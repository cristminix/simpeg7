<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pernikahan extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function view($id_pegawai=false,$content=array()){
		$content['id_pegawai'] = $id_pegawai;
		$content['data'] = Modules::run("datamodel/pegawai/get_riwayat_perkawinan",$id_pegawai);
		$content['panel_body'] = $this->load->view('pernikahan/panel_body',$content,true);
		
		$this->load->view('pernikahan/default',$content);
	}
	function form($id_pegawai=false,$id_peg_perkawinan=false){
		$content['id_pegawai'] = $id_pegawai;
		$content['id_peg_perkawinan'] = $id_peg_perkawinan;
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_perkawinan",$id_peg_perkawinan);
		
		$this->load->view('pernikahan/form',$content);
	}

	function form_sub($id_peg_perkawinan,$id=false){
		$content['id_peg_perkawinan'] = $id_peg_perkawinan;
		$content['id_peg_perkawinan_tunjangan'] = $id;
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_perkawinan_tunjangan", $id);
		// var_dump($content['row']);
		$this->load->view('pernikahan/form_sub',$content);
	}

	function save($id_pegawai=false,$id_peg_perkawinan=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_perkawinan",$id_pegawai,$id_peg_perkawinan,$data);
		if($result)
		{
		$content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
		}else
		{
		$content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
		}
		$this->view($id_pegawai,$content);
	}

	function save_sub($id_pegawai, $id_peg_perkawinan=false, $id=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_perkawinan_tunjangan", $id, $data);
		if($result)
		{
		$content['notif' . $id_peg_perkawinan] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
		}else
		{
		$content['notif' . $id_peg_perkawinan] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
		}
		$this->view($id_pegawai,$content);
	}

	function del($id_pegawai=false,$id_peg_perkawinan=false){
		$result = Modules::run("datamodel/pegawai/del_peg_perkawinan",$id_peg_perkawinan);
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

