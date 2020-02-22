<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verifikatur extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
		$this->load->model('appskp/m_skpd');
	}	

	function index(){
		$data['satu'] = "Informasi Verifikatur";
		$this->load->view('verifikatur/index',$data);
	}

	function unor(){
		$data['satu'] = "Daftar Unit Kerja Verifikatur";
		$id_pegawai = $this->session->userdata('verifikatur_info');
		$data['verifikatur'] = $this->m_skp->get_pegawai($id_pegawai);
		$this->load->view('verifikatur/unor',$data);
	}
	function row_unor(){
		$idd = $this->session->userdata('verifikatur_info');
		$user = $this->m_skpd->get_verifikatur_idpegawai($idd);
		$verifikatur = $this->m_skpd->ini_verifikatur($user->user_id);
			$dd=array("{","}");
		$unorin = ($verifikatur->unor_akses=="{}")?"00":str_replace($dd,"",$verifikatur->unor_akses);
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skpd->hitung_verifikatur_lihat($cari,$unorin);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_skpd->verifikatur_lihat($cari,$unorin,$mulai,$batas);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function arsip(){
		$data['satu'] = "Arsip SKP Terverifikasi";
		$id_pegawai = $this->session->userdata('verifikatur_info');
		$data['verifikatur'] = $this->m_skp->get_pegawai($id_pegawai);
		$this->load->view('verifikatur/arsip',$data);
	}

}