<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Profile_ro extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function index($id_pegawai=false){
//		$id_pegawai = $this->session->userdata('pegawai_info');
		$content['fotoSrc'] = Modules::run("datamodel/pegawai/get_peg_fotosrc",$id_pegawai);
		$content['data'] = Modules::run("datamodel/pegawai/get_pegawai",$id_pegawai);
		$content['kontrak'] = Modules::run("datamodel/pegawai/get_peg_kontrak",$id_pegawai);
		$content['capeg'] = Modules::run("datamodel/pegawai/get_peg_capeg",$id_pegawai);
		$content['tetap'] = Modules::run("datamodel/pegawai/get_peg_tetap",$id_pegawai);
		// $content['pns'] = Modules::run("datamodel/pegawai/get_peg_pns",$id_pegawai);
		$content['id_pegawai'] = $id_pegawai;
		$this->load->view('profile/default_ro',$content);
	}
}
?>