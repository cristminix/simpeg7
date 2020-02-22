<?php
class M_statis_main extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function getwidget($idd,$idw){
		$sqlstr="SELECT a.*
		FROM p_setting_item a 
		WHERE a.id_setting='9' AND a.id_item=$idw";
		$hslquery=$this->db->query($sqlstr)->result();
			$jj=json_decode($hslquery[0]->meta_value);
			$ini=$jj->id_kategori;

		$sqlstr3="SELECT a.*,b.nama_item AS nama_kategori
		FROM konten_judul a 
		LEFT JOIN p_setting_item b 
		ON (a.id_kategori=b.id_item AND b.id_setting='6') 
		WHERE a.id_kategori IN ($ini) LIMIT 0,1";
		$hslquery3=$this->db->query($sqlstr3);

		return $hslquery3;
	}
	function ini_wrapper($idd){
		$sqlstr="SELECT a.nama_item AS nama_wrapper FROM p_setting_item a WHERE a.id_item='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
