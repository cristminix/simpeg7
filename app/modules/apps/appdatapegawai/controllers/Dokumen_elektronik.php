<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Dokumen_elektronik extends MX_Controller {

	function __construct(){
    parent::__construct();
	}
	function view($id_pegawai=false){
		// $content['data'] = Modules::run("datamodel/pegawai/get_peg_alamat",$id_pegawai);
		$content['id_pegawai'] = $id_pegawai;
		$this->load->view('dokumen_elektronik/default',$content);
	}
	function save($id_pegawai=false,$data=array()){
		// $result = Modules::run("datamodel/pegawai/set_peg_alamat",$id_pegawai,$data);
		if($result)
		{
			echo '<div class="alert alert-success pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> Data berhasil disimpan.</div>';
		}else
		{
			echo '<div class="alert alert-warning pull-right" role="alert"><i class="fa fa-thumbs-o-down"></i> Data tidak berhasil disimpan.</div>';
		}
	}
	public function fetch($id_pegawai)
	{
		$records = $this->db->where('id_pegawai',$id_pegawai)
							->get('r_peg_dokumen_elektronik')
							->result_array();
		echo json_encode($records);
	}
	public function create()
	{
		$response = [
			'success' => true
		];
		$id_pegawai = $this->input->post('id_pegawai');
		if(is_numeric($id_pegawai)){
			$title = $this->input->post('title');
			// $file = $this->input->post('data');
			// UPLOAD
			// $config['file_name'] = './uploads/';
			$config['upload_path'] = FCPATH.'/assets/file/dokumen/';
			// $config['upload_path'] = './assets/file/';
			$config['allowed_types'] = 'jpg|jpeg|png|doc|docx|xlx|xlsx|ppt|pptx|pdf|txt';
			// $config['max_size']	= '1024';
			// $config['max_width']  = '1024';
			// $config['max_height']  = '768';
	    
			$this->load->library('upload', $config);
	    
	    	$field_name = "attachment";
	        
			if ( ! $this->upload->do_upload($field_name))
			{
				$msg = str_replace(array('<p>','</p>'),'',$this->upload->display_errors());
				$response['msg'] = $msg;
				$response['success'] = false;
				echo json_encode($response);
				exit();
			}
			$uploaded_file = $this->upload->data();
      		$response['uploaded_file'] = $uploaded_file;
			$data = [
				'title' => $title,
				'data' => $uploaded_file['file_name'],
				'id_pegawai' => $id_pegawai
			];
	    	$this->db->insert('r_peg_dokumen_elektronik',$data);
	    	$response['data'] = $data;
	    	echo json_encode($response);
		}
	}
	public function delete()
	{
		$response = [
			'success' => true
		];
		$id = $this->input->post('id');
		if(is_numeric($id)){
			$row = $this->db->where('id',$id)
							->get('r_peg_dokumen_elektronik')
							->row();
			if(!empty($row)){
				// unlink file
				$filepath = FCPATH . 'assets/file/dokumen/'.$row->data;
				if(file_exists($filepath)){
					@unlink($filepath);
				}
				// delete rec
				$this->db->where('id',$id)
							->delete('r_peg_dokumen_elektronik');
			}
		}

		echo json_encode($response);
	}
	public function delete_attachment()
	{
		$response = [
			'success' => true
		];
		$id = $this->input->post('id');
		if(is_numeric($id)){
			$row = $this->db->where('id',$id)
							->get('r_peg_dokumen_elektronik')
							->row();
			if(!empty($row)){
				// unlink file
				$filepath = FCPATH . 'assets/file/dokumen/'.$row->data;
				if(file_exists($filepath)){
					@unlink($filepath);
				}
				// delete rec
				$this->db->where('id',$id)
							->update('r_peg_dokumen_elektronik',['data'=>'']);
			}
		}

		echo json_encode($response);
	}
	public function update()
	{
		$response = [
			'success' => true
		];
		$id = $this->input->post('id');
		$id_pegawai = $this->input->post('id_pegawai');
		if(is_numeric($id)){
			$title = $this->input->post('title');
			// $file = $this->input->post('data');
			// UPLOAD
			// $config['file_name'] = './uploads/';
			$config['upload_path'] = FCPATH.'/assets/file/dokumen/';
			// $config['upload_path'] = './assets/file/';
			$config['allowed_types'] = 'jpg|jpeg|png|doc|docx|xlx|xlsx|ppt|pptx|pdf|txt';
			// $config['max_size']	= '1024';
			// $config['max_width']  = '1024';
			// $config['max_height']  = '768';
	    
			$this->load->library('upload', $config);
	    
	    	$field_name = "attachment";
	        
			if ( ! $this->upload->do_upload($field_name))
			{
				$msg = str_replace(array('<p>','</p>'),'',$this->upload->display_errors());
				$response['msg'] = $msg;
				$response['success'] = false;
				echo json_encode($response);
				exit();
			}
			$uploaded_file = $this->upload->data();
      		$response['uploaded_file'] = $uploaded_file;
			$data = [
				'title' => $title,
				'data' => $uploaded_file['file_name'],
				// 'id_pegawai' => $id_pegawai
			];
	    	$this->db->where('id',$id)->update('r_peg_dokumen_elektronik',$data);
	    	$response['data'] = $data;
	    	echo json_encode($response);
		}
	}
}