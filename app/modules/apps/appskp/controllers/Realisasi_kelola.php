<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Realisasi_kelola extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
		// $this->load->model('appskp/dropdowns');
	}

	function index()
	{
		$id_pegawai = $this->session->userdata('pegawai_info');

		$data['satu'] = "Persetujuan Realisasi Sasaran Kerja Pegawai";
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
		$data['skp'] = $this->m_skp->get_realisasi_kelola($id_pegawai);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
			$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
			$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();

		$this->load->view('realisasi_kelola/index',$data);
	}
////////////////////////////////////////////////////////////////////////////////
	function alih()
	{
        $this->session->set_userdata("id_skp",$this->uri->segment(4));
		redirect(site_url("admin/module/appskp/realisasi_kelola/target"));
	}
////////////////////////////////////////////////////////////////////////////////
	function target()
	{
		$data['satu'] = "Persetujuan Realisasi Sasaran Kerja Pegawai";

		$data['id_skp'] = $this->session->userdata('id_skp');
		$id_penilai = $this->session->userdata('pegawai_info');

		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['penilai'] = $this->m_skp->get_pegawai($id_penilai);
		$data['pegawai'] = $this->m_skp->get_pegawai($data['skp']->id_pegawai);
		$data['target'] = $this->m_skp->get_target($data['id_skp']);
			foreach($data['target'] AS $key=>$val){
				$data['realisasi'][$key] = $this->m_skp->get_realisasi($val->id_target);
			}

		$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($data['id_skp']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();


		$this->load->view('realisasi_kelola/target',$data);
	}

	function form_kembalikan_skp()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($data['id_skp']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_realisasi();
		$this->load->view('realisasi_kelola/form_kembalikan_skp',$data);
	}
	function kembalikan_skp_aksi()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['skp']->pelaku = "revisi_penilai";
		$this->m_skp->kembalikan_realisasi_aksi($data['skp']);
//		echo "success";
	}
	function form_acc_skp()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['realisasi_tahapan'] = $this->m_skp->ini_realisasi($data['id_skp']);
			$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
			$data['perilaku'] = $this->m_skp->get_perilaku($data['id_skp']);

			$this->load->view('realisasi_kelola/form_acc_skp',$data);
	}
	function acc_skp_aksi()
	{
		$data['id_skp']=$this->session->userdata('id_skp');
		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['skp']->pelaku = "aju_verifikatur";
		$this->m_skp->acc_realisasi_aksi($data['skp']);
		echo "success";
	}
	function formacc_tugas_pokok()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_pokok";
		$this->load->view('realisasi_kelola/formacc',$data);
	}
	function acc_item_tugas_pokok()
	{
		$this->m_skp->acc_item_tugas_pokok($_POST);
		echo "success";
	}







	function formkoreksi_tugas_pokok()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_pokok";
		$this->load->view('realisasi_kelola/formkoreksi',$data);
	}
	function koreksi_aksi()
	{
		$_POST['user_id'] = $this->session->userdata('pegawai_info');
		$this->m_skp->koreksi_aksi($_POST);
		echo "success";
	}
	function formkomentar_tugas_pokok()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_pokok";
		$data['komentar'] = $this->m_skp->get_realisasi_komentar('tugas_pokok',$_POST['idd']);
		$this->load->view('realisasi_kelola/formkomentar',$data);
	}
/*
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
*/
/////////////////////////////////////////////////////////////////////////////////////////////////
	function lembar_kreatifitas()
	{
		$data['satu'] = "RRR";
		$id_skp = $this->session->userdata('id_skp');
		$data['kreatifitas'] = $this->m_skp->get_kreatifitas($id_skp);
		$this->load->view('realisasi_kelola/lembar_kreatifitas',$data);
	}
	function formacc_kreatifitas()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "kreatifitas";
		$this->load->view('realisasi_kelola/formacc',$data);
	}
	function acc_item_kreatifitas()
	{
		$this->m_skp->acc_item_kreatifitas($_POST);
		echo "success";
	}







	function formkoreksi_kreatifitas()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "kreatifitas";
		$this->load->view('realisasi_kelola/formkoreksi',$data);
	}
	function formkomentar_kreatifitas()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "kreatifitas";
		$data['komentar'] = $this->m_skp->get_realisasi_komentar('kreatifitas',$_POST['idd']);

		$this->load->view('realisasi_kelola/formkomentar',$data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function lembar_tugas_tambahan()
	{
		$data['satu'] = "RRR";
		$id_skp = $this->session->userdata('id_skp');
		$data['ttambahan'] = $this->m_skp->get_tugas_tambahan($id_skp);

		$this->load->view('realisasi_kelola/lembar_tugas_tambahan',$data);
	}
	function formacc_tugas_tambahan()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_tambahan";
		$this->load->view('realisasi_kelola/formacc',$data);
	}
	function acc_item_tugas_tambahan()
	{
		$this->m_skp->acc_item_tugas_tambahan($_POST);
		echo "success";
	}







	function formkoreksi_tugas_tambahan()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_tambahan";
		$this->load->view('realisasi_kelola/formkoreksi',$data);
	}
	function formkomentar_tugas_tambahan()
	{
		$data['idd'] = $_POST['idd'];
		$data['idx'] = "tugas_tambahan";
		$data['komentar'] = $this->m_skp->get_realisasi_komentar('tugas_tambahan',$_POST['idd']);

		$this->load->view('realisasi_kelola/formkomentar',$data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	function lembar_perilaku()
	{
		$data['satu'] = "RRR";
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
		$this->load->view('realisasi_kelola/lembar_perilaku',$data);
	}

	function perilaku_aksi()
	{
 		$this->form_validation->set_rules("isi","Perilaku","required|numeric|xss_clean");
		if($this->form_validation->run())
		{
			if($_POST['isi']>=0 && $_POST['isi']<=100 ){
				$operasi = ($_POST['ada']=="ya")?"edit":"input";
				$this->m_skp->put_perilaku($_POST,$operasi);
				$data['perilaku'] = $this->m_skp->get_perilaku($_POST['idd']);
					$dn['nilai'] = $data['perilaku']->$_POST['ipt'];
					$dn['kat'] = $this->kat_perilaku($dn['nilai']);
					$dn['jumlah'] = $data['perilaku']->pelayanan+$data['perilaku']->integritas+$data['perilaku']->komitmen+$data['perilaku']->disiplin+$data['perilaku']->kerjasama+$data['perilaku']->kepemimpinan;
					if($data['perilaku']->kepemimpinan > 0)
					{
						$pembagi = 6;
					}
					else
					{
						$pembagi = 5;
					}
					$dn['rerata'] = number_format($dn['jumlah']/$pembagi, 2, ",", "");
					$dn['kat_rerata'] = $this->kat_perilaku($dn['rerata']);
					$dn['nilai_perilaku'] = $dn['rerata']*0.4;
					$dn['ada'] = "ya";
				$dn['pesan']="sukses";
			}
			else
			{
				$dn['pesan']="Angka antara 1-100";
			}
		}
		else
		{
			$dn['pesan']="Inputan harus berupa angka\n(Hanya Angka Saja)";
		}
		echo json_encode($dn);
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
	
/////////////////////////////////////////////////////////////////////////////////////////////////
}
?>