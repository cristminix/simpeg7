<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_statis extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_statis');
	}

	public function index($id_widget,$id_wrapper,$opsi)	{
		$data['wrapper'] = $this->m_statis->ini_wrapper($id_wrapper);
		$data['daftar'] = $this->m_statis->getwidget($id_widget,$id_wrapper)->result();
	    $d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+',' ');
		$hh = array(); $hh['Sunday']="Minggu"; $hh['Monday']="Senin"; $hh['Tuesday']="Selasa"; $hh['Wednesday']="Rabu"; $hh['Thursday']="Kamis"; $hh['Friday']="Jum'at"; $hh['Saturday']="Sabtu";
			@$data['daftar'][0]->hari = $hh[$val->hari];
			@$data['daftar'][0]->seo = str_replace($d, '-', $val->judul);
			@$data['daftar'][0]->kat_seo = str_replace($d, '-', $val->nama_kategori);
			$data['margin_top']=$opsi[0]->nilai;
		$this->load->view('index',$data);
	}

}