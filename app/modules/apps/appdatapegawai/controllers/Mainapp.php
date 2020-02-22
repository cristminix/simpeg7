<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mainapp extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	public function getprofile()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		echo Modules::run("appdatapegawai/profile/index",$id_pegawai);
	}
	public function gettab()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai);
	}
	public function getform()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$ID = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$ID);
	}
	public function submitform()
	{
		$id_pegawai = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		$data = $this->input->post();
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$data);
		// echo json_encode($this->input->post());
	}
	public function submitformriwayat()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$ID = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		$data = $this->input->post();
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$ID,$data);
		// echo json_encode($this->input->post());
	}
	public function del()
	{
		$id_pegawai = $this->input->post('id_pegawai');
		$ID = $this->input->post('ID');
		$m = $this->input->post('m');
		$f = $this->input->post('f');
		echo Modules::run("appdatapegawai/".$m."/".$f,$id_pegawai,$ID);
		// echo json_encode($this->input->post());
	}
}
?>