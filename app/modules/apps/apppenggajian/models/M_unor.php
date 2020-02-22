<?php
class M_unor extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function ini_unor($idd){
		$this->db->from('m_unor');
		$this->db->where('id_unor',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function gettree($kode,$lgh,$tanggal){
		$iKode = ($kode==0)?"":"AND a.kode_unor LIKE '$kode%'";
		$sqlstr="SELECT a.* 
		FROM (m_unor a)
		WHERE CHAR_LENGTH(a.kode_unor) = $lgh
		AND a.tmt_berlaku<='$tanggal' AND a.tst_berlaku>='$tanggal'
		$iKode
		ORDER BY a.kode_unor asc
		";
		$res = $this->db->query($sqlstr)->result(); 
		return $res;
	}


	function hitung_master_unor($cari,$tanggal,$ese=""){
		$iTanggal = ($tanggal=="xx")?"":"AND a.tmt_berlaku<='$tanggal' AND a.tst_berlaku>='$tanggal'";
		// $iEse = ($ese=="")?"":"AND kode_ese!='99'";
		$sqlstr="SELECT COUNT(a.id_unor) AS numrows
		FROM (m_unor a)
		WHERE  (
		a.kode_unor LIKE '$cari%'
		OR a.nama_unor LIKE '%$cari%'
		)
		$iTanggal
		
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_master_unor($cari,$mulai,$batas,$tanggal,$ese=""){
		$iTanggal = ($tanggal=="xx")?"":"AND a.tmt_berlaku<='$tanggal' AND a.tst_berlaku>='$tanggal'";
		// $iEse = ($ese=="")?"":"AND kode_ese!='99'";
				$sqlstr="
		SELECT a.*
		FROM m_unor a
		WHERE  (
		a.kode_unor LIKE '$cari%'
		OR a.nama_unor LIKE '%$cari%'
		)
		$iTanggal
	
		ORDER BY a.kode_unor ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
		$this->db->set('nama_unor',$isi['nama_unor']);
		$this->db->set('jenis',$isi['jenis']);
		// $this->db->set('kode_ese',$isi['kode_ese']);
		// $this->db->set('nama_ese',$isi['nama_ese']);
		$this->db->set('nomenklatur_jabatan',$isi['nomenklatur_jabatan']);
		$this->db->set('nomenklatur_pada',$isi['nomenklatur_pada']);
		$this->db->set('nomenklatur_cari',$isi['nomenklatur_cari']);
		$this->db->set('kode_unor',$isi['kode_unor']);
		$this->db->set('tmt_berlaku',$isi['tmt_berlaku']);
		$this->db->set('tst_berlaku',$isi['tst_berlaku']);
		$this->db->where('id_unor',$isi['idd']);
		$this->db->update('m_unor');
	}

    function tambah_aksi($isi){
		$this->db->set('nama_unor',$isi['nama_unor']);
		$this->db->set('jenis',$isi['jenis']);
		// $this->db->set('kode_ese',$isi['kode_ese']);
		// $this->db->set('nama_ese',$isi['nama_ese']);
		$this->db->set('nomenklatur_jabatan',$isi['nomenklatur_jabatan']);
		$this->db->set('nomenklatur_pada',$isi['nomenklatur_pada']);
		$this->db->set('nomenklatur_cari',$isi['nomenklatur_cari']);
		$this->db->set('kode_unor',$isi['kode_unor']);
		$this->db->set('tmt_berlaku',$isi['tmt_berlaku']);
		$this->db->set('tst_berlaku',$isi['tst_berlaku']);
		$this->db->insert('m_unor');
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_unor', array('id_unor' => $isi['idd']));
	}

	function setberlaku_aksi($isi){
		$this->db->set('tmt_berlaku',$isi['tmt_berlaku']);
		$this->db->set('tst_berlaku',$isi['tst_berlaku']);
		$this->db->where('id_unor',$isi['id_unor']);
		$this->db->update('m_unor');
	}

	function cek_pegawai_unor($idd){
		$this->db->from('r_peg_jab');
		$this->db->where('id_unor',$idd);
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}

    function get_pejabat($idd){
		$this->db->from('rekap_peg');
		$this->db->where('id_unor',$idd);
		$this->db->where('jab_type','js');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}



}
