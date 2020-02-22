<?php
class M_pendidikan extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function ini_pendidikan($idd){
		$this->db->from('m_pendidikan');
		$this->db->where('id_pendidikan',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hitung_pendidikan($cari,$jenjang){
		$iJenjang = ($jenjang=="")?"":" AND kode_jenjang='$jenjang'";
		$sqlstr="SELECT COUNT(a.id_pendidikan) AS numrows
		FROM (m_pendidikan a)
		WHERE  (
		a.nama_pendidikan LIKE '%$cari%'
		)
		$iJenjang
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pendidikan($cari,$mulai,$batas,$jenjang){
		$iJenjang = ($jenjang=="")?"":" AND kode_jenjang='$jenjang'";
		$sqlstr="
		SELECT a.*
		FROM m_pendidikan a
		WHERE  (
		a.nama_pendidikan LIKE '%$cari%'
		)
		$iJenjang
		ORDER BY a.kode_bkn ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function edit_aksi($isi){
	$kode = $isi['kode_jenjang'];
		
		$sql2="SELECT * FROM m_pendidikan_jenjang WHERE kode_jenjang = $kode ";
		$get2= $this->db->query($sql2)->result();

			foreach($get2 as $row2){
				$nama_jenjang=$row2->nama_jenjang;		
				$nama_jenjang_rumpun=$row2->nama_jenjang_rumpun;		
			}
			
	$this->db->set('kode_jenjang',$kode);
		$this->db->set('nama_pendidikan',$isi['nama_pendidikan']);
		$this->db->set('kode_bkn',$isi['kode_bkn']);
		$this->db->set('nama_jenjang',$nama_jenjang);
		$this->db->set('nama_jenjang_rumpun',$nama_jenjang_rumpun);
		$this->db->where('id_pendidikan',$isi['idd']);
		$this->db->update('m_pendidikan');
	}

    function tambah_aksi($isi){
		$kode = $isi['kode_jenjang'];
		
		$sql2="SELECT * FROM m_pendidikan_jenjang WHERE kode_jenjang = $kode ";
		$get2= $this->db->query($sql2)->result();

			foreach($get2 as $row2){
				$nama_jenjang=$row2->nama_jenjang;		
				$nama_jenjang_rumpun=$row2->nama_jenjang_rumpun;		
			}
			
		$this->db->set('kode_jenjang',$kode);
		$this->db->set('nama_pendidikan',$isi['nama_pendidikan']);
		$this->db->set('kode_bkn',$isi['kode_bkn']);
		$this->db->set('nama_jenjang',$nama_jenjang);
		$this->db->set('nama_jenjang_rumpun',$nama_jenjang_rumpun);
		$this->db->insert('m_pendidikan');
		
		
		
	}
	
    function hapus_aksi($isi){
		$this->db->delete('m_pendidikan', array('id_pendidikan' => $isi['idd']));
	}


}
