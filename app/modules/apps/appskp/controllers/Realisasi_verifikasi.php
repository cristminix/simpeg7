<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Realisasi_verifikasi extends MX_Controller {

  function __construct(){
    parent::__construct();
	$this->load->model('appskp/m_skp');
  }

  function index(){
	$data['satu'] = "Verifikasi Realisasi Sasaran Kerja Pegawai";
		$data['unor_akses'] = $this->session->userdata('unor_akses');
		$id_pegawai = $this->session->userdata('verifikatur_info');
	$data['verifikatur'] = $this->m_skp->get_pegawai($id_pegawai);
    $this->load->view('realisasi_verifikasi/index', $data);    
  }
	function getdata(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skp->hitung_realisasi_verifikasi($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$bulan = $this->dropdowns->bulan();
			$tahapan_skp = $this->dropdowns->tahapan_realisasi();
			$data['hslquery'] = $this->m_skp->get_realisasi_verifikasi($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					@$data['hslquery'][$key]->bulan_mulai = $bulan[$val->bulan_mulai];
					@$data['hslquery'][$key]->bulan_selesai = $bulan[$val->bulan_selesai];
					@$data['hslquery'][$key]->status = $tahapan_skp[$val->status];
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					$data['hslquery'][$key]->penilai_nama_pegawai = ((trim($val->penilai_gelar_depan) != '-')?trim($val->penilai_gelar_depan).' ':'').((trim($val->penilai_gelar_nonakademis) != '-')?trim($val->penilai_gelar_nonakademis).' ':'').$val->penilai_nama_pegawai.((trim($val->penilai_gelar_belakang) != '-')?', '.trim($val->penilai_gelar_belakang):'');
				}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
	function target(){
		$data['satu'] = "Verifikasi Realisasi Sasaran Kerja Pegawai";
		$idk = $this->session->userdata('idskp');
        $this->session->set_userdata("id_skp",$idk);
		$data['id_skp'] = $this->session->userdata('id_skp');

		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['penilai'] = $this->m_skp->get_pegawai($data['skp']->id_penilai);
		$data['pegawai'] = $this->m_skp->get_pegawai($data['skp']->id_pegawai);
		$data['target'] = $this->m_skp->get_target($data['id_skp']);
			foreach($data['target'] AS $key=>$val){
				$data['realisasi'][$key] = $this->m_skp->get_realisasi($val->id_target);
			}

		$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($data['id_skp']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();
		$this->load->view('realisasi_verifikasi/target',$data);
	}
	function form_kembalikan_skp()
	{
		$data['id_skp'] = $this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($data['id_skp']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();
		$this->load->view('realisasi_verifikasi/form_kembalikan_skp',$data);
	}

	function kembalikan_skp_aksi()
	{
		$data['id_skp'] = $this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['skp']->pelaku = "acc_verifikatur";

		$this->m_skp->kembalikan_realisasi_verifikatur_aksi($data['skp']);
	}

	function form_acc_skp()
	{
		$data['id_skp'] = $this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($data['id_skp']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();
		$this->load->view('realisasi_verifikasi/form_acc_skp',$data);
	}

	function acc_skp_aksi()
	{
		$data['id_skp'] = $this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['skp']->pelaku = "acc_verifikatur";

		$this->m_skp->acc_realisasi_verifikatur_aksi($data['skp']);
	}

	function formacc_tugas_pokok()
	{
		$data['idd'] = $_POST['idd'];
		$this->load->view('skp_verifikasi/form_target_acc',$data);
	}
	function formkomentar_tugas_pokok()
	{
		$data['idd'] = $_POST['idd'];
		$data['komentar'] = $this->m_skp->get_komentar($_POST['idd']);
		$this->load->view('skp_verifikasi/formkomentar',$data);
	}
	function target_acc()
	{
//		$this->m_skp->target_acc($_POST);
		echo "success";
	}
}
?>