<?php
class M_main extends CI_Model{
	function __construct(){
		parent::__construct();
	}
////////////////////////////////Titipan dari Halaman Login///////////////////////////////////
/// ---> PEGAWAI
	function hitung_pegawai($id_skpd_hir,$sub="ya"){
			$sess = $this->session->userdata('logged_in');
		if($id_skpd_hir=="xx" || $sess['scoop']=="xx"){
			$and1=" ";
		} else {
			$hunor = $sess['scoop'];
			$and1=" WHERE id_unor IN ($hunor)";
		}
		$query=$this->db->query("SELECT count(id_pegawai) as count_peg FROM rekap_peg $and1"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_peg'];
		return $hslrow;
	}

	function get_pegawai($id_skpd_hir,$mulai,$batas){
			$sess = $this->session->userdata('logged_in');
		if($id_skpd_hir=="xx" || $sess['scoop']=="xx"){
			$and1=" ";
		} else {
			$hunor = $sess['scoop'];
			$and1=" WHERE a.id_unor IN ($hunor)";
		}


		$sqlstr="SELECT a.*,
			DATE_FORMAT(a.tanggal_lahir,'%d-%m-%Y') AS tanggal_lahir,
			DATE_FORMAT(a.tmt_cpns,'%d-%m-%Y') AS tmt_cpns,
			DATE_FORMAT(a.tmt_pns,'%d-%m-%Y') AS tmt_pns,
			DATE_FORMAT(a.tmt_pangkat,'%d-%m-%Y') AS tmt_pangkat,
			DATE_FORMAT(a.tmt_jabatan,'%d-%m-%Y') AS tmt_jabatan
			FROM rekap_peg a
			$and1
			LIMIT $mulai,$batas";
		$res = $this->db->query($sqlstr)->result();
		return $res;

	}

/// ---> JABATAN
	function get_pemangku_jabatan($id_skpd_hir){
		$sqlstr="SELECT a.id_pegawai, a.nama_lengkap, a.jabatan_nama
		FROM rekap_peg a
		WHERE a.id_skpd_hir=$id_skpd_hir
		ORDER BY a.id_pangkat DESC";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
/// ---> SKPD
	function get_skpd_master($id_parent,$mulai,$batas){
		$this->db->select('a.*');
		$this->db->from('m_skpd a');
		$this->db->where('a.id_parent', $id_parent);
		$this->db->order_by('a.urutan','asc');
		$this->db->limit($mulai);
		$this->db->limit($batas);
		$res = $this->db->get()->result();
		return $res;
	}
	function get_unor($id_parent,$mulai,$batas){
		$this->db->select('a.*');
		$this->db->from('m_unor a');
		// $this->db->join('m_jab_struk b','a.kode_ese=b.kode','left');
		$this->db->where('a.id_parent', $id_parent);
		$this->db->order_by('a.kode_unor','asc');
		$this->db->limit($mulai);
		$this->db->limit($batas);
		$res = $this->db->get()->result();
		return $res;
	}
	function get_unor_all(){
		$this->db->select('a.*');
		// $this->db->select('b.nama_ese');
		$this->db->from('m_unor a');
		// $this->db->join('m_jab_struk b','a.kode_ese=b.kode','left');
		$this->db->order_by('a.kode_unor','asc');
		$res = $this->db->get()->result();
		return $res;
	}
	function detailunor($id_unor){
		$this->db->select('a.*');
		$this->db->from('m_unor a');
		$this->db->where('a.id_unor', $id_unor);
		$res = $this->db->get()->result();
		return $res;
	}

	function detail_unor($id_skpd_hir){
		$this->db->select('a.*');
		$this->db->from('m_unor a');
		$this->db->join('m_jab_struk b','a.kode_ese=b.kode','left');
		$this->db->where('a.id_unor', $id_skpd_hir);
		$res = $this->db->get()->result();
		return $res;
	}

	function get_eselon(){
		$this->db->select('*');
		$this->db->from('m_jab_struk');
		$res = $this->db->get()->result();
		return $res;
	}



	function get_skpd_sotk($id_parent,$id_sotk){
		$this->db->select('a.*');
		$this->db->from('m_skpd_hir a');
		$this->db->where('a.id_parent', $id_parent);
		$this->db->where('a.id_skpd_aturan', $id_sotk);
		$this->db->order_by('a.nama_lengkap','asc');
		$res = $this->db->get()->result();
		return $res;
	}

	function get_skpd_by_jenis($id_skpd_jenis_hir,$id_parent,$mulai,$batas){
		$this->db->select('a.*');
		$this->db->from('m_skpd_hir a');
		$this->db->where('a.id_parent', $id_parent);
		$this->db->where('a.id_skpd_aturan', 4);
		if($id_skpd_jenis_hir!="xx"){
			$this->db->where('a.id_skpd_jenis_hir', $id_skpd_jenis_hir);
		}
		$this->db->order_by('a.urutan','asc');
		$this->db->limit($mulai);
		$this->db->limit($batas);
		$res = $this->db->get()->result();
		return $res;
	}

	function get_jenis_skpd($id_parent,$mulai,$batas){
		$this->db->select('*');
		$this->db->from('m_skpd_jenis_hir');
		$this->db->where('id_parent', $id_parent);
		$this->db->order_by('urutan','asc');
		$this->db->limit($mulai);
		$this->db->limit($batas);
		$res = $this->db->get()->result();
		return $res;
	}
	function detail_jenis_skpd($idd){
		$this->db->select('*');
		$this->db->from('m_skpd_jenis_hir');
		$this->db->where('id_skpd_jenis_hir', $idd);
		$res = $this->db->get()->result();
		return $res;
	}

	function get_sotk(){
		$this->db->select('a.*');
		$this->db->from('m_skpd_aturan a');
		$res = $this->db->get()->result();
		return $res;
	}


}
