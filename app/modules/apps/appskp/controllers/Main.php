<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_main');
		// $this->load->model('appskp/dropdowns');
	}	
////////////////////////////////Titipan dari Halaman Login///////////////////////////////////
/// ---> PEGAWAI
	function hitungpegawai($idskpdhir,$sub="ya"){
		$res = $this->m_main->hitung_pegawai($idskpdhir,$sub);
		return $res;
	}
	function getpegawai($idskpdhir,$mulai,$batas){
		$res = $this->m_main->get_pegawai($idskpdhir,$mulai,$batas);
		return $res;
	}
//riwayat pangkat
	function getr_kp($idpegawai){
		$res = $this->m_main->get_r_kp($idpegawai);
		return $res;
	}
/// ---> JABATAN
	function getpemangkujabatan($idskpdhir){
		$res = $this->m_main->get_pemangku_jabatan($idskpdhir);
		return $res;
	}
/// ---> SKPD
	function getskpdmaster($id_parent){
		$res = $this->m_main->get_skpd_master($id_parent,0,10000);
		return $res;
	}
	function getskpdutama($id_parent,$mulai=0,$batas=10000){
		$res = $this->m_main->get_skpd_utama($id_parent,$mulai,$batas);
		return $res;
	}
	function getunor($id_parent,$mulai=0,$batas=10000){
		$res = $this->m_main->get_unor($id_parent,$mulai,$batas);
		return $res;
	}

	function detail_unor($id_skpd_hir){
		$res = $this->m_main->detail_unor($id_skpd_hir);
		return $res;
	}

	function detailunor($id_unor){
		$res = $this->m_main->detailunor($id_unor);
		return $res;
	}
	function geteselon(){
		$res = $this->m_main->get_eselon();
		return $res;
	}


	function getskpdsotk($id_parent,$id_sotk){
		$res = $this->m_main->get_skpd_sotk($id_parent,$id_sotk);
		return $res;
	}
	function getskpdbyjenis($idjenisskpdhir,$idparent,$mulai,$batas){
		$res = $this->m_main->get_skpd_by_jenis($idjenisskpdhir,$idparent,0,1000);
		return $res;
	}
	function getsotk(){
		$res = $this->m_main->get_sotk();
		return $res;
	}
	function getjenis($id_parent=0){
		$res = $this->m_main->get_jenis_skpd($id_parent,0,10000);
		return $res;
	}
	function detailjenis($idd){
		$res = $this->m_main->detail_jenis_skpd($idd);
		return $res;
	}
/// ---> OPTIONS
	function jenisskpdoptions($id_parent=0,$id_skpd_jenis_hir=""){
		$res = $this->m_main->get_jenis_skpd($id_parent,0,10000);
		$str_opt = '';
		foreach($res as $key=>$val):
			if($id_skpd_jenis_hir==$val->id_skpd_jenis_hir){
				$str_opt = $str_opt."<option selected value='".$val->id_skpd_jenis_hir."'>".ucfirst($val->nama_jenis)."</option>";
			} else {
				$str_opt = $str_opt."<option value='".$val->id_skpd_jenis_hir."'>".ucfirst($val->nama_jenis)."</option>";
			}
		endforeach;
		return $str_opt;
	}
	function skpdoptions($id_parent=0,$id_skpd_hir=10){
		$res = $this->m_main->get_unor($id_parent,0,1000);
		$str_opt = '';
		foreach($res as $key=>$val):
			if($id_skpd_hir==$val->id_unor){
				$str_opt = $str_opt."<option selected value='".$val->id_unor."'>".ucfirst($val->nama_unor)."</option>";
			} else {
				$str_opt = $str_opt."<option value='".$val->id_unor."'>".ucfirst($val->nama_unor)."</option>";
			}
		endforeach;
		return $str_opt;
	}



}