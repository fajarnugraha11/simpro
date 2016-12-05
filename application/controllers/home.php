<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'content' => 'f_view/index',
            'title' => 'Login'
        );
        $this->load->view($data['content']);
    }

    public function contact(){

        $insert['name'] = $this->input->post('name');
        $insert['email'] = $this->input->post('email');
        $insert['message'] = $this->input->post('message');
        $insert['created'] = time();
        if($_POST){
          $this->general_model->insertTable('contact_us',$insert);
        }
        redirect('home');

    }



}
