<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Mutasi extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('sikda');
	}
  
	function index($content=array()){
	
    $this->load->view('mutasi/default',$content);

	}

	function cari($id_pegawai=false,$content=array()){
    $this->db->where('nip_baru',$this->input->post('nip_baru'));
    $this->db->where("nip_baru !='' ",'',false);
    $data = $this->db->get('rekap_peg')->row();
    
    if($data){
      
      $id_pegawai = $data->id_pegawai;
      
      }else{
      
      $id_pegawai = false;
      
    }
    $this->view($id_pegawai,array());
	}

	function view($id_pegawai=false,$content=array()){
    
    
    $content['id_pegawai'] = $id_pegawai; 
    
    $content['row'] = Modules::run("datamodel/pegawai/get_pegawai",$id_pegawai);
    
    $this->index($content);
	
  }
  
	function form_js(){
	
    $content['id_pegawai'] = $this->input->post('id_pegawai');
		$content['id_peg_jab'] = 'add';
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_jabatan",'add');
		
		$this->load->view('mutasi/form_js',$content);
	}
	function form_jf(){
    $content['id_pegawai'] = $this->input->post('id_pegawai');
		$content['id_peg_jab'] = 'add';
		$content['row'] = Modules::run("datamodel/pegawai/get_peg_jabatan",'add');
		
		$this->load->view('mutasi/form_jf',$content);
	}
	function picker($f=false){
    
		$this->load->view('mutasi/'.$f);
    
	}
	function getunor($f=false){
    
		$nama_unor = $this->input->post('nama_unor');
    $this->db->like('nomenklatur_cari',$nama_unor,'both');
    $this->db->order_by('kode_unor');
    $content['data'] = $this->db->get('m_unor')->result();
    
		$this->load->view('mutasi/pickerunor_data',$content);
	}
	function getjabatan($f=false){
    
		$nama_jenis_jabatan = $this->input->post('nama_jenis_jabatan');
		$nama_jabatan_jf = $this->input->post('nama_jabatan_jf');
    
    // echo $nama_jenis_jabatan;
    if($this->input->post('nama_jenis_jabatan')) $this->db->where('jab_type',$nama_jenis_jabatan);
    
    $this->db->like('nama_jabatan',$nama_jabatan_jf,'both');
    
    $this->db->order_by('nama_jabatan');
    
    $content['data'] = $this->db->get('m_jf')->result();
    
		$this->load->view('mutasi/pickerjabatan_data',$content);
	}
	function submit(){
    $id_pegawai= $this->input->post('id_pegawai');
    $id_peg_jab=$this->input->post('id_peg_jab');
    $data=$this->input->post();
    $this->save($id_pegawai,$id_peg_jab,$data);
  }
	function save($id_pegawai=false,$id_peg_jab=false,$data=array()){
    $action_data['lama'] = Modules::run("datamodel/pegawai/get_pegawai",$id_pegawai);
		$result = Modules::run("datamodel/pegawai/set_peg_jabatan",$id_pegawai,$id_peg_jab,$data);

		if($result)
    {
      $content['notif'] = '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';

      $action_data['akhir'] = Modules::run("datamodel/pegawai/get_pegawai",$id_pegawai);
      $action_data['input'] = $this->input->post();
      
      $action_desc = 'Mutasi Pegawai a.n '.$action_data['lama']->nama_pegawai.' dari jabatan '.$action_data['lama']->nomenklatur_jabatan.' pada '.$action_data['lama']->nomenklatur_pada.' menjadi jabatan '.$action_data['akhir']->nomenklatur_jabatan.' pada '.$action_data['akhir']->nomenklatur_pada;

      $this->db->set('id_pegawai',$id_pegawai);

      $this->db->set('user_id', $this->session->userdata('user_id'));

      $this->db->set('action_name','Modul Mutasi Pegawai');

      $this->db->set('action_desc',$action_desc);

      $this->db->set('action_data',json_encode($action_data));

      $this->db->set('action_time','NOW()',false);

      $this->db->insert('r_peg_log');

    }else
    {
      $content['notif'] = '<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
    }
    $this->view($id_pegawai,$content);
	}
}
?>