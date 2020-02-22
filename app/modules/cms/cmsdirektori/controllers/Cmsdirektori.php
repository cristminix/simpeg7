<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmsdirektori extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_direktori');
	}

	function index(){
		$data['jform']="Pengaturan Direktori";
		$data['rubrik_options'] = Modules::run("cmshome/kategori_options","","direktori");
		$this->load->view('index',$data);
	}
	function getdirektori(){
		$batas=$_POST['batas'];
		$rubrik=$_POST['rubrik'];
		$dt=$this->m_direktori->hitung_direktori($rubrik); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;
		if($dt['count']!=0){
			$data['hslquery']=$this->m_direktori->getdirektori($mulai,$batas,$rubrik)->result();
				foreach($data['hslquery'] as $it=>$val){
					$idd=$data['hslquery'][$it]->id_konten;
						$cek = Modules::run("web/fotokonten",$idd);
						if(!empty($cek)){
							$data['hslquery'][$it]->icon_hapus="";
							$data['hslquery'][$it]->cek="ada";
							$data['hslquery'][$it]->thumb=@$cek[0]->foto_thumbs;
						}	else	{
							$data['hslquery'][$it]->icon_hapus="<div class=grid_icon onclick=\"loadForm('cmsdirektori/formhapus','$idd');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
							$data['hslquery'][$it]->cek="kosong";
							$data['hslquery'][$it]->thumb="";
						}
				}
		} else { $data['hslquery']="";}
		$de = Modules::run("cmsuser/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}

	function formtambah(){
		$data = array( 'nama_kategori'=> 'Wajib diisi','nama_direktori'=> 'Wajib diisi');
				$dt=$this->m_direktori->detail_kategori($_POST['rubrik']);
				$vv="<input type=hidden id='id_kategori' name='id_kategori' value='".$dt[0]->id_item."'>";
				$vv=$vv."<b>".$dt[0]->nama_item."</b>";
		$data['pilrb']=$vv;
		$atr = json_decode($dt[0]->meta_value);
		$data['atribut']=$atr->atribut; 
		$this->load->view('formtambah',$data);
	}
	function tambah_aksi(){
			$data['idd']=$_POST['id_kategori'];
			$this->form_validation->set_rules("nama_direktori","Nama Item Direktori","trim|required|xss_clean");
			$jml=count($this->input->post('id_atribut')); 
				for($i=0;$i<$jml;$i++){
						$this->form_validation->set_rules("isi_atribut[$i]","Atribut No.$i","trim|required|xss_clean");
				}	
				if($this->form_validation->run()) {
					$this->m_direktori->tambah_direktori_aksi($_POST);
					echo "sukses#"."add#";
				}
	}
	function formedit(){
	$ini=$this->m_direktori->inidirektori($_POST['idd']);
	$jj = json_decode($ini[0]->isi_artikel);
	$data['ini']=$ini;
				$dt=$this->m_direktori->detail_kategori($_POST['rubrik']);
				$vv="<input type=hidden id='id_kategori' name='id_kategori' value='".$dt[0]->id_item."'>
				<input type=hidden id='id_konten' name='id_konten' value='".$ini[0]->id_konten."'>";
				$vv=$vv."<b>".$dt[0]->nama_item."</b>";
		$data['pilrb']=$vv;
		$atr = json_decode($dt[0]->meta_value);
		foreach($atr->atribut AS $key=>$val){
			@$data['atribut'][$key]->label=$val->label;
			foreach($jj as $kk=>$vv){
				if($val->label==$vv->label){
					@$data['atribut'][$key]->nilai=$vv->nilai;
				} 
			}
		}
		$this->load->view('formedit',$data);
	}
	function edit_aksi(){
			$data['idd']=$_POST['id_kategori'];
			$this->form_validation->set_rules("nama_direktori","Nama Item Direktori","trim|required|xss_clean");
			$jml=count($this->input->post('id_atribut')); 
				for($i=0;$i<$jml;$i++){
						$this->form_validation->set_rules("isi_atribut[$i]","Atribut No.$i","trim|required|xss_clean");
				}	
				if($this->form_validation->run()) {
					$this->m_direktori->edit_direktori_aksi($_POST);
					echo "sukses#"."add#";
				}
	}
	function formhapus(){
	$ini=$this->m_direktori->inidirektori($_POST['idd'])->result();
	$data['ini']=$ini;

				$dt=$this->m_direktori->detail_kategori($_POST['rubrik'])->result();
				$vv="<input type=hidden id='id_kategori' name='id_kategori' value='".$dt[0]->id_kategori."'>
				<input type=hidden id='id_item' name='id_item' value='".$ini[0]->id_item."'>";
				$vv=$vv."<b>".$dt[0]->nama_kategori."</b>";
		$data['pilrb']=$vv;
		$data['atribut']=$this->m_direktori->iniatribut($_POST['rubrik'],@$ini[0]->id_item)->result(); 
		$this->load->view('formhapus',$data);
	}
	function hapus_aksi(){
					$this->m_direktori->hapus_direktori_aksi($_POST);
					echo "sukses#"."add#";
	}
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
	function custom_kategori(){
		if(isset($_POST['idd'])){
			$dt=$this->m_direktori->detail_kategori($_POST['idd']);
			$jj = json_decode($dt[0]->meta_value);
			foreach($jj->atribut AS $key=>$val){
			echo "<tr>";
			echo "<td>Label ".($key+1)."</td>";
			echo "<td colspan=3>";
			echo "<input type='hidden' id='label_lama".($key+1)."' name='labellama[]' value=\"".$val->label."\">";
			echo "<input type='text' id='label_".($key+1)."' name='label[]' value=\"".$val->label."\" class=\"ipt_text\" style=\"width:400px;\">";
			echo "</td>";
			echo "</tr>";
			}
		} else {
			echo "<tr class=\"custom\"><td colspan=4>Honda</td></tr>";
			echo "<tr class=\"custom\"><td colspan=4>Suzuki</td></tr>";
		}
	}
	function reurut_atribut(){
		$this->m_direktori->reurut_atribut_aksi($_POST);
	}

	function hapus_atribut_aksi(){
		$this->m_direktori->hapus_atribut_aksi($_POST);
	}
//////////////////////////////
//////////////////////////////
	function formfoto(){
		$data['isi'] = Modules::run("web/detailkonten",$_POST['idd']);
		$data['foto'] = Modules::run("web/fotokonten",$_POST['idd']);
		$data['nomax']=count($data['foto'])+1;
		$this->load->view('../../cmsartikel/views/formfoto',$data);
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
			$this->m_direktori->edit_info_aksi($_POST);
			echo "sukses#"."add#";
		}
	}

	function reurut_foto(){
			$this->m_direktori->reurut_foto_aksi($_POST);
	}
	function hapus_foto_aksi(){
		$dfoto=$this->m_direktori->hapus_foto_aksi($_POST)->result(); 
		$foto=$dfoto[0]->foto;
		$thumb=$dfoto[0]->foto_thumbs;
		unlink("assets/media/file/direktori/".$_POST['idd']."/$foto");
		unlink("assets/media/file/direktori/".$_POST['idd']."/$thumb");
		$cfoto=$this->m_direktori->foto_direktori($_POST['idd'])->result(); 
		if(empty($cfoto)){rmdir("assets/media/file/direktori/".$_POST['idd']."");}
		echo "sukses#"."add#";
	}
	function saveupload(){
		if(strlen($_FILES['artikel_file']['name'])>0){
				$id_direktori = $_POST['id_direktori'];
				$nama_file = str_replace(" ","_",$_FILES['artikel_file']['name']);
				$result = $this->uploadFile($id_direktori,$_FILES['artikel_file'],$nama_file);

				$config['image_library'] = 'gd2';
				$config['width'] = 250;
				$config['height'] = 150;
				$config['create_thumb'] = FALSE;
				$config['maintain_ratio'] = TRUE;
				//$config['thumb_marker']='';
				$config['source_image'] = 'assets/media/file/direktori/'.$id_direktori.'/'.$nama_file;
				$config['new_image'] = 'assets/media/file/direktori/'.$id_direktori.'/thumbs_'.$nama_file;
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

	function uploadFile($id_direktori,$file,$nama_file){
		$this->load->helper('file');
			$path="assets/media/file/direktori/".$id_direktori."/";
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
			$this->m_direktori->simpan_foto($id_direktori,$nama_file);
		}

	}

















}
?>