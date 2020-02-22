<?php
class M_bebankerja extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function get_tupoksi($id_unor,$tipe,$jab="js",$idj=""){
		$this->db->select('id_tupoksi,isi_tupoksi');
		$this->db->from('m_pekerjaan');
		$this->db->where('id_unor',$id_unor);
		if($jab=="js"){
			$this->db->where('jab_type',$jab);
		} else {
			$this->db->where('id_jabatan',$idj);
		}
		$this->db->order_by("urutan", "asc");
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function detail_tupoksi($id_tupoksi){
		$this->db->select('isi_tupoksi');
		$this->db->from('tupoksi_jabatan');
		$this->db->where('id_tupoksi',$id_tupoksi);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function get_jabatan_rekap_peg($id_unor){
		$sqlstr="SELECT DISTINCT jab_type FROM rekap_peg WHERE id_unor=$id_unor";
		$hslquery=$this->db->query($sqlstr)->result();

		return $hslquery;
	}

	function get_jab_unor($id_unor,$jenis){
		if($jenis=="js"){
			$sqlstr="SELECT DISTINCT nomenklatur_jabatan FROM rekap_peg WHERE id_unor='$id_unor' AND jab_type='$jenis'";
		} else {
			$sqlstr="SELECT DISTINCT a.nomenklatur_jabatan,b.id_jabatan
			FROM rekap_peg a
			LEFT JOIN (m_jf b) ON (a.nomenklatur_jabatan=b.nama_jabatan AND a.jab_type=b.jab_type)
			WHERE a.id_unor='$id_unor' AND a.jab_type='$jenis'";
		}

		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function detail_unor($id_unor,$jenis){
		if($jenis=="js"){
			$sqlstr="SELECT nomenklatur_jabatan FROM m_unor WHERE id_unor='$id_unor'";
		} else {
			$sqlstr="SELECT DISTINCT a.nomenklatur_jabatan,b.id_jabatan
			FROM rekap_peg a
			LEFT JOIN (m_jf b) ON (a.nomenklatur_jabatan=b.nama_jabatan AND a.jab_type=b.jab_type)
			WHERE a.id_unor='$id_unor' AND a.jab_type='$jenis'";
		}

		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}


	function get_jab_non_ese($id_unor,$id_jabatan,$jenis){
		if($jenis=="jft" || $jenis=="jfu"){
			$sqlstr="SELECT a.nomenklatur_pada,b.nama_jabatan AS nomenklatur_jabatan
			FROM m_unor a
			LEFT JOIN (m_jf b) ON (b.id_jabatan=$id_jabatan)
			WHERE a.id_unor='$id_unor'";
		} else {
			$sqlstr="SELECT a.nomenklatur_pada,b.nama AS nomenklatur_jabatan
			FROM m_unor a
			LEFT JOIN (m_jft_guru b) ON (b.id_jft_guru=$id_jabatan)
			WHERE a.id_unor='$id_unor'";
		}
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function tambah_aksi($isi){
		$this->db->set('isi_tupoksi',$isi['isi_tupoksi']); 
		$this->db->set('id_unor',$isi['idd']);
		$this->db->set('jab_type',$isi['jab_type']);
		$this->db->set('tipe',$isi['tipe']);
		if($isi['jab_type']!="js"){
			$this->db->set('id_jabatan',$isi['idj']);
		}
		$this->db->insert('tupoksi_jabatan');
	}
    function edit_aksi($isi){
		$this->db->set('isi_tupoksi',$isi['isi_tupoksi']); 
		$this->db->where('id_tupoksi',$isi['idt']);
		$this->db->update('tupoksi_jabatan');
	}
    function hapus_aksi($isi){
		$this->db->delete('tupoksi_jabatan', array('id_tupoksi' => $isi['idt']));
	}

}
