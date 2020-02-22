
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Peraturan_gaji extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('apppenggajian/m_peraturan_gaji');
		date_default_timezone_set('UTC');
	}


	function index(){
		$data['satu'] = "Master Peraturan Gaji";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"";
		$this->load->view('peraturan_gaji/index',$data);
	}
	function getdata(){
		$tipe = $_POST['tipe'];	
		// $data['judul'] = $judul[$tipe];

		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$data['count'] = $this->m_peraturan_gaji->hitung_peraturan_gaji($cari,$tipe);
	
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_peraturan_gaji->get_peraturan_gaji($cari,$mulai,$batas,$tipe);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_peraturan_gaji->ini_peraturan_gaji($data['idd']);
		$this->load->view('peraturan_gaji/formedit',$data);
	}
	function edit_aksi(){
        $this->form_validation->set_rules("peraturan_gaji","Peraturan Gaji","trim|required|xss_clean");
        $this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_peraturan_gaji->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah(){
		$data['tipe'] = $_POST['tipe'];
		$this->load->view('peraturan_gaji/formtambah',$data);
	}
	function tambah_aksi(){
		print "<pre>";
		print_r($_FILES);
		print "</pre>"; 
		$file = $_FILES["file"]["name"];
 		$this->form_validation->set_rules("peraturan_gaji","Peraturan Gaji","trim|required|xss_clean");
        $this->form_validation->set_rules("tahun","Tahun","trim|required|xss_clean");
		if($this->form_validation->run()) {
		
			$ddir=$this->m_peraturan_gaji->tambah_aksi($_POST,$file); 
		// $isi = $_POST;
		// $this->db->set('peraturan_gaji',$isi['peraturan_gaji']);
		// $this->db->set('tahun',$isi['tahun']);
		// $this->db->set('status',$isi['optradio']); 
		// $this->db->set('file',$_FILES["file"]["name"]);
		// $this->db->insert('m_peraturan_gaji');
		
		
		$config['upload_path'] = './assets/file/pdf/';
		$config['allowed_types'] = 'pdf';
    
		$this->load->library('upload', $config);
    
		$field_name = "file";
			
			if ( ! $this->upload->do_upload($field_name))
			{
		  $result = array('reload'=>false,'message' =>'<div class="alert alert-danger pull-right" role="alert"><i class="fa fa-thumbs-o-up"></i> '.str_replace(array('<p>','</p>'),'',$this->upload->display_errors()).'</div>');
				echo json_encode($result);
			}
			else
			{
				// $this->load->view('peraturan_gaji/index/batal','');
				// $data = $this->upload->data();
		  
			  // $this->db->set('file',$data['file_name']);
			  // $this->db->where('id_peraturan_gaji',$id_peraturan_gaji);
			  // $this->db->update('m_peraturan_gaji');
		  
				// echo 'success';
			}
			$data['satu'] = "Master Peraturan Gaji";
		$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
		$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
		$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
		$data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"";
		$this->load->view('peraturan_gaji/index',$data);
			// echo '<script type="text/javascript">
			// $("#content-wrapper").show();
			// $("#form-wrapper").hide();
			// </script>';
		
			// $ddir=$this->m_peraturan_gaji->tambah_aksi($_POST,$_FILES); 
			// echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapus(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_peraturan_gaji->ini_peraturan_gaji($data['idd']);
		$this->load->view('peraturan_gaji/formhapus',$data);
	}
	function hapus_aksi(){
			$ddir=$this->m_peraturan_gaji->hapus_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>

