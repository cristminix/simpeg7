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
				 	   ->row();
		return json_encode($rs);
	}
	public function get_wrapper($path,$posisi){
		$rs = $this->db->select('meta_value')
					 ->from('p_setting_item')
					 ->where('id_setting','10')
					 ->where('nama_item',$posisi)
					 ->like('meta_value','\"path_kanal\":\"'.$path.'\"')
					 ->get()
					 ->row();

		$res=(!empty($row->meta_value))	?	json_decode($row->meta_value)	:	json_decode("{\"widget\":[]}");
		return $res;
	}
	public function cari_kanal($idd){
		$rs = $this->db->select('meta_value,nama_item,id_item')
					->from('p_setting_item')
					->where('id_setting','1')
					->like('meta_value','\"path_kanal\":\"'.$idd.'\"')
					->get()
					->row();

					@$hsl = json_decode($hslquery[0]->meta_value);
					@$hslq->nama_kanal=$hslquery[0]->nama_item;
					$hslq->path_kanal=@$hsl->path_root;
					$hslq->tipe=@$hsl->tipe;
					$hslq->theme=@$hsl->theme;
					$hslq->id_kanal=@$hslquery[0]->id_item;
					return $hslq;
	}
}