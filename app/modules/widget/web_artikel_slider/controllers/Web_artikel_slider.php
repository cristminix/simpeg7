<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_artikel_slider extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->model('m_artikel_slider');
	}

	public function index($id_widget,$id_wrapper,$opsi)	{
		$data['idd']=$id_wrapper;
		$data['daftar'] = $this->m_artikel_slider->getwidget($id_widget,$id_wrapper)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		foreach ($data['daftar'] as $key=>$val) {
			@$data['daftar'][$key]->kat_seo = str_replace($d, '-', $val->nama_kategori);
			@$data['daftar'][$key]->seo=str_replace($d, '-', $val->judul);
			$fr=$val->isi_artikel;
			$df=explode("\n",$fr);
			@$data['daftar'][$key]->sub=$df[0];

			$ssdd = $this->m_artikel_slider->cekimage($val->id_konten)->result();
			@$data['daftar'][$key]->imgslider=(empty($ssdd))?"assets/media/file/slider/default/slide_".($key+1).".jpg":"assets/media/file/slider/".$val->id_konten."/".@$ssdd[0]->foto;
		}


		$data['margin_top']=$opsi[0]->nilai;
		$this->load->view('index',$data);
	}

}