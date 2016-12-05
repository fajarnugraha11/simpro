<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_menu');
        if(!isLogin()) redirect('login', 'refresh');
        $this->access = $this->general_model->getLevelAccess($this->uri->uri_string(), $this->session->userdata('level'));

    }

    public function index()
    {
        $data = array(
            'content' => '_view/v_menu'
            ,'title' => 'Menu'
            ,'data' => array(
                 'id' => 'id'
                , 'table' => 'backend_menu b'
                , 'join' => 'backend_menu a'
                , 'on_join_id' => 'a.id = b.parent'
                , 'column' =>  array(
                    "b.`id`"
                    , "a.`name` AS `parent_menu`"
                    , "b.`name`"
                    , "b.`url`"
                    , "b.`sort`")
                 ,'access' => $this->access['action']
                , 'url_by_id' => site_url('menu/get_data_menu')
                , 'url' => site_url('menu/load_ajax')
                , 'menu' => array(
                    'data' => $this->general_model->getFirstRow('backend_menu', 'id')
                    ,'url_ajax_menu' => site_url('menu/load_parent_menu'))
            )

        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');

            $insert['parent'] = $this->input->post('parent');
            $insert['name'] = $this->input->post('name');
            $insert['url'] = $this->input->post('url');
            $insert['sort'] = $this->input->post('sort');

            if($type == 'add'){
                $insert['created'] = time();
                $insert['created_by'] = $this->session->userdata('user_id');
                $query = $this->general_model->insertTable('backend_menu',$insert);
                if ($query){
                    $get_parent_menu = $this->general_model->getfieldById('name as parent','backend_menu',array('id' => $this->input->post('parent')));
                    if($get_parent_menu !== false){
                        $parent = $get_parent_menu->parent;
                    }else{
                        $parent = '';
                    }

                    $return = array(
                        $query
                        , $parent
                        , $insert['name']
                        , $insert['url']
                        , $insert['sort']
                        , $this->access['action']

                    );
                    $json_status = 1;
                }else{
                    $json_status = 0;
                }
            }
            else if($type == 'edit'){
                $id = $this->input->post('id');
                $insert['modified'] = time();
                $insert['modified_by'] = $this->session->userdata('user_id');
                $id_array = array('id' => $id);
                $query = $this->general_model->updateById('backend_menu', $id_array, $insert);
                if ($query){
                    $get_parent_menu = $this->general_model->getfieldById('name as parent','backend_menu',array('id' => $this->input->post('parent')));
                    if($get_parent_menu !== false){
                        $parent = $get_parent_menu->parent;
                    }else{
                        $parent = '';
                    }

                    $return = array(
                      $id
                    , $parent
                    , $insert['name']
                    , $insert['url']
                    , $insert['sort']
                    , $this->access['action']

                    );
                    $json_status = 1;
                }else{
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $id = $this->input->post('menu_id');
                $parent_id = array(
                    'parent' => $id
                );
                $menu_id = array(
                  'id' => $id
                );
                $backend_id = array(
                    'backend_menu_id' => $id
                );

                $check_relation = $this->general_model->getByWhere("backend_menu", $parent_id);
                $check_relation_access = $this->general_model->getByWhere("backend_menu_access", $backend_id);
                if($check_relation->num_rows() > 0 || $check_relation_access->num_rows() > 0)
                {
                    $json_status = 0;
                    $json_text = 'Sorry, cannot remove Menu. <br/> It\'s still have Relation with another menu and Access Menu.';
                }
                else {
                    $return = $this->general_model->deleteByWhere('backend_menu', $menu_id);
                    $json_status = 1;
                    $json_text = 'Success remove menu.';
                }
            }

            $json = array(
                'status' => $json_status,
                'message' => $json_text,
                'data' => $return,
                'type' => $type
            );

            echo json_encode($json);

        }else {
            $this->template->load('template/tpl', $data['content'], $data);
        }
    }

    public function load_ajax()
    {
        $order = $this->input->get('d');
        $table = $this->input->get('t');
        $join = $this->input->get('j');
        $on_join = $this->input->get('oj');
        $column = $this->input->get('c');
        $access = $this->input->get('a');

        $query = $this->m_menu->get_list_menu($column, $table,$join,$on_join, $order);
        if($query) {
            $iTotalRecords = $this->db->count_all('backend_menu');
            foreach($query->result() as $aRow)
            {
                $row = array();
                $row[] = $aRow->id;
                $row[] = $aRow->parent_menu;
                $row[] = $aRow->name;
                $row[] = $aRow->url;
                $row[] = $aRow->sort;
                $row[] = $access;

                $json['status'] = 1;
                $json['sEcho'] = 0;
                $json['iTotalRecords'] = $iTotalRecords;
                $json['iTotalDisplayRecords'] = $iTotalRecords;
                $json['aaData'][] = $row;
            }
        }else{
            $json['status'] = 0;
            $json['aaData'] = array() ;
            $json['iTotalRecords'] = 0;
            $json['iTotalDisplayRecords'] = 0;
        }
        echo json_encode($json);
    }

    public function load_parent_menu(){

        $json = array('results' => array());

        $page = 1;
        if(isset($_GET['page'])) $page = $_GET['page'];

        $search = "";
        if(isset($_GET['q'])) $search = $_GET['q'];

        $limit = "";
        $from = "";
        if(isset($_GET['page_limit'])) $limit = $_GET['page_limit'];

        if($limit != ""){
            $from = ceil($page * $limit) - $limit;
        }
        $data = $this->general_model->getListLikeLimit('backend_menu', 'name', $search, '', '', 'id', $from, $limit);
        $rows['id'] = 0;
        $rows['text'] = '-';
        foreach($data->result() as $row)
        {
            $rows['id'] = $row->id;
            $rows['text'] = $row->name;
            $json['results'][] = $rows;
        }

        $json['count_data'] = $data->num_rows();
        $json['count_all'] = $this->general_model->getCountTableLike('backend_menu', 'name', $search, '', '');

        echo json_encode($json);
    }


    public function get_data_menu(){
        $id = $this->input->post('id');
        if($id != ''){
            $array_id =array('id' => $id );
            $data = $this->general_model->getByWhere('backend_menu',$array_id);
            if($data){
                $row = $data->row();
                if($row->parent != 0){
                    $get = $this->general_model->getByWhere('backend_menu',array('id' => $row->parent));
                    $parent_menu = $get->row();
                }else{
                    $parent_menu = '';
                }

                $json['data'] = $row;
                $json['parent'] = $parent_menu;
                $json['status'] = 1;
            }else{
                $json['status'] = 0;
                $json['message'] = 'data not found';
            }
        }else{
            $json['status'] = 0;
            $json['message'] = 'id is empty';
        }

        echo json_encode($json);
    }

}
