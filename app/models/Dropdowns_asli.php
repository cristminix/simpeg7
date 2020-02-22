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
  function jenis_jabatan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Jabatan';
    }else{
      $select [''] = '-';
    }
    $select ['js'] = 'Jabatan Struktural';
    $select ['jfu'] = 'Jabatan Fungsional Umum';
    $select ['jft'] = 'Jabatan Fungsional Tertentu';
    // $select ['jft-staff'] = 'Staff ';
    
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
  function rumpun_diklat_struk($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Diklat';
    }else{
      $select [''] = '-';
    }
    $select [1] = 'Diklat PIM IV';
    $select [2] = 'Diklat PIM III';
    $select [3] = 'Diklat PIM II';
    $select [4] = 'Diklat PIM I';
    
    return $select;
  }
  function kode_jenjang_pendidikan($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenjang Pendidikan';
    }else{
      $select [''] = '-';
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
  function kode_golongan_pangkat($asRef=false)
  {
    if(!$asRef){
    $select [''] = 'Pilih Golongan';
    }else{
      $select [''] = '-';
    }
    $select [11] = 'I/a, Juru Muda';
    $select [12] = 'I/b, Juru Muda Tingkat I';
    $select [13] = 'I/c, Juru';
    $select [14] = 'I/d, Juru Tingkat I';
    $select [21] = 'II/a, Pengatur Muda';
    $select [22] = 'II/b, Pengatur Muda Tingkat I';
    $select [23] = 'II/c, Pengatur';
    $select [24] = 'II/d, Pengatur Tingkat I';
    $select [31] = 'III/a, Penata Muda';
    $select [32] = 'III/b, Penata Muda Tingkat I';
    $select [33] = 'III/c, Penata';
    $select [34] = 'III/d, Penata Tingkat I';
    $select [41] = 'IV/a, Pembina';
    $select [42] = 'IV/b, Pembina Tingkat I';
    $select [43] = 'IV/c, Pembina Utama Muda';
    $select [44] = 'IV/d, Pembina Utama Madya';
    
    return $select;
  }
  function kode_jenis_kp($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis KP';
    }else{
      $select [''] = '-';
    }
    $select [101] = 'Reguler';
    $select [201] = 'Pilihan  (Jabatan Struktural)';
    $select [202] = 'Pilihan  (Jabatan Fungsional Tertentu)';
    $select [203] = 'Pilihan  (Penyesuaian Ijazah)';
    $select [204] = 'Pilihan  (Sedang Melaksanakan Tugas Belajar)';
    $select [205] = 'Pilihan  (Setelah Selesai Tugas Belajar)';
    $select [211] = 'Gol. dari Pengadaan CPNS/PNS';
    
    return $select;
  }
  function kedudukan_hukum($asRef=false)
  {
    if(!$asRef){
      $select [''] = 'Pilih Jenis Kedudukan Hukum';
    }else{
      $select [''] = '-';
    }
    $select [01] = 'Aktif';
    $select [02] = 'CLTN';
    $select [03] = 'Tugas Belajar';
    $select [04] = 'Pemberhentian Sementara';
    $select [05] = 'Penerima Uang Tunggu';
    $select [06] = 'Prajurit Wajib';
    $select [07] = 'Pejabat Negara';
    $select [08] = 'Kepala Desa';
    $select [09] = 'Sedang dlm Proses Banding BAPEK';
    $select [11] = 'Pegawai Titipan';
    $select [12] = 'Pengungsi';
    $select [13] = 'Perpanjangan CLTN';
    $select [14] = 'PNS yang dinyatakan hilang';
    $select [15] = 'PNS kena hukuman disiplin';
    $select [16] = 'Pemindahan dalam rangka penurunan Jabatan';
    $select [20] = 'Masa Persiapan Pensiun';
    $select [66] = 'Diberhentikan';
    $select [67] = 'Punah';
    $select [69] = 'TMS Dari Pengadaan';
    $select [70] = 'Pembatalan NIP';
    $select [77] = 'Pemberhentian tanpa hak pensiun';
    $select [88] = 'Pemberhentian dengan hak pensiun';
    $select [98] = 'Mencapai BUP';
    $select [99] = 'Pensiun';
    
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


}
