<?php
class M_setting extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function detail_grup($idg){
		$sqlstr="SELECT nama_item AS group_name FROM p_setting_item WHERE id_item='$idg'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
	function getopsi($sett){
		$sqlstr="SELECT * FROM p_setting WHERE nama_setting='$sett'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function getitem($sett,$idp){
		$sqlstr="SELECT a.*
		FROM p_setting_item a 
		WHERE a.id_setting='$sett' AND a.id_parent='$idp' 
		ORDER BY a.urutan";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function ini_item($nid){
		$sqlstr="SELECT * FROM p_setting_item WHERE id_item='".$nid."'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function naik_urutan_item_aksi($idini,$urini,$idlawan,$urlawan){
		$sqlstr="UPDATE p_setting_item SET urutan='$urlawan' WHERE id_item='$idini'";
		$this->db->query($sqlstr);
		$sqlstr="UPDATE p_setting_item SET urutan='$urini' WHERE id_item='$idlawan'";
		$this->db->query($sqlstr);
	}
    function hapus_item_aksi($idp){
		$sqlstr="DELETE FROM p_setting_item WHERE id_item='$idp'";
		$this->db->query($sqlstr);
	}
    function reurut($ids,$idp){
		$sqlstr="SELECT id_item FROM p_setting_item WHERE id_setting='$ids' AND id_parent='$idp' ORDER BY urutan";
		$hslquery=$this->db->query($sqlstr)->result();
		$urutanbaru=1;
		foreach($hslquery AS $key=>$val){
			$sqlstr="UPDATE p_setting_item SET urutan='$urutanbaru' WHERE id_item='".$val->id_item."'";
			$this->db->query($sqlstr);
			$urutanbaru++;
		}
	}
///////////////////////////////////////////////////
	function tambah_menu_aksi($idp,$ipp){
			$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM p_setting_item WHERE id_setting='2' AND id_parent='$idp'"); 
			$row = $query->row_array();		$max = $row['count_nik']+1;
			$ini="{\"path_menu\":\"".$ipp['menu_path']."\",\"icon_menu\":\"".$ipp['icon_menu']."\",\"keterangan\":\"".$ipp['keterangan']."\"}";

			$sqlstr="INSERT INTO p_setting_item (id_setting,id_parent,nama_item,urutan,meta_value) 
			VALUES ('2','$idp','".$ipp['menu_name']."','$max','$ini')";		
			$this->db->query($sqlstr);
	}
	function edit_menu_aksi($idp,$ipp){
			$ini="{\"path_menu\":\"".$ipp['menu_path']."\",\"icon_menu\":\"".$ipp['icon_menu']."\",\"keterangan\":\"".$ipp['keterangan']."\"}";
			$sqlstr="UPDATE p_setting_item SET nama_item='".$ipp['menu_name']."',meta_value='$ini' WHERE id_item='$idp'";		
			$this->db->query($sqlstr);
	}
	function cek_menu($idp){
		$sqlstr="SELECT id_item FROM p_setting_item WHERE id_setting='3' AND meta_value LIKE '%\"id_menu\":\"$idp\"%'";
		$hslquery=$this->db->query($sqlstr)->result();

		return $hslquery;
	}
///////////////////////////////////////////////////
	function getmenupengguna($sett,$sett_ref,$idp,$group_id){
		$sqlstr="SELECT a.* FROM p_setting_item a WHERE a.id_setting='$sett_ref' AND a.id_parent='$idp' ORDER BY a.urutan";
		$hslquery=$this->db->query($sqlstr)->result();
		
		$hslqueryc=array();
		foreach($hslquery as $key=>$val){
			$sqlstrb="SELECT b.* FROM p_setting_item b WHERE b.id_setting='$sett' AND b.meta_value LIKE '%\"group_id\":\"$group_id\"%'  AND b.meta_value LIKE '%\"id_menu\":\"".$val->id_item."\"%'";
			$hslqueryb=$this->db->query($sqlstrb)->result();
			if(!empty($hslqueryb)){	$hslqueryc[]=$hslquery[$key];	}
		}
		return $hslqueryc;
	}

	function cekmenupengguna($id_item,$set,$set_ref,$grup){
		$sqlstr="SELECT a.*	FROM p_setting_item a WHERE a.id_setting='$set_ref' AND a.id_item='$id_item'";
		$hslquery=$this->db->query($sqlstr)->result();
		$sqlstrb="SELECT a.id_item FROM p_setting_item a WHERE a.id_setting='$set' AND a.meta_value LIKE '%\"group_id\":\"$grup\"%' AND a.meta_value LIKE '%\"id_menu\":\"$id_item\"%'";
		$hslqueryb=$this->db->query($sqlstrb)->result();
		return $hslqueryb;
	}

	function tambah_menu_pengguna_aksi($idd,$set,$ipp){
		for($i=0;$i<count($ipp)-1;$i++){
			$sql ="SELECT id_item FROM p_setting_item WHERE id_setting='$set' AND meta_value LIKE '%\"group_id\":\"$idd\"%' AND meta_value LIKE '%\"id_menu\":\"".$ipp[$i]."\"%'";
			$dt = $this->db->query($sql)->result();
			if(empty($dt)){	
				$ini="{\"id_menu\":\"".$ipp[$i]."\",\"group_id\":\"$idd\"}";
				$sqlstr="INSERT INTO p_setting_item (id_setting,meta_value) VALUES ('$set','$ini')";
				$this->db->query($sqlstr);
			}
		}
	}

	function hapus_menu_pengguna_aksi($grup,$idm){
		$sqlstr="DELETE FROM p_setting_item WHERE id_setting='3' AND meta_value LIKE '%\"group_id\":\"$grup\"%' AND meta_value LIKE '%\"id_menu\":\"$idm\"%'";
		$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwidget($mulai,$batas){
		if($batas==0){$limit="";}else{$limit="LIMIT $mulai,$batas";}
		$sqlstr="SELECT a.*	FROM p_setting_item a WHERE a.id_setting='8' ORDER BY a.id_item ASC  $limit";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function hitung_widget(){
		$query=$this->db->query("SELECT count(id_item) as count_nik FROM p_setting_item WHERE id_setting='8'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
//////////////////////////////////////////////////////////////////////////////////
	function getwrapper($mulai,$batas,$idd){
		if($batas==0){$limit="";}else{$limit="LIMIT $mulai,$batas";}
		$sqlstr="SELECT a.*
		FROM p_setting_item a 
		WHERE a.id_setting='9' AND a.meta_value LIKE '%\"id_widget\":\"$idd\"%'
		ORDER BY a.urutan ASC  $limit";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}

	function getkategori_by_komponen($komponen){
		$sqlstr="SELECT * FROM p_setting_item WHERE id_setting='6' AND meta_value LIKE '%\"komponen\":\"$komponen\"%'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function getkanalpemakaiwrapper_by_idwrapper($id_wrapper){
		$sqlstr="SELECT meta_value FROM p_setting_item WHERE id_setting='10' AND meta_value LIKE '%\"id_wrapper\":\"$id_wrapper\"%'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function hitung_wrapper($idd){
		$query=$this->db->query("SELECT count(id_item) as count_nik 
		FROM p_setting_item
		WHERE id_setting='9'  AND meta_value LIKE '%\"id_widget\":\"$idd\"%'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
    function tambah_wrapper_aksi($isi){
			$yu="";
		foreach($isi['widget_isi'] AS $key=>$val){
			$yu.= ($key==0) ? $val : ",".$val;
		}
		$ini="{\"id_widget\":\"".$isi['id_widget']."\",\"id_kategori\":\"".$yu."\",\"keterangan\":\"".$isi['keterangan']."\"}";
		$sqlstr="INSERT INTO p_setting_item (id_setting,nama_item,meta_value) VALUES ('9','".$isi['nama_wrapper']."','$ini')";		
		$this->db->query($sqlstr);
	}

    function edit_wrapper_aksi($isi){
			$yu="";
		foreach($isi['widget_isi'] AS $key=>$val){
			$yu.= ($key==0) ? $val : ",".$val;
		}
		$ini="{\"id_widget\":\"".$isi['id_widget']."\",\"id_kategori\":\"".$yu."\",\"keterangan\":\"".$isi['keterangan']."\"}";
		$sqlstr="UPDATE p_setting_item SET nama_item='".$isi['nama_wrapper']."',
		meta_value='$ini'
		WHERE id_item='".$isi['idd']."' ";
		$this->db->query($sqlstr);
	}
    function hapus_wrapper_aksi($isi){
		$sqlstr="DELETE FROM m_widget_wrapper WHERE id_wrapper='".$isi['idd']."'";
		$this->db->query($sqlstr);
	}

///////////////////////////////////////////////
}
