<?php
class M_skp extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function get_skp($id_pegawai){
		$this->db->from('p_skp');
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->order_by('tahun','asc');
		$this->db->order_by('bulan_mulai','asc');
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}
	function get_skp_kelola($id_pegawai){
		$this->db->from('p_skp');
		$this->db->where('id_penilai',$id_pegawai);
		$this->db->having('status','aju_penilai');
		$this->db->or_having('status','koreksi_penilai');
		$this->db->order_by('id_skp','asc');
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}


	function get_unor_akses(){
		$user_id = $this->session->userdata('user_id');
		$this->db->select('unor_akses');
		$this->db->from('user_verifikatur');
		$this->db->where('user_id',$user_id);
		$hslquery = $this->db->get()->row();
		return $hslquery->unor_akses;
	}


	function get_skp_verifikasi($cari,$mulai,$batas){
		$unor_akses = $this->get_unor_akses();
		$d = array('{','}');
		$id_unor = ($unor_akses=="{}")?"01":str_replace($d,'',$unor_akses);
		$sqlstr="SELECT *
FROM p_skp
WHERE id_unor IN  ($id_unor)
AND (`status`='aju_verifikatur')
AND  (nama_pegawai  LIKE '%$cari%'
OR  nip_baru  LIKE '%$cari%'
OR  nomenklatur_jabatan  LIKE '%$cari%'
OR  nomenklatur_pada  LIKE '%$cari%'
OR  penilai_nama_pegawai  LIKE '%$cari%'
OR  penilai_nip_baru  LIKE '%$cari%'
OR  penilai_nomenklatur_jabatan  LIKE '%$cari%'
OR  penilai_nomenklatur_pada  LIKE '%$cari%')
ORDER BY (id_unor)
LIMIT $mulai,$batas";

/*
		$this->db->where('id_penilai',$id_pegawai);
		$this->db->where('status','aju_penilai');
		if($cari!=""){
		$this->db->like('nama_pegawai', $cari);
		$this->db->or_like('nip_baru', $cari);
		$this->db->or_like('nomenklatur_jabatan', $cari);
		$this->db->or_like('nomenklatur_pada', $cari);
		$this->db->or_like('penilai_nama_pegawai', $cari);
		$this->db->or_like('penilai_nip_baru', $cari);
		$this->db->or_like('penilai_nomenklatur_jabatan', $cari);
		$this->db->or_like('penilai_nomenklatur_pada', $cari);
		}
		$this->db->order_by('tahun','asc');
		$this->db->order_by('id_skp','asc');
		$this->db->limit($batas, $mulai);
		$this->db->from('p_skp');
		$hslquery = $this->db->get()->result();
*/

		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}
	function hitung_skp_verifikasi($cari){
		$unor_akses = $this->get_unor_akses();
		$d = array('{','}');
		$id_unor = ($unor_akses=="{}")?"01":str_replace($d,'',$unor_akses);
		$sqlstr="SELECT COUNT(id_skp) AS `numrows`
FROM (`p_skp`)
WHERE `id_unor` IN  ($id_unor)
AND (`status`='aju_verifikatur')
AND  (`nama_pegawai`  LIKE '%$cari%'
OR  `nip_baru`  LIKE '%$cari%'
OR  `nomenklatur_jabatan`  LIKE '%$cari%'
OR  `nomenklatur_pada`  LIKE '%$cari%'
OR  `penilai_nama_pegawai`  LIKE '%$cari%'
OR  `penilai_nip_baru`  LIKE '%$cari%'
OR  `penilai_nomenklatur_jabatan`  LIKE '%$cari%'
OR  `penilai_nomenklatur_pada`  LIKE '%$cari%')";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
/*
//		$this->db->where('status','aju_penilai');
		if($cari!=""){
		$this->db->like('nama_pegawai', $cari);
		$this->db->or_like('nip_baru', $cari);
		$this->db->or_like('nomenklatur_jabatan', $cari);
		$this->db->or_like('nomenklatur_pada', $cari);
		$this->db->or_like('penilai_nama_pegawai', $cari);
		$this->db->or_like('penilai_nip_baru', $cari);
		$this->db->or_like('penilai_nomenklatur_jabatan', $cari);
		$this->db->or_like('penilai_nomenklatur_pada', $cari);
		}
		$this->db->from('p_skp');
		return $this->db->count_all_results();
*/
	}

	function get_realisasi_verifikasi($cari,$mulai,$batas){
		$unor_akses = $this->get_unor_akses();
		$d = array('{','}');
		$id_unor = ($unor_akses=="{}")?"01":str_replace($d,'',$unor_akses);
		$sqlstr="
SELECT a.*,b.status AS status
FROM (p_skp a)
LEFT JOIN (p_skp_realisasi_tahapan b)
ON (a.id_skp=b.id_skp)
WHERE a.id_unor IN  ($id_unor)
AND (b.status='aju_verifikatur' OR b.status='koreksi_verifikatur')
AND  (a.nama_pegawai  LIKE '%$cari%'
OR  a.nip_baru  LIKE '%$cari%'
OR  a.nomenklatur_jabatan  LIKE '%$cari%'
OR  a.nomenklatur_pada  LIKE '%$cari%'
OR  a.penilai_nama_pegawai  LIKE '%$cari%'
OR  a.penilai_nip_baru  LIKE '%$cari%'
OR  a.penilai_nomenklatur_jabatan  LIKE '%$cari%'
OR  a.penilai_nomenklatur_pada  LIKE '%$cari%')
ORDER BY (id_unor)
LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
/*
		if($cari!=""){
			$this->db->like('a.nama_pegawai', $cari);
			$this->db->or_like('a.nip_baru', $cari);
			$this->db->or_like('a.nomenklatur_jabatan', $cari);
			$this->db->or_like('a.nomenklatur_pada', $cari);
			$this->db->or_like('a.penilai_nama_pegawai', $cari);
			$this->db->or_like('a.penilai_nip_baru', $cari);
			$this->db->or_like('a.penilai_nomenklatur_jabatan', $cari);
			$this->db->or_like('a.penilai_nomenklatur_pada', $cari);
		}
		$this->db->select('a.id_skp,a.tahun,a.bulan_mulai,a.bulan_selesai');
		$this->db->select('a.nama_pegawai,a.gelar_depan,a.gelar_belakang,a.gelar_nonakademis');
		$this->db->select('a.nip_baru,a.nomenklatur_jabatan,a.nomenklatur_pada,a.nama_pangkat,a.nama_golongan');
		$this->db->select('a.penilai_nama_pegawai,a.penilai_gelar_depan,a.penilai_gelar_belakang,a.penilai_gelar_nonakademis');
		$this->db->select('a.penilai_nip_baru,a.penilai_nomenklatur_jabatan,a.penilai_nomenklatur_pada,a.penilai_nama_pangkat,a.penilai_nama_golongan');
		$this->db->select('b.status');
		$this->db->from('p_skp a');
		$this->db->join('p_skp_realisasi_tahapan b', 'a.id_skp = b.id_skp');
			$this->db->where('a.id_unor','314');
		$this->db->order_by('a.tahun','asc');
		$this->db->order_by('a.id_skp','asc');
		$this->db->limit($batas, $mulai);
		$hslquery = $this->db->get()->result();

		return $hslquery;
*/
	}
	function hitung_realisasi_verifikasi($cari){
		$unor_akses = $this->get_unor_akses();
		$d = array('{','}');
		$id_unor = ($unor_akses=="{}")?"01":str_replace($d,'',$unor_akses);
		$sqlstr="SELECT COUNT(a.id_skp) AS numrows
FROM (p_skp a)
LEFT JOIN (p_skp_realisasi_tahapan b)
ON (a.id_skp=b.id_skp)
WHERE a.id_unor IN  ($id_unor)
AND (b.status='aju_verifikatur' OR b.status='koreksi_verifikatur')
AND  (a.nama_pegawai  LIKE '%$cari%'
OR  a.nip_baru  LIKE '%$cari%'
OR  a.nomenklatur_jabatan  LIKE '%$cari%'
OR  a.nomenklatur_pada  LIKE '%$cari%'
OR  a.penilai_nama_pegawai  LIKE '%$cari%'
OR  a.penilai_nip_baru  LIKE '%$cari%'
OR  a.penilai_nomenklatur_jabatan  LIKE '%$cari%'
OR  a.penilai_nomenklatur_pada  LIKE '%$cari%')";

		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
/*
			$this->db->where('id_unorr','314');
		if($cari!=""){
			$this->db->like('nama_pegawai', $cari);
			$this->db->or_like('nip_baru', $cari);
			$this->db->or_like('nomenklatur_jabatan', $cari);
			$this->db->or_like('nomenklatur_pada', $cari);
			$this->db->or_like('penilai_nama_pegawai', $cari);
			$this->db->or_like('penilai_nip_baru', $cari);
			$this->db->or_like('penilai_nomenklatur_jabatan', $cari);
			$this->db->or_like('penilai_nomenklatur_pada', $cari);
		}
		$this->db->from('p_skp');
		return $this->db->count_all_results();
*/
	}




	function ini_skp($id_skp){
		$this->db->from('p_skp');
		$this->db->where('id_skp',$id_skp);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}


	function get_realisasi_kelola($id_pegawai){
		$this->db->from('p_skp a');
		$this->db->join('p_skp_realisasi_tahapan b', 'a.id_skp = b.id_skp', 'left');
		$this->db->where('a.id_penilai',$id_pegawai);
		$this->db->where('b.status','aju_penilai');
		$this->db->order_by('a.id_skp','asc');
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}


	function get_pegawai($id_pegawai){
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

	function set_skp($isi,$pegawai,$penilai){
		$this->db->set('tahun',$isi['tahun']);
		$this->db->set('bulan_mulai',$isi['bulan_mulai']);
		$this->db->set('bulan_selesai',$isi['bulan_selesai']);
		$this->db->set('id_pegawai',$pegawai->id_pegawai);
		$this->db->set('nip_baru',$pegawai->nip_baru);
		$this->db->set('nama_pegawai',$pegawai->nama_pegawai);
		$this->db->set('gelar_nonakademis',$pegawai->gelar_nonakademis);
		$this->db->set('gelar_depan',$pegawai->gelar_depan);
		$this->db->set('gelar_belakang',$pegawai->gelar_belakang);
		$this->db->set('gelar_depan',$pegawai->gelar_depan);
		$this->db->set('nama_golongan',$pegawai->nama_golongan);
		$this->db->set('nama_pangkat',$pegawai->nama_pangkat);
		$this->db->set('id_unor',$pegawai->id_unor);
		$this->db->set('nomenklatur_jabatan',$pegawai->nomenklatur_jabatan);
		$this->db->set('nomenklatur_pada',$pegawai->nomenklatur_pada);
		$this->db->set('tugas_tambahan',$pegawai->tugas_tambahan);
		$this->db->set('nama_ese',$pegawai->nama_ese);
		$this->db->set('id_penilai',$penilai->id_pegawai);
		$this->db->set('penilai_nip_baru',$penilai->nip_baru);
		$this->db->set('penilai_nama_pegawai',$penilai->nama_pegawai);
		$this->db->set('penilai_gelar_nonakademis',$penilai->gelar_nonakademis);
		$this->db->set('penilai_gelar_depan',$penilai->gelar_depan);
		$this->db->set('penilai_gelar_belakang',$penilai->gelar_belakang);
		$this->db->set('penilai_gelar_depan',$penilai->gelar_depan);
		$this->db->set('penilai_nama_golongan',$penilai->nama_golongan);
		$this->db->set('penilai_nama_pangkat',$penilai->nama_pangkat);
		$this->db->set('penilai_id_unor',$penilai->id_unor);
		$this->db->set('penilai_nomenklatur_jabatan',$penilai->nomenklatur_jabatan);
		$this->db->set('penilai_nomenklatur_pada',$penilai->nomenklatur_pada);
		$this->db->set('penilai_tugas_tambahan',$penilai->tugas_tambahan);
		$this->db->set('penilai_nama_ese',$penilai->nama_ese);
		$this->db->set('status',"draft");
		
		if($isi['id_skp']!=""){
			$this->db->where('id_skp',$isi['id_skp']);
			$rt = $this->db->update('p_skp');

			$this->db->set('tahun',$isi['tahun']);
			$this->db->set('bulan_mulai',$isi['bulan_mulai']);
			$this->db->set('bulan_selesai',$isi['bulan_selesai']);
			$this->db->where('id_skp',$isi['id_skp']);
			$this->db->update('p_skp_realisasi_tahapan');

			return $rt;
		} else {
	        $this->db->set('buat',"NOW()",false);
			$this->db->insert('p_skp');
			$id_skp = $this->db->insert_id();

			$this->db->set('id_skp',$id_skp);
			$this->db->set('tahun',$isi['tahun']);
			$this->db->set('bulan_mulai',$isi['bulan_mulai']);
			$this->db->set('bulan_selesai',$isi['bulan_selesai']);
	        $this->db->set('status',"draft");
	        $this->db->set('buat',"NOW()",false);
			$this->db->insert('p_skp_realisasi_tahapan');

			return $id_skp;
		}
	}

	function hapus_skp($isi){
		$this->db->delete('p_skp', array('id_skp' => $isi['id_skp']));
		$this->db->delete('p_skp_realisasi_tahapan', array('id_skp' => $isi['id_skp']));
	}
	function aju_penilai($isi){
		$this->db->set('status',"aju_penilai");
        $this->db->set('aju_penilai',"NOW()",false);
		$this->db->where('id_skp',$isi['id_skp']);
		return $this->db->update('p_skp');
	}
	function verifikatur_kembalikan_skp_aksi($isi){
		$this->db->set('status',"revisi_verifikatur");
        $this->db->set('revisi_verifikatur',"NOW()",false);
		$this->db->where('id_skp',$isi);
		return $this->db->update('p_skp');
	}
	function verifikatur_acc_skp_aksi($isi){
		$this->db->set('status',"acc_verifikatur");
        $this->db->set('acc_verifikatur',"NOW()",false);
		$this->db->where('id_skp',$isi);
		return $this->db->update('p_skp');
	}
/////////////////////////////
	function get_target($id_skp){
		$this->db->from('p_skp_target');
		$this->db->where('id_skp',$id_skp);
		$this->db->order_by('id_target','asc');
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}
	function detail_target($id_target){
		$this->db->from('p_skp_target');
		$this->db->where('id_target',$id_target);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}
	function tambah_aksi($isi){
		$this->db->set('id_skp',$isi['id_skp']);
		$this->db->set('pekerjaan',$isi['target']);
		$this->db->set('ak',$isi['ak']);
		$this->db->set('volume',$isi['volume']);
		$this->db->set('satuan',$isi['satuan']);
		$this->db->set('kualitas',$isi['kualitas']);
		$this->db->set('waktu_lama',$isi['waktu_lama']);
		$this->db->set('waktu_satuan',$isi['waktu_satuan']);
		$this->db->set('biaya',$isi['biaya']);
        $this->db->set('last_updated',"NOW()",false);
		$this->db->insert('p_skp_target');

		
		if($isi['nomor']==1){
	        $this->db->set('draft',"NOW()",false);
			$this->db->where('id_skp',$isi['id_skp']);
			$this->db->update('p_skp');
		}

		$this->db->select_max('id_target');
		$this->db->from('p_skp_target');
		$this->db->where('id_skp',$isi['id_skp']);
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}

	function edit_aksi($isi){
		$this->db->set('pekerjaan',$isi['target']);
		$this->db->set('ak',$isi['ak']);
		$this->db->set('volume',$isi['volume']);
		$this->db->set('satuan',$isi['satuan']);
		$this->db->set('kualitas',$isi['kualitas']);
		$this->db->set('waktu_lama',$isi['waktu_lama']);
		$this->db->set('waktu_satuan',$isi['waktu_satuan']);
		$this->db->set('biaya',$isi['biaya']);
		$this->db->where('id_target',$isi['id_target']);
		$this->db->update('p_skp_target');
	}

	function hapus_aksi($isi){
		$this->db->delete('p_skp_target', array('id_target' => $isi['idd']));
	}
/////////////////////////////////
	function target_acc($isi){
		$this->db->set('status',"acc");
		$this->db->set('icon',"acc");
		$this->db->where('id_target',$isi['idd']);
		$this->db->update('p_skp_target');
	}
	function target_koreksi($isi,$id_penilai,$id_skp){
		$this->db->set('status',"koreksi_penilai");
		$this->db->set('icon',"pentung");
		$this->db->where('id_target',$isi['idd']);
		$this->db->update('p_skp_target');

		$this->db->set('komentar',$isi['komentar']);
		$this->db->set('id_target',$isi['idd']);
		$this->db->set('user_id',$id_penilai);
		$this->db->insert('p_skp_target_koreksi');

		$this->db->set('status',"koreksi_penilai");
        $this->db->set('koreksi_penilai',"NOW()",false);
		$this->db->where('id_skp',$id_skp);
		$this->db->update('p_skp');
	}
	function get_komentar($id_target){
		$this->db->from('p_skp_target_koreksi');
		$this->db->where('id_target',$id_target);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}
	function kembali_aksi($isi){
		$this->db->set('status',$isi->pelaku);
        $this->db->set($isi->pelaku,"NOW()",false);
		$this->db->where('id_skp',$isi->id_skp);
		return $this->db->update('p_skp');
	}
	function acc_skp_penilai_aksi($isi){
		$this->db->set('status',$isi->pelaku);
        $this->db->set($isi->pelaku,"NOW()",false);
		$this->db->where('id_skp',$isi->id_skp);
		return $this->db->update('p_skp');
	}

/////////////////////////////////
	function get_realisasi($id_target){
		$this->db->from('p_skp_realisasi');
		$this->db->where('id_target',$id_target);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}
	function ini_realisasi($id_skp){
		$this->db->from('p_skp_realisasi_tahapan');
		$this->db->where('id_skp',$id_skp);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function realisasi_aksi($isi){
		$vn = $this->get_realisasi($isi['idd']);
			$this->db->set($isi['nama'],$isi['nilai']);
		if(empty($vn)){
			$this->db->set('id_target',$isi['idd']);
			$this->db->insert('p_skp_realisasi');
		} else {
			$this->db->where('id_target',$isi['idd']);
			$this->db->update('p_skp_realisasi');
		}

		$this->db->select($isi['nama']);
		$this->db->from('p_skp_realisasi');
		$this->db->where('id_target',$isi['idd']);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}
	function realisasi_aju_penilai($isi){
		$this->db->set('status',"aju_penilai");
        $this->db->set('aju_penilai',"NOW()",false);
		$this->db->where('id_skp',$isi['id_skp']);
		return $this->db->update('p_skp_realisasi_tahapan');
	}
	function kembalikan_realisasi_aksi($isi){
		$this->db->set('status',$isi->pelaku);
        $this->db->set($isi->pelaku,"NOW()",false);
		$this->db->where('id_skp',$isi->id_skp);
		return $this->db->update('p_skp_realisasi_tahapan');
	}
	function acc_realisasi_aksi($isi){
		$this->db->set('status',$isi->pelaku);
        $this->db->set("acc_penilai","NOW()",false);
        $this->db->set($isi->pelaku,"NOW()",false);
		$this->db->where('id_skp',$isi->id_skp);
		return $this->db->update('p_skp_realisasi_tahapan');
	}
	function acc_realisasi_verifikatur_aksi($isi){
		$this->db->set('status',$isi->pelaku);
        $this->db->set("acc_verifikatur","NOW()",false);
        $this->db->set($isi->pelaku,"NOW()",false);
		$this->db->where('id_skp',$isi->id_skp);
		return $this->db->update('p_skp_realisasi_tahapan');
	}
	function kembalikan_realisasi_verifikatur_aksi($isi){
		$this->db->set('status','revisi_verifikatur');
        $this->db->set("revisi_verifikatur","NOW()",false);
		$this->db->where('id_skp',$isi->id_skp);
		return $this->db->update('p_skp_realisasi_tahapan');
	}
	function acc_item_tugas_pokok($isi){
		$this->db->set('status',"acc");
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('icon',"acc");
		$this->db->where('id_target',$isi['idd']);
		$this->db->update('p_skp_realisasi');
	}
/////////////////////////////////
	function get_tugas_tambahan($id_skp){
		$this->db->from('p_skp_tambahan');
		$this->db->where('id_skp',$id_skp);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}
	function ini_tugas_tambahan($id_tambahan){
		$this->db->from('p_skp_tambahan');
		$this->db->where('id_tambahan',$id_tambahan);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}
	function tugas_tambahan_tambah_aksi($isi){
		$this->db->set('id_skp',$isi['id_skp']);
		$this->db->set('pekerjaan',$isi['pekerjaan']);
		$this->db->set('no_sp',$isi['no_sp']);
		$this->db->set('tanggal_sp',$isi['tanggal_sp']);
		$this->db->set('penandatangan_sp',$isi['penandatangan_sp']);
		$this->db->insert('p_skp_tambahan');
	}
	function tugas_tambahan_edit_aksi($isi){
		$this->db->set('pekerjaan',$isi['pekerjaan']);
		$this->db->set('no_sp',$isi['no_sp']);
		$this->db->set('tanggal_sp',$isi['tanggal_sp']);
		$this->db->set('penandatangan_sp',$isi['penandatangan_sp']);
		$this->db->where('id_tambahan',$isi['idd']);
		$this->db->update('p_skp_tambahan');
	}
	function tugas_tambahan_hapus_aksi($isi){
		$this->db->delete('p_skp_tambahan', array('id_tambahan' => $isi['idd']));
	}
	function acc_item_tugas_tambahan($isi){
		$this->db->set('status',"acc");
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('icon',"acc");
		$this->db->where('id_tambahan',$isi['idd']);
		$this->db->update('p_skp_tambahan');
	}
/////////////////////////////////
/////////////////////////////////
	function get_kreatifitas($id_skp){
		$this->db->from('p_skp_kreatifitas');
		$this->db->where('id_skp',$id_skp);
		$hslquery = $this->db->get()->result();

		return $hslquery;
	}
	function ini_kreatifitas($id_kreatifitas){
		$this->db->from('p_skp_kreatifitas');
		$this->db->where('id_kreatifitas',$id_kreatifitas);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}
	function kreatifitas_tambah_aksi($isi){
		$this->db->set('id_skp',$isi['id_skp']);
		$this->db->set('kreatifitas',$isi['kreatifitas']);
		$this->db->set('no_sk',$isi['no_sk']);
		$this->db->set('tanggal_sk',$isi['tanggal_sk']);
		$this->db->set('penandatangan_sk',$isi['penandatangan_sk']);
		$this->db->insert('p_skp_kreatifitas');
	}
	function kreatifitas_edit_aksi($isi){
		$this->db->set('kreatifitas',$isi['kreatifitas']);
		$this->db->set('no_sk',$isi['no_sk']);
		$this->db->set('tanggal_sk',$isi['tanggal_sk']);
		$this->db->set('penandatangan_sk',$isi['penandatangan_sk']);
		$this->db->where('id_kreatifitas',$isi['idd']);
		$this->db->update('p_skp_kreatifitas');
	}
	function kreatifitas_hapus_aksi($isi){
		$this->db->delete('p_skp_kreatifitas', array('id_kreatifitas' => $isi['idd']));
	}
	function acc_item_kreatifitas($isi){
		$this->db->set('icon',"acc");
		$this->db->where('id_kreatifitas',$isi['idd']);
		$this->db->update('p_skp_kreatifitas');
	}
/////////////////////////////////
	function get_perilaku($id_skp){
		$this->db->from('p_skp_perilaku');
		$this->db->where('id_skp',$id_skp);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function put_perilaku($isi,$operasi){
		$this->db->set($isi['ipt'],$isi['isi']);
		if($operasi=="edit"){
			$this->db->where('id_skp',$isi['idd']);
			$this->db->update('p_skp_perilaku');
		} else {
	        $this->db->set('id_skp',$isi['idd']);
			$this->db->insert('p_skp_perilaku');
		}
	}


































	function koreksi_aksi($isi){
	$tb['tugas_pokok'] = "p_skp_realisasi";
	$tb['tugas_tambahan'] = "p_skp_tambahan";
	$tb['kreatifitas'] = "p_skp_kreatifitas";

	$idk['tugas_pokok'] = "id_target";
	$idk['tugas_tambahan'] = "id_tambahan";
	$idk['kreatifitas'] = "id_kreatifitas";

		$this->db->set('komentar',$isi['komentar']);
        $this->db->set('id_'.$isi['lembar'],$isi['idd']);
        $this->db->set('user_id',$isi['user_id']);
        $this->db->set('last_updated',"NOW()",false);
		$this->db->insert('p_skp_'.$isi['lembar'].'_koreksi');

		$this->db->set('status',"koreksi_penilai");
        $this->db->set('last_updated',"NOW()",false);
		$this->db->set('icon',"pentung");
		$this->db->where($idk[$isi['lembar']],$isi['idd']);
		$this->db->update($tb[$isi['lembar']]);



	}
/*
	function target_koreksi($isi,$id_penilai,$id_skp){
		$this->db->set('status',"koreksi_penilai");
		$this->db->set('icon',"pentung");
		$this->db->where('id_target',$isi['idd']);
		$this->db->update('p_skp_target');

		$this->db->set('komentar',$isi['komentar']);
		$this->db->set('id_target',$isi['idd']);
		$this->db->set('user_id',$id_penilai);
		$this->db->insert('p_skp_target_koreksi');

		$this->db->set('status',"koreksi_penilai");
        $this->db->set('koreksi_penilai',"NOW()",false);
		$this->db->where('id_skp',$id_skp);
		$this->db->update('p_skp');
	}
*/





















	function get_realisasi_komentar($lembar,$idd){
		$this->db->from('p_skp_'.$lembar.'_koreksi');
		$this->db->where('id_'.$lembar,$idd);
		$hslquery = $this->db->get()->result();
		return $hslquery;
	}


  public function get_data() 
  {
     $this->load->library('datatables');
     $this->datatables
    ->select('id_pegawai')
    ->select('tahun,bulan_mulai,bulan_selesai')
    ->select('nip_baru,nama_pegawai')
    ->select('nama_pangkat,nama_golongan')
    ->select('nomenklatur_jabatan')
    ->select('nomenklatur_pada')
    ->select('penilai_nip_baru,penilai_nama_pegawai,penilai_nama_pangkat,penilai_nama_golongan,penilai_nomenklatur_jabatan')
    ->from('p_skp');
        
      $result = $this->datatables->generate();
      return $result;
  }


}
