<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_simpro_registration extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list_simpro_registration($id = ''){
        $this->db->select('a.*, b.store_name, c.product_name, c.claim_price, c.device_type, c.brand, c.brand_slug, d.name ');
        $this->db->from('simpro_registration a');
        $this->db->join('store b', 'a.store_id = b.id', 'left');
        $this->db->join('product c', 'a.product_id = c.id', 'left');
        $this->db->join('member_detail d', 'a.created_by = d.member_id', 'left');
        $this->db->where('a.is_deleted', 0);
		$this->db->order_by('a.created_by','desc');
        if($id != ''){
            $this->db->where('a.id', $id);
        }
		
		// Jika agent tampil hanya yang dia buat
		if($this->session->userdata('level') == 5){
			$this->db->where('a.created_by', $this->session->userdata('user_id'));
		}
		
		// Jika vendor tampil hanya store dia
		if($this->session->userdata('level') == 3){
			$this->db->where('a.store_id', $this->session->userdata('store_id'));
		}
		

        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql;
        }else{
            return false;

        }
    }
	
	public function getPeriodeNummer($store_id) {
		$this->db->select_max('id');
		$res1 = $this->db->get('simpro_registration');

		if ($res1->num_rows() > 0)
		{
			$res2 = $res1->result_array();
			
			$result = date("Ymd")."-".$store_id."-00".($res2[0]['id'] + 1);
			// print_r($res2); die;
			// $result = $res2[0]['id'];
			

			return $result;
		}

		return NULL;
	}
	

}