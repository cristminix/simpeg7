<?php
class M_commented extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwidget($idd,$idw){
		$sqlstr="SELECT a.*
		FROM p_setting_item a 
		WHERE a.id_setting='9' AND a.id_item=$idw";
		$hslquery=$this->db->query($sqlstr)->result();
		
			$jj=json_decode($hslquery[0]->meta_value);
			$ini=$jj->id_kategori;

		$sqlstr3="SELECT a.*, (SELECT DAYNAME(a.tanggal)) AS hari, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal, b.nama_item AS nama_kategori 
		FROM konten_judul a 
		LEFT JOIN p_setting_item b ON (a.id_kategori=b.id_item AND b.id_setting='6') 
		WHERE a.id_kategori IN ($ini) AND a.komponen='artikel' ORDER BY a.tanggal DESC LIMIT 0,6";

		$sqlstr4="SELECT a.*, (SELECT DAYNAME(a.tanggal)) AS hari, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal, b.nama_item AS nama_kategori 
		FROM konten_judul a 
		LEFT JOIN p_setting_item b ON (a.id_kategori=b.id_item AND b.id_setting='6') 
		WHERE a.id_kategori IN ($ini) AND a.komponen='artikel' ORDER BY a.id_konten DESC LIMIT 0,6";

		$comment['komentar']=$this->db->query($sqlstr3)->result();
		$comment['populer']=$this->db->query($sqlstr4)->result();

		return $comment;
	}
	function ini_wrapper($idd){
		$sqlstr="SELECT a.id_parent AS id_widget,a.nama_item AS id_wrapper FROM p_setting_item a WHERE a.id_setting='9' AND a.id_parent='$idd'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
}
