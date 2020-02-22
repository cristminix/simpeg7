<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Dashboard extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('appbkpp/m_unor');
		// $this->load->model('appbkpp/m_pegawai');
		// $this->load->model('appbkpp/m_dashboard');
		// $this->load->model('appskp/m_skp');
	}

	public function index() 
	{
		echo "This is dashboard";
	}
}