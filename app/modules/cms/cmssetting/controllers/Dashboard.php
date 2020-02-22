<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Dashboard extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('cmssetting/m_dashboard','dBase');
		$this->load->helper('font_awesome');
		$this->auth->restrict();
	}

	function index(){
		$data['jform']="Pengaturan Item Dashboard";
		$this->load->view('dashboard/index',$data);
	}

	function getdashboard(){
		$batas=$_POST['batas'];
		$dt=$this->dBase->countData(); 
		$hal = ($_POST['hal']?$_POST['hal']:2);
		if($hal=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$hal;	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->dBase->getData($mulai,$batas);
		foreach($data['hslquery'] as $it=>$val){
			$jj=json_decode($val->meta_value);
			$data['hslquery'][$it]->text=$jj->text;
			$data['hslquery'][$it]->icon=$jj->icon;
			$data['hslquery'][$it]->status=$jj->status;
			$data['hslquery'][$it]->color=$jj->color;
			$data['hslquery'][$it]->module=(isset($jj->module)?$jj->module:'');
			$data['hslquery'][$it]->path=$jj->path;
			$data['hslquery'][$it]->note=(isset($jj->note)?$jj->note:'');
		}
		$de = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}

	function formcontent_dashboard($id){
		$pilok=array("Topbar"=>"topbar","Mainbar"=>"mainbar","Sidebar"=>"sidebar");
		$pilstat=array("Aktif"=>"1","NonAktif"=>"0");
		$icon = json_decode(icon_array());
		$data['status_options']	= "";
		$data['icon_options']	= "";
		$data['idd'] = $id;
		$row=$this->dBase->getDetail($id);
		//var_dump($icon);
		if($row->num_rows() > 0){
			$row  = $row->row();
			$frm  = json_decode($row->meta_value);
			$data["text"] 		= $frm->text;
			$data["icon"] 		= $frm->icon;
			$data["status"] 	= $frm->status;
			$data["color"] 		= $frm->color;
			$data["module"] 	= (isset($frm->module)?$frm->module:'');
			$data["path"] 		= $frm->path;
			$data["note"] 		= (isset($frm->note)?$frm->note:'');
			foreach($icon as $val){
				if($frm->icon==$val){
					$data['icon_options'].="<option value='".$val."' selected>".$val."";
				} else {
					$data['icon_options'].="<option value='".$val."'>".$val."";
				}
			}
			
			foreach($pilstat as $key=>$val){
				if($frm->status==$val){
					$data['status_options'].="<option value='".$val."' selected>".$key."";
				} else {
					$data['status_options'].="<option value='".$val."'>".$key."";
				}
			}
		}else{
			$data["text"] 		= "";
			$data["icon"] 		= "";
			$data["status"] 	= "";
			$data["color"] 		= "";
			$data["custom_query"] 	= "";
			$data["path"] 		= "";
			foreach($pilstat as $key=>$val){$data['status_options'].="<option value='".$val."'>".$key."";}
			foreach($icon as $val){$data['icon_options'].="<option value='".$val."'>".$val."";}
		}
	
		$this->load->view('dashboard/formcontent_dashboard',$data);
	}
	
	function saveaksi(){
		//var_dump(json_encode($_POST));
		$_POST["note"] = trim($_POST["note"]);
		$_POST["module"] = trim($_POST["module"]);
		$data = json_encode($_POST);
		$id	  = $_POST["idd"];
		$dbUpdate = $this->dBase->saveData($id,$data);
		if($dbUpdate){
			echo "success#true";
		}
	}

	function hapus_aksi(){
		$idd=$_POST['id'];
		$this->dBase->hapus_dashboard_aksi($idd);
	}
}
?>