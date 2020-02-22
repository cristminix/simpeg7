<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Realisasi extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
	}

	function index()
	{
		$data['satu'] = "Penyusunan Realisasi Sasaran Kerja Pegawai";
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
			$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($id_skp);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();
			$data['avail'] = ($data['realisasi_tahapan']->status=="draft" or $data['realisasi_tahapan']->status=="revisi_penilai" or $data['realisasi_tahapan']->status=="revisi_verifikatur")?"":"disabled=\"\"";

			$data['target'] = $this->m_skp->get_target($id_skp);
			foreach($data['target'] AS $key=>$val){
				$data['realisasi'][$key] = $this->m_skp->get_realisasi($val->id_target);
			}
			$this->load->view('realisasi/index',$data);
		} else {
			$this->load->view('realisasi/index_kosong',$data);
		}
	}

	function form_skp_ajupenilai()
	{
		$data['idd'] = $_POST['idd'];
		if($_POST['idd']!="xx"){
			$data['skp'] = $this->m_skp->ini_skp($_POST['idd']);
			$data['realisasi'] = $this->m_skp->ini_realisasi($_POST['idd']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
		}
			$data['isi'] = "ada";
			$data['target'] = $this->m_skp->get_target($_POST['idd']);
			foreach($data['target'] AS $key=>$val){
				$isini = $this->m_skp->get_realisasi($val->id_target);
				if(empty($isini)){$data['isi']="kosong";}
			}
		$this->load->view('realisasi/form_skp_ajupenilai',$data);
	}

	function aju_penilai()
	{
		$ddir=$this->m_skp->realisasi_aju_penilai($_POST);
		$this->session->set_userdata("idskp",$_POST['id_skp']);
		echo json_encode($ddir);
	}

	function track()
	{
		$id_skp = $this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($id_skp);
		$data['realisasi'] = $this->m_skp->ini_realisasi($id_skp);
				$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
				$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
				$tahapan_skp_nomor = $this->dropdowns->tahapan_skp_nomor();
				$data['tahapan_skp_nomor'] = $tahapan_skp_nomor[$data['realisasi']->status];
		$this->load->view('realisasi/track',$data);
	}

	function arsip()
	{
		$id_pegawai = $this->session->userdata('pegawai_info');
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
		$data['skp'] = $this->m_skp->get_skp($id_pegawai);
		foreach($data['skp'] AS $key=>$val)
		{
			$real = $this->m_skp->ini_realisasi($val->id_skp);
			@$data['skp'][$key]->realisasi_tahapan = $real->status;
		}


				$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
		$this->load->view('realisasi/arsip',$data);
	}

	function ipt_realisasi(){
 		$this->form_validation->set_rules("nilai","Realisasi","required|numeric|xss_clean");
		if($this->form_validation->run())
		{
			$hasil = $this->m_skp->realisasi_aksi($_POST);
			$data['pesan']="sukses";
			$data['isi']=($_POST['nama']=="biaya")?number_format($hasil->$_POST['nama'],2,"."," "):$hasil->$_POST['nama'];
		}
		else
		{
			$data['pesan']="Inputan harus berupa angka\n(Hanya Angka Saja)";
		}
		echo json_encode($data);
	}
	function formkomentar_tugas_pokok()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_pokok";
		$data['komentar'] = $this->m_skp->get_realisasi_komentar('tugas_pokok',$_POST['idd']);
		$this->load->view('realisasi/formkomentar',$data);
	}

	function lembar_kreatifitas(){
		$data['satu'] = "RRR";
		$id_skp = $this->session->userdata('id_skp');
		$data['kreatifitas'] = $this->m_skp->get_kreatifitas($id_skp);
		$this->load->view('realisasi/lembar_kreatifitas',$data);
	}
	function formtambah_kreatifitas(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['ini'] = $_POST['ini'];
		$data['nomor'] = $_POST['nomor'];

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$realisasi_tahapan = $this->m_skp->ini_realisasi($data['id_skp']);
		$data['avail'] = ($realisasi_tahapan->status=="draft" or $realisasi_tahapan->status=="revisi_penilai" or $realisasi_tahapan->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('realisasi/formtambah_kreatifitas',$data);
	}
	function kreatifitas_tambah_aksi(){
		$ipt = $this->input->post();
		$ipt['tanggal_sk'] = date("Y-m-d", strtotime($ipt['tanggal_sk']));
		$this->m_skp->kreatifitas_tambah_aksi($ipt);
		echo "success";
	}
	function formedit_kreatifitas(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];

		$data['kreatifitas'] = $this->m_skp->ini_kreatifitas($data['idd']);

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$realisasi_tahapan = $this->m_skp->ini_realisasi($data['id_skp']);
		$data['avail'] = ($realisasi_tahapan->status=="draft" or $realisasi_tahapan->status=="revisi_penilai" or $realisasi_tahapan->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('realisasi/formedit_kreatifitas',$data);
	}
	function kreatifitas_edit_aksi(){
		$ipt = $this->input->post();
		$ipt['tanggal_sk'] = date("Y-m-d", strtotime($ipt['tanggal_sk']));
		$this->m_skp->kreatifitas_edit_aksi($ipt);
		echo "success";
	}
	function formhapus_kreatifitas(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];

		$data['kreatifitas'] = $this->m_skp->ini_kreatifitas($data['idd']);

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$realisasi_tahapan = $this->m_skp->ini_realisasi($data['id_skp']);
		$data['avail'] = ($realisasi_tahapan->status=="draft" or $realisasi_tahapan->status=="revisi_penilai" or $realisasi_tahapan->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('realisasi/formhapus_kreatifitas',$data);
	}
	function kreatifitas_hapus_aksi(){
		$ipt = $this->input->post();
		$this->m_skp->kreatifitas_hapus_aksi($ipt);
		echo "success";
	}
	function formkomentar_kreatifitas()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "kreatifitas";
		$data['komentar'] = $this->m_skp->get_realisasi_komentar('kreatifitas',$_POST['idd']);

		$this->load->view('realisasi/formkomentar',$data);
	}

	function lembar_tugas_tambahan(){
		$data['satu'] = "RRR";
		$id_skp = $this->session->userdata('id_skp');
		$data['ttambahan'] = $this->m_skp->get_tugas_tambahan($id_skp);

		$this->load->view('realisasi/lembar_tugas_tambahan',$data);
	}
	function formtambah_tugas_tambahan(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['ini'] = $_POST['ini'];
		$data['nomor'] = $_POST['nomor'];

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$realisasi_tahapan = $this->m_skp->ini_realisasi($data['id_skp']);
		$data['avail'] = ($realisasi_tahapan->status=="draft" or $realisasi_tahapan->status=="revisi_penilai" or $realisasi_tahapan->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('realisasi/formtambah_tugas_tambahan',$data);
	}
	function tugas_tambahan_tambah_aksi(){
		$ipt = $this->input->post();
		$ipt['tanggal_sp'] = date("Y-m-d", strtotime($ipt['tanggal_sp']));
		$this->m_skp->tugas_tambahan_tambah_aksi($ipt);
		echo "success";
	}
	function formedit_tugas_tambahan(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];

		$data['tambahan'] = $this->m_skp->ini_tugas_tambahan($data['idd']);

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$realisasi_tahapan = $this->m_skp->ini_realisasi($data['id_skp']);
		$data['avail'] = ($realisasi_tahapan->status=="draft" or $realisasi_tahapan->status=="revisi_penilai" or $realisasi_tahapan->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('realisasi/formedit_tugas_tambahan',$data);
	}
	function tugas_tambahan_edit_aksi(){
		$ipt = $this->input->post();
		$ipt['tanggal_sp'] = date("Y-m-d", strtotime($ipt['tanggal_sp']));
		$this->m_skp->tugas_tambahan_edit_aksi($ipt);
		echo "success";
	}
	function formhapus_tugas_tambahan(){
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];

		$data['tambahan'] = $this->m_skp->ini_tugas_tambahan($data['idd']);

		$skp = $this->m_skp->ini_skp($data['id_skp']);
		$realisasi_tahapan = $this->m_skp->ini_realisasi($data['id_skp']);
		$data['avail'] = ($realisasi_tahapan->status=="draft" or $realisasi_tahapan->status=="revisi_penilai" or $realisasi_tahapan->status=="revisi_verifikatur")?"yes":"no";

		$this->load->view('realisasi/formhapus_tugas_tambahan',$data);
	}
	function tugas_tambahan_hapus_aksi(){
		$ipt = $this->input->post();
		$this->m_skp->tugas_tambahan_hapus_aksi($ipt);
		echo "success";
	}
	function formkomentar_tugas_tambahan()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_tambahan";
		$data['komentar'] = $this->m_skp->get_realisasi_komentar('tugas_tambahan',$_POST['idd']);

		$this->load->view('realisasi/formkomentar',$data);
	}
	function lembar_perilaku(){
		$id_skp = $this->session->userdata('id_skp');
		$data['perilaku'] = $this->m_skp->get_perilaku($id_skp);
		if(!empty($data['perilaku'])){
			$data['perilaku']->kat_pelayanan = ($data['perilaku']->pelayanan!=0)?$this->kat_perilaku($data['perilaku']->pelayanan):"--";
			$data['perilaku']->kat_integritas = ($data['perilaku']->integritas!=0)?$this->kat_perilaku($data['perilaku']->integritas):"--";
			$data['perilaku']->kat_komitmen = ($data['perilaku']->komitmen!=0)?$this->kat_perilaku($data['perilaku']->komitmen):"--";
			$data['perilaku']->kat_disiplin = ($data['perilaku']->disiplin!=0)?$this->kat_perilaku($data['perilaku']->disiplin):"--";
			$data['perilaku']->kat_kerjasama = ($data['perilaku']->kerjasama!=0)?$this->kat_perilaku($data['perilaku']->kerjasama):"--";
			$data['perilaku']->kat_kepemimpinan = ($data['perilaku']->kepemimpinan!=0)?$this->kat_perilaku($data['perilaku']->kepemimpinan):"--";
			$data['jumlah'] = $data['perilaku']->pelayanan+$data['perilaku']->integritas+$data['perilaku']->komitmen+$data['perilaku']->disiplin+$data['perilaku']->kerjasama+$data['perilaku']->kepemimpinan;
			$data['rerata'] = number_format($data['jumlah']/6, 2, ",", "");
			$data['kat_rerata'] = $this->kat_perilaku($data['rerata']);
			$data['nilai_perilaku'] = $data['rerata']*.4;
			$data['ada'] = "ya";
		} else {
			$data['jumlah'] = "--";
			$data['rerata'] = "--";
			$data['kat_rerata'] = "--";
			$data['nilai_perilaku'] = "--";
			$data['ada'] = "tidak";
		}
		$this->load->view('realisasi/lembar_perilaku',$data);
	}

	function kat_perilaku($nperilaku)
	{
		$nperilaku = (int)$nperilaku;
		if($nperilaku > 0)
		{
			switch ($nperilaku):
				case ($nperilaku>=91 && $nperilaku<=100):
					$kat = "Sangat Baik";
					break;
				case ($nperilaku>=76 && $nperilaku<=90):
					$kat = "Baik";
					break;
				case ($nperilaku>=61 && $nperilaku<=75):
					$kat = "Cukup";
					break;
				case ($nperilaku>=51 && $nperilaku<=60):
					$kat = "Kurang";
					break;
				case ($nperilaku<=50):
					$kat = "Buruk";
					break;
			endswitch;
		}
		else
		{
			$kat = "-";
		}
		return $kat;
	}

}
?>