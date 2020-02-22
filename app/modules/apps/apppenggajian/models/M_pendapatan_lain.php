<?php
class M_pendapatan_lain extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_pendapatan_lain($idd){
		$this->db->from('m_pendapatan_lain');
		$this->db->where('id_pendapatan_lain',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_pendapatan_lain($cari,$pendapatan_lain){
		$sqlstr="SELECT COUNT(a.id_pendapatan_lain) AS numrows
		FROM (m_pendapatan_lain a)
		WHERE  (
		a.pendapatan_lain LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pendapatan_lain($cari,$mulai,$batas,$pendapatan_lain){
		$sqlstr="
		SELECT a.*
		FROM m_pendapatan_lain a
		WHERE  (
		a.pendapatan_lain LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		ORDER BY a.id_pendapatan_lain ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		$this->db->set('pendapatan_lain',$isi['pendapatan_lain']);
		$this->db->set('status',$isi['optradio']);
		$this->db->where('id_pendapatan_lain',$isi['idd']);
		$this->db->update('m_pendapatan_lain');
	}

    function tambah_aksi($isi){
		$isi = $_POST;
		$this->db->set('pendapatan_lain',$isi['pendapatan_lain']);
		$this->db->set('status',$isi['optradio']);
		$this->db->insert('m_pendapatan_lain');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_pendapatan_lain', array('id_pendapatan_lain' => $isi['idd']));
	}

}
