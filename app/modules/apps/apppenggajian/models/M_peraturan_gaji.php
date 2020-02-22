<?php
class M_peraturan_gaji extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_peraturan_gaji($idd){
		$this->db->from('m_peraturan_gaji');
		$this->db->where('id_peraturan_gaji',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_peraturan_gaji($cari,$masa_kerja){
		$sqlstr="SELECT COUNT(a.id_peraturan_gaji) AS numrows
		FROM (m_peraturan_gaji a)
		WHERE  (
		a.peraturan_gaji LIKE '%$cari%'
		OR
		a.tahun LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_peraturan_gaji($cari,$mulai,$batas,$masa_kerja){
		$sqlstr="
		SELECT a.*
		FROM m_peraturan_gaji a
		WHERE  (
		a.peraturan_gaji LIKE '%$cari%'
		OR
		a.tahun LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		ORDER BY a.id_peraturan_gaji ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		
		$this->db->set('peraturan_gaji',$isi['peraturan_gaji']);
		$this->db->set('tahun',$isi['tahun']);
		$this->db->set('status',$isi['optradio']); 
		$this->db->set('file',$isi['file']);
		$this->db->where('id_peraturan_gaji',$isi['idd']);
		$this->db->update('m_peraturan_gaji');
	}
	
    function tambah_aksi($isi,$file){
		$isi = $_POST;
	
		$this->db->set('peraturan_gaji',$isi['peraturan_gaji']);
		$this->db->set('tahun',$isi['tahun']);
		$this->db->set('status',$isi['optradio']); 
		$this->db->set('file',$file);
		$this->db->insert('m_peraturan_gaji');
		
			
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_peraturan_gaji', array('id_peraturan_gaji' => $isi['idd']));
	}

}
