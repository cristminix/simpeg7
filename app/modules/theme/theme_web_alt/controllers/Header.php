<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_pack_web');
	}

	function index(){
			$sess = $this->session->userdata('visit');
			$header = $this->m_pack_web->get_opsi($sess['kanal']);
		if(!empty($header)){
			$jj = json_decode($header[0]->meta_value);
			$data['jadal'] = $jj->judul_header;
			$data['sub_jadal'] = $jj->sub_judul;
			$data['height'] = $jj->height;
			$data['margin_top'] = $jj->margin_top;
			$data['margin_bottom'] = $jj->margin_bottom;
			$data['padding_top'] = $jj->padding_top;
			$data['padding_bottom'] = $jj->padding_bottom;
		} else {
			$data['jadal'] = "";
			$data['sub_jadal'] = "";
				$tpl = $this->m_pack_web->gettemplate_by_path($sess['theme']);
				$jj=json_decode($tpl[0]->meta_value);
			$data['height'] = $jj->header_opsi->height;
			$data['margin_top'] = $jj->header_opsi->margin_top;
			$data['margin_bottom'] = $jj->header_opsi->margin_bottom;
			$data['padding_top'] = $jj->header_opsi->padding_top;
			$data['padding_bottom'] = $jj->header_opsi->padding_bottom;
		}

		$this->load->view("header",$data);
	}

//////////////////////////////////////////////////////////////////////////////////////////
}	
?>