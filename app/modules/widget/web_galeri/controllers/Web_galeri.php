<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_galeri extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_web_galeri');
	}

	public function index($id_widget,$id_wrapper,$opsi)	{
		$data['id_wrapper']=$id_wrapper;
		$data['id_widget']=$id_widget;

		$data['wrapper'] = $this->m_web_galeri->ini_wrapper($id_wrapper);
		$data['daftar'] = $this->m_web_galeri->getwidget($id_widget,$id_wrapper);
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";

		foreach($data['daftar'] as $key=>$val){
			$data['daftar'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
			$data['daftar'][$key]->seo=str_replace($d, '-', $val->judul);
		}

		$data['tpl']="web";//////////modif by Dadan
		$data['margin_top']=$opsi[0]->nilai;

		$this->load->view('index',$data);
	}

	public function read($id_widget,$id_wrapper)	{
		$data['muka']=$this->m_web_galeri->ini_galeri($id_wrapper);
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$judulseo=str_replace($d, '-', $data['muka'][0]->judul);
		if(!$data['muka'][0]->id_konten || str_replace(" ","-",$data['muka'][0]->nama_kategori)!=$id_widget || $this->uri->segment(5)!=$judulseo ){
				redirect(base_url());
		} else {
			$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
			$data['muka'][0]->hari=$hh[@$data['muka'][0]->hari_buat];

			$data['isi']=$this->m_web_galeri->album_galeri($id_wrapper);

			$data['jkanal'] = Modules::run("web_artikel/root_kanal",$data['muka'][0]->id_kanal);
			$data['kanal']	= Modules::run("web_artikel/cari_kanal",$data['muka'][0]->id_kanal);

			$sessm['kanal'] = $data['kanal'][0]->kanal_path;
			$sessm['tipe_kanal'] = $data['kanal'][0]->tipe;
			$sessm['id_kanal'] = $data['kanal'][0]->id_kanal;
			$sessm['theme'] = $data['kanal'][0]->theme;
			$this->session->set_userdata('visit', $sessm);

			$data['batas']=2;
			$urutan=$this->m_web_galeri->urutan_galeri($data['muka'][0]->id_konten,$data['muka'][0]->id_kategori);
			$data['hal']=ceil($urutan['count']/$data['batas']);

			$this->load->view('detail',$data);
		}
	}

	public function getfoto()	{
		$data['hslquery']=$this->m_web_galeri->getfoto($_POST['idd'])->result();
		echo json_encode($data);
	}


	public function getgaleri()	{
		$batas=$_POST['batas'];
		$rubrik=$_POST['rubrik'];
		$dt=$this->m_web_galeri->hitung_album($rubrik); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_web_galeri->getalbum($mulai,$batas,$rubrik)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
		foreach($data['hslquery'] as $key=>$val){
			$data['hslquery'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['hslquery'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
			$data['hslquery'][$key]->hari_buat=$hh[$val->hari_buat];
		}



		$de = Modules::run("web/pagerB",$dt['count'],$batas,$hal,"artikel",2);
		$data['pager']=$de;
		echo json_encode($data);
	}

	public function all($id_widget,$id_wrapper)	{
		$data['rubrik']=str_replace("-"," ",$this->uri->segment(5));
		$rubrik=$id_wrapper;

					$dt=$this->m_web_galeri->hitung_album($rubrik); 
					$batas=2;
					$data['id_rubrik']=$id_wrapper;
					if($id_widget=="end"){	$hal=ceil($dt['count']/$batas);		} else {	if($id_widget*1>0 && $id_widget<=(ceil($dt['count']/$batas))){	$hal=$id_widget;	} else {	redirect(site_url());	}	}
					$mulai=($hal-1)*$batas;
					$data['mulai']=$mulai+1;
					$data['isi']=$this->m_web_galeri->getalbum($mulai,$batas,$rubrik)->result();
					$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
					$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
					foreach($data['isi'] as $key=>$val){
						$data['isi'][$key]->seo=str_replace($d, '-', $val->judul);
						$data['isi'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
						$data['isi'][$key]->hari=$hh[$val->hari_buat];
					}
			
					$pph=$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);
					$ddmm = Modules::run("web/pagerD",$dt['count'],$batas,$hal,$pph);
					$ganti=str_replace("XX",$this->uri->segment(5),$ddmm);
					$data['pager']=$ganti;
			
					$sess = $this->m_web_galeri->getkanal($rubrik);
					$data['id_kanal'] = $sess[0]->id_kanal;
					$dkn = Modules::run("web_artikel/cari_kanal",$sess[0]->id_kanal);
					$sessm['kanal'] = $dkn[0]->kanal_path;
					$sessm['tipe_kanal'] = $dkn[0]->tipe;
					$sessm['id_kanal'] = $dkn[0]->id_kanal;
					$sessm['theme'] = $dkn[0]->theme;
					$this->session->set_userdata('visit', $sessm);
					$data['jkanal'] = Modules::run("web_artikel/root_kanal",$data['id_kanal']);
			
					$this->load->view('all',$data);
	}


}