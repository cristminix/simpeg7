<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Kontrak extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function view($id_pegawai=false){
		$content['id_pegawai'] = $id_pegawai;
		$content['data'] = Modules::run("datamodel/pegawai/get_peg_kontrak",$id_pegawai);
		// $this->load->view('kontrak/default',$content);
		$this->load->view('kontrak/list',$content);
		
	}
	function save($id_pegawai=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_kontrak",$id_pegawai,$data);
		if($result)
		{
			echo '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
		}else
		{
			echo '<div class="alert alert-warning pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
		}
	}
}
?>