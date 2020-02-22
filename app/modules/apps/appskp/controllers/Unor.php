<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Unor extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_unor');
	}


	function index(){
		$data['satu'] = "Daftar Master Unit Organisasi";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$this->load->view('unor/index',$data);
	}
	function getdata(){
		$cari = $_POST['cari'];
		$data['count'] = $this->m_unor->hitung_master_unor($cari);

		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_unor->get_master_unor($cari,$mulai,$batas);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data = $_POST;
		$this->load->view('unor/formedit',$data);
	}
	function formhapus(){
		$data = $_POST;
		$this->load->view('unor/formhapus',$data);
	}
}
?>