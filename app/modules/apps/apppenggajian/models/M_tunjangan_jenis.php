<?php
class M_tunjangan_jenis extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    

    function ini_tunjangan_jenis($idd){
		$this->db->from('m_tunjangan_jenis');
		$this->db->where('id_tunjangan_jenis',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_tunjangan_jenis($cari,$masa_kerja){
		$sqlstr="SELECT COUNT(a.id_tunjangan_jenis) AS numrows
		FROM (m_tunjangan_jenis a)
		WHERE  (
		a.tunjangan_jenis LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_tunjangan_jenis($cari,$mulai,$batas,$masa_kerja){
		$sqlstr="
		SELECT a.*,b.tunjangan_kelompok
		FROM m_tunjangan_jenis a
		LEFT JOIN m_tunjangan_kelompok b ON a.id_tunjangan_kelompok=b.id_tunjangan_kelompok
		WHERE  (
		a.tunjangan_jenis LIKE '%$cari%'
		OR
		a.status LIKE '%$cari%'
		)
		
		ORDER BY a.id_tunjangan_jenis ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$isi = $_POST;
		$pkt = $this->dropdowns->getTunjKelompok();
		$pkt_X=explode(",",$pkt[$isi['id_tunjangan_kelompok']]);
		
		$this->db->set('id_tunjangan_kelompok',$isi['id_tunjangan_kelompok']);
		$this->db->set('tunjangan_jenis',$isi['tunjangan_jenis']);
		$this->db->set('status',$isi['optradio']); 
		$this->db->where('id_tunjangan_jenis',$isi['idd']);
		$this->db->update('m_tunjangan_jenis');
	}

    function tambah_aksi($isi){
		$isi = $_POST;
		$pkt = $this->dropdowns->getTunjKelompok();
		$pkt_X=explode(",",$pkt[$isi['id_tunjangan_kelompok']]);
		
		$this->db->set('id_tunjangan_kelompok',$isi['id_tunjangan_kelompok']);
		$this->db->set('tunjangan_jenis',$isi['tunjangan_jenis']);
		$this->db->set('status',$isi['optradio']); 
		$this->db->insert('m_tunjangan_jenis');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_tunjangan_jenis', array('id_tunjangan_jenis' => $isi['idd']));
	}

}
