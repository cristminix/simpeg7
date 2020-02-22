<?php
class M_agenda extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwrapper($idw){
		$sqlstr="SELECT * FROM m_widget_wrapper WHERE id_wrapper='$idw'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function getwidget($idd,$idw){
		$sqlstr="SELECT * FROM m_widget WHERE id_widget='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		$nama_tabel=$hslquery[0]->tabel_komponen;
		$nama_id=$hslquery[0]->id_komponen;
		$nama_kunci=$hslquery[0]->nama_kunci;

		$sqlstr2="SELECT * FROM m_widget_wrapper_isi WHERE id_wrapper='$idw'";
		$hslquery2=$this->db->query($sqlstr2)->result();
			$ini="";
			foreach($hslquery2 as $key=>$val){
				if($key==0){
					$ini.="a.".$nama_id."=".$val->nilai_idnya;
				} else {
					$ini.=" OR a.".$nama_id."=".$val->nilai_idnya;
				}
			}

		$sqlstr3="SELECT a.*, 
		(SELECT DAYNAME(a.tgl_mulai)) AS hari_mulai, DATE_FORMAT(a.tgl_mulai,'%d-%m-%Y') AS tgl_mulai, 
		(SELECT DAYNAME(a.tgl_selesai)) AS hari_selesai, DATE_FORMAT(a.tgl_selesai,'%d-%m-%Y') AS tgl_selesai, 
		b.nama_kategori 
		FROM konten_judul a
		LEFT JOIN p_kanal_kategori b ON (a.id_kategori=b.id_kategori) 
		WHERE $ini AND a.komponen='agenda' ORDER BY a.id_konten DESC LIMIT 0,10";
		$hslquery3=$this->db->query($sqlstr3);

		return $hslquery3;
	}
	function getwapperisi($idd){
		$sqlstr="SELECT * FROM m_widget WHERE id_widget='$idd'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
	function ini_agenda($idd){
		$sqlstr="SELECT a.*,c.nama_item AS nama_kategori,c.id_item AS id_kategori,c.id_parent,c.meta_value, 
		(SELECT DAYNAME(a.tgl_mulai)) AS hari_mulai, DATE_FORMAT(a.tgl_mulai,'%d-%m-%Y') AS tgl_mulai, 
		(SELECT DAYNAME(a.tgl_selesai)) AS hari_selesai, DATE_FORMAT(a.tgl_selesai,'%d-%m-%Y') AS tgl_selesai
		FROM konten_judul a 
		LEFT JOIN (p_setting_item c)
		ON
		(c.id_setting='6' AND c.id_item=a.id_kategori)
		WHERE a.id_konten='$idd' AND a.komponen='agenda'";
		$hslquery=$this->db->query($sqlstr)->result();

		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->id_kanal=$jj->id_kanal;
		return $hslquery;
	}
	function rubrik_kanal($idd,$idx){
		$sqlstr="SELECT a.*,b.nama_kanal,c.nama_kategori 
		FROM p_kanal_kategori a 
		LEFT JOIN (p_kanal b, p_kanal_kategori c) 
		ON (a.id_kanal=b.id_kanal AND a.id_kategori=c.id_kategori)  
		WHERE a.id_kanal='$idd' AND a.id_kategori!='$idx' AND a.komponen='agenda'";
		$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
	}
	function hitung_agenda($path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_kategori='$path' AND komponen='agenda'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function urutan_agenda($idd,$path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE id_konten<='$idd' AND komponen='agenda' AND id_kategori='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getagenda($mulai,$batas,$path){
//		if($path=="xx"){$and1="";}else{$and1=" WHERE a.komponen='agenda' AND a.id_kategori='$path'";}
		$sqlstr="SELECT a.*, b.nama_item AS nama_kategori,
		(SELECT DAYNAME(a.tgl_mulai)) AS hari_mulai, DATE_FORMAT(a.tgl_mulai,'%d-%m-%Y') AS tgl_mulai, 
		(SELECT DAYNAME(a.tgl_selesai)) AS hari_selesai, DATE_FORMAT(a.tgl_selesai,'%d-%m-%Y') AS tgl_selesai,
		(SELECT foto_thumbs FROM konten_foto WHERE id_konten=a.id_konten AND komponen='agenda' ORDER BY foto_urutan ASC LIMIT 0,1) AS foto_thumbs
		FROM konten_judul a
		LEFT JOIN (p_setting_item b) ON (a.id_kategori=b.id_item AND b.id_setting='6')
		WHERE a.id_kategori='$path' AND a.komponen='agenda'
		ORDER BY a.id_konten DESC  LIMIT $mulai,$batas";

		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
	function getkanal($idd){
/*
		$sqlstr="SELECT a.id_kanal,b.kanal_path FROM p_kanal_kategori a LEFT JOIN p_kanal b ON (a.id_kanal=b.id_kanal) WHERE a.id_kategori='$idd' AND a.komponen='agenda'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
*/
		$sqlstr="SELECT a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='6' AND a.id_item='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();

		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->id_kanal=$jj->id_kanal;
		return $hslquery;

	}
//////////////////////////////////////////////////////////////////////////////////
	function foto($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='$idd'";
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
