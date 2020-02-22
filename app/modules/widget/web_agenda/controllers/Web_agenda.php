<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_agenda extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_agenda');
	}

	public function index($id_widget,$id_wrapper)	{
		$data['id_wrapper']=$id_wrapper;
		$data['id_widget']=$id_widget;

		$data['wrapper'] = $this->m_agenda->getwrapper($id_wrapper);
		$data['iiii'] = $this->m_agenda->getwidget($id_widget,$id_wrapper)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
		foreach($data['iiii'] as $key=>$val){
			@$data['iiii'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
			@$data['iiii'][$key]->seo=str_replace($d, '-', $val->judul);
			@$data['iiii'][$key]->hari_mulai=$hh[$val->hari_mulai];
			@$data['iiii'][$key]->hari_selesai=$hh[$val->hari_selesai];
		}

		$this->load->view('index',$data);
	}

	public function read($id_widget,$id_wrapper)	{
		$data['isi']=$this->m_agenda->ini_agenda($id_wrapper);
		if(!$data['isi'][0]->id_konten || str_replace(" ","-",$data['isi'][0]->nama_kategori)!=$id_widget ){
				redirect(base_url());
		} else {
			$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
			$data['isi'][0]->hari_mulai=$hh[$data['isi'][0]->hari_mulai];
			$data['isi'][0]->hari_selesai=$hh[$data['isi'][0]->hari_selesai];
	
			$data['jkanal'] = Modules::run("web_artikel/root_kanal",$data['isi'][0]->id_kanal);
			$data['kanal']	= Modules::run("web_artikel/cari_kanal",$data['isi'][0]->id_kanal);
			$sessm['kanal'] = $data['kanal'][0]->kanal_path;
			$sessm['tipe_kanal'] = $data['kanal'][0]->tipe;
			$sessm['id_kanal'] = $data['kanal'][0]->id_kanal;
			$sessm['theme'] = $data['kanal'][0]->theme;
			$this->session->set_userdata('visit', $sessm);

			$data['foto']=$this->m_agenda->foto($id_wrapper);
			$data['batas']=10;
			$urutan=$this->m_agenda->urutan_agenda($data['isi'][0]->id_konten,$data['isi'][0]->id_kategori);
			$data['hal']=ceil($urutan['count']/$data['batas']);

			$this->load->view('detail',$data);
		}
	}
	public function getfoto()	{
		$idd=$_POST['idd'];
		$data=$this->m_agenda->getfoto($idd);
		echo json_encode($data);
	}

	public function getagenda()	{
		$batas=$_POST['batas'];
		$rubrik=$_POST['rubrik'];
		$dt=$this->m_agenda->hitung_agenda($rubrik); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_agenda->getagenda($mulai,$batas,$rubrik)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
		foreach($data['hslquery'] as $key=>$val){
			$data['hslquery'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
			$data['hslquery'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['hslquery'][$key]->hari_mulai=$hh[$val->hari_mulai];
			$data['hslquery'][$key]->hari_selesai=$hh[$val->hari_selesai];
		}

		$de = Modules::run("web/pagerB",$dt['count'],$batas,$hal,"agenda");
		$data['pager']=$de;
		echo json_encode($data);
	}

	public function all($id_widget,$id_wrapper)	{
		$data['rubrik']=str_replace("-"," ",$this->uri->segment(5));
		$batas=10;
		$rubrik=$id_wrapper; $data['id_rubrik']=$id_wrapper;
		$dt=$this->m_agenda->hitung_agenda($rubrik); 

		if($id_widget=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$id_widget;	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;
		$data['isi']=$this->m_agenda->getagenda($mulai,$batas,$rubrik)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
		foreach($data['isi'] as $key=>$val){
			$data['isi'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
			$data['isi'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['isi'][$key]->hari_mulai=$hh[$val->hari_mulai];
			$data['isi'][$key]->hari_selesai=$hh[$val->hari_selesai];
		}

		$pph=$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);
		$ddmm = Modules::run("web/pagerD",$dt['count'],$batas,$hal,$pph);
		$ganti=str_replace("XX",$this->uri->segment(5),$ddmm);
		$data['pager']=$ganti;

		$sess = $this->m_agenda->getkanal($rubrik);
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