<?php

/**
 * 
 */
class M_web extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_opsi_value()
	{
		$rs = $this->db->where(['id_setting' => '5'])
					   ->get('p_setting_item') 
				 	   ->row()->meta_value;
		return json_decode($rs);
	}
	public function get_wrapper($path,$posisi){
		$rs = $this->db->select('meta_value')
					 ->from('p_setting_item')
					 ->where('id_setting','10')
					 ->where('nama_item',$posisi)
					 ->like('meta_value','\"path_kanal\":\"'.$path.'\"')
					 ->get()
					 ->row();

		$res=(!empty($row->meta_value))	?	json_decode($row->meta_value)	
									    :	json_decode("{\"widget\":[]}");
		return $res;
	}
	public function cari_kanal($idd){
		$rs = $this->db->select('meta_value,nama_item,id_item')
					->from('p_setting_item')
					->where('id_setting','1')
					->like('meta_value','\"path_kanal\":\"'.$idd.'\"')
					->get()
					->row();

		$mv 		    = json_decode($rs->meta_value);
		// print_r($mv);
		$o 				= new stdClass();
		$o->nama_kanal	= $mv->nama_item;
		$o->path_kanal	= $mv->path_root;
		$o->tipe 		= $mv->tipe;
		$o->theme 		= $mv->theme;
		$o->id_kanal 	= $mv->id_item;

		return $o;
	}

	function get_komponen(){
		$hslquery = $this->db->get_where('p_setting_item', ['id_setting' => '7'])->result();
		$hsl = array();
		foreach ($hslquery AS $key=>$val){ $hsl[]=$val->nama_item;}
		return $hsl;
	}
}