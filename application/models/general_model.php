<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class General_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function getList($table = '', $order = '') {
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by($order, "ASC");
        $sql = $this->db->get();
        if($sql->num_rows()>0){
            return $sql;
        }else{
            $sql->free_result();
            return $sql;
        }
    }

    public function getfieldById($field = '',$table = '', $id = array()){
        $this->db->select($field);
        $this->db->from($table);
        $this->db->where($id);
        $data = $this->db->get();
        if($table != '')
        {
            if($data->num_rows()>0){
                return $data->row();
            }
            else return FALSE;
        }
        else return FALSE;
    }

    public function getListbyField($table = '', $field = array()){
        $this->db->select($field);
        $this->db->from($table);
        $data = $this->db->get();
        if($table != '')
        {
            if($data->num_rows()>0){
                return $data;
            }
            else return FALSE;

        }
        else return FALSE;
    }

    public function manualQuery($query)
	{
		$data = $this->db->query($query);
		return $data;
	}
    
    public function getById($table = '', $id = array())
    {
        if($table != '')
        {
            $this->db->from($table);
            foreach($id as $key => $value) 
            {
                $this->db->where($key, $value);
            }
            $data = $this->db->get();
            return $data;
        }
        else return FALSE;
    }

    public function getByWhere($table = '', $where = array())
    {
        if($table != '')
        {
            $this->db->from($table);
            foreach($where as $key => $value)
            {
                $this->db->where($key, $value);
            }
            $data = $this->db->get();
            return $data;
        }
        else return FALSE;
    }
    
    public function getByWhereOrder($table = '', $where = array(), $order = array())
    {
        if($table != '')
        {
            $this->db->from($table);
            foreach($where as $key => $value) 
            {
                $this->db->where($key, $value);
            }
            foreach($order as $key => $value) 
            {
                $this->db->order_by($key, $value);
            }
            $data = $this->db->get();
            return $data;
        }
        else return FALSE;
    }
    
    public function getByWhereOrderLimit($table = '', $where = array(), $order = array(), $limit = '', $from = '')
    {
        if($table != '')
        {
            $this->db->from($table);
            foreach($where as $key => $value) 
            {
                $this->db->where($key, $value);
            }
            foreach($order as $key => $value) 
            {
                $this->db->order_by($key, $value);
            }
            if($limit !== '' && $from === '') $this->db->limit($limit);
            else if($limit !== '' && $from !== '') $this->db->limit($limit, $from);
            $data = $this->db->get();

            return $data;
        }
        else return FALSE;
    }
    
    public function insertTable($table = '', $data = array())
    {
        if($table != '')
        {
            $this->db->trans_begin();
            $this->db->insert($table, $data);
            $id = $this->db->insert_id();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            }
            else {
                $this->db->trans_commit();
                return $id;
            }
        }
        else return FALSE;
    }

    public function updateById($table = '', $id = array(), $data = array())
    {
        if($table !== '' && count($id) !== 0)
        {
            $this->db->trans_begin();
            $this->db->update($table, $data, $id);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            }
            else {
                $this->db->trans_commit();
                return TRUE;
            }
        }
        else return FALSE;
    }
    
    public function deleteByWhere($table = '', $where = array())
    {
        if($table != '' && count($where) != 0)
        {
            $this->db->trans_begin();
            $this->db->delete($table, $where);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            }
            else {
                $this->db->trans_commit();
                return TRUE;
            }
        }
        else return FALSE;
    }

    function getFirstRow($table, $order, $where = array()) {
        $this->db->cache_off();
        $this->db->from($table);
        foreach($where as $key => $value)
        {
            $this->db->where($key, $value);
        }
        $this->db->order_by($order, "ASC");
        $sql = $this->db->get();

        if($sql->num_rows()<> 0){

            return $sql->row();

        }else{

            return false;

        }

    }


    function getListQuery($table, $like1 = '', $like2 = '', $where = '', $id = '', $from = 0, $limit = 0, $store) {
        $this->db->cache_off();
		$qwhere = "";
		
		if($where != ""){
			// $qwhere = " ($like1 like '%$where%' OR $like2 like '%$where%') AND ";			
			$qwhere = "WHERE ($like1 like '%$where%' OR $like2 like '%$where%') ";			
		}
		// $sql = $this->db->query("select DISTINCT(brand), brand_slug from $table WHERE $qwhere store_id = $store order by brand asc");
		$sql = $this->db->query("select DISTINCT(brand), brand_slug from $table $qwhere order by brand asc");
		
		// print_r($data->result()); die;
        // $sql = $this->db->get();
        if($sql->num_rows()>0){

            return $sql;

        }else{

            $sql->free_result();

            return $sql;
        }
    }
	
	function getListQueryDevice($table, $like1 = '', $like2 = '', $where = '', $id = '', $from = 0, $limit = 0, $store, $param) {
        $this->db->cache_off();
		$qwhere = "";
		
		if($where != ""){
			$qwhere = " ($like1 like '%$where%' OR $like2 like '%$where%') AND ";			
		}
		// $sql = $this->db->query("select * from $table WHERE $qwhere store_id = $store AND brand_slug = '".$param."' order by device_type asc");
		$sql = $this->db->query("select * from $table WHERE $qwhere brand_slug = '".$param."' order by device_type asc");
		
		// print_r($data->result()); die;
        // $sql = $this->db->get();
        if($sql->num_rows()>0){

            return $sql;

        }else{

            $sql->free_result();

            return $sql;
        }
    }
	
	function getListLikeLimit($table, $like = '', $id = '', $where = '', $data = '', $order, $from = 0, $limit = 0) {
        $this->db->cache_off();
        $this->db->select('*');
        $this->db->from($table);
        if($where != '' && $data != '') {
            for($i = 0; $i < count($where); $i++)
            {
                $this->db->where($where[$i], $data[$i]);
            }
        }
        if($like != '' && $id != '') {
            $this->db->like($like, $id);
        }
        $this->db->order_by($order, "ASC");
        if ($from != 0 && $limit != 0) {
            $this->db->limit($limit, $from);
        }
        $sql = $this->db->get();
        if($sql->num_rows()>0){

            return $sql;

        }else{

            $sql->free_result();

            return $sql;
        }
    }

    function getCountTableLike($table, $like = '', $id = '', $where = '', $data = '')
    {
        $this->db->cache_off();
        if($where != '' && $data != '') {
            for($i = 0; $i < count($where); $i++)
            {
                $this->db->where($where[$i], $data[$i]);
            }
        }
        if($like != '' && $id != ''){
            $this->db->like($like, $id);
        }
        $this->db->from($table);
        return $this->db->count_all_results();
    }


    function getFirstWhere($columns, $table, $whr, $id, $order) {
        $this->db->cache_off();
        $this->db->select($columns);
        $this->db->from($table);
        $this->db->where($whr, $id);
        $this->db->limit(1, 0);
        $this->db->order_by($order, "ASC");

        $sql = $this->db->get();
        if($sql->num_rows()>0){

            return $sql;

        }else{

            $sql->free_result();
            return $sql;
            //return false;
        }
    }


    public function getLevelAccess($uri = '', $level = 0)
    {
        $this->db->cache_off();
        $query = "SELECT
                aa.*
            FROM
                `backend_menu_access` aa
            INNER JOIN `backend_menu` bb
                ON aa.`backend_menu_id` = bb.`id`
            WHERE
                bb.`url` = '{$uri}'
            AND
                aa.`usergroup_id` = {$level}";

        $access = $this->db->query($query);
        if( $access->num_rows() > 0 ) {
            $row = $access->row();
            $access = array(
                'add' => $row->add
            ,'action' => array(
                    'view' => $row->view
                ,'edit' => $row->edit
                ,'delete' => $row->delete
                )
            );
        }
        else {
            $access = array(
                'add' => 0
            ,'action' => array(
                    'view' => 0
                ,'edit' => 0
                ,'delete' => 0
                )
            );
        }
        $string = '';
        foreach($access['action'] as $key => $value)
        {
            if($string != '') $string .= ',';
            if($value != 0) $string .= $key;
        }
        $access['action'] = $string;
        return $access;
    }

    function do_resize($path = '',$new_path = '', $image_name_source = '', $image_name_thumbs = '', $ratio = 0, $width = 0, $height = 0)
    {
        $this->load->library('image_lib');

        $new_width = 0;
        $new_height = 0;

        if ($width > $height) {
            $new_width = $width;
            $new_height = $new_width / $ratio;
            if ($height == 0)
                $height = $new_height;
            if ($new_height < $height) {
                $new_height = $height;
                $new_width = $new_height * $ratio;
            }
        }
        else {
            $new_height = $height;
            $new_width = $new_height * $ratio;
            if ($width == 0)
                $width = $new_width;

            if ($new_width < $width) {
                $new_width = $width;
                $new_height = $new_width / $ratio;
            }
        }

        $new_width = ceil($new_width);
        $new_height = ceil($new_height);

        //Resizing
        $config = array();
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path.$image_name_source;
        $config['new_image'] = $new_path.$image_name_thumbs;
        $config['maintain_ratio'] = FALSE;
        $config['height'] = $new_height;
        $config['width'] = $new_width;
        $config['quality'] = 80;
        $this->image_lib->initialize($config);

        if(!$this->image_lib->resize()) return $this->image_lib->display_errors();
        else
        {
            $this->image_lib->clear();

            //Crop if both width and height are not zero
            $x_axis = floor(($new_width - $width) / 2);
            $y_axis = floor(($new_height- $height) / 2);

            //Cropping
            $config = array();
            $config['source_image'] = $new_path.$image_name_thumbs;
            $config['maintain_ratio'] = FALSE;
            $config['new_image'] = $new_path.$image_name_thumbs;
            $config['width'] = $width;
            $config['height'] = $height;
            $config['x_axis'] = $x_axis;
            $config['y_axis'] = $y_axis;
            $config['quality'] = 100;
            $this->image_lib->initialize($config);

            if(!$this->image_lib->crop()) return $this->image_lib->display_errors();
            else $this->image_lib->clear();
        }
    }


}