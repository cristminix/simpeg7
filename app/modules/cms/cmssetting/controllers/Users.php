<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Users extends MX_Controller {

  function __construct(){
    parent::__construct();
  }

  function index(){
	$data['satu'] = "Daftar Pengguna Aplikasi";
    $this->load->view('users/index', $data);    
  }
  public function data() 
  {
    $this->load->model('cmssetting/m_users');
    echo $this->m_skp->get_data();
  }
}
?>