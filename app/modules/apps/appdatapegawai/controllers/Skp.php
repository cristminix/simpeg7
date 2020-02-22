<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Skp extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function view($id_pegawai=false){
		$content['id_pegawai'] = $id_pegawai;
		// $content['data'] = Modules::run("datamodel/pegawai/get_riwayat_skp",$id_pegawai);
		$content['panel_body'] = $this->load->view('skp/panel_body',$content,true);
		
		$this->load->view('skp/default',$content);
	}
	function form($id_pegawai=false,$id_peg_skp=false){
		$content['id_pegawai'] = $id_pegawai;
		// $content['id_peg_skp'] = $id_peg_skp;
		// $content['row'] = Modules::run("datamodel/pegawai/get_peg_perkawinan",$id_peg_skp);
		
		$this->load->view('skp/form',$content);
	}
	function save($id_pegawai=false,$id_peg_skp=false,$data=array()){
		// $result = Modules::run("datamodel/pegawai/set_peg_perkawinan",$id_pegawai,$id_peg_skp,$data);
		// if($result)
    // {
      // $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
    // }else
    // {
      // $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
    // }
    // $this->view($id_pegawai,$content);
	}
	function del($id_pegawai=false,$id_peg_skp=false){
		// $result = Modules::run("datamodel/pegawai/del_peg_perkawinan",$id_peg_skp);
		// if($result)
    // {
      // $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil dihapus.</div>';
    // }else
    // {
      // $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil dihapus.</div>';
    // }
    // $this->view($id_pegawai,$content);
	}
}
?>