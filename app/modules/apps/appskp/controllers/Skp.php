<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Skp extends MX_Controller {

	function __construct(){
		parent::__construct();
//		$this->load->library('curl');
		$this->load->model('appskp/m_skp');
//		 $this->load->model('appskp/skp_dropdowns');
//		$this->load->model('datamodel/pegawai__model','m_pegawai');
	}


	function index(){
		$data['satu'] = "Penyusunan Target Sasaran Kerja Pegawai";
		$id_pegawai = $this->session->userdata('pegawai_info');
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);

		$skp = $this->m_skp->get_skp($id_pegawai);
		if(!empty($skp)){
			$idskp = $this->session->userdata('idskp');
			if($idskp==""){
				$pilih = end($skp);
				$this->session->set_userdata("id_skp",$pilih->id_skp);
			} else {
				$this->session->set_userdata("id_skp",$idskp);
			}
			$this->session->set_userdata("idskp","");
			$id_skp = $this->session->userdata('id_skp');
			$data['id_skp'] = $id_skp;
			$data['skp'] = $this->m_skp->ini_skp($id_skp);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();
			$data['target'] = $this->m_skp->get_target($id_skp);
		} else {
			$data['id_skp'] = "xx";
		}

		$this->load->view('skp/index',$data);
	}

	function baru(){
		$data['idB'] = "baru";
		$this->load->view('skp/form_skp',$data);
	}

	function form_skp(){
		$data['idd'] = $_POST['idd'];
		if($_POST['idd']!="xx"){
			$data['isi'] = $this->m_skp->ini_skp($_POST['idd']);
			$penilai = $this->m_skp->get_pegawai($data['isi']->id_penilai);
			$data['isi']->penilai = $penilai->nip_baru;
		}
		$this->load->view('skp/form_skp',$data);
	}

	function form_aksi_skp(){
 		$this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
 		$this->form_validation->set_rules("bulan_mulai","Bulan Awal Periode","trim|required|xss_clean");
 		$this->form_validation->set_rules("bulan_selesai","Bulan Akhir Periode","trim|required|xss_clean");
		if($this->form_validation->run()) {

			$id_pegawai = $this->session->userdata('pegawai_info');
			$pegawai = $this->m_skp->get_pegawai($id_pegawai);
			$penilai = $this->m_skp->get_pegawai_by_nip($_POST['penilai']);
			$bulan = $this->dropdowns->bulan();

			if($_POST['id_skp']==""){
				$ddir=$this->m_skp->set_skp($_POST,$pegawai,$penilai);
				$data = $this->m_skp->ini_skp($ddir);
				$data->aksi="tambah";
			} else {
				$ddir=$this->m_skp->set_skp($_POST,$pegawai,$penilai);
				$data = $this->m_skp->ini_skp($_POST['id_skp']);
				$this->session->set_userdata("idskp",$_POST['id_skp']);
				$data->aksi="edit";
			}

				$data->nama_penilai = ((trim($data->penilai_gelar_depan) != '-')?trim($data->penilai_gelar_depan).' ':'').$data->penilai_nama_pegawai.((trim($data->penilai_gelar_belakang) != '-')?', '.trim($data->penilai_gelar_belakang):'');
				$data->bulan_mulai = $bulan[$data->bulan_mulai];
				$data->bulan_selesai = $bulan[$data->bulan_selesai];
			echo json_encode($data);
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function form_skp_hapus(){
		if($_POST['idd']!="xx"){
			$data['skp'] = $this->m_skp->ini_skp($_POST['idd']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		}
		$data['target'] = $this->m_skp->get_target($_POST['idd']);
		$this->load->view('skp/form_skp_hapus',$data);
	}
	function hapus_skp()
	{
		$ddir=$this->m_skp->hapus_skp($_POST);
		echo json_encode($ddir);
	}
	function form_skp_ajupenilai(){
		$data['idd'] = $_POST['idd'];
		if($_POST['idd']!="xx"){
			$data['skp'] = $this->m_skp->ini_skp($_POST['idd']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		}
		$data['target'] = $this->m_skp->get_target($_POST['idd']);
		$this->load->view('skp/form_skp_ajupenilai',$data);
	}
	function aju_penilai()
	{
		$ddir=$this->m_skp->aju_penilai($_POST);
		$this->session->set_userdata("idskp",$_POST['id_skp']);
		echo json_encode($ddir);
	}
	function arsip(){
		$id_pegawai = $this->session->userdata('pegawai_info');
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
		$data['skp'] = $this->m_skp->get_skp($id_pegawai);
				$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		$this->load->view('skp/arsip',$data);
	}
	function track()
	{
		$id_skp = $this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($id_skp);
				$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
				$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
				$tahapan_skp_nomor = $this->dropdowns->tahapan_skp_nomor();
				$data['tahapan_skp_nomor'] = $tahapan_skp_nomor[$data['skp']->status];
		$this->load->view('skp/track',$data);
	}
	function riwayat_pangkat()
	{
		$data['nama'] = ($_POST['orang']=="penilai")?"Pejabat Penilai":"Pegawai Yang Dinilai";
		$data['orang'] = $_POST['orang'];
	
		$id_skp = $this->session->userdata('id_skp');
		$skp = $this->m_skp->ini_skp($id_skp);
		$idPegawai = ($_POST['orang']=="penilai")?$skp->id_penilai:$skp->id_pegawai;
		$data['riwayat'] = Modules::run("datamodel/pegawai/get_riwayat_pangkat",$idPegawai);

		$this->load->view('skp/riwayat_pangkat',$data);
	}
	function riwayat_jabatan()
	{
		$data['nama'] = ($_POST['orang']=="penilai")?"Pejabat Penilai":"Pegawai Yang Dinilai";
		$data['orang'] = $_POST['orang'];

		$id_skp = $this->session->userdata('id_skp');
		$skp = $this->m_skp->ini_skp($id_skp);
		$idPegawai = ($_POST['orang']=="penilai")?$skp->id_penilai:$skp->id_pegawai;
		$data['riwayat'] = Modules::run("datamodel/pegawai/get_riwayat_jabatan",$idPegawai);

		$this->load->view('skp/riwayat_jabatan',$data);
	}
	function jabatan_aksi()
	{
		echo "success";
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////
	function alih(){
        $this->session->set_userdata("id_skp",$this->uri->segment(4));
		redirect(site_url("admin/module/appskp/skp/target"));
	}
	function alih_skp(){
		$this->session->set_userdata("idskp",$_POST['idd']);
		echo "success";
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////
	function target_X(){
		$id_skp = $this->session->userdata('id_skp'); 
		$data['satu'] = "Penyusunan Target Sasaran Kerja Pegawai";
		$data['skp'] = $this->m_skp->ini_skp($id_skp);
		$data['target'] = $this->m_skp->get_target($id_skp);
		$this->load->view('skp/target',$data);
	}

	function formtambah(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['ini'] = $_POST['ini'];
		$data['nomor'] = $_POST['nomor'];

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$data['avail'] = ($skp->status=="draft" or $skp->status=="revisi_penilai" or $skp->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('skp/form_target',$data);
	}

//////////////////edit item target
	function formedit(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$ini = explode("**",$_POST['ini']);
		$data['idd'] = $ini[0];
		$data['nomor'] = $ini[1];
		$data['isi'] = $this->m_skp->detail_target($data['idd']);

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$data['avail'] = ($skp->status=="draft" or $skp->status=="revisi_penilai" or $skp->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('skp/form_target',$data);
	}
//////////////////hapus item target
	function formhapus(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$ini = explode("**",$_POST['ini']);
		$data['idd'] = $ini[0];
		$data['nomor'] = $ini[1];
		$data['isi'] = $this->m_skp->detail_target($data['idd']);

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$data['avail'] = ($skp->status=="draft" or $skp->status=="revisi_penilai" or $skp->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('skp/form_target_hapus',$data);
	}
//////////////////lihat komentar item target
	function formkomentar(){
		$data['komentar'] = $this->m_skp->get_komentar($_POST['idd']);
		$this->load->view('skp/track_komentar',$data);
	}

	function edit_aksi(){
 		$this->form_validation->set_rules("target","Pekerjaan","trim|required|xss_clean");
 		$_POST['biaya'] = str_replace(" ","",trim($_POST['biaya']));
		if($this->form_validation->run()) {
			if($_POST['id_target']==""){
				$ddir=$this->m_skp->tambah_aksi($_POST);
				$data = $this->m_skp->detail_target($ddir[0]->id_target);
				$data[0]->biaya=number_format($data[0]->biaya,2,"."," ");
				$data[0]->aksi="tambah";
			} else {
				$ddir=$this->m_skp->edit_aksi($_POST); 
				$data = $this->m_skp->detail_target($_POST['id_target']);
				$data[0]->biaya=number_format($data[0]->biaya,2,"."," ");
				$data[0]->aksi="edit";
			}
			echo json_encode($data);
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function hapus_aksi(){
		$ddir=$this->m_skp->hapus_aksi($_POST);
		echo "success";
	}

/////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////
	function index_ASLI(){
//		$layer = $this->config->item('datalayer');
		$id_pegawai = $this->session->userdata('pegawai_info');

		$data['satu'] = "Penyusunan Target Sasaran Kerja Pegawai";
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
//		$data['pegawai_info'] = json_decode($this->curl->simple_get($layer.'skp/pegawai/'.$id_pegawai));
		$data['skp'] = $this->m_skp->get_skp($id_pegawai);
//		$data['skp'] = json_decode($this->curl->simple_get($layer.'skp/daftar/index/'.$id_pegawai));

//--< COBA LANGSUNG MENUJU LEMBAR TARGET SKP
			$pilih = end($data['skp']);
			redirect(site_url("appskp/skp/alih/".$pilih->id_skp));
//-->
		$this->load->view('skp/index',$data);
	}
//--< ASLI PAKAI DUA GRID
	function form(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		if($_POST['idd']!="xx"){
			$data['isi'] = $this->m_skp->ini_skp($_POST['idd']);
			$penilai = $this->m_skp->get_pegawai($data['isi']->id_penilai);
			
			$data['isi']->penilai = $penilai->nip_baru;
		}
		$this->load->view('skp/form',$data);
	}

	function form_aksi(){
 		$this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
		if($this->form_validation->run()) {

		$id_pegawai = $this->session->userdata('pegawai_info');
		$pegawai = $this->m_skp->get_pegawai($id_pegawai);
		$penilai = $this->m_skp->get_pegawai_by_nip($_POST['penilai']);
		$bulan = $this->dropdowns->bulan();

			if($_POST['id_skp']==""){
				$ddir=$this->m_skp->set_skp($_POST,$pegawai,$penilai);
				$data = $this->m_skp->ini_skp($ddir);
				$data->aksi="tambah";
			} else {
				$ddir=$this->m_skp->set_skp($_POST,$pegawai,$penilai);
				$data = $this->m_skp->ini_skp($_POST['id_skp']);
				$data->aksi="edit";
			}

				$data->nama_penilai = ((trim($data->penilai_gelar_depan) != '-')?trim($data->penilai_gelar_depan).' ':'').$data->penilai_nama_pegawai.((trim($data->penilai_gelar_belakang) != '-')?', '.trim($data->penilai_gelar_belakang):'');
				$data->bulan_mulai = $bulan[$data->bulan_mulai];
				$data->bulan_selesai = $bulan[$data->bulan_selesai];

			echo json_encode($data);
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
//-->
	////////////////// Ubah Data Pejabat Penilai
	function get_penilai_form()
	{
		$id_skp = $this->session->userdata('id_skp');
		
		$data['id_skp'] = $id_skp;
		$data['row'] = $this->m_skp->ini_skp($id_skp);
		
		$this->load->view('skp/form_penilai_pejabat',$data);
	}
	function pickerjabatan()
	{
    
		$content = array();
		$content['nomenklatur_cari'] = '';
		if($this->input->post('nomenklatur_cari'))
		{
			$nomenklatur_cari = $content['nomenklatur_cari'] = $this->input->post('nomenklatur_cari');
			$this->db->like('nomenklatur_cari',$nomenklatur_cari,'both');
			$this->db->order_by('kode_unor');
			$content['data'] = $this->db->get('m_unor')->result();
		}
		
		$this->load->view('skp/pickerjabatan',$content);
	}
	function save_penilai()
	{
		$id_skp = $this->session->userdata('id_skp');
		$post = $this->input->post();
		
		$ar_golongan = $this->dropdowns->kode_golongan_pangkat();
		$kode_golongan = $post['penilai_kode_golongan'];
		$golongan = explode(', ',$ar_golongan[$kode_golongan]);
		
		$data = array(
		'penilai_kode_golongan' => $kode_golongan,
		'penilai_nama_golongan' => $golongan[0],
		'penilai_nama_pangkat' => $golongan[1],
		'penilai_id_unor' => $post['penilai_id_unor'],
		'penilai_nomenklatur_jabatan' => $post['penilai_nomenklatur_jabatan'],
		'penilai_nomenklatur_pada' => $post['penilai_nomenklatur_pada'],
		// 'penilai_tugas_tambahan' => $post['penilai_tugas_tambahan'],
		'penilai_nama_ese' => $post['penilai_nama_ese'],
		);
		
		$result['success'] = $this->save_skp_penilai($id_skp,$data);
		
		echo json_encode($result);
	}
	function save_skp_penilai($id_skp=false,$data=array())
	{
		$skp = $this->m_skp->ini_skp($id_skp);
		$result = false;
		if($skp)
		{
			$this->db->where('id_skp',$id_skp);
			$result = $this->db->update('p_skp',$data);
			// $result = true;
		}
		
		return $result;
	}
	
}
?>