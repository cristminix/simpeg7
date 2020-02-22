<?php
class M_direktori extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	function getdirektori($mulai,$batas,$ini){
		$sqlstr="SELECT a.*,b.nama_item AS nama_kategori,  
		(SELECT foto_thumbs FROM konten_foto WHERE id_konten=a.id_konten AND komponen='direktori' ORDER BY foto_urutan ASC LIMIT 0,1) AS foto_thumbs
		FROM konten_judul a 
		LEFT JOIN (p_setting_item b) ON (a.id_kategori=b.id_item)
		WHERE a.id_kategori='$ini' AND a.komponen='direktori' 
		ORDER BY a.urutan ASC LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}

	function hitung_direktori($path){
		$this->db->select('id_konten');
		$this->db->from('konten_judul');
		$this->db->where('id_kategori',$path);
		$hslquery['count'] = count($this->db->get()->result());
		
		return $hslquery;
	}

	function urutan_direktori($idd,$path){
		$this->db->select('id_konten');
		$this->db->from('konten_judul');
		$this->db->where('id_kategori',$path);
		$this->db->where('urutan<=',$idd,FALSE);
		$hslrow['count'] = count($this->db->get()->result());
		return $hslrow;
	}

	function ikanal($idd){
		$hslquery = $this->db->get_where('p_setting_item', array('id_setting' => '6','id_item' => $idd))->result();
			$jj = json_decode($hslquery[0]->meta_value);
			$hslquery[0]->id_kanal=$jj->id_kanal;
		return $hslquery;
	}

	function ini_direktori($idd){
		$sqlstr="SELECT a.*, (SELECT DAYNAME(a.tanggal)) AS hari, DATE_FORMAT(a.tanggal,'%d-%m-%Y') AS tanggal,c.nama_item AS nama_kategori,c.meta_value
		FROM konten_judul a 
		LEFT JOIN (p_setting_item c)
		ON
		(c.id_setting='6' AND c.id_item=a.id_kategori)
		WHERE a.id_konten='$idd'";
		$hslquery=$this->db->query($sqlstr)->result();
		$jj = json_decode($hslquery[0]->meta_value);
		$hslquery[0]->id_kanal=$jj->id_kanal;

		return $hslquery;
	}


}
