<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_member');
        if(!isLogin()) redirect('login', 'refresh');
        $this->access = $this->general_model->getLevelAccess($this->uri->uri_string(), $this->session->userdata('level'));
    }

    public function index()
    {
        $data = array(
            'content' => '_view/v_member'
        ,'title' => 'Member'
        ,'data' => array(
                 'url' => site_url('member/load_ajax_member')
                , 'url_by_id' => site_url('member/get_data_member')
                ,'access' => $this->access['action']
                ,'user_group' => array(
                    'data' => $this->general_model->getFirstRow('usergroup', 'id'),
                    'url_usergroup' => site_url('member/load_ajax_user_group'))
                ,'city' => array(
                    'url_city' => site_url('member/load_ajax_city'))
            )
        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');
            $gender = 'None';
            ($this->input->post('gender') != '') ? $gender = $this->input->post('gender') : $gender;
            $insert_h['usergroup_id'] = $this->input->post('usergroup');
            $insert_h['email'] = $this->input->post('email');
            

            $insert_d['city_id'] = $this->input->post('city');
            $insert_d['photo'] = '';
            $insert_d['name'] = $this->input->post('name');
            $insert_d['sex'] = $gender;
            $insert_d['telephone'] = $this->input->post('telephone');
            $insert_d['handphone'] = $this->input->post('handphone');
            $insert_d['address'] = $this->input->post('address');
            $insert_d['zipcode'] = $this->input->post('zipcode');
            $dob = $this->input->post('month')."/".$this->input->post('day')."/".$this->input->post('year');
            $insert_d['dob'] = strtotime($dob, time());

            if($type == 'add'){
				$insert_h['password'] = md5($this->input->post('password'));
                $insert_h['created'] = time();
                $insert_h['created_by'] = $this->session->userdata('user_id');
                $query_h = $this->general_model->insertTable('member',$insert_h);
                if ($query_h){
                    $insert_d['member_id'] = $query_h;
                    $insert_d['created'] = time();
                    $insert_d['created_by'] = $this->session->userdata('user_id');
                    $query_d = $this->general_model->insertTable('member_detail',$insert_d);
                    if($query_d) {
                        $get_usergroup = $this->general_model->getfieldById('name','usergroup',array('id'=> $insert_h['usergroup_id']));
                        $return = array(
                            $query_h
                        , ($get_usergroup != false) ? $get_usergroup->name : $insert_h['usergroup_id']
                        , $insert_h['email']
                        , $insert_d['name']
                        , $insert_d['created']
                        , $this->access['action']
                        );
                        $json_status = 1;
                    }
                }else{
                    $json_status = 0;
                }
            }
            else if($type == 'edit'){
				if ($this->input->post('password')!='' or $this->input->post('password')!=NULL) {
				$insert_h['password'] = md5($this->input->post('password'));
				}
				
                $id = $this->input->post('id');
                $insert_h['modified'] = time();
                $insert_h['modified_by'] = $this->session->userdata('user_id');
                $id_h = array('id' => $id);
                $query_h = $this->general_model->updateById('member', $id_h, $insert_h);
                if($query_h){
                    $id_d = array('member_id' => $id);
                    $insert_d['modified'] = time();
                    $insert_d['modified_by'] = $this->session->userdata('user_id');
                    $query_d = $this->general_model->updateById('member_detail', $id_d, $insert_d);
                    if($query_d){
                        $get_usergroup = $this->general_model->getfieldById('name','usergroup',array('id'=> $insert_h['usergroup_id']));
                        $return = array(
                            $id
                        , ($get_usergroup != false) ? $get_usergroup->name : $insert_h['usergroup_id']
                        , $insert_h['email']
                        , $insert_d['name']
                        , $insert_d['modified']
                        , $this->access['action']
                        );
                        $json_status = 1;
                    }
                }else{
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $post_id = $this->input->post('id');
                $id = array(
                    'id' => $post_id
                );
                $member_id = array(
                    'member_id' => $post_id
                );


                $delete_d = $this->general_model->deleteByWhere('member_detail', $member_id);
                if($delete_d) {
                    $return = $this->general_model->deleteByWhere('member', $id);
                    if ($return != false) {
                        $json_status = 1;
                        $json_text = 'Success remove .';
                    } else {
                        $json_status = 0;
                        $json_text = 'Failed remove .';
                    }
                }else{
                    $json_status = 0;
                    $json_text = 'Failed remove .';
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

    public function load_ajax_member(){
        $access = $this->input->get('a');
        $query = $this->m_member->get_list_member('');
        if($query != false) {
            $iTotalRecords = $this->db->count_all('member');
            foreach($query->result() as $aRow)
            {
                $row = array();
                $row[] = $aRow->id;
                $row[] = $aRow->usergroup_name;
                $row[] = $aRow->email;
                $row[] = $aRow->name;
                $row[] = $aRow->created;
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

    public function get_data_member()
    {
        $id = $this->input->post('id');
        if ($id != '') {
            $data = $this->m_member->get_data_member($id);
            if ($data) {
                $row = $data->row();
                $json['data'] = $row;
                $json['status'] = 1;
            } else {
                $json['status'] = 0;
                $json['message'] = 'data not found';
            }
        } else {
            $json['status'] = 0;
            $json['message'] = 'id is empty';
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

    public function load_ajax_city()
    {
        $json = array('cities' => array());

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


        $data = $this->general_model->getListLikeLimit('city', 'name', $search, array('id'), '' , 'name', $from, $limit);

        foreach($data->result() as $row)
        {
            $rows['id'] = $row->id;
            $rows['text'] = $row->name;

            $json['cities'][] = $rows;
        }

        $json['count_data'] = $data->num_rows();
        $json['count_all'] = $this->general_model->getCountTableLike('city', 'name', $search, array('id'),  '');

        echo json_encode($json);
    }


    public function usergroup()
    {

        $data = array(
            'content' => '_view/v_usergroup'
        ,'title' => 'Usergroup'
        , 'access' => $this->access['action']
        ,'data' => array(
                'id' => 'id'
            , 'table' => 'usergroup'
            , 'column' =>  array(
                    "`id`"
                , "`name`"
                , "`created`"
                , "`modified`" )
            ,'access' => $this->access['action']
            , 'url_by_id' => site_url('member/get_data_usergroup')
            , 'url' => site_url('member/load_ajax_usergroup'))
        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');

            $insert['name'] = $this->input->post('name');

            if($type == 'add'){
                $insert['created'] = time();
                $insert['created_by'] = $this->session->userdata('user_id');
                $query = $this->general_model->insertTable('usergroup',$insert);
                if ($query){
                    $return = array(
                        $query
                    , $insert['name']
                    , $insert['created']
                    , time()
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
                $query = $this->general_model->updateById('usergroup', $id_array, $insert);
                if($query){
                    $return = array(
                        $id
                    , $insert['name']
                    , time()
                    , $insert['modified']
                    , $this->access['action']
                    );
                    $json_status = 1;
                }else{
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $id = $this->input->post('id');
                $usergroup_id = array(
                    'id' => $id
                );

                $return = $this->general_model->deleteByWhere('usergroup', $usergroup_id);
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

    public function member_credit_card()
    {
        $data = array(
            'content' => '_view/v_member_cc'
            ,'title' => 'Member Credit Card'
            ,'data' => array(
                'id' => 'id'
            , 'table' => 'member_cc'
            , 'access' => $this->access['action']
            , 'column' =>  array(
                    "id"
                , "member_id"
                , "type"
                , "name"
                , "number"
                , "expired_month"
                , "expired_year"
                , "'{$this->access['action']}' as action" )
            , 'url_by_id' => site_url('member/get_data_member_cc')
            , 'url' => site_url('member/load_ajax_member_cc')
            , 'member' => array(
                'data' => $this->general_model->getFirstRow('member_detail', 'id')
                ,'ajax_member_id' => site_url('member/ajax_member_id'))
            )
        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');

            $insert['member_id'] = $this->input->post('member_id');
            $insert['type'] = $this->input->post('cc_type');
            $insert['name'] = $this->input->post('name');
            $insert['number'] = $this->input->post('number');
            $insert['expired_month'] = $this->input->post('expired_month');
            $insert['expired_year'] = $this->input->post('expired_year');
            if($type == 'add'){
                $insert['created'] = time();
                $insert['created_by'] = $this->session->userdata('user_id');
                $query = $this->general_model->insertTable('member_cc',$insert);
                if ($query){
                    $get_list_cc = $this->m_member->get_list_member_cc('');
                    $row = $get_list_cc->row();

                    $return = array(
                        $query
                    , $row->member_name
                    , $this->general_model->getCardTypeValue($insert['type'])
                    , $insert['name']
                    , $insert['number']
                    , $this->general_model->getMonthValue($insert['expired_month'])
                    , $insert['expired_year']
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
                $query = $this->general_model->updateById('member_cc', $id_array, $insert);
                if($query){
                    $get_list_cc = $this->m_member->get_list_member_cc('');
                    $row = $get_list_cc->row();

                    $return = array(
                        $id
                    , $row->member_name
                    , $this->general_model->getCardTypeValue($insert['type'])
                    , $insert['name']
                    , $insert['number']
                    , $this->general_model->getMonthValue($insert['expired_month'])
                    , $insert['expired_year']
                    , $this->access['action']
                    );
                    $json_status = 1;
                }else{
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $id = $this->input->post('member_cc_id');
                $member_cc_id = array(
                    'id' => $id
                );

                $return = $this->general_model->deleteByWhere('member_cc', $member_cc_id);
                if($return != false){
                    $json_status = 1;
                    $json_text = 'Success remove member credit card.';
                }else{
                    $json_status = 0;
                    $json_text = 'Failed remove member credit card.';
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

    public function member_preference()
    {
        $data = array(
            'content' => '_view/v_member_preference'
            ,'title' => 'Member Preference'
            ,'data' => array(
                'id' => 'id'
                , 'table' => 'member_preference'
                , 'access' => $this->access['action']
                , 'column' =>  array(
                    "id"
                    , "member_id"
                    , "type"
                    , "status"
                    , "'{$this->access['action']}' as action" )
                , 'url_by_id' => site_url('member/get_data_member_preference')
                , 'url' => site_url('member/load_ajax_member_preference')
                , 'member' => array(
                    'data' => $this->general_model->getFirstRow('member_detail', 'id')
                    ,'ajax_member_id' => site_url('member/ajax_member_id'))
            )
        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');

            $insert['member_id'] = $this->input->post('member_id');
            $insert['type'] = $this->input->post('preference_type');
            $insert['status'] = ( $this->input->post('preference_status') == "" || $this->input->post('preference_status') == 0 ? 0 : 1 );

            if($type == 'add'){
                $insert['created'] = time();
                $insert['created_by'] = $this->session->userdata('user_id');
                $query = $this->general_model->insertTable('member_preference',$insert);
                $status = ($insert['status'] == 0 ? "No" : "Yes");
                if ($query){
                    $get_list_preference = $this->m_member->get_list_member_preference('');
                    $row = $get_list_preference->row();

                    $return = array(
                        $query
                    , $row->member_name
                    , $this->general_model->getPreferenceTypeValue($insert['type'])
                    , $status
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
                $query = $this->general_model->updateById('member_preference', $id_array, $insert);
                $status = ($insert['status'] == 0 ? "No" : "Yes");

                if($query){
                    $get_list_preference = $this->m_member->get_list_member_preference($id);
                    $row = $get_list_preference->row();

                    $return = array(
                        $id
                    , $row->member_name
                    , $this->general_model->getPreferenceTypeValue($insert['type'])
                    , $status
                    , $this->access['action']
                    );
                    $json_status = 1;
                }else{
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $id = $this->input->post('member_preference_id');
                $member_preference_id = array(
                    'id' => $id
                );

                $return = $this->general_model->deleteByWhere('member_preference', $member_preference_id);
                if($return != false){
                    $json_status = 1;
                    $json_text = 'Success remove member preference.';
                }else{
                    $json_status = 0;
                    $json_text = 'Failed remove member preference.';
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

    public function load_ajax_usergroup()
    {
        $order = $this->input->get('d');
        $table = $this->input->get('t');
        $field = $this->input->get('c');
        $access = $this->input->get('a');
        $query = $this->general_model->getListbyField($table, $field, $order);
        if($query) {
            $iTotalRecords = $this->db->count_all('usergroup');
            foreach($query->result() as $aRow)
            {
                $row = array();
                $row[] = $aRow->id;
                $row[] = $aRow->name;
                $row[] = $aRow->created;
                $row[] = $aRow->modified;
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

    public function get_data_usergroup(){
        $id = $this->input->post('id');
        if($id != ''){
            $array_id =array('id' => $id );
            $data = $this->general_model->getByWhere('usergroup',$array_id);
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

    public function get_data_member_cc(){
        $id = $this->input->post('id');
        if($id != ''){
            $data = $this->m_member->get_list_member_cc($id);
            if($data){
                $row = $data->row();
                $aRow = array();
                $aRow['id'] = $row->id;
                $aRow['member_id'] = $row->member_id;
                $aRow['member_name'] = $row->member_name;
                $aRow['type'] = $row->type;
                $aRow['type_val'] = $this->general_model->getCardTypeValue($row->type);
                $aRow['name'] = $row->name;
                $aRow['number'] = $row->number;
                $aRow['expired_month'] = $row->expired_month;
                $aRow['expired_month_val'] = $this->general_model->getMonthValue($row->expired_month);
                $aRow['expired_year'] = $row->expired_year;

                $json['data'] = $aRow;
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

    public function load_ajax_member_cc()
    {
        $access = $this->input->get('a');

        $query = $this->m_member->get_list_member_cc('');
        if($query) {
            $iTotalRecords = $this->db->count_all('member_cc');
            foreach($query->result() as $aRow)
            {
                $row = array();
                $row[] = $aRow->id;
                $row[] = $aRow->member_name;
                $row[] = $this->general_model->getCardTypeValue($aRow->type);
                $row[] = $aRow->name;
                $row[] = $aRow->number;
                $row[] = $this->general_model->getMonthValue($aRow->expired_month);
                $row[] = $aRow->expired_year;
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

    public function load_ajax_member_preference()
    {
        $access = $this->input->get('a');
        
        $query = $this->m_member->get_list_member_preference('');
        if($query) {
            $iTotalRecords = $this->db->count_all('member_preference');
            foreach($query->result() as $aRow)
            {
                $row = array();
                $status = ($aRow->status == 0 || $aRow->status == "" ? "No" : "Yes");
                $row[] = $aRow->id;
                $row[] = $aRow->member_name;
                $row[] = $this->general_model->getPreferenceTypeValue($aRow->type);
                $row[] = $status;
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

    public function get_data_member_preference(){
        $id = $this->input->post('id');
        if($id != ''){
            $data = $this->m_member->get_list_member_preference($id);
            if($data){
                $row = $data->row();
                $status = ($row->status == 0 ? "No" : "Yes");
                $aRow = array();
                $aRow['id'] = $row->id;
                $aRow['member_id'] = $row->member_id;
                $aRow['member_name'] = $row->member_name;
                $aRow['type'] = $row->type;
                $aRow['type_val'] = $this->general_model->getPreferenceTypeValue($row->type);
                $aRow['preference_status'] = $status;
                $aRow['status'] = $row->status;

                $json['data'] = $aRow;
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

    public function ajax_member_id(){

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

        $member_id = (isset($_GET['id'])) ? $_GET['id'] : '';
        $data = $this->general_model->getListLikeLimit('member_detail', 'name', $search, (($member_id == '' || $member_id == NULL) ? '' : array('member_id')), (($member_id == '' || $member_id == NULL) ? '' : array($member_id)), 'member_id', $from, $limit);

        foreach($data->result() as $row)
        {
            $rows['id'] = $row->member_id;
            $rows['text'] = $row->name;
            $json['results'][] = $rows;
        }

        $json['count_data'] = $data->num_rows();
        $json['count_all'] = $this->general_model->getCountTableLike('member_detail', 'member_id', $search, (($member_id == '' || $member_id == NULL) ? '' : array('member_id')), (($member_id == '' || $member_id == NULL) ? '' : array($member_id)));

        echo json_encode($json);
    }

    public function ajax_member_type(){

        $json = array('results' => array());

        $member_id = (isset($_GET['id'])) ? $_GET['id'] : '';
        $data = $this->general_model->getListLikeLimit('member_detail', 'name', $search, (($member_id == '' || $member_id == NULL) ? '' : array('member_id')), (($member_id == '' || $member_id == NULL) ? '' : array($member_id)), 'member_id', $from, $limit);

        foreach($data->result() as $row)
        {
            $rows['id'] = $row->member_id;
            $rows['text'] = $row->name;
            $json['results'][] = $rows;
        }

        $json['count_data'] = $data->num_rows();
        $json['count_all'] = $this->general_model->getCountTableLike('member_detail', 'member_id', $search, (($member_id == '' || $member_id == NULL) ? '' : array('member_id')), (($member_id == '' || $member_id == NULL) ? '' : array($member_id)));

        echo json_encode($json);
    }

}
