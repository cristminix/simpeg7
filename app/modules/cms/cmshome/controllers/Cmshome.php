<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmshome extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_home');
		$this->load->library("paging");
	}
	
	function index(){
			$sess = $this->session->userdata('logged_in');
			$data['ssb'] = $sess;
			$sess = $this->session->all_userdata();
			$data['ssn'] = $sess;
			$data['PHPSESSID']= $this->session->userdata('session_id');

		$dt=$this->m_home->getopsi();
		$jj = json_decode($dt[0]->meta_value);
		$data['nama_aplikasi']=$jj->nama_aplikasi;
		$data['slogan_aplikasi']=$jj->slogan_aplikasi;

		$this->load->view('index',$data);
	}
////////////////////////////////////////////////////////////////////
///////////////           Load Pager Grid
	function pagerB($n_itmsrch,$bat,$hal,$kehal="paging") {
		$diri=$n_itmsrch;
		$page=$this->paging->halamanB($n_itmsrch,$bat_page=5,$bat,$hal,$kehal);
		$halkehal="hal".$kehal;
		$b_halmaxkehal="b_halmax".$kehal;
		$gokehal="go".$kehal;
		$inputkehal="input".$kehal;
		
		$iptx="<input id='".$inputkehal."' type=\"text\" style=\"text-align:right; float:left; border:1px solid #3399CC; padding:0px 2px 0px 2px;\" size='2' value='".$hal."' onblur=\"if(this.value=='') this.value='".$hal."';\" onfocus=\"if(this.value=='".$hal."') this.value='';\" onchange=\"".$gokehal."()\">";
		$vala="<div style=\"float:left; padding-top:2px\">&nbsp;<b>Hal.</b>&nbsp;</div><div id='bhal' style=\"float:left; padding-top:1px\">".$iptx."</div><div style=\"float:left; padding-top:2px\">&nbsp;dari&nbsp;</div><div id='bhalmax' style=\"float:left; padding-top:2px\">".$page[$b_halmaxkehal]."</div><div class=pagingframe>"; 
		$i=0;foreach($page[$halkehal] as $keyb=>$valb){ $vala=$vala.$valb;$i++;}
		$vala=$vala."</div>";
		return $vala;
	}
/////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////Titipan dari Halaman Login///////////////////////////////////
/// ---> RUBRIK / KATEGORI
	function hitungrubrik($komponen){
		$res = $this->m_home->hitung_rubrik($komponen);
		return $res;
	}
	function getrubrik($komponen,$mulai,$batas){
		$res = $this->m_home->get_rubrik($komponen,$mulai,$batas)->result();
		return $res;
	}
	function detailrubrik($komponen){
		$res = $this->m_home->detail_rubrik($komponen)->result();
		return $res;
	}
/// ---> JUDUL KONTEN
	function hitungkonten($rubrik,$komponen){
		$res = $this->m_home->hitung_konten($rubrik,$komponen);
		return $res;
	}
	function getkonten($mulai,$batas,$rubrik,$komponen){
		$res = $this->m_home->get_konten($mulai,$batas,$rubrik,$komponen);
		return $res;
	}
	function detailkonten($idkonten){
		$res = $this->m_home->detail_konten($idkonten)->result();
		return $res;
	}
/// ---> PENULIS
	function hitungpenulis($rubrik,$komponen){
		$res = $this->m_home->hitung_penulis($rubrik,$komponen);
		return $res;
	}
/// ---> FOTO KONTEN
	function fotokonten($idkonten){
		$res = $this->m_home->foto_konten($idkonten)->result();
		return $res;
	}
/// ---> OPTIONS
	function kategori_options($id_kategori="",$komponen){
		$res = $this->m_home->get_rubrik($komponen,0,10000)->result();
		$str_opt = '';
		foreach($res as $key=>$val):
			$slc = ($id_kategori==$val->id_kategori)?"selected":"";
			$str_opt.= "<option value='".$val->id_kategori."' ".$slc.">".ucfirst($val->nama_kategori)." - ".($val->keterangan)."</option>";
		endforeach;
		return $str_opt;
	}
	function penulis_options($id_penulis=""){
		$res = $this->m_home->get_penulis("all",100)->result();
		$str_opt = '';
		foreach($res as $key=>$val):
			$slc = ($id_penulis==$val->id_penulis)?"selected":"";
			$str_opt.= "<option value='".$val->id_penulis."' ".$slc.">".ucfirst($val->nama_penulis)."</option>";
		endforeach;
		return $str_opt;
	}
	function komponen_options($komponen=""){
		$res = $this->m_home->get_komponen("all",1000)->result();
		$str_opt = '';
		foreach($res as $key=>$val):
			$jj = json_decode($val->meta_value);
			$slc = ($val->nama_item==$komponen)?"selected":"";
			$str_opt.="<option value='".$val->nama_item."' ".$slc.">".ucfirst($jj->label)."</option>";
		endforeach;
		return $str_opt;
	}
	function theme_options($path=""){
		$res = $this->m_home->get_theme("all",1000)->result();
		$str_opt = '';
		foreach($res as $key=>$val):
			$jj = json_decode($val->meta_value);
			$slc = ($jj->theme_path==$path)?"selected":"";
			$str_opt.="<option value='".$jj->theme_path."' ".$slc.">".ucfirst($val->nama_item)."</option>";
		endforeach;
		return $str_opt;
	}
}
?>