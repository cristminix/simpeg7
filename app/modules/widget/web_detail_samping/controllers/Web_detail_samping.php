<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_detail_samping extends MX_Controller {

	function __construct()	{
		parent::__construct();
		$this->load->library("session");
		$this->load->model('m_web_detail_samping');
	}
	public function index($id_kanal,$komponen="xxx",$ikat=1000)	{
		$data['artikel']=$this->m_web_detail_samping->cari_rubrik_kanal($id_kanal);
		foreach($data['artikel'] as $key=>$val){
			@$data['artikel'][$key]->status=(@$data['artikel'][$key]->id_kategori==$ikat)?"aktif":"pasif";		
		}
		$this->load->view('index',$data);
	}
}