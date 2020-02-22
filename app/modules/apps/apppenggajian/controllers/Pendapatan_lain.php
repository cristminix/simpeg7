<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pendapatan_lain extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('apppenggajian/m_pendapatan_lain');
		date_default_timezone_set('UTC');
	}


	function index(){
		$data['satu'] = "Master Pendapatan Lain";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"x";
		$this->load->view('pendapatan_lain/index',$data);
	}
	function getdata(){
		$tipe = $_POST['tipe'];	
		// $data['judul'] = $judul[$tipe];

		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$data['count'] = $this->m_pendapatan_lain->hitung_pendapatan_lain($cari,$tipe);
	
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_pendapatan_lain->get_pendapatan_lain($cari,$mulai,$batas,$tipe);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_pendapatan_lain->ini_pendapatan_lain($data['idd']);
		$this->load->view('pendapatan_lain/formedit',$data);
	}
	function edit_aksi(){
        $this->form_validation->set_rules("pendapatan_lain","Pendapatan Lain","trim|required|xss_clean");
        if($this->form_validation->run()) {
			$ddir=$this->m_pendapatan_lain->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah(){
		$data['tipe'] = $_POST['tipe'];
		$this->load->view('pendapatan_lain/formtambah',$data);
	}
	function tambah_aksi(){
        $this->form_validation->set_rules("pendapatan_lain","Pendapatan Lain","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_pendapatan_lain->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapus(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_pendapatan_lain->ini_pendapatan_lain($data['idd']);
		$this->load->view('pendapatan_lain/formhapus',$data);
	}
	
	function hapus_aksi(){
			$ddir=$this->m_pendapatan_lain->hapus_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>