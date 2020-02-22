<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Utama extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appdok/m_edok');
		$this->load->model('appbkpp/m_pegawai');
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
	function edit(){
		$idd = $_POST['idd'];
		echo Modules::run("appdok/pasfoto/".$idd,$_POST['id_pegawai']);
	}

}
?>