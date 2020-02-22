<?php
class M_web_detail_samping extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function cari_rubrik_kanal($id_kanal){
		$sqlstr="SELECT a.nama_item AS nama_kategori,a.id_item AS id_kategori,a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='6' AND a.meta_value LIKE '%\"id_kanal\":\"$id_kanal\"%' AND a.meta_value LIKE '%\"status\":\"publish\"%'
		ORDER BY a.urutan ASC";
		$hslquery=$this->db->query($sqlstr)->result();

		foreach($hslquery AS $key=>$val){
			$jj = json_decode($val->meta_value);
			$hslquery[$key]->id_kanal=$jj->id_kanal;
			$hslquery[$key]->komponen=$jj->komponen;
		}

		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
