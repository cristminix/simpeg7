<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_direktori extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_direktori');
	}

	public function index($id_widget,$id_wrapper)	{
		$data['id_wrapper']=$id_wrapper;
		$data['id_widget']=$id_widget;

		$data['wrapper'] = $this->m_direktori->getwrapper($id_wrapper);
		$ddtt = $this->m_direktori->getwidget($id_widget,$id_wrapper)->result();

	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		foreach($ddtt as $key=>$val){
			@$data['iiii'][$key]->id_kategori=$ddtt[$key]->id_kategori;
			$data['iiii'][$key]->nama_kategori=$ddtt[$key]->nama_kategori;
			$data['iiii'][$key]->seo=str_replace($d, '-', $ddtt[$key]->nama_kategori);
		}

		$this->load->view('index',$data);
	}

	public function all($id_widget,$id_wrapper)	{
		$sess = $this->m_direktori->ikanal($id_wrapper);
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$judulseo=str_replace($d, '-', $sess[0]->nama_item);
		if(!$sess[0]->id_kanal || $judulseo!=$this->uri->segment(5) ){
				redirect(site_url());
		} else {

					$data['rubrik']=str_replace("-"," ",$this->uri->segment(5));
					$batas=2;
					$rubrik=$id_wrapper; $data['id_rubrik']=$id_wrapper;
					$dt=$this->m_direktori->hitung_direktori($rubrik); 
			
					if($id_widget=="end"){	$hal=ceil($dt['count']/$batas);		} else {	if($id_widget*1>0 && $id_widget<=(ceil($dt['count']/$batas))){	$hal=$id_widget;	} else {	redirect(site_url());	}	}
					$mulai=($hal-1)*$batas;
					$data['mulai']=$mulai+1;
					$data['isi']=$this->m_direktori->getdirektori($mulai,$batas,$rubrik)->result();
					$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
					foreach($data['isi'] as $key=>$val){
						@$data['isi'][$key]->seo=str_replace($d, '-', $val->judul);
						$data['isi'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
						$data['isi'][$key]->thumb = (!empty($val->foto_thumbs))?"direktori/".$val->id_konten."/".$val->foto_thumbs:"artikel/default/no_image.gif" ;
					}
			
					$pph=$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);
					$ddmm = Modules::run("web/pagerD",$dt['count'],$batas,$hal,$pph,5);
					$ganti=str_replace("XX",$this->uri->segment(5),$ddmm);
					$data['pager']=$ganti;
			

					$data['id_kanal'] = @$sess[0]->id_kanal;
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


	public function getdirektori()	{
		$batas=$_POST['batas'];
		$rubrik=$_POST['rubrik'];
		$dt=$this->m_direktori->hitung_direktori($rubrik); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_direktori->getdirektori($mulai,$batas,$rubrik)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');

		foreach($data['hslquery'] as $key=>$val){
			$data['hslquery'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['hslquery'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
		}

		$de = Modules::run("web/pagerB",$dt['count'],$batas,$hal,"artikel");
		$data['pager']=$de;
		echo json_encode($data);
	}


	public function read($id_widget,$id_wrapper)	{
		$data['isi']=$this->m_direktori->ini_direktori($id_wrapper);
		if(!$data['isi'][0]->id_konten || str_replace(" ","-",$data['isi'][0]->nama_kategori)!=$id_widget ){
				redirect(site_url());
		} else {

			$data['kanal'] = Modules::run("web_artikel/cari_kanal",$data['isi'][0]->id_kanal);
				$sessm['kanal'] = $data['kanal'][0]->kanal_path;
				$sessm['tipe_kanal'] = $data['kanal'][0]->tipe;
				$sessm['id_kanal'] = $data['kanal'][0]->id_kanal;
				$sessm['theme'] = $data['kanal'][0]->theme;
				$this->session->set_userdata('visit', $sessm);
			$data['jkanal']=Modules::run("web_artikel/root_kanal",$data['isi'][0]->id_kanal);
			$data['atr'] = json_decode($data['isi'][0]->isi_artikel);

			$data['batas']=2;
			$urutan=$this->m_direktori->urutan_direktori($data['isi'][0]->urutan,$data['isi'][0]->id_kategori);
			$data['hal']=ceil($urutan['count']/$data['batas']);

			$this->load->view('detail',$data);
		}
	}



}