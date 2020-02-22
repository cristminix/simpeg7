<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Tarif extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_tarif');
		// $this->load->model('appskp/dropdowns');
	}

	function index(){
		$data['satu']="TARIF TPP BULANAN";
		$this->load->view('tarif/index',$data);
	}


	function getskpdutama(){
		$level=($_POST['level']+1);
		$spare=3+(($level*15)-15);
		$id_parent=end(explode("_",$_POST['id_parent']));	
		$data['hslquery'] = Modules::run("appskp/main/getunor",$id_parent);

		foreach($data['hslquery'] as $it=>$val){
			$id=$data['hslquery'][$it]->id_unor;
			$data['hslquery'][$it]->idparent=$_POST['id_parent'];	
			$data['hslquery'][$it]->spare=$spare;	
			$data['hslquery'][$it]->level=$level;

			$tjs = $this->m_tarif->get_tarif($id,"js");
			$data['hslquery'][$it]->tarif_js = number_format(@$tjs[0]->tarif,2,",",".");
			$data['hslquery'][$it]->tarif_jft = $this->m_tarif->get_tarif($id,"jft");
			foreach($data['hslquery'][$it]->tarif_jft AS $key=>$val){
				$data['hslquery'][$it]->tarif_jft[$key]->tarif=number_format($val->tarif,2,",",".");
			}
			$data['hslquery'][$it]->tarif_jfu = $this->m_tarif->get_tarif($id,"jfu");
			foreach($data['hslquery'][$it]->tarif_jfu AS $key=>$val){
				$data['hslquery'][$it]->tarif_jfu[$key]->tarif=number_format($val->tarif,2,",",".");
			}

				$anak=Modules::run("appskp/main/getunor",$id);
				$data['hslquery'][$it]->toggle=(!empty($anak))?"tutup":"buka";
				$data['hslquery'][$it]->idchild=($_POST['id_parent']==0)?$id:$_POST['id_parent']."_".$id;
		}

		$data['mulai'] = 1;
		$data['pager'] = "kj";
		echo json_encode($data);
	}

	function formedit(){
		$idd=explode("**",$_POST['idd']);
		$data['idd']=$idd[0];
		$data['rowparent']=($idd[1]=="0")?"":$idd[1]."_";
		$data['parent']=($idd[1]=="0")?"0":$idd[1];
		$data['level']=$idd[2];
		$data['isi'] = Modules::run("appskp/main/detailunor",$data['idd']);
		$ese = Modules::run("appskp/main/geteselon");
		$data['pileselon']="";
		foreach($ese as $key=>$val){
			$data['pileselon'].=($val->kode==@$data['isi'][0]->kode_ese)?"<option value=".$val->kode." selected>".$val->nama_ese."</option>":"<option value=".$val->kode.">".$val->nama_ese."</option>";
		}

		$this->load->view('formedit',$data);
	}
	function edit_aksi(){
 		$this->form_validation->set_rules("nama_unor","Nama Unor","trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_jabatan","Jabatan (nomenklatur)","trim|required|xss_clean");
 		$this->form_validation->set_rules("nomenklatur_pada","Lokasi Jabatan (pada)","trim|required|xss_clean");
 		$this->form_validation->set_rules("nomenklatur_cari","Index Pencarian","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_tarif->edit_aksi($_POST); 
//			$ddir=$this->m_appskpd->editutama_aksi_konvensi($_POST['idd'],$_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}


}
?>