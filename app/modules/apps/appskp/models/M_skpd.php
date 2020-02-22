<?php
class M_skpd extends CI_Model{
	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
	}
//////////////////////////////////////////////////////////////////////////////////
    function editutama_aksi($isi){
		$this->db->set('nama_unor',$isi['nama_unor']);
		$this->db->set('jenis',$isi['jenis']);
		$this->db->set('kode_ese',$isi['kode_ese']);
		$this->db->set('nama_ese',$isi['nama_ese']);
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
		$this->db->set('nama_ese',$isi['nama_ese']);
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
	function get_tupoksi($id_unor,$tipe){
		$this->db->select('isi_tupoksi');
		$this->db->from('tupoksi_jabatan');
		$this->db->where('id_unor',$id_unor);
		$this->db->where('tipe',$tipe);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function ini_verifikatur($user_id){
		$this->db->from('users a');
		$this->db->join('user_verifikatur b','a.user_id=b.user_id');
		$this->db->where('a.user_id',$user_id);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}
	function get_verifikatur_idpegawai($id_pegawai){
		$this->db->from('user_verifikatur');
		$this->db->where('id_pegawai',$id_pegawai);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function get_verifikatur($cari,$mulai,$batas){
		$sqlstr="
SELECT a.*,b.nama_pegawai,b.gelar_depan,b.gelar_nonakademis,b.gelar_belakang,b.nip_baru,c.username
FROM (user_verifikatur a)
LEFT JOIN (rekap_peg b,users c)
ON (a.id_pegawai=b.id_pegawai AND c.user_id=a.user_id)
WHERE b.nama_pegawai LIKE '%$cari%'
ORDER BY a.user_id DESC
LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function hitung_verifikatur($cari){
		$sqlstr="SELECT COUNT(a.user_id) AS numrows
FROM (user_verifikatur a)
LEFT JOIN (rekap_peg b,users c)
ON (a.id_pegawai=b.id_pegawai AND c.user_id=a.user_id)
WHERE b.nama_pegawai LIKE '%$cari%'
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function verifikatur_lihat($cari,$id_unor,$mulai,$batas){
		$sqlstr="
SELECT *
FROM m_unor WHERE id_unor IN ($id_unor) 
AND (kode_unor LIKE '$cari%' OR nama_unor LIKE '%$cari%' OR nomenklatur_pada LIKE '%$cari%' OR nomenklatur_cari LIKE '%$cari%' OR nomenklatur_jabatan LIKE '%$cari%')
ORDER BY kode_unor ASC
LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function hitung_verifikatur_lihat($cari,$id_unor){
		$sqlstr="SELECT COUNT(id_unor) AS numrows FROM m_unor WHERE id_unor IN ($id_unor)
		AND (kode_unor LIKE '$cari%' OR nama_unor LIKE '%$cari%' OR nomenklatur_pada LIKE '%$cari%' OR nomenklatur_cari LIKE '%$cari%' OR nomenklatur_jabatan LIKE '%$cari%')";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}


	function get_unor_in($id_unor){
		$sqlstr="SELECT nama_unor,nomenklatur_pada,kode_unor FROM m_unor WHERE id_unor IN ($id_unor) ORDER BY kode_unor ASC";
		$hslquery = $this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function get_daftar($cari="",$mulai,$batas,$sekarang_saja="ya"){
		
		$this->db->select('id_unor,kode_unor,nama_unor,nomenklatur_jabatan,nomenklatur_pada');
		if($cari!=""){
			$this->db->like('kode_unor', $cari,'after');
			$this->db->or_like('nomenklatur_jabatan',$cari);
			$this->db->or_like('nomenklatur_pada', $cari);
		}
		if($sekarang_saja=="ya"){
			$tanggal = date("Y-m-d");
			$this->db->where('tmt_berlaku <=', $tanggal);
			$this->db->where('tst_berlaku >=', $tanggal);
		}
		$this->db->from('m_unor');
		$this->db->order_by('kode_unor','asc');
		$this->db->limit($batas, $mulai);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function hitung_daftar($cari="",$sekarang_saja="ya"){
		if($cari!=""){
			$this->db->like('kode_unor', $cari,'after');
			$this->db->or_like('nomenklatur_jabatan',$cari);
			$this->db->or_like('nomenklatur_pada', $cari);
		}
		if($sekarang_saja=="ya"){
			$tanggal = date("Y-m-d");
			$this->db->where('tmt_berlaku <=', $tanggal);
			$this->db->where('tst_berlaku >=', $tanggal);
		}
		$this->db->from('m_unor');
		return $this->db->count_all_results();
	}

	function get_unor_verifikatur($id_unor){
		$this->db->select('a.user_id,b.nama_pegawai,b.gelar_depan,b.gelar_nonakademis,b.gelar_belakang,c.username');
			$this->db->like('a.unor_akses','{'.$id_unor.',');
			$this->db->or_like('a.unor_akses','{'.$id_unor.'}');
			$this->db->or_like('a.unor_akses',','.$id_unor.',');
			$this->db->or_like('a.unor_akses',','.$id_unor.'}');
		$this->db->from('user_verifikatur a');
		$this->db->join('rekap_peg b','a.id_pegawai=b.id_pegawai','left');
		$this->db->join('users c','a.user_id=c.user_id','left');
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function setup_verifikatur_aksi($isi){
		$this->db->set('unor_akses',$isi['unor_pil']);
		$this->db->where('user_id',$isi['user_id']);
		$this->db->update('user_verifikatur');
	}
//////////////////////////////////////////////////////////////////////
	function ini_pegawai($id_pegawai){
		$this->db->from('rekap_peg');
		$this->db->where('id_pegawai',$id_pegawai);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function get_pegawai_by_nip($nip){
		$this->db->from('rekap_peg');
		$this->db->where('nip_baru',$nip);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////
	function setup_petugas_aksi($isi){
		$petugas = $this->get_pegawai_by_nip($isi['nip_baru']);

		$this->db->set('group_id',477);
		$this->db->set('username',$isi['username']);
		$this->db->set('nama_user',$petugas->nama_pegawai);
		$this->db->set('passwd',sha1($isi['username']));
		$this->db->insert('users');
		$user_id = $this->db->insert_id();

		$this->db->set('user_id',$user_id);
		$this->db->set('id_pegawai',$petugas->id_pegawai);
		$this->db->set('unor_akses','{}');
		$this->db->insert('user_verifikatur');
	}

	function hitung_pengelola($cari){
		$sqlstr="SELECT COUNT(a.user_id) AS numrows
FROM (users a)
WHERE a.group_id=6
AND (username LIKE '%$cari%' OR nama_user LIKE '%$cari%')
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pengelola($cari,$mulai,$batas){
		$sqlstr="SELECT *
FROM (users a)
WHERE a.group_id=6
AND (username LIKE '%$cari%' OR nama_user LIKE '%$cari%')
ORDER BY nama_user ASC
LIMIT $mulai,$batas
";
		$hslquery = $this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function get_unor_pengelola($id_unor){
		$this->db->select('a.user_id,c.*');
			$this->db->like('a.unor_akses','{'.$id_unor.',');
			$this->db->or_like('a.unor_akses','{'.$id_unor.'}');
			$this->db->or_like('a.unor_akses',','.$id_unor.',');
			$this->db->or_like('a.unor_akses',','.$id_unor.'}');
		$this->db->from('user_umpeg a');
		$this->db->join('users c','a.user_id=c.user_id','left');
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function ini_pengelola($idd){
		$this->db->from('users a');
		$this->db->join('user_umpeg b','a.user_id=b.user_id','left');
		$this->db->where('a.user_id',$idd);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function pengelola_tambah_aksi($isi){
        $this->db->set('username',$isi['username']);
        $this->db->set('nama_user',$isi['nama_user']);
        $this->db->set('group_id',6);
        $this->db->set('passwd',sha1($isi['username']));
		$this->db->insert('users');
		$user_id = $this->db->insert_id();

        $this->db->set('unor_akses',"{}");
        $this->db->set('user_id',$user_id);
		$this->db->insert('user_umpeg');
	}

	function pengelola_edit_aksi($isi){
        $this->db->set('username',$isi['username']);
        $this->db->set('nama_user',$isi['nama_user']);
        $this->db->set('passwd',sha1($isi['username']));
        $this->db->where('user_id',$isi['user_id']);
		$this->db->update('users');
	}

	function pengelola_hapus_aksi($isi){
        $this->db->where('user_id',$isi['user_id']);
		$this->db->delete('users');
        $this->db->where('user_id',$isi['user_id']);
		$this->db->delete('user_umpeg');
	}

	function setup_pengelola_aksi($isi){
		$this->db->set('unor_akses',$isi['unor_pil']);
		$this->db->where('user_id',$isi['user_id']);
		$this->db->update('user_umpeg');
	}





	function hitung_pegawai_skp($cari){
		$sqlstr="SELECT COUNT(a.user_id) AS numrows
FROM (users a)
WHERE a.group_id=7
AND (username LIKE '%$cari%' OR nama_user LIKE '%$cari%')
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pegawai_skp($cari,$mulai,$batas){
//LEFT JOIN (rekap_peg c) ON (a.username=c.nip_baru)
		$sqlstr="SELECT a.*,d.*
FROM users a
LEFT JOIN (user_pegawai c,rekap_peg d) ON (a.user_id=c.user_id AND c.id_pegawai=d.id_pegawai) 
WHERE a.group_id=7
AND (a.username LIKE '%$cari%' OR a.nama_user LIKE '%$cari%')
ORDER BY a.user_id ASC
LIMIT $mulai,$batas
";
		$hslquery = $this->db->query($sqlstr)->result();
		return $hslquery;
	}












	function hitung_pegawai($cari){
$carib = ($cari=="")?"":"WHERE (b.nama_pegawai LIKE '%$cari%' OR b.nip_baru LIKE '%$cari%' OR b.nomenklatur_jabatan LIKE '%$cari%' OR b.nomenklatur_pada LIKE '%$cari%' OR b.tempat_lahir LIKE '%$cari%' OR b.kode_unor LIKE '$cari%')";
		$sqlstr="SELECT COUNT(b.id_pegawai) AS numrows
FROM (rekap_peg b)
$carib
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pegawai($cari,$mulai,$batas){
$carib = ($cari=="")?"":"WHERE (b.nama_pegawai LIKE '%$cari%' OR b.nip_baru LIKE '%$cari%' OR b.nomenklatur_jabatan LIKE '%$cari%' OR b.nomenklatur_pada LIKE '%$cari%' OR b.tempat_lahir LIKE '%$cari%' OR b.kode_unor LIKE '$cari%')";
		$sqlstr="SELECT b.*
FROM (rekap_peg b)
$carib
ORDER BY b.kode_unor ASC
LIMIT $mulai,$batas
";
		$hslquery = $this->db->query($sqlstr)->result();
		return $hslquery;
	}


	function ini_user_pegawai_skp($id_user){
		$this->db->from('users a');
		$this->db->join('user_pegawai b','a.user_id=b.user_id','left');
		$this->db->where('a.user_id',$id_user);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}



	function ini_user_pegawai($id_pegawai){
		$this->db->from('users a');
		$this->db->join('user_pegawai b','a.user_id=b.user_id','left');
		$this->db->where('b.id_pegawai',$id_pegawai);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function ini_user($userid){
//		$this->db->select('a.*,b.group');
		$this->db->from('users a');
//		$this->db->join('user_group b','a.group_id=b.group_id','left');
		$this->db->where('a.user_id',$userid);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function ganti_password($isi){
        $this->db->set('passwd',sha1($isi['pw1']));
        $this->db->where('user_id',$isi['user_id']);
		$this->db->update('users');
	}


	function get_pantau_target($cari,$mulai,$batas,$tahun="",$unor=""){
		if($tahun==""){	$iTahun="";	}else{	$iTahun="AND tahun='$tahun'";	}
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="AND id_unor IN ($uUnor)";	}
		$sqlstr="SELECT *
FROM p_skp
WHERE  (nama_pegawai  LIKE '%$cari%'
OR  nip_baru  LIKE '%$cari%'
OR  nomenklatur_jabatan  LIKE '%$cari%'
OR  nomenklatur_pada  LIKE '%$cari%'
OR  penilai_nama_pegawai  LIKE '%$cari%'
OR  penilai_nip_baru  LIKE '%$cari%'
OR  penilai_nomenklatur_jabatan  LIKE '%$cari%'
OR  penilai_nomenklatur_pada  LIKE '%$cari%')
$iTahun
$iUnor
ORDER BY (id_unor)
LIMIT $mulai,$batas";

		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function hitung_pantau_target($cari,$tahun="",$unor=""){
		if($tahun==""){	$iTahun="";	}else{	$iTahun="AND tahun='$tahun'";	}
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="AND id_unor IN ($uUnor)";	}
		$sqlstr="SELECT COUNT(id_skp) AS `numrows`
FROM (`p_skp`)
WHERE  (`nama_pegawai`  LIKE '%$cari%'
OR  `nip_baru`  LIKE '%$cari%'
OR  `nomenklatur_jabatan`  LIKE '%$cari%'
OR  `nomenklatur_pada`  LIKE '%$cari%'
OR  `penilai_nama_pegawai`  LIKE '%$cari%'
OR  `penilai_nip_baru`  LIKE '%$cari%'
OR  `penilai_nomenklatur_jabatan`  LIKE '%$cari%'
OR  `penilai_nomenklatur_pada`  LIKE '%$cari%')
$iTahun
$iUnor
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pantau_realisasi($cari,$mulai,$batas,$tahun="",$unor=""){
		if($tahun==""){	$iTahun="";	}else{	$iTahun="AND b.tahun='$tahun'";	}
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="AND a.id_unor IN ($uUnor)";	}
		$sqlstr="
SELECT a.*,b.status AS status
FROM (p_skp_realisasi_tahapan b)
LEFT JOIN (p_skp a)
ON (a.id_skp=b.id_skp)
WHERE b.status!='draft'
AND (a.nama_pegawai  LIKE '%$cari%'
OR  a.nip_baru  LIKE '%$cari%'
OR  a.nomenklatur_jabatan  LIKE '%$cari%'
OR  a.nomenklatur_pada  LIKE '%$cari%'
OR  a.penilai_nama_pegawai  LIKE '%$cari%'
OR  a.penilai_nip_baru  LIKE '%$cari%'
OR  a.penilai_nomenklatur_jabatan  LIKE '%$cari%'
OR  a.penilai_nomenklatur_pada  LIKE '%$cari%')
$iTahun
$iUnor
ORDER BY (a.id_unor)
LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function hitung_pantau_realisasi($cari,$tahun="",$unor=""){
		if($tahun==""){	$iTahun="";	}else{	$iTahun="AND b.tahun='$tahun'";	}
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="AND a.id_unor IN ($uUnor)";	}
		$sqlstr="SELECT COUNT(a.id_skp) AS numrows
FROM (p_skp_realisasi_tahapan b)
LEFT JOIN (p_skp a)
ON (a.id_skp=b.id_skp)
WHERE b.status!='draft'
AND (a.nama_pegawai  LIKE '%$cari%'
OR  a.nip_baru  LIKE '%$cari%'
OR  a.nomenklatur_jabatan  LIKE '%$cari%'
OR  a.nomenklatur_pada  LIKE '%$cari%'
OR  a.penilai_nama_pegawai  LIKE '%$cari%'
OR  a.penilai_nip_baru  LIKE '%$cari%'
OR  a.penilai_nomenklatur_jabatan  LIKE '%$cari%'
OR  a.penilai_nomenklatur_pada  LIKE '%$cari%')
$iTahun
$iUnor
";

		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function hitung_pantau_target_non($cari="",$tahun="",$unor=""){
//		if($tahun==""){	$iTahun="";	}else{	$iTahun="AND tahun='$tahun'";	}
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="id_unor IN ($uUnor) AND ";	}
		$iPegawai=$this->pegawai_skp_in($cari,$tahun,$unor);
		$sqlstr="SELECT COUNT(id_pegawai) AS `numrows`
FROM (`rekap_peg`)
WHERE $iUnor id_pegawai NOT IN ($iPegawai)";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pantau_target_non($cari="",$mulai,$batas,$tahun="",$unor=""){
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="id_unor IN ($uUnor) AND ";	}
		$iPegawai=$this->pegawai_skp_in($cari,$tahun,$unor);
		$sqlstr="SELECT *
FROM (`rekap_peg`)
WHERE $iUnor id_pegawai NOT IN ($iPegawai)
ORDER BY (id_unor)
LIMIT $mulai,$batas";

		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}



	function unor_in($kode){
		$sqlstr="SELECT id_unor	FROM (m_unor) WHERE kode_unor LIKE '$kode%' ORDER BY (kode_unor)";
		$unor=$this->db->query($sqlstr)->result();
		
		$in_unor="";
		foreach($unor as $key=>$val){
			if($key==0){$in_unor=$in_unor.$val->id_unor;}else{$in_unor=$in_unor.",".$val->id_unor;}
		}
		return $in_unor;
	}

	function pegawai_skp_in($cari="",$tahun="",$unor=""){
		if($tahun==""){	$iTahun="";	}else{	$iTahun="WHERE tahun='$tahun'";	}
		if($unor==""){	$iUnor="";	}else{	$uUnor=$this->unor_in($unor); $iUnor="AND id_unor IN ($uUnor)";	}
		$sqlstr="SELECT id_pegawai FROM (p_skp) $iTahun $iUnor";
		$pegawai=$this->db->query($sqlstr)->result();
		
		$in_pegawai="";
		foreach($pegawai as $key=>$val){
			if($key==0){$in_pegawai=$in_pegawai.$val->id_pegawai;}else{$in_pegawai=$in_pegawai.",".$val->id_pegawai;}
		}
		return $in_pegawai;
	}

}
