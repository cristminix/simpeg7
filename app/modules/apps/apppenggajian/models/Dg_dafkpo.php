<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
class Dg_dafkpo extends CI_Model 
{

  public function __construct() 
  {
      parent::__construct();
  }

  public function get_data() 
  {
     $this->load->library('datatables');
     $this->datatables
    ->select('id_pegawai')
    ->select('nip_baru,nama_pegawai,tempat_lahir')
    ->select("DATE_FORMAT(tanggal_lahir,'%d-%m-%Y') AS tanggal_lahir",false)
    ->select('nama_pangkat,nama_golongan')
    ->select("DATE_FORMAT(tmt_pangkat,'%d-%m-%Y') AS tmt_pangkat",false)
    ->select('nomenklatur_jabatan')
    ->select("DATE_FORMAT(tmt_jabatan,'%d-%m-%Y') AS tmt_jabatan",false)
    ->select('nomenklatur_pada')
    ->where("TIMESTAMPDIFF(YEAR, tmt_pangkat, '2015-04-01') > 4",'',false)
    ->where("jab_type !=",'jft')
    ->where("jab_type !=",'guru')
    ->from('rekap_peg');
        
      $result = $this->datatables->generate();
      return $result;
  }
}
