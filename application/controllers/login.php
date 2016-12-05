<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_login');
    }

    public function index()
    {
        $data = array(
            'content' => '_view/v_login',
            'title' => 'Login'
        );
        $this->template->load('template_login/tpl_login', $data['content'], $data);
    }

    public function dologin()
    {
        $email = $this->input->post('username');
        $password = md5($this->input->post('password'));
        $return = $this->m_login->checkLogin($email, $password);
		// print_r($return); die;
        if($return != false ) {
            $json['status'] = 1;
            $json['message'] = $return->name;
            $data = array(
                'is_login' => 1
            , 'user_id' => $return->member_id
            , 'level' => $return->usergroup_id
            , 'email' => $return->email
            , 'name' => $return->name
			, 'store_id' => $return->store_id
            );
            $this->session->set_userdata($data);

        }else {
            $json['status'] = 0;
            $json['message'] = $email;
        }

        echo json_encode($json);
    }

    public function dologout()
    {
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

}
