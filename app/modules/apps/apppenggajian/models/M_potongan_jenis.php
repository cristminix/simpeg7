<?php
class M_potongan_jenis extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_potongan_jenis($idd){
		$this->db->from('m_potongan_jenis');
		$this->db->where('id_potongan_jenis',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_potongan_jenis($cari,$masa_kerja){
		$sqlstr="SELECT COUNT(a.id_potongan_jenis) AS numrows
		FROM (m_potongan_jenis a)
		WHERE  (
		a.potongan_jenis LIKE '%$cari%'
		OR
		a.keterangan LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_potongan_jenis($cari,$mulai,$batas,$masa_kerja){
		$sqlstr="
		SELECT a.*
		FROM m_potongan_jenis a
		WHERE  (
		a.potongan_jenis LIKE '%$cari%'
		OR
		a.keterangan LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		ORDER BY a.id_potongan_jenis ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		$this->db->set('potongan_jenis',$isi['potongan_jenis']);
		$this->db->set('keterangan',$isi['keterangan']);
		$this->db->set('status',$isi['optradio']);
		$this->db->where('id_potongan_jenis',$isi['idd']);
		$this->db->update('m_potongan_jenis');
	}

    function tambah_aksi($isi){
		$isi = $_POST;
		$this->db->set('potongan_jenis',$isi['potongan_jenis']);
		$this->db->set('keterangan',$isi['keterangan']);
		$this->db->set('status',$isi['optradio']);
		$this->db->insert('m_potongan_jenis');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_potongan_jenis', array('id_potongan_jenis' => $isi['idd']));
	}

}
