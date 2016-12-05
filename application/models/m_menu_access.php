<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_menu_access extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list_menu_access($id = ''){
        $this->db->select("a.*, b.`name` as usergroup_name, c.`name` as menu_name, d.`name` as parent_menu");
        $this->db->from('backend_menu_access a');
        $this->db->join('usergroup b','a.usergroup_id = b.id','left');
        $this->db->join('backend_menu c','c.id = a.backend_menu_id','left');
        $this->db->join('backend_menu d','c.parent = d.id','left');
        if($id != ''){
            $this->db->where('a.backend_menu_id', $id);
        }

        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql;
        }else{
          return false;

        }
    }

    public function get_data_access($id_access){
        $this->db->select("a.id, a.usergroup_id, b.`name` as usergroup_name, a.`view`, a.`add`, a.edit, a.`delete`,
        c.id as menu_id, c.`name` as menu_name, d.id as parent_id,  d.`name` as parent_menu");
        $this->db->from('backend_menu_access a');
        $this->db->join('usergroup b','a.usergroup_id = b.id','left');
        $this->db->join('backend_menu c','c.id = a.backend_menu_id','left');
        $this->db->join('backend_menu d','c.parent = d.id','left');
        $this->db->where('a.id', $id_access);
        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql;
        }else{

            $sql->free_result();
            return $sql;

        }

    }




}