<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_index_tutorial extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_index_tutorial');
	}

	public function index($id_widget,$id_wrapper,$opsi)	{

		$data['wrapper'] = $this->m_index_tutorial->ini_wrapper($id_wrapper);
		$data['daftar'] = $this->m_index_tutorial->getwidget($id_widget,$id_wrapper)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
		foreach ($data['daftar'] as $key=>$val) {
			@$data['daftar'][$key]->kat_seo = str_replace($d, '-', $val->nama_kategori);
			@$data['daftar'][$key]->isi = $this->m_index_tutorial->getisi($val->id_kategori)->result();
				foreach ($data['daftar'][$key]->isi as $key2=>$val2) {
					@$data['daftar'][$key]->isi[$key2]->seo = str_replace($d, '-', $val2->judul);
				}
		}

		$data['margin_top']=$opsi[0]->nilai;
		$this->load->view('index',$data);
	}

}