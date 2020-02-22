<?php
class M_artikel_slider extends CI_Model{
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

		$sqlstr3="SELECT a.*,b.nama_item AS nama_kategori, b.id_item AS id_kategori, b.id_parent AS id_kanal 
		FROM konten_judul a 
		LEFT JOIN (p_setting_item b) ON 
		(a.id_kategori=b.id_item AND b.id_setting='6') 
		WHERE a.id_kategori IN ($ini) LIMIT 0,4";
		$hslquery3=$this->db->query($sqlstr3);

		return $hslquery3;
	}

	function cekimage($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='$idd' AND tipe='artikel_slider'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
