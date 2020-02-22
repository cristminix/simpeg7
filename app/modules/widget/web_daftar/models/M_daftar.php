<?php
class M_daftar extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwidget($idd,$idw,$mulai,$opsi){
		$sqlstr="SELECT a.*	FROM p_setting_item a WHERE a.id_setting='9' AND a.id_item=$idw";
		$hslquery=$this->db->query($sqlstr)->result();

			$jj=json_decode($hslquery[0]->meta_value);
			$ini=$jj->id_kategori;

		$sqlstr3="SELECT a.*, b.nama_item AS nama_kategori 
		FROM konten_judul a 
		LEFT JOIN (p_setting_item b) ON (a.id_kategori=b.id_item AND b.id_setting='6') 
		WHERE a.id_kategori IN ($ini) LIMIT $mulai,$opsi";
		$hslquery3=$this->db->query($sqlstr3);
		return $hslquery3;
	}

	function ini_wrapper($idd){
		$sqlstr="SELECT a.id_item AS id_wrapper,a.nama_item AS nama_wrapper FROM p_setting_item a WHERE a.id_item='$idd'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}


	function hitung_item($path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_kategori='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function urutan_direktori($idd,$path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_konten<='$idd' AND komponen='direktori' AND id_kategori='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}

//////////////////////////////////////////////////////////////////////////////////
	function foto($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='$idd' AND komponen='direktori' ORDER BY foto_urutan ASC";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function getfoto($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_foto='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
