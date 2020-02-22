<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Sk_jabatan extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appdok/m_edok');
		$this->load->model('appbkpp/m_pegawai');
		$this->load->model('appbkpp/m_unor');
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
	function edit(){
		$data['idd'] = $_POST['idd'];
		$data['val'] = $this->m_pegawai->ini_jabatan_riwayat($data['idd']);
		$jab = $this->m_unor->ini_unor($data['val']->id_unor);
		$data['val']->nama_jab_struk = $jab->nomenklatur_jabatan;
		$data['val']->sk_tanggal = date("d-m-Y", strtotime($data['val']->sk_tanggal));
		$data['val']->tmt_jabatan = date("d-m-Y", strtotime($data['val']->tmt_jabatan));
		$this->load->view('sk_jabatan/form',$data);
	}

	function hapus(){
		$data['idd'] = $_POST['idd'];
		$data['val'] = $this->m_pegawai->ini_jabatan_riwayat($data['idd']);
		$jab = $this->m_unor->ini_unor($data['val']->id_unor);
		$data['val']->nama_jab_struk = $jab->nomenklatur_jabatan;
		$data['val']->sk_tanggal = date("d-m-Y", strtotime($data['val']->sk_tanggal));
		$data['val']->tmt_jabatan = date("d-m-Y", strtotime($data['val']->tmt_jabatan));
		$data['hapus'] = "ya";
		$this->load->view('sk_jabatan/form',$data);
	}

	function tambah(){
		@$data['val']->id_pegawai = $_POST['id_pegawai'];
		$this->load->view('sk_jabatan/form',$data);
	}

	function uploadDok(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['idd'] = $_POST['idd'];
		$data['komponen'] = $_POST['komponen'];
		$data['isi'] = $this->m_pegawai->ini_jabatan_riwayat($_POST['idd']);
		$data['row'] = $this->m_edok->cek_dokumen($_POST['id_pegawai'],$_POST['komponen'],$_POST['idd']);
		$this->load->view('sk_jabatan/upload',$data);
	}

}
?>