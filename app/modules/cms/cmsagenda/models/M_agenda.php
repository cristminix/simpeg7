<?php
class M_agenda extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function tambah_aksi($isi){
		$sqlstr="INSERT INTO konten_judul (judul,komponen,id_kategori,tgl_mulai,tgl_selesai,isi_artikel,sub_judul) 
		VALUES ('".$isi['tema']."','agenda','".$isi['id_kategori']."','".$isi['tgl_mulai']."','".$isi['tgl_selesai']."','".$isi['isi_agenda']."','".$isi['tempat']."')";		
		$this->db->query($sqlstr);
	}
    function edit_aksi($isi){
		$sqlstr="UPDATE konten_judul SET judul='".$isi['judul']."',id_kategori='".$isi['id_kategori']."',isi_artikel='".$isi['isi_artikel']."',tgl_mulai='".$isi['tgl_mulai']."',tgl_selesai='".$isi['tgl_selesai']."',sub_judul='".$isi['sub_judul']."' WHERE id_konten='".$isi['idd']."'";
		$this->db->query($sqlstr);
	}
    function hapus_aksi($isi){
		$sqlstr="DELETE FROM konten_judul WHERE id_konten='$isi'";
		$this->db->query($sqlstr);
	}
}
