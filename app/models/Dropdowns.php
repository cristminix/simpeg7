<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
class Dropdowns extends CI_Model 
{

  public function __construct() 
  {
    parent::__construct();
  }

  function gender($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Kelamin';
    }else{
      $select [''] = '-';
    }
    $select ['l'] = 'Laki-Laki';
    $select ['p'] = 'Perempuan';
    
    return $select;
  } 
  
  function status_orangtua($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih';
    }else{
      $select [''] = '-';
    }
    $select ['Orang Tua Kandung'] = 'Orang Tua Kandung';
    $select ['Orang Tua Angkat'] = 'Orang Tua Angkat';
    $select ['Orang Tua Tiri'] = 'Orang Tua Tiri';
    
    return $select;
  }
  function keterangan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih';
    }else{
      $select [''] = '-';
    }
    $select ['Masih Hidup'] = 'Masih Hidup';
    $select ['Sudah Meninggal'] = 'Sudah Meniggal';
    
    return $select;
  }
  
   function jenis_pendidikan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Pendidikan';
    }else{
      $select [''] = '-';
    }
    $select ['umum'] = 'Umum';
    $select ['teknik'] = 'Teknik';
    
    return $select;
  }
  function agama($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Agama';
    }else{
      $select [''] = '-';
    }
    $select ['Islam']       = 'Islam';
    $select ['Protestan']   = 'Protestan';
    $select ['Katholik']    = 'Katholik';
    $select ['Hindu']       = 'Hindu';
    $select ['Budha']       = 'Budha';
    
    return $select;
  }
   function kelompok_pegawai($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Kelompok Pegawai';
    }else{
      $select [''] = '-';
    }
    $select ['Perorangan']   = 'Perorangan';
    $select ['Pengolahan']= 'Pengolahan';
    $select ['Distribusi'] = 'Distribusi';
    $select ['Administrasi Umum'] = 'Administrasi Umum';
    $select ['Direksi'] = 'Direksi';
    $select ['Dewan Pengawas'] = 'Dewan Pengawas';
    return $select;
  }
  function status_pegawai($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Status Pegawai';
    }else{
      $select [''] = '-';
    }
    $select ['Tetap']   = 'Tetap';
    $select ['Kontrak']= 'Kontrak';
    $select ['Capeg'] = 'Capeg';
    $select ['Khusus'] = 'Khusus';
    return $select;
  }
  
    function status($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Status';
    }else{
      $select [''] = '-';
    }
    $select ['On']   = 'on';
    $select ['Off']= 'off';
    return $select;
  }
  
  function group($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Grup Pengguna';
    }else{
      $select [''] = '-';
    }
    $select ['superadmin']   = 'Super Admin';
    $select ['admin']= 'Admin';
    $select ['pegawai'] = 'Pegawai';
    return $select;
  }
  
  function status_perkawinan($asRef=false)
  {
    if(!$asRef){
      $select ['']                = 'Pilih Status Pernikahan';
    }else{
      $select [''] = '-';
    }
    $select ['Belum Menikah']   = 'Belum Menikah';
    $select ['Menikah']         = 'Menikah';
    $select ['Duda']            = 'Duda';
    $select ['Janda']           = 'Janda';
    $select ['Tidak Tahu']      = 'Tidak Tahu';
    
    return $select;
  }
  function status_anak($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Status Anak';
    }else{
      $select [''] = '-';
    }
    $select ['Anak kandung'] = 'Anak kandung';
    $select ['Anak tiri'] = 'Anak tiri';
    $select ['Anak angkat'] = 'Anak angkat';
    
    return $select;
  }
  function keterangan_tunjangan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Keterangan Tunjangan';
    }else{
      $select [''] = '-';
    }
    $select ['Dapat'] = 'Dapat Tunjangan';
    $select ['Tidak'] = 'Tidak Dapat Tunjangan';
    
    return $select;
  }
  function jenis_jabatan($asRef=false,$choose=true)
  {
    if(!$asRef && $choose){
      $select [''] = 'Pilih Jenis Jabatan';
    }else{
      if($choose){
         $select [''] = '-';
      }
     
    }
    $select ['js'] = 'Jabatan Struktural';
    $select ['jfu'] = 'Jabatan Fungsional Umum';
    $select ['jft'] = 'Jabatan Fungsional Tertentu';
 
    
    return $select;
  }
  function tugas_tambahan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Tugas Tambahan';
    }else{
      $select [''] = '-';
    }
    $select ['Kepala Sekolah'] = 'Kepala Sekolah';
    $select ['Bendahara penerimaan'] = 'Bendahara penerimaan';
    $select ['Bendahara pengeluaran'] = 'Bendahara pengeluaran';
    $select ['Bendahara penerimaan pembantu'] = 'Bendahara penerimaan pembantu';
    $select ['Bendahara pengeluaran pembantu'] = 'Bendahara pengeluaran pembantu';
    $select ['Pembantu bendahara penerimaan'] = 'Pembantu bendahara penerimaan';
    $select ['Pembantu bendahara pengeluaran'] = 'Pembantu bendahara pengeluaran';
    $select ['Bendahara barang'] = 'Bendahara barang';
    $select ['Pembantu bendahara barang'] = 'Pembantu bendahara barang';
    $select ['Verifikatur'] = 'Verifikatur';
    
    return $select;
  }
  function jenis_pensiun($asRef=false,$choose=true)
  {
    if(!$asRef&& $choose){
      $select [''] = 'Pilih Jenis Pensiun...';
    }else{
      if($choose){
         $select [''] = '-';
      }
    }
    $select ['Mencapai BUP'] = 'Mencapai BUP';
    $select ['Atas Permintaan Sendiri'] = 'Atas Permintaan Sendiri';
    $select ['Pensiun Karena Sakit'] = 'Pensiun Karena Sakit';
    $select ['Diberhentikan Tidak Hormat'] = 'Diberhentikan Tidak Hormat';
    $select ['Pensiun Direksi'] = 'Pensiun Direksi';
    $select ['Pensiun Dewan Pengawas'] = 'Pensiun Dewan Pengawas';
    
    return $select;
  }
  function rumpun_diklat_struk($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Diklat';
    }else{
      $select [''] = '-';
    }
    $select ["1"] = 'Diklat PIM IV';
    $select ["2"] = 'Diklat PIM III';
    $select ["3"] = 'Diklat PIM II';
    $select ["4"] = 'Diklat PIM I';
    
    return $select;
  }
  
  function masa_kerja($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Masa Kerja';
    }else{
      $select [''] = '-';
    }
    $select ["0"] = '0';
    $select ["1"] = '1';
    $select ["2"] = '2';
    $select ["3"] = '3';
    $select ["4"] = '4';
    $select ["5"] = '5';
    $select ["6"] = '6';
    $select ["7"] = '7';
    $select ["8"] = '8';
    $select ["9"] = '9';
    $select ["10"] = '10';   
	  $select ["11"] = '11';
    $select ["12"] = '12';
    $select ["13"] = '13';
    $select ["14"] = '14';
    $select ["15"] = '15';
    $select ["16"] = '16';
    $select ["17"] = '17';
    $select ["18"] = '18';
    $select ["19"] = '19';
    $select ["20"] = '20';   
	  $select ["21"] = '21';
    $select ["22"] = '22';
    $select ["23"] = '23';
    $select ["24"] = '24';
    $select ["25"] = '25';
    $select ["26"] = '26';
    $select ["27"] = '27';
    $select ["28"] = '28';
    $select ["29"] = '29';
    $select ["30"] = '30';   
    $select ["31"] = '31';   
    $select ["32"] = '32';   
    $select ["33"] = '33';   
    $select ["34"] = '34';   
    $select ["35"] = '35';   
    return $select;
  }
  
  function kode_jenjang_pendidikan($asRef=false,$choose=true)
  {
    if(!$asRef && $choose){
      $select [''] = 'Pilih Jenjang Pendidikan';
    }else{
      if($choose){
        $select [''] = '-';
      }
      
    }
    $select ['05'] = 'Sekolah Dasar';
    $select ['10'] = 'SLTP';
    $select ['12'] = 'SLTP Kejuruan';
    $select ['15'] = 'SLTA';
    $select ['17'] = 'SLTA Kejuruan';
    $select ['18'] = 'SLTA Keguruan';
    $select ['20'] = 'Diploma I';
    $select ['25'] = 'Diploma II';
    $select ['30'] = 'Diploma III/Sarjana Muda';
    $select ['35'] = 'Diploma IV';
    $select ['40'] = 'S-1/Sarjana';
    $select ['45'] = 'S-2';
    $select ['50'] = 'S-3/Doktor';

    return $select;
  }
 
 function getMasaKerja(){
		$this->db->select('masa_kerja');
		$this->db->from('m_masa_kerja');
		$this->db->where('status','aktif');
		$query = $this->db->get();
		
		 if($query->num_rows() > 0)
        {
            foreach($query->result() as $row)
            {
				$data[''] = 'Pilih Masa Kerja';
                $data[] = $row->masa_kerja;
            }
            return $data;
        }
	}
 
  function getKodeGolPangkat(){
		$this->db->select('kode_golongan,nama_pangkat');
		$this->db->from('m_golongan');
		$this->db->order_by('kode_golongan','ASC');
		$data = $this->db->get()->result() ;
		$arr_data = array();
	    foreach($data as $key=>$row){
			$arr_data[''] = 'Pilih Pangkat';
		    $arr_data[$row->kode_golongan] = $row->nama_pangkat;
	    }
	    return $arr_data;
		
		 // if($query->num_rows() > 0)
        // {
            // foreach($query->result() as $row)
            // {
				// $data[''] = 'Pilih Pangkat';
                // $data[] = $row->nama_pangkat;
            // }
            // return $data;
        // }
	}
  
  
   function getTunjKelompok(){
		
   
		$this->db->select('id_tunjangan_kelompok,tunjangan_kelompok');
		$this->db->from('m_tunjangan_kelompok');
		$this->db->order_by('id_tunjangan_kelompok','ASC');
		$data = $this->db->get()->result() ;
		$arr_data = array();
	    foreach($data as $key=>$row){
			$arr_data[''] = 'Pilih Tunjangan Kelompok';
		    $arr_data[$row->id_tunjangan_kelompok] = $row->tunjangan_kelompok;
	    }
	    return $arr_data;
		 // if($query->num_rows() > 0)
        // {
            // foreach($query->result() as $row)
            // {
				// $data[''] = 'Pilih Tunjangan Kelompok';
                // $data[] = $row->tunjangan_kelompok;
            // }
            // return $data;
        // }
	}
  
  
  function kode_golongan_pangkat($asRef=false,$blank=false)
  {
    if(!$asRef && !$blank){
    $select [''] = 'Pilih Pangkat';
    }else{
      if(!$blank){
        $select [''] = '-';
      }
      
    }
    $select ["1"] = 'Pegawai Dasar';
    $select ["2"] = 'Pegawai Dasar';
    $select ["3"] = 'Pegawai Madya';
    $select ["4"] = 'Pegawai Utama';
    $select ["5"] = 'Pelaksana Dasar';
    $select ["6"] = 'Pelaksana Muda';
    $select ["7"] = 'Pelaksana Madya';
    $select ["8"] = 'Pelaksana Utama';
    $select ["9"] = 'Pengatur Dasar';
    $select ["10"] = 'Pengatur Muda';
    $select ["11"] = 'Pengatur Madya';
    $select ["12"] = 'Pengatur Utama';
    $select ["13"] = 'Penata Dasar';
    $select ["14"] = 'Penata Muda';
    $select ["15"] = 'Penata Madya';
    $select ["16"] = 'Penata Utama';
    $select ["17"] = 'Pembina Madya';
    $select ["91"] = 'HONOR UMR';    
    
    return $select;
  }

  // function kode_golongan_pangkat($asRef=false)
  // {
    // if(!$asRef){
    // $select [''] = 'Pilih Golongan';
    // }else{
      // $select [''] = '-';
    // }
    // $select [11] = 'I/a, Juru Muda';
    // $select [12] = 'I/b, Juru Muda Tingkat I';
    // $select [13] = 'I/c, Juru';
    // $select [14] = 'I/d, Juru Tingkat I';
    // $select [21] = 'II/a, Pengatur Muda';
    // $select [22] = 'II/b, Pengatur Muda Tingkat I';
    // $select [23] = 'II/c, Pengatur';
    // $select [24] = 'II/d, Pengatur Tingkat I';
    // $select [31] = 'III/a, Penata Muda';
    // $select [32] = 'III/b, Penata Muda Tingkat I';
    // $select [33] = 'III/c, Penata';
    // $select [34] = 'III/d, Penata Tingkat I';
    // $select [41] = 'IV/a, Pembina';
    // $select [42] = 'IV/b, Pembina Tingkat I';
    // $select [43] = 'IV/c, Pembina Utama Muda';
    // $select [44] = 'IV/d, Pembina Utama Madya';
    
    // return $select;
  // }
  
   function pilih_peringkat($asRef=false)
  {
    if(!$asRef){
    $select [''] = 'Pilih Peringkat';
    }else{
      $select [''] = '-';
    }
    $select ["1"] = 'Pegawai Dasar';
    $select ["2"] = 'Pegawai Dasar';
    $select ["3"] = 'Pegawai Madya';
    $select ["4"] = 'Pegawai Utama';
    $select ["5"] = 'Pelaksana Dasar';
    $select ["6"] = 'Pelaksana Muda';
    $select ["7"] = 'Pelaksana Madya';
    $select ["8"] = 'Pelaksana Utama';
    $select ["9"] = 'Pengatur Dasar';
    $select ["10"] = 'Pengatur Muda';
    $select ["11"] = 'Pengatur Madya';
    $select ["12"] = 'Pengatur Utama';
    $select ["13"] = 'Penata Dasar';
    $select ["14"] = 'Penata Muda';
    $select ["15"] = 'Penata Madya';
    $select ["16"] = 'Penata Utama';
    $select ["17"] = 'Pembina Madya';
    $select ["91"] = 'HONOR UMR';    
    return $select;
  }
  
  function kode_jenis_kp($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis KP';
    }else{
      $select [''] = '-';
    }
    $select ["101"] = 'Reguler';
    $select ["201"] = 'Pilihan  (Jabatan Struktural)';
    $select ["202"] = 'Pilihan  (Jabatan Fungsional Tertentu)';
    $select ["203"] = 'Pilihan  (Penyesuaian Ijazah)';
    $select ["204"] = 'Pilihan  (Sedang Melaksanakan Tugas Belajar)';
    $select ["205"] = 'Pilihan  (Setelah Selesai Tugas Belajar)';
    $select ["211"] = 'Gol. dari Pengadaan CPNS/PNS';
    
    return $select;
  }
  function kedudukan_hukum($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Kedudukan Hukum';
    }else{
      $select [''] = '-';
    }
    $select ["01"] = 'Aktif';
    $select ["02"] = 'CLTN';
    $select ["03"] = 'Tugas Belajar';
    $select ["04"] = 'Pemberhentian Sementara';
    $select ["05"] = 'Penerima Uang Tunggu';
    $select ["06"] = 'Prajurit Wajib';
    $select ["07"] = 'Pejabat Negara';
    $select ["08"] = 'Kepala Desa';
    $select ["09"] = 'Sedang dlm Proses Banding BAPEK';
    $select ["11"] = 'Pegawai Titipan';
    $select ["12"] = 'Pengungsi';
    $select ["13"] = 'Perpanjangan CLTN';
    $select ["14"] = 'PNS yang dinyatakan hilang';
    $select ["15"] = 'PNS kena hukuman disiplin';
    $select ["16"] = 'Pemindahan dalam rangka penurunan Jabatan';
    $select ["20"] = 'Masa Persiapan Pensiun';
    $select ["66"] = 'Diberhentikan';
    $select ["67"] = 'Punah';
    $select ["69"] = 'TMS Dari Pengadaan';
    $select ["70"] = 'Pembatalan NIP';
    $select ["77"] = 'Pemberhentian tanpa hak pensiun';
    $select ["88"] = 'Pemberhentian dengan hak pensiun';
    $select ["98"] = 'Mencapai BUP';
    $select ["99"] = 'Pensiun';
    
    return $select;
  }

  function kode_ese($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Eselon';
    }else{
      $select [''] = '-';
    }
    $select [11] = 'Eselon IA';
    $select [12] = 'Eselon IB';
    $select [21] = 'Eselon IIA';
    $select [22] = 'Eselon IIB';
    $select [31] = 'Eselon IIIA';
    $select [32] = 'Eselon IIIB';
    $select [41] = 'Eselon IVA';
    $select [42] = 'Eselon IVB';
    $select [51] = 'Eselon VA';
    $select [52] = 'Eselon VB';
    $select [99] = 'Non-Esselon';
    
    return $select;
  }

  function bulan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Bulan';
    }else{
      $select [''] = '-';
    }
    $select [1] = 'Januari';
    $select [2] = 'Februari';
    $select [3] = 'Maret';
    $select [4] = 'April';
    $select [5] = 'Mei';
    $select [6] = 'Juni';
    $select [7] = 'Juli';
    $select [8] = 'Agustus';
    $select [9] = 'September';
    $select [10] = 'Oktober';
    $select [11] = 'November';
    $select [12] = 'Desember';
    
    return $select;
  }

  function tahapan_skp_pelaku($asRef=false)
  {
    $select ['buat'] = 'Pegawai';
    $select ['draft'] = 'Pegawai';
    $select ['aju_penilai'] = 'Pegawai';
    $select ['koreksi_penilai'] = 'Pejabat Penilai';
    $select ['revisi_penilai'] = 'Pegawai';
    $select ['acc_penilai'] = 'Pejabat Penilai';
    $select ['aju_verifikatur'] = 'Pejabat Penilai';
    $select ['koreksi_verifikatur'] = 'Verifikatur';
    $select ['revisi_verifikatur'] = 'Pegawai';
    $select ['acc_verifikatur'] = 'Verifikatur';
    return $select;
  }

  function tahapan_skp_nomor($asRef=false)
  {
    $select ['buat'] = 1;
    $select ['draft'] = 2;
    $select ['aju_penilai'] = 3;
    $select ['koreksi_penilai'] = 4;
    $select ['revisi_penilai'] = 5;
    $select ['acc_penilai'] = 6;
	$select ['aju_verifikatur'] = 7;
    $select ['koreksi_verifikatur'] = 8;
    $select ['revisi_verifikatur'] = 9;
    $select ['acc_verifikatur'] = 10;

    return $select;
  }
  function tahapan_skp($asRef=false)
  {
    $select ['buat'] = 'Pembuatan SKP';
    $select ['draft'] = 'Pengisan target sasaran kerja pegawai';
    $select ['aju_penilai'] = 'Pengajuan target sasaran kerja pegawai kepada Pejabat Penilai';
    $select ['koreksi_penilai'] = 'Koreksi target sasaran kerja pegawai oleh Pejabat Penilai';
    $select ['revisi_penilai'] = 'Revisi target sasaran kerja pegawai oleh Pegawai';
    $select ['acc_penilai'] = 'Persetujuan target sasaran kerja pegawai oleh Pejabat Penilai';
    $select ['aju_verifikatur'] = 'Pengajuan target sasaran kerja pegawai kepada Verifikatur';
    $select ['koreksi_verifikatur'] = 'Koreksi target sasaran kerja pegawai oleh Verifikatur';
    $select ['revisi_verifikatur'] = 'Revisi target sasaran kerja pegawai oleh Pegawai';
    $select ['acc_verifikatur'] = 'Persetujuan target sasaran kerja pegawai oleh Verifikatur';

    return $select;
  }

  function tahapan_realisasi($asRef=false)
  {
    $select ['buat'] = 'Pembuatan Realisasi SKP';
    $select ['draft'] = 'Pengisan realisasi sasaran kerja pegawai';
    $select ['aju_penilai'] = 'Pengajuan realisasi sasaran kerja pegawai kepada Pejabat Penilai';
    $select ['koreksi_penilai'] = 'Koreksi realisasi sasaran kerja pegawai oleh Pejabat Penilai';
    $select ['revisi_penilai'] = 'Revisi realisasi sasaran kerja pegawai oleh Pegawai';
    $select ['acc_penilai'] = 'Persetujuan realisasi sasaran kerja pegawai oleh Pejabat Penilai';
    $select ['aju_verifikatur'] = 'Pengajuan realisasi sasaran kerja pegawai kepada Verifikatur';
    $select ['koreksi_verifikatur'] = 'Koreksi realisasi sasaran kerja pegawai oleh Verifikatur';
    $select ['revisi_verifikatur'] = 'Revisi realisasi sasaran kerja pegawai oleh Pegawai';
    $select ['acc_verifikatur'] = 'Persetujuan realisasi sasaran kerja pegawai oleh Verifikatur';
    return $select;
  }

  // status tunjangan pernikahan
  function alwMarStat() {
    return array('' => 'Pilih status tunjangan' , '1' => '(1) Dapat', '0' => '(0) Tidak Dapat' );
  }

  function activeStat() {
    return array('' => 'Pilih status aktif' , '1' => '(1) AKTIF', '0' => '(0) NON-AKTIF' );
  }
}
