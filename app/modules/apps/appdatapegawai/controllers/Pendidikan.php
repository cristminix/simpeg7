<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pendidikan extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function view($id_pegawai=false,$content=array()){
    $content['id_pegawai'] = $id_pegawai;

		$content['datalama'] = $this->getdatalama($id_pegawai);

		$content['data'] = Modules::run("datamodel/pegawai/get_riwayat_pend",$id_pegawai);

		$content['panel_body'] = $this->load->view('pendidikan/panel_body',$content,true);

		$this->load->view('pendidikan/default',$content);
	}
  
	function picker($f=false){

		$this->load->view('pendidikan/picker');

	}

	function getdatalama($id_pegawai=false){

    // $content['data'] = Modules::run("datamodel/pegawai/get_riwayat_pend_lama",$id_pegawai);
    $content['data'] = Modules::run("datamodel/pegawai/get_riwayat_pend",$id_pegawai);

		return $this->load->view('pendidikan/datalama',$content,true);

  }
  
	function getpendidikan(){
    $kode_jenjang = $this->input->post('kode_jenjang');

    $pendidikan = $this->input->post('pendidikan');

    if($kode_jenjang !== "") $this->db->where('kode_jenjang',$kode_jenjang);

    $this->db->like('nama_pendidikan',$pendidikan,'both');

    $this->db->from('m_pendidikan');

    $this->db->order_by('kode_jenjang, nama_pendidikan');

    $content['data'] = $this->db->get()->result();

		$this->load->view('pendidikan/picker_data',$content);
	}
	function form($id_pegawai=false,$id_peg_pend=false){
		$content['id_pegawai'] = $id_pegawai;

		$content['id_peg_pend'] = $id_peg_pend;

		$content['row'] = Modules::run("datamodel/pegawai/get_peg_pend",$id_peg_pend);
		
		$this->load->view('pendidikan/form',$content);
	}
	function save($id_pegawai=false,$id_peg_pend=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_pend",$id_pegawai,$id_peg_pend,$data);

		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
    }
    $this->view($id_pegawai,$content);
	}
	function del($id_pegawai=false,$id_peg_pend=false){
		$result = Modules::run("datamodel/pegawai/del_peg_pend",$id_peg_pend);
		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil dihapus.</div>';
    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil dihapus.</div>';
    }
    $this->view($id_pegawai,$content);
	}
}
?>