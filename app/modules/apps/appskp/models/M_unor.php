<?php
class M_unor extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_master_unor($cari){
		$sqlstr="SELECT COUNT(a.id_unor) AS numrows
FROM (m_unor a)
WHERE  (
a.kode_unor LIKE '$cari%'
OR a.nama_unor LIKE '%$cari%'
)
";
/*
WHERE CHAR_LENGTH(a.kode_unor) = 5
*/

		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_master_unor($cari,$mulai,$batas){
		$sqlstr="
SELECT a.*
FROM m_unor a
WHERE  (
a.kode_unor LIKE '$cari%'
OR a.nama_unor LIKE '%$cari%'
)
ORDER BY a.kode_unor ASC
LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}




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
		$this->db->from('user a');
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
LEFT JOIN (rekap_peg b,user c)
ON (a.id_pegawai=b.id_pegawai AND c.user_id=a.user_id)
WHERE b.nama_pegawai LIKE '%$cari%'
ORDER BY a.user_id DESC
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



/*
('a.unor_akses'))
(".json_decode("a.unor_akses").")
$iid="310,302";
WHERE d.id_unor IN (a.unor_akses)
AND d.nomenklatur_pada LIKE '%$cari%'


WHERE d.nomenklatur_pada LIKE '%$cari%'
		$sqlstr="SELECT GROUP_CONCAT(nomenklatur_pada separator ', ') as FF 
		FROM m_unor 
		WHERE id_unor IN ($iid)";


		$sqlstr="
SELECT GROUP_CONCAT(nomenklatur_pada separator ', ') AS ff
FROM (user_verifikatur a)
LEFT JOIN (m_unor d)
ON (d.id_unor IN (a.unor_akses))
LIMIT $mulai,$batas";

		$sqlstr="
SELECT a.*,b.nama_pegawai,b.gelar_depan,b.gelar_nonakademis,b.gelar_belakang,b.nip_baru,c.username
FROM (user_verifikatur a)
LEFT JOIN (rekap_peg b,user c)
ON (a.id_pegawai=b.id_pegawai AND c.user_id=a.user_id)
LIMIT $mulai,$batas";

		$sqlstrf="SELECT nomenklatur_pada FROM m_unor WHERE id_unor='301'";



SELECT GROUP_CONCAT(nomenklatur_pada) FROM m_unor WHERE id_unor IN (a.unor_akses) 
WHERE (SELECT GROUP_CONCAT(d.nomenklatur_pada) FROM m_unor d WHERE d.id_unor IN (a.unor_akses) ) LIKE '%$cari%'
,GROUP_CONCAT(d.nomenklatur_jabatan) as FF
WHERE GROUP_CONCAT(d.nomenklatur_jabatan) LIKE %$cari%
WHERE GROUP_CONCAT(d.nomenklatur_jabatan) FROM m_unor d WHERE  d.id_unor IN (a.unor_akses)
		$sqlstrb="
SELECT a.*,b.nama_pegawai,b.gelar_depan,b.gelar_nonakademis,b.gelar_belakang,b.nip_baru,c.username
FROM (user_verifikatur a)
LEFT JOIN (rekap_peg b,user c)
ON (a.id_pegawai=b.id_pegawai AND c.user_id=a.user_id)
LIMIT $mulai,$batas";
*/
/*
		$sqlstrb="SELECT COUNT(*) AS `numrows`
FROM (user_verifikatur a)
LEFT JOIN (rekap_peg b,user c)
ON (a.id_pegawai=b.id_pegawai AND c.user_id=a.user_id)";
*/

	function get_unor_in($id_unor){
		$sqlstr="SELECT nama_unor,nomenklatur_pada,kode_unor FROM m_unor WHERE id_unor IN ($id_unor) ORDER BY kode_unor ASC";
		$hslquery = $this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function get_daftar($cari="",$mulai,$batas){
		$this->db->select('id_unor,kode_unor,nama_unor,nomenklatur_jabatan,nomenklatur_pada');
		if($cari!=""){
			$this->db->like('kode_unor', $cari,'after');
			$this->db->or_like('nomenklatur_jabatan',$cari);
			$this->db->or_like('nomenklatur_pada', $cari);
		}
		$this->db->from('m_unor');
		$this->db->order_by('kode_unor','asc');
		$this->db->limit($batas, $mulai);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function hitung_daftar($cari=""){
		if($cari!=""){
			$this->db->like('kode_unor', $cari,'after');
			$this->db->or_like('nomenklatur_jabatan',$cari);
			$this->db->or_like('nomenklatur_pada', $cari);
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
		$this->db->join('user c','a.user_id=c.user_id','left');
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

		$this->db->set('group_id',5);
		$this->db->set('username',$isi['username']);
		$this->db->set('nama_user',$petugas->nama_pegawai);
		$this->db->set('passwd',sha1($isi['username']));
		$this->db->insert('user');
		$user_id = $this->db->insert_id();

		$this->db->set('user_id',$user_id);
		$this->db->set('id_pegawai',$petugas->id_pegawai);
		$this->db->set('unor_akses','{}');
		$this->db->insert('user_verifikatur');
	}

	function hitung_pengelola($cari){
/*
		$this->db->from('user a');
		$this->db->where('a.group_id',3);
		return $this->db->count_all_results();
*/
		$sqlstr="SELECT COUNT(a.user_id) AS numrows
FROM (user a)
WHERE a.group_id=3
AND (username LIKE '%$cari%' OR nama_user LIKE '%$cari%')
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pengelola($cari,$mulai,$batas){
		$sqlstr="SELECT *
FROM (user a)
WHERE a.group_id=3
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
		$this->db->join('user c','a.user_id=c.user_id','left');
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}

	function ini_pengelola($idd){
		$this->db->from('user a');
		$this->db->join('user_umpeg b','a.user_id=b.user_id','left');
		$this->db->where('a.user_id',$idd);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function pengelola_tambah_aksi($isi){
        $this->db->set('username',$isi['username']);
        $this->db->set('nama_user',$isi['nama_user']);
        $this->db->set('group_id',3);
        $this->db->set('passwd',sha1($isi['username']));
		$this->db->insert('user');
		$user_id = $this->db->insert_id();

        $this->db->set('unor_akses',"{}");
        $this->db->set('user_id',$user_id);
		$this->db->insert('user_umpeg');
	}

	function pengelola_edit_aksi($isi){
        $this->db->set('username',$isi['username']);
        $this->db->set('nama_user',$isi['nama_user']);
        $this->db->where('user_id',$isi['user_id']);
		$this->db->update('user');
	}

	function pengelola_hapus_aksi($isi){
        $this->db->where('user_id',$isi['user_id']);
		$this->db->delete('user');
        $this->db->where('user_id',$isi['user_id']);
		$this->db->delete('user_umpeg');
	}

	function setup_pengelola_aksi($isi){
		$this->db->set('unor_akses',$isi['unor_pil']);
		$this->db->where('user_id',$isi['user_id']);
		$this->db->update('user_umpeg');
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
	function ini_user_pegawai($id_pegawai){
/*
		$sqlstr="SELECT b.id_pegawai,b.nama_pegawai,b.nip_baru,b.nomenklatur_jabatan,b.gelar_depan,b.gelar_nonakademis,b.gelar_belakang,a.user_id
LEFT JOIN (rekap_peg b) ON (a.id_pegawai=b.id_pegawai)
$carib
*/
		$this->db->from('user a');
		$this->db->join('user_pegawai b','a.user_id=b.user_id','left');
		$this->db->where('b.id_pegawai',$id_pegawai);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function ini_user($userid){
		$this->db->select('a.*,b.group');
		$this->db->from('user a');
		$this->db->join('user_group b','a.group_id=b.group_id','left');
		$this->db->where('a.user_id',$userid);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function ganti_password($isi){
        $this->db->set('passwd',sha1($isi['pw1']));
        $this->db->where('user_id',$isi['user_id']);
		$this->db->update('user');
	}


}
