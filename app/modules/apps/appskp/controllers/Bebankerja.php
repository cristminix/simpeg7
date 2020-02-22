<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bebankerja extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('m_bebankerja');
		// $this->load->model('appskp/dropdowns');
	}	

	function index(){
		$data['satu'] = "Beban kerja pegawai";
		$this->load->view('bebankerja/index',$data);
	}

	function pilih_jabatan(){
		$data['jform']="Pilih Unit Organisasi";
		$this->load->view('daftar_jabatan',$data);
	}

	function gettupoksi(){
		$idd = $_POST['id_unor'];
		$jenis = $_POST['jenis'];

		$data['rincian'] = $this->m_bebankerja->get_tupoksi($idd,'rincian',$jenis);
		$data['pengemban'] = $this->m_bebankerja->detail_unor($idd,$jenis);
		echo json_encode($data);
	}

}