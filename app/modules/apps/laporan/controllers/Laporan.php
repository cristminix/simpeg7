<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Laporan extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library("paging");
	}

	function index(){
//		$sub=array("skp","realisasi","skp_kelola","realisasi_kelola","skp_verifikasi","realisasi_verifikasi","skpd","tupoksi","tarif","bebankerja","cetak","skp_formpegawai","sett","verifikatur","unor","penilaian");
		$sub=array("skp_formpegawai");
		$id_grup = $this->session->userdata('group_id');
		$cari = '"group_id":"'.$id_grup.'"';
		$this->db->from('p_setting_item');
		$this->db->where('id_setting',3);
		$this->db->like('meta_value',$cari);
		$hsl = $this->db->get()->result();
		foreach($hsl as $key=>$val){
			$itt = json_decode($val->meta_value);
			$idt = $itt->id_menu;
				$this->db->from('p_setting_item');
				$this->db->where('id_item',$idt);
				$nnm = $this->db->get()->row();
				$itk = json_decode($nnm->meta_value);
			    $d = array ('module/laporan/','module/appbkpp/');
				$etk = explode("/",str_replace($d, '', $itk->path_menu));
				array_push($sub,$etk[0]);
		}

		if(in_array($this->uri->segment(4),$sub)){
			if($this->uri->segment(5)==""){
				echo Modules::run("laporan/".$this->uri->segment(4)."/index");
			} else {
				echo Modules::run("laporan/".$this->uri->segment(4)."/".$this->uri->segment(5));
			}
		} else {
			redirect(site_url("admin"));
		}
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
		$vala="<div style=\"float:left; padding-top:5px\">&nbsp;<b>Hal.</b>&nbsp;</div><div id='bhal' style=\"float:left; padding-top:4px\">".$iptx."</div><div style=\"float:left; padding-top:5px\">&nbsp;dari&nbsp;</div><div id='bhalmax' style=\"float:left; padding-top:5px\">".$page[$b_halmaxkehal]."</div><div class='btn-group pagingframe'>"; 
		$i=0;foreach($page[$halkehal] as $keyb=>$valb){ $vala=$vala.$valb;$i++;}
		$vala=$vala."</div>";
		return $vala;
	}

	
}
?>