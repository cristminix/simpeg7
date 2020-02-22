<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tupoksi extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_tupoksi');
		// $this->load->model('appskp/dropdowns');
	}	

	function index(){
		$data['satu'] = "Tugas Pokok dan Fungsi";
		$this->load->view('tupoksi/index',$data);
	}

	function pilih_jabatan(){
		$data['jform']="Daftar Unit Organisasi";
		$this->load->view('tupoksi/daftar_jabatan',$data);
	}

	function gettupoksi(){
		$idd = $_POST['id_unor'];
		$jenis = $_POST['jenis'];
		$idj = $_POST['idj'];

		$data['fungsi'] = $this->m_tupoksi->get_tupoksi($idd,'fungsi',$jenis,$idj);
		$data['rincian'] = $this->m_tupoksi->get_tupoksi($idd,'rincian',$jenis,$idj);
		$data['tugas'] = $this->m_tupoksi->get_tupoksi($idd,'tugas',$jenis,$idj);

		echo json_encode($data);
	}

	function detail_unor(){
		$data['idd'] = $_POST['id_unor'];
		$data['hslquery'] = Modules::run("appskp/main/detailunor",$data['idd']);
		$data['jabatan'] = $this->get_jabatan_rekap_peg($data['idd']);

		$this->load->view('tupoksi/detail_unor',$data);
	}

	function get_jabatan_rekap_peg($id_unor){
		$jabatan = $this->m_tupoksi->get_jabatan_rekap_peg($id_unor);
		return $jabatan;
	}

	function get_jab_unor(){
		$ddnon = $this->get_jab_unor_mx($_POST['id_unor'],$_POST['jenis']);
		echo json_encode($ddnon);
	}

	function get_jab_unor_mx($id_unor,$jenis){
		$jab_unor = $this->m_tupoksi->get_jab_unor($id_unor,$jenis);
		return $jab_unor;
	}

	function tambah(){
			$tp['fungsi']="fungsi";
			$tp['tugas']="tugas pokok";
			$tp['rincian']="rincian tugas";
			$jj['js']="jabatan struktural";
			$jj['jfu']="jabatan fungsional umum";
			$jj['jft']="jabatan fungsional tertentu";
			$jj['guru']="guru";

		$data['tipe'] = $tp[$_POST['tipe']];
		$data['tp'] = $_POST['tipe'];
		$data['idd'] = $_POST['idd'];
		$data['idj'] = $_POST['idj'];
		$data['jenis_jabatan'] = $_POST['jenis'];
		$data['jj']=$jj[$_POST['jenis']];

		if($_POST['jenis']=="js"){
			$data['hslquery'] = Modules::run("appskp/main/detailunor",$data['idd']);
		} else {
			$data['hslquery'] = $this->m_tupoksi->get_jab_non_ese($data['idd'],$_POST['idj'],$_POST['jenis']);
		}
		$this->load->view('tupoksi/form_tambah',$data);
	}
	function tambah_aksi(){
 		$this->form_validation->set_rules("isi_tupoksi","TUPOKSI","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_tupoksi->tambah_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function edit(){
			$tp['fungsi']="fungsi";
			$tp['tugas']="tugas pokok";
			$tp['rincian']="rincian tugas";
			$jj['js']="jabatan struktural";
			$jj['jfu']="jabatan fungsional umum";
			$jj['jft']="jabatan fungsional tertentu";
			$jj['guru']="guru";
		$data['tipe'] = $tp[$_POST['tipe']];
		$data['tp'] = $_POST['tipe'];
		$data['idd'] = $_POST['idd'];
		$data['idt'] = $_POST['idt'];
		$data['idj'] = $_POST['idj'];
		$data['jenis_jabatan'] = $_POST['jenis'];
		$data['jj']=$jj[$_POST['jenis']];

		if($_POST['jenis']=="js"){
			$data['hslquery'] = Modules::run("appskp/main/detailunor",$data['idd']);
		} else {
			$data['hslquery'] = $this->m_tupoksi->get_jab_non_ese($data['idd'],$_POST['idj'],$_POST['jenis']);
		}
		$data['detail'] = $this->m_tupoksi->detail_tupoksi($_POST['idt']);
		$this->load->view('tupoksi/form_edit',$data);
	}

	function edit_aksi(){
 		$this->form_validation->set_rules("isi_tupoksi","TUPOKSI","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$ddir=$this->m_tupoksi->edit_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}

	function hapus(){
			$tp['fungsi']="fungsi";
			$tp['tugas']="tugas pokok";
			$tp['rincian']="rincian tugas";
			$jj['js']="jabatan struktural";
			$jj['jfu']="jabatan fungsional umum";
			$jj['jft']="jabatan fungsional tertentu";
			$jj['guru']="guru";
		$data['tipe'] = $tp[$_POST['tipe']];
		$data['tp'] = $_POST['tipe'];
		$data['idd'] = $_POST['idd'];
		$data['idt'] = $_POST['idt'];
		$data['idj'] = $_POST['idj'];
		$data['jenis_jabatan'] = $_POST['jenis'];
		$data['jj']=$jj[$_POST['jenis']];

		if($_POST['jenis']=="js"){
			$data['hslquery'] = Modules::run("appskp/main/detailunor",$data['idd']);
		} else {
			$data['hslquery'] = $this->m_tupoksi->get_jab_non_ese($data['idd'],$_POST['idj'],$_POST['jenis']);
		}
		$data['detail'] = $this->m_tupoksi->detail_tupoksi($_POST['idt']);
		$this->load->view('tupoksi/form_hapus',$data);
	}

	function hapus_aksi(){
			$ddir=$this->m_tupoksi->hapus_aksi($_POST); 
			echo "sukses#"."add#";
	}

}