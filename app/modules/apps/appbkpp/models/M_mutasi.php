<?php
class M_mutasi extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////

    function get_pejabat_rancangan($idd,$idr){
		$this->db->from('p_mut_rancangan_pemangku');
		$this->db->where('id_unor',$idd);
		$this->db->where('id_rancangan',$idr);
		$this->db->order_by('no_duk','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}

    function get_rancangan(){
		$this->db->from('p_mut_rancangan');
		$this->db->order_by('id_rancangan','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}

    function ini_rancangan($idd){
		$this->db->from('p_mut_rancangan');
		$this->db->where('id_rancangan',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

    function rancangan_edit_aksi($idd){
		$this->db->set('nama_rancangan',$idd['nama_rancangan']);
		$this->db->set('tahun',$idd['tahun']);
		$this->db->set('periode',$idd['tmt_jabatan']);
		$this->db->where('id_rancangan',$idd['id_rancangan']);
		$this->db->update('p_mut_rancangan');
	}

    function rancangan_hapus_aksi($idd){
		$this->db->where('id_rancangan',$idd['id_rancangan']);
		$this->db->delete('p_mut_rancangan');

		$this->db->where('id_rancangan',$idd['id_rancangan']);
		$this->db->delete('p_mut_rancangan_pemangku');
	}

    function rancangan_baru_aksi($idd){
		$tmt = date("Y-m-d", strtotime($idd['tmt_jabatan']));
		$this->db->set('nama_rancangan',$idd['nama_rancangan']);
		$this->db->set('tahun',$idd['tahun']);
		$this->db->set('periode',$tmt);
		$this->db->insert('p_mut_rancangan');
		$id_rancangan = $this->db->insert_id();

		$pemangku = $this->get_pegawai_duk();
		$no=1;
		foreach($pemangku AS $key=>$val){
			$this->db->set('id_rancangan',$id_rancangan);
			$this->db->set('id_pegawai',$val->id_pegawai);
			$this->db->set('nip',$val->nip);
			$this->db->set('nip_baru',$val->nip_baru);
			$this->db->set('nama_pegawai',$val->nama_pegawai);
			$this->db->set('gelar_nonakademis',$val->gelar_nonakademis);
			$this->db->set('gelar_depan',$val->gelar_depan);
			$this->db->set('gelar_belakang',$val->gelar_belakang);
			$this->db->set('gender',$val->gender);
			$this->db->set('tempat_lahir',$val->tempat_lahir);
			$this->db->set('tanggal_lahir',$val->tanggal_lahir);
			$this->db->set('agama',$val->agama);
			$this->db->set('status_perkawinan',$val->status_perkawinan);
			$this->db->set('status_kepegawaian',$val->status_kepegawaian);
			$this->db->set('nomor_telepon',$val->nomor_telepon);
			$this->db->set('tmt_cpns',$val->tmt_cpns);
			$this->db->set('tmt_pns',$val->tmt_pns);
			$this->db->set('id_pangkat',$val->id_pangkat);
			$this->db->set('kode_golongan',$val->kode_golongan);
			$this->db->set('nama_golongan',$val->nama_golongan);
			$this->db->set('nama_pangkat',$val->nama_pangkat);
			$this->db->set('tmt_pangkat',$val->tmt_pangkat);
			$this->db->set('mk_gol_tahun',$val->mk_gol_tahun);
			$this->db->set('mk_gol_bulan',$val->mk_gol_bulan);
			$this->db->set('id_unor',$val->id_unor);
			$this->db->set('kode_unor',$val->kode_unor);
			$this->db->set('nama_unor',$val->nama_unor);
			$this->db->set('jab_type',$val->jab_type);
			$this->db->set('nomenklatur_jabatan',$val->nomenklatur_jabatan);
			$this->db->set('nomenklatur_pada',$val->nomenklatur_pada);
			$this->db->set('tugas_tambahan',$val->tugas_tambahan);
			$this->db->set('tmt_jabatan',$val->tmt_jabatan);
			$this->db->set('kode_ese',$val->kode_ese);
			$this->db->set('nama_ese',$val->nama_ese);
			$this->db->set('tmt_ese',$val->tmt_ese);
			$this->db->set('id_pendidikan',$val->id_pendidikan);
			$this->db->set('nama_pendidikan',$val->nama_pendidikan);
			$this->db->set('pend_jurusan',$val->pend_jurusan);
			$this->db->set('nama_sekolah',$val->nama_sekolah);
			$this->db->set('nama_jenjang',$val->nama_jenjang);
			$this->db->set('nama_jenjang_rumpun',$val->nama_jenjang_rumpun);
			$this->db->set('tanggal_lulus',$val->tanggal_lulus);
			$this->db->set('tahun_lulus',$val->tahun_lulus);
			$this->db->set('nama_diklat_struk',$val->nama_diklat_struk);
			$this->db->set('tanggal_sttpl_diklat_struk',$val->tanggal_sttpl_diklat_struk);
			$this->db->set('bup',$val->bup);
			$this->db->set('no_duk',$no);
			$this->db->set('last_updated',$val->last_updated);
			$this->db->insert('p_mut_rancangan_pemangku');
			$no++;
		}
	}

	function get_pegawai_duk(){
		$sqlstr="SELECT a.*
		FROM rekap_peg a
		WHERE jab_type='js'
		ORDER BY a.kode_golongan DESC,a.tmt_pangkat ASC,a.kode_ese DESC,a.tmt_ese ASC,a.tmt_cpns ASC";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function cek_jabatan_pegawai($idd,$idr){
		$this->db->from('p_mut_rancangan_pemangku');
		$this->db->where('id_pegawai',$idd);
		$this->db->where('id_rancangan',$idr);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

    function mutasi($idd,$idp,$idr){
		$unor = $this->ini_unor($idp['id_unor']);
		$tmt = date("Y-m-d", strtotime($idp['tmt_jabatan']));

		$this->db->set('nama_pegawai',$idd->nama_pegawai);
		$this->db->set('gelar_depan',$idd->gelar_depan);
		$this->db->set('gelar_belakang',$idd->gelar_belakang);
		$this->db->set('gelar_nonakademis',$idd->gelar_nonakademis);
		$this->db->set('gender',$idd->gender);
		$this->db->set('tempat_lahir',$idd->tempat_lahir);
		$this->db->set('tanggal_lahir',$idd->tanggal_lahir);
		$this->db->set('agama',$idd->agama);
		$this->db->set('nip',$idd->nip);
		$this->db->set('nip_baru',$idd->nip_baru);

		$this->db->set('nama_pangkat',$idd->nama_pangkat);
		$this->db->set('nama_golongan',$idd->nama_golongan);
		$this->db->set('tmt_pangkat',$idd->tmt_pangkat);
		$this->db->set('tmt_pns',$idd->tmt_pns);
		$this->db->set('tmt_cpns',$idd->tmt_cpns);

		$this->db->set('tmt_jabatan',$tmt);
		$this->db->set('tmt_ese',$idd->tmt_ese);
		$this->db->set('id_unor',$unor->id_unor);
		$this->db->set('kode_unor',$unor->kode_unor);
		$this->db->set('nama_unor',$unor->nama_unor);
		$this->db->set('nomenklatur_jabatan',$unor->nomenklatur_jabatan);
		$this->db->set('nomenklatur_pada',$unor->nomenklatur_pada);
		// $this->db->set('kode_ese',$unor->kode_ese);
		// $this->db->set('nama_ese',$unor->nama_ese);
		$this->db->set('jab_type','js');

		$this->db->where('id_rancangan',$idr);
		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->update('p_mut_rancangan_pemangku');
	}

    function promosi($idd,$idp,$idr){
		$unor = $this->ini_unor($idp['id_unor']);
		$tmt = date("Y-m-d", strtotime($idp['tmt_jabatan']));

		$this->db->set('nama_pegawai',$idd->nama_pegawai);
		$this->db->set('gelar_depan',$idd->gelar_depan);
		$this->db->set('gelar_belakang',$idd->gelar_belakang);
		$this->db->set('gelar_nonakademis',$idd->gelar_nonakademis);
		$this->db->set('gender',$idd->gender);
		$this->db->set('tempat_lahir',$idd->tempat_lahir);
		$this->db->set('tanggal_lahir',$idd->tanggal_lahir);
		$this->db->set('agama',$idd->agama);
		$this->db->set('nip',$idd->nip);
		$this->db->set('nip_baru',$idd->nip_baru);

		$this->db->set('nama_pangkat',$idd->nama_pangkat);
		$this->db->set('nama_golongan',$idd->nama_golongan);
		$this->db->set('tmt_pangkat',$idd->tmt_pangkat);
		$this->db->set('tmt_pns',$idd->tmt_pns);
		$this->db->set('tmt_cpns',$idd->tmt_cpns);

		$this->db->set('tmt_jabatan',$tmt);
		$this->db->set('tmt_ese',$idd->tmt_ese);
		$this->db->set('id_unor',$unor->id_unor);
		$this->db->set('kode_unor',$unor->kode_unor);
		$this->db->set('nama_unor',$unor->nama_unor);
		$this->db->set('nomenklatur_jabatan',$unor->nomenklatur_jabatan);
		$this->db->set('nomenklatur_pada',$unor->nomenklatur_pada);
		// $this->db->set('kode_ese',$unor->kode_ese);
		// $this->db->set('nama_ese',$unor->nama_ese);
		$this->db->set('jab_type','js');

		$this->db->set('id_pegawai',$idd->id_pegawai);
		$this->db->set('id_rancangan',$idr);
		$this->db->insert('p_mut_rancangan_pemangku');
	}

	function ini_unor($idd){
		$this->db->from('m_unor');
		$this->db->where('id_unor',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}


}
