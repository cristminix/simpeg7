<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmspolling extends MX_Controller {

	function __construct(){
		$this->auth->restrict();
		$this->load->library("paging");
	}

////////////////////////////////////////////////////////////////////
///////////////////////////RUBRIK HANDLING//////////////////////////
	function custom_kategori(){
//		echo "<tr><td colspan=4>Artikel</td></tr>";
		echo "";
	}



}
?>