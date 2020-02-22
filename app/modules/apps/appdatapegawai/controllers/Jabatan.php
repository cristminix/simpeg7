<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Jabatan extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function view($id_pegawai=false,$content=array()){
		$content['id_pegawai'] = $id_pegawai;
		$content['data'] = Modules::run("datamodel/pegawai/get_riwayat_jabatan",$id_pegawai);
		$content['panel_body'] = $this->load->view('jabatan/panel_body',$content,true);
		$content['datalama'] = $this->getdatalama($id_pegawai);

		$this->load->view('jabatan/default',$content);
	}
	function getdatalama($id_pegawai=false){
    
    // $content['data'] = Modules::run("datamodel/pegawai/get_riwayat_pangkat_lama",$id_pegawai);
    
		// return $this->load->view('kepangkatan/datalama',$content,true);
    
    return 'huya';
    
  }
	function form_js($id_pegawai=false,$id_peg_jab=false){
		$content['id_pegawai'] = $id_pegawai;
		$content['id_peg_jab'] = $id_peg_jab;
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_jabatan",$id_peg_jab);
		
		$this->load->view('jabatan/form_js',$content);
	}
	function form_jf($id_pegawai=false,$id_peg_jab=false){
		$content['id_pegawai'] = $id_pegawai;
		$content['id_peg_jab'] = $id_peg_jab;
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_jabatan",$id_peg_jab);
		
		$this->load->view('jabatan/form_jf',$content);
	}
	function picker($f=false){
    
		$this->load->view('jabatan/'.$f);
    
	}
	function getunor($f=false){
    
		$nama_unor = $this->input->post('nama_unor');
    $this->db->like('nomenklatur_cari',$nama_unor,'both');
    $this->db->order_by('kode_unor');
    $content['data'] = $this->db->get('m_unor')->result();
    
		$this->load->view('jabatan/pickerunor_data',$content);
	}
	function getjabatan($f=false){
    
		$nama_jenis_jabatan = $this->input->post('nama_jenis_jabatan');
		$nama_jabatan_jf = $this->input->post('nama_jabatan_jf');
    
    // echo $nama_jenis_jabatan;
    if($this->input->post('nama_jenis_jabatan')) $this->db->where('jab_type',$nama_jenis_jabatan);
    
    $this->db->like('nama_jabatan',$nama_jabatan_jf,'both');
    
    $this->db->order_by('nama_jabatan');
    
    $content['data'] = $this->db->get('m_jf')->result();
    
		$this->load->view('jabatan/pickerjabatan_data',$content);
	}
	function save($id_pegawai=false,$id_peg_jab=false,$data=array()){
		$result = Modules::run("datamodel/pegawai/set_peg_jabatan",$id_pegawai,$id_peg_jab,$data);
		// $result = true;
		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
    }
    $this->view($id_pegawai,$content);
	}
	function del($id_pegawai=false,$id_peg_jab=false){
		$result = Modules::run("datamodel/pegawai/del_peg_jabatan",$id_peg_jab);
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