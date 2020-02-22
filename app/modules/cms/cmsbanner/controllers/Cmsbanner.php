<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmsbanner extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_banner');
	}
	
	function index(){
		$data['jform']="Pengaturan Album Banner";
		$this->load->view('album',$data);
	}
	function getalbum(){
		$batas=$_POST['batas'];
		$dt=$this->m_banner->hitung_album(); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_banner->getalbum($mulai,$batas)->result();
		foreach($data['hslquery'] as $it=>$val){
			$jj = json_decode($val->meta_value);
			$data['hslquery'][$it]->keterangan=$jj->keterangan;
			$idd=$data['hslquery'][$it]->id_kategori;
				$cek=$this->m_banner->isi_album($idd)->result();
				if(!empty($cek)){
					$data['hslquery'][$it]->icon_hapus="";
				}	else	{
					$data['hslquery'][$it]->icon_hapus="<div class=grid_icon onclick=\"loadForm('formhapus','$idd');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
				}
		}
		$de = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}
	function formtambahalbum(){
		$this->load->view('formtambahalbum');
	}
	function tambahalbum_aksi(){
 		$this->form_validation->set_rules("nama_kategori","Nama Album","trim|required|xss_clean");
 		$this->form_validation->set_rules("keterangan","Keterangan","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_banner->tambah_album_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formeditalbum(){
		$idd=$_POST['idd'];
		$data['idd']=$idd;
		$data['hslquery']=$this->m_banner->inialbum($idd);
		$this->load->view('formeditalbum',$data);
	}
	function editalbum_aksi(){
 		$this->form_validation->set_rules("nama_kategori","Nama Album","trim|required|xss_clean");
 		$this->form_validation->set_rules("keterangan","Keterangan","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_banner->edit_album_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}





	function formfoto(){
	$data['idd']=$_POST['idd'];
	$data['isi']=$this->m_banner->inialbum($data['idd']); 
		$jj = json_decode($data['isi'][0]->meta_value);
	$data['isi'][0]->keterangan = $jj->keterangan;
	$data['foto']=$this->m_banner->banner($data['idd']); 
	$data['nomax']=count($data['foto'])+1;
		$this->load->view('formfoto',$data);
	}
	function saveupload(){
		if(strlen($_FILES['artikel_file']['name'])>0){
				$id_kategori = $_POST['id_kategori'];
				$nama_file = str_replace(" ","_",$_FILES['artikel_file']['name']);
				$result = $this->uploadFile($id_kategori,$_FILES['artikel_file'],$nama_file);

				$config['image_library'] = 'gd2';
				$config['width'] = 250;
				$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				//$config['thumb_marker']='';
				$config['source_image'] = 'assets/media/file/banner/'.$nama_file;
				//$cek = createImageThumbnail(250,150,$config);
				$this->load->library('image_lib', $config);
//				$cek = $this->image_lib->resize();


				if($result['status']=='error'){
					echo "error-<b>File gagal di upload</b> : <br />".$result['error'];
				}else{
					echo "success-".$result['id'];
				}
		}else{
			echo "error-<b>Tidak ada file</b>";
		}
	}

	function uploadFile($id_kategori,$file,$nama_file){
		$this->load->helper('file');
			$path="assets/media/file/banner/";
		
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'jpg|png|gif|bmp|jpeg';
//		$config['max_size']	= '512';
		$config['remove_spaces']=true;
        $config['overwrite']=true;
		
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('artikel_file'))		{
			$data= array('status' => 'error', 'error' => $this->upload->display_errors());
			return $data;
		}	else {
			$this->m_banner->simpan_banner($id_kategori,$nama_file);
		}

	}

	function hapus_foto_aksi(){
		$dfoto=$this->m_banner->hapus_banner_aksi($_POST)->result(); 
		$foto=$dfoto[0]->file_image;
		unlink("assets/media/file/banner/$foto");
		echo "sukses#"."add#";
	}
	function reurut_foto(){
			$this->m_banner->reurut_banner_aksi($_POST);
	}
	function edit_foto(){
	$data['idd']=$_POST['idd'];
	$jml=count($this->input->post('judul_foto')); 
		for($i=0;$i<$jml;$i++){
			$nomor=	$_POST['urutan'][$i];
				$this->form_validation->set_rules("link[$i]","Link No.$nomor","trim|required|xss_clean");
				$this->form_validation->set_rules("keterangan[$i]","Keterangan No.$nomor","trim|required|xss_clean");
		}	
		if($this->form_validation->run()) {
			$this->m_banner->edit_banner_aksi($_POST);
			echo "sukses#"."add#";
		}
	}



	function custom_kategori(){
//		echo "<tr><td colspan=4>Artikel</td></tr>";
		echo "";
	}






}

?>