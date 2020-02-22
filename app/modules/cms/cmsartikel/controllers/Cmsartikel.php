<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmsartikel extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_artikel');
	}
////////////////////////////////////////////////////////////////////
	function index(){
		$data['jform']="Pengaturan Artikel";
		$data['rubrik_options'] = Modules::run("cmshome/kategori_options","","artikel");
		$this->load->view('index',$data);
	}
	function getkonten(){
		$dt = Modules::run("cmshome/hitungkonten",$_POST['rubrik'],$_POST['komponen']); 
		if($dt['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else { 
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;

			$data['hslquery'] = Modules::run("cmshome/getkonten",$mulai,$batas,$_POST['rubrik'],$_POST['komponen'])->result();
			foreach($data['hslquery'] as $it=>$val){
					$cek = Modules::run("cmshome/fotokonten",$val->id_konten);
					if(!empty($cek)){
						$data['hslquery'][$it]->cek="ada";
						$data['hslquery'][$it]->thumb=@$cek[0]->foto_thumbs;
					}	else	{
						$data['hslquery'][$it]->cek="kosong";
						$data['hslquery'][$it]->thumb="";
					}
					$cek2=$this->m_artikel->slider_artikel($val->id_konten)->result();
					if(!empty($cek2)){
						$data['hslquery'][$it]->cek2="ada";
						$data['hslquery'][$it]->slider=@$cek2[0]->file_thumb;
					} else {
						$data['hslquery'][$it]->cek2="kosong";
						$data['hslquery'][$it]->slider="";
					}
			}
			$data['pager'] = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
		}
			echo json_encode($data);
	}
	
	function formcontent($id){
		$row = Modules::run("cmshome/detailkonten",$id);
		if(!empty($row[0]->id_konten)){
			$content = array('komponen'=>$_POST['komponen'],'id_konten' => @$row[0]->id_konten, 'judul'=> @$row[0]->judul, 'id'=>0 , 
			'sub_judul'=>@$row[0]->sub_judul, 'tanggal'=> @$row[0]->tanggal , 'isi_artikel'=> @$row[0]->isi_artikel,'urutan'=> @$row[0]->urutan,
			'penulis_options'=> Modules::run("cmshome/penulis_options",@$row[0]->id_penulis),
			'rubrik_name' => @$row[0]->nama_kategori,'rubrik_options'=>Modules::run("cmshome/kategori_options",@$row[0]->id_kategori,$_POST['komponen']));
		} else {
			$content = array('komponen'=>$_POST['komponen'],'id_konten' => 0, 'judul'=>'','sub_judul'=>'','tanggal'=>'','isi_artikel'=>'','urutan'=>'',
			'rubrik_name'=>"",'rubrik_options'=>Modules::run("cmshome/kategori_options","",$_POST['komponen']),
			'penulis_options'=> Modules::run("cmshome/penulis_options",""), 'id'=>0);
		}
		$data=$content;
		$this->load->view('formcontent',$data);
	}

	function saveartikel(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules("judul","Judul","required");
        $this->form_validation->set_rules("tanggal","Tanggal","required");
        $this->form_validation->set_rules("id_kategori","Rubrik","required");
 		$this->form_validation->set_rules("id_penulis","Penulis","required");
		if($this->form_validation->run()) {
						if($this->input->post('id_konten') == 0):
							$this->m_artikel->tambah_aksi($_POST);
						else:	
							$this->m_artikel->edit_aksi($_POST);
						endif;
						echo "sukses#kjkj";
		 }else{
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formhapus(){
		$data['isi'] = Modules::run("web/detailkonten",$_POST['idd']);
		$this->load->view('formhapus',$data);
	}

	function hapusartikel(){
		$hasil = $this->m_artikel->hapus_aksi($_POST);
		foreach($hasil as $key=>$val){
			unlink("assets/media/file/artikel/".$_POST['id_konten']."/".$val->file_image."");
			unlink("assets/media/file/artikel/".$_POST['id_konten']."/".$val->file_thumb."");
		}
		if(!empty($hasil[0]->file_image)){
			rmdir("assets/media/file/artikel/".$_POST['id_konten']."");
		}

		$hpslider['idd']=$_POST['id_konten'];

		$dfoto=$this->m_artikel->hapus_slider_aksi($hpslider)->result(); 
		if(!empty($dfoto[0]->file_slider)){
				$foto=$dfoto[0]->file_slider;
				$thumb=$dfoto[0]->file_thumb;
				unlink("assets/media/file/slider/".$_POST['id_konten']."/$foto");
				unlink("assets/media/file/slider/".$_POST['id_konten']."/$thumb");
				rmdir("assets/media/file/slider/".$_POST['id_konten']."");
		}
		echo "sukses#kjkj";
	}

	function reurut_foto(){
		$this->m_artikel->reurut_foto_aksi($_POST);
	}
	function hapus_foto_aksi(){
		$dfoto=$this->m_artikel->hapus_foto_aksi($_POST)->result(); 
		$foto=$dfoto[0]->foto;
		$thumb=$dfoto[0]->foto_thumbs;
		unlink("assets/media/file/".$_POST['komponen']."/".$_POST['idd']."/$foto");
		unlink("assets/media/file/".$_POST['komponen']."/".$_POST['idd']."/$thumb");
//		$cfoto=$this->m_artikel->foto_artikel($_POST)->result(); 
		$cfoto = Modules::run("web/fotokonten",$_POST['idd']);
		if(empty($cfoto)){rmdir("assets/media/file/".$_POST['komponen']."/".$_POST['idd']."");}
		echo "sukses#"."add#";
	}

	function formfoto(){
		$data['isi'] = Modules::run("cmshome/detailkonten",$_POST['idd']);
		$data['foto'] = Modules::run("cmshome/fotokonten",$_POST['idd']);
		$data['nomax']=count($data['foto'])+1;
		$this->load->view('formfoto',$data);
	}

	function saveupload(){
		if(strlen($_FILES['artikel_file']['name'])>0){
				$id_konten = $_POST['id_konten'];
				$komponen = $_POST['komponen'];
				$nama_file = str_replace(" ","_",$_FILES['artikel_file']['name']);
				$result = $this->uploadFile($id_konten,$_FILES['artikel_file'],$nama_file,$komponen);

				$config['image_library'] = 'gd2';
				$config['width'] = 250;
				$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				//$config['thumb_marker']='';
				$config['source_image'] = 'assets/media/file/'.$komponen.'/'.$id_konten.'/'.$nama_file;
				$config['new_image'] = 'assets/media/file/'.$komponen.'/'.$id_konten.'/thumbs_'.$nama_file;
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

	function uploadFile($id_konten,$file,$nama_file,$komponen){
		$this->load->helper('file');
			$path="assets/media/file/".$komponen."/".$id_konten."/";
			if(!file_exists($path)){	mkdir($path,755);	}
		
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
			$this->m_artikel->simpan_foto($id_konten,$nama_file,$komponen);
		}

	}

	function edit_info(){
	$data['idd']=$_POST['idd'];
	$jml=count($this->input->post('judul_foto')); 
		for($i=0;$i<$jml;$i++){
			$nomor=	$_POST['urutan'][$i];
				$this->form_validation->set_rules("judul_foto[$i]","Jenis Spesimen No.$nomor","trim|required|xss_clean");
				$this->form_validation->set_rules("ket_foto[$i]","Jumlah/Volume No.$nomor","trim|required|xss_clean");
				$this->form_validation->set_rules("fotografer[$i]","Negara/Institusi Tujuan No.$nomor","trim|required|xss_clean");
				$this->form_validation->set_rules("foto_from[$i]","Jenis Pemeriksaan No.$nomor","trim|required|xss_clean");
		}	
		if($this->form_validation->run()) {
			$this->m_artikel->edit_info_aksi($_POST);
			echo "sukses#"."add#";
		}
	}

	function savestatus(){
		$id = $this->input->post("id_konten");
		if(!empty($id)):
			$this->db->select('*');
			$this->db->from('artikel');
			$this->db->where('id_konten',$id);
			$row = $this->db->get()->row_array();
			if(!empty($row)){
				if($row['status']== 'pending'):
					$status = 'publish';
				else:
					$status = 'pending';
				endif;
				$this->db->set("status",$status);
				$this->db->where("id_konten",$id);
				$this->db->update("artikel");
				echo "sukses";
			}else{
				echo "error";
			}
		else:
			echo "error";
		endif;
	}
	function custom_kategori(){
//		echo "<tr><td colspan=4>Artikel</td></tr>";
		echo "";
	}
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
	function penulis(){
		$data['jform']="Pengaturan Penulis";
		$this->load->view('penulis',$data);
	}

	function getpenulis(){
		$batas=$_POST['batas'];
		$dt=$this->m_artikel->hitung_penulis(); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_artikel->getpenulis($mulai,$batas)->result();

		$de = Modules::run("cmsuser/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}
	function formpenulistambah(){
		$this->load->view('formtambah_penulis');
	}
	function formpenulisedit(){
		$data['id_penulis']=$_POST['idd'];
		$data['hslquery']=$this->m_artikel->ini_penulis($data['id_penulis'])->result();
		$this->load->view('formedit_penulis',$data);
	}
	function savepenulis(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules("nama_penulis","Nama Penulis","trim|required|xss_clean");
		if($this->form_validation->run()) {
						if($this->input->post('id_penulis') == "xx"):
							$this->m_artikel->tambah_penulis_aksi($_POST);
						else:	
							$this->m_artikel->edit_penulis_aksi($_POST);
						endif;
						echo "sukses#kjkj";
		 }else{
			echo "error-".validation_errors()."#0";	
		 }
	}
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
	function komentar(){
		$data['jform']="Pengaturan Komentar";
		$this->load->view('komentar',$data);
	}
	function getkomentar(){
		$batas=$_POST['batas'];
		$dt=$this->m_artikel->hitung_komentar(); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		$data['hslquery']=$this->m_artikel->getkomentar($mulai,$batas)->result();

		$de = Modules::run("cmsuser/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
	function formslider(){
	$data['idd']=$_POST['idd'];
	$data['isi'] = Modules::run("web/detailkonten",$_POST['idd']);
	$data['foto']=$this->m_artikel->slider_artikel($data['idd'])->result(); 
	$data['nomax']=count($data['foto'])+1;
		$this->load->view('formslider',$data);
	}
	function saveuploadslider(){
		if(strlen($_FILES['artikel_file']['name'])>0){
				$id_kategori = $_POST['id_kategori'];
				$nama_file = str_replace(" ","_",$_FILES['artikel_file']['name']);
				$result = $this->uploadFileSlider($id_kategori,$_FILES['artikel_file'],$nama_file);

				$config['image_library'] = 'gd2';
				$config['width'] = 250;
				$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				//$config['thumb_marker']='';
				$config['source_image'] = 'assets/media/file/slider/'.$id_kategori.'/'.$nama_file;
				$config['new_image'] = 'assets/media/file/slider/'.$id_kategori.'/thumbs_'.$nama_file;
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

	function uploadFileSlider($id_kategori,$file,$nama_file){
		$this->load->helper('file');
			$path="assets/media/file/slider/".$id_kategori."/";
			if(!file_exists($path)){	mkdir($path,755);	}
		
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
			$this->m_artikel->simpan_slider($id_kategori,$nama_file);
		}

	}
	function hapus_slider_aksi(){
		$dfoto=$this->m_artikel->hapus_slider_aksi($_POST)->result(); 
		$foto=$dfoto[0]->file_slider;
		$thumb=$dfoto[0]->file_thumb;
		unlink("assets/media/file/slider/".$_POST['idd']."/$foto");
		unlink("assets/media/file/slider/".$_POST['idd']."/$thumb");
		rmdir("assets/media/file/slider/".$_POST['idd']."");
		echo "sukses#"."add#";
	}
	function edit_slider(){
			echo "sukses#"."add#";
	}


}
?>