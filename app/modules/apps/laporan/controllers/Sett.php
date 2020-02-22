<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sett extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('laporan/m_lap');
		// $this->load->model('appskp/m_skp');
		// $this->load->model('appbkpp/m_unor');
	}	

	function index(){
		$data['satu'] = "Setting Petugas Verifikatur";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('sett/index',$data);
	}

	function pegawai_X(){
		$data['satu'] = "Setting Pegawai SKP";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$this->load->view('sett/pegawai',$data);
	}

	function row_pegawai_X(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_pegawai($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_lap->get_pegawai($cari,$mulai,$batas);
			$data['hslquery'] = '';
			foreach($hslquery as $row){
				$user = $this->m_lap->ini_user_pegawai($row->id_pegawai);
				$row->user_id=(isset($user->user_id))?$user->user_id:"xx";;
				$row->username=(isset($user->username))?$user->username:"xx";
				$row->batas = $batas;
				$row->hal = $hal;
				$row->cari = $cari;
				$row->no=$mulai+1;
				$data['hslquery'] .= $this->load->view('sett/row_pegawai',array('val'=>$row),true);
				$mulai++;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}



	function set_id(){
		$this->session->set_userdata("id_pengelola",$_POST['idd']);
		$this->session->set_userdata("hal",$_POST['hal']);
		$this->session->set_userdata("cari",$_POST['cari']);
		$this->session->set_userdata("batas",$_POST['batas']);
		echo "success";
	}
	function set_idu(){
		$this->session->set_userdata("idu",$_POST['idd']);
		$this->session->set_userdata("hal",$_POST['hal']);
		$this->session->set_userdata("cari",$_POST['cari']);
		$this->session->set_userdata("asal",$_POST['asal']);
		$this->session->set_userdata("batas",$_POST['batas']);
		echo "success";
	}

	function ganti_password(){
		$data['satu'] = "Penggantian Password Pengguna";
		$data['user'] = $this->session->userdata('logged_in');
		$this->load->view('sett/form_ganti_password',$data);
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////
	function gettree(){
		$tahun = $_POST['tahun'];
		$tanggal = $tahun."-01-01";
		$unor = $this->m_unor->gettree(0,5,$tanggal); 
		$pilunor='<option value="">Semua...</option>';
		foreach($unor as $key=>$val){
			$pilunor = $pilunor.'<option value="'.$val->kode_unor.'">'.$val->nama_unor.'</option>';
		}
		echo $pilunor;
	}

	
	function kepangkatan(){
		$data['satu'] = "Laporan Kepangkatan";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/kepangkatan',$data);
	}
	function get_kepangkatan(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_kepangkatan($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			// $bulan = $this->dropdowns->bulan();
			// $tahapan_skp = $this->dropdowns->tahapan_skp();
			$data['hslquery'] = $this->m_lap->get_kepangkatan($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->sk_tanggal = date("d-m-Y", strtotime($val->sk_tanggal));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
	

function jabatan(){
		$data['satu'] = "Laporan Jabatan";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/jabatan',$data);
	}
	function get_jabatan(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_jabatan($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			
			$data['hslquery'] = $this->m_lap->get_jabatan($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->sk_tanggal = date("d-m-Y", strtotime($val->sk_tanggal));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function sanksi(){
		$data['satu'] = "Laporan Sanksi";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/sanksi',$data);
	}
	function get_sanksi(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_sanksi($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_lap->get_sanksi($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->tanggal_sk = date("d-m-Y", strtotime($val->tanggal_sk));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
	
	function penghargaan(){
		$data['satu'] = "Laporan Penghargaan";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		// $data['unor'] = $this->m_unor->gettree(0,5,"2015-01-01"); 
		$data['tahun'] = ""; 
		$this->load->view('sett/penghargaan',$data);
	}
	function get_penghargaan(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_penghargaan($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_lap->get_penghargaan($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->tanggal_sk = date("d-m-Y", strtotime($val->tanggal_sk));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}


	function kesehatan(){
		$data['satu'] = "Laporan Kesehatan";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/kesehatan',$data);
	}
	function get_kesehatan(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_kesehatan($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_lap->get_kesehatan($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->tanggal_tes = date("d-m-Y", strtotime($val->tanggal_tes));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function psikotes(){
		$data['satu'] = "Laporan Psikotes";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/psikotes',$data);
	}
	function get_psikotes(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_psikotes($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_lap->get_psikotes($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->tanggal_tes = date("d-m-Y", strtotime($val->tanggal_tes));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	
	function pengalaman(){
		$data['satu'] = "Laporan Pengalaman";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/pengalaman',$data);
	}
	function get_pengalaman(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_pengalaman($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_lap->get_pengalaman($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->tanggal_awal = date("d-m-Y", strtotime($val->tanggal_awal));
					$data['hslquery'][$key]->tanggal_akhir = date("d-m-Y", strtotime($val->tanggal_akhir));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
	
	function diklat(){
		$data['satu'] = "Laporan Diklat";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['tahun'] = ""; 
		$this->load->view('sett/diklat',$data);
	}
	function get_diklat(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_lap->hitung_diklat($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_lap->get_diklat($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->tanggal_mulai = date("d-m-Y", strtotime($val->tanggal_mulai));
					$data['hslquery'][$key]->tanggal_selesai = date("d-m-Y", strtotime($val->tanggal_selesai));
					$data['hslquery'][$key]->tanggal_sk = date("d-m-Y", strtotime($val->tanggal_sk));
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					
				}
			$data['pager'] = Modules::run("laporan/laporan/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}


}