<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_login extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }


    function checkLogin($email = '', $password = '')
    {
        if($email !== '' && $password !== '') {
            $this->db->select('a.*,b.*');
            $this->db->from('member a');
            $this->db->join('member_detail b','a.id = b.member_id');
            $this->db->join('usergroup c','a.usergroup_id = c.id');
//            $this->db->join('schools d','a.school_id = d.school_id', 'left');
            $this->db->where('a.email', $email);
            $this->db->where('a.password', $password);
            // $this->db->where('a.usergroup_id', "2");
            // $this->db->or_where('a.usergroup_id', "7");
            $this->db->limit(1);
            $data = $this->db->get();
            if($data->num_rows()>0){
                return $data->row();
            }
            else return false;
        }
        else return false;
    }


}