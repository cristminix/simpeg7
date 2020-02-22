<?php
class M_notif extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function getData($mulai,$batas){
		if($batas==0){$limit="";}else{$limit="LIMIT $batas OFFSET $mulai";}
		$sqlstr="SELECT a.* FROM p_setting_item a WHERE a.id_setting='111' ORDER BY a.id_item ASC $limit";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	
	function countData(){
		$query=$this->db->query("SELECT count(id_item) as count_all FROM p_setting_item WHERE id_setting='111'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_all'];
		return $hslrow;
	}
	
	function getDetail($idg){
		$sqlstr="SELECT * FROM p_setting_item WHERE id_item='$idg'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	
	function saveData($id=0,$data){
		if($id == 0){
			$sqlstr = "INSERT INTO p_setting_item (id_setting,meta_value)values(111,'$data')";
		}else{
			$sqlstr = "UPDATE p_setting_item set meta_value = '$data' WHERE id_item = '$id'";
		}
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
}