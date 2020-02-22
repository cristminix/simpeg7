<?php
class M_web_galeri extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwidget($idd,$idw){
		$sqlstr="SELECT a.*	FROM p_setting_item a WHERE a.id_setting='9' AND a.id_item=$idw";
		$hslquery=$this->db->query($sqlstr)->result();
		
			$jj=json_decode($hslquery[0]->meta_value);
			$ini=$jj->id_kategori;

		$sqlstr3="SELECT a.*, 
		(SELECT DAYNAME(a.tanggal)) AS hari_buat, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal, 
		(SELECT foto_thumbs FROM konten_foto WHERE id_konten=a.id_konten ORDER BY foto_urutan ASC LIMIT 0,1) AS foto_thumbs, 
		b.nama_item AS nama_kategori
		FROM konten_judul a
		LEFT JOIN (p_setting_item b) ON (a.id_kategori=b.id_item AND b.id_setting='6')
		WHERE a.id_kategori IN ($ini)
		ORDER BY a.tanggal DESC  LIMIT 0,4";
		$hslquery3=$this->db->query($sqlstr3)->result();
		return $hslquery3;
	}
//////////////////////////////////////////////////////////////////////////////////
	function ini_wrapper($idw){
		$sqlstr="SELECT a.nama_item AS nama_wrapper FROM p_setting_item a WHERE a.id_item='$idw'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function ini_galeri($idd){
		$sqlstr="SELECT a.*,(SELECT DAYNAME(a.tanggal)) AS hari_buat, 
		DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal,c.nama_item AS nama_kategori,c.meta_value
		FROM konten_judul a 
		LEFT JOIN (p_setting_item c)
		ON
		(c.id_setting='6' AND c.id_item=a.id_kategori)
		WHERE a.id_konten='$idd' AND a.komponen='galeri'";

		$hslquery=$this->db->query($sqlstr)->result();
		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->id_kanal=$jj->id_kanal;

		return $hslquery;
	}
	function album_galeri($idd){
		$sqlstr="SELECT a.*
		FROM konten_foto a
		LEFT JOIN (konten_judul b)
		ON (b.id_konten=a.id_konten)
		WHERE a.id_konten='$idd' ORDER BY a.foto_urutan ASC";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function getfoto($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_foto='$idd'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_album($path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_kategori='$path' AND komponen='galeri'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getalbum($mulai,$batas,$path){
		$sqlstr="SELECT a.*, (SELECT foto_thumbs FROM konten_foto WHERE id_konten=a.id_konten ORDER BY foto_urutan ASC LIMIT 0,1) AS foto_thumbs,
		(SELECT DAYNAME(a.tanggal)) AS hari_buat, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal, 
		b.nama_item AS nama_kategori
		FROM konten_judul a
		LEFT JOIN (p_setting_item b) ON (a.id_kategori=b.id_item AND b.id_setting='6')
		WHERE a.id_kategori='$path' AND a.komponen='galeri'
		ORDER BY a.id_konten DESC  LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}

	function urutan_galeri($idd,$path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_konten>='$idd' AND id_kategori='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
//////////////////////////////////////////////////////////////////////////////////
	function getkanal($idd){
		$sqlstr="SELECT a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='6' AND a.id_item='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();

		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->id_kanal=$jj->id_kanal;
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
