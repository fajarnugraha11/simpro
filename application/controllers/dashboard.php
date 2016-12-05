<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_dashboard');
        if(!isLogin()) redirect('login', 'refresh');
        $this->access = $this->general_model->getLevelAccess($this->uri->uri_string(), $this->session->userdata('level'));

    }

    public function index()
    {
		$d=NULL;
		$result=array();
		$result2=array();
		
		date_default_timezone_set('Asia/Jakarta');
		$timenow=time();
		$day=date('d',$timenow);
		$month=date('M',$timenow);
		$year=date('Y',$timenow);
		// $getSumAbsensi =  $this->db->query("SELECT status_project, COUNT(id) AS jumlah FROM projects GROUP BY status_project");
		// print_r($getSumAbsensi->result());
        $data = array(
            'content' => '_view/v_dashboard',
            'title' => 'Dashboard',
            'd' => $d,
            // 'sumAbsensi' => ($getSumAbsensi->num_rows() > 0 ? $getSumAbsensi->result_array() : "-"),
            'day' => $day,
            'month' => $month,
            'year' => $year,
			'data' => array(
                'url' => site_url('transaction/load_ajax_quotation')
			)
        );

        $this->template->load('template/tpl', $data['content'], $data);
    }

    // public function get_event(){
        // $get = $this->general_model->getList('evenement','id');
        // echo json_encode($get->result_array());
    // }

}
