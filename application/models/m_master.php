<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_master extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list_city($id = ''){
        $this->db->select("a.*, b.`name` as province_name");
        $this->db->from('city a');
        $this->db->join('province b','a.province_id = b.id','left');
        if($id != ''){
            $this->db->where('a.id', $id);
        }

        $sql = $this->db->get();

        if($sql->num_rows()>0){
            return $sql;
        }else{
            return false;

        }
    }
}