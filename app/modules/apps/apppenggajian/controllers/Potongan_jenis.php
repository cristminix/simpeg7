<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Potongan_jenis extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('apppenggajian/m_potongan_jenis');
		date_default_timezone_set('UTC');
	}


	function index(){
		$data['satu'] = "Master Potongan Jenis";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"x";
		$this->load->view('potongan_jenis/index',$data);
	}
	function getdata(){
		$tipe = $_POST['tipe'];	
		// $data['judul'] = $judul[$tipe];

		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$data['count'] = $this->m_potongan_jenis->hitung_potongan_jenis($cari,$tipe);
	
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_potongan_jenis->get_potongan_jenis($cari,$mulai,$batas,$tipe);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_potongan_jenis->ini_potongan_jenis($data['idd']);
		$this->load->view('potongan_jenis/formedit',$data);
	}
	function edit_aksi(){
        $this->form_validation->set_rules("potongan_jenis","Potongan Jenis","trim|required|xss_clean");
        if($this->form_validation->run()) {
			$ddir=$this->m_potongan_jenis->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah(){
		$data['tipe'] = $_POST['tipe'];
		$this->load->view('potongan_jenis/formtambah',$data);
	}
	function tambah_aksi(){
        $this->form_validation->set_rules("potongan_jenis","Potongan Jenis","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_potongan_jenis->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapus(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_potongan_jenis->ini_potongan_jenis($data['idd']);
		$this->load->view('potongan_jenis/formhapus',$data);
	}
	
	function hapus_aksi(){
			$ddir=$this->m_potongan_jenis->hapus_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>