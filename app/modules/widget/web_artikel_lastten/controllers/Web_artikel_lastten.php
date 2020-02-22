<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_artikel_lastten extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->model('m_artikel_lastten');
	}

	public function index($id_widget,$id_wrapper,$opsi)	{
		$data['wrapper'] = $this->m_artikel_lastten->ini_wrapper($id_wrapper)->result();
		$data['daftar'] = $this->m_artikel_lastten->getwidget($id_widget,$id_wrapper,$opsi[2]->nilai)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
		foreach ($data['daftar'] as $key=>$val) {
			@$data['daftar'][$key]->hari = $hh[$val->hari];
			@$data['daftar'][$key]->seo = str_replace($d, '-', $val->judul);
			@$data['daftar'][$key]->kat_seo = str_replace($d, '-', $val->nama_kategori);
			$fr=$val->isi_artikel;
			$df=explode("\n",$fr);
			@$data['daftar'][$key]->sub=$df[0];
					$gambar=$this->m_artikel_lastten->gambar_artikel($val->id_konten);
			@$data['daftar'][$key]->thumb = (!empty($gambar))?$val->id_konten."/".$gambar[0]->foto_thumbs:"default/no_image.gif" ;
		}
			$data['margin_top']=$opsi[0]->nilai;
		$this->load->view('index',$data);
	}

}