<?php if(!defined('BASEPATH'))exit('No direct script access allowed');

class M_dashboard extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function getResultDashboard_quotation($tanggal="",$bulan="",$tahun="",$type=""){
		if($type=='bulan') {
		$query = $this->db->query("SELECT count(*) as jml FROM quotation 
		where month(FROM_UNIXTIME(created))=".$bulan." and day(FROM_UNIXTIME(created))=".$tanggal." and year(FROM_UNIXTIME(created))=".$tahun);
		} else if($type=='tahun') {
		$query = $this->db->query("SELECT count(*) as jml FROM quotation 
		where month(FROM_UNIXTIME(created))=".$bulan." and year(FROM_UNIXTIME(created))=".$tahun);		
		}
		$temp=$query->result();	
        return $temp[0]->jml;
	}
	
	function getResultDashboard_projects($tanggal="",$bulan="",$tahun="",$type=""){
		if($type=='bulan') {
		$query = $this->db->query("SELECT count(*) as jml FROM projects 
		where month(FROM_UNIXTIME(created))=".$bulan." and day(FROM_UNIXTIME(created))=".$tanggal." and year(FROM_UNIXTIME(created))=".$tahun);
		} else if($type=='tahun') {
		$query = $this->db->query("SELECT count(*) as jml FROM projects 
		where month(FROM_UNIXTIME(created))=".$bulan." and year(FROM_UNIXTIME(created))=".$tahun);		
		}
		$temp=$query->result();	
        return $temp[0]->jml;
	}

}