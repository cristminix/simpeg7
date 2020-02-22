<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Orangtua_ro extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('sikda');
	}
	function view($id_pegawai=false,$content=array()){
		$content['id_pegawai'] = $id_pegawai;
		$content['data'] = Modules::run("datamodel/pegawai/get_riwayat_orangtua",$id_pegawai);
		$content['panel_body'] = $this->load->view('orangtua/panel_body_ro',$content,true);
		
		$this->load->view('orangtua/default_ro',$content);
	}
	function form($id_pegawai=false,$id_peg_orangtua=false){
		$content['id_pegawai'] = $id_pegawai;
		$content['id_peg_orangtua'] = $id_peg_orangtua;
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_orangtua",$id_peg_orangtua);
		
		$this->load->view('orangtua/form',$content);
	}
	function save($id_pegawai=false,$id_peg_orangtua=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_orangtua",$id_pegawai,$id_peg_orangtua,$data);
		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
    }
    $this->view($id_pegawai,$content);
	}
	function del($id_pegawai=false,$id_peg_orangtua=false){
		$result = Modules::run("datamodel/pegawai/del_peg_orangtua",$id_peg_orangtua);
		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil dihapus.</div>';
    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil dihapus.</div>';
    }
    $this->view($id_pegawai,$content);
	}
}
?>