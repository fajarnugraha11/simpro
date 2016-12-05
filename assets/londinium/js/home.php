<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
		require_once(BASEPATH."recaptchalib.php");
		use_ssl();
		
    }

    public function index()
    {
			$query = $this->general_model->getListbyField("websites", "*", "website_id");
			// print_r($query->result()[0]->logo_white);  die;
			 
			$data = array(
            'content' => 'f_view/index',
            'title' => 'Login', 
			'data' => $query,
			'error' => null
			// 'student' = $getStudent
			);
        $this->load->view($data['content'], $data);
    }

    public function contact(){
		$query = $this->general_model->getListbyField("websites", "*", "website_id");
		$privatekey = "6LeQkiETAAAAAEzDFNcOMmkCI_T2iqcHKfmtTrY-";
		$resp = null;
		# the error code from reCAPTCHA, if any
		$error = null;
		
		
		$recaptcha_response_field = $this->input->post('recaptcha_response_field');
		$recaptcha_challenge_field = $this->input->post('recaptcha_challenge_field');
        $insert['name'] = $this->input->post('name');
        $insert['email'] = $this->input->post('email');
        $insert['message'] = $this->input->post('message');
        $insert['created'] = time();

		
        if($_POST){
			$resp = recaptcha_check_answer ($privatekey,
												$_SERVER["REMOTE_ADDR"],
												$recaptcha_challenge_field,
												$recaptcha_response_field);
							
			if ($resp->is_valid) {
				$error = null;
			} else {
				# set the error code so that we can display it
				$error = $resp->error;
			}
			
			
			$data = array(
				'nama' => $insert['name'],
				'tanggal' => date("d-M-Y"),
				'email' => $insert['email'],
				'pesan' => $insert['message'],
				'content' => 'f_view/index',
				'title' => 'TOMONNO', 
				'data' => $query,
				'error' => $error
			);
			$emailData = array(							
				'from' => 'noreply@tomonno.com',
				'name' => $insert['email'],
				'to' => array('contact@tomonno.com'),
				'cc' => array('fnugraha11@gmail.com'),
				'bcc' => "",
				'subject' => "Contact Pesan dari ".$insert['name'],
				'template' => $this->load->view('v_contactus_frontend', $data, true)							
			);		
			
			if ($resp->is_valid) {
				$this->sendContact($emailData);
			
				$query = $this->general_model->insertTable('contact_us',$insert);
				if($query){
					redirect('home');
					// $this->load->view($data['content'], $data);
				}
			} else {
				# set the error code so that we can display it
				$error = $resp->error;
				$this->load->view($data['content'], $data);
			}
			
		}
		
		
    }
	
	public function sendContact($emailData = array()){
		$this->load->library("CustomEmail");
		// $data = array(
				// 'nama' => "fasdfs",
				// 'tanggal' => date("d-M-Y"),
				// 'email' => "oenyil91@gmail.com",
				// 'pesan' => "tedsfsdfsdfs"			
			// );
			// $emailData = array(							
				// 'from' => "noreply@tomonno.com",
				// 'name' => "oenyil91@gmail.com",
				// 'to' => array('pricilliaprimayanti@gmail.com'),
				// 'cc' => "",
				// 'bcc' => "",
				// 'subject' => "Contact Pesan dari fdsf",
				// 'template' => $this->load->view('v_contactus_frontend', $data, true)							
			// );		
						
		
		return $this->customemail->send_email_info(
					  $emailData['from']
					, $emailData['name']
					, $emailData['to']
					, $emailData['cc']
					, $emailData['bcc']
					, $emailData['subject']
					, $emailData
					, $emailData['template']
				);		
	}



}
