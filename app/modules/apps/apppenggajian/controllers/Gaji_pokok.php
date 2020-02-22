<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Gaji_pokok extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('apppenggajian/m_gaji_pokok');
		date_default_timezone_set('UTC');
	}


	function index(){
		$data['satu'] = "Master Gaji Pokok";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"jfu";
		$this->load->view('gaji_pokok/index',$data);
	}
	function getdata(){
		$tipe = $_POST['tipe'];	
		// $data['judul'] = $judul[$tipe];

		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$data['count'] = $this->m_gaji_pokok->hitung_gaji_pokok($cari,$tipe);
	
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_gaji_pokok->get_gaji_pokok($cari,$mulai,$batas,$tipe);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
			// $data['pager'] = Modules::run("apppenggajian/apppenggajian/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_gaji_pokok->ini_gaji_pokok($data['idd']);
		$this->load->view('gaji_pokok/formedit',$data);
	}
	function edit_aksi(){
        $this->form_validation->set_rules("kode_golongan","Nama Pangkat","trim|required|xss_clean");
        $this->form_validation->set_rules("masa_kerja","Masa Kerja","trim|required|xss_clean");
        $this->form_validation->set_rules("gaji_pokok","Gaji Pokok","trim|required|xss_clean");
        $this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
        // $this->form_validation->set_rules("status","Status","trim|required|xss_clean");
 		// $this->form_validation->set_rules("idd","ID Gaji Pokok","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_gaji_pokok->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah(){
		$data['tipe'] = $_POST['tipe'];
		$this->load->view('gaji_pokok/formtambah',$data);
	}
	function tambah_aksi(){
 		$this->form_validation->set_rules("kode_golongan","Nama Pangkat","trim|required|xss_clean");
        $this->form_validation->set_rules("masa_kerja","Masa Kerja","trim|required|xss_clean");
        $this->form_validation->set_rules("gaji_pokok","Gaji Pokok","trim|required|xss_clean");
        $this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
        // $this->form_validation->set_rules("status","Status","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_gaji_pokok->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapus(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_gaji_pokok->ini_gaji_pokok($data['idd']);
		$this->load->view('gaji_pokok/formhapus',$data);
	}
	function hapus_aksi(){
			$ddir=$this->m_gaji_pokok->hapus_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>