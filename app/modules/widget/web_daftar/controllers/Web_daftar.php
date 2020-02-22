<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_daftar extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_daftar');
	}

	public function index($id_widget,$id_wrapper,$opsi)	{

		$data['wrapper'] = $this->m_daftar->ini_wrapper($id_wrapper)->result();
		$ddtt = $this->m_daftar->getwidget($id_widget,$id_wrapper,0,$opsi[2]->nilai)->result();

	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		foreach($ddtt as $key=>$val){
			@$data['hslquery'][$key]->id_konten=$val->id_konten;
			$data['hslquery'][$key]->judul=$val->judul;
			$data['hslquery'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['hslquery'][$key]->katseo=str_replace($d, '-', $val->nama_kategori);
		}
		$data['margin_top']=$opsi[0]->nilai;
		$dk = $this->m_daftar->hitung_item($ddtt[0]->id_kategori);

		$data['count'] = $dk['count'];
		$data['batas']=$opsi[2]->nilai;
		$data['ini'] = $id_widget;

		$de = Modules::run("web/pagerB",$dk['count'],$data['batas'],$hal=1,"daftar_$id_wrapper",2);
		$data['pager']=$de;
		$this->load->view('index',$data);
	}

	public function getdaftar()	{
		$batas=$_POST['batas'];
		$hal=$_POST['hal'];
		$ini=$_POST['ini'];
		$id_wrapper=$_POST['id_wrapper'];
		$count = $_POST['count'];
		$data['mulai']=(($hal-1)*$batas)+1;
		
		$ddtt=$this->m_daftar->getwidget($ini,$id_wrapper,(($hal-1)*$batas),$batas)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');

		foreach($ddtt as $key=>$val){
			@$data['hslquery'][$key]->id_konten=$val->id_konten;
			$data['hslquery'][$key]->judul=$val->judul;
			$data['hslquery'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['hslquery'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
		}

		$de = Modules::run("web/pagerB",$count,$batas,$hal,"daftar_$id_wrapper",2);
		$data['pager']=$de;
		echo json_encode($data);
	}



	public function getfoto()	{
		$idd=$_POST['idd'];
		$data=$this->m_daftar->getfoto($idd);
		echo json_encode($data);
	}
	public function getdirektori()	{
		$batas=$_POST['batas'];
		$hal=$_POST['hal'];
		$ini=$_POST['rubrik'];
		$dt=$this->m_daftar->hitung_direktori($ini); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;
		
		$ddtt=$this->m_daftar->getdirektori($mulai,$batas,$ini)->result();

	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		foreach($ddtt as $key=>$val){
			$isi=$this->m_daftar->ini_direktori($ddtt[$key]->id_konten)->result();
			@$data['hslquery'][$key]->id_konten=$ddtt[$key]->id_konten;
			$data['hslquery'][$key]->judul=$isi[0]->judul;
			$data['hslquery'][$key]->kat_seo=str_replace($d, '-', $isi[0]->nama_kategori);
			$data['hslquery'][$key]->seo=str_replace($d, '-', $isi[0]->judul);
		}

		$de = Modules::run("web/pagerC",$dt['count'],$batas,$hal,"daftar",2);
		$data['pager']=$de;
		echo json_encode($data);
	}


}