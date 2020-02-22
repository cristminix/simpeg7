<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Sertifikat_kursus extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appdok/m_edok');
		$this->load->model('appbkpp/m_pegawai');
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
	function edit(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['isi'] = $this->m_pegawai->ini_sertifikat_kursus($_POST['idd']);
		$this->load->view('sertifikat_kursus/form',$data);
	}

	function hapus(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['isi'] = $this->m_pegawai->ini_sertifikat_kursus($_POST['idd']);
		$data['hapus'] = "ya";
		$this->load->view('sertifikat_kursus/form',$data);
	}

	function tambah(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$this->load->view('sertifikat_kursus/form',$data);
	}

	function uploadDok(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['idd'] = $_POST['idd'];
		$data['komponen'] = $_POST['komponen'];
		$data['isi'] = $this->m_pegawai->ini_sertifikat_kursus($_POST['idd']);
		$data['row'] = $this->m_edok->cek_dokumen($_POST['id_pegawai'],$_POST['komponen'],$_POST['idd']);
		$this->load->view('sertifikat_kursus/upload',$data);
	}

}
?>