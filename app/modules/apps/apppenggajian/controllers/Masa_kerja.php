<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Masa_kerja extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('apppenggajian/m_masa_kerja');
		date_default_timezone_set('UTC');
	}


	function index(){
		$data['satu'] = "Master Masa Kerja";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"x";
		$this->load->view('masa_kerja/index',$data);
	}
	function getdata(){
		$tipe = $_POST['tipe'];	
		// $data['judul'] = $judul[$tipe];

		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$data['count'] = $this->m_masa_kerja->hitung_masa_kerja($cari,$tipe);
	
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_masa_kerja->get_masa_kerja($cari,$mulai,$batas,$tipe);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_masa_kerja->ini_masa_kerja($data['idd']);
		$this->load->view('masa_kerja/formedit',$data);
	}
	function edit_aksi(){
        $this->form_validation->set_rules("masa_kerja","Masa Kerja","trim|required|xss_clean");
        if($this->form_validation->run()) {
			$ddir=$this->m_masa_kerja->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah(){
		$data['tipe'] = $_POST['tipe'];
		$this->load->view('masa_kerja/formtambah',$data);
	}
	function tambah_aksi(){
        $this->form_validation->set_rules("masa_kerja","Masa Kerja","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_masa_kerja->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapus(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_masa_kerja->ini_masa_kerja($data['idd']);
		$this->load->view('masa_kerja/formhapus',$data);
	}
	
	function hapus_aksi(){
			$ddir=$this->m_masa_kerja->hapus_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>