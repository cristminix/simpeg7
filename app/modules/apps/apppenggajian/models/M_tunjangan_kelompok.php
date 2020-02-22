<?php
class M_tunjangan_kelompok extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_tunjangan_kelompok($idd){
		$this->db->from('m_tunjangan_kelompok');
		$this->db->where('id_tunjangan_kelompok',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_tunjangan_kelompok($cari,$tunjangan_kelompok){
		$sqlstr="SELECT COUNT(a.id_tunjangan_kelompok) AS numrows
		FROM (m_tunjangan_kelompok a)
		WHERE  (
		a.tunjangan_kelompok LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_tunjangan_kelompok($cari,$mulai,$batas,$tunjangan_kelompok){
		$sqlstr="
		SELECT a.*
		FROM m_tunjangan_kelompok a
		WHERE  (
		a.tunjangan_kelompok LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		ORDER BY a.id_tunjangan_kelompok ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		$this->db->set('tunjangan_kelompok',$isi['tunjangan_kelompok']);
		$this->db->set('status',$isi['optradio']);
		$this->db->where('id_tunjangan_kelompok',$isi['idd']);
		$this->db->update('m_tunjangan_kelompok');
	}

    function tambah_aksi($isi){
		$isi = $_POST;
		$this->db->set('tunjangan_kelompok',$isi['tunjangan_kelompok']);
		$this->db->set('status',$isi['optradio']);
		$this->db->insert('m_tunjangan_kelompok');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_tunjangan_kelompok', array('id_tunjangan_kelompok' => $isi['idd']));
	}

}
