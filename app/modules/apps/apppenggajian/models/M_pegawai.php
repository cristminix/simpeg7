<?php
class M_pegawai extends CI_Model{
	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_master_pegawai($cari){
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (r_pegawai a)
		WHERE  (
		a.nip LIKE '$cari%'
		OR a.nip_baru LIKE '$cari%'
		OR a.nama_pegawai LIKE '%$cari%'
		)
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	function get_master_pegawai($cari,$mulai,$batas){
		$sqlstr="SELECT a.*
		FROM r_pegawai a
		WHERE  (
		a.nip LIKE '$cari%'
		OR a.nip_baru LIKE '$cari%'
		OR a.nama_pegawai LIKE '%$cari%'
		)
		ORDER BY a.nama_pegawai ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_pegawai($cari,$pns="all",$unor="all",$kode,$pkt,$jbt,$ese,$tugas,$gender,$agama,$status,$jenjang){
			if($pns=="all"){
				$iPns = "";	
			} elseif($pns=="kontrak"){	
				$iPns = "AND status_pegawai = 'Kontrak'";	
			} elseif($pns=="capeg") {	
				$iPns = "AND status_pegawai = 'Capeg'";	
			} elseif($pns=="tetap") {	
				$iPns = "AND status_pegawai = 'Tetap'";	
			}
			
			if($kode==""){
				if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND a.id_unor IN ($unor)";	}
			} else {
				$iUnor="AND a.kode_unor LIKE '$kode%'";
			}
			if($pkt==""){	$iPkt = "";	} else {	$iPkt = "AND a.kode_golongan='$pkt'";	}
			if($jbt==""){	$iJbt = "";	} else {	$iJbt = "AND a.jab_type='$jbt'";	}
			if($ese==""){	$iEse = "";	} else {	$iEse = "AND a.kode_ese='$ese'";	}
			if($tugas==""){	$iTugas = "";	} else {	$iTugas = "AND a.tugas_tambahan='$tugas'";	}
			if($gender==""){	$iGender = "";	} else {	$iGender = "AND a.gender='$gender'";	}
			if($agama==""){	$iAgama = "";	} else {	$iAgama = "AND a.agama='$agama'";	}
			if($status==""){	$iStatus = "";	} else {	$iStatus = "AND a.status_perkawinan='$status'";	}
			if($jenjang==""){	$iJenjang = "";	} else {	$iJenjang = "AND a.nama_jenjang='$jenjang'";	}

		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		WHERE  (
		a.nip_baru LIKE '$cari%'
		OR a.nama_pegawai LIKE '%$cari%'
		OR a.nomenklatur_pada LIKE '%$cari%'
		OR a.kode_unor LIKE '$cari%'
		)
		$iPns
		$iUnor
		$iPkt
		$iJbt
		$iEse
		$iTugas
		$iGender
		$iAgama
		$iStatus
		$iJenjang
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	function get_pegawai($cari,$mulai,$batas,$pns="all",$unor="all",$kode,$pkt,$jbt,$ese,$tugas,$gender,$agama,$status,$jenjang){
			if($pns=="all"){
				$iPns = "";	
			} elseif($pns=="kontrak"){	
				$iPns = "AND status_pegawai = 'Kontrak'";	
			} elseif($pns=="capeg") {	
				$iPns = "AND status_pegawai = 'Capeg'";	
			} elseif($pns=="tetap") {	
				$iPns = "AND status_pegawai = 'Tetap'";	
			}
			
			if($kode==""){
				if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND a.id_unor IN ($unor)";	}
			} else {
				$iUnor="AND a.kode_unor LIKE '$kode%'";
			}
			if($pkt==""){	$iPkt = "";	} else {	$iPkt = "AND a.kode_golongan='$pkt'";	}
			if($jbt==""){	$iJbt = "";	} else {	$iJbt = "AND a.jab_type='$jbt'";	}
			if($ese==""){	$iEse = "";	} else {	$iEse = "AND a.kode_ese='$ese'";	}
			if($tugas==""){	$iTugas = "";	} else {	$iTugas = "AND a.tugas_tambahan='$tugas'";	}
			if($gender==""){	$iGender = "";	} else {	$iGender = "AND a.gender='$gender'";	}
			if($agama==""){	$iAgama = "";	} else {	$iAgama = "AND a.agama='$agama'";	}
			if($status==""){	$iStatus = "";	} else {	$iStatus = "AND a.status_perkawinan='$status'";	}
			if($jenjang==""){	$iJenjang = "";	} else {	$iJenjang = "AND a.nama_jenjang='$jenjang'";	}

		$sqlstr="SELECT a.*
		FROM rekap_peg a
		WHERE  (
		a.nip_baru LIKE '$cari%'
		OR a.nama_pegawai LIKE '%$cari%'
		OR a.nomenklatur_pada LIKE '%$cari%'
		OR a.kode_unor LIKE '$cari%'
		)
		$iPns
		$iUnor
		$iPkt
		$iJbt
		$iEse
		$iTugas
		$iGender
		$iAgama
		$iStatus
		$iJenjang
		ORDER BY a.nama_pegawai
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function hitung_pegawai_duk($cari,$pns,$unor="all"){
			if($pns=="jfu"){	$iPns = "AND (jab_type='jfu' OR jab_type='js')";	} elseif($pns=="jft"){	$iPns = "AND jab_type='jft'";	} else {	$iPns = "AND jab_type='jft-staff'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		WHERE  (
		a.nip_baru LIKE '$cari%'
		OR a.nama_pegawai LIKE '%$cari%'
		OR a.nomenklatur_pada LIKE '%$cari%'
		)
		$iPns
		$iUnor
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	function get_pegawai_duk($cari,$mulai,$batas,$pns,$unor="all"){
			if($pns=="jfu"){	$iPns = "AND (jab_type='jfu' OR jab_type='js')";	} elseif($pns=="jft"){	$iPns = "AND jab_type='jft'";	} else {	$iPns = "AND jab_type='jft-staff'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT a.*
		FROM rekap_peg a
		WHERE  (
		a.nip_baru LIKE '$cari%'
		OR a.nama_pegawai LIKE '%$cari%'
		OR a.nomenklatur_pada LIKE '%$cari%'
		)
		$iPns
		$iUnor
		ORDER BY a.kode_golongan DESC,a.tmt_pangkat ASC,a.tmt_cpns ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
	function get_pegawai_by_nip($nip){
		$this->db->from('rekap_peg');
		$this->db->where('nip_baru',$nip);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
	 function ini_tetap($idd){
		$this->db->from('r_peg_tetap');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
	 function ini_capeg($idd){
		$this->db->from('r_peg_capeg');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
     function ini_kontrak($idd){
		$this->db->from('r_peg_kontrak');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
	function ini_cpns($idd){
		$this->db->from('r_peg_cpns');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function ini_pns($idd){
		$this->db->from('r_peg_pns');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function ini_pegawai($idd){
		$this->db->from('rekap_peg');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
////////////////////////////////////////////////////////////////////////////////////////////////
    function ini_pegawai_master($idd){
		$this->db->from('r_pegawai');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function ini_pegawai_foto($idd){
		$this->db->from('r_peg_foto');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function ini_pegawai_alamat($idd){
		$this->db->from('r_peg_alamat');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function ini_pegawai_pernikahan($idd){
		$this->db->from('r_peg_perkawinan');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_menikah','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
    function ini_pegawai_anak($idd){
		$this->db->from('r_peg_anak');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_lahir_anak','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
	
	 function ini_pegawai_orangtua($idd){
		$this->db->from('r_peg_orangtua');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_lahir_orangtua','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
    function ini_pegawai_pendidikan($idd){
		$this->db->from('r_peg_pendidikan');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_lulus','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
    function ini_pegawai_pangkat($idd){
		$this->db->from('r_peg_golongan');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tmt_golongan','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
	function ini_pegawai_sanksi($idd){
		$this->db->from('r_peg_sanksi');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_sk','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
	function ini_pegawai_penghargaan($idd){
		$this->db->from('r_peg_penghargaan');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_sk','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
	function ini_pegawai_kesehatan($idd){
		$this->db->from('r_peg_kesehatan');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_tes','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}

	function ini_pegawai_psikotes($idd){
		$this->db->from('r_peg_psikotes');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_tes','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
	
	function ini_pegawai_pengalaman($idd){
		$this->db->from('r_peg_pengalaman');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_akhir','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
	
	function ini_pegawai_diklat($idd){
		$this->db->from('r_peg_diklat');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tanggal_sk','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}

////////////////////////////////////////////////////////////////////////////////////////////////
    function ini_pangkat_riwayat($idd){
		$this->db->from('r_peg_golongan');
		$this->db->where('id_peg_golongan',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function pangkat_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_golongan');
		
		$riwayat = $this->ini_pegawai_pangkat($isi['id_pegawai']);
		$jab = end($riwayat);

		$this->db->set('tmt_pangkat',$jab->tmt_golongan);
		$this->db->set('kode_golongan',$jab->kode_golongan);
		$this->db->set('nama_golongan',$jab->nama_golongan);
		$this->db->set('kode_pangkat',$jab->kode_pangkat);
		$this->db->set('nama_pangkat',$jab->nama_pangkat);
		$this->db->set('mk_gol_tahun',$jab->mk_gol_tahun);
		$this->db->set('mk_gol_bulan',$jab->mk_gol_bulan);
		$this->db->where('id_pegawai',$jab->id_pegawai);
		$this->db->update('rekap_peg');
	}
    function pangkat_riwayat_edit_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->where('id_peg_golongan',$isi['id_peg_golongan']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_golongan');
		
		$riwayat = $this->ini_pegawai_pangkat($isi['id_pegawai']);
		$jab = end($riwayat);

		$this->db->set('tmt_pangkat',$jab->tmt_golongan);
		$this->db->set('kode_golongan',$jab->kode_golongan);
		$this->db->set('nama_golongan',$jab->nama_golongan);
		$this->db->set('kode_pangkat',$jab->kode_pangkat);
		$this->db->set('nama_pangkat',$jab->nama_pangkat);
		$this->db->set('mk_gol_tahun',$jab->mk_gol_tahun);
		$this->db->set('mk_gol_bulan',$jab->mk_gol_bulan);

		$this->db->where('id_pegawai',$jab->id_pegawai);
		$this->db->update('rekap_peg');
	}
    function pangkat_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_golongan',$isi['id_peg_golongan']);
		$this->db->delete('r_peg_golongan');
		
		$riwayat = $this->ini_pegawai_pangkat($isi['id_pegawai']);
		$jab = end($riwayat);

		$this->db->set('tmt_pangkat',$jab->tmt_golongan);
		$this->db->set('kode_golongan',$jab->kode_golongan);
		$this->db->set('nama_golongan',$jab->nama_golongan);
		$this->db->set('kode_pangkat',$jab->kode_pangkat);
		$this->db->set('nama_pangkat',$jab->nama_pangkat);
		$this->db->set('mk_gol_tahun',$jab->mk_gol_tahun);
		$this->db->set('mk_gol_bulan',$jab->mk_gol_bulan);

		$this->db->where('id_pegawai',$jab->id_pegawai);
		$this->db->update('rekap_peg');
	}
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
    function ini_sanksi_riwayat($idd){
		$this->db->from('r_peg_sanksi');
		$this->db->where('id_peg_sanksi',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function sanksi_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_sanksi');
		
		$riwayat = $this->ini_pegawai_sanksi($isi['id_pegawai']);
		$jab = end($riwayat);
		
	}
    function sanksi_riwayat_edit_aksi($isi){
		// echo($isi);
		foreach($isi AS $key=>$val){$this->db->set($key,$val);	}
		$this->db->where('id_peg_sanksi',$isi['id_peg_sanksi']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_sanksi');
		
	
	}
    function sanksi_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_sanksi',$isi['id_peg_sanksi']);
		$this->db->delete('r_peg_sanksi');
		
		
	}
////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    function ini_penghargaan_riwayat($idd){
		$this->db->from('r_peg_penghargaan');
		$this->db->where('id_peg_penghargaan',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function penghargaan_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_penghargaan');
		
		$riwayat = $this->ini_pegawai_penghargaan($isi['id_pegawai']);
		$jab = end($riwayat);
		
	}
    function penghargaan_riwayat_edit_aksi($isi){
		// echo($isi);
		foreach($isi AS $key=>$val){$this->db->set($key,$val);	}
		$this->db->where('id_peg_penghargaan',$isi['id_peg_penghargaan']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_penghargaan');
		
	
	}
    function penghargaan_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_penghargaan',$isi['id_peg_penghargaan']);
		$this->db->delete('r_peg_penghargaan');
		
		
	}
////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    function ini_kesehatan_riwayat($idd){
		$this->db->from('r_peg_kesehatan');
		$this->db->where('id_peg_kesehatan',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function kesehatan_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_kesehatan');
		
		$riwayat = $this->ini_pegawai_kesehatan($isi['id_pegawai']);
		$jab = end($riwayat);
		
	}
    function kesehatan_riwayat_edit_aksi($isi){
		// echo($isi);
		foreach($isi AS $key=>$val){$this->db->set($key,$val);	}
		$this->db->where('id_peg_kesehatan',$isi['id_peg_kesehatan']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_kesehatan');
		
	
	}
    function kesehatan_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_kesehatan',$isi['id_peg_kesehatan']);
		$this->db->delete('r_peg_kesehatan');
		
		
	}
////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////
    function ini_psikotes_riwayat($idd){
		$this->db->from('r_peg_psikotes');
		$this->db->where('id_peg_psikotes',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function psikotes_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_psikotes');
		
		$riwayat = $this->ini_pegawai_psikotes($isi['id_pegawai']);
		$jab = end($riwayat);
		
	}
    function psikotes_riwayat_edit_aksi($isi){
		// echo($isi);
		foreach($isi AS $key=>$val){$this->db->set($key,$val);	}
		$this->db->where('id_peg_psikotes',$isi['id_peg_psikotes']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_psikotes');
		
	
	}
    function psikotes_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_psikotes',$isi['id_peg_psikotes']);
		$this->db->delete('r_peg_psikotes');
		
		
	}
////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
    function ini_pengalaman_riwayat($idd){
		$this->db->from('r_peg_pengalaman');
		$this->db->where('id_peg_pengalaman',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function pengalaman_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_pengalaman');
		
		$riwayat = $this->ini_pegawai_pengalaman($isi['id_pegawai']);
		$jab = end($riwayat);
		
	}
    function pengalaman_riwayat_edit_aksi($isi){
		// echo($isi);
		foreach($isi AS $key=>$val){$this->db->set($key,$val);	}
		$this->db->where('id_peg_pengalaman',$isi['id_peg_pengalaman']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_pengalaman');
		
	
	}
    function pengalaman_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_pengalaman',$isi['id_peg_pengalaman']);
		$this->db->delete('r_peg_pengalaman');
		
		
	}
////////////////////////////////////////////////////////////////////////////////////////////////


    function ini_pegawai_jabatan($idd){
		$this->db->from('r_peg_jab');
		$this->db->where('id_pegawai',$idd);
		$this->db->order_by('tmt_jabatan','asc');
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}
    function ini_jabatan_riwayat($idd){
		$this->db->from('r_peg_jab');
		$this->db->where('id_peg_jab',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function jabatan_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_jab');
		
		$riwayat = $this->ini_pegawai_jabatan($isi['id_pegawai']);
		$jab = end($riwayat);

		$this->db->set('id_unor',$jab->id_unor);
		$this->db->set('kode_unor',$jab->kode_unor);
		$this->db->set('nama_unor',$jab->nama_unor);
		$this->db->set('nomenklatur_pada',$jab->nomenklatur_pada);
		$this->db->set('jab_type',$jab->nama_jenis_jabatan);
		$this->db->set('tmt_jabatan',$jab->tmt_jabatan);
		$this->db->set('nomenklatur_jabatan',$jab->nama_jabatan);
		// $this->db->set('kode_ese',$jab->kode_ese);
		// $this->db->set('nama_ese',$jab->nama_ese);
		$this->db->set('tugas_tambahan',$jab->tugas_tambahan);
		$this->db->where('id_pegawai',$jab->id_pegawai);
		$this->db->update('rekap_peg');
	}
    function jabatan_riwayat_edit_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->where('id_peg_jab',$isi['id_peg_jab']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_jab');
		
		$riwayat = $this->ini_pegawai_jabatan($isi['id_pegawai']);
		$jab = end($riwayat);

		$this->db->set('id_unor',$jab->id_unor);
		$this->db->set('kode_unor',$jab->kode_unor);
		$this->db->set('nama_unor',$jab->nama_unor);
		$this->db->set('nomenklatur_pada',$jab->nomenklatur_pada);
		$this->db->set('jab_type',$jab->nama_jenis_jabatan);
		$this->db->set('tmt_jabatan',$jab->tmt_jabatan);
		$this->db->set('nomenklatur_jabatan',$jab->nama_jabatan);
		// $this->db->set('kode_ese',$jab->kode_ese);
		// $this->db->set('nama_ese',$jab->nama_ese);
		$this->db->set('tugas_tambahan',$jab->tugas_tambahan);
		$this->db->where('id_pegawai',$jab->id_pegawai);
		$this->db->update('rekap_peg');
	}




    function jabatan_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_jab',$isi['id_peg_jab']);
		$this->db->delete('r_peg_jab');
		
		$riwayat = $this->ini_pegawai_jabatan($isi['id_pegawai']);
		$jab = end($riwayat);

		$this->db->set('id_unor',$jab->id_unor);
		$this->db->set('kode_unor',$jab->kode_unor);
		$this->db->set('nama_unor',$jab->nama_unor);
		$this->db->set('nomenklatur_pada',$jab->nomenklatur_pada);
		$this->db->set('jab_type',$jab->nama_jenis_jabatan);
		$this->db->set('tmt_jabatan',$jab->tmt_jabatan);
		$this->db->set('nomenklatur_jabatan',$jab->nama_jabatan);
		// $this->db->set('kode_ese',$jab->kode_ese);
		// $this->db->set('nama_ese',$jab->nama_ese);
		$this->db->where('id_pegawai',$jab->id_pegawai);
		$this->db->update('rekap_peg');
	}
//////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
    function ini_diklat_riwayat($idd){
		$this->db->from('r_peg_diklat');
		$this->db->where('id_peg_diklat',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
    function diklat_riwayat_tambah_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_diklat');
		
		$riwayat = $this->ini_pegawai_diklat($isi['id_pegawai']);
		$diklat = end($riwayat);

		// $this->db->set('nama_diklat',$jab->nama_diklat);
		// $this->db->set('tempat_diklat',$jab->tempat_diklat);
		// $this->db->set('nomor_sk',$jab->nomor_sk);
		// $this->db->set('tanggal_sk',$jab->tanggal_sk);
		// $this->db->set('tmt_diklat',$jab->tmt_diklat);
		// $this->db->set('tst_diklat',$jab->tst_diklat);
		// $this->db->where('id_pegawai',$jab->id_pegawai);
		// $this->db->update('rekap_peg');
	}
    function diklat_riwayat_edit_aksi($isi){
		foreach($isi AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->where('id_peg_diklat',$isi['id_peg_diklat']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->update('r_peg_diklat');
		
		$riwayat = $this->ini_pegawai_diklat($isi['id_pegawai']);
		$jab = end($riwayat);

		// $this->db->set('tmt_pangkat',$jab->tmt_golongan);
		// $this->db->set('kode_golongan',$jab->kode_golongan);
		// $this->db->set('nama_golongan',$jab->nama_golongan);
		// $this->db->set('nama_pangkat',$jab->nama_pangkat);
		// $this->db->set('mk_gol_tahun',$jab->mk_gol_tahun);
		// $this->db->set('mk_gol_bulan',$jab->mk_gol_bulan);

		// $this->db->where('id_pegawai',$jab->id_pegawai);
		// $this->db->update('rekap_peg');
	}
    function diklat_riwayat_hapus_aksi($isi){
		$this->db->where('id_peg_diklat',$isi['id_peg_diklat']);
		$this->db->delete('r_peg_diklat');
		
		$riwayat = $this->ini_pegawai_diklat($isi['id_pegawai']);
		$jab = end($riwayat);

		// $this->db->set('tmt_pangkat',$jab->tmt_golongan);
		// $this->db->set('kode_golongan',$jab->kode_golongan);
		// $this->db->set('nama_golongan',$jab->nama_golongan);
		// $this->db->set('nama_pangkat',$jab->nama_pangkat);
		// $this->db->set('mk_gol_tahun',$jab->mk_gol_tahun);
		// $this->db->set('mk_gol_bulan',$jab->mk_gol_bulan);

		// $this->db->where('id_pegawai',$jab->id_pegawai);
		// $this->db->update('rekap_peg');
	}
////////////////////////////////////////////////////////////////////////////////////////////////
	function userskp_setup_aksi($isi){
		$this->db->where('id_pegawai',$isi['id_pegawai']);
		$this->db->delete('user_pegawai');

		$this->db->where('group_id','7');
		$this->db->where('username',$isi['username']);
		$this->db->delete('users');

	        $this->db->set('group_id','7');
	        $this->db->set('username',$isi['username']);
	        $this->db->set('passwd',sha1($isi['username']));
	        $this->db->set('nama_user',$isi['nama']);
			$this->db->insert('users');
			$id_user = $this->db->insert_id();

			$this->db->set('user_id',$id_user);
			$this->db->set('id_pegawai',$isi['id_pegawai']);
			$this->db->insert('user_pegawai');
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_pegawai_pros($cari,$tab){
		$sqlstr="SELECT COUNT(a.id) AS numrows
		FROM (r_pegawai_$tab a)
		WHERE  (
		a.nama_pegawai LIKE '%$cari%'
		OR a.nip_baru LIKE '$cari%'
		)
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	function get_pegawai_pros($cari,$mulai,$batas,$tab){
		$sqlstr="SELECT a.*
		FROM r_pegawai_$tab a
		WHERE  (
		a.nama_pegawai LIKE '%$cari%'
		OR a.nip_baru LIKE '$cari%'
		)
		ORDER BY a.tanggal_$tab ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function ini_pegawai_meninggal($idd){
		$this->db->from('r_pegawai_meninggal');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function pros_meninggal_tambah_aksi($idd,$isi){
		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('tanggal_meninggal',date("Y-m-d", strtotime($idd['tanggal_meninggal'])));
		$this->db->set('tempat_meninggal',$idd['tempat_meninggal']);
		$this->db->set('sebab_meninggal',$idd['sebab_meninggal']);
		$this->db->set('var_rekap_peg',$isi);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_pegawai_meninggal');

		$this->db->set('status','meninggal');
		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->update('r_pegawai');

		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->delete('rekap_peg');
	}
	function pros_meninggal_edit_aksi($idd){
		$this->db->set('tanggal_meninggal',date("Y-m-d", strtotime($idd['tanggal_meninggal'])));
		$this->db->set('tempat_meninggal',$idd['tempat_meninggal']);
		$this->db->set('sebab_meninggal',$idd['sebab_meninggal']);
		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->update('r_pegawai_meninggal');
	}
	function pros_meninggal_hapus_aksi($idd){
		foreach($idd AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->insert('rekap_peg');

		$this->db->set('status','aktif');
		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->update('r_pegawai');

		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->delete('r_pegawai_meninggal');
	}
	function ini_pegawai_pensiun($idd){
		$this->db->from('r_pegawai_pensiun');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
	function pros_pensiun_tambah_aksi($idd,$isi){
		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('tanggal_pensiun',date("Y-m-d", strtotime($idd['tanggal_pensiun'])));
		$this->db->set('no_sk',$idd['no_sk']);
		$this->db->set('tanggal_sk',date("Y-m-d", strtotime($idd['tanggal_sk'])));
		$this->db->set('jenis_pensiun',$idd['jenis_pensiun']);
		$this->db->set('var_rekap_peg',$isi);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_pegawai_pensiun');

		$this->db->set('status','pensiun');
		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->update('r_pegawai');

		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->delete('rekap_peg');
	}
	function pros_pensiun_edit_aksi($idd){
		$this->db->set('tanggal_pensiun',date("Y-m-d", strtotime($idd['tanggal_pensiun'])));
		$this->db->set('no_sk',$idd['no_sk']);
		$this->db->set('tanggal_sk',date("Y-m-d", strtotime($idd['tanggal_sk'])));
		$this->db->set('jenis_pensiun',$idd['jenis_pensiun']);
		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->update('r_pegawai_pensiun');
	}
	function pros_pensiun_hapus_aksi($idd){
		foreach($idd AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->insert('rekap_peg');

		$this->db->set('status','aktif');
		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->update('r_pegawai');

		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->delete('r_pegawai_pensiun');
	}



	function ini_pegawai_keluar($idd){
		$this->db->from('r_pegawai_keluar');
		$this->db->where('id_pegawai',$idd);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
	function pros_keluar_tambah_aksi($idd,$isi){
		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('tanggal_keluar',date("Y-m-d", strtotime($idd['tanggal_keluar'])));
		$this->db->set('no_sk',$idd['no_sk']);
		$this->db->set('tanggal_sk',date("Y-m-d", strtotime($idd['tanggal_sk'])));
		$this->db->set('instansi_tujuan',$idd['instansi_tujuan']);
		$this->db->set('var_rekap_peg',$isi);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_pegawai_keluar');

		$this->db->set('status','keluar');
		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->update('r_pegawai');

		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->delete('rekap_peg');
	}
	function pros_keluar_edit_aksi($idd){
		$this->db->set('tanggal_keluar',date("Y-m-d", strtotime($idd['tanggal_keluar'])));
		$this->db->set('no_sk',$idd['no_sk']);
		$this->db->set('tanggal_sk',date("Y-m-d", strtotime($idd['tanggal_sk'])));
		$this->db->set('instansi_tujuan',$idd['instansi_tujuan']);
		$this->db->where('id_pegawai',$idd['id_pegawai']);
		$this->db->update('r_pegawai_keluar');
	}
	function pros_keluar_hapus_aksi($idd){
		foreach($idd AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->insert('rekap_peg');

		$this->db->set('status','aktif');
		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->update('r_pegawai');

		$this->db->where('id_pegawai',$idd->id_pegawai);
		$this->db->delete('r_pegawai_keluar');
	}

	function pros_penambahan_aksi($idd){
		foreach($idd AS $key=>$val){	$this->db->set($key,$val);	}
		$this->db->insert('r_pegawai');
		$id_pegawai = $this->db->insert_id();

		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('id_pegawai',$id_pegawai);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('nip',$idd['nip']);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('rekap_peg');
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_jfu($cari,$jenis="jfu"){
		$sqlstr="SELECT COUNT(a.id_jabatan) AS numrows
		FROM (m_jf a)
		WHERE  (
		a.nama_jabatan LIKE '%$cari%'
		OR a.kode_bkn LIKE '%$cari%'
		)
		AND jab_type = '$jenis'
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	function get_jfu($cari,$jenis="jfu",$mulai,$batas){
		$sqlstr="SELECT a.*
		FROM m_jf a
		WHERE  (
		a.nama_jabatan LIKE '%$cari%'
		OR a.kode_bkn LIKE '%$cari%'
		)
		AND jab_type = '$jenis'
		ORDER BY a.nama_jabatan ASC
		LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         PROSES INJEK K2
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function pros_injek_k2($idd){
		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('tempat_lahir',$idd['tempat_lahir']);
		$this->db->set('tanggal_lahir',$idd['tanggal_lahir']);
		$this->db->set('agama',$idd['agama']);
		$this->db->set('gender',$idd['gender']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('status','cpns');
		$this->db->insert('r_pegawai');

		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('tempat_lahir',$idd['tempat_lahir']);
		$this->db->set('tanggal_lahir',$idd['tanggal_lahir']);
		$this->db->set('agama',$idd['agama']);
		$this->db->set('gender',$idd['gender']);
		$this->db->set('tmt_pangkat',$idd['tmt_pangkat']);
		$this->db->set('nama_pangkat',$idd['nama_pangkat']);
		$this->db->set('nama_golongan',$idd['nama_golongan']);
		$this->db->set('kode_golongan',$idd['kode_golongan']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('status_kepegawaian','cpns');
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('rekap_peg');

		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('tmt_cpns',$idd['tmt_pangkat']);
		$this->db->set('sk_cpns_nomor',"CPNS K2 Tahun 2014");
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_cpns');

		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('nama_pangkat',$idd['nama_pangkat']);
		$this->db->set('nama_golongan',$idd['nama_golongan']);
		$this->db->set('kode_golongan',$idd['kode_golongan']);
		$this->db->set('sk_nomor',"CPNS K2 Tahun 2014");
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_peg_golongan');
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
//                         PROSES REKON PEGAWAI MASTER
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function formsub_pensiun_aksi($idd,$isi){
		$this->db->set('id_pegawai',$idd['id_pegawai']);
		$this->db->set('nip_baru',$idd['nip_baru']);
		$this->db->set('nama_pegawai',$idd['nama_pegawai']);
		$this->db->set('tanggal_pensiun',date("Y-m-d", strtotime($idd['tanggal_pensiun'])));
		$this->db->set('no_sk',$idd['no_sk']);
		$this->db->set('tanggal_sk',date("Y-m-d", strtotime($idd['tanggal_sk'])));
		$this->db->set('jenis_pensiun',$idd['jenis_pensiun']);
		$this->db->set('var_rekap_peg',$isi);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->insert('r_pegawai_pensiun');

	}


}
