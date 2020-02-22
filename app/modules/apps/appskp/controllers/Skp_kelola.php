<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Skp_kelola extends MX_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('appskp/m_skp');
		// $this->load->model('appskp/dropdowns');
	}

	function index()
	{
		$id_pegawai = $this->session->userdata('pegawai_info');

		$data['satu'] = "Persetujuan Target Sasaran Kerja Pegawai";
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
		$data['skp'] = $this->m_skp->get_skp_kelola($id_pegawai);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();

		$this->load->view('skp_kelola/index',$data);
	}
	function acc()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		$this->load->view('skp_kelola/form_acc',$data);
	}
	function form_kembalikan()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		$this->load->view('skp_kelola/form_kembalikan_skp',$data);
	}
	function kembali_aksi()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['skp']->pelaku = "revisi_penilai";
		$this->m_skp->kembali_aksi($data['skp']);
	}
	function form_acc()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		$this->load->view('skp_kelola/form_acc_skp',$data);
	}
	function acc_penilai_aksi()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['skp']->pelaku = "aju_verifikatur";
		$this->m_skp->acc_skp_penilai_aksi($data['skp']);
	}
////////////////////////////////////////////////////////////////////////////////
	function alih()
	{
        $this->session->set_userdata("id_skp",$this->uri->segment(4));
		redirect(site_url("admin/module/appskp/skp_kelola/target"));
	}
////////////////////////////////////////////////////////////////////////////////
	function target()
	{
		$data['satu'] = "Persetujuan Target Sasaran Kerja Pegawai";

		$data['id_skp'] = $this->session->userdata('id_skp');
		$id_penilai = $this->session->userdata('pegawai_info');

		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['penilai'] = $this->m_skp->get_pegawai($id_penilai);
		$data['pegawai'] = $this->m_skp->get_pegawai($data['skp']->id_pegawai);
		$data['target'] = $this->m_skp->get_target($data['id_skp']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();
		$this->load->view('skp_kelola/target',$data);
	}
	function form_target_acc()
	{
		$data['idd'] = $_POST['idd'];
		$this->load->view('skp_kelola/form_target_acc',$data);
	}
	function target_acc()
	{
		$this->m_skp->target_acc($_POST);
	}
	function target_koreksi()
	{
		$id_skp = $this->session->userdata('id_skp');
		$id_penilai = $this->session->userdata('pegawai_info');

		$this->m_skp->target_koreksi($_POST,$id_penilai,$id_skp);

		echo "success";
	}













	function santunnya(){
		$id_pegawai = $this->session->userdata('pegawai_info');

		$data['satu'] = "Penyusunan Target Sasaran Kerja Pegawai";
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
		$data['skp'] = $this->m_skp->get_skp($id_pegawai);

		$this->load->view('skp_kelola/santun',$data);
	}

	function form(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		if($_POST['idd']!="xx"){
			$data['isi'] = $this->m_skp_kelola->ini_skp($_POST['idd']);
			$penilai = $this->m_skp_kelola->get_penilai($data['isi']->id_penilai);
			$data['isi']->penilai = $penilai[0]->nip_baru;
		}
		$this->load->view('skp_kelola/form',$data);
	}

	function form_aksi(){
 		$this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
		if($this->form_validation->run()) {

		$pegawai = $this->session->userdata('pegawai_info');
		$penilai = $this->m_skp_kelola->get_penilai_by_nip($_POST['penilai']);
		$bulan = $this->dropdowns->bulan();

			if($_POST['id_skp']==""){
				$ddir=$this->m_skp_kelola->tambah_aksi($_POST,$pegawai->id_pegawai,$penilai->id_pegawai);
				$data = $this->m_skp_kelola->ini_skp($ddir[0]->id_skp);
				$data->aksi="tambah";
			} else {
				$ddir=$this->m_skp_kelola->edit_aksi($_POST,$penilai->id_pegawai);
				$data = $this->m_skp_kelola->ini_skp($_POST['id_skp']);
				$data->aksi="edit";
			}

				$penilai = $this->m_skp_kelola->get_pegawai($data->id_pegawai);
				$gelardepan=($penilai[0]->gelar_depan=="-" || $penilai[0]->gelar_depan=="")?"":$penilai[0]->gelar_depan." ";
				$gelarbelakang=($penilai[0]->gelar_belakang=="-" || $penilai[0]->gelar_belakang=="")?"":", ".$penilai[0]->gelar_belakang;
				$data->nama_penilai = $gelardepan.$penilai[0]->nama_pegawai.$gelarbelakang;
				$data->nip_penilai = $penilai[0]->nip_baru;
				$data->pangkat_penilai = $penilai[0]->nama_pangkat." / ".$penilai[0]->nama_golongan;
				$data->jabatan_penilai = $penilai[0]->nomenklatur_jabatan;
				$data->bulan_mulai = $bulan[$data->bulan_mulai];
				$data->bulan_selesai = $bulan[$data->bulan_selesai];

			echo json_encode($data);
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function hapus_aksi(){
		$ddir=$this->m_skp_kelola->hapus_aksi($_POST);
	}


}
?>