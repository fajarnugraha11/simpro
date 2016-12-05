<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_menu extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list_menu($column = array(), $table = '', $join = '', $on_join, $order = '') {
        $this->db->select($column);
        $this->db->from($table);
        $this->db->join($join,$on_join,'left');
        $this->db->order_by($order, "ASC");
        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql;
        }else{

            $sql->free_result();
            return $sql;

        }
    }

    public function listMenu() {
        $usergroup = $this->session->userdata('level');
        if($usergroup != '') {
            $query = "SELECT
                bb.*
            FROM
                (
                 SELECT
                        `backend_menu_access`.`backend_menu_id`,
                        `backend_menu_access`.`usergroup_id`
                    FROM
                        `backend_menu_access`
                    WHERE
                        `backend_menu_access`.`usergroup_id` = '$usergroup'
                    AND `backend_menu_access`.`view` = 1
                    GROUP BY
                        `backend_menu_access`.`backend_menu_id`
                ) aa
            INNER JOIN `backend_menu` bb ON aa.backend_menu_id = bb.id
            WHERE `bb`.`parent` = 0
            ORDER BY
                bb.`sort` ASC";

            $sql = $this->db->query($query);

            if ($sql->num_rows() > 0) {
                foreach ($sql->result() as $rows) {
                    $data[] = $rows;
                }
            } else {
                $data = 0;
            }

            $sql->free_result();
            return $data;
        }else{
            redirect('login');
        }
    }

    public function listSubMenu() {
        $usergroup = $this->session->userdata('level');
            $query = "SELECT
                bb.*
            FROM
                (
                    SELECT
                        `backend_menu_access`.`backend_menu_id`,
                        `backend_menu_access`.`usergroup_id`
                    FROM
                        `backend_menu_access`
                    WHERE
                        `backend_menu_access`.`usergroup_id` = '$usergroup'
                    AND `backend_menu_access`.`view` = 1

                ) aa
            INNER JOIN `backend_menu` bb ON aa.`backend_menu_id` = bb.`id`
            WHERE bb.parent != 0
            ORDER BY
                bb.`sort` ASC";
        $sql = $this->db->query($query);
        if($sql->num_rows()>0){
            foreach ($sql->result() as $rows){
                $data[] = $rows;
            }
        }else{
            $data=0;
        }

        $sql->free_result();
        return $data;
    }
}