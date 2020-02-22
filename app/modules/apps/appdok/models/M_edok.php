<?php
class M_edok extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function ini_pegawai($idpeg){
		$this->db->from('rekap_peg');
		$this->db->where('id_pegawai',$idpeg);
		$hslquery = $this->db->get()->row();
		return $hslquery;	
	}
	function ini_pendidikan($idd){
		$this->db->from('r_peg_pendidikan');
		$this->db->where('id_peg_pendidikan',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;	
	}
	function ini_capeg($idd){
		$this->db->from('r_peg_capeg');
		$this->db->where('id',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;	
	}
//////////////////////////////////////////////////////////////////////////////////
	function cek_dokumen($nip_baru,$tipe,$idd){
		$this->db->from('r_peg_dokumen');
		$this->db->where('nip_baru',$nip_baru);
		$this->db->where('tipe_dokumen',$tipe);
		$this->db->where('id_reff',$idd);
		$this->db->order_by('halaman_item_dokumen','ASC');
		$hslquery = $this->db->get()->result();
		return $hslquery;	
	}

	function simpan_dokumen($nip_baru,$nama_file,$tipe,$idd){
		$ini = $this->cek_dokumen($nip_baru,$tipe,$idd);
		$hal = count($ini)+1;
		
			$sqlstr="INSERT INTO r_peg_dokumen (nip_baru,tipe_dokumen,file_thumb,file_dokumen,halaman_item_dokumen,id_reff) 
			VALUES ('$nip_baru','$tipe','thumb_".$nama_file."','$nama_file','$hal','$idd')";		
			$this->db->query($sqlstr);
	}

	function ini_dokumen($idd){
		$this->db->from('r_peg_dokumen');
		$this->db->where('id_dokumen',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function hapus_dokumen($idd,$id_peg,$komponen,$id_reff){
		$this->db->delete('r_peg_dokumen', array('id_dokumen' => $idd));
		
		$dok = $this->cek_dokumen($id_peg,$komponen,$id_reff);
		foreach($dok AS $key=>$val){
			$sqlstr="UPDATE r_peg_dokumen SET halaman_item_dokumen='".($key+1)."' WHERE id_dokumen='".$val->id_dokumen."'";		
			$this->db->query($sqlstr);
		}
		return $dok;
	}

	function edit_keterangan_dokumen($isi){
		$this->db->set('keterangan',$isi['keterangan']);
		$this->db->set('sub_keterangan',$isi['sub_keterangan']);
		$this->db->where('id_dokumen',$isi['idd']);
		$this->db->update('r_peg_dokumen');
	}

	function cek_pasfoto($nip_baru){
		$this->db->from('r_peg_dokumen');
		$this->db->where('nip_baru',$nip_baru);
		$this->db->where('tipe_dokumen','pasfoto');
		$hslquery = $this->db->get()->row();
		return $hslquery;	
	}

	function cek_foto_lama($idd){
		$this->db->from('r_peg_foto');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;	
	}


	function simpan_pasfoto($nip_baru,$nama_file,$tipe,$idd){
		$ini = $this->cek_pasfoto($nip_baru);
		if(empty($ini)){
			$sqlstr="INSERT INTO r_peg_dokumen (nip_baru,tipe_dokumen,file_thumb,file_dokumen,id_reff) 
			VALUES ('$nip_baru','$tipe','thumb_".$nama_file."','$nama_file','$idd')";		
			$this->db->query($sqlstr);
		} else {
			$sqlstr="UPDATE r_peg_dokumen SET file_thumb='thumb_".$nama_file."',file_dokumen='$nama_file' WHERE nip_baru='$nip_baru' AND tipe_dokumen='$tipe'";		
			$this->db->query($sqlstr);
		}
	}

}
