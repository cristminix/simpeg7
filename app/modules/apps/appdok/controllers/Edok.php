<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Edok extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appdok/m_edok');
		$this->load->model('appbkpp/m_pegawai');
		date_default_timezone_set('UTC');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         PROSES DOKUMEN ELEKTRONIK
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function index(){
		$data['hal'] = $_POST['hal'];
		$data['batas'] = $_POST['batas'];
		$data['cari'] = $_POST['cari'];
		$data['idd'] = $_POST['idd'];
		$data['pegawai'] = $this->m_pegawai->ini_pegawai($data['idd']);
		$data['kode_dokumen'] = $this->dropdowns->kode_dokumen_peg();

		$this->load->view('index',$data);
	}
function pasfoto(){
	$data['id_pegawai'] = $_POST['id_pegawai'];

	$data['pegawai'] = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['alamat'] = Modules::run("datamodel/pegawai/get_peg_alamat",$data['id_pegawai']);
	$cek = $this->m_edok->cek_dokumen($data['pegawai']->nip_baru,"pasfoto",0);
	if(empty($cek)){

		$fotolama = $this->m_edok->cek_foto_lama($data['id_pegawai']);
		$pathfoto="assets/file/".$fotolama->foto;
		if(file_exists($pathfoto)){
			$fotobaru = str_replace("foto/","",$fotolama->foto);
			
			$path="assets/media/file/".$data['pegawai']->nip_baru."/";
			if(!file_exists($path)){	mkdir($path,755);	}
			$path2="assets/media/file/".$data['pegawai']->nip_baru."/pasfoto/";
			if(!file_exists($path2)){	mkdir($path2,755);	}

			copy("assets/file/foto/".$fotobaru,"assets/media/file/".$data['pegawai']->nip_baru."/pasfoto/".$fotobaru);

				$config['image_library'] = 'gd2';
				$config['width'] = 250;
				$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				$config['source_image'] = 'assets/file/foto/'.$fotobaru;
				$config['new_image'] = 'assets/media/file/'.$data['pegawai']->nip_baru.'/pasfoto/thumb_'.$fotobaru;
				$this->load->library('image_lib', $config);
				$cekG = $this->image_lib->resize();


			$this->m_edok->simpan_dokumen($data['pegawai']->nip_baru,$fotobaru,"pasfoto",0);
			
			$data['pasfoto'] = "assets/media/file/".$data['pegawai']->nip_baru."/pasfoto/".$fotobaru;
			$data['ada'] = "yes";


		} else {
			$data['pasfoto'] = "assets/file/foto/photo.jpg";
			$data['ada'] = "no";
		}




	} else {
		$data['pasfoto'] = "assets/media/file/".$data['pegawai']->nip_baru."/pasfoto/".$cek[0]->file_thumb;
		$data['ada'] = "yes";
	}

	$this->load->view('pasfoto/index',$data);
}



function sertifikat_prajab(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sertifikat_prajab";
	$cek = $this->m_edok->cek_dokumen($data['id_pegawai'],'sertifikat_prajab','0');


	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_sertifikat_prajab($_POST['id_pegawai']);
		if(!empty($data['isi'])){
			$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$data['isi']->id_peg_diklat_struk);
			$data['thumb'] = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/".$data['komponen']."/".$dok_ref[0]->file_thumb;
		} else {
			$data['thumb'] = "assets/file/foto/photo.jpg";
		}
	$this->load->view('sertifikat_prajab/index',$data);
}
function karpeg(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "karpeg";
	$cek = $this->m_edok->cek_dokumen($data['id_pegawai'],'karpeg',0);
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_karpeg($_POST['id_pegawai']);
		if(!empty($data['isi'])){
			$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$data['isi']->id_karpeg);
			$data['thumb'] = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/".$data['komponen']."/".$dok_ref[0]->file_thumb;
		} else {
			$data['thumb'] = "assets/file/foto/photo.jpg";
		}
	$this->load->view('karpeg/index',$data);
}
function konversi_nip(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "konversi_nip";
	$cek = $this->m_edok->cek_dokumen($data['id_pegawai'],'konversi_nip',0);
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_konversi_nip($_POST['id_pegawai']);
		if(!empty($data['isi'])){
			$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$data['isi']->id_konversi_nip);
			$data['thumb'] = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/".$data['komponen']."/".$dok_ref[0]->file_thumb;
		} else {
			$data['thumb'] = "assets/file/foto/photo.jpg";
		}
	$this->load->view('konversi_nip/index',$data);
}
function sk_cpns(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sk_cpns";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->ini_cpns($_POST['id_pegawai']);
		if(!empty($data['isi'])){
			$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$data['isi']->id);
			@$data['thumb'] = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sk_cpns/".$dok_ref[0]->file_thumb;
		} else {
			$data['thumb'] = "assets/file/foto/photo.jpg";
		}
	$this->load->view('sk_cpns/index',$data);
}
function sk_pns(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sk_pns";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->ini_pns($_POST['id_pegawai']);
		if(!empty($data['isi'])){
			$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$data['isi']->id);
			@$data['thumb'] = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sk_pns/".$dok_ref[0]->file_thumb;
		} else {
			$data['thumb'] = "assets/file/foto/photo.jpg";
		}
	$this->load->view('sk_pns/index',$data);
}
function sk_pangkat(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sk_pangkat";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->ini_pegawai_pangkat($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_golongan);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sk_pangkat/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('sk_pangkat/index',$data);
}
function ijazah_pendidikan(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "ijazah_pendidikan";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = Modules::run("appbkpp/pegawai/get_riwayat_pendidikan",$_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_pendidikan);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/ijazah_pendidikan/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('ijazah_pendidikan/index',$data);
}
function sk_jabatan(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sk_jabatan";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->ini_pegawai_jabatan($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_jab);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sk_jabatan/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('sk_jabatan/index',$data);
}
function sertifikat_diklat(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sertifikat_diklat";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_sertifikat_diklat($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_diklat_struk);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sertifikat_diklat/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('sertifikat_diklat/index',$data);
}
function karis_karsu(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "karis_karsu";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->ini_pegawai_pernikahan($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_perkawinan);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/karis_karsu/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('karis_karsu/index',$data);
}
function taspen(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "taspen";
	$cek = $this->m_edok->cek_dokumen($data['id_pegawai'],'taspen',0);
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_taspen($_POST['id_pegawai']);
		if(!empty($data['isi'])){
			$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$data['isi']->id_taspen);
			$data['thumb'] = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/".$data['komponen']."/".$dok_ref[0]->file_thumb;
		} else {
			$data['thumb'] = "assets/file/foto/photo.jpg";
		}
	$this->load->view('taspen/index',$data);
}
function sertifikat_kursus(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sertifikat_kursus";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_sertifikat_kursus($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_kursus);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sertifikat_kursus/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('sertifikat_kursus/index',$data);
}
function sertifikat_penghargaan(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "sertifikat_penghargaan";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_sertifikat_penghargaan($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_penghargaan);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/sertifikat_penghargaan/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('sertifikat_penghargaan/index',$data);
}
function skp(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "skp";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_skp($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_skp);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/skp/".$dok_ref[0]->file_thumb;
	}
	$this->load->view('skp/index',$data);
}
function dp3(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "dp3";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_dp3($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_dp3);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/dp3/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('dp3/index',$data);
}
function ujian_dinas(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "ujian_dinas";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_ujian_dinas($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_ujian_dinas);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/ujian_dinas/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('ujian_dinas/index',$data);
}
function penyesuaian_ijazah(){
	$data['id_pegawai'] = $_POST['id_pegawai'];
	$data['komponen'] = "penyesuaian_ijazah";
	$pegawai = $this->m_edok->ini_pegawai($data['id_pegawai']);
	$data['isi'] = $this->m_pegawai->get_penyesuaian_ijazah($_POST['id_pegawai']);
	foreach($data['isi'] AS $key=>$val){
		$dok_ref = $this->m_edok->cek_dokumen($pegawai->nip_baru,$data['komponen'],$val->id_peg_penyesuaian_ijazah);
		@$data['isi'][$key]->thumb = (empty($dok_ref))?"assets/file/foto/photo.jpg":"assets/media/file/".$pegawai->nip_baru."/penyesuaian_ijazah/".$dok_ref[0]->file_thumb;
		@$data['isi'][$key]->gbr = (empty($dok_ref))?"kosong":"ada";
	}
	$this->load->view('penyesuaian_ijazah/index',$data);
}


}
?>