<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
	}	

	function index()
	{
			$id_skp = $this->session->userdata('id_skp');
			$data['id_skp'] = $id_skp;
			$data['skp'] = $this->m_skp->ini_skp($id_skp);
			$data['target'] = $this->m_skp->get_target($id_skp);
			foreach($data['target'] AS $key=>$val){
				$data['realisasi'][$key] = $this->m_skp->get_realisasi($val->id_target);
			}
//		$this->load->view('cetak/index',$data);
		if( ! ini_get('date.timezone') )
		{
			date_default_timezone_set('GMT');
		}

	$this->load->library('pdf');
	$this->pdf->load_view('cetak/index',$data);
	$this->pdf->render();
	$this->pdf->stream("realisasi.pdf");

	}

	function skp()
	{
			$id_skp = $this->session->userdata('id_skp');
			$data['id_skp'] = $id_skp;
			$data['skp'] = $this->m_skp->ini_skp($id_skp);
			$data['target'] = $this->m_skp->get_target($id_skp);
			foreach($data['target'] AS $key=>$val){
				$data['realisasi'][$key] = $this->m_skp->get_realisasi($val->id_target);
			}
		$this->load->view('cetak/skp',$data);

/*

		if( ! ini_get('date.timezone') )
		{
			date_default_timezone_set('GMT');
		}


		$this->load->library('pdf');
		$this->pdf->load_view('cetak/skp',$data);
		$this->pdf->render();
		$this->pdf->stream("skp.pdf");

*/

	}

}