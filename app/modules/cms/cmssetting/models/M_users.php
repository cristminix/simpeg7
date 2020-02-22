<?php
class M_users extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
  public function get_data() 
  {
		$nama_pegawai_lengkap = "CONCAT(if(trim(REPLACE(gelar_depan,'-','')) <> '', concat(trim(REPLACE(gelar_depan,'-','')),' '),''),if(trim(REPLACE(gelar_nonakademis,'-','')) <> '', concat(trim(REPLACE(gelar_nonakademis,'-','')),' '),''),nama_pegawai,if(trim(REPLACE(gelar_belakang,'-','')) <> '', concat(', ',trim(REPLACE(gelar_belakang,'-',''))),'')) AS nama_pegawai";
		$penilai_nama_pegawai_lengkap = "CONCAT(if(trim(REPLACE(penilai_gelar_depan,'-','')) <> '', concat(trim(REPLACE(penilai_gelar_depan,'-','')),' '),''),if(trim(REPLACE(penilai_gelar_nonakademis,'-','')) <> '', concat(trim(REPLACE(penilai_gelar_nonakademis,'-','')),' '),''),penilai_nama_pegawai,if(trim(REPLACE(penilai_gelar_belakang,'-','')) <> '', concat(', ',trim(REPLACE(penilai_gelar_belakang,'-',''))),'')) AS penilai_nama_pegawai";
		$this->load->library('datatables');
		$this->datatables
    ->select('id_pegawai')
    ->select('tahun,bulan_mulai,bulan_selesai')
    ->select('nip_baru')
    ->select($nama_pegawai_lengkap,false)
    ->select('nama_pangkat,nama_golongan')
    ->select('nomenklatur_jabatan')
    ->select('nomenklatur_pada')
    ->select('penilai_nip_baru,penilai_nama_pangkat,penilai_nomenklatur_jabatan')
    ->select($penilai_nama_pegawai_lengkap,false)
    ->select('penilai_nama_golongan')
    ->from('p_skp');
        
      $result = $this->datatables->generate();
      return $result;
  }


}
