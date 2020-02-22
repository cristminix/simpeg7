<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Widget extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_setting');
		$this->auth->restrict();
	}

	function index(){
		$data['jform']="Pengaturan Master Widget";
		$this->load->view('widget/index',$data);
	}

	function getwidget(){
		$batas=$_POST['batas'];
		$dt=$this->m_setting->hitung_widget(); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_setting->getwidget($mulai,$batas);
		foreach($data['hslquery'] as $it=>$val){
			$jj=json_decode($val->meta_value);
			$data['hslquery'][$it]->keterangan=$jj->keterangan;
			$data['hslquery'][$it]->lokasi_widget=$jj->lokasi_widget;
			$data['hslquery'][$it]->komponen=$jj->komponen;
		}
		$de = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}

	function formcontent_widget($id){
		$pilok=array("Topbar"=>"topbar","Mainbar"=>"mainbar","Sidebar"=>"sidebar");
		$data['lokasi_options']="";
		$data['idd'] = $id;
		$row=$this->m_setting->detailwidget($id)->result();
		if(!empty($row[0]->id_widget)){
			$data['nama_widget'] = $row[0]->nama_widget;
			$data['keterangan'] = $row[0]->keterangan;

			foreach($pilok as $key=>$val){
				if($row[0]->lokasi_widget==$val){
					$data['lokasi_options'].="<option value='".$val."' selected>".$key."";
				} else {
					$data['lokasi_options'].="<option value='".$val."'>".$key."";
				}
			}
		} else {
			$data['nama_widget'] = "";
			$data['keterangan'] = "";
			foreach($pilok as $key=>$val){	$data['lokasi_options'].="<option value='".$val."'>".$key."";	}
		}
	
		$this->load->view('widget/formcontent_widget',$data);
	}

}
?>