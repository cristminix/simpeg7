<?php
class M_artikel_baca extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function ini_artikel($idd){
		$sqlstr="SELECT a.*, (SELECT DAYNAME(a.tanggal)) AS hari, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal,c.nama_item AS nama_kategori,c.meta_value
		FROM konten_judul a 
		LEFT JOIN (p_setting_item c)
		ON
		(c.id_setting='6' AND c.id_item=a.id_kategori)
		WHERE a.id_konten='$idd' AND a.komponen='artikel'";
		$hslquery=$this->db->query($sqlstr)->result();
		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->id_kanal=$jj->id_kanal;

		return $hslquery;
	}
	function hitung_artikel($path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_kategori='$path' AND komponen='artikel'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function urutan_artikel($idd,$path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_konten>='$idd' AND komponen='artikel' AND id_kategori='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getartikel($mulai,$batas,$path){
		if($path=="xx"){$and1="";}else{$and1=" WHERE a.id_kategori='$path'";}
		$sqlstr="SELECT a.judul, (SELECT DAYNAME(a.tanggal)) AS hari, DATE_FORMAT(tanggal,'%d-%m-%Y') AS tanggal,a.id_konten,b.nama_item AS nama_kategori, a.isi_artikel,c.nama_item AS nama_penulis,
		(SELECT foto_thumbs FROM konten_foto WHERE id_konten=a.id_konten AND tipe='foto' ORDER BY foto_urutan ASC LIMIT 0,1) AS foto_thumbs
		FROM konten_judul a 
		LEFT JOIN (p_setting_item b,p_setting_item c) 
		ON (a.id_kategori=b.id_item AND b.id_setting='6' AND a.komponen='artikel' AND c.id_setting='11' AND a.id_penulis=c.id_item) $and1 
		ORDER BY a.id_konten DESC  LIMIT $mulai,$batas";

		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function gambar_artikel($idd){
		$hslquery = $this->db->get_where('konten_foto', array('id_konten' => $idd,'tipe'=>'foto'))->result();
		return $hslquery;
	}
	function hitung_komen($path){
		$query=$this->db->query("SELECT count(id_komentar) as count_nik FROM artikel_komentar WHERE id_konten='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getkomen($mulai,$batas,$isi){
		$sqlstr="SELECT * FROM artikel_komentar WHERE id_konten='$isi' LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function isi_komentar_aksi($isi){
		$sqlstr="INSERT INTO artikel_komentar (id_konten,nama_komentator,email_komentator,isi_komentar) 
		VALUES ('".$isi['id_konten']."','".$isi['nama_komentator']."','".$isi['email_komentator']."','".$isi['isi_komentar']."')";		
		$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
	function root_kanal($idd){
		$root="";
		$sqlstr="SELECT a.id_item AS id_kanal,a.nama_item AS nama_kanal,a.id_parent AS id_parent,a.urutan AS urutan,a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='1' AND a.id_item='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();

		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->kanal_path=$jj->path_kanal;

		$root=$hslquery[0]->id_kanal."*".$hslquery[0]->nama_kanal."*".$hslquery[0]->kanal_path."**".$root;
		if($hslquery[0]->id_parent!=0){
			$ulang = $this->root_kanal($hslquery[0]->id_parent);
			$root=$ulang.$root;
		}
		return $root;
	}
	function cari_kanal($idd){
		$sqlstr="SELECT a.id_item AS id_kanal,a.nama_item AS nama_kanal,a.id_parent AS id_parent,a.urutan AS urutan,a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='1' AND a.id_item='$idd'";

		$hslquery=$this->db->query($sqlstr)->result();

		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->kanal_path=$jj->path_kanal;
		$hslquery[0]->tipe=$jj->tipe;
		$hslquery[0]->theme=$jj->theme;

		if($hslquery[0]->id_parent==0){
			return $hslquery;
		} else {
			$ulang=$this->cari_kanal($hslquery[0]->id_parent);
			return $ulang;
		}
	}
	function ikanal($idd){
		$hslquery = $this->db->get_where('p_setting_item', array('id_setting' => '6','id_item' => $idd))->result();
			$jj = json_decode($hslquery[0]->meta_value);
			$hslquery[0]->id_kanal=$jj->id_kanal;
		return $hslquery;
	}
}
