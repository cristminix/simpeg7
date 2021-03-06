<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Foto extends MX_Controller {

	function __construct(){
	
    parent::__construct();
	
  }
	
  function view($id_pegawai=false,$content=array())
  {
		$content['id_pegawai'] = $id_pegawai;
    
    $content['fotoSrc'] = Modules::run("datamodel/pegawai/get_peg_fotosrc",$id_pegawai);
		
    $this->load->view('foto/default',$content);
  }
	
  function upload($id_pegawai=false)
  {
    // $id_pegawai = $this->input->post('ID');

		// $config['file_name'] = './uploads/';
		$config['upload_path'] = './assets/file/foto/';
		// $config['upload_path'] = './assets/file/';
		$config['allowed_types'] = 'jpg';
		// $config['max_size']	= '100';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';
    
		$this->load->library('upload', $config);
    
    $field_name = "file_foto";
        
		if ( ! $this->upload->do_upload($field_name))
		{
      $result = array('reload'=>false,'message' =>'<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> '.str_replace(array('<p>','</p>'),'',$this->upload->display_errors()).'</div>');
      
			echo json_encode($result);
		}
		else
		{
			$data = $this->upload->data();
      
      $this->db->set('foto','foto/'.$data['file_name']);
      $this->db->where('id_pegawai',$id_pegawai);
      $this->db->update('r_peg_foto');
      
			echo 'success';
		}
    
  }
}
?>