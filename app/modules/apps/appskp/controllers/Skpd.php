<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Skpd extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skpd');
		// $this->load->model('appskp/dropdowns');
	}

	function index(){
		$data['satu']="Daftar Master SKPD";
			$id_skp = $this->session->userdata('id_skp');
			$data['id_skp'] = $id_skp;
		$this->load->view('skpd/index',$data);
	}


	function getskpdutama(){
		$level=($_POST['level']+1);
		$spare=3+(($level*20)-20);
		$id_parent=end(explode("_",$_POST['id_parent']));	
		$data['hslquery'] = Modules::run("appskp/main/getunor",$id_parent);

		foreach($data['hslquery'] as $it=>$val){
			$id=$data['hslquery'][$it]->id_unor;
			$data['hslquery'][$it]->idparent=$_POST['id_parent'];	
			$data['hslquery'][$it]->spare=$spare;	
			$data['hslquery'][$it]->level=$level;
				$anak=Modules::run("appskp/main/getunor",$id);
				$data['hslquery'][$it]->toggle=(!empty($anak))?"tutup":"buka";
				$data['hslquery'][$it]->idchild=($_POST['id_parent']==0)?$id:$_POST['id_parent']."_".$id;
		}

		$data['mulai'] = 1;
		$data['pager'] = "";
		echo json_encode($data);
	}

	function formtambah_utama(){
		$idd=explode("**",$_POST['idd']);
		$data['idparent']=$idd[0];
		$data['rowparent']=($idd[1]=="X")?"":$idd[1]."_";
		$data['parent']=($idd[1]=="X")?"0":$idd[1];
		$data['level']=$idd[2];
		$this->load->view('skpd/formtambah_utama',$data);
	}

	function tambahutama_aksi(){
 		$this->form_validation->set_rules("nama_unor","Nama Unor","trim|required|xss_clean");
//      $this->form_validation->set_rules("nomenklatur_jabatan","Jabatan (nomenklatur)","trim|required|xss_clean");
// 		$this->form_validation->set_rules("nomenklatur_pada","Lokasi Jabatan (pada)","trim|required|xss_clean");
// 		$this->form_validation->set_rules("nomenklatur_cari","Index Pencarian","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ese = $this->dropdowns->kode_ese();
			$_POST['nama_ese']=$ese[$_POST['kode_ese']];
			$ddir=$this->m_skpd->tambahutama_aksi($_POST); 
//			$ddir=$this->m_appskpd->editutama_aksi_konvensi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formedit_utama(){
		$idd=explode("**",$_POST['idd']);
		$data['idd']=$idd[0];
		$data['rowparent']=($idd[1]=="0")?"":$idd[1]."_";
		$data['parent']=($idd[1]=="0")?"0":$idd[1];
		$data['level']=$idd[2];
		$data['isi'] = Modules::run("appskp/main/detailunor",$data['idd']);
		$this->load->view('skpd/formedit_utama',$data);
	}
	function editutama_aksi(){
 		$this->form_validation->set_rules("nama_unor","Nama Unor","trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_jabatan","Jabatan (nomenklatur)","trim|required|xss_clean");
 		$this->form_validation->set_rules("nomenklatur_pada","Lokasi Jabatan (pada)","trim|required|xss_clean");
 		$this->form_validation->set_rules("nomenklatur_cari","Index Pencarian","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ese = $this->dropdowns->kode_ese();
			$_POST['nama_ese']=$ese[$_POST['kode_ese']];
			$ddir=$this->m_skpd->editutama_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formhapus_utama(){
		$idd = explode("**",$_POST['idd']);
		$data['idd'] = $idd[0];

		if($idd[2]==1){
			$data['level']=0;
			$data['rowparent']="";
			$data['parent']=0;
		} else {
			$idp=explode("_",$idd[1]);
			$data['rowparent']="";
			$data['parent']="";
			if($idd[3]==1){
				$data['level']=$idd[2]-2;
				for($i=0;$i<count($idp)-2;$i++){	$data['rowparent'].=$idp[$i]."_";	$data['parent'].=($i==0)?$idp[$i]:"_".$idp[$i];	}
			} else {
				$data['level']=$idd[2]-1;
				for($i=0;$i<count($idp)-1;$i++){	$data['rowparent'].=$idp[$i]."_";	$data['parent'].=($i==0)?$idp[$i]:"_".$idp[$i];	}
			}
			if($data['parent']==""){$data['parent']=0;}
		}
		
		$data['isi'] = Modules::run("appskp/main/detailunor",$data['idd']);
		$this->load->view('skpd/formhapus_utama',$data);
	}
	function hapusutama_aksi(){
		$this->m_skpd->hapusutama_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>