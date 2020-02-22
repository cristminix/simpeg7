<?php
class M_index_tutorial extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getwidget($idd,$idw){
		$sqlstr="SELECT a.* FROM p_setting_item a WHERE a.id_setting='9' AND a.id_item=$idw";
		$hslquery=$this->db->query($sqlstr)->result();

			$jj=json_decode($hslquery[0]->meta_value);
			$ini=$jj->id_kategori;

		$sqlstr3="SELECT a.nama_item AS nama_kategori, a.id_item AS id_kategori 
		FROM p_setting_item a 
		WHERE a.id_item IN ($ini) ORDER BY a.urutan ASC";
		$hslquery3=$this->db->query($sqlstr3);
		return $hslquery3;
	}
	function ini_wrapper($idd){
		$sqlstr="SELECT a.nama_item AS nama_wrapper FROM p_setting_item a WHERE a.id_item='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function getisi($idd){
		$sqlstr="SELECT a.*, (SELECT DAYNAME(a.tanggal)) AS hari, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal
		FROM konten_judul a 
		WHERE a.id_kategori=$idd ORDER BY a.tanggal DESC LIMIT 0,10";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
