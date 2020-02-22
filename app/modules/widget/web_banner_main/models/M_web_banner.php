<?php
class M_web_banner extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwidget($idd,$idw){
		$sqlstr="SELECT a.*
		FROM p_setting_item a 
		WHERE a.id_setting='9' AND a.id_item=$idw";
		$hslquery=$this->db->query($sqlstr)->result();
			$jj=json_decode($hslquery[0]->meta_value);
			$ini=$jj->id_kategori;

		$sqlstr3="SELECT * FROM konten_foto WHERE id_konten IN ($ini) AND tipe='banner'";
		$hslquery3=$this->db->query($sqlstr3);

		return $hslquery3;
	}
//////////////////////////////////////////////////////////////////////////////////
}
