<?php
class M_pack_web extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function get_opsi($path){
		$sqlstr="SELECT meta_value FROM p_setting_item WHERE id_setting='13' AND meta_value LIKE '%\"path_kanal\":\"$path\"%'";
//		$sqlstr="SELECT meta_value FROM p_setting_item WHERE id_setting='13' AND id_item='$path'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function gettemplate_by_path($path){
		$sqlstr="SELECT * FROM p_setting_item WHERE id_setting='12' AND meta_value LIKE '%\"theme_path\":\"$path\"%' ";
		$data = $this->db->query($sqlstr)->result();
		return $data;
	}

}
