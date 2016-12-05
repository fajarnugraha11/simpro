<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_access extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_menu_access');
        if(!isLogin()) redirect('login', 'refresh');
        $this->access = $this->general_model->getLevelAccess($this->uri->uri_string(), $this->session->userdata('level'));

    }



    public function index()
    {
        $data = array(
            'content' => '_view/v_menu_access'
        ,'title' => 'Menu Access'
        ,'data' => array(
            'url' => site_url('menu_access/load_ajax_menu_access'),
            'access' => $this->access['action'],
            'url_by_id' => site_url('menu_access/get_data_access'),
             'parent_menu' => array(
                'data' => $this->general_model->getFirstRow('backend_menu', 'id'),
                'ajax_parent_menu' => site_url('menu_access/load_ajax_parent_menu')),
             'user_group' => array(
                'data' => $this->general_model->getFirstRow('usergroup', 'id'),
                 'ajax_group_menu' => site_url('menu_access/load_ajax_user_group')),
            'sub_menu' => array(
                'ajax_sub_menu' => site_url('menu_access/load_ajax_sub_menu')),
            'get_first_row_select2' => site_url('menu_access/first_row_select2')
            )
        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');
            $parent = $this->input->post('parent');
            $submenu = $this->input->post('submenu');

            $insert['usergroup_id'] = $this->input->post('group');
            $insert['view'] = 0;
            $insert['add'] = 0;
            $insert['edit'] = 0;
            $insert['delete'] = 0;

            if($parent != 0 && $submenu == 0){
                $backend_id = $parent;
            } else if ($parent != 0 && $submenu != 0){
                $backend_id = $submenu;
            }else if($parent == 0 && $submenu != 0) {
                $backend_id = $submenu;
            }else{
                $backend_id = "XXXX";
            }

            $insert['backend_menu_id'] = $backend_id;

            if($this->input->post('view') == 'on')$insert['view'] = 1;
            if($this->input->post('add') == 'on')$insert['add'] = 1;
            if($this->input->post('edit') == 'on')$insert['edit'] = 1;
            if($this->input->post('delete') == 'on')$insert['delete'] = 1;

            if($type == 'add'){
                $insert['created'] = time();
                $insert['created_by'] = $this->session->userdata('user_id');
                $query = $this->general_model->insertTable('backend_menu_access',$insert);
                if ($query){
                      $get_data_access = $this->m_menu_access->get_list_menu_access($backend_id);
                      if($get_data_access != false){
                          $row = $get_data_access->row();
                          $return = array(
                              $query
                            , $row->usergroup_name
                            , $row->parent_menu
                            , $row->menu_name
                            , $row->view
                            , $row->add
                            , $row->edit
                            , $row->delete
                            , $this->access['action']
                          );
                      }
                    $json_status = 1;
                    $json_text = $parent."dan".$submenu;
                }else{
                    $json_status = 0;
                    $json_text = $parent."dan".$submenu;
                }
            }
            else if($type == 'edit'){
                $id = $this->input->post('id');
                $insert['modified'] = time();
                $insert['modified_by'] = $this->session->userdata('user_id');
                $id_array = array('id' => $id);
                $query = $this->general_model->updateById('backend_menu_access', $id_array, $insert);
                if($query){
                    $get_data_access = $this->m_menu_access->get_list_menu_access($backend_id);
                    if($get_data_access != false){
                        $row = $get_data_access->row();
                        $return = array(
                            $id
                        , $row->usergroup_name
                        , $row->parent_menu
                        , $row->menu_name
                        , $row->view
                        , $row->add
                        , $row->edit
                        , $row->delete
                        , $this->access['action']
                        );
                    }
                    $json_status = 1;
                }else{
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $id = $this->input->post('menu_id');
                $menu_id = array(
                    'id' => $id
                );

                $return = $this->general_model->deleteByWhere('backend_menu_access', $menu_id);
                if($return != false){
                    $json_status = 1;
                    $json_text = 'Success remove menu.';
                }else{
                    $json_status = 0;
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

    public function load_ajax_menu_access(){
        $access = $this->input->get('a');
        $query = $this->m_menu_access->get_list_menu_access('');
        if($query != false) {
            $iTotalRecords = $this->db->count_all('backend_menu_access');
            foreach($query->result() as $aRow)
            {
                $row = array();
                $row[] = $aRow->id;
                $row[] = $aRow->usergroup_name;
                $row[] = $aRow->parent_menu;
                $row[] = $aRow->menu_name;
                $row[] = $aRow->view;
                $row[] = $aRow->add;
                $row[] = $aRow->edit;
                $row[] = $aRow->delete;
                $row[] = $access;

                $json['status'] = 1;
                $json['sEcho'] = 0;
                $json['iTotalRecords'] = $iTotalRecords;
                $json['iTotalDisplayRecords'] = $iTotalRecords;
                $json['aaData'][] = $row;
            }
        }else{
            $json['status'] = 0;
            $json['aaData'] = '';
        }
        echo json_encode($json);
    }


   public function load_ajax_user_group(){

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

       $usergroup_id = (isset($_GET['id'])) ? $_GET['id'] : '';
       $data = $this->general_model->getListLikeLimit('usergroup', 'name', $search, (($usergroup_id == '' || $usergroup_id == NULL) ? '' : array('id')), (($usergroup_id == '' || $usergroup_id == NULL) ? '' : array($usergroup_id)), 'id', $from, $limit);

       foreach($data->result() as $row)
       {
           $rows['id'] = $row->id;
           $rows['text'] = $row->name;
           $json['results'][] = $rows;
       }

       $json['count_data'] = $data->num_rows();
       $json['count_all'] = $this->general_model->getCountTableLike('usergroup', 'id', $search, (($usergroup_id == '' || $usergroup_id == NULL) ? '' : array('id')), (($usergroup_id == '' || $usergroup_id == NULL) ? '' : array($usergroup_id)));

       echo json_encode($json);
   }


   public function load_ajax_parent_menu(){
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

   public function load_ajax_sub_menu(){

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


       if($_GET['id'] != "0"){
           $parent = array('parent');
           $parent_id = array($_GET['id']);
       }else{
           $parent = '';
           $parent_id = '';
       }

       $data = $this->general_model->getListLikeLimit('backend_menu','name', $search, $parent , $parent_id, 'id', $from, $limit);

       foreach($data->result() as $row)
       {
           $rows['id'] = $row->id;
           $rows['text'] = $row->name;
           $json['results'][] = $rows;
       }

       $json['count_data'] = $data->num_rows();
       $json['id'] = $_GET['id'];
       $json['parent'] = $parent;
       $json['parent_id'] = $parent_id;
       $json['count_all'] = $this->general_model->getCountTableLike('backend_menu', 'name', $search, $parent, $parent_id);

       echo json_encode($json);
   }

    public function first_row_select2()
    {
        $json = array();
        if(isset($_GET['columns']) && isset($_GET['table']) && isset($_GET['where']) && isset($_GET['id']) && isset($_GET['order']))
        {
            $cols = explode(",", $_GET['columns']);
            $data = $this->general_model->getFirstWhere($_GET['columns'], $_GET['table'], $_GET['where'], $_GET['id'], $_GET['order']);
            foreach($data->result() as $row)
            {
                $json['id'] = $row->$cols[0];
                $json['text'] = $row->$cols[1];
            }
        }
        echo json_encode($json);
    }

    public function get_data_access(){
        $id = $this->input->post('id');
        if($id != ''){
            $data = $this->m_menu_access->get_data_access($id);
            if($data){
                $row = $data->row();
                $json['data'] = $row;
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
