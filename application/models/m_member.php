<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_member extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list_member($id = ''){
        $this->db->select("a.id,a.email,a.created,b.`name`, c.`name` as usergroup_name");
        $this->db->from('member a');
        $this->db->join('member_detail b','a.id = b.member_id');
        $this->db->join('usergroup c','a.usergroup_id = c.id');
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

    public function get_data_member($id = ''){
        $this->db->select("a.id as id_member, a.usergroup_id, a.email, a.`password`,b.*, c.`name` as usergroup_name, d.`name` as city_name");
        $this->db->from('member a');
        $this->db->join('member_detail b','a.id = b.member_id','inner');
        $this->db->join('usergroup c','a.usergroup_id = c.id','inner');
        $this->db->join('city d','d.id = b.city_id','left');
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

    public function get_list_member_cc($id = ''){
        $this->db->select("a.*, b.`name` as member_name");
        $this->db->from('member_cc a');
        $this->db->join('member_detail b','a.member_id = b.member_id','left');
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

    public function get_list_member_preference($id = ''){
        $this->db->select("a.*, b.`name` as member_name");
        $this->db->from('member_preference a');
        $this->db->join('member_detail b','a.member_id = b.member_id','left');
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