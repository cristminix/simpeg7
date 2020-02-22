<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pegawai extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appbkpp/m_pegawai');
		$this->load->model('appbkpp/m_unor');
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
	function index(){
		$data['satu'] = "Daftar Pegawai";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('pegawai/index',$data);
	}
	function getdata(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_pegawai->hitung_master_pegawai($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_pegawai->get_master_pegawai($cari,$mulai,$batas);
				foreach($data['hslquery'] AS $key=>$val){
					$data['hslquery'][$key]->gender = ($val->gender=="l")?"Laki-laki":"Perempuan";
					$data['hslquery'][$key]->tanggal_lahir = date("d-m-Y", strtotime($val->tanggal_lahir));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					$cpns = $this->m_pegawai->ini_cpns($val->id_pegawai);
					$pns = $this->m_pegawai->ini_pns($val->id_pegawai);
					@$data['hslquery'][$key]->tmt_cpns = date("d-m-Y", strtotime($cpns->tmt_cpns));
					@$data['hslquery'][$key]->tmt_pns = date("d-m-Y", strtotime($pns->tmt_pns));
				}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
///////////////////////////////////////////////////////////////////////////////////
	function aktif(){
		if($this->session->userdata('group_id')=="6"){
			$rd = "aktif_umpeg";
			$data['dua'] = $this->session->userdata('nama_unor');
		} elseif($this->session->userdata('group_id')=="488") {
			$rd = "aktif_mutasi";
		} else {
			$rd = "aktif";
		}
		
		$data['unor'] = $this->m_unor->gettree(0,5,"2015-01-01"); 
		$data['pkt'] = $this->dropdowns->kode_golongan_pangkat();
		$data['jbt'] = $this->dropdowns->jenis_jabatan();
		// $data['ese'] = $this->dropdowns->kode_ese();
		// $data['tugas'] = $this->dropdowns->tugas_tambahan();
		$data['agama'] = $this->dropdowns->agama();
		$data['status_pegawai'] = $this->dropdowns->status_pegawai();
		$data['kelompok_pegawai'] = $this->dropdowns->kelompok_pegawai();
		$data['status'] = $this->dropdowns->status_perkawinan();
		$data['jenjang'] = $this->dropdowns->kode_jenjang_pendidikan();

		$data['satu'] = "Daftar Pegawai";
		$data['dua'] = $this->session->userdata('nama_unor');
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('pegawai/'.$rd,$data);
	}
	function duk(){
		if($this->session->userdata('group_id')=="6"){
			$rd = "duk_umpeg";
			$data['dua'] = $this->session->userdata('nama_unor');
//		} elseif($this->session->userdata('group_id')=="488") {
//			$rd = "duk_mutasi";
		} else {
			$rd = "duk";
		}
		$data['satu'] = "Daftar Pegawai";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('pegawai/'.$rd,$data);
	}
	function cpns(){
		if($this->session->userdata('group_id')=="6"){
			$rd = "cpns_umpeg";
			$data['dua'] = $this->session->userdata('nama_unor');
		} elseif($this->session->userdata('group_id')=="488") {
			$rd = "cpns_mutasi";
		} else {
			$rd = "cpns";
		}
		$data['satu'] = "Daftar Pegawai";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('pegawai/'.$rd,$data);
	}
	function pns(){
		if($this->session->userdata('group_id')=="6"){
			$rd = "pns_umpeg";
			$data['dua'] = $this->session->userdata('nama_unor');
		} elseif($this->session->userdata('group_id')=="488") {
			$rd = "pns_mutasi";
		} else {
			$rd = "pns";
		}
		$data['satu'] = "Daftar Pegawai";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('pegawai/'.$rd,$data);
	}
	// function getaktif(){
		// if($this->session->userdata('group_id')=="6"){
			// $this->load->model('appbkpp/m_umpeg');
			// $user_id = $this->session->userdata('user_id');
			// $user = $this->m_umpeg->ini_user($user_id);
				// $dd=array("{","}");
			// $unor=  str_replace($dd,"",$user->unor_akses);
			// $kode="";$pkt="";$jbt="";$ese="";$gender="";$agama="";$tugas="";$status="";$jenjang="";
		// } else {
			// $unor="all";
			// $kode=$_POST['kode'];
			// $pkt=$_POST['pkt'];
			// $jbt=$_POST['jbt'];
			// $ese=$_POST['ese'];
			// $tugas=$_POST['tugas'];
			// $gender=$_POST['gender'];
			// $agama=$_POST['agama'];
			// $status=$_POST['status'];
			// $jenjang=$_POST['jenjang'];
		// }
		// $data['count'] = $this->m_pegawai->hitung_pegawai($_POST['cari'],$_POST['pns'],$unor,$kode,$pkt,$jbt,$ese,$tugas,$gender,$agama,$status,$jenjang);
		// $data['bat_print'] = 200;
		// $data['seg_print'] = ceil($data['count']/$data['bat_print']);
		// $_POST['bat_print'] = $data['bat_print'];
		// $this->session->set_userdata("id_cetak",$_POST);


		// if($data['count']==0){
			// $data['hslquery']="";
			// $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		// } else {
			// $batas=$_POST['batas'];
			// $hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			// $mulai=($hal-1)*$batas;
			// $data['mulai']=$mulai+1;
			// $data['hslquery'] = $this->m_pegawai->get_pegawai($_POST['cari'],$mulai,$batas,$_POST['pns'],$unor,$kode,$pkt,$jbt,$ese,$tugas,$gender,$agama,$status,$jenjang);
				// foreach($data['hslquery'] AS $key=>$val){
					// $data['hslquery'][$key]->tanggal_lahir = date("d-m-Y", strtotime($val->tanggal_lahir));
					
					// $data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
					// $data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					// $data['hslquery'][$key]->tmt_cpns = date("d-m-Y", strtotime($val->tmt_cpns));
					// $data['hslquery'][$key]->tmt_pns = date("d-m-Y", strtotime($val->tmt_pns));
					// $data['hslquery'][$key]->tmt_pangkat = date("d-m-Y", strtotime($val->tmt_pangkat));
					// $data['hslquery'][$key]->tmt_jabatan = date("d-m-Y", strtotime($val->tmt_jabatan));
				// }
			// $data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		// }
		// echo json_encode($data);
	// }
	function getaktif(){
			if($this->session->userdata('group_id')=="6"){
				$this->load->model('appbkpp/m_umpeg');
				$user_id = $this->session->userdata('user_id');
				$user = $this->m_umpeg->ini_user($user_id);
					$dd=array("{","}");
				$unor=  str_replace($dd,"",$user->unor_akses);
				$kode="";$pkt="";$jbt="";$ese="";$gender="";$agama="";$tugas="";$status="";$jenjang="";
			} else {
				$unor="all";
				$kode=$_POST['kode'];
				$pkt=$_POST['pkt'];
				$jbt=$_POST['jbt'];
				$gender=$_POST['gender'];
				$agama=$_POST['agama'];
				$status=$_POST['status'];
				$jenjang=$_POST['jenjang'];
			}
			$data['count'] = $this->m_pegawai->hitung_pegawai($_POST['cari'],$_POST['pns'],$unor,$kode,$pkt,$jbt,'','',$gender,$agama,$status,$jenjang);
			$data['bat_print'] = 200;
			$data['seg_print'] = ceil($data['count']/$data['bat_print']);
			$_POST['bat_print'] = $data['bat_print'];
			$this->session->set_userdata("id_cetak",$_POST);

			if($data['count']==0){
				$data['hslquery']="";
				$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
			} else {
				$batas=$_POST['batas'];
				$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
				$mulai=($hal-1)*$batas;
				$data['mulai']=$mulai+1;
				$data['hslquery'] = $this->m_pegawai->get_pegawai($_POST['cari'],$mulai,$batas,$_POST['pns'],$unor,$kode,$pkt,$jbt,'','',$gender,$agama,$status,$jenjang);
					foreach($data['hslquery'] AS $key=>$val){
						$data['hslquery'][$key]->gender = ($val->gender=="l")?"Laki-laki":"Perempuan";
						$data['hslquery'][$key]->tanggal_lahir = date("d-m-Y", strtotime($val->tanggal_lahir));
						$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
						$data['hslquery'][$key]->tmt_cpns = date("d-m-Y", strtotime($val->tmt_cpns));
						$data['hslquery'][$key]->tmt_pns = date("d-m-Y", strtotime($val->tmt_pns));
						$data['hslquery'][$key]->tmt_pangkat = date("d-m-Y", strtotime($val->tmt_pangkat));
						$data['hslquery'][$key]->tmt_jabatan = date("d-m-Y", strtotime($val->tmt_jabatan));
					}
				$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
			}
			echo json_encode($data);
		}

	function getduk(){
		if($this->session->userdata('group_id')=="6"){
			$this->load->model('appbkpp/m_umpeg');
			$user_id = $this->session->userdata('user_id');
			$user = $this->m_umpeg->ini_user($user_id);
				$dd=array("{","}");
			$unor=  str_replace($dd,"",$user->unor_akses);
		} else {
			$unor="all";
		}

		$data['count'] = $this->m_pegawai->hitung_pegawai_duk($_POST['cari'],$_POST['pns'],$unor);
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_pegawai->get_pegawai_duk($_POST['cari'],$mulai,$batas,$_POST['pns'],$unor);
				foreach($data['hslquery'] AS $key=>$val){
					$data['hslquery'][$key]->tanggal_lahir = date("d-m-Y", strtotime($val->tanggal_lahir));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					$data['hslquery'][$key]->tmt_cpns = date("d-m-Y", strtotime($val->tmt_cpns));
					$data['hslquery'][$key]->tmt_pns = date("d-m-Y", strtotime($val->tmt_pns));
					$data['hslquery'][$key]->tmt_pangkat = date("d-m-Y", strtotime($val->tmt_pangkat));
					$data['hslquery'][$key]->tmt_jabatan = date("d-m-Y", strtotime($val->tmt_jabatan));
				}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
///////////////////////////////////////////////////////////////////////////////////
	function formpangkat(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$pangkat = $this->m_pegawai->ini_pegawai_pangkat($data['idd']);
			$data['pangkat'] = '';
			$mulai=0;
			foreach($pangkat as $row){
				$row->no=$mulai+1;
				$row->tmt_golongan = date("d-m-Y", strtotime($row->tmt_golongan));
				$row->sk_tanggal = date("d-m-Y", strtotime($row->sk_tanggal));
				// $row->bkn_tanggal = date("d-m-Y", strtotime($row->bkn_tanggal));
				$data['pangkat'] .= $this->load->view('pegawai/formpangkat_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formpangkat',$data);
	}
	function pangkat_riwayat(){
		$pangkat = $this->m_pegawai->ini_pegawai_pangkat($_POST['id_pegawai']);
			$data['pangkat'] = '';
			$mulai=0;
			foreach($pangkat as $row){
				$row->no=$mulai+1;
				$row->tmt_golongan = date("d-m-Y", strtotime($row->tmt_golongan));
				$row->sk_tanggal = date("d-m-Y", strtotime($row->sk_tanggal));
				// $row->bkn_tanggal = date("d-m-Y", strtotime($row->bkn_tanggal));
				$data['pangkat'] .= $this->load->view('pegawai/formpangkat_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formpangkat_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formpangkat_update',$data);
	}
	function formpangkat_tambah_aksi(){
		$isi = $_POST;
		$pkt = $this->dropdowns->kode_golongan_pangkat();
		$pkt_X=explode(",",$pkt[$isi['kode_golongan']]);
		$kp = $this->dropdowns->kode_jenis_kp();

		// $isi['jenis_kp'] = $kp[$isi['kode_jenis_kp'	]];
		$isi['kode_pangkat'] = trim($_POST['kode_pangkat']);
		$isi['nama_pangkat'] = trim($pkt_X[0]);
		$isi['nama_golongan'] = trim($_POST['nama_golongan']);
		$isi['tmt_golongan'] = date("Y-m-d", strtotime($_POST['tmt_golongan']));
		$isi['sk_tanggal'] =  date("Y-m-d", strtotime($_POST['sk_tanggal']));
		$isi['bkn_tanggal'] =  date("Y-m-d", strtotime($_POST['bkn_tanggal']));
		$this->m_pegawai->pangkat_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formpangkat_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_pangkat_riwayat($data['idd']);
		$data['val']->sk_tanggal = date("d-m-Y", strtotime($data['val']->sk_tanggal));
		$data['val']->kode_pangkat =  trim($data['val']->kode_pangkat);
		$data['val']->nama_golongan =  trim($data['val']->nama_golongan);
		// $data['val']->bkn_tanggal = date("d-m-Y", strtotime($data['val']->bkn_tanggal));
		$data['val']->tmt_golongan = date("d-m-Y", strtotime($data['val']->tmt_golongan));
		$this->load->view('pegawai/formpangkat_update',$data);
	}
	function formpangkat_edit_aksi(){
		$isi = $_POST;
		$pkt = $this->dropdowns->kode_golongan_pangkat();
		$pkt_X=explode(",",$pkt[$isi['kode_golongan']]);
		$isi['kode_pangkat'] = trim($_POST['kode_pangkat']);
		$isi['nama_pangkat'] = trim($pkt_X[0]);
		// $isi['nama_golongan'] = trim($pkt_X[0]);
		$isi['tmt_golongan'] = date("Y-m-d", strtotime($_POST['tmt_golongan']));
		$isi['sk_tanggal'] =  date("Y-m-d", strtotime($_POST['sk_tanggal']));
		// $isi['bkn_tanggal'] =  date("Y-m-d", strtotime($_POST['bkn_tanggal']));
		$this->m_pegawai->pangkat_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formpangkat_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_pangkat_riwayat($data['idd']);
		$data['val']->sk_tanggal = date("d-m-Y", strtotime($data['val']->sk_tanggal));
		// $data['val']->bkn_tanggal = date("d-m-Y", strtotime($data['val']->bkn_tanggal));
		$data['val']->tmt_golongan = date("d-m-Y", strtotime($data['val']->tmt_golongan));
		$this->load->view('pegawai/formpangkat_hapus',$data);
	}
	function formpangkat_hapus_aksi(){
		$isi = $_POST;
		$this->m_pegawai->pangkat_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////
	function formsanksi(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$sanksi = $this->m_pegawai->ini_pegawai_sanksi($data['idd']);
			$data['sanksi'] = '';
			$mulai=0;
			foreach($sanksi as $row){
				$row->no=$mulai+1;
				$row->nomor_sk = trim($row->nomor_sk);
				$row->tanggal_sk = date("d-m-Y", strtotime($row->tanggal_sk));
				$row->uraian = $row->uraian;
				@$data['hslquery'][$key]->sanksi = $row->sanksi;
				$data['sanksi'] .= $this->load->view('pegawai/formsanksi_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formsanksi',$data);
	}
	function sanksi_riwayat(){
		$sanksi = $this->m_pegawai->ini_pegawai_sanksi($_POST['id_pegawai']);
			$data['sanksi'] = '';
			$mulai=0;
			foreach($sanksi as $row){
				$row->no=$mulai+1;
				$row->nomor_sk = trim($row->nomor_sk);
				$row->tanggal_sk = date("d-m-Y", strtotime($row->tanggal_sk));
				$row->uraian = trim($row->uraian);
				$data['sanksi'] .= $this->load->view('pegawai/formsanksi_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formsanksi_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formsanksi_update',$data);
	}
	function formsanksi_tambah_aksi(){
		$isi = $_POST;
		$isi['nomor_sk'] = trim($_POST['nomor_sk']);
		$isi['tanggal_sk'] =  date("Y-m-d", strtotime($_POST['tanggal_sk']));
		$isi['uraian'] = trim($_POST['uraian']);
		$this->m_pegawai->sanksi_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formsanksi_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_sanksi_riwayat($data['idd']);
		$data['val']->nomor_sk = trim($data['val']->nomor_sk);
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($data['val']->tanggal_sk));
		$data['val']->uraian = trim($data['val']->uraian);
		$this->load->view('pegawai/formsanksi_update',$data);
	}
	function formsanksi_edit_aksi(){
		$isi['id_peg_sanksi'] = $_POST['id_peg_sanksi'];
		$isi['nomor_sk'] = trim($_POST['nomor_sk']);
		$isi['tanggal_sk'] =  date("Y-m-d", strtotime($_POST['tanggal_sk']));
		$isi['uraian'] = trim($_POST['uraian']);
		$this->m_pegawai->sanksi_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formsanksi_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_sanksi_riwayat($data['idd']);
		$data['val']->nomor_sk= trim($data['val']->nomor_sk);
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($data['val']->tanggal_sk));
		$data['val']->uraian= trim($data['val']->uraian);
		$this->load->view('pegawai/formsanksi_hapus',$data);
	}
	function formsanksi_hapus_aksi(){
		$isi['id_peg_sanksi'] = $_POST['id_peg_sanksi'];
		$this->m_pegawai->sanksi_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
	function formpenghargaan(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$penghargaan = $this->m_pegawai->ini_pegawai_penghargaan($data['idd']);
			$data['penghargaan'] = '';
			$mulai=0;
			foreach($penghargaan as $row){
				$row->no=$mulai+1;
				$row->nomor_sk = trim($row->nomor_sk);
				$row->tanggal_sk = date("d-m-Y", strtotime($row->tanggal_sk));
				$row->uraian = $row->uraian;
				@$data['hslquery'][$key]->penghargaan = $row->penghargaan;
				$data['penghargaan'] .= $this->load->view('pegawai/formpenghargaan_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formpenghargaan',$data);
	}
	function penghargaan_riwayat(){
		$penghargaan = $this->m_pegawai->ini_pegawai_penghargaan($_POST['id_pegawai']);
			$data['penghargaan'] = '';
			$mulai=0;
			foreach($penghargaan as $row){
				$row->no=$mulai+1;
				$row->nomor_sk = trim($row->nomor_sk);
				$row->tanggal_sk = date("d-m-Y", strtotime($row->tanggal_sk));
				$row->uraian = trim($row->uraian);
				$data['penghargaan'] .= $this->load->view('pegawai/formpenghargaan_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formpenghargaan_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formpenghargaan_update',$data);
	}
	function formpenghargaan_tambah_aksi(){
		$isi = $_POST;
		
		$isi['nomor_sk'] = trim($_POST['nomor_sk']);
		$isi['tanggal_sk'] =  date("Y-m-d", strtotime($_POST['tanggal_sk']));
		$isi['uraian'] = trim($_POST['uraian']);
		$this->m_pegawai->penghargaan_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formpenghargaan_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_penghargaan_riwayat($data['idd']);
		$data['val']->nomor_sk = trim($data['val']->nomor_sk);
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($data['val']->tanggal_sk));
		$data['val']->uraian = trim($data['val']->uraian);
		$this->load->view('pegawai/formpenghargaan_update',$data);
	}
	function formpenghargaan_edit_aksi(){
		$isi['id_peg_penghargaan'] = $_POST['id_peg_penghargaan'];
		$isi['nomor_sk'] = trim($_POST['nomor_sk']);
		$isi['tanggal_sk'] =  date("Y-m-d", strtotime($_POST['tanggal_sk']));
		$isi['uraian'] = trim($_POST['uraian']);
		$this->m_pegawai->penghargaan_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formpenghargaan_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_penghargaan_riwayat($data['idd']);
		$data['val']->nomor_sk= trim($data['val']->nomor_sk);
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($data['val']->tanggal_sk));
		$data['val']->uraian= trim($data['val']->uraian);
		$this->load->view('pegawai/formpenghargaan_hapus',$data);
	}
	function formpenghargaan_hapus_aksi(){
		$isi['id_peg_penghargaan'] = $_POST['id_peg_penghargaan'];
		$this->m_pegawai->penghargaan_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////
	function formkesehatan(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$kesehatan = $this->m_pegawai->ini_pegawai_kesehatan($data['idd']);
			$data['kesehatan'] = '';
			$mulai=0;
			foreach($kesehatan as $row){
				$row->no=$mulai+1;
				$row->tanggal_tes = date("d-m-Y", strtotime($row->tanggal_tes));
				$row->tempat = $row->tempat;
				$row->hasil = $row->hasil;
				@$data['hslquery'][$key]->kesehatan = $row->kesehatan;
				$data['kesehatan'] .= $this->load->view('pegawai/formkesehatan_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formkesehatan',$data);
	}
	function kesehatan_riwayat(){
		$kesehatan = $this->m_pegawai->ini_pegawai_kesehatan($_POST['id_pegawai']);
			$data['kesehatan'] = '';
			$mulai=0;
			foreach($kesehatan as $row){
				$row->no=$mulai+1;
				$row->tanggal_tes = date("d-m-Y", strtotime($row->tanggal_tes));
				$row->tempat = $row->tempat;
				$row->hasil = $row->hasil;
				$data['kesehatan'] .= $this->load->view('pegawai/formkesehatan_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formkesehatan_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formkesehatan_update',$data);
	}
	function formkesehatan_tambah_aksi(){
		$isi = $_POST;
		$isi['tanggal_tes'] =  date("Y-m-d", strtotime($_POST['tanggal_tes']));
		$isi['tempat'] = trim($_POST['tempat']);
		$isi['hasil'] = trim($_POST['hasil']);
		$this->m_pegawai->kesehatan_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formkesehatan_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_kesehatan_riwayat($data['idd']);
		$data['val']->tanggal_tes = date("d-m-Y", strtotime($data['val']->tanggal_tes));
		$data['val']->tempat = trim($data['val']->tempat);
		$data['val']->hasil = trim($data['val']->hasil);
		$this->load->view('pegawai/formkesehatan_update',$data);
	}
	function formkesehatan_edit_aksi(){
		$isi['id_peg_kesehatan'] = $_POST['id_peg_kesehatan'];
		$isi['tanggal_tes'] =  date("Y-m-d", strtotime($_POST['tanggal_tes']));
		$isi['tempat'] = trim($_POST['tempat']);
		$isi['hasil'] = trim($_POST['hasil']);
		$this->m_pegawai->kesehatan_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formkesehatan_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_kesehatan_riwayat($data['idd']);
		$data['val']->tanggal_tes = date("d-m-Y", strtotime($data['val']->tanggal_tes));
		$data['val']->tempat= trim($data['val']->tempat);
		$data['val']->hasil= trim($data['val']->hasil);
		$this->load->view('pegawai/formkesehatan_hapus',$data);
	}
	function formkesehatan_hapus_aksi(){
		$isi['id_peg_kesehatan'] = $_POST['id_peg_kesehatan'];
		$this->m_pegawai->kesehatan_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////
	function formpsikotes(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$psikotes = $this->m_pegawai->ini_pegawai_psikotes($data['idd']);
			$data['psikotes'] = '';
			$mulai=0;
			foreach($psikotes as $row){
				$row->no=$mulai+1;
				$row->tanggal_tes = date("d-m-Y", strtotime($row->tanggal_tes));
				$row->tempat = trim($row->tempat);
				$row->hasil = trim($row->hasil);
				@$data['hslquery'][$key]->psikotes = $row->psikotes;
				$data['psikotes'] .= $this->load->view('pegawai/formpsikotes_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formpsikotes',$data);
	}
	function psikotes_riwayat(){
		$psikotes = $this->m_pegawai->ini_pegawai_psikotes($_POST['id_pegawai']);
			$data['psikotes'] = '';
			$mulai=0;
			foreach($psikotes as $row){
				$row->no=$mulai+1;
				$row->tanggal_tes = date("d-m-Y", strtotime($row->tanggal_tes));
				$row->tempat = trim($row->tempat);
				$row->hasil = trim($row->hasil);
				$data['psikotes'] .= $this->load->view('pegawai/formpsikotes_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formpsikotes_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formpsikotes_update',$data);
	}
	function formpsikotes_tambah_aksi(){
		$isi = $_POST;
		$isi['tanggal_tes'] =  date("Y-m-d", strtotime($_POST['tanggal_tes']));
		$isi['tempat'] = trim($_POST['tempat']);
		$isi['hasil'] = trim($_POST['hasil']);
		$this->m_pegawai->psikotes_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formpsikotes_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_psikotes_riwayat($data['idd']);
		$data['val']->tanggal_tes = date("d-m-Y", strtotime($data['val']->tanggal_tes));
		$data['val']->tempat = trim($data['val']->tempat);
		$data['val']->hasil = trim($data['val']->hasil);
		$this->load->view('pegawai/formpsikotes_update',$data);
	}
	function formpsikotes_edit_aksi(){
		$isi['id_peg_psikotes'] = $_POST['id_peg_psikotes'];
		$isi['tanggal_tes'] =  date("Y-m-d", strtotime($_POST['tanggal_tes']));
		$isi['tempat'] = trim($_POST['tempat']);
		$isi['hasil'] = trim($_POST['hasil']);
		$this->m_pegawai->psikotes_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formpsikotes_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_psikotes_riwayat($data['idd']);
		$data['val']->tanggal_tes = date("d-m-Y", strtotime($data['val']->tanggal_tes));
		$data['val']->tempat = trim($data['val']->tempat);
		$data['val']->hasil = trim($data['val']->hasil);
		$this->load->view('pegawai/formpsikotes_hapus',$data);
	}
	function formpsikotes_hapus_aksi(){
		$isi['id_peg_psikotes'] = $_POST['id_peg_psikotes'];
		$this->m_pegawai->psikotes_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
	function formpengalaman(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$pengalaman = $this->m_pegawai->ini_pegawai_pengalaman($data['idd']);
			$data['pengalaman'] = '';
			$mulai=0;
			foreach($pengalaman as $row){
				$row->no=$mulai+1;
				$row->perusahaan = trim($row->perusahaan);
				$row->pekerjaan = trim($row->pekerjaan);
				$row->tanggal_awal = date("d-m-Y", strtotime($row->tanggal_awal));
				$row->tanggal_akhir = date("d-m-Y", strtotime($row->tanggal_akhir));
				$row->jabatan = trim($row->jabatan);
				@$data['hslquery'][$key]->pengalaman = $row->pengalaman;
				$data['pengalaman'] .= $this->load->view('pegawai/formpengalaman_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formpengalaman',$data);
	}
	function pengalaman_riwayat(){
			$pengalaman = $this->m_pegawai->ini_pegawai_pengalaman($_POST['id_pegawai']);
			$data['pengalaman'] = '';
			$mulai=0;
			foreach($pengalaman as $row){
				$row->no=$mulai+1;
				$row->perusahaan = trim($row->perusahaan);
				$row->pekerjaan = trim($row->pekerjaan);
				$row->tanggal_awal = date("d-m-Y", strtotime($row->tanggal_awal));
				$row->tanggal_akhir = date("d-m-Y", strtotime($row->tanggal_akhir));
				$row->jabatan = trim($row->jabatan);
				$data['pengalaman'] .= $this->load->view('pegawai/formpengalaman_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formpengalaman_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formpengalaman_update',$data);
	}
	function formpengalaman_tambah_aksi(){
		$isi = $_POST;
		$isi['perusahaan'] = trim($_POST['perusahaan']);
		$isi['pekerjaan'] = trim($_POST['pekerjaan']);
		$isi['tanggal_awal'] =  date("Y-m-d", strtotime($_POST['tanggal_awal']));
		$isi['tanggal_akhir'] =  date("Y-m-d", strtotime($_POST['tanggal_akhir']));
		$isi['jabatan'] = trim($_POST['jabatan']);
		$this->m_pegawai->pengalaman_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formpengalaman_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_pengalaman_riwayat($data['idd']);
		$data['val']->perusahaan = trim($data['val']->perusahaan);
		$data['val']->pekerjaan = trim($data['val']->pekerjaan);
		$data['val']->tanggal_awal = date("d-m-Y", strtotime($data['val']->tanggal_awal));
		$data['val']->tanggal_akhir = date("d-m-Y", strtotime($data['val']->tanggal_akhir));
		$data['val']->jabatan = trim($data['val']->jabatan);
		$this->load->view('pegawai/formpengalaman_update',$data);
	}
	function formpengalaman_edit_aksi(){
		$isi['id_peg_pengalaman'] = $_POST['id_peg_pengalaman'];
		$isi['perusahaan'] = trim($_POST['perusahaan']);
		$isi['pekerjaan'] = trim($_POST['pekerjaan']);
		$isi['tanggal_awal'] =  date("Y-m-d", strtotime($_POST['tanggal_awal']));
		$isi['tanggal_akhir'] =  date("Y-m-d", strtotime($_POST['tanggal_akhir']));
		$isi['jabatan'] = trim($_POST['jabatan']);
		$this->m_pegawai->pengalaman_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formpengalaman_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_pengalaman_riwayat($data['idd']);
		$data['val']->perusahaan = trim($data['val']->perusahaan);
		$data['val']->pekerjaan = trim($data['val']->pekerjaan);
		$data['val']->tanggal_awal = date("d-m-Y", strtotime($data['val']->tanggal_awal));
		$data['val']->tanggal_akhir = date("d-m-Y", strtotime($data['val']->tanggal_akhir));
		$data['val']->jabatan = trim($data['val']->jabatan);
		$this->load->view('pegawai/formpengalaman_hapus',$data);
	}
	function formpengalaman_hapus_aksi(){
		$isi['id_peg_pengalaman'] = $_POST['id_peg_pengalaman'];
		$this->m_pegawai->pengalaman_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
	function formdiklat(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$diklat = $this->m_pegawai->ini_pegawai_diklat($data['idd']);
			$data['diklat'] = '';
			$mulai=0;
			foreach($diklat as $row){
				$row->no=$mulai+1;
				$row->tanggal_mulai= date("d-m-Y", strtotime($row->tanggal_mulai));
				$row->tanggal_selesai = date("d-m-Y", strtotime($row->tanggal_selesai));
				$row->tanggal_sk = date("d-m-Y", strtotime($row->tanggal_sk));
				$data['diklat'] .= $this->load->view('pegawai/formdiklat_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formdiklat',$data);
	}
	function diklat_riwayat(){
		$diklat = $this->m_pegawai->ini_pegawai_diklat($_POST['id_pegawai']);
			$data['diklat'] = '';
			$mulai=0;
			foreach($diklat as $row){
				$row->no=$mulai+1;
				$row->tanggal_mulai= date("d-m-Y", strtotime($row->tanggal_mulai));
				$row->tanggal_selesai = date("d-m-Y", strtotime($row->tanggal_selesai));
				$row->tanggal_sk = date("d-m-Y", strtotime($row->tanggal_sk));
				$data['diklat'] .= $this->load->view('pegawai/formdiklat_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formdiklat_tambah(){
		$data['no'] = $_POST['nomor'];
		$this->load->view('pegawai/formdiklat_update',$data);
	}
	function formdiklat_tambah_aksi(){
		$isi = $_POST;
		// $pkt = $this->dropdowns->kode_golongan_pangkat();
		// $pkt_X=explode(",",$pkt[$isi['kode_golongan']]);
		// $kp = $this->dropdowns->kode_jenis_kp();

		// $isi['jenis_kp'] = $kp[$isi['kode_jenis_kp'	]];
		// $isi['nama_pangkat'] = trim($pkt_X[0]);
		$isi['nama_diklat'] = trim($_POST['nama_diklat']);
		$isi['tempat_diklat'] = trim($_POST['tempat_diklat']);
		$isi['tanggal_mulai'] = date("Y-m-d", strtotime($_POST['tanggal_mulai']));
		$isi['tanggal_selesai'] = date("Y-m-d", strtotime($_POST['tanggal_selesai']));
		$isi['nomor_sk'] = trim($_POST['nomor_sk']);
		$isi['tanggal_sk'] =  date("Y-m-d", strtotime($_POST['tanggal_sk']));
		$this->m_pegawai->diklat_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formdiklat_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_diklat_riwayat($data['idd']);
		$data['val']->nama_diklat=  trim($data['val']->nama_diklat);
		$data['val']->tempat_diklat=  trim($data['val']->tempat_diklat);
		$data['val']->tanggal_mulai = date("d-m-Y", strtotime($data['val']->tanggal_mulai));
		$data['val']->tanggal_selesai = date("d-m-Y", strtotime($data['val']->tanggal_selesai));
		$data['val']->nomor_sk=  trim($data['val']->nomor_sk);
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($data['val']->tanggal_sk));
		$this->load->view('pegawai/formdiklat_update',$data);
	}
	function formdiklat_edit_aksi(){
		$isi = $_POST;
		$isi['nama_diklat'] = trim($_POST['nama_diklat']);
		$isi['tempat_diklat'] = trim($_POST['tempat_diklat']);
		$isi['tanggal_mulai'] = date("Y-m-d", strtotime($_POST['tanggal_mulai']));
		$isi['tanggal_selesai'] = date("Y-m-d", strtotime($_POST['tanggal_selesai']));
		$isi['nomor_sk'] = trim($_POST['nomor_sk']);
		$isi['tanggal_sk'] =  date("Y-m-d", strtotime($_POST['tanggal_sk']));
		$this->m_pegawai->diklat_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formdiklat_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_diklat_riwayat($data['idd']);
		$data['val']->nama_diklat=  trim($data['val']->nama_diklat);
		$data['val']->tempat_diklat=  trim($data['val']->tempat_diklat);
		$data['val']->tanggal_mulai = date("d-m-Y", strtotime($data['val']->tanggal_mulai));
		$data['val']->tanggal_selesai = date("d-m-Y", strtotime($data['val']->tanggal_selesai));
		$data['val']->nomor_sk=  trim($data['val']->nomor_sk);
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($data['val']->tanggal_sk));
		$this->load->view('pegawai/formdiklat_hapus',$data);
	}
	function formdiklat_hapus_aksi(){
		$isi = $_POST;
		$this->m_pegawai->diklat_riwayat_hapus_aksi($isi);
		echo "ss";
	}
///////////////////////////////////////////////////////////////////////////////////
	function formuserskp(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$this->load->view('pegawai/formuserskp',$data);
	}

	function formuserskp_aksi(){
		$this->m_pegawai->userskp_setup_aksi($_POST);
		echo "success";
	}


///////////////////////////////////////////////////////////////////////////////////
	
	
	function formjabatan(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$jabatan = $this->m_pegawai->ini_pegawai_jabatan($data['idd']);
			$data['jabatan'] = '';
			$mulai=0;
			foreach($jabatan as $row){
				$row->no=$mulai+1;
				$row->tmt_jabatan = date("d-m-Y", strtotime($row->tmt_jabatan));
				$row->sk_tanggal = date("d-m-Y", strtotime($row->sk_tanggal));
				$data['jabatan'] .= $this->load->view('pegawai/formjabatan_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		$this->load->view('pegawai/formjabatan',$data);
	}
	function jabatan_riwayat(){
		$jabatan = $this->m_pegawai->ini_pegawai_jabatan($_POST['id_pegawai']);
			$data['jabatan'] = '';
			$mulai=0;
			foreach($jabatan as $row){
				$row->no=$mulai+1;
				$row->tmt_jabatan = date("d-m-Y", strtotime($row->tmt_jabatan));
				$row->sk_tanggal = date("d-m-Y", strtotime($row->sk_tanggal));
				$data['jabatan'] .= $this->load->view('pegawai/formjabatan_row',array('val'=>$row),true);
				$mulai++;
			}
		$data['no']=$mulai+1;
		echo json_encode($data);
	}
	function formjabatan_tambah(){
		$data['no'] = $_POST['nomor'];
		$tugas_tambahan = $this->dropdowns->tugas_tambahan();
		$this->load->view('pegawai/formjabatan_update',$data);
	}
	function formjabatan_tambah_aksi(){
		$isi = $_POST;
		$isi['tmt_jabatan'] = date("Y-m-d", strtotime($_POST['tmt_jabatan']));
		$isi['sk_tanggal'] =  date("Y-m-d", strtotime($_POST['sk_tanggal']));
		$this->m_pegawai->jabatan_riwayat_tambah_aksi($isi);
		echo "ss";
	}
	function formjabatan_edit(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_jabatan_riwayat($data['idd']);
		$jab = $this->m_unor->ini_unor($data['val']->id_unor);
		$data['val']->nama_jab_struk = $jab->nomenklatur_jabatan;
		$data['val']->sk_tanggal = date("d-m-Y", strtotime($data['val']->sk_tanggal));
		$data['val']->tmt_jabatan = date("d-m-Y", strtotime($data['val']->tmt_jabatan));
		$this->load->view('pegawai/formjabatan_update',$data);
	}
	function formjabatan_edit_aksi(){
		$isi = $_POST;
		$isi['tmt_jabatan'] = date("Y-m-d", strtotime($_POST['tmt_jabatan']));
		$isi['sk_tanggal'] =  date("Y-m-d", strtotime($_POST['sk_tanggal']));
		$this->m_pegawai->jabatan_riwayat_edit_aksi($isi);
		echo "ss";
	}
	function formjabatan_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['no'] = $_POST['nomor'];
		$data['val'] = $this->m_pegawai->ini_jabatan_riwayat($data['idd']);
		$data['val']->sk_tanggal = date("d-m-Y", strtotime($data['val']->sk_tanggal));
		$data['val']->tmt_jabatan = date("d-m-Y", strtotime($data['val']->tmt_jabatan));
		$this->load->view('pegawai/formjabatan_hapus',$data);
	}
	function formjabatan_hapus_aksi(){
		$isi = $_POST;
		$this->m_pegawai->jabatan_riwayat_hapus_aksi($isi);
		echo "ss";
	}
	function getjfu(){
		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$jenis = $_POST['jenis'];
		$data['count'] = $this->m_pegawai->hitung_jfu($cari,$jenis);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_pegawai->get_jfu($cari,$jenis,$mulai,$batas);
			
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
///////////////////////////////////////////////////////////////////////////////////
	function formsub(){
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:"end";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['form'] = $_POST['idd'];
		$this->load->view('pegawai/formsub_'.$data['form'],$data);
	}

	function getsub(){
		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"pagingB";
		$cari = $_POST['cari'];
		$sub = $_POST['sub'];
		$data['count'] = $this->m_pegawai->hitung_pegawai_pros($cari,$sub);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_pegawai->get_pegawai_pros($cari,$mulai,$batas,$sub);
			foreach($hslquery AS $key=>$row){
					$val = json_decode($row->var_rekap_peg);
					@$data['hslquery'][$key] = $val;
					@$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					@$data['hslquery'][$key]->tempat_meninggal = $row->tempat_meninggal;
					@$data['hslquery'][$key]->tanggal_meninggal = date("d-m-Y", strtotime($row->tanggal_meninggal));
					@$data['hslquery'][$key]->sebab_meninggal = $row->sebab_meninggal;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}

	function formsub_meninggal_tambah(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}

	function formsub_meninggal_tambah_aksi(){
		if($_POST['sub']=="meninggal"){
			$peg = $this->m_pegawai->ini_pegawai($_POST['id_pegawai']);
			$peg = json_encode($peg);
			$this->m_pegawai->pros_meninggal_tambah_aksi($_POST,$peg);
		}
		echo "success";
	}

	function formsub_meninggal_edit(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$peg = $this->m_pegawai->ini_pegawai_meninggal($data['idd']);
		$val = json_decode($peg->var_rekap_peg);
		$data['val'] = $val;
		$data['val']->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
		$data['val']->tanggal_meninggal = date("d-m-Y", strtotime($peg->tanggal_meninggal));
		$data['val']->tempat_meninggal = $peg->tempat_meninggal;
		$data['val']->sebab_meninggal = $peg->sebab_meninggal;
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}

	function formsub_meninggal_edit_aksi(){
		$this->m_pegawai->pros_meninggal_edit_aksi($_POST);
		echo "success";
	}

	function formsub_meninggal_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$peg = $this->m_pegawai->ini_pegawai_meninggal($data['idd']);
		$val = json_decode($peg->var_rekap_peg);
		$data['val'] = $val;
		$data['val']->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
		$data['val']->tanggal_meninggal = date("d-m-Y", strtotime($peg->tanggal_meninggal));
		$data['val']->tempat_meninggal = $peg->tempat_meninggal;
		$data['val']->sebab_meninggal = $peg->sebab_meninggal;
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_hapus',$data);
	}

	function formsub_meninggal_hapus_aksi(){
		$peg = $this->m_pegawai->ini_pegawai_meninggal($_POST['id_pegawai']);
		$val = json_decode($peg->var_rekap_peg);

		$this->m_pegawai->pros_meninggal_hapus_aksi($val);
		echo "success";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	function getsub_cltn(){
		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"pagingB";
		$cari = $_POST['cari'];
		$sub = $_POST['sub'];
		$data['count'] = $this->m_pegawai->hitung_pegawai_pros($cari,$sub);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_pegawai->get_pegawai_pros($cari,$mulai,$batas,$sub);
			foreach($hslquery AS $key=>$row){
					$val = json_decode($row->var_rekap_peg);
					@$data['hslquery'][$key] = $val;
					@$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					@$data['hslquery'][$key]->tanggal_keluar = date("d-m-Y", strtotime($row->tanggal_keluar));
					@$data['hslquery'][$key]->no_sk = $row->no_sk;
					@$data['hslquery'][$key]->tanggal_sk =  date("d-m-Y", strtotime($row->tanggal_sk));
					@$data['hslquery'][$key]->instansi_tujuan = $row->instansi_tujuan;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formsub_cltn_tambah(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}
	function formsub_cltn_tambah_aksi(){
			$peg = $this->m_pegawai->ini_pegawai($_POST['id_pegawai']);
			$peg = json_encode($peg);
			$this->m_pegawai->pros_cltn_tambah_aksi($_POST,$peg);
		echo "success";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////
	function getsub_keluar(){
		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"pagingB";
		$cari = $_POST['cari'];
		$sub = $_POST['sub'];
		$data['count'] = $this->m_pegawai->hitung_pegawai_pros($cari,$sub);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_pegawai->get_pegawai_pros($cari,$mulai,$batas,$sub);
			foreach($hslquery AS $key=>$row){
					$val = json_decode($row->var_rekap_peg);
					@$data['hslquery'][$key] = $val;
					@$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					@$data['hslquery'][$key]->tanggal_keluar = date("d-m-Y", strtotime($row->tanggal_keluar));
					@$data['hslquery'][$key]->no_sk = $row->no_sk;
					@$data['hslquery'][$key]->tanggal_sk =  date("d-m-Y", strtotime($row->tanggal_sk));
					@$data['hslquery'][$key]->instansi_tujuan = $row->instansi_tujuan;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formsub_keluar_tambah(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}
	function formsub_keluar_tambah_aksi(){
			$peg = $this->m_pegawai->ini_pegawai($_POST['id_pegawai']);
			$peg = json_encode($peg);
			$this->m_pegawai->pros_keluar_tambah_aksi($_POST,$peg);
		echo "success";
	}
	function formsub_keluar_edit(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$peg = $this->m_pegawai->ini_pegawai_keluar($data['idd']);
		$val = json_decode($peg->var_rekap_peg);
		$data['val'] = $val;
		$data['val']->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
		$data['val']->tanggal_keluar = date("d-m-Y", strtotime($peg->tanggal_keluar));
		$data['val']->no_sk = $peg->no_sk;
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($peg->tanggal_sk));
		$data['val']->instansi_tujuan = $peg->instansi_tujuan;
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}

	function formsub_keluar_edit_aksi(){
		$this->m_pegawai->pros_keluar_edit_aksi($_POST);
		echo "success";
	}
	function formsub_keluar_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$peg = $this->m_pegawai->ini_pegawai_keluar($data['idd']);
		$val = json_decode($peg->var_rekap_peg);
		$data['val'] = $val;
		$data['val']->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
		$data['val']->tanggal_keluar = date("d-m-Y", strtotime($peg->tanggal_keluar));
		$data['val']->no_sk = $peg->no_sk;
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($peg->tanggal_sk));
		$data['val']->instansi_tujuan = $peg->instansi_tujuan;
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_hapus',$data);
	}

	function formsub_keluar_hapus_aksi(){
		$peg = $this->m_pegawai->ini_pegawai_keluar($_POST['id_pegawai']);
		$val = json_decode($peg->var_rekap_peg);

		$this->m_pegawai->pros_keluar_hapus_aksi($val);
		echo "success";
	}


	function getsub_pensiun(){
		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"pagingB";
		$cari = $_POST['cari'];
		$sub = $_POST['sub'];
		$data['count'] = $this->m_pegawai->hitung_pegawai_pros($cari,$sub);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_pegawai->get_pegawai_pros($cari,$mulai,$batas,$sub);
			foreach($hslquery AS $key=>$row){
					$val = json_decode($row->var_rekap_peg);
					@$data['hslquery'][$key] = $val;
					@$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					@$data['hslquery'][$key]->tanggal_pensiun = date("d-m-Y", strtotime($row->tanggal_pensiun));
					@$data['hslquery'][$key]->no_sk = $row->no_sk;
					@$data['hslquery'][$key]->tanggal_sk =  date("d-m-Y", strtotime($row->tanggal_sk));
					@$data['hslquery'][$key]->jenis_pensiun = $row->jenis_pensiun;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formsub_pensiun_tambah(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}
	function formsub_pensiun_tambah_aksi(){
			$peg = $this->m_pegawai->ini_pegawai($_POST['id_pegawai']);
			$peg = json_encode($peg);
			$this->m_pegawai->pros_pensiun_tambah_aksi($_POST,$peg);
		echo "success";
	}
	function formsub_pensiun_edit(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$peg = $this->m_pegawai->ini_pegawai_pensiun($data['idd']);
		$val = json_decode($peg->var_rekap_peg);
		$data['val'] = $val;
		$data['val']->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
		$data['val']->tanggal_pensiun = date("d-m-Y", strtotime($peg->tanggal_pensiun));
		$data['val']->no_sk = $peg->no_sk;
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($peg->tanggal_sk));
		$data['val']->jenis_pensiun = $peg->jenis_pensiun;
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update',$data);
	}

	function formsub_pensiun_edit_aksi(){
		$this->m_pegawai->pros_pensiun_edit_aksi($_POST);
		echo "success";
	}
	function formsub_pensiun_hapus(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$peg = $this->m_pegawai->ini_pegawai_pensiun($data['idd']);
		$val = json_decode($peg->var_rekap_peg);
		$data['val'] = $val;
		$data['val']->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
		$data['val']->tanggal_pensiun = date("d-m-Y", strtotime($peg->tanggal_pensiun));
		$data['val']->no_sk = $peg->no_sk;
		$data['val']->tanggal_sk = date("d-m-Y", strtotime($peg->tanggal_sk));
		$data['val']->jenis_pensiun = $peg->jenis_pensiun;
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_hapus',$data);
	}

	function formsub_pensiun_hapus_aksi(){
		$peg = $this->m_pegawai->ini_pegawai_pensiun($_POST['id_pegawai']);
		$val = json_decode($peg->var_rekap_peg);

		$this->m_pegawai->pros_pensiun_hapus_aksi($val);
		echo "success";
	}

	function formsub_penambahan_aksi(){
//			$peg = $this->m_pegawai->ini_pegawai($_POST['id_pegawai']);
//			$peg = json_encode($peg);
			$this->m_pegawai->pros_penambahan_aksi($_POST);
		echo "success";
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         PROSES REKON PEGAWAI MASTER
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function formsub_pensiun(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$data['peg'] = $this->m_pegawai->ini_pegawai_master($data['idd']);
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update_non',$data);
	}
	function formsub_pensiun_aksi(){
			$master = $this->m_pegawai->ini_pegawai_master($_POST['id_pegawai']);
			$pkt = $this->m_pegawai->ini_pegawai_pangkat($_POST['id_pegawai']);
			$jab = $this->m_pegawai->ini_pegawai_jabatan($_POST['id_pegawai']);
			$pend = $this->m_pegawai->ini_pegawai_pendidikan($_POST['id_pegawai']);
			$cpns = $this->m_pegawai->ini_cpns($_POST['id_pegawai']);
			$pns = $this->m_pegawai->ini_pns($_POST['id_pegawai']);
			
			$peg = array();
			$pkt = end($pkt);
			$pend = end($pend);
			$jab = end($jab);
			
			$peg['id_pegawai'] = $master->id_pegawai;
			$peg['nip_baru'] = $master->nip_baru;
			$peg['nama_pegawai'] = $master->nama_pegawai;
			$peg['tempat_lahir'] = $master->tempat_lahir;
			$peg['tanggal_lahir'] = $master->tanggal_lahir;
			$peg['gelar_depan'] = $master->gelar_depan;
			$peg['gelar_belakang'] = $master->gelar_belakang;
			$peg['gelar_nonakademis'] = $master->gelar_nonakademis;
			$peg['gender'] = $master->gender;
			$peg['agama'] = $master->agama;
			$peg['status_pegawai'] = $master->status_pegawai;
			$peg['kelompok_pegawai'] = $master->kelompok_pegawai;
			$peg['status_perkawinan'] = $master->status_perkawinan;

			$peg['nama_pangkat'] = @$pkt->nama_pangkat;
			$peg['nama_golongan'] = @$pkt->nama_golongan;
			$peg['kode_golongan'] = @$pkt->kode_golongan;
			$peg['mk_gol_tahun'] = @$pkt->mk_gol_tahun;
			$peg['mk_gol_bulan'] = @$pkt->mk_gol_bulan;
			$peg['tmt_pangkat'] = @$pkt->tmt_golongan;

			$peg['tmt_cpns'] = @$cpns->tmt_cpns;
			$peg['tmt_pns'] = @$pns->tmt_pns;

			$peg['id_unor'] = @$jab->id_unor;
			$peg['kode_unor'] = @$jab->kode_unor;
			$peg['nama_unor'] = @$jab->nama_unor;
			$peg['nomenklatur_jabatan'] = @$jab->nama_jabatan;
			$peg['nomenklatur_pada'] = @$jab->nomenklatur_pada;
			// $peg['kode_ese'] = @$jab->kode_ese;
			// $peg['nama_ese'] = @$jab->nama_ese;
			$peg['tmt_jabatan'] = @$jab->tmt_jabatan;
			$peg['jab_type'] = @$jab->nama_jenis_jabatan;

			$peg['id_pendidikan'] = @$pend->id_pendidikan;
			$peg['nama_pendidikan'] = @$pend->nama_pendidikan;
			$peg['nama_jenjang'] = @$pend->nama_jenjang;
			$peg['nama_sekolah'] = @$pend->nama_sekolah;
			$peg['tanggal_lulus'] = @$pend->tanggal_lulus;
			$peg['tahun_lulus'] = @$pend->tahun_lulus;

			$peg = json_encode($peg);
			$peg = str_replace("null","\"\"",$peg);
			$this->m_pegawai->pros_pensiun_tambah_aksi($_POST,$peg);
			
			echo $peg;
	}

	function formsub_meninggal(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$data['peg'] = $this->m_pegawai->ini_pegawai_master($data['idd']);
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update_non',$data);
	}

	function formsub_meninggal_aksi(){
			$master = $this->m_pegawai->ini_pegawai_master($_POST['id_pegawai']);
			$pkt = $this->m_pegawai->ini_pegawai_pangkat($_POST['id_pegawai']);
			$jab = $this->m_pegawai->ini_pegawai_jabatan($_POST['id_pegawai']);
			$pend = $this->m_pegawai->ini_pegawai_pendidikan($_POST['id_pegawai']);
			$cpns = $this->m_pegawai->ini_cpns($_POST['id_pegawai']);
			$pns = $this->m_pegawai->ini_pns($_POST['id_pegawai']);
			
			$peg = array();
			$pkt = end($pkt);
			$pend = end($pend);
			$jab = end($jab);
			
			$peg['id_pegawai'] = $master->id_pegawai;
			$peg['nip_baru'] = $master->nip_baru;
			$peg['nama_pegawai'] = $master->nama_pegawai;
			$peg['tempat_lahir'] = $master->tempat_lahir;
			$peg['tanggal_lahir'] = $master->tanggal_lahir;
			$peg['gelar_depan'] = $master->gelar_depan;
			$peg['gelar_belakang'] = $master->gelar_belakang;
			$peg['gelar_nonakademis'] = $master->gelar_nonakademis;
			$peg['gender'] = $master->gender;
			$peg['agama'] = $master->agama;
			$peg['status_perkawinan'] = $master->status_perkawinan;

			$peg['nama_pangkat'] = @$pkt->nama_pangkat;
			$peg['nama_golongan'] = @$pkt->nama_golongan;
			$peg['kode_golongan'] = @$pkt->kode_golongan;
			$peg['mk_gol_tahun'] = @$pkt->mk_gol_tahun;
			$peg['mk_gol_bulan'] = @$pkt->mk_gol_bulan;
			$peg['tmt_pangkat'] = @$pkt->tmt_golongan;

			$peg['tmt_cpns'] = @$cpns->tmt_cpns;
			$peg['tmt_pns'] = @$pns->tmt_pns;

			$peg['id_unor'] = @$jab->id_unor;
			$peg['kode_unor'] = @$jab->kode_unor;
			$peg['nama_unor'] = @$jab->nama_unor;
			$peg['nomenklatur_jabatan'] = @$jab->nama_jabatan;
			$peg['nomenklatur_pada'] = @$jab->nomenklatur_pada;
			// $peg['kode_ese'] = @$jab->kode_ese;
			// $peg['nama_ese'] = @$jab->nama_ese;
			$peg['tmt_jabatan'] = @$jab->tmt_jabatan;
			$peg['jab_type'] = @$jab->nama_jenis_jabatan;

			$peg['id_pendidikan'] = @$pend->id_pendidikan;
			$peg['nama_pendidikan'] = @$pend->nama_pendidikan;
			$peg['nama_jenjang'] = @$pend->nama_jenjang;
			$peg['nama_sekolah'] = @$pend->nama_sekolah;
			$peg['tanggal_lulus'] = @$pend->tanggal_lulus;
			$peg['tahun_lulus'] = @$pend->tahun_lulus;

			$peg = json_encode($peg);
			$peg = str_replace("null","\"\"",$peg);
			$this->m_pegawai->pros_meninggal_tambah_aksi($_POST,$peg);
		
			echo $peg;
	}

	function formsub_keluar(){
		$data['idd'] = $_POST['idd'];
		$data['nomor'] = $_POST['nomor'];
		$data['peg'] = $this->m_pegawai->ini_pegawai_master($data['idd']);
		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update_non',$data);
	}

	function formsub_keluar_aksi(){
			$master = $this->m_pegawai->ini_pegawai_master($_POST['id_pegawai']);
			$pkt = $this->m_pegawai->ini_pegawai_pangkat($_POST['id_pegawai']);
			$jab = $this->m_pegawai->ini_pegawai_jabatan($_POST['id_pegawai']);
			$pend = $this->m_pegawai->ini_pegawai_pendidikan($_POST['id_pegawai']);
			$cpns = $this->m_pegawai->ini_cpns($_POST['id_pegawai']);
			$pns = $this->m_pegawai->ini_pns($_POST['id_pegawai']);
			
			$peg = array();
			$pkt = end($pkt);
			$pend = end($pend);
			$jab = end($jab);
			
			$peg['id_pegawai'] = $master->id_pegawai;
			$peg['nip_baru'] = $master->nip_baru;
			$peg['nama_pegawai'] = $master->nama_pegawai;
			$peg['tempat_lahir'] = $master->tempat_lahir;
			$peg['tanggal_lahir'] = $master->tanggal_lahir;
			$peg['gelar_depan'] = $master->gelar_depan;
			$peg['gelar_belakang'] = $master->gelar_belakang;
			$peg['gelar_nonakademis'] = $master->gelar_nonakademis;
			$peg['gender'] = $master->gender;
			$peg['agama'] = $master->agama;
			$peg['status_perkawinan'] = $master->status_perkawinan;

			$peg['nama_pangkat'] = @$pkt->nama_pangkat;
			$peg['nama_golongan'] = @$pkt->nama_golongan;
			$peg['kode_golongan'] = @$pkt->kode_golongan;
			$peg['mk_gol_tahun'] = @$pkt->mk_gol_tahun;
			$peg['mk_gol_bulan'] = @$pkt->mk_gol_bulan;
			$peg['tmt_pangkat'] = @$pkt->tmt_golongan;

			$peg['tmt_cpns'] = @$cpns->tmt_cpns;
			$peg['tmt_pns'] = @$pns->tmt_pns;

			$peg['id_unor'] = @$jab->id_unor;
			$peg['kode_unor'] = @$jab->kode_unor;
			$peg['nama_unor'] = @$jab->nama_unor;
			$peg['nomenklatur_jabatan'] = @$jab->nama_jabatan;
			$peg['nomenklatur_pada'] = @$jab->nomenklatur_pada;
			// $peg['kode_ese'] = @$jab->kode_ese;
			// $peg['nama_ese'] = @$jab->nama_ese;
			$peg['tmt_jabatan'] = @$jab->tmt_jabatan;
			$peg['jab_type'] = @$jab->nama_jenis_jabatan;

			$peg['id_pendidikan'] = @$pend->id_pendidikan;
			$peg['nama_pendidikan'] = @$pend->nama_pendidikan;
			$peg['nama_jenjang'] = @$pend->nama_jenjang;
			$peg['nama_sekolah'] = @$pend->nama_sekolah;
			$peg['tanggal_lulus'] = @$pend->tanggal_lulus;
			$peg['tahun_lulus'] = @$pend->tahun_lulus;

			$peg = json_encode($peg);
			$peg = str_replace("null","\"\"",$peg);
//			$this->m_pegawai->pros_keluar_aksi($_POST,$peg);
		
			echo $peg;
	}

	function formsub_lihat(){
		$id_pegawai = $_POST['idd'];
		$data['id_unor'] = $_POST['nomor'];

		$this->session->set_userdata("pegawai_info",$id_pegawai);
		$data['data'] = $this->m_pegawai->ini_pegawai_master($id_pegawai);

	
		$foto = $this->m_pegawai->ini_pegawai_foto($id_pegawai);
		$data['fotoSrc']=site_url()."assets/file/".$foto->foto;

		// $jabatan = end($this->m_pegawai->ini_pegawai_jabatan($id_pegawai));
		// $data['data']->tmt_jabatan=$jabatan->tmt_jabatan;

		// $data['cpns']=$this->m_pegawai->ini_cpns($id_pegawai);
		// $data['pns']=$this->m_pegawai->ini_pns($id_pegawai);

		$pangkat = end($this->m_pegawai->ini_pegawai_pangkat($id_pegawai));
		$data['data']->tmt_pangkat=$pangkat->tmt_golongan;
		$data['data']->nama_pangkat=$pangkat->nama_pangkat;
		$data['data']->nama_golongan=$pangkat->nama_golongan;

		$this->load->view('pegawai/formsub_'.$_POST['sub'].'_update_non',$data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         PROSES INJEK K2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////CEK USER GRUP 7 (pegawai) YANG TIDAK ADA DI USER_PEGAWAI///////////////
	function injek_k2(){
		$this->db->from('users');
		$this->db->where('group_id',7);
		$hsl = $this->db->get()->result();
		$no=1;
		foreach($hsl as $ky=>$vl){
				$this->db->from('user_pegawai');
				$this->db->where('user_id',$vl->user_id);
				$hl = $this->db->get()->row();
				
				if(empty($hl)){
						$this->db->from('rekap_peg');
						$this->db->where('nip_baru',$vl->username);
						$sl = $this->db->get()->row();
					echo $no." - ".$vl->nama_user." - ".$vl->username." - ".$sl->id_pegawai."<br/>";
					$no++;
				}
		}
	}

//////INJEK USER UNTUK K2///////////////
	function injek_k2_MB(){
		$this->db->from('rekap_peg');
		$this->db->order_by('nama_pegawai');
		$hsl = $this->db->get()->result();
		$no=1;
		foreach($hsl as $ky=>$vl){
				$this->db->from('user_pegawai');
				$this->db->where('id_pegawai',$vl->id_pegawai);
				$hl = $this->db->get()->row();
				if(empty($hl)){

							$this->db->set('group_id',7);
							$this->db->set('username',$vl->nip_baru);
					        $this->db->set('nama_user',$vl->nama_pegawai);
							$this->db->set('passwd',sha1($vl->nip_baru));
							$this->db->insert('users');
							$user_id = $this->db->insert_id();

							$this->db->set('user_id',$user_id);
							$this->db->set('id_pegawai',$vl->id_pegawai);
							$this->db->insert('user_pegawai');
				
					echo $no." - ".$vl->nip_baru." - ".$vl->id_pegawai." - ".$vl->nama_pegawai." - ".@$hl->kode_unor."<br/>";
					$no++;
				}
		}
	}

//////CEK UNTUK KEKUATAN PEGAWAI///////////////
	function injek_k2_XC(){
		$this->db->from('rekap_peg');
		$this->db->order_by('nama_pegawai');
		$hsl = $this->db->get()->result();
		$no=1;
		foreach($hsl as $ky=>$vl){
			if($vl->kode_unor==""){

				$this->db->from('r_peg_jab');
				$this->db->where('id_pegawai',$vl->id_pegawai);
				$hl = $this->db->get()->row();
				if(!empty($hl)){
//							$this->db->set('kode_unor',$hl->kode_unor);
//							$this->db->where('id_pegawai',$vl->id_pegawai);
//							$this->db->update('rekap_peg');
					echo $no." - ".$vl->nip_baru." - ".$vl->id_pegawai." - ".$vl->nama_pegawai." - ".@$hl->kode_unor."<br/>";
					$no++;
				}
			}
		}
	}
//////perbaikan kode golongan= 0 padahal ada di r_peg_golongan///////////////
	function injek_k2_PKT(){
		$this->db->from('rekap_peg');
		$this->db->where('kode_golongan',0);
		$hsl = $this->db->get()->result();
		$no=1;
		foreach($hsl as $ky=>$vl){
			$this->db->from('r_peg_golongan');
			$this->db->order_by('tmt_golongan','asc');
			$this->db->where('id_pegawai',$vl->id_pegawai);
			$hl = $this->db->get()->result();

			if(!empty($hl)){
				$gol = end($hl);
				$ada = $gol->tmt_golongan;
							$this->db->set('tmt_pangkat',$gol->tmt_golongan);
							$this->db->set('nama_pangkat',$gol->nama_pangkat);
							$this->db->set('nama_golongan',$gol->nama_golongan);
							$this->db->set('kode_golongan',$gol->kode_golongan);
							$this->db->set('mk_gol_tahun',$gol->mk_gol_tahun);
							$this->db->set('mk_gol_bulan',$gol->mk_gol_bulan);
							$this->db->where('id_pegawai',$vl->id_pegawai);
							$this->db->update('rekap_peg');
				
			} else {	$ada="";	}
			echo $no." - ".$vl->nama_pegawai.$ada."<br/>";
			$no++;
		}
	}



//////perbaikan nama golongan yang kebalik sama nama pangkat///////////////
	function injek_k2_rekon_pangkat(){
		$pkt = $this->dropdowns->kode_golongan_pangkat();

		$this->db->from('rekap_peg');
		$hsl = $this->db->get()->result();
		$no=1;
		foreach($hsl as $ky=>$vl){
			if($vl->kode_golongan!=0){
				$pkt_X=explode(",",$pkt[$vl->kode_golongan]);
				$nm_pangkat = trim($pkt_X[1]);
				$nm_golongan = trim($pkt_X[0]);
					if($nm_pangkat!=$vl->nama_pangkat){
							$this->db->set('nama_golongan',$nm_golongan);
							$this->db->set('nama_pangkat',$nm_pangkat);
							$this->db->where('id_pegawai',$vl->id_pegawai);
							$this->db->update('rekap_peg');
						echo $no." - ".$vl->id_pegawai."<br/>";
						$no++;
					}
			}
		}

		$this->db->from('r_peg_golongan');
		$hsl = $this->db->get()->result();
		$no=1;
		foreach($hsl as $ky=>$vl){
			if($vl->kode_golongan!=0){
				$pkt_X=explode(",",$pkt[$vl->kode_golongan]);
				$nm_pangkat = trim($pkt_X[1]);
				$nm_golongan = trim($pkt_X[0]);
					if($nm_pangkat!=$vl->nama_pangkat){
							$this->db->set('nama_golongan',$nm_golongan);
							$this->db->set('nama_pangkat',$nm_pangkat);
							$this->db->where('id_peg_golongan',$vl->id_peg_golongan);
							$this->db->update('r_peg_golongan');
						echo $no." - ".$vl->nama_pegawai."<br/>";
						$no++;
					}
			}
		}


	}

	function injek_k2_ASLI(){
		$sqlstr="SELECT * FROM (k2_gregs)";
		$query = $this->db->query($sqlstr)->result(); 
		
		$idd = 42501;
		foreach($query AS $key=>$val){
			$sqr="SELECT * FROM r_pegawai WHERE nip_baru='".$val->nip_baru."'";
			$qr = $this->db->query($sqr)->row();
			$ada = (empty($qr))?"kosong":"ada";

			$sqr2="SELECT * FROM m_pendidikan WHERE nama_pendidikan='".$val->nama_pendidikan."'";
			$qr2= $this->db->query($sqr2)->row();
			$pend = (empty($qr2))?"kosong":$qr2->nama_pendidikan;


			echo $val->nip_baru."/".$val->nama_pegawai."/".$val->tempat_lahir."/".date("Y-m-d", strtotime($val->tanggal_lahir))."/".$ada."/".date("Y-m-d", strtotime($val->tmt_pangkat))."/".$pend."<br/>";

			if($ada=="kosong"){
				$idp['id_pegawai'] = $idd;
				$idp['nip_baru'] = $val->nip_baru;
				$idp['nama_pegawai'] = $val->nama_pegawai;
				$idp['tempat_lahir'] = $val->tempat_lahir;
				$idp['tanggal_lahir'] = date("Y-m-d", strtotime($val->tanggal_lahir));
				$idp['agama'] = $val->agama;
				$idp['gender'] = $val->gender;
				$idp['status_perkawinan'] = $val->status_perkawinan;
				$idp['tmt_pangkat'] = date("Y-m-d", strtotime($val->tmt_pangkat));
				$idp['nama_pangkat'] = $val->nama_pangkat;
				$idp['nama_golongan'] = $val->nama_golongan;
				$idp['kode_golongan'] = $val->kode_golongan;
				$this->m_pegawai->pros_injek_k2($idp);
				$idd++;
			} //endif
		} //end foreach
	}

}
?>