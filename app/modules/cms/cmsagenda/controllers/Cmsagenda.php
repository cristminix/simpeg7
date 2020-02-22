<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmsagenda extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_agenda');
	}
	
	function index(){
		$data['jform']="Pengaturan Agenda";
		$data['rubrik_options'] = Modules::run("cmshome/kategori_options","","agenda");
		$this->load->view('index',$data);
	}

	function formtambah(){
		$data = array( 'tema'=> 'Wajib diisi','tgl_mulai'=> 'Wajib diisi','tgl_selesai'=> 'Wajib diisi', 'tempat'=> 'Wajib diisi', 'isi_agenda'=> 'Wajib diisi');
		if($_POST['rubrik']=="xx"){
				$vv = "\n<select id='id_kategori' name='id_kategori' class=\"ipt_text\" style=\"width:200px;\">\n<option value=''>-- Pilih --</option>\n";
				$vv = $vv.Modules::run("cmshome/kategori_options","","agenda");
				$vv = $vv."</select>\n";

		} else {
				$dt = Modules::run("cmshome/detailrubrik",$_POST['rubrik']);
				$vv="<input type=hidden id='id_kategori' name='id_kategori' value='".$dt[0]->id_kategori."'>";
				$vv=$vv."<b>".$dt[0]->nama_kategori."</b>";
		}
		$data['pilrb']=$vv;
		$this->load->view('formtambah',$data);
	}
	function tambah_aksi(){
 		$this->form_validation->set_rules("tema","Judul Agenda","trim|required|xss_clean");
        $this->form_validation->set_rules("id_kategori","Rubrik Agenda","trim|required|xss_clean");
 		$this->form_validation->set_rules("tempat","Tempat","trim|required|xss_clean");
 		$this->form_validation->set_rules("tgl_mulai","Tanggal Mulai","trim|required|xss_clean");
 		$this->form_validation->set_rules("tgl_selesai","Tanggal Selesai","trim|required|xss_clean");
 		$this->form_validation->set_rules("isi_agenda","Isi Agenda","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_agenda->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function formedit(){
		$data['isi'] = Modules::run("cmshome/detailkonten",$_POST['idd']);
		$data['pilrb']=Modules::run("cmshome/kategori_options",@$data['isi'][0]->id_kategori,"agenda");
		$this->load->view('formedit',$data);
	}
	function edit_aksi(){
 		$this->form_validation->set_rules("judul","Judul Agenda","trim|required|xss_clean");
        $this->form_validation->set_rules("id_kategori","Rubrik Agenda","trim|required|xss_clean");
 		$this->form_validation->set_rules("sub_judul","Tempat","trim|required|xss_clean");
 		$this->form_validation->set_rules("tgl_mulai","Tanggal Mulai","trim|required|xss_clean");
 		$this->form_validation->set_rules("tgl_selesai","Tanggal Selesai","trim|required|xss_clean");
 		$this->form_validation->set_rules("isi_artikel","Isi Agenda","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_agenda->edit_aksi($_POST); 
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
		$idd=$_POST['idd'];
		$this->m_agenda->hapus_aksi($idd);
		echo "sukses#"."add#";
	}
////////////////////////////////////////////////////////////////////////////////
	function custom_kategori(){
//		echo "<tr><td colspan=4>Artikel</td></tr>";
		echo "";
	}

}
?>