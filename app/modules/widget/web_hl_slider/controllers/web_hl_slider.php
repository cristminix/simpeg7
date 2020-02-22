<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_hl_slider extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_hl_slider');
	}	

	public function index($id_widget,$id_wrapper,$opsi){

		$data['idd']=$id_wrapper;
		$data['daftar'] = $this->m_hl_slider->getwidget($id_widget,$id_wrapper)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		foreach ($data['daftar'] as $key=>$val) {
			@$data['daftar'][$key]->kat_seo = str_replace($d, '-', $val->nama_kategori);
			@$data['daftar'][$key]->seo=str_replace($d, '-', $val->judul);
			$fr=$val->isi_artikel;
			$df=explode("\n",$fr);
			@$data['daftar'][$key]->sub=$df[0];

			$ssdd = $this->m_hl_slider->cekimage($val->id_konten)->result();
			if(empty($ssdd)){
				@$data['daftar'][$key]->imgslider="assets/media/file/hl_slider/medium_32angrybird.jpg";
				@$data['daftar'][$key]->imgthumbs="assets/media/file/hl_slider/small_32angrybird.jpg";
			} else {
				@$data['daftar'][$key]->imgslider="assets/media/file/artikel/".$val->id_konten."/".@$ssdd[0]->foto;
				@$data['daftar'][$key]->imgthumbs="assets/media/file/artikel/".$val->id_konten."/thumbs_".@$ssdd[0]->foto;
			}
		}
		$data['margin_top']=$opsi[0]->nilai;
		$this->load->view('index',$data);
	}
}