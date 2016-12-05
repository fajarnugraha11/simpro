<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_simpro_registration');
    }

    public function index()
    {
		$id = base64_decode($this->input->get("id"));
		$query = $getMaxId = $this->general_model->manualQuery('UPDATE simpro_registration SET status = "verified" where reg_no = "'.$id.'"');
		
        $data = array(
            'content' => '_view/v_notifikasi',
            'title' => 'Notifikasi Sukses'
        );
		if($query){
			$this->load->view('v_notifikasi', $data);			
		}
    }
	
}