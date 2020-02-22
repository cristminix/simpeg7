<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Apppenggajian extends MX_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->module_name = "apppenggajian";
	}
	
	// SUB FRONT CONTROLLER
	public function index(){

		$segments 			= array_values($this->uri->segment_array());
		$real_segments_tmp 	= array_diff($segments,array("admin","module",$this->module_name) );
		$real_segments 		= array_values($real_segments_tmp);

		$method = $real_segments[0];
		$params = array_values(array_diff($real_segments, array($method)));

		foreach ($params as $index => $p) 
		{
			$params[$index] = "'$p'";
		}

		if(method_exists($this, $method))
		{
			// EVAL
			$eval_fn = 'call_user_func(array($this,$method),'.implode(',',$params).');';

			eval( $eval_fn );
		}
		else
		{
			// redirect to admin
			echo "Method doesnt exists";
		}

	}

	/*----------------------------------------------------------------------------------------*/
	/*---------- START MODULE METHOD ------------------------------*/

	public function pegawai($cmd = 'index', $param = 'aktif' )
	{
		$this->load->model('appbkpp/m_pegawai');
		$this->load->model('appbkpp/m_unor');


		switch ($cmd) {
			case 'index':
				$rd = $param;
				//////////////////////////////////////////////////////////////
				$data['unor'] = $this->m_unor->gettree(0,5,"2015-01-01"); 
				$data['pkt'] = $this->dropdowns->kode_golongan_pangkat();
				$data['jbt'] = $this->dropdowns->jenis_jabatan();
				// $data['ese'] = $this->dropdowns->kode_ese();
				// $data['tugas'] = $this->dropdowns->tugas_tambahan();
				$data['agama'] = $this->dropdowns->agama();
				$data['status_pegawai'] = $this->dropdowns->status_pegawai();
				$data['kelompok_pegawai'] = $this->dropdowns->kelompok_pegawai();
				$data['status'] = $this->dropdowns->status_perkawinan();
				$data['jenjang'] = $this->dropdowns->kode_jenjang_pendidikan();

				$data['satu'] = "Daftar Pegawai";
				$data['dua'] = $this->session->userdata('nama_unor');
				$data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
				$data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
				$data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
				$this->load->view('pegawai/'.$rd,$data);
				//////////////////////////////////////////////////////////////
				break;
			
			default:
				# code...
				break;
		}
	}
}