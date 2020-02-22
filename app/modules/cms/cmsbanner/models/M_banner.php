<?php
class M_banner extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_album(){
		$query=$this->db->query("SELECT count(a.id_item) as count_nik
		FROM p_setting_item a 
		WHERE a.id_setting='6' AND a.meta_value LIKE '%\"komponen\":\"banner\"%'");
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getalbum($mulai,$batas){
		$sqlstr="SELECT a.id_item AS id_kategori,a.nama_item AS nama_kategori,a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='6' AND a.meta_value LIKE '%\"komponen\":\"banner\"%'
		ORDER BY a.urutan ASC  
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function isi_album($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='$idd' AND tipe='banner'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function inialbum($idd){
		$sqlstr="SELECT a.id_item AS id_kategori,a.nama_item AS nama_kategori,a.meta_value
		FROM p_setting_item a 
		WHERE id_item='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
    function tambah_album_aksi($isi){
		$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM p_kanal_kategori"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;

		$sqlstr="INSERT INTO p_kanal_kategori (nama_kategori,keterangan,status,urutan) 
		VALUES ('".$isi['nama_kategori']."','".$isi['keterangan']."','pending','$max')";		
		$this->db->query($sqlstr);
	}
    function edit_album_aksi($isi){
		$sqlstr="UPDATE p_kanal_kategori SET nama_kategori='".$isi['nama_kategori']."',keterangan='".$isi['keterangan']."' WHERE id_kategori='".$isi['idd']."'";		
		$this->db->query($sqlstr);
	}

	function banner($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='$idd' AND tipe='banner' ORDER BY foto_urutan ASC";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function simpan_banner($id_kategori,$nama_file){
		$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM banner WHERE id_kategori='$id_kategori'"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;

		$sqlstr="INSERT INTO banner (id_kategori,file_image,urutan) 
		VALUES ('$id_kategori','$nama_file','$max')";		
		$this->db->query($sqlstr);
	}

    function hapus_banner_aksi($isi){
		$sqlstr="SELECT * FROM banner WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan']."'"; 
		$hslquery=$this->db->query($sqlstr);

		$sqlstr="DELETE FROM banner WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan']."'";
		$this->db->query($sqlstr);

		$sqlstr="UPDATE banner SET urutan=(urutan-1) WHERE id_kategori='".$isi['idd']."' AND urutan>'".$isi['urutan']."'";
		$this->db->query($sqlstr);

		return $hslquery;
	}
    function reurut_banner_aksi($isi){
				$sqlstr="UPDATE banner SET	urutan='99' WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan_ini']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE banner SET	urutan='".$isi['urutan_ini']."' WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan_lawan']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE banner SET	urutan='".$isi['urutan_lawan']."'	WHERE id_kategori='".$isi['idd']."' AND urutan='99'";
				$this->db->query($sqlstr);
	}

    function edit_banner_aksi($isi){
		for($i=0;$i<count($isi['link']);$i++){
				$sqlstr="UPDATE banner SET
				 link='".$isi['link'][$i]."',
				 keterangan='".$isi['keterangan'][$i]."'
				 WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan'][$i]."'";
				$this->db->query($sqlstr);
		}
	}
//////////////////////////////////////////////////////////////////////////////////

}
