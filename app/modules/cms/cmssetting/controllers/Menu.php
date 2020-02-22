<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Menu extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_setting');
		$this->auth->restrict();
	}

	function index(){
		$data['setting']	= "Menu";
		$this->load->view('menu/index',$data);
	}

	function getmenu(){
		$idparent=end(explode("_",$_POST['idparent']));	
		$level=($_POST['level']+1);
		$spare=3+(($level*15)-15);

		$data['isi']	= $this->m_setting->getitem(2,$idparent);
		foreach($data['isi'] as $key=>$val){
			$jj=json_decode($val->meta_value);

			$data['isi'][$key]->spare=$spare;	
			$data['isi'][$key]->level=$level;
			$data['isi'][$key]->path_menu=$jj->path_menu;
			$data['isi'][$key]->icon_menu=$jj->icon_menu;
			$data['isi'][$key]->keterangan=$jj->keterangan;
				$anak=$this->m_setting->getitem(2,$val->id_item);
				$data['isi'][$key]->toggle=(!empty($anak))?"tutup":"buka";
				$data['isi'][$key]->idchild=($_POST['idparent']==0)?$val->id_item:$_POST['idparent']."_".$val->id_item;
				$cek = $this->m_setting->cek_menu($val->id_item);
				$data['isi'][$key]->cek=(empty($cek) & empty($anak))?"kosong":"ada";
		}
		echo  json_encode($data);
	}
	function formtambah_menu(){
		$data['idparent']=$_POST['idparent'];
		$data['level']=$_POST['level'];

		$data['level']=$_POST['level'];
		$data['rowparent']=($_POST['idparent']=="0")?"":$_POST['idparent']."_";
		$data['parent']=($_POST['idparent']=="0")?"0":$_POST['idparent'];

		$this->load->view('menu/formtambah_menu',$data);
	}

	function tambah_menu_aksi(){
		$id_parent=end(explode("_",$_POST['idparent']));
		$ang=explode("*",$_POST['nama_menu']);
			$ipp['menu_name']=$ang[0];
			$ipp['icon_menu']=$ang[1];
			$ipp['menu_path']=$ang[2];
			$ipp['keterangan']=$ang[3];
		$this->m_setting->tambah_menu_aksi($id_parent,$ipp);
		echo "sukses#"."add#";
	}
	function formedit_menu(){
		$data['id_menu']=$_POST['idd'];
		$data['idparent']=$_POST['idparent'];
		$data['level']=$_POST['level'];
		$data['rowparent']=($_POST['idparent']=="0")?"":$_POST['idparent']."_";
		$data['parent']=($_POST['idparent']=="0")?"0":$_POST['idparent'];
		$hslquery=$this->m_setting->ini_item($_POST['idd']);
			$jj = json_decode($hslquery[0]->meta_value);
		@$data['hslquery'][0]->menu_name=$hslquery[0]->nama_item;
		$data['hslquery'][0]->menu_path=$jj->path_menu;
		$data['hslquery'][0]->icon_menu=$jj->icon_menu;
		$data['hslquery'][0]->keterangan=$jj->keterangan;
		$this->load->view('menu/formedit_menu',$data);
	}
	function edit_menu_aksi(){
		$idd=$_POST['idd'];
		$ang=explode("*",$_POST['nama_menu']);
			$ipp['menu_name']=$ang[0];
			$ipp['icon_menu']=$ang[1];
			$ipp['menu_path']=$ang[2];
			$ipp['keterangan']=$ang[3];
		$this->m_setting->edit_menu_aksi($idd,$ipp);
	}

	function formhapus_menu(){
		$data['idd']=end(explode("_",$_POST['idd']));
		$data['idparent']=$_POST['idparent'];

		if($_POST['level']==1){
			$data['level']=0;
			$data['rowparent']="";
			$data['parent']=0;
		} else {
			$idp=explode("_",$_POST['idd']);
			$isi	= $this->m_setting->getitem(2,$_POST['idparent']);
			$data['rowparent']="";
			$data['parent']="";
			if(count($isi)==1){
				$data['level']=$_POST['level']-2;
				for($i=0;$i<count($idp)-2;$i++){	$data['rowparent'].=$idp[$i]."_";	$data['parent'].=($i==0)?$idp[$i]:"_".$idp[$i];	}
			} else {
				$data['level']=$_POST['level']-1;
				for($i=0;$i<count($idp)-1;$i++){	$data['rowparent'].=$idp[$i]."_";	$data['parent'].=($i==0)?$idp[$i]:"_".$idp[$i];	}
			}
			if($data['parent']==""){$data['parent']=0;}
		}

		$hslquery=$this->m_setting->ini_item($_POST['idd']);
			$jj = json_decode($hslquery[0]->meta_value);
		@$data['hslquery'][0]->menu_name=$hslquery[0]->nama_item;
		$data['hslquery'][0]->menu_path=$jj->path_menu;
		$data['hslquery'][0]->icon_menu=$jj->icon_menu;
		$data['hslquery'][0]->keterangan=$jj->keterangan;

		$this->load->view('menu/formhapus_menu',$data);
	}

	function hapus_menu_aksi($id_setting=2){
		$idd=$_POST['idd'];
		$this->m_setting->hapus_item_aksi($idd);
		$idparent=end(explode("_",$_POST['idparent']));
		$this->m_setting->reurut($id_setting,$idparent);
		echo "sukses#"."add#";
	}

}
?>