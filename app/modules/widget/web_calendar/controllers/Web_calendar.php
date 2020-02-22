<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_calendar extends MX_Controller {
	public function __construct(){
		parent::__construct();
	}	

	public function index($id_widget,$id_wrapper,$opsi){

		$data['idd']=$id_wrapper;
		$data['margin_top']=$opsi[0]->nilai;

		$this->load->view('index',$data);
	}
}