<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simpro_registration extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('m_simpro_registration');
		$this->load->library("CustomEmail");
        $this->load->library('pdf');
        if (!isLogin()) redirect('login', 'refresh');
        $this->access = $this->general_model->getLevelAccess($this->uri->uri_string(), $this->session->userdata('level'));
    }

    public function index()
    {
        $data = array(
            'content' => '_view/module/v_simpro_registration'
			,'title' => 'List Simpro Registration'
			,'data' => array(
                'url' => site_url('simpro_registration/load_ajax_simpro')
				, 'url_by_id' => site_url('simpro_registration/get_data_simpro')
				, 'url_next_date' => site_url('simpro_registration/get_next_date')
				, 'url_email' => site_url('simpro_registration/sendEmailTicket')
				, 'url_get_store' => site_url('simpro_registration/get_store')
				, 'getProductDetail' => site_url('simpro_registration/get_data_product')
				,'access' => $this->access['action']
				, 'product' => array(
                    'data' => $this->general_model->getFirstRow('product', 'id'),
                    'list_product' => site_url('simpro_registration/load_list_product'),
                    'list_device' => site_url('simpro_registration/load_list_device'))
					
            )
        );

        if($_POST){

            $json_status = 0;
            $json_text = '';
            $return = array();

            $type = $this->input->post('type');
			
			$document = json_encode(
							array(
								'bukti_pembelian' => $this->input->post('bukti_pembelian'), 
								'kartu_garansi' => $this->input->post('kartu_garansi'), 
								'kartu_identitas' => $this->input->post('kartu_identitas'), 
								'voucher' => $this->input->post('voucher')
							)
						);
			$check_point = json_encode(
							array(
								'unit' => $this->input->post('unit'), 
								'cover' => $this->input->post('cover'), 
								'battery' => $this->input->post('battery'), 
								'other' => $this->input->post('other')
							)
						);			
			
			$varReplace = array(",", ".00");
			$paymentAmount = str_replace($varReplace, "", $this->input->post('payment_amount'));
			$sumInsured = str_replace($varReplace, "", $this->input->post('sum_insured'));
			
			$product_period_start = new DateTime($this->input->post('product_period_start'));
			$product_period_end = new DateTime($this->input->post('product_period_end'));
			$purchase_date = new DateTime($this->input->post('purchase_date'));
			$date_in = new DateTime($this->input->post('date_in'));
			
            $insert = 	array(
							'store_id' => $this->session->userdata('store_id'),
							'has_payment' => ($this->input->post('has_payment') == "" || $this->input->post('has_payment') == 0 ? 0 : 1 ),
							'payment_amount' => $paymentAmount,
							'sum_insured' => $sumInsured,
							'sign_date_cust' => $this->input->post('sign_date_cust'),
							'sign_date_store' => $this->input->post('sign_date_store'),
							'sign_date_sim' => $this->input->post('sign_date_sim'),
							'sign_name_sim' => $this->input->post('sign_name_sim'),
							'full_name' => $this->input->post('full_name'),
							'card_number' => $this->input->post('card_number'),
							'address' => $this->input->post('address'),
							'phone_number' => $this->input->post('phone_number'),
							'contact_number' => $this->input->post('contact_number'),
							'email_address' => $this->input->post('email_address'),
							'simpro_category' => $this->input->post('simpro_category'),
							'product_id' => $this->input->post('device_type'),
							'imei' => $this->input->post('imei'),
							'kondisi' => $this->input->post('kondisi'),
							'product_period_start' => $product_period_start->format('Y-m-d H:i:s'),
							'product_period_end' => $product_period_end->format('Y-m-d H:i:s'),
							'purchase_date' => $purchase_date->format('Y-m-d H:i:s'),
							'document_json' => $document,
							'check_point_json' => $check_point,
							'is_warranty' => ($this->input->post('is_warranty') == "" || $this->input->post('is_warranty') == "N" ? 0 : 1 ),
							'is_seal' => ($this->input->post('is_seal') == "" || $this->input->post('is_seal') == "N" ? 0 : 1 )
							
						);
						
			
//			$id_array = array('id' => $this->input->post('device_type'));
			// $id_array_store = array('id' => $this->session->userdata('store_id'));
			// $getStore = $this->general_model->getfieldById('store_name','store',$id_array_store);
			// $getProduct = $this->general_model->getfieldById('device_type','product',$id_array);

            
            if($type == 'add'){
                $getMaxId = $this->general_model->manualQuery('SELECT MAX(temp_no) as temp_no FROM simpro_registration WHERE store_id = '.$this->session->userdata("store_id").'');
                if(empty($getMaxId)){
                    $maxId = 1;
                }else{
                    $maxId = $getMaxId->result()[0]->temp_no + 1;
                }

				$insert['created_by'] = $this->session->userdata('user_id');
                $insert['reg_no'] = date("Ymd")."-".$this->session->userdata('store_id')."-000".$maxId;
                $insert['date_in'] = date("Y-m-d h:i:s");
                $insert['temp_no'] = $maxId;
                $insert['created'] = date("Y-m-d h:i:s");
                $insert['is_deleted'] = 0;
                $insert['status'] = "not_verified";
				
//				 print_r($insert); die;
                $query = $this->general_model->insertTable('simpro_registration',$insert);
				
                if ($query){					
                    $return = array(
                        $query
						, $insert['reg_no']
						, $this->input->post('store')
						, $insert['simpro_category']
						, $insert['card_number']
						, $insert['full_name']
						, $insert['phone_number']
						, $this->input->post('product_name')
						, $date_in->format('d-m-Y')
						, "Rp. ".number_format($insert['payment_amount'])
						, $this->access['action']
                    );

                    $json_status = 1;
					$temp_id = $query;

                }else{
                    $temp_id = 0;
                    $json_status = 0;
                }
            }
            else if($type == 'edit'){
                $id = $this->input->post('id');
                $insert['reg_no'] = $this->input->post('reg_no');
                $insert['date_in'] = $date_in->format('Y-m-d H:i:s');
                $insert['updated'] = date("Y-m-d H:i:s");
				$insert['updated_by'] = $this->session->userdata('user_id');
                $id_array = array('id' => $id);
				
//				 print_r($insert); die;
                $query = $this->general_model->updateById('simpro_registration', $id_array, $insert);
                if($query){                    
                    
                    $return = array(
                        $id
						, $insert['reg_no']
						, $this->input->post('store')
						, $insert['simpro_category']
						, $insert['card_number']
						, $insert['full_name']
						, $insert['phone_number']
						, $this->input->post('product_name')
						, $date_in->format('d-m-Y')
						, "Rp. ".number_format($insert['payment_amount'])
						, $this->access['action']
                    );

                    $temp_id = 0;
                    $json_status = 1;
                }else{
                    $temp_id = 0;
                    $json_status = 0;
                }

            }else if($type == 'delete'){
                $id = $this->input->post('simpro_id');
                $reg_no = $this->input->post('reg_no');
                $simpro_id = array(
                    'id' => $id
                );
				
				$fileName = "Invoice-".$reg_no.".pdf";
				
                $return = $getMaxId = $this->general_model->manualQuery('UPDATE simpro_registration SET is_deleted = 1 where id = '.$id.'');
                
				if($return != false){
					unlink('pantotukang/attachment/'.$fileName);
                    $temp_id = 0;
                    $json_status = 1;
                    $json_text = 'Success remove Registration.';
                }else{
                    $temp_id = 0;
                    $json_status = 0;
                    $json_text = 'Success remove Registration.';
                }

            }

            $json = array(
                'status' => $json_status,
                'message' => $json_text,
                'data' => $return,
                'type' => $type,
                'tempId' => $temp_id
            );

            echo json_encode($json);


        }else {
            $this->template->load('template/tpl', $data['content'], $data);
        }
    }

    public function sendEmailTicket(){
        $tempId = $this->input->post('id');
        $dataEmail = $this->m_simpro_registration->get_list_simpro_registration($tempId);
        $row = $dataEmail->row();
        $pdfName ="Invoice-".$row->reg_no.".pdf"; // nama pdf disamakan reg_no
        $source_eticket = absAttachmentInvoice().$pdfName;

        $tes['data'] = $row;

        $html = $this->load->view('v_print/invoice',$tes,TRUE);
        $this->pdf->save_pdf_file($html,'A4',$pdfName, $source_eticket);

        // SEND EMAIL
        $data = array(
            'judul' => "EMAIL TELAH TERDAFTAR",
            'reg_no' => base64_encode($row->reg_no)
        );
        $emailData = array(
            'from' => 'noreply@mitrarenov.com',
            'name' => 'SIMPRO',
            'to' => array($row->email_address),
            'cc' => "",
            'bcc' => "",
            'subject' => "Aktivasi SIMPRO",
            'template' => $this->load->view('v_email', $data, true),
            'attach' => $source_eticket
        );

        $kirim = $this->sendEmailAktifasi($emailData);

        if($kirim == TRUE){
            $json = array(
                'status' => 1,
                'message' => ""
            );
        }else{
            $json = array(
                'status' => 0,
                'message' => ""
            );
        }

        echo json_encode($json);

    }

    public function load_ajax_simpro()
    {
        $access = $this->input->get('a');
        $query = $this->m_simpro_registration->get_list_simpro_registration('');
        if($query != false) {
            $iTotalRecords = $this->db->count_all('simpro_registration');
            foreach($query->result() as $aRow)
            {
				$date = new DateTime($aRow->date_in);
				$row = array();
                $row[] = $aRow->id;
                $row[] = $aRow->reg_no;
                $row[] = $aRow->store_name;
                $row[] = $aRow->simpro_category;
                $row[] = $aRow->card_number;
                $row[] = $aRow->full_name;
                $row[] = $aRow->phone_number;
                $row[] = $aRow->device_type;
                $row[] = $date->format('d-m-Y');
                $row[] = "Rp. ".number_format($aRow->payment_amount);
                $row[] = $access;

                $json['status'] = 1;
                $json['sEcho'] = 0;
                $json['iTotalRecords'] = $iTotalRecords;
                $json['iTotalDisplayRecords'] = $iTotalRecords;
                $json['aaData'][] = $row;
            }
        }else{
            $json['status'] = 0;
            $json['aaData'] = array();
            $json['sEcho'] = 0;
            $json['iTotalRecords'] = 0;
            $json['iTotalDisplayRecords'] = 0;
        }
        echo json_encode($json);

    }

    public function get_data_simpro(){
        $id = $this->input->post('id');
        if ($id != '') {
            $data = $this->m_simpro_registration->get_list_simpro_registration($id);
            if ($data) {
                $row = $data->row();
                $json['data'] = $row;
                $json['status'] = 1;
                $json['usergroup'] = $this->session->userdata('level');
            } else {
                $json['status'] = 0;
                $json['message'] = 'data not found';
				$json['usergroup'] = $this->session->userdata('level');
            }
        } else {
            $json['status'] = 0;
            $json['message'] = 'id is empty';
			$json['usergroup'] = $this->session->userdata('level');
        }

        echo json_encode($json);
    }
	
	public function get_next_date(){
        $id = $this->input->post('id');
        $new_date = date("d-m-Y", strtotime("6 months", strtotime($id)));
		if ($id != '') {            
			$json['data'] = $new_date;
            $json['status'] = 1;
		} else {
            $json['status'] = 0;
            $json['data'] = '';
        }
        echo json_encode($json);
    }
	
	public function get_store(){
        $id = $this->input->post('id');
		$id_array_store = array('id' => $this->session->userdata('store_id'));
		$getStore = $this->general_model->getfieldById('store_name','store',$id_array_store);
        $date = date("d-m-Y");
        $new_date = date("d-m-Y", strtotime("6 months", strtotime($date)));
		
//		$getNumber = $this->m_simpro_registration->getPeriodeNummer($this->session->userdata('store_id'));
		
		
		if ($id == '') {            
			$json['store_name'] = $getStore->store_name;
			$json['reg_no'] = "";
			$json['date'] = $date;
			$json['new_date'] = $new_date;
            $json['status'] = 1;
		} else {
            $json['store_name'] = "";
            $json['reg_no'] = "";
            $json['date'] = "";
            $json['new_date'] = "";
            $json['status'] = 0;
        }
        echo json_encode($json);
    }
	
	
	public function printInvoice($id = ""){
		$this->load->library('pdf');
		
        if ($id != '') {
            $data = $this->m_simpro_registration->get_list_simpro_registration($id);
            if ($data) {
                $row = $data->row();
                $json['data'] = $row;
                $pdfName ="Invoice-".$row->reg_no.".pdf"; // nama pdf disamakan reg_no
				// $source_eticket = absAttachmentInvoice().$pdfName;                
				
				$tes['data'] = $row;				
				
            } else {
                $json['status'] = 0;
                $json['message'] = 'data not found';
				$json['usergroup'] = $this->session->userdata('level');
            }
        } else {
            $json['status'] = 0;
            $json['message'] = 'id is empty';
			$json['usergroup'] = $this->session->userdata('level');
        }
		
		$html = $this->load->view('v_print/invoice',$tes,TRUE);
		// $this->pdf->save_pdf_file($html,'A4',$pdfName, $source_eticket);
		$this->pdf->print_data($html,'A4',$pdfName,"print");

    }
	
	
	public function get_data_product(){
        $id = $this->input->post('id');
        if ($id != '') {
            $data = $this->general_model->getById('product', array('id' => $id));
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
	
	public function load_list_product(){

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

        $sche_id = '';
        // $data = $this->general_model->getListLikeLimit('product', 'brand, product_name', $search, (($sche_id == '' || $sche_id == NULL) ? '' : array('id')), (($sche_id == '' || $sche_id == NULL) ? '' : array($sche_id)), 'id', $from, $limit);
        $data = $this->general_model->getListQuery('product', 'brand', 'product_name', $search, array('id'), $from, $limit, $this->session->userdata('store_id'));

        foreach($data->result() as $row)
        {
            $rows['id'] = $row->brand_slug;
            $rows['text'] = $row->brand;
            $json['results'][] = $rows;
        }

        $json['count_data'] = $data->num_rows();
        $json['count_all'] = $this->general_model->getCountTableLike('product', 'id', $search, (($sche_id== '' || $sche_id== NULL) ? '' : array('id')), (($sche_id == '' || $sche_id == NULL) ? '' : array($sche_id)));

        echo json_encode($json);
    }
	
	public function load_list_device(){

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

        $sche_id = '';
		$data = $this->general_model->getListQueryDevice('product', 'brand', 'product_name', $search, array('id'), $from, $limit, $this->session->userdata('store_id'), $_GET['id']);
		
        foreach($data->result() as $row)
        {	
            $rows['id'] = $row->id;
            $rows['text'] = $row->device_type;
            $json['results'][] = $rows;
        }

        $json['count_data'] = $data->num_rows();
        $json['count_all'] = $this->general_model->getCountTableLike('product', 'id', $search, (($sche_id== '' || $sche_id== NULL) ? '' : array('id')), (($sche_id == '' || $sche_id == NULL) ? '' : array($sche_id)));

        echo json_encode($json);
    }
	
	
	private function sendEmailAktifasi($emailData = array()){
		return $this->customemail->send_email_noreply(
				  $emailData['from']
				, $emailData['name']
				, $emailData['to']
				, $emailData['cc']
				, $emailData['bcc']
				, $emailData['subject']
				, $emailData
				, $emailData['template']
				, $emailData['attach']
			);		
	}
	
	public function TesEmail()
	{
		// $query_template = $this->db->query("select * FROM email_project");
		// $template = $query_template->row();

		$data = array(
			'judul' => "EMAIL TELAH TERDAFTAR",
			'tanggal' => date("d-M-Y"),
			'description' => "Selamat Email anda telah Terdaftar di Mitrarenov.com",
			'nama' => "Fajar Nugraha",
			'project_id' => '124324ffsd',
			'password' => 'Fajaroentyil', 'email' => 'oenyil91@gmail.com',
			'reg_no' => base64_encode("@#$@#$")
		);
		$emailData = array(
			'from' => 'noreply@mitrarenov.com',
			'name' => 'SIMPRO',
			'to' => array('fnugraha11@gmail.com'),
			'cc' => "",
			'bcc' => "",
			'subject' => "Aktivasi SIMPRO",
			'template' => $this->load->view('v_email', $data, true),
			'attach' => 'pantotukang/attachment/syarat.pdf'
		);		
		
		// $this->load->view('v_email', $data);
									
		$this->sendEmailAktifasi($emailData);
		// print_r($this->sendEmailAktifasi($emailData));
	}
	
	

}