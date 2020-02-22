<?php
class M_tarif extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function editutama_aksi($isi){
		$this->db->set('nama_unor',$isi['nama_unor']);
		$this->db->set('jenis',$isi['jenis']);
		$this->db->set('kode_ese',$isi['kode_ese']);
		$this->db->set('nomenklatur_jabatan',$isi['nomenklatur_jabatan']);
		$this->db->set('nomenklatur_pada',$isi['nomenklatur_pada']);
		$this->db->set('nomenklatur_cari',$isi['nomenklatur_cari']);
		$this->db->set('kode_unor',$isi['kode_unor']);
		$this->db->where('id_unor',$isi['idd']);
		$this->db->update('m_unor');
	}

    function tambahutama_aksi($isi){
		$this->db->set('id_parent',$isi['idparent']); 
		$this->db->set('nama_unor',$isi['nama_unor']);
		$this->db->set('jenis',$isi['jenis']);
		$this->db->set('kode_ese',$isi['kode_ese']);
		$this->db->set('nomenklatur_jabatan',$isi['nomenklatur_jabatan']);
		$this->db->set('nomenklatur_pada',$isi['nomenklatur_pada']);
		$this->db->set('nomenklatur_cari',$isi['nomenklatur_cari']);
		$this->db->set('kode_unor',$isi['kode_unor']);
		$this->db->insert('m_unor');
	}
	
    function hapusutama_aksi($isi){
		$this->db->delete('m_unor', array('id_unor' => $isi['idd']));
	}


    function editutama_aksi_konvensi($id_unor=false,$isi=array()){
		$this->db->set('nama_unor',$isi['nama_unor']);
		$this->db->set('jenis',$isi['jenis']);
		$this->db->set('kode_ese',$isi['kode_ese']);
		$this->db->set('nomenklatur_jabatan',$isi['nomenklatur_jabatan']);
		$this->db->set('nomenklatur_pada',$isi['nomenklatur_pada']);
		$this->db->set('nomenklatur_cari',$isi['nomenklatur_cari']);
		$this->db->set('kode_unor',$isi['kode_unor']);
		if(!$id_unor){ // insert action
			$this->db->set('id_parent',$isi['idparent']); 
			$result = $this->db->insert('m_unor');
		}else{ //update action
			$this->db->where('id_unor',$isi['idd']);
			$result = $this->db->update('m_unor');
		}
		return $result;
	}

    function get_tupoksi_byunor($id_unor=false){
		if(is_array($id_unor)){
			if(count($id_unor) > 0){
				$this->db->where_in('id_unor',$id_unor);
				$result = $this->db->get()->result();
			}else{
				$result = false;
			}
		}else{
			$this->db->where('id_unor',$id_unor);
			$result = $this->db->get()->row();
		}
		
		if(! $result){
			return array();
		}else{
			return $data;
		}
	}


	function get_tarif($id_unor,$tipe){
		if($tipe=="js"){
			$sqlstr="SELECT tarif FROM m_tarif WHERE id_unor='$id_unor' AND jab_type='js'";
		} else {
			$sqlstr="SELECT a.tarif,b.nama_jabatan AS nomenklatur_jabatan
			FROM m_tarif a
			LEFT JOIN (m_jf b) ON (b.id_jabatan=a.id_jabatan)
			WHERE a.id_unor='$id_unor' AND a.jab_type='$tipe'";
		}
		$hslquery=$this->db->query($sqlstr)->result();

		return $hslquery;
	}


}
