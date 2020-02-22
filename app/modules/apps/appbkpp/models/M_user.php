<?php
class M_user extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function ini_user($idd){
		$this->db->from('users');
		$this->db->where('user_id',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_user($cari,$tipe){
		// if ($tipe=="all"){
			// $cekTipe="";
		// }else{
			// $cekTipe=" AND group='$tipe' ";
		// }
		
		// echo($tipe);
			if($tipe=="all"){	
				$cekTipe = "";	
			} else{
				$cekTipe = " AND `group`='$tipe' ";	
			}
		
		$sqlstr="SELECT COUNT(a.user_id) AS numrows
		FROM (users a)
		WHERE  (
		a.username LIKE '%$cari%'
		OR a.nama_user LIKE '%$cari%'
		)
		$cekTipe
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_user($cari,$mulai,$batas,$tipe){
	if($tipe=="all"){	
		$cekTipe = "";	
	} else{
		$cekTipe = " AND `group`='$tipe' ";	
	}
		$sqlstr="
		SELECT a.*
		FROM users a
		WHERE  (
		a.username LIKE '%$cari%'
		OR a.nama_user LIKE '%$cari%'
		)
		$cekTipe
		ORDER BY a.user_id ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$this->db->set('username',$isi['username']);
		$this->db->set('nama_user',$isi['nama_user']);
		$this->db->set('group',$isi['group']);
		$this->db->set('status',$isi['status']);
		$this->db->where('user_id',$isi['idd']);
		$this->db->update('users');
	}

    function tambah_aksi($isi){
		$sqlstr="INSERT INTO users (`group`,username,nama_user,passwd,`status`) 
		VALUES ('".$isi['group']."','".$isi['username']."','".$isi['nama_user']."','".sha1($isi['username'])."','".$isi['status']."')";		
		$this->db->query($sqlstr);
	
		// $this->db->set('group',$isi['group']);
		// $this->db->set('username',$isi['username']);
		// $this->db->set('nama_user',$isi['nama_user']);
		// $this->db->set('status','on');
		// $this->db->insert('users');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('users', array('user_id' => $isi['idd']));
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
