<?php
class M_user extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

	function psetting($nama="Kanal"){
		$sqlstr="SELECT a.* FROM p_setting a WHERE a.nama_setting='$nama'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function psetting_atr($nama){
		$sqlstr="SELECT a.* FROM p_setting_atribut a WHERE a.id_setting='$nama'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
	function getuser($mulai,$batas,$path){
		if($path=="xx"){$and1="";}else{$and1=" WHERE a.group_id='$path'";}
		$sqlstr="SELECT a.*,b.nama_item AS group_name FROM users a LEFT JOIN (p_setting_item b) ON (a.group_id=b.id_item) $and1 ORDER BY b.id_item ASC,a.user_id ASC  LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function getuseradmin($mulai,$batas,$path){
		if($path=="xx"){$and1="";}else{$and1=" AND a.group_id='$path'";}
		$sqlstr="SELECT a.*,b.group_name FROM users a LEFT JOIN (p_setting_item b) ON (a.group_id=b.id_item) WHERE b.nama_item!='superadmin' $and1 ORDER BY b.id_item ASC,a.user_id ASC  LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function getuserDEMOMULTIGRID($mulai,$batas){
		$sqlstr="SELECT * FROM c_user ORDER BY id_user ASC  LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function hitung_userDEMOMULTIGRID(){
		$query=$this->db->query("SELECT count(id_user) as count_nik FROM c_user"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
    function detail_user($idd){
		$sqlstr="SELECT * FROM users WHERE user_id='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
    function cek_user($idd,$idg){
			if ($idg=="pemohon"){
				$sqlstr="SELECT user_id FROM m_pemohon_user WHERE user_id='$idd'";
				$hslquery=$this->db->query($sqlstr)->result();
			} elseif($idg=="penelaah") {
				$sqlstr="SELECT user_id FROM m_penelaah_tim_user WHERE user_id='$idd'";
				$hslquery=$this->db->query($sqlstr)->result();
			} else {
				$hslquery = "";
			}
		return $hslquery;
	}
    function edit_password_aksi($idg,$ipp){
		$sqlstr="UPDATE users SET user_password='".sha1($ipp)."' WHERE user_id='$idg'";
		$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
    function tambah_user_aksi($ipp){
		$sqlstr="INSERT INTO users (group_id,username,nama_user,passwd) 
		VALUES ('".$ipp['group_id']."','".$ipp['username']."','".$ipp['nama_user']."','".sha1($ipp['username'])."')";		
		$this->db->query($sqlstr);
	}
    function edit_user_aksi($idg,$ipp){
		$sqlstr="UPDATE users SET group_id='".$ipp['group_id']."',username='".$ipp['username']."',nama_user='".$ipp['nama_user']."' WHERE user_id='$idg'";
		$this->db->query($sqlstr);
	}
    function hapus_user_aksi($idg){
		$sqlstr="DELETE FROM users WHERE user_id='$idg'";
		$this->db->query($sqlstr);
	}
	function hitung_user($path){
		if($path=="xx"){$and1="";}else{$and1=" WHERE group_id='$path'";}

		$query=$this->db->query("SELECT count(user_id) as count_nik FROM users $and1"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function hitung_useradmin($path){
		if($path=="xx"){$and1="";}else{$and1=" AND group_id='$path'";}

		$query=$this->db->query("SELECT count(user_id) as count_nik FROM users WHERE group_id!='1' $and1"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
//////////////////////////////////////////////////////////////////////////////////
	function getusergroup(){
		$sqlstr="SELECT id_item AS group_id,nama_item AS group_name,meta_value FROM p_setting_item WHERE id_setting='4' ORDER BY id_item ASC";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function cek_grup($idg){
		$sqlstr="SELECT user_id FROM users WHERE group_id='$idg'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function detail_grup($idg){
		$sqlstr="SELECT * FROM p_setting_item WHERE id_item='$idg'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
    function tambah_grup_aksi($ipp){
		$ini="{\"section_name\":\"".$ipp['nama_section']."\",\"back_office\":\"".$ipp['backoffice']."\",\"keterangan\":\"".$ipp['keterangan']."\"}";

		$sqlstr="INSERT INTO p_setting_item (nama_item,id_setting,meta_value) VALUES ('".$ipp['nama_grup']."','4','$ini')";		
		$this->db->query($sqlstr);
	}
    function edit_grup_aksi($idg,$ipp){
		$ini="{\"section_name\":\"".$ipp['nama_section']."\",\"back_office\":\"".$ipp['backoffice']."\",\"keterangan\":\"".$ipp['keterangan']."\"}";

		$sqlstr="UPDATE p_setting_item SET nama_item='".$ipp['nama_grup']."',meta_value='$ini' WHERE id_item='$idg'";
		$this->db->query($sqlstr);
	}
    function hapus_grup_aksi($idg){
		$sqlstr="DELETE FROM p_setting_item WHERE id_item='$idg'";
		$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
}
