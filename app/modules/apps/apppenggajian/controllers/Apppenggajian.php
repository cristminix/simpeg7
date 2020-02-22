<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Apppenggajian extends MX_Controller {

	function __construct(){
		parent::__construct();
	}

	function index(){
//		$sub=array("unor","pegawai","profile","jabfung","mutasi","pejabat","pendidikan","dashboard");
		$sub=array();
		$id_grup = $this->session->userdata('group_id');
		
		$cari = '"group_id":"'.$id_grup.'"';
		$this->db->from('p_setting_item');
		$this->db->where('id_setting',3);
		$this->db->like('meta_value',$cari);
		$hsl = $this->db->get()->result();
		
		

		foreach($hsl as $key=>$val){
			$itt = json_decode($val->meta_value);
			$idt = $itt->id_menu;
				$this->db->from('p_setting_item');
				$this->db->where('id_item',$idt);
				$nnm = $this->db->get()->row();
				$itk = json_decode($nnm->meta_value);
			    $d = array ('module/apppenggajian/');
				$etk = explode("/",str_replace($d, '', $itk->path_menu));
				array_push($sub,$etk[0]);
		}

	
		if(in_array($this->uri->segment(4),$sub)){
			if($this->uri->segment(5)==""){
				echo Modules::run("apppenggajian/".$this->uri->segment(4)."/index");
			} else {
				echo Modules::run("apppenggajian/".$this->uri->segment(4)."/".$this->uri->segment(5));
			}
		} else {
			redirect(site_url("admin"));
		}
	}
}