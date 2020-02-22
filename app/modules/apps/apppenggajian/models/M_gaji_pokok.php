<?php
class M_gaji_pokok extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_gaji_pokok($idd){
		$this->db->from('m_gaji_pokok');
		$this->db->where('id_gaji_pokok',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_gaji_pokok($cari,$masa_kerja){
		$sqlstr="SELECT COUNT(a.id_gaji_pokok) AS numrows
		FROM (m_gaji_pokok a)
		WHERE  (
		a.nama_pangkat LIKE '%$cari%'
		OR
		a.masa_kerja LIKE '%$cari%'
		OR
		a.gaji_pokok LIKE '%$cari%'
		OR
		a.tahun LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_gaji_pokok($cari,$mulai,$batas,$masa_kerja){
		$sqlstr="
		SELECT a.*
		FROM m_gaji_pokok a
		WHERE  (
		a.nama_pangkat LIKE '%$cari%'
		OR
		a.masa_kerja LIKE '%$cari%'
		OR
		a.gaji_pokok LIKE '%$cari%'
		OR
		a.tahun LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		ORDER BY a.id_gaji_pokok ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		$pkt = $this->dropdowns->getKodeGolPangkat();
		$pkt_X=explode(",",$pkt[$isi['kode_golongan']]);
		
		$this->db->set('kode_golongan',$isi['kode_golongan']);
		$this->db->set('nama_pangkat',trim($pkt_X[0]));
		$this->db->set('masa_kerja',$isi['masa_kerja']);
		$this->db->set('gaji_pokok',str_replace('.', '',$isi['gaji_pokok']));
		$this->db->set('tahun',$isi['tahun']);
		$this->db->set('status',$isi['optradio']); 
		$this->db->where('id_gaji_pokok',$isi['idd']);
		$this->db->update('m_gaji_pokok');
	}

    function tambah_aksi($isi){
		$isi = $_POST;
		$pkt = $this->dropdowns->getKodeGolPangkat();
		$pkt_X=explode(",",$pkt[$isi['kode_golongan']]);
		
		$this->db->set('kode_golongan',$isi['kode_golongan']);
		$this->db->set('nama_pangkat',trim($pkt_X[0]));
		$this->db->set('masa_kerja',$isi['masa_kerja']);
		$this->db->set('gaji_pokok',str_replace('.', '',$isi['gaji_pokok']));
		// $this->db->set('gaji_pokok',$isi['gaji_pokok']);
		$this->db->set('tahun',$isi['tahun']);
		$this->db->set('status',$isi['optradio']); 
		$this->db->insert('m_gaji_pokok');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_gaji_pokok', array('id_gaji_pokok' => $isi['idd']));
	}

}
