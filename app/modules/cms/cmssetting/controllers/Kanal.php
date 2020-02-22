<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Kanal extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('cmssetting/m_kanal');
		$this->auth->restrict();
	}

	function index(){
		$data['default']="amin";
		$data['jform']="Pengaturan Kanal";
		$this->load->view('kanal/index',$data);
	}

	function getkanal(){
		$idparent=end(explode("_",$_POST['idparent']));	
		$level=($_POST['level']+1);
		$spare=3+(($level*15)-15);

		$data['hslquery']=$this->m_kanal->getkanal($idparent);

		foreach($data['hslquery'] as $it=>$val){
			$jj=json_decode($val->meta_value);
			$id=$data['hslquery'][$it]->id_kanal;
				$tpl = $this->m_kanal->gettheme_by_path($jj->theme);
			$data['hslquery'][$it]->template= $tpl[0]->nama_item;
			$data['hslquery'][$it]->idparent=$_POST['idparent'];	
			$data['hslquery'][$it]->spare=$spare;	
			$data['hslquery'][$it]->level=$level;
				$anak=$this->m_kanal->getkanal($id);
				$data['hslquery'][$it]->toggle=(!empty($anak))?"tutup":"buka";
				$data['hslquery'][$it]->idchild=($_POST['idparent']==0)?$id:$_POST['idparent']."_".$id;	
				$cek_header=$this->m_kanal->cek_kanal_header($jj->path_kanal); // cek header kanal
			if(!empty($cek_header)){
				$jjh = json_decode(@$cek_header[0]->meta_value);
				$data['hslquery'][$it]->judul_header=$jjh->judul_header;
				$data['hslquery'][$it]->sub_judul=$jjh->sub_judul;
				$data['hslquery'][$it]->proses="[ <span onclick=\"loadForm('formedit_header/".$cek_header[0]->id_item."','$id','".$_POST['idparent']."','".$_POST['level']."');\" class='text_aksi'>Edit...</span> ]";
			} else {
				$data['hslquery'][$it]->judul_header="...";
				$data['hslquery'][$it]->sub_judul="...";
				$data['hslquery'][$it]->proses="[ <span onclick=\"loadForm('formtambah_header/".$jj->theme."','$id','".$_POST['idparent']."','".$_POST['level']."');\" class='text_aksi'>Input...</span> ]";
			}

				$cek_rubrik=$this->m_kanal->cek_kanal_rubrik($id); // cek rubrik
			$data['hslquery'][$it]->rubrik="";
				foreach($cek_rubrik AS $key=>$val){	$data['hslquery'][$it]->rubrik.=($key==0)?$val->nama_item:", ".$val->nama_item;	}
				$cek_wrapper=$this->m_kanal->cek_kanal_wrapper($id); // cek wrapper
			$data['hslquery'][$it]->wrapper="";$nnn=0;
				foreach($cek_wrapper AS $key=>$val){
					$jw = json_decode($val->meta_value);
					foreach($jw->widget AS $kk=>$vv){
						$nmw = $this->m_kanal->ini_item($vv->id_wrapper);
						$data['hslquery'][$it]->wrapper.=($nnn==0)?$nmw[0]->nama_item:", ".$nmw[0]->nama_item;
						$nnn++;
					}
				}
			$data['hslquery'][$it]->cek=(empty($cek_rubrik) && empty($cek_wrapper) && empty($anak))?"kosong":"ada";
		}

		echo json_encode($data['hslquery']);
	}
////////////////////////////////////////////////////////////////////
	function formtambah(){
		$data['idparent']=$_POST['idparent'];
		$data['root']=$_POST['root'];

		$data['level']=$_POST['level'];
		$data['rowparent']=($_POST['idparent']=="0")?"":$_POST['root']."_";
		$data['parent']=($_POST['idparent']=="0")?"0":$_POST['root'];

			$tpl= Modules::run("cmshome/theme_options");
			$data['theme']="<select id=theme name=theme class='ipt_text' style=\"width:200px;\">".$tpl."</select>";
		$this->load->view('kanal/formtambah_kanal',$data);
	}
	function tambah_aksi(){
        $this->form_validation->set_rules("nama_kanal","Nama Kanal","required");
		if($this->form_validation->run()) {
		    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
			$_POST['kanal_path'] = str_replace($d, '_',strtolower($_POST['nama_kanal']));
			$this->m_kanal->tambah_aksi($_POST);
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
////////////////////////////////////////////////////////////////////
	function formedit(){
		$data['idd']=$_POST['idparent'];
		$data['root']=$_POST['root'];

		$data['level']=$_POST['level'];
		$data['rowparent']=($_POST['root']=="0")?"":$_POST['root']."_";
		$data['parent']=($_POST['idparent']=="0")?"0":$_POST['root'];

		$kanal=$this->m_kanal->ini_item($_POST['idparent']);
			$jj = json_decode($kanal[0]->meta_value);
		$data['nama_kanal']=$kanal[0]->nama_item;
		$data['keterangan']=$jj->keterangan;
		$data['path_lama']=$jj->path_kanal;

		$tipe_val = array("biasa","liputan");
		$tipe_label = array("Biasa","Liputan");
		$data['tipe'] = "";
			for($i=0;$i<count($tipe_val); $i++){
				$data['tipe'].=($tipe_val[$i]==$jj->tipe)?"<option value='".$tipe_val[$i]."' selected>".$tipe_label[$i]:"<option value='".$tipe_val[$i]."'>".$tipe_label[$i];
			}

			$tpl= Modules::run("cmshome/theme_options",$jj->theme);
			$data['theme']="<select id=theme name=theme class='ipt_text' style=\"width:200px;\">".$tpl."</select>";
		$this->load->view('kanal/formedit_kanal',$data);
	}

	function edit_aksi(){
        $this->form_validation->set_rules("nama_kanal","Nama Kanal","required");
		if($this->form_validation->run()) {
			if($_POST['path_lama']==""){
				$_POST['kanal_path']="";			
			} else {
				$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
				$_POST['kanal_path'] = str_replace($d, '_',strtolower($_POST['nama_kanal']));
			}
		$this->m_kanal->edit_aksi($_POST);
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formhapus(){
		$data['idd']=$_POST['idparent'];

		if($_POST['level']==1){
			$data['level']=0;
			$data['rowparent']="";
			$data['parent']=0;
			$data['idparent']=0;
		} else {
			$idp=explode("_",$_POST['root']);
			$isi	= $this->m_kanal->getkanal($idp[(count($idp)-2)]);
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
			$data['idparent']=end(explode("_",$data['parent']));
		}


		$data['hslquery']=$this->m_kanal->ini_item($_POST['idparent']);
			$jj = json_decode($data['hslquery'][0]->meta_value);
		$data['nama_kanal']=$data['hslquery'][0]->nama_item;
		$data['keterangan']=$jj->keterangan;
		$data['tipe']=$jj->tipe;
		$data['theme']=$jj->theme;
		$this->load->view('kanal/formhapus_kanal',$data);
	}

	function formedit_header($idh){
		$data['idh']=$idh;
		$data['idd']=$_POST['idparent'];
		$data['root']=$_POST['root'];
		$data['level']=$_POST['level'];
		$data['rowparent']=($_POST['root']=="0")?"":$_POST['root']."_";
		$data['parent']=($_POST['idparent']=="0")?"0":$_POST['root'];

		$kanal=$this->m_kanal->ini_item($_POST['idparent']);
			$jj = json_decode($kanal[0]->meta_value);
		$data['nama_kanal']=$kanal[0]->nama_item;
		$data['path_kanal']=$jj->path_kanal;

		$header=$this->m_kanal->ini_item($idh);
			$jjh = json_decode($header[0]->meta_value);
		$data['judul_header']=$jjh->judul_header;
		$data['sub_judul']=$jjh->sub_judul;
		$data['height'] = $jjh->height;
		$data['margin_top'] = $jjh->margin_top;
		$data['margin_bottom'] = $jjh->margin_bottom;
		$data['padding_top'] = $jjh->padding_top;
		$data['padding_bottom'] = $jjh->padding_bottom;

		$this->load->view('kanal/formedit_kanal_header',$data);
	}
	function edit_header_aksi(){
        $this->form_validation->set_rules("judul_header","Judul Header","required");
		if($this->form_validation->run()) {
		$this->m_kanal->edit_header_aksi($_POST);
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah_header($tpl){
		$data['idd']=$_POST['idparent'];
		$data['root']=$_POST['root'];
		$data['level']=$_POST['level'];
		$data['rowparent']=($_POST['root']=="0")?"":$_POST['root']."_";
		$data['parent']=($_POST['idparent']=="0")?"0":$_POST['root'];

		$kanal=$this->m_kanal->ini_item($_POST['idparent']);
			$jj = json_decode($kanal[0]->meta_value);
		$data['nama_kanal']=$kanal[0]->nama_item;
		$data['path_kanal']=$jj->path_kanal;
			$tpl = $this->m_kanal->gettheme_by_path($tpl);
			$jj=json_decode($tpl[0]->meta_value);
		$data['height'] = $jj->header_opsi->height;
		$data['margin_top'] = $jj->header_opsi->margin_top;
		$data['margin_bottom'] = $jj->header_opsi->margin_bottom;
		$data['padding_top'] = $jj->header_opsi->padding_top;
		$data['padding_bottom'] = $jj->header_opsi->padding_bottom;

		$this->load->view('kanal/formtambah_kanal_header',$data);
	}
	function tambah_header_aksi(){
        $this->form_validation->set_rules("judul_header","Judul Header","required");
		if($this->form_validation->run()) {
		$this->m_kanal->tambah_header_aksi($_POST);
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

////////////////////////////////////////////////////////////////////
/////Memproses naik urutan menu
////////////////////////////////////////////////////////////////////
	function naik_aksi(){
		$id_ini=end(explode("_",$_POST['id_ini']));
		$id_lawan=end(explode("_",$_POST['id_lawan']));
		$urutan_ini=$_POST['urutan_ini'];
		$urutan_lawan=$_POST['urutan_lawan'];
		$this->m_kanal->naik_index($id_ini,$id_lawan,$urutan_ini,$urutan_lawan);
	}

}
?>