<?php
class M_penilaian extends CI_Model{
	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
	}
	//////////////////////////////////////////////////////////////////////////////////
	function rumus_satu($target,$realisasi)
	{
		$target 	= $target;
		$realisasi = $realisasi;
		$hasil = ( $realisasi / $target) * 100;
		$hasil = "";
		return $hasil;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function rumus_dua($target,$realisasi)
	{
		if( $target < 1)
		{
			return false;
		}
		if( $realisasi < 1){
			$efisiensi 	= 0;
			$capaian 		= 0;
		}
		else
		{
			$efisiensi = 100 - (( $realisasi / $target ) * 100);
			
			if($efisiensi <= 24)
			{
				$capaian = ( (1.76 * $target ) - $realisasi ) *(100 /  $target);
			}
			elseif($efisiensi > 24)
			{
				$capaian = 76 - ( ( ( ( 1.76 *  $target ) - $realisasi ) *(100 /  $target) ) - 100);
			}
		}
		$hasil = array (
		'efisiensi' 			=> $efisiensi,
		'capaian'			 		=> $capaian
		);
		return $hasil;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function hitung_perilaku($id_skp){
/*
		$sql = "
		SELECT
		IF(a.kepemimpinan = 0, 
		(a.pelayanan + a.integritas + a.komitmen + a.disiplin + a.kerjasama), 
		(a.pelayanan + a.integritas + a.komitmen + a.disiplin + a.kerjasama + a.kepemimpinan)) 
		as jumlah,
		IF(a.kepemimpinan = 0, 5, 6) as pembagi,
		IF(a.kepemimpinan = 0, 
		(a.pelayanan + a.integritas + a.komitmen + a.disiplin + a.kerjasama)/5, 
		(a.pelayanan + a.integritas + a.komitmen + a.disiplin + a.kerjasama + a.kepemimpinan)/6) 
		as rata_rata
		
		from p_skp_perilaku a
		where a.id_skp = $id_skp";
		$hitung = $this->db->query($sql,false)->row();
*/
		$hitung=array();
		return $hitung;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function hitung_tugas_tambahan($id_skp){
		$this->db->from('p_skp');
		$this->db->where('id_skp',$id_skp);
		$skp = $this->db->get()->row();
		
		$this->db->where('id_skp',$id_skp);
		$this->db->where('status','acc');
		$this->db->from('p_skp_tambahan');
		$data = $this->db->get()->result();
		// dump($this->db->last_query());
		$nilai = 0;
		$ndata = count($data);
		if($ndata > 0)
		{
			switch ($ndata):
			case $ndata >= 7:
			$nilai = 3;
			break;
			case ($ndata>=4 && $ndata<=6):
			$nilai = 2;
			break;
			// case ($ndata>=3 && $ndata<=1):
			// $nilai = 1;
			// dump($ndata);
			// break;
			default :
			$nilai = 1;
			break;
			endswitch;
		}
		$n = array();
		foreach($data as $row)
		{
			$n[] = $row->pekerjaan;
		}
		
		$this->db->from('p_skp_penilaian_akhir');
		$this->db->where('p_skp_penilaian_akhir.id_skp',$id_skp);
		$spa = $this->db->get()->row();
		
		$perhitungan = json_decode($spa->perhitungan,true);
		$perhitungan['tugas_tambahan'] = $n;
		$this->db->set('perhitungan',json_encode($perhitungan));
		$this->db->set('skp_tugas_tambahan',$nilai);
		$this->db->where('id_pegawai',$skp->id_pegawai);
		$this->db->where('tahun',$skp->tahun);
		$this->db->update('p_skp_penilaian_akhir');
		
		return $data;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function hitung_penilaian_akhir($id_pegawai,$tahun)
	{
/*
		$skp_akhir = $this->get_penilaian_akhir($id_pegawai,$tahun);

		// hitung skp aplikasi
		$this->db->from('p_skp');
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('tahun',$tahun);
		$all = $this->db->get()->result();
		$skp_app = 0;
		foreach($all as $s)
		{
			$zz = $this->get_skp_nilai($s->id_skp);
			$skp_app += $zz->nilai;
		}
		// $perhitungan['skp_app']
		$skp_non_app = 0;
		$skp_tambahan	= json_decode($skp_akhir->skp_tambahan,true);
		// dump($skp_akhir);
		if(count($skp_tambahan) > 0)
		{
			foreach($skp_tambahan as $st)
			{
				$skp_non_app += $st['nilai'];
			}
		}
		// hitung skp tambahan
		// $this->hitung_tugas_tambahan($p_akhir->id_skp);
		// $this->db->from('p_skp_penilaian_akhir');
		// $this->db->where('p_skp_penilaian_akhir.id_pegawai',$id_pegawai);
		// $this->db->where('p_skp_penilaian_akhir.tahun',$tahun);
		// $cc = $this->db->get()->row();
		
		
		$skp_final = ($skp_app + $skp_non_app) / (count($all) + count($skp_tambahan));
		// $skp_final += $c->skp_tugas_tambahan;
		
		$perilaku = $this->hitung_perilaku($skp_akhir->id_skp);
		if($perilaku)
		{
			$this->db->set('nilai_perilaku',$perilaku->rata_rata);
		}
		$this->db->set('nilai_skp',$skp_final);
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tahun', $tahun);
		$this->db->update('p_skp_penilaian_akhir');
*/
	}
	//////////////////////////////////////////////////////////////////////////////////
	function get_penilaian_akhir($id_pegawai,$tahun)
	{

			$this->db->from('p_skp');
			$this->db->where('id_pegawai',$id_pegawai);
			$this->db->where('tahun',$tahun);
//			$this->db->where('bulan_selesai',12);
			$p_akhir = $this->db->get()->row();


/*
		$this->db->from('p_skp_penilaian_akhir');
		$this->db->join('p_skp','p_skp_penilaian_akhir.id_skp=p_skp.id_skp');
		$this->db->where('p_skp_penilaian_akhir.id_pegawai',$id_pegawai);
		$this->db->where('p_skp_penilaian_akhir.tahun',$tahun);
		$p_akhir = $this->db->get()->row();
		
		if(! $p_akhir)
		{
			$this->db->from('p_skp');
			$this->db->where('id_pegawai',$id_pegawai);
			$this->db->where('tahun',$tahun);
			$this->db->where('bulan_selesai',12);
			$row = $this->db->get()->row();
			if(! $row)
			{
				return false;
			}
			$this->db->set('id_pegawai',$row->id_pegawai);
			$this->db->set('tahun',$row->tahun);
			$this->db->set('id_penilai',$row->id_penilai);
			$this->db->set('id_skp',$row->id_skp);
			$this->db->insert('p_skp_penilaian_akhir');
			
			$this->db->from('p_skp_penilaian_akhir');
			$this->db->join('p_skp','p_skp_penilaian_akhir.id_skp=p_skp.id_skp');
			$this->db->where('p_skp_penilaian_akhir.id_pegawai',$id_pegawai);
			$this->db->where('p_skp_penilaian_akhir.tahun',$tahun);
			$p_akhir = $this->db->get()->row();
		}
*/		
		
		
//		$p_akhir = array();
		return $p_akhir;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function get_skp_penilai($id_pegawai)
	{
		$this->db->from('p_skp');
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('tahun',2014);
		$this->db->order_by('tahun,bulan_mulai desc');
		$data = $this->db->get()->result();
		return $data;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function get_skp_nilai($id_skp)
	{
		$this->db->from('p_skp_penilaian');
		$this->db->where('p_skp_penilaian.id_skp',$id_skp);
		$data = $this->db->get()->row();
		if(! $data)
		{
			$this->db->set('id_skp',$id_skp);
			$this->db->insert('p_skp_penilaian');
		}
		$this->hitung_capaian_skp($id_skp);
		$this->db->from('p_skp_penilaian');
		$this->db->join('p_skp','p_skp.id_skp=p_skp_penilaian.id_skp');
		$this->db->where('p_skp_penilaian.id_skp',$id_skp);
		return $this->db->get()->row();
	}
	//////////////////////////////////////////////////////////////////////////////////
	function get_narasi_nilai($nilai){
		$nilai = (int)$nilai;
		if($nilai > 0)
		{
			switch ($nilai):
			case ($nilai>=91 && $nilai<=100):
			$kat = "Sangat Baik";
			break;
			case ($nilai>=76 && $nilai<=90):
			$kat = "Baik";
			break;
			case ($nilai>=61 && $nilai<=75):
			$kat = "Cukup";
			break;
			case ($nilai>=51 && $nilai<=60):
			$kat = "Kurang";
			break;
			case ($nilai > 0 && $nilai<=50):
			$kat = "Buruk";
			break;
			default :
			$kat = "-";
			break;
			endswitch;
		}
		else
		{
			$kat = "-";
		}
		return $kat;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function hitung_capaian_skp($id_skp)
	{
		$this->db->from('p_skp_target');
		$this->db->where('id_skp',$id_skp);
		$data = $this->db->get()->result();
		foreach($data as $target)
		{
			$this->hitung_capaian_target($target->id_target);
		}
		$sql = "
		SELECT
		sum(b.nilai_capaian) as jumlah,
		count(b.id_target) as pembagi,
		sum(b.nilai_capaian) / count(b.id_target) as nilai
		FROM
		p_skp_target AS a
		INNER JOIN p_skp_realisasi AS b ON b.id_target = a.id_target
		where a.id_skp = $id_skp";
		$skp = $this->db->query($sql)->row();
		
		$this->db->set('jumlah',$skp->jumlah);
		$this->db->set('jumlah',$skp->jumlah);
		$this->db->set('pembagi',$skp->pembagi);
		$this->db->set('nilai',$skp->nilai);
		$this->db->where('id_skp',$id_skp);
		$this->db->update('p_skp_penilaian');
		
		
		return $skp;
	}
	//////////////////////////////////////////////////////////////////////////////////
	function hitung_capaian_target($id_target)
	{
		$this->db->where('id_target',$id_target);
		$target = $this->db->get('p_skp_target')->row();
		
		$this->db->where('id_target',$id_target);
		$realisasi = $this->db->get('p_skp_realisasi')->row();
		if($target && $realisasi)
		{
			// PERHITUNGAN ASPEK KUANTITAS
			$h['ro'] = $realisasi->volume;
			$h['to'] = $target->volume;
			$h['aspek_output'] = $this->rumus_satu( $target->volume, $realisasi->volume);
			
			// PERHITUNGAN ASPEK KUALITAS
			$h['rk'] = $realisasi->kualitas;
			$h['tk'] = $target->kualitas;
			$h['aspek_kualitas'] = $this->rumus_satu( $target->kualitas, $realisasi->kualitas);
			
			// PERHITUNGAN ASPEK WAKTU
			$h['rw'] = $realisasi->waktu_lama;
			$h['tw'] = $target->waktu_lama;
			$hitung_waktu 			= $this->rumus_dua( $target->waktu_lama, $realisasi->waktu_lama);
			$h['ef_waktu'] 		= $hitung_waktu['efisiensi'];
			$h['aspek_waktu'] = $hitung_waktu['capaian'];
			
			// -- asumsi jika waktu pengerjaan 0 maka tidak ada yang bisa dihasilkan
			if($h['rw'] < 1)
			{
				$h['aspek_output'] 		= 0;
				$h['aspek_kualitas'] 	= 0;
			}
			
			// PERHITUNGAN ASPEK BIAYA
			$h['rb'] = $realisasi->biaya;
			$h['tb'] = $target->biaya;
			if($target->biaya > 0)
			{
				$hitung_biaya 		= $this->rumus_dua( $target->biaya, $realisasi->biaya);
				$h['ef_biaya'] 		= $hitung_biaya['efisiensi'];
				$h['aspek_biaya'] = $hitung_biaya['capaian'];
			}
			else
			{
				$h['ef_biaya'] 		= 0;
				$h['aspek_biaya'] = 0;
			}
			
			
			// HITUNG CAPAIAN
			$h['pembagi'] = ($h['aspek_biaya'] > 0)?4:3;
			$h['capaian'] = ($h['aspek_output'] + $h['aspek_kualitas'] + $h['aspek_waktu'] + $h['aspek_biaya']) / $h['pembagi'];
			
			$this->db->set('nilai_capaian',$h['capaian']);
			$this->db->set('perhitungan',json_encode($h));
			$this->db->where('id_target',$id_target);
			$this->db->update('p_skp_realisasi');
			
		}
		else // target dan realisasi tidak diketemukan
		{
			return false;
		}
	}
///////////////////////////////////////////////////////////////////////////////////
//
///////////////////////////////////////////////////////////////////////////////////
	function get_skp_tahun($id_pegawai,$tahun){
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->where('tahun',$tahun);
		$target = $this->db->get('p_skp')->result();
		return $target;
	}
	function get_skp_tahun_target($id_skp){
		$this->db->where('id_skp',$id_skp);
		$target = $this->db->get('p_skp_target')->result();
		return $target;
	}
	function get_skp_tahun_realisasi($id_target){
		$this->db->where('id_target',$id_target);
		$target = $this->db->get('p_skp_realisasi')->row();
		return $target;
	}
	


}
