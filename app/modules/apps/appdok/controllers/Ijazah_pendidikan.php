<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Ijazah_pendidikan extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appdok/m_edok');
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
	function edit(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['row'] = Modules::run("appbkpp/pegawai/ini_riwayat_pendidikan",$_POST['idd']);
		@$data['row']->tanggal_lulus = date("d-m-Y", strtotime($data['row']->tanggal_lulus));
		$this->load->view('ijazah_pendidikan/form',$data);
	}

	function hapus(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['row'] = Modules::run("appbkpp/pegawai/ini_riwayat_pendidikan",$_POST['idd']);
		@$data['row']->tanggal_lulus = date("d-m-Y", strtotime($data['row']->tanggal_lulus));
		$data['hapus'] = "ya";
		$this->load->view('ijazah_pendidikan/form',$data);
	}

	function tambah(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['row'] = Modules::run("datamodel/pegawai/get_peg_pend",$_POST['idd']);
		$this->load->view('ijazah_pendidikan/form',$data);
	}

	function uploadDok(){
		$data['id_pegawai'] = $_POST['id_pegawai'];
		$data['idd'] = $_POST['idd'];
		$data['komponen'] = $_POST['komponen'];
		$data['isi'] = $this->m_edok->ini_pendidikan($_POST['idd']);
		$data['row'] = $this->m_edok->cek_dokumen($_POST['id_pegawai'],$_POST['komponen'],$_POST['idd']);
		$this->load->view('ijazah_pendidikan/upload',$data);
	}

	function edit_keterangan_aksi(){
		$this->m_edok->edit_keterangan_dokumen($_POST);
		echo json_encode($_POST);
	}

	function saveupload(){
		if(strlen($_FILES['artikel_file']['name'])>0){
				$id_pegawai = $_POST['id_pegawai'];
				$komponen = $_POST['komponen'];
				$idd = $_POST['idd'];
				$nama_file = str_replace(" ","_",$_FILES['artikel_file']['name']);
				$result = $this->uploadFile($id_pegawai,$_FILES['artikel_file'],$nama_file,$komponen,$idd);


				$config['image_library'] = 'gd2';
				$config['width'] = 250;
				$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				//$config['thumb_marker']='';
				$config['source_image'] = 'assets/media/file/'.$id_pegawai.'/'.$komponen.'/'.$nama_file;
				$config['new_image'] = 'assets/media/file/'.$id_pegawai.'/'.$komponen.'/thumb_'.$nama_file;
				//$cek = createImageThumbnail(250,150,$config);
				$this->load->library('image_lib', $config);
				$cek = $this->image_lib->resize();


				if($result['status']=='error'){
					echo "error-<b>File gagal di upload</b> : <br />".$result['error'];
				}else{
					echo "success-".$result['id'];
				}
		}else{
			echo "error-<b>Tidak ada file</b>";
		}
	}

	function uploadFile($id_pegawai,$file,$nama_file,$komponen,$idd){
		$this->load->helper('file');
			$path="assets/media/file/".$id_pegawai."/";
			if(!file_exists($path)){	mkdir($path,755);	}
			$path2="assets/media/file/".$id_pegawai."/".$komponen."/";
			if(!file_exists($path2)){	mkdir($path2,755);	}
		
		$config['upload_path'] = $path2;
		$config['allowed_types'] = 'jpg|png|gif|bmp|jpeg';
//		$config['max_size']	= '512';
		$config['remove_spaces']=true;
        $config['overwrite']=true;
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('artikel_file'))		{
			$data= array('status' => 'error', 'error' => $this->upload->display_errors());
			return $data;
		}	else {
			$this->m_edok->simpan_dokumen($id_pegawai,$nama_file,$komponen,$idd);
		}

	}
	
	function hapus_dok(){
		$komponen = $_POST['komponen'];
		$id_pegawai = $_POST['id_pegawai'];
		$id_dokumen = $_POST['id_dokumen'];
		$dok = $this->m_edok->ini_dokumen($id_dokumen);
		unlink("assets/media/file/".$id_pegawai."/".$komponen."/".$dok->file_dokumen);
		unlink("assets/media/file/".$id_pegawai."/".$komponen."/".$dok->file_thumb);
		$hp = $this->m_edok->hapus_dokumen($id_dokumen,$id_pegawai,$komponen,$_POST['idd']);
/*
		if(empty($hp)){
			rmdir("assets/media/file/".$id_pegawai."/".$komponen);
			rmdir("assets/media/file/".$id_pegawai."/".$komponen);
		}
*/
			echo "<b>Sukses...</b>";
	}

}
?>