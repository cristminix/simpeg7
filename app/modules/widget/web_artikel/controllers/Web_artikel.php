<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_artikel extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->model('m_artikel_baca');
	}

	public function read($id_widget,$id_wrapper)	{

		$data['isi']=$this->m_artikel_baca->ini_artikel($id_wrapper);
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$judulseo=str_replace($d, '-', $data['isi'][0]->judul);

		if(!$data['isi'][0]->id_konten || str_replace(" ","-",$data['isi'][0]->nama_kategori)!=$id_widget || $this->uri->segment(5)!=$judulseo ){
				redirect(site_url());
		} else {
			$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
			$data['isi'][0]->hari=$hh[@$data['isi'][0]->hari];
	
			$data['kanal'] = $this->cari_kanal($data['isi'][0]->id_kanal);
				$sessm['kanal'] = $data['kanal'][0]->kanal_path;
				$sessm['tipe_kanal'] = $data['kanal'][0]->tipe;
				$sessm['id_kanal'] = $data['kanal'][0]->id_kanal;
				$sessm['theme'] = $data['kanal'][0]->theme;
				$this->session->set_userdata('visit', $sessm);
			$data['jkanal']=$this->root_kanal($data['isi'][0]->id_kanal);
			$data['gambar']=$this->m_artikel_baca->gambar_artikel($id_wrapper);
	
			$data['batas']=2;
			$urutan=$this->m_artikel_baca->urutan_artikel($data['isi'][0]->id_konten,$data['isi'][0]->id_kategori);
			$data['hal']=ceil($urutan['count']/$data['batas']);
	
			$this->load->view('index',$data);
		}
	}

	public function getartikel()	{
		$batas=$_POST['batas'];
		$rubrik=$_POST['rubrik'];
		$dt=$this->m_artikel_baca->hitung_artikel($rubrik); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_artikel_baca->getartikel($mulai,$batas,$rubrik)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";

		foreach($data['hslquery'] as $key=>$val){
			$data['hslquery'][$key]->seo=str_replace($d, '-', $val->judul);
			$data['hslquery'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
			$data['hslquery'][$key]->hari=$hh[$val->hari];
			$data['hslquery'][$key]->thumb = (!empty($val->foto_thumbs))?$val->id_konten."/".$val->foto_thumbs:"default/no_image.gif" ;
		}

		$de = Modules::run("web/pagerB",$dt['count'],$batas,$hal,"artikel");
		$data['pager']=$de;
		echo json_encode($data);
	}

	public function all($id_widget,$id_wrapper)	{
		$sess = $this->m_artikel_baca->ikanal($id_wrapper);
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$judulseo=str_replace($d, '-', $sess[0]->nama_item);
		if(!$sess[0]->id_kanal || $judulseo!=$this->uri->segment(5) ){
				redirect(site_url());
		} else {
				$dt=$this->m_artikel_baca->hitung_artikel($id_wrapper); 
				$batas=2;
				$data['id_rubrik']=$id_wrapper;
				if($id_widget=="end"){	$hal=ceil($dt['count']/$batas);		} else {	if($id_widget*1>0 && $id_widget<=(ceil($dt['count']/$batas))){	$hal=$id_widget;	} else {	redirect(site_url());	}	}
				$mulai=($hal-1)*$batas;
				$data['mulai']=$mulai+1;
				$data['isi']=$this->m_artikel_baca->getartikel($mulai,$batas,$data['id_rubrik'])->result();
				$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
				$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
				foreach($data['isi'] as $key=>$val){
					@$data['isi'][$key]->seo=str_replace($d, '-', $val->judul);
					$data['isi'][$key]->kat_seo=str_replace($d, '-', $val->nama_kategori);
					$data['isi'][$key]->hari=$hh[$val->hari];
					$fr=$val->isi_artikel;
					$df=explode("\n",$fr);
					$data['isi'][$key]->sub=$df[0];
					$data['isi'][$key]->thumb = (!empty($val->foto_thumbs))?$val->id_konten."/".$val->foto_thumbs:"default/no_image.gif" ;
				}

				$data['rubrik']=$data['isi'][0]->nama_kategori;

				$pph=$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3);
				$ddmm = Modules::run("web/pagerD",$dt['count'],$batas,$hal,$pph,5);
				$ganti=str_replace("XX",$this->uri->segment(5),$ddmm);
				$data['pager']=$ganti;

				$data['id_kanal'] = @$sess[0]->id_kanal;
				$dkn = $this->cari_kanal($sess[0]->id_kanal);
				$sessm['kanal'] = $dkn[0]->kanal_path;
				$sessm['tipe_kanal'] = $dkn[0]->tipe;
				$sessm['id_kanal'] = $dkn[0]->id_kanal;
				$sessm['theme'] = $dkn[0]->theme;
				$this->session->set_userdata('visit', $sessm);
				$data['jkanal']=$this->root_kanal($data['id_kanal']);
		
				$this->load->view('all',$data);
		}
	}

	public function root_kanal($id_kanal)	{
		$iniroot="";
		$jkanal=explode("**",$this->m_artikel_baca->root_kanal($id_kanal));
		for($i=0;$i<count($jkanal)-1;$i++){
			$kanali=explode("*",$jkanal[$i]);
			$iniroot= $iniroot."<li><a href='".site_url()."kanal/".@$kanali[2]."'>".@$kanali[1]."</a></li>";
		}
		return $iniroot;
	}
	public function cari_kanal($id_kanal)	{
		$ckanal	= $this->m_artikel_baca->cari_kanal($id_kanal);
		return $ckanal;
	}
///////////////////////////////////////////////////////////////////////////////////
	public function getkomen()	{
		$batas=$_POST['batas'];
		$dt=$this->m_artikel_baca->hitung_komen($_POST['idd']); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_artikel_baca->getkomen($mulai,$batas,$_POST['idd'])->result();
		$de = Modules::run("web/pagerB",$dt['count'],$batas,$hal,"komen");
		$data['pager']=$de;
		echo json_encode($data);
	}

	public function savekomentar()	{
		$this->load->library("form_validation");
		$this->form_validation->set_rules("nama_komentator","NAMA","trim|required|xss_clean");
		$this->form_validation->set_rules("email_komentator","EMAIL","trim|required|xss_clean");
        $this->form_validation->set_rules("isi_komentar","KOMENTAR","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_artikel_baca->isi_komentar_aksi($_POST);
			echo "sukses#kjkj";
		 }else{
			echo "error-".validation_errors()."#0";	
		 }
	}


}