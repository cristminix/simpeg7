<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penilaian extends MX_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
		$this->load->model('appskp/m_penilaian');
//		$this->server_root = '/home/skponline/webs/skponline/public_html/skp.tangerangkota.go.id.site/online/';
//		$this->server_root = '';
	}	

	function index(){
/////////////////////////////////////////// AMBIL DARI FILE SKP////////////////////////////////
//    KHUSUS UNTUK SET SESSION ID_SKP
///////////////////////////////////////////////////////////////////////////////////////////////
		$id_pegawai = $this->session->userdata('pegawai_info');
		$skpi = $this->m_skp->get_skp($id_pegawai);
		if(!empty($skpi)){
			$idskp = $this->session->userdata('idskp');
			if($idskp==""){
				$pilih = end($skpi);
				$this->session->set_userdata("id_skp",$pilih->id_skp);
			} else {
				$this->session->set_userdata("id_skp",$idskp);
			}
			$this->session->set_userdata("idskp","");
			$id_skp = $this->session->userdata('id_skp');
/////////////////////////////////////////// AMBIL DARI FILE ARIS//////////////////////////////
//    MULAI MASUK KE PERHITUNGAN SKP
///////////////////////////////////////////////////////////////////////////////////////////////
				$xx = $this->m_skp->ini_skp($id_skp);
				$this->session->set_userdata("tahun_skp",$xx->tahun);
//				$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
				$skp = $content['skp'] = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
				
				$id_pegawai = @$content['id_pegawai'] = $skp->id_pegawai;
				$id_penilai = @$content['id_penilai'] = $skp->id_penilai;
				
//				$this->db->where('id_pegawai',$skp->id_penilai_atasan);
//				$this->db->from('rekap_peg');

//				$content['atasan'] 				= $this->db->get()->row();
				$content['step_content'] 	= $this->get_step_1($skp->id_penilai);
				$content['tahun'] 				= $xx->tahun;
				$content['bulan'] 				= $this->dropdowns->bulan(true);
			
				$this->load->view('penilaian/index',$content);

		} else {
				$this->load->view('penilaian/index_kosong');
		}
	}


	public function load_step_1()
	{
		$id_skp = $this->session->userdata('id_skp');
		$xx = $this->m_skp->ini_skp($id_skp);
		$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp = $content['skp'] = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		// $skp = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		// echo $this->get_step_1($skp->id_penilai);
		$result = array(
			'success'=>true,
			'step_content' => $this->get_step_1($skp->id_penilai)
		);
		echo json_encode($result);
	}
	# tampilkan daftar skp pejabat penilai untuk pemilihan atasan pejabat penilai
	public function get_step_1($id_penilai=false)
	{
		$data = $content['data'] = $this->m_penilaian->get_skp_penilai($id_penilai);
		return $this->load->view('penilaian/step_1',$content,true);
	}
	public function hapus_skp_luar()
	{
		$id = $this->input->post('id');
		$xx = $this->m_skp->ini_skp($this->id_skp);
		$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp_tambahan	= json_decode($skp->skp_tambahan, TRUE);
		unset($skp_tambahan[$id]);
		$this->db->set('skp_tambahan',json_encode($skp_tambahan));
		$this->db->where('id_pegawai',$xx->id_pegawai);
		$this->db->where('tahun',$xx->tahun);
		$this->db->update('p_skp_penilaian_akhir');
		
		$result = array(
		'success'=>true,
		'step_content' => $this->input->post()
		);
		echo json_encode($result);
	}
	public function tambah_skp_luar()
	{
		$xx = $this->m_skp->ini_skp($this->id_skp);
		$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp_tambahan	= json_decode($skp->skp_tambahan, TRUE);
		$skp_tambahan[(count($skp_tambahan) + 1)] = array(
			'tahun'=> $xx->tahun,
			'bulan_mulai'=> $this->input->post('bulan_mulai'),
			'bulan_selesai'=> $this->input->post('bulan_selesai'),
			'jumlah'=> $this->input->post('jumlah'),
			'pembagi'=> $this->input->post('pembagi'),
			'nilai'=> $this->input->post('jumlah') / $this->input->post('pembagi')
		);
		$this->db->set('skp_tambahan',json_encode($skp_tambahan));
		$this->db->where('id_pegawai',$xx->id_pegawai);
		$this->db->where('tahun',$xx->tahun);
		$this->db->update('p_skp_penilaian_akhir');
		
		$result = array(
			'success'=>true,
			'step_content' => $this->input->post()
		);
		echo json_encode($result);
	}
	public function reload_step_2()
	{
		$result = array(
		'success'=>true,
		'step_content' => $this->get_step_2()
		);
		echo json_encode($result);
	}
	public function load_step_2()
	{
		$id_penilai_atasan = $this->input->post('id_penilai_atasan');
		$id_skp_penilai = $this->input->post('id_skp_penilai');
		$this->db->where('id_skp',$id_skp_penilai);
		$this->db->from('p_skp');
		$data 	= $this->db->get()->row();

		$nama_atasan_penilai = ((trim($data->penilai_gelar_depan) != '-')?trim($data->penilai_gelar_depan).' ':'').$data->penilai_nama_pegawai.((trim($data->penilai_gelar_belakang) != '-')?', '.trim($data->penilai_gelar_belakang):'');
		$this->session->set_userdata("nama_atasan_penilai",$nama_atasan_penilai);
		$this->session->set_userdata("nip_atasan_penilai",$data->penilai_nip_baru);
		$this->session->set_userdata("pangkat_atasan_penilai",$data->penilai_nama_golongan." / ".$data->penilai_nama_pangkat);
		$this->session->set_userdata("jabatan_atasan_penilai",$data->penilai_nomenklatur_jabatan);
		$this->session->set_userdata("unor_atasan_penilai",$data->penilai_nomenklatur_pada);
		
		if($data)
		{
			$id_skp = $this->session->userdata('id_skp');
			$xx = $this->m_skp->ini_skp($id_skp);
			$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
			$skp = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);

			$this->db->set('id_penilai_atasan',$id_penilai_atasan);
			$this->db->set('id_skp_penilai',$id_skp_penilai);
			$this->db->where('id_skp',$skp->id_skp);
			$this->db->update('p_skp_penilaian_akhir');
			
			$result = array(
			'success'=>true,
			'message'=> $data->penilai_nama_pegawai.' / '.$data->penilai_nip_baru,
			'step_content' => $this->get_step_2()
			);
			echo json_encode($result);
		}else{
			$this->load_step_1();
		}
	}
	# tampilkan daftar skp pegawai untuk tahun tertentu untuk diperlihatkan hasil perhitungan
	public function get_step_2()
	{
		$id_skp = $this->session->userdata('id_skp');
		$xx = $this->m_skp->ini_skp($id_skp);
		$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp = $content['skp_akhir'] 			= $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		
		$this->db->where('p_skp.id_pegawai',$xx->id_pegawai);
		$this->db->where('p_skp.tahun',$xx->tahun);
		$this->db->order_by('bulan_mulai');
		$this->db->from('p_skp_penilaian');
		$this->db->join('p_skp','p_skp.id_skp=p_skp_penilaian.id_skp');
		$data = $content['data'] = $this->db->get()->result();

		foreach($data as $row)
		{
			$content['skp'][$row->id_skp] 				= $this->m_penilaian->get_skp_nilai($row->id_skp); 
		}
/*		
		$content['skp_tambahan']	= json_decode($skp->skp_tambahan);
		$content['perhitungan']	= json_decode($skp->perhitungan,true);
		$content['perilaku']			= $this->m_penilaian->hitung_perilaku($id_skp);
		$content['bulan'] 				= $this->dropdowns->bulan(true);
*/
		return $this->load->view('penilaian/step_2',$content,true);
	}
	public function cetak($id_pegawai=false,$tahun=false)
	{
		require_once($this->server_root.'system/cms/libraries/PHPWord.php');
		$PHPWord = new PHPWord();
		
		$path = $this->server_root.'assets/file/skp/template/';
		$document = $PHPWord->loadTemplate($path.'FORMAT_LEMBAR_PENILAIAN.docx');
		$arr =$this->set_value();
		
		foreach($arr as $key => $field){
			// dump($key);
			$document->setValue($key, $field);
		}

		// $a_penilai = $this->get_penilai_atasan($id_skp_penilai);
		// foreach($a_penilai as $k => $f){
			// $document->setValue($k, $f);
		// }
		$path = $this->server_root.'assets/file/skp/lembarpenilaian/'.$tahun.'/';
		$document->save($path.$id_pegawai.'.docx');
	}
	public function download()
	{
		// echo dirname(__FILE__);die;
		$id_skp = $this->session->userdata('id_skp');
		$xx = $this->m_skp->ini_skp($id_skp);
		$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		
		$id_pegawai = $skp->id_pegawai;
		$tahun = $skp->tahun;
		$this->cetak($id_pegawai,$tahun);

		$this->load->helper('download');
		$path = $this->server_root.'assets/file/skp/lembarpenilaian/'.$xx->tahun.'/';
		$data = file_get_contents($path.$id_pegawai.".docx"); // Read the file's contents
		$name = md5(rand()).'.docx';
		
		force_download($name, $data);
	}
	public function set_value()
	{
		$id_skp = $this->session->userdata('id_skp');
		$xx = $this->m_skp->ini_skp($id_skp);
		$this->m_penilaian->hitung_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$skp = $this->m_penilaian->get_penilaian_akhir($xx->id_pegawai,$xx->tahun);
		$bulan = $this->dropdowns->bulan(true);
		
		$arr = array();
		// data utama 
		$gelar_depan =(trim($skp->gelar_depan) != '-')?trim($skp->gelar_depan).' ':'';
		$gelar_na =(trim($skp->gelar_nonakademis) != '-')?trim($skp->gelar_nonakademis).' ':'';
		$gelar_blkg =(trim($skp->gelar_belakang) != '-')?', '.trim($skp->gelar_belakang):'' ;
		$nama_lengkap_pegawai = $gelar_depan.$gelar_na.$skp->nama_pegawai.$gelar_blkg;
		
		$gelar_depan =(trim($skp->penilai_gelar_depan) != '-')?trim($skp->penilai_gelar_depan).' ':'';
		$gelar_na =(trim($skp->penilai_gelar_nonakademis) != '-')?trim($skp->penilai_gelar_nonakademis).' ':'';
		$gelar_blkg =(trim($skp->penilai_gelar_belakang) != '-')?', '.trim($skp->penilai_gelar_belakang):'' ;
		$nama_lengkap_penilai = $gelar_depan.$gelar_na.$skp->penilai_nama_pegawai.$gelar_blkg;

		$arr += array(
		'tahun'									=>$skp->tahun,
		'bulan_mulai'						=>$bulan[$skp->bulan_mulai],
		'bulan_selesai'					=>$bulan[$skp->bulan_selesai],
		'nama_pegawai'					=>$nama_lengkap_pegawai,
		'nip_baru'							=>$skp->nip_baru,
		'gelar_nonakademis'			=>$skp->gelar_nonakademis,
		'gelar_depan'						=>$skp->gelar_depan,
		'gelar_belakang'				=>$skp->gelar_belakang,
		'nama_golongan'					=>$skp->nama_golongan,
		'nama_pangkat'					=>$skp->nama_pangkat,
		'nomenklatur_jabatan'		=>$skp->nomenklatur_jabatan,
		'nomenklatur_pada'			=>$skp->nomenklatur_pada,
		
		'penilai_nama_pegawai'					=>$nama_lengkap_penilai,
		'penilai_nip_baru'							=>$skp->penilai_nip_baru,
		'penilai_gelar_nonakademis'			=>$skp->penilai_gelar_nonakademis,
		'penilai_gelar_depan'						=>$skp->penilai_gelar_depan,
		'penilai_gelar_belakang'				=>$skp->penilai_gelar_belakang,
		'penilai_nama_golongan'					=>$skp->penilai_nama_golongan,
		'penilai_nama_pangkat'					=>$skp->penilai_nama_pangkat,
		'penilai_nomenklatur_jabatan'		=>$skp->penilai_nomenklatur_jabatan,
		'penilai_nomenklatur_pada'			=>$skp->penilai_nomenklatur_pada,
		);
		
		$this->db->where('id_skp',$skp->id_skp_penilai);
		$atasan = $this->db->get('p_skp')->row();
		// dump($atasan);
		$gelar_depan =(trim($atasan->penilai_gelar_depan) != '-')?trim($atasan->penilai_gelar_depan).' ':'';
		$gelar_na =(trim($atasan->penilai_gelar_nonakademis) != '-')?trim($atasan->penilai_gelar_nonakademis).' ':'';
		$gelar_blkg =(trim($atasan->penilai_gelar_belakang) != '-')?', '.trim($atasan->penilai_gelar_belakang):'' ;
		$nama_lengkap_atasan = $gelar_depan.$gelar_na.$atasan->penilai_nama_pegawai.$gelar_blkg;

		$arr += array(
		'a_penilai_nama_pegawai'					=> $nama_lengkap_atasan,
		'a_penilai_nip_baru'							=> $atasan->penilai_nip_baru,
		'a_penilai_gelar_nonakademis'			=> $atasan->penilai_gelar_nonakademis,
		'a_penilai_gelar_depan'						=> $atasan->penilai_gelar_depan,
		'a_penilai_gelar_belakang'				=> $atasan->penilai_gelar_belakang,
		'a_penilai_nama_golongan'					=> $atasan->penilai_nama_golongan,
		'a_penilai_nama_pangkat'					=> $atasan->penilai_nama_pangkat,
		'a_penilai_nomenklatur_jabatan'		=> $atasan->penilai_nomenklatur_jabatan,
		'a_penilai_nomenklatur_pada'			=> $atasan->penilai_nomenklatur_pada
		);
		
		// Perilaku
		$this->db->where('id_skp',$skp->id_skp);
		$perilaku = $this->db->get('p_skp_perilaku')->row();
		$perilaku_hitung = $this->m_penilaian->hitung_perilaku($skp->id_skp);
		$arr += array(
		'pelayanan'				=> $perilaku->pelayanan,
		'integritas'			=> $perilaku->integritas,
		'komitmen'				=> $perilaku->komitmen,
		'disiplin'				=> $perilaku->disiplin,
		'kerjasama'				=> $perilaku->kerjasama,
		'kepemimpinan'		=> $perilaku->kepemimpinan,

		'nomenklatur_pelayanan'			=>$this->m_penilaian->get_narasi_nilai($perilaku->pelayanan),
		'nomenklatur_integritas'		=>$this->m_penilaian->get_narasi_nilai($perilaku->integritas),
		'nomenklatur_komitmen'			=>$this->m_penilaian->get_narasi_nilai($perilaku->komitmen),
		'nomenklatur_disiplin'			=>$this->m_penilaian->get_narasi_nilai($perilaku->disiplin),
		'nomenklatur_kerjasama'			=>$this->m_penilaian->get_narasi_nilai($perilaku->kerjasama),
		'nomenklatur_kepemimpinan'	=>$this->m_penilaian->get_narasi_nilai($perilaku->kepemimpinan),

		'jumlah'								=> $perilaku_hitung->jumlah,
		'rata_rata'							=> $perilaku_hitung->rata_rata,
		'nomenklatur_rata_rata'	=> $this->m_penilaian->get_narasi_nilai($perilaku_hitung->rata_rata),
		'nilai_perilaku'				=> ($perilaku_hitung->rata_rata * 0.4),
		
		);
		
		if($skp->tugas_tambahan == 'Kepala Sekolah')
		{
			$arr['nomenklatur_jabatan'] = 'Kepala Sekolah';
		}
		
		if($skp->penilai_tugas_tambahan == 'Kepala Sekolah')
		{
			$arr['penilai_nomenklatur_jabatan'] = 'Kepala Sekolah';
		}
		
		// $nilai_skp = $this->m_formulasi->get_skp_nilai($id_skp);
		$arr['nilai_skp'] = $skp->nilai_skp;
		$arr['nilai_skp_2'] = $skp->nilai_skp*0.6;
		$arr['npk'] = $skp->nilai_skp*0.6 + $perilaku_hitung->rata_rata * 0.4;
		$arr['npk2'] = $this->m_penilaian->get_narasi_nilai($arr['npk']);
		return $arr;
	}

//////////////////////////////////////////////////////////////////////////////////////////////
	function arsip(){
		$id_pegawai = $this->session->userdata('pegawai_info');
		$data['pegawai_info'] = $this->m_skp->get_pegawai($id_pegawai);
		$data['skp'] = $this->m_skp->get_skp($id_pegawai);
				$data['tahapan_skp'] = $this->dropdowns->tahapan_skp();
		$this->load->view('penilaian/arsip',$data);
	}
	function buka_hitung(){
		$id_pegawai = $this->session->userdata('pegawai_info');
		$tahun = $this->session->userdata('tahun_skp');
		$bulan = $this->dropdowns->bulan();

		$data['skp_tahun'] = $this->m_penilaian->get_skp_tahun($id_pegawai,$tahun);
		foreach($data['skp_tahun'] as $key=>$val){
			$target = $this->m_penilaian->get_skp_tahun_target($val->id_skp);
			$data['skp_tahun'][$key]->target = $this->m_penilaian->get_skp_tahun_target($val->id_skp);
			foreach($target as $ky=>$vl){
				$realisasi = $this->m_penilaian->get_skp_tahun_realisasi($vl->id_target);
				@$data['skp_tahun'][$key]->target[$ky]->r_volume = $realisasi->volume;
				@$data['skp_tahun'][$key]->target[$ky]->r_kualitas = $realisasi->kualitas;
				@$data['skp_tahun'][$key]->target[$ky]->r_waktu_lama = $realisasi->waktu_lama;
				@$data['skp_tahun'][$key]->target[$ky]->r_biaya = $realisasi->biaya;
				$data['skp_tahun'][$key]->target[$ky]->r_ak = (isset($realisasi->ak))?$realisasi->ak:"-";

				$data['skp_tahun'][$key]->target[$ky]->persen_waktu = 100-($realisasi->waktu_lama/$vl->waktu_lama*100);
				$data['skp_tahun'][$key]->target[$ky]->persen_biaya = ($vl->biaya!="0" && $realisasi->biaya!="0")?100-($realisasi->biaya/$vl->biaya*100):"-";

				$data['skp_tahun'][$key]->target[$ky]->rw_K_24 = ((1.76*$vl->waktu_lama-$realisasi->waktu_lama)/$vl->waktu_lama)*100;
				$data['skp_tahun'][$key]->target[$ky]->rw_L_24 = 76-((((1.76*$vl->waktu_lama-$realisasi->waktu_lama)/$vl->waktu_lama)*100)-100);
				$data['skp_tahun'][$key]->target[$ky]->rb_K_24 = ($vl->biaya!="0" && $realisasi->biaya!="0")?((1.76*$vl->biaya-$realisasi->biaya)/$vl->biaya)*100:"-";
				$data['skp_tahun'][$key]->target[$ky]->rb_L_24 = ($vl->biaya!="0" && $realisasi->biaya!="0")?76-((((1.76*$vl->biaya-$realisasi->biaya)/$vl->biaya)*100)-100):"-";

				$data['skp_tahun'][$key]->target[$ky]->skor_kuantitas = $realisasi->volume/$vl->volume*100;
				$data['skp_tahun'][$key]->target[$ky]->skor_kualitas = $realisasi->kualitas/$vl->kualitas*100;
				$data['skp_tahun'][$key]->target[$ky]->skor_waktu = ($data['skp_tahun'][$key]->target[$ky]->persen_waktu<24)?$data['skp_tahun'][$key]->target[$ky]->rw_K_24:$data['skp_tahun'][$key]->target[$ky]->rw_L_24;
				if($data['skp_tahun'][$key]->target[$ky]->persen_biaya!="-" && $data['skp_tahun'][$key]->target[$ky]->persen_biaya<24){
					$data['skp_tahun'][$key]->target[$ky]->skor_biaya=$data['skp_tahun'][$key]->target[$ky]->rb_K_24;
				} elseif($data['skp_tahun'][$key]->target[$ky]->persen_biaya!="-" && $data['skp_tahun'][$key]->target[$ky]->persen_biaya>24) {
					$data['skp_tahun'][$key]->target[$ky]->skor_biaya=$data['skp_tahun'][$key]->target[$ky]->rb_L_24;
				} else {
					$data['skp_tahun'][$key]->target[$ky]->skor_biaya="-";
				}


				$data['skp_tahun'][$key]->target[$ky]->perhitungan = ($data['skp_tahun'][$key]->target[$ky]->skor_biaya!="-")?($data['skp_tahun'][$key]->target[$ky]->skor_kuantitas+$data['skp_tahun'][$key]->target[$ky]->skor_kualitas+$data['skp_tahun'][$key]->target[$ky]->skor_waktu+$data['skp_tahun'][$key]->target[$ky]->skor_biaya):($data['skp_tahun'][$key]->target[$ky]->skor_kuantitas+$data['skp_tahun'][$key]->target[$ky]->skor_kualitas+$data['skp_tahun'][$key]->target[$ky]->skor_waktu);
				$data['skp_tahun'][$key]->target[$ky]->nilai_capaian = ($data['skp_tahun'][$key]->target[$ky]->skor_biaya!="-")?($data['skp_tahun'][$key]->target[$ky]->perhitungan/4):($data['skp_tahun'][$key]->target[$ky]->perhitungan/3);
			} 
		}

		$this->load->view('penilaian/buka_hitung',$data);
	}
	
}