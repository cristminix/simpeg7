<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Upload_file extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('apppenggajian/m_tunjangan_kelompok');
		date_default_timezone_set('UTC');
	}


	function index(){
		$allowedExts = array("pdf", "doc");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if (($_FILES["file"]["type"] == "application/pdf")
		|| ($_FILES["file"]["type"] == "application/doc")
		&& ($_FILES["file"]["size"] < 200000)
		&& in_array($extension, $allowedExts))
		{
		if ($_FILES["file"]["error"] > 0)
		{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{
		echo "Upload: " . $_FILES["file"]["name"] . "<br>";
		echo "Type: " . $_FILES["file"]["type"] . "<br>";
		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

		if (file_exists("upload/" . $_FILES["file"]["name"]))
		  {
		  echo $_FILES["file"]["name"] . " already exists. ";
		  }
		else
		  {
		  move_uploaded_file($_FILES["file"]["tmp_name"],
		  "upload/" . $_FILES["file"]["name"]);
		echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
		  }
		}
		}
		else
		{
		echo "Invalid file";
		}
	}
	function getdata(){
		$tipe = $_POST['tipe'];	
		// $data['judul'] = $judul[$tipe];

		$kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
		$cari = $_POST['cari'];
		$data['count'] = $this->m_tunjangan_kelompok->hitung_tunjangan_kelompok($cari,$tipe);
	
		if($data['count']==0){
			$data['hslquery']="";
			$data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
		} else {
			$batas=$_POST['batas'];
			$hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['hslquery'] = $this->m_tunjangan_kelompok->get_tunjangan_kelompok($cari,$mulai,$batas,$tipe);
			$data['pager'] = Modules::run("appskp/appskp/pagerB",$data['count'],$batas,$hal,$kehal);
		}
		echo json_encode($data);
	}
	function formedit(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_tunjangan_kelompok->ini_tunjangan_kelompok($data['idd']);
		$this->load->view('tunjangan_kelompok/formedit',$data);
	}
	function edit_aksi(){
        $this->form_validation->set_rules("tunjangan_kelompok","Masa Kerja","trim|required|xss_clean");
        if($this->form_validation->run()) {
			$ddir=$this->m_tunjangan_kelompok->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formtambah(){
		$data['tipe'] = $_POST['tipe'];
		$this->load->view('tunjangan_kelompok/formtambah',$data);
	}
	function tambah_aksi(){
        $this->form_validation->set_rules("tunjangan_kelompok","Masa Kerja","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_tunjangan_kelompok->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapus(){
		$data['idd']=$_POST['idd'];
		$data['unit'] = $this->m_tunjangan_kelompok->ini_tunjangan_kelompok($data['idd']);
		$this->load->view('tunjangan_kelompok/formhapus',$data);
	}
	
	function hapus_aksi(){
			$ddir=$this->m_tunjangan_kelompok->hapus_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>

