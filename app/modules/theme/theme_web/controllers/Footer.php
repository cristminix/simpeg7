<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_pack_web');
	}

	function index(){
		$this->load->view("footer");
	}

//////////////////////////////////////////////////////////////////////////////////////////
}	
?>