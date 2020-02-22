<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_banner_slider extends MX_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('web_banner_main/m_web_banner');
	}	

	public function index($id_widget,$id_wrapper,$opsi){

		$data['idd']=$id_wrapper;
		$data['daftar'] = $this->m_web_banner->getwidget($id_widget,$id_wrapper)->result();
		$data['margin_top']=$opsi[0]->nilai;

		$this->load->view('index',$data);
	}
}