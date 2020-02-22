<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmsgaleri extends MX_Controller {
	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_galeri');
	}
	
	function index(){
		$data['jform']="Pengaturan Berita Foto";
		$data['rubrik_options'] = Modules::run("cmshome/kategori_options","","galeri");
		$this->load->view('index',$data);
	}
	function formtambah(){
		$data = array( 'judul'=> 'Wajib diisi','tgl_buat'=> 'Wajib diisi', 'keterangan'=> 'Wajib diisi');

		if($_POST['rubrik']=="xx"){
				$vv = "\n<select id='id_kategori' name='id_kategori' class=\"ipt_text\" style=\"width:200px;\">\n<option value=''>-- Pilih --</option>\n";
				$vv = $vv.Modules::run("cmshome/kategori_options","","galeri");
				$vv = $vv."</select>\n";
		} else {
				$dt = Modules::run("cmshome/detailrubrik",$_POST['rubrik']);
				$vv="<input type=hidden id='id_kategori' name='id_kategori' value='".@$dt[0]->id_kategori."'>";
				$vv=$vv."<b>".@$dt[0]->nama_kategori."</b>";
		}
		$data['pilrb']=$vv;

		$this->load->view('formtambah',$data);
	}
	function tambah_aksi(){
 		$this->form_validation->set_rules("judul","Judul Berita Foto","trim|required|xss_clean");
        $this->form_validation->set_rules("id_kategori","Rubrik Berita Foto","trim|required|xss_clean");
 		$this->form_validation->set_rules("tgl_buat","Tanggal Berita Foto","trim|required|xss_clean");
 		$this->form_validation->set_rules("keterangan","Keterangan","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_galeri->tambah_galeri_aksi($_POST)->id_konten; 
					$path="assets/media/file/galeri/".$ddir;
					mkdir($path,'755');
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formedit(){
		$data['isi'] = Modules::run("cmshome/detailkonten",$_POST['idd']);
				$vv = "\n<select id='id_kategori' name='id_kategori' class=\"ipt_text\" style=\"width:200px;\">\n<option value=''>-- Pilih --</option>\n";
				$vv = $vv.Modules::run("cmshome/kategori_options",@$data['isi'][0]->id_kategori,"galeri");
				$vv = $vv."</select>\n";
		$data['pilrb']=$vv;
		$this->load->view('formedit',$data);
	}
	function edit_aksi(){
 		$this->form_validation->set_rules("idd","IDD","trim|required|xss_clean");
 		$this->form_validation->set_rules("judul","Judul Berita Foto","trim|required|xss_clean");
        $this->form_validation->set_rules("id_kategori","Rubrik Berita Foto","trim|required|xss_clean");
 		$this->form_validation->set_rules("tgl_buat","Tanggal Berita Foto","trim|required|xss_clean");
 		$this->form_validation->set_rules("keterangan","Keterangan","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_galeri->edit_galeri_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formhapus(){
		$data['isi'] = Modules::run("cmshome/detailkonten",$_POST['idd']);
		$this->load->view('formhapus',$data);
	}

	function hapus_aksi(){
			$path="assets/media/file/galeri/".$_POST['idd'];
			rmdir($path);
		$this->m_galeri->hapus_galeri_aksi($_POST['idd']);
		echo "sukses#"."add#";
	}
////////////////////////////////////////////////////////////////////////////////
	function custom_kategori(){
//		echo "<tr><td colspan=4>Artikel</td></tr>";
		echo "";
	}
////////////////////////////////////////////////////////////////////////////////
////// WIDGET -> Untuk Form Artikel
	function getWIKategori($path){	
		$rs = Modules::run("cmshome/getkonten",0,10000,$path,"galeri")->result();
	
		$list_kategori = '<ul>';
		foreach($rs as $row): 		
			$id_konten   = @$row->id_konten;												
			$rf = Modules::run("cmshome/fotokonten",$id_konten);
			$id_foto   = @$rf[0]->id_foto;												
			$img_thumb = "assets/media/file/galeri/".$id_konten."/".@$rf[0]->foto_thumbs;
			$img_thumb = '<img src="'.$img_thumb.'" title="" alt="'.@$rf[0]->ket_foto.'" >';	
			$judul_foto = @$rf[0]->judul_foto;			
			$list_kategori .= '<li><a href="javascript:void(0);" onclick="getWIImageDetails('.$id_konten.');">'.$img_thumb.' <br> '.$judul_foto.' </a></li>';
		endforeach;
		$list_kategori .= '</ul>';
		echo $list_kategori;
	}		

	function getWIImageDetails($id_cat){		
		$content['list_foto'] = "<ul>";
		$res = Modules::run("cmshome/fotokonten",$id_cat);
		foreach($res as $row){
			$path = base_url().'assets/media/file/galeri/'.$row->id_konten.'/'.$row->foto;
			if(is_file($path)):
				$path = base_url().'assets/media/file/galeri/'.$row->id_konten.'/'.$row->foto;
				$path_foto_thumbs = base_url().'assets/media/file/galeri/'.$row->id_konten.'/'.$row->foto_thumbs;
			else:
				$path = '';
				$path_foto_thumbs = base_url().'assets/media/file/galeri/'.$row->id_konten.'/'.$row->foto_thumbs;
			endif;					
			$content['list_foto'] .= '<li><img src="'.$path_foto_thumbs.'" title="'.$row->judul_foto.'" alt="'.$row->ket_foto.'" width="103"></li>';
		}		
		$content['list_foto'] .= '</ul>';
		echo $content['list_foto'];
	}		


}
?>