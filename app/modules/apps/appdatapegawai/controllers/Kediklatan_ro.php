<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Kediklatan_ro extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function view($id_pegawai=false,$content=array()){
		$content['id_pegawai'] = $id_pegawai;
		$content['data'] = Modules::run("datamodel/pegawai/get_riwayat_diklat",$id_pegawai);
		$content['panel_body'] = $this->load->view('kediklatan/panel_body',$content,true);
		$content['datalama'] = $this->getdatalama($id_pegawai);


		$this->load->view('kediklatan/default',$content);
	}
	function getdatalama($id_pegawai=false){

    // $content['data'] = Modules::run("datamodel/pegawai/get_riwayat_pangkat_lama",$id_pegawai);
    $content['data'] = Modules::run("datamodel/pegawai/get_riwayat_diklat",$id_pegawai);

		return $this->load->view('kediklatan/datalama',$content,true);

  }
	function form($id_pegawai=false,$id_peg_golongan=false){
		$content['id_pegawai'] = $id_pegawai;
		$content['id_peg_golongan'] = $id_peg_golongan;
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_pkt",$id_peg_golongan);
		
		$this->load->view('kediklatan/form',$content);
	}
	function save($id_pegawai=false,$id_peg_golongan=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_pkt",$id_pegawai,$id_peg_golongan,$data);
		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
    }
    $this->view($id_pegawai,$content);
	}
	function del($id_pegawai=false,$id_peg_golongan=false){
		$result = Modules::run("datamodel/pegawai/del_peg_pkt",$id_peg_golongan);
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