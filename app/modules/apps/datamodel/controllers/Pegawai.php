<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pegawai extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('pegawai__model');
	}
	function get_pegawai($id_pegawai=false){
		$result = $this->pegawai__model->get_pegawai($id_pegawai);
		return $result;
	}
  
  /* biodata pegawai */
	function get_peg_biodata($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_biodata($id_pegawai);
		return $result;
	}
	function set_peg_biodata($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_biodata($id_pegawai,$data);
		return $result;
	}
  
  /* foto pegawai */
	function get_peg_fotopath($id_pegawai=false){
		$foto = $this->pegawai__model->get_peg_foto($id_pegawai);
		return $foto->fileFoto;
	}
	function get_peg_fotosrc($id_pegawai=false){
		$foto = $this->pegawai__model->get_peg_foto($id_pegawai);
		return $foto->srcFoto;
	}
  
  /* alamat pegawai */
	function get_peg_alamat($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_alamat($id_pegawai);
		return $result;
	}
	function set_peg_alamat($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_alamat($id_pegawai,$data);
		return $result;
	}
  /* ----------------------------------------- */
  
  /* Pernikahan pegawai */
	function get_riwayat_perkawinan($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_perkawinan($id_pegawai);
		return $result;
	}
	function get_peg_perkawinan($id_peg_perkawinan=false)
	{
		$result = $this->pegawai__model->get_peg_perkawinan($id_peg_perkawinan);
		return $result;
	}
	function get_peg_perkawinan_tunjangan($id_peg_perkawinan_tunjangan=false)
	{
		$result = $this->pegawai__model->get_peg_perkawinan_tunjangan($id_peg_perkawinan_tunjangan);
		return $result;
	}
	function set_peg_perkawinan($id_pegawai=false,$id_peg_perkawinan=false,$data=array()){
		$result = $this->pegawai__model->set_peg_perkawinan($id_pegawai,$id_peg_perkawinan,$data);
		return $result;
	}
	function set_peg_perkawinan_tunjangan($id=false,$data=array()){
		$result = $this->pegawai__model->set_peg_perkawinan_tunjangan($id,$data);
		return $result;
	}
	function del_peg_perkawinan($id_peg_perkawinan=false){
		$result = $this->pegawai__model->del_peg_perkawinan($id_peg_perkawinan);
		return $result;
	}
  /* ----------------------------------------- */
  
  /* Anak pegawai */
	function get_riwayat_anak($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_anak($id_pegawai);
		return $result;
	}
	function get_peg_anak($id_peg_anak=false)
	{
		$result = $this->pegawai__model->get_peg_anak($id_peg_anak);
		return $result;
	}
	function set_peg_anak($id_pegawai=false,$id_peg_anak=false,$data=array()){
		$result = $this->pegawai__model->set_peg_anak($id_pegawai,$id_peg_anak,$data);
		return $result;
	}
	function del_peg_anak($id_peg_anak=false){
		$result = $this->pegawai__model->del_peg_anak($id_peg_anak);
		return $result;
	}
  /* ----------------------------------------- */
  
  /* Orangtua pegawai */
	function get_riwayat_orangtua($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_orangtua($id_pegawai);
		return $result;
	}
	function get_peg_orangtua($id_peg_orangtua=false)
	{
		$result = $this->pegawai__model->get_peg_orangtua($id_peg_orangtua);
		return $result;
	}
	function set_peg_orangtua($id_pegawai=false,$id_peg_orangtua=false,$data=array()){
		$result = $this->pegawai__model->set_peg_orangtua($id_pegawai,$id_peg_orangtua,$data);
		return $result;
	}
	function del_peg_orangtua($id_peg_orangtua=false){
		$result = $this->pegawai__model->del_peg_orangtua($id_peg_orangtua);
		return $result;
	}
  /* ----------------------------------------- */

  /* Pendidikan pegawai */
	function get_riwayat_pend($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_pend($id_pegawai);
		return $result;
	}
	function get_riwayat_pend_lama($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_pend_lama($id_pegawai);
		return $result;
	}
	function get_peg_pend($id_peg_pend=false)
	{
		$result = $this->pegawai__model->get_peg_pend($id_peg_pend);
		return $result;
	}
	function set_peg_pend($id_pegawai=false,$id_peg_pend=false,$data=array()){
		$result = $this->pegawai__model->set_peg_pend($id_pegawai,$id_peg_pend,$data);
		return $result;
	}
	function del_peg_pend($id_peg_pend=false){
		$result = $this->pegawai__model->del_peg_pend($id_peg_pend);
		return $result;
	}
  /* ----------------------------------------- */

  /* CPNS pegawai */
	function get_peg_cpns($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_cpns($id_pegawai);
		return $result;
	}
	function set_peg_cpns($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_cpns($id_pegawai,$data);
		return $result;
	}
  /* ----------------------------------------- */
  
  /* PNS pegawai */
	function get_peg_pns($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_pns($id_pegawai);
		return $result;
	}
	function set_peg_pns($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_pns($id_pegawai,$data);
		return $result;
	}
  /* ----------------------------------------- */
    /* ----------------------------------------- */
  
  /* KONTRAK pegawai */
	function get_peg_kontrak($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_kontrak($id_pegawai);
		return $result;
	}
	function set_peg_kontrak($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_kontrak($id_pegawai,$data);
		return $result;
	}
  /* ----------------------------------------- */
   /* CAPEG pegawai */
	function get_peg_capeg($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_capeg($id_pegawai);
		return $result;
	}
	function set_peg_capeg($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_capeg($id_pegawai,$data);
		return $result;
	}
  /* ----------------------------------------- */
   /* tetap pegawai */
	function get_peg_tetap($id_pegawai=false){
		$result = $this->pegawai__model->get_peg_tetap($id_pegawai);
		return $result;
	}
	function set_peg_tetap($id_pegawai=false,$data=array()){
		$result = $this->pegawai__model->set_peg_tetap($id_pegawai,$data);
		return $result;
	}
  /* ----------------------------------------- */
  /* Kepangkatan pegawai */
	function get_riwayat_pangkat($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_pangkat($id_pegawai);
		return $result;
	}
	function get_riwayat_pangkat_lama($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_pangkat_lama($id_pegawai);
		return $result;
	}
	
	function get_riwayat_diklat($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_diklat($id_pegawai);
		return $result;
	}
	// function get_riwayat_pangkat_lama($id_pegawai=false){
		// $result = $this->pegawai__model->get_riwayat_pangkat_lama($id_pegawai);
		// return $result;
	// }
	function get_peg_pkt($id=false){
		$result = $this->pegawai__model->get_peg_pkt($id);
		return $result;
	}
	function set_peg_pkt($id_pegawai=false,$id=false,$data=array()){
		$result = $this->pegawai__model->set_peg_pkt($id_pegawai,$id,$data);
		return $result;
	}
	function del_peg_pkt($id=false){
		$result = $this->pegawai__model->del_peg_pkt($id);
		return $result;
	}
  /* ----------------------------------------- */
   // diklat
  // function get_riwayat_diklat($id_pegawai=false){
		// $result = $this->pegawai__model->get_riwayat_diklat($id_pegawai);
		// return $result;
	// }  
  // pengalaman
  function get_riwayat_pengalaman($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_pengalaman($id_pegawai);
		return $result;
	}  
  // psikotes
  function get_riwayat_psikotes($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_psikotes($id_pegawai);
		return $result;
	}  
 // kesehatan
  function get_riwayat_kesehatan($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_kesehatan($id_pegawai);
		return $result;
	}  
  // penghargaan
  function get_riwayat_penghargaan($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_penghargaan($id_pegawai);
		return $result;
	}
  // sanksi
  function get_riwayat_sanksi($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_sanksi($id_pegawai);
		return $result;
	}
  /* Jabatan pegawai */
	function get_riwayat_jabatan($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_jabatan($id_pegawai);
		return $result;
	}
	function get_peg_jabatan($id_peg_jab=false){
		$result = $this->pegawai__model->get_peg_jabatan($id_peg_jab);
		return $result;
	}
	function set_peg_jabatan($id_pegawai=false,$id_peg_jab=false,$data=array())
	{
		$result = $this->pegawai__model->set_peg_jabatan($id_pegawai,$id_peg_jab,$data);
		return $result;
	}
	function del_peg_jabatan($id_peg_jab=false){
		$result = $this->pegawai__model->del_peg_jabatan($id_peg_jab);
		return $result;
	}
  /* ----------------------------------------- */



  /* Kediklatan pegawai */
	function get_riwayat_diklat_struk($id_pegawai=false){
		$result = $this->pegawai__model->get_riwayat_diklat_struk($id_pegawai);
		return $result;
	}
  /* ----------------------------------------- */
}
?>