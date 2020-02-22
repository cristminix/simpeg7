<?php
class M_masa_kerja extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_masa_kerja($idd){
		$this->db->from('m_masa_kerja');
		$this->db->where('id_masa_kerja',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_masa_kerja($cari,$masa_kerja){
		$sqlstr="SELECT COUNT(a.id_masa_kerja) AS numrows
		FROM (m_masa_kerja a)
		WHERE  (
		a.masa_kerja LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_masa_kerja($cari,$mulai,$batas,$masa_kerja){
		$sqlstr="
		SELECT a.*
		FROM m_masa_kerja a
		WHERE  (
		a.masa_kerja LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		
		)
		
		ORDER BY a.id_masa_kerja ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		$this->db->set('masa_kerja',str_replace('.', '',$isi['masa_kerja']));
		$this->db->set('status',$isi['optradio']);
		$this->db->where('id_masa_kerja',$isi['idd']);
		$this->db->update('m_masa_kerja');
	}

    function tambah_aksi($isi){
		$isi = $_POST;
		$this->db->set('masa_kerja',str_replace('.', '',$isi['masa_kerja']));
		$this->db->set('status',$isi['optradio']);
		$this->db->insert('m_masa_kerja');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_masa_kerja', array('id_masa_kerja' => $isi['idd']));
	}

}
