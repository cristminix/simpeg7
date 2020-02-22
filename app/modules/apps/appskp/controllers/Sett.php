<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sett extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skpd');
		$this->load->model('appskp/m_skp');
		$this->load->model('appbkpp/m_unor');
	}	

	function index(){
		$data['satu'] = "Setting Petugas Verifikatur";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('sett/index',$data);
	}
	function row_verifikatur(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skpd->hitung_verifikatur($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_skpd->get_verifikatur($cari,$mulai,$batas);
			$data['hslquery'] = '';
			foreach($hslquery as $row){
				$row->hal = $hal;
				$row->cari = $cari;
				$row->no=$mulai+1;
				$row->nama_pegawai = ((trim($row->gelar_depan) != '-')?trim($row->gelar_depan).' ':'').((trim($row->gelar_nonakademis) != '-')?trim($row->gelar_nonakademis).' ':'').$row->nama_pegawai.((trim($row->gelar_belakang) != '-')?', '.trim($row->gelar_belakang):'');
				$data['hslquery'] .= $this->load->view('sett/row_verifikatur',array('val'=>$row),true);
				$mulai++;
			}

			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function daftar_verifikatur_akses(){
		$data['satu'] = "Daftar Verifikatur Unor";
		$this->load->view('sett/daftar_unor_verifikatur',$data);
	}

	function verifikatur_akses(){
		$data['satu'] = "Setting Verifikatur Unor";
		$idd = $this->session->userdata('id_pengelola');
		$data['verifikatur'] = $this->m_skpd->ini_verifikatur($idd);
		$data['pegawai'] = $this->m_skpd->ini_pegawai($data['verifikatur']->id_pegawai);
		$data['pegawai']->nama_pegawai = ((trim($data['pegawai']->gelar_depan) != '-')?trim($data['pegawai']->gelar_depan).' ':'').((trim($data['pegawai']->gelar_nonakademis) != '-')?trim($data['pegawai']->gelar_nonakademis).' ':'').$data['pegawai']->nama_pegawai.((trim($data['pegawai']->gelar_belakang) != '-')?', '.trim($data['pegawai']->gelar_belakang):'');
		$data['hal'] = $this->session->userdata('hal');
		$data['cari'] = $this->session->userdata('cari');

		$this->load->view('sett/pil_unor_verifikatur',$data);
	}

	function verifikatur_lihat(){
		$data['satu'] = "Lihat Unor Verifikatur";
		$idd = $this->session->userdata('id_pengelola');
		$data['verifikatur'] = $this->m_skpd->ini_verifikatur($idd);
		$data['pegawai'] = $this->m_skpd->ini_pegawai($data['verifikatur']->id_pegawai);
		$data['pegawai']->nama_pegawai = ((trim($data['pegawai']->gelar_depan) != '-')?trim($data['pegawai']->gelar_depan).' ':'').((trim($data['pegawai']->gelar_nonakademis) != '-')?trim($data['pegawai']->gelar_nonakademis).' ':'').$data['pegawai']->nama_pegawai.((trim($data['pegawai']->gelar_belakang) != '-')?', '.trim($data['pegawai']->gelar_belakang):'');
		$data['hal'] = $this->session->userdata('hal');
		$data['cari'] = $this->session->userdata('cari');

		$this->load->view('sett/lihat_unor_verifikatur',$data);
	}
	function verifikatur_lihat_getdata(){
		$idd = $this->session->userdata('id_pengelola');
		$verifikatur = $this->m_skpd->ini_verifikatur($idd);
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


	function getakses(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skpd->hitung_daftar($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_skpd->get_daftar($cari,$mulai,$batas);
				foreach($data['hslquery'] as $key=>$val){
					$verifikatur = $this->m_skpd->get_unor_verifikatur($val->id_unor);
					$data['hslquery'][$key]->user_id = (isset($verifikatur->user_id))?$verifikatur->user_id:"";
					$val->nama_pegawai = (isset($verifikatur->nama_pegawai))?$verifikatur->nama_pegawai:"";
					$val->gelar_depan = (isset($verifikatur->gelar_depan))?$verifikatur->gelar_depan:"";
					$val->gelar_nonakademis = (isset($verifikatur->gelar_nonakademis))?$verifikatur->gelar_nonakademis:"";
					$val->gelar_belakang = (isset($verifikatur->gelar_belakang))?$verifikatur->gelar_belakang:"";
					$data['hslquery'][$key]->nama_pegawai = (isset($verifikatur->nama_pegawai))?((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):''):"";
					$data['hslquery'][$key]->username = (isset($verifikatur->username))?$verifikatur->username:"";
				}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function setup_verifikatur_aksi(){
		$isi = $this->input->post();

		$verifikatur = $this->m_skpd->ini_verifikatur($isi['user_id']);
			$dd=array("{","}");
		$unorid = 	explode(",",str_replace($dd,"",$verifikatur->unor_akses));
		$unortt = 	explode(",",str_replace($dd,"",$isi['unor_pil']));
		$userada = 	explode(",",str_replace($dd,"",$isi['user_ada']));
		for($i=0;$i<count($unortt);$i++){	
			if(!in_array($unortt[$i],$unorid)){	$unorid[] = $unortt[$i];	}
			if($userada[$i]!=$isi['user_id']){
					$veriada = $this->m_skpd->ini_verifikatur($userada[$i]);
						$dd=array("{","}");
					$unorada = 	explode(",",str_replace($dd,"",$veriada->unor_akses));
					$unortc = "";$jj=0;
					foreach($unorada AS $val){	if($val!="" && $val!=$unortt[$i]){	if($jj==0){	$unortc=$unortc.$val;	} else {	$unortc=$unortc.",".$val;	}	$jj++;}	}
					$iji['unor_pil'] = "{".$unortc."}";
					$iji['user_id'] = $userada[$i];
					$this->m_skpd->setup_verifikatur_aksi($iji);
			}
		}
		$unortb = "";$ii=0;
		foreach($unorid AS $val){	if($val!=""){	if($ii==0){	$unortb=$unortb.$val;	} else {	$unortb=$unortb.",".$val;	}	$ii++;}	}
		$isi['unor_pil'] = "{".$unortb."}";

		$this->m_skpd->setup_verifikatur_aksi($isi);
		echo end($unorid);
	}

	function setup_petugas_aksi(){
		$isi = $this->input->post();
		$this->m_skpd->setup_petugas_aksi($isi);
		echo "success";
	}

	function pengelola(){
		$data['satu'] = "Setting Pengelola Kepegawaian";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('sett/pengelola',$data);
	}

	function row_pengelola(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skpd->hitung_pengelola($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_skpd->get_pengelola($cari,$mulai,$batas);
			$data['hslquery'] = '';
			foreach($hslquery as $row){
				$row->hal = $hal;
				$row->cari = $cari;
				$row->no=$mulai+1;
				$data['hslquery'] .= $this->load->view('sett/row_pengelola',array('val'=>$row),true);
				$mulai++;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function pengelola_tambah_form(){
		$this->load->view('sett/form_update_pengelola');
	}
	function pengelola_tambah_aksi(){
 		$this->form_validation->set_rules("nama_user","Nama pengelola","trim|required|xss_clean");
 		$this->form_validation->set_rules("username","Username","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_skpd->pengelola_tambah_aksi($this->input->post());
		}

		echo "success";
	}
	function pengelola_edit_form(){
		$data['pengelola'] = $this->m_skpd->ini_pengelola($_POST['idd']);
		$this->load->view('sett/form_update_pengelola',$data);
	}
	function pengelola_edit_aksi(){
 		$this->form_validation->set_rules("user_id","","trim|required|xss_clean");
 		$this->form_validation->set_rules("nama_user","Nama pengelola","trim|required|xss_clean");
 		$this->form_validation->set_rules("username","Username","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_skpd->pengelola_edit_aksi($this->input->post());
		}

		echo "success";
	}
	function pengelola_hapus_form(){
		$data['pengelola'] = $this->m_skpd->ini_pengelola($_POST['idd']);
		$this->load->view('sett/form_hapus_pengelola',$data);
	}
	function pengelola_hapus_aksi(){
 		$this->form_validation->set_rules("user_id","","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_skpd->pengelola_hapus_aksi($this->input->post());
		}
		echo "success";
	}

	function daftar_pengelola_akses(){
		$data['satu'] = "Daftar Pengelola Unor";
		$this->load->view('sett/daftar_unor_pengelola',$data);
	}

	function pengelola_akses(){
		$data['satu'] = "Setting Pengelola Unor";
		$idd = $this->session->userdata('id_pengelola');
		$data['pengelola'] = $this->m_skpd->ini_pengelola($idd);
		$data['hal'] = $this->session->userdata('hal');
		$data['cari'] = $this->session->userdata('cari');
		$this->load->view('sett/pil_unor_pengelola',$data);
	}

	function getakses_pengelola(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skpd->hitung_daftar($cari,"no");

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_skpd->get_daftar($cari,$mulai,$batas,"no");

				foreach($data['hslquery'] as $key=>$val){
					$pengelola = $this->m_skpd->get_unor_pengelola($val->id_unor);
					$data['hslquery'][$key]->pengelola = (empty($pengelola))?"":$pengelola;
//					$data['hslquery'][$key]->nama_user = (isset($pengelola->nama_user))?$pengelola->nama_user:"";
//					$data['hslquery'][$key]->username = (isset($pengelola->username))?$pengelola->username:"";
				}

			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}


	function setup_pengelola_aksi(){
		$dd=array("{","}");
		$isi = $this->input->post();
		$unortt = 	explode(",",str_replace($dd,"",$isi['unor_pil']));
		$pengelola = $this->m_skpd->ini_pengelola($isi['user_id']);
		$unorid = 	explode(",",str_replace($dd,"",$pengelola->unor_akses));

		for($i=0;$i<count($unortt);$i++){	if(!in_array($unortt[$i],$unorid)){	$unorid[] = $unortt[$i];	}	}
		$unortb = "";$ii=0;
		foreach($unorid AS $val){	if($val!=""){	if($ii==0){	$unortb=$unortb.$val;	} else {	$unortb=$unortb.",".$val;	}	$ii++;	}	}
		$isi['unor_pil'] = "{".$unortb."}";

		$this->m_skpd->setup_pengelola_aksi($isi);
		echo "success";
	}

	function pengelola_lihat(){
		$data['satu'] = "Lihat Pengelola Unor";
		$idd = $this->session->userdata('id_pengelola');
		$data['pengelola'] = $this->m_skpd->ini_pengelola($idd);
		$data['hal'] = $this->session->userdata('hal');
		$data['cari'] = $this->session->userdata('cari');
		$this->load->view('sett/lihat_unor_pengelola',$data);
	}
	function pengelola_lihat_getdata(){
		$idd = $this->session->userdata('id_pengelola');
		$pengelola = $this->m_skpd->ini_pengelola($idd);
			$dd=array("{","}");
		$unorin = ($pengelola->unor_akses=="{}")?"00":str_replace($dd,"",$pengelola->unor_akses);
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

	function pegawai_skp(){
		$data['satu'] = "Setting User Pegawai";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$this->load->view('sett/pegawai_skp',$data);
	}

	function row_pegawai_skp(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_skpd->hitung_pegawai_skp($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_skpd->get_pegawai_skp($cari,$mulai,$batas);
			$data['hslquery'] = '';
			foreach($hslquery as $row){
//				$user = $this->m_skpd->ini_user_pegawai_skp($row->user_id);
//				$row->user_id=(isset($user->user_id))?$user->user_id:"xx";;
//				$row->username=(isset($user->username))?$user->username:"xx";

//				$rn = $this->m_skp->get_pegawai($user->id_pegawai);
				
//				$row->nama_pegawai = $rn->nama_pegawai;


				$row->batas = $batas;
				$row->hal = $hal;
				$row->cari = $cari;
				$row->no=$mulai+1;
				$data['hslquery'] .= $this->load->view('sett/row_pegawai_skp',array('val'=>$row),true);
				$mulai++;
			}
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
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
		$data['count'] = $this->m_skpd->hitung_pegawai($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$hslquery = $this->m_skpd->get_pegawai($cari,$mulai,$batas);
			$data['hslquery'] = '';
			foreach($hslquery as $row){
				$user = $this->m_skpd->ini_user_pegawai($row->id_pegawai);
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

	function lihatDataPegawai(){
		$data['satu'] = "Lihat Data Pegawai";
		$data['user'] = $this->m_skpd->ini_user($this->session->userdata('idu'));
		$data['hal'] = $this->session->userdata('hal');
		$data['cari'] = $this->session->userdata('cari');
		$data['batas'] = $this->session->userdata('batas');
		$data['asal'] = $this->session->userdata('asal');
		$this->load->view('skp_formpegawai/data',$data);
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
	function ganti_password_aksi(){
		$_POST['pw1'] = $this->security->xss_clean($this->input->post('pw1'));
		$_POST['pw2'] = $this->security->xss_clean($this->input->post('pw2'));
		if($_POST['pw1']!="" && $_POST['pw1']==$_POST['pw2']){
			$_POST['user_id'] = $this->session->userdata('user_id');
			$this->m_skpd->ganti_password($_POST);
			echo "success";
		} else {
			echo "successv";
		}
	}
	function reset_password(){
		$data['satu'] = "Reset Password Pengguna";
		$data['user'] = $this->m_skpd->ini_user($this->session->userdata('idu'));
		$sess = $this->session->userdata('logged_in');
		$data['user']->group = $sess['group_name'];
		$data['hal'] = $this->session->userdata('hal');
		$data['cari'] = $this->session->userdata('cari');
		$data['batas'] = $this->session->userdata('batas');
		$data['asal'] = $this->session->userdata('asal');
		$this->load->view('sett/form_reset_password',$data);
	}
	function reset_password_aksi(){
		$_POST['pw1'] = $this->security->xss_clean($this->input->post('pw1'));
		$_POST['pw2'] = $this->security->xss_clean($this->input->post('pw2'));
		if($_POST['pw1']!="" && $_POST['pw1']==$_POST['pw2']){
			$_POST['user_id'] = $this->session->userdata('idu');
			$this->m_skpd->ganti_password($_POST);
			echo "success";
		} else {
			echo "successv";
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////
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

	function pantau_target(){
		$data['satu'] = "Menyusun Target Kinerja";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['unor'] = $this->m_unor->gettree(0,5,"2015-01-01"); 
		$data['tahun'] = "2015"; 
		$this->load->view('sett/pantau_target',$data);
	}

	function get_pantau_target(){
		$cari = $_POST['cari'];
		$tahun = $_POST['tahun'];
		$kode_unor = $_POST['kode_unor'];
		$data['count'] = $this->m_skpd->hitung_pantau_target($cari,$tahun,$kode_unor);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$bulan = $this->dropdowns->bulan();
			$tahapan_skp = $this->dropdowns->tahapan_skp();
			$data['hslquery'] = $this->m_skpd->get_pantau_target($cari,$mulai,$batas,$tahun,$kode_unor);
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

	function pantau_target_non(){
		$data['satu'] = "Tidak Menyusun Target Kinerja";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['unor'] = $this->m_unor->gettree(0,5,"2015-01-01"); 
		$data['tahun'] = "2015"; 
		$this->load->view('sett/pantau_target_non',$data);
	}

	function get_pantau_target_non(){
		$cari = $_POST['cari'];
		$tahun = $_POST['tahun'];
		$kode_unor = $_POST['kode_unor'];
		$data['count'] = $this->m_skpd->hitung_pantau_target_non($cari,$tahun,$kode_unor);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$bulan = $this->dropdowns->bulan();
			$tahapan_skp = $this->dropdowns->tahapan_skp();
			$data['hslquery'] = $this->m_skpd->get_pantau_target_non($cari,$mulai,$batas,$tahun,$kode_unor);
				foreach($data['hslquery'] as $key=>$val){
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
				}
/*
				foreach($data['hslquery'] as $key=>$val){
					@$data['hslquery'][$key]->bulan_mulai = $bulan[$val->bulan_mulai];
					@$data['hslquery'][$key]->bulan_selesai = $bulan[$val->bulan_selesai];
					@$data['hslquery'][$key]->status = $tahapan_skp[$val->status];
					$data['hslquery'][$key]->nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
					$data['hslquery'][$key]->penilai_nama_pegawai = ((trim($val->penilai_gelar_depan) != '-')?trim($val->penilai_gelar_depan).' ':'').((trim($val->penilai_gelar_nonakademis) != '-')?trim($val->penilai_gelar_nonakademis).' ':'').$val->penilai_nama_pegawai.((trim($val->penilai_gelar_belakang) != '-')?', '.trim($val->penilai_gelar_belakang):'');
				}
*/
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}

	function target()
	{
		$data['satu'] = "Pemantauan Penyusunan Target Kinerja";

		$data['id_skp'] = $this->session->userdata('idskp');
		$id_penilai = $this->session->userdata('pegawai_info');

		$data['skp'] = $this->m_skp->ini_skp($data['id_skp']);
		$data['penilai'] = $this->m_skp->get_pegawai($id_penilai);
		$data['pegawai'] = $this->m_skp->get_pegawai($data['skp']->id_pegawai);
		$data['target'] = $this->m_skp->get_target($data['id_skp']);
					$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
					$data['tahapan_skp_pelaku'] = $this->dropdowns->tahapan_skp_pelaku();
					$data['tahapan_skp_nomor'] = $this->dropdowns->tahapan_skp_nomor();

		$data['hal']=$_POST['hal'];
		$data['batas']=$_POST['batas'];
		$data['cari']=$_POST['cari'];
		$this->load->view('sett/target',$data);
	}

	function pantau_realisasi(){
		$data['satu'] = "Menyusun Realisasi Kinerja";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['unor'] = $this->m_unor->gettree(0,5,"2015-01-01"); 
		$data['tahun'] = "2015"; 
		$this->load->view('sett/pantau_realisasi',$data);
	}

	function get_pantau_realisasi(){
		$cari = $_POST['cari'];
		$tahun = $_POST['tahun'];
		$kode_unor = $_POST['kode_unor'];
		$data['count'] = $this->m_skpd->hitung_pantau_realisasi($cari,$tahun,$kode_unor);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$bulan = $this->dropdowns->bulan();
			$tahapan_skp = $this->dropdowns->tahapan_realisasi();
			$data['hslquery'] = $this->m_skpd->get_pantau_realisasi($cari,$mulai,$batas,$tahun,$kode_unor);
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

	function realisasi()
	{
		$data['satu'] = "Persetujuan Realisasi Sasaran Kerja Pegawai";

		$data['id_skp'] = $this->session->userdata('idskp');
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


		$data['hal']=$_POST['hal'];
		$data['batas']=$_POST['batas'];
		$data['cari']=$_POST['cari'];
		$this->load->view('sett/realisasi',$data);
	}


}