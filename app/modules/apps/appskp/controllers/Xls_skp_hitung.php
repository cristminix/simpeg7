<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Xls_skp_hitung extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
		$this->load->model('appskp/m_penilaian');
		$this->load->model('appbkpp/m_pegawai');
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
function index(){
$this->load->library('myexcel');

$styleArray2 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray3 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray3a = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray3b = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray3c = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray4 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
        'name' => 'Arial',
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray4b = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
        'name' => 'Arial',
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray4c = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
        'name' => 'Arial',
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
);
$styleArray5 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR,), 
      ),
      'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_TOP,
      ),
);
$styleArray5a = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
);
$styleArray6 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR,), 
      ),
);
$styleArray6a = array(
      'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR,), 
      ),
);
$styleArray7 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR,), 
      ),
);
$styleArray7a = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
);
$styleArray7b = array(
      'borders' => array(
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_HAIR,), 
      ),
);
$styleArray8 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8a = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
);
$styleArray8aa = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8b = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
);
$styleArray8ba = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
);
$styleArray8c = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
      ),
);
$styleArray8d = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8e = array(
      'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8f = array(
      'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8g = array(
      'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8h = array(
      'borders' => array(
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8i = array(
      'borders' => array(
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray8j = array(
      'borders' => array(
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray9 = array(
      'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
        'name' => 'Arial',
		'bold' => true,
      ),
);

$styleArray10 = array(
      'borders' => array(
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray10b = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
//////////////////////////////////////////
		$id_pegawai = $this->session->userdata('pegawai_info');
		$tahun = $this->session->userdata('tahun_skp');
		$bulan = $this->dropdowns->bulan();
		$data['skp_tahun'] = $this->m_penilaian->get_skp_tahun($id_pegawai,$tahun);
//////////////////////////////////////////
$this->myexcel->setActiveSheetIndex(0);
$this->myexcel->getActiveSheet()->setTitle('SKP');

$this->myexcel->getActiveSheet()->getPageSetup()->setScale(85);
$this->myexcel->getActiveSheet()->getPageMargins()->setLeft(.4);
$this->myexcel->getActiveSheet()->getPageMargins()->setRight(.2);
$this->myexcel->getActiveSheet()->getColumnDimension("A")->setWidth(2);
$this->myexcel->getActiveSheet()->getColumnDimension("B")->setWidth(6);
$this->myexcel->getActiveSheet()->getColumnDimension("C")->setWidth(20);
$this->myexcel->getActiveSheet()->getColumnDimension("E")->setWidth(20);
$this->myexcel->getActiveSheet()->getColumnDimension("G")->setWidth(6);
$this->myexcel->getActiveSheet()->getColumnDimension("H")->setWidth(11);
$this->myexcel->getActiveSheet()->getColumnDimension("I")->setWidth(6);
$this->myexcel->getActiveSheet()->getColumnDimension("J")->setWidth(6);



$rc=1;
		foreach($data['skp_tahun'] as $key=>$val){

$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'FORMULIR SASARAN KERJA');
$this->myexcel->getActiveSheet()->setCellValue('B'.($rc+1), 'Pegawai Negeri Sipil');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':B'.($rc+1))->getFont()->setSize(16);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':B'.($rc+1))->getFont()->setBold(true);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':L'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('B'.($rc+1).':L'.($rc+1));
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.($rc+1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$rc++;
$rc++;
	$bulan = $this->dropdowns->bulan();
	$bulan_mulai = $bulan[$val->bulan_mulai];
	$bulan_selesai = $bulan[$val->bulan_selesai];
	$periode="PERIODE : ".$bulan_mulai." s.d. ".$bulan_selesai;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, $periode);

$rc++;
$r_perilaku = $rc;
$perilaku = $this->m_skp->get_perilaku($val->id_skp);
if(!empty($perilaku)){
	$pelayanan = $perilaku->pelayanan;
	$integritas = $perilaku->integritas;
	$komitmen =  $perilaku->komitmen;
	$disiplin =  $perilaku->disiplin;
	$kerjasama =  $perilaku->kerjasama;
	$kepemimpinan =  $perilaku->kepemimpinan;
} else {
	$pelayanan = 0;
	$integritas = 0;
	$komitmen =  0;
	$disiplin =  0;
	$kerjasama =  0;
	$kepemimpinan =  0;
}

$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'No.');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'I. PEJABAT PENILAI');
$this->myexcel->getActiveSheet()->mergeCells('C'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 'No.');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'II. PEGAWAI NEGERI SIPIL YANG DINILAI');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':K'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray4);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':L'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('O'.$rc, 'PELAYANAN');
$this->myexcel->getActiveSheet()->setCellValue('O'.($rc+1), $pelayanan);
$this->myexcel->getActiveSheet()->setCellValue('P'.$rc, 'INTEGRITAS');
$this->myexcel->getActiveSheet()->setCellValue('P'.($rc+1), $integritas);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, 'KOMITMEN');
$this->myexcel->getActiveSheet()->setCellValue('Q'.($rc+1), $komitmen);
$this->myexcel->getActiveSheet()->setCellValue('R'.$rc, 'DISIPLIN');
$this->myexcel->getActiveSheet()->setCellValue('R'.($rc+1), $disiplin);
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc, 'KERJASAMA');
$this->myexcel->getActiveSheet()->setCellValue('S'.($rc+1), $kerjasama);
$this->myexcel->getActiveSheet()->setCellValue('T'.$rc, 'KEPEMIMPINAN');
$this->myexcel->getActiveSheet()->setCellValue('T'.($rc+1), $kepemimpinan);
$rc++;
$nama_pegawai = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
$nama_penilai = ((trim($val->penilai_gelar_depan) != '-')?trim($val->penilai_gelar_depan).' ':'').$val->penilai_nama_pegawai.((trim($val->penilai_gelar_belakang) != '-')?', '.trim($val->penilai_gelar_belakang):'');
$r_nama = $rc;
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 1);
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'Nama');
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, $nama_penilai);
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 1);
	$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'Nama');
	$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, $nama_pegawai);
	$this->myexcel->getActiveSheet()->getStyle('G'.$rc.':K'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray7b);
	$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, " ");
$rc++;
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 2);
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'NIP');
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, " ".$val->penilai_nip_baru);
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 2);
	$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'NIP');
	$this->myexcel->getActiveSheet()->setCellValue('I'.$rc,  " ".$val->nip_baru);
	$this->myexcel->getActiveSheet()->getStyle('G'.$rc.':K'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray7b);
	$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, " ");
$rc++;
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 3);
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'Pangkat / Gol.Ruang');
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, $val->penilai_nama_golongan." / ".$val->penilai_nama_pangkat);
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 3);
	$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'Pangkat / Gol.Ruang');
	$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, $val->nama_golongan." / ".$val->nama_pangkat);
	$this->myexcel->getActiveSheet()->getStyle('G'.$rc.':K'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray7b);
	$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, " ");
$rc++;
	$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 4);
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'Jabatan');
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, $val->penilai_nomenklatur_jabatan);
	$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->getAlignment()->setWrapText(true);
	$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 4);
	$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'Jabatan');
	$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, $val->nomenklatur_jabatan);
	$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->getAlignment()->setWrapText(true);
	$this->myexcel->getActiveSheet()->mergeCells('I'.$rc.':L'.$rc);
	$this->myexcel->getActiveSheet()->getStyle('G'.$rc.':K'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray7b);
	$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, " ");
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':L'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$rc++;
	$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 5);
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'Unit Kerja');
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, $val->penilai_nomenklatur_pada);
	$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->getAlignment()->setWrapText(true);
	$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
	$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 5);
	$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'Unit Kerja');
	$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, $val->nomenklatur_pada);
	$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->getAlignment()->setWrapText(true);
	$this->myexcel->getActiveSheet()->mergeCells('I'.$rc.':L'.$rc);
	$this->myexcel->getActiveSheet()->getStyle('G'.$rc.':K'.$rc)->applyFromArray($styleArray6);
	$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray7b);
	$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, " ");
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':L'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'No.');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'III. KEGIATAN TUGAS JABATAN');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 'TARGET');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('J'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('K'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray4b);
$this->myexcel->getActiveSheet()->mergeCells('F'.$rc.':L'.$rc);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
$this->myexcel->getActiveSheet()->mergeCells('B'.($rc-1).':B'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->mergeCells('C'.($rc-1).':E'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, 'AK');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'KUANTITAS');
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, 'KUAL.');
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('J'.$rc, 'WAKTU');
$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('K'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->mergeCells('J'.$rc.':K'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, 'BIAYA');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray4c);

			$target = $this->m_penilaian->get_skp_tahun_target($val->id_skp);
			$i=1;
	foreach($target as $ky=>$vl){
		$rc++;
		$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, $i);
		$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
		$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, $vl->pekerjaan);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '');
		$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, '');
		$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('C'.$rc.':E'.$rc);
		$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setWrapText(true);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, $vl->ak);
		$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $vl->volume);
		$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, $vl->satuan);
		$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray6a);
		$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, $vl->kualitas);
		$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->setCellValue('J'.$rc, $vl->waktu_lama);
		$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, $vl->waktu_satuan);
		$this->myexcel->getActiveSheet()->getStyle('K'.$rc)->applyFromArray($styleArray6a);
		$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, $vl->biaya);
		$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getNumberFormat()->setFormatCode('_-* #,##0.00');
		$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray7);
		$i++;
	}
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':K'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray10);
$rc++;
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc,'Tangerang,   Januari '.$val->tahun);

$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'Pejabat Penilai');
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':D'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc,'Pegawai Negeri Sipil Yang Dinilai');
$this->myexcel->getActiveSheet()->mergeCells('H'.$rc.':L'.$rc);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$rc++;
$rc++;
$rc++;
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,$nama_penilai);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getFont()->setUnderline(true);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':D'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc,$nama_pegawai);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->getFont()->setUnderline(true);
$this->myexcel->getActiveSheet()->mergeCells('H'.$rc.':L'.$rc);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$nip_penilai=$val->penilai_nip_baru;
$nip_baru=$val->nip_baru;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,"NIP. ".$nip_penilai);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':D'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc,"NIP. ".$nip_baru);
$this->myexcel->getActiveSheet()->mergeCells('H'.$rc.':L'.$rc);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$rc=$rc+3;
		}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$this->myexcel->createSheet(NULL, 1);
$this->myexcel->setActiveSheetIndex(1);
$this->myexcel->getActiveSheet()->setTitle('PENGUKURAN');

$this->myexcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$this->myexcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$this->myexcel->getActiveSheet()->getPageMargins()->setLeft(.2);
$this->myexcel->getActiveSheet()->getPageMargins()->setRight(.2);

$this->myexcel->getActiveSheet()->getColumnDimension("A")->setWidth(3);
$this->myexcel->getActiveSheet()->getColumnDimension("B")->setWidth(6);
$this->myexcel->getActiveSheet()->getColumnDimension("C")->setWidth(40);
$this->myexcel->getActiveSheet()->getColumnDimension("D")->setWidth(10);
$this->myexcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$this->myexcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);

$this->myexcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$this->myexcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);

$this->myexcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
$this->myexcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
$this->myexcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
$this->myexcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);

$rc=2;
		foreach($data['skp_tahun'] as $key=>$val){
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'Penilaian Capaian Sasaran Kerja');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getFont()->setSize(20);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getFont()->setBold(true);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':S'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$rc++;
	$bulan_mulai = $bulan[$val->bulan_mulai];
	$bulan_selesai = $bulan[$val->bulan_selesai];
	$periode="PERIODE : ".$bulan_mulai." s.d. ".$bulan_selesai;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, $periode);

$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'No.');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'I. KEGIATAN TUGAS JABATAN');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, 'TARGET');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('J'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, 'REALISASI');
$this->myexcel->getActiveSheet()->getStyle('K'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('N'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('O'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('O'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('P'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('P'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc)->applyFromArray($styleArray3a);
$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('R'.$rc, 'PERHITUNGAN');
$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->getFont()->setSize(8);
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc, 'CAPAIAN');
$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray4);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
$this->myexcel->getActiveSheet()->mergeCells('B'.($rc-1).':B'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->mergeCells('C'.($rc-1).':C'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, 'AK');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, 'KUANTITAS');
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':F'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'KUAL.');
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, 'WAKTU');
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->mergeCells('H'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('J'.$rc, 'BIAYA');
$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, 'AK');
$this->myexcel->getActiveSheet()->getStyle('K'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, 'KUANTITAS');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->mergeCells('L'.$rc.':M'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('N'.$rc, 'KUAL.');
$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('O'.$rc, 'WAKTU');
$this->myexcel->getActiveSheet()->getStyle('O'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('P'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('P'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->mergeCells('O'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, 'BIAYA');
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc)->applyFromArray($styleArray3b);
$this->myexcel->getActiveSheet()->setCellValue('R'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray3);
$this->myexcel->getActiveSheet()->mergeCells('R'.($rc-1).':R'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray4);
$this->myexcel->getActiveSheet()->mergeCells('S'.($rc-1).':S'.$rc);
$rc++;
$i=1;
			$target = $this->m_penilaian->get_skp_tahun_target($val->id_skp);
			$data['skp_tahun'][$key]->target = $this->m_penilaian->get_skp_tahun_target($val->id_skp);
$mulai = $rc;
	foreach($target as $ky=>$vl){
	$realisasi = $this->m_penilaian->get_skp_tahun_realisasi($vl->id_target);
		if(!empty($realisasi)){
			if($vl->volume!=0){
					$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, $i);
					$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
					$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, $vl->pekerjaan);
					$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setWrapText(true);
					$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, $vl->ak);
					$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, $vl->volume);
					$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, $vl->satuan);
					$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray6a);
					$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $vl->kualitas);
					$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, $vl->waktu_lama);
					$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, $vl->waktu_satuan);
					$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray6a);
					$this->myexcel->getActiveSheet()->setCellValue('J'.$rc, $vl->biaya);
					$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->getStyle('J'.$rc)->getNumberFormat()->setFormatCode('_-* #,##0.00');
					$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, $realisasi->ak);
					$this->myexcel->getActiveSheet()->getStyle('K'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, $realisasi->volume);
					$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, $vl->satuan);
					$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->applyFromArray($styleArray6a);
					$this->myexcel->getActiveSheet()->setCellValue('N'.$rc, $realisasi->kualitas);
					$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('O'.$rc, $realisasi->waktu_lama);
					$this->myexcel->getActiveSheet()->getStyle('O'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->setCellValue('P'.$rc, $vl->waktu_satuan);
					$this->myexcel->getActiveSheet()->getStyle('P'.$rc)->applyFromArray($styleArray6a);
					$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, $realisasi->biaya);
					$this->myexcel->getActiveSheet()->getStyle('Q'.$rc)->applyFromArray($styleArray6);
					$this->myexcel->getActiveSheet()->getStyle('Q'.$rc)->getNumberFormat()->setFormatCode('_-* #,##0.00');
					$this->myexcel->getActiveSheet()->setCellValue('R'.$rc, '=AG'.$rc);
					$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray6);
					if($vl->biaya!=0 && $realisasi->biaya!=0){
						$this->myexcel->getActiveSheet()->setCellValue('S'.$rc,'=IF(J'.$rc.'="-",IF(Q'.$rc.'="-",R'.$rc.'/4,R'.$rc.'/4),R'.$rc.'/4)');
					} else {
						$this->myexcel->getActiveSheet()->setCellValue('S'.$rc,'=IF(J'.$rc.'="-",IF(Q'.$rc.'="-",R'.$rc.'/3,R'.$rc.'/3),R'.$rc.'/3)');
					}
					$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7);
					$this->myexcel->getActiveSheet()->setCellValue('U'.$rc,'=IF(E'.$rc.'>0,1,0)');
					$this->myexcel->getActiveSheet()->setCellValue('V'.$rc,'=S'.$rc);
					$this->myexcel->getActiveSheet()->setCellValue('W'.$rc,'=100-(O'.$rc.'/H'.$rc.'*100)');
					$this->myexcel->getActiveSheet()->setCellValue('X'.$rc,'=100-(Q'.$rc.'/J'.$rc.'*100)');
					$this->myexcel->getActiveSheet()->setCellValue('Y'.$rc,'=L'.$rc.'/E'.$rc.'*100');
					$this->myexcel->getActiveSheet()->setCellValue('Z'.$rc,'=N'.$rc.'/G'.$rc.'*100');
					$this->myexcel->getActiveSheet()->setCellValue('AA'.$rc,'=IF(W'.$rc.'>24,AD'.$rc.',AC'.$rc.')');
					$this->myexcel->getActiveSheet()->setCellValue('AB'.$rc,'=IF(X'.$rc.'>24,AF'.$rc.',AE'.$rc.')');
					$this->myexcel->getActiveSheet()->setCellValue('AC'.$rc,'=((1.76*H'.$rc.'-O'.$rc.')/H'.$rc.')*100');
					$this->myexcel->getActiveSheet()->setCellValue('AD'.$rc,'=76-((((1.76*H'.$rc.'-O'.$rc.')/H'.$rc.')*100)-100)');
					$this->myexcel->getActiveSheet()->setCellValue('AE'.$rc,'=((1.76*J'.$rc.'-Q'.$rc.')/J'.$rc.')*100');
					$this->myexcel->getActiveSheet()->setCellValue('AF'.$rc,'=76-((((1.76*J'.$rc.'-Q'.$rc.')/J'.$rc.')*100)-100)');
					if($vl->biaya!=0 && $realisasi->biaya!=0){
						$this->myexcel->getActiveSheet()->setCellValue('AG'.$rc,'=SUM(Y'.$rc.':AB'.$rc.')');
					} else {
						$this->myexcel->getActiveSheet()->setCellValue('AG'.$rc,'=SUM(Y'.$rc.':AA'.$rc.')');
					}
					$i++;$rc++;
		} //end if=>volume
	} //end if=>realisasi
} //end foreach=>target
$akhir=$rc;
	$this->myexcel->getActiveSheet()->setCellValue('U'.$rc,'=SUM(U'.$mulai.':U'.($rc-1).')');
	$this->myexcel->getActiveSheet()->setCellValue('V'.$rc,'=SUM(V'.$mulai.':V'.($rc-1).')');
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, "");
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, "II. TUGAS TAMBAHAN");
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, "PEJABAT PEMBERI PERINTAH");
	$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':R'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
	$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, "No. / TANGGAL SURAT PERINTAH");
	$this->myexcel->getActiveSheet()->getStyle('K'.$rc.':Q'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
	$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->setCellValue('S'.$rc, "");
	$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray4);
$rc++;
	$awal_tt = $rc;
	$tt = $this->m_skp->get_tugas_tambahan($val->id_skp);
	$nott = 0;
	foreach($tt as $ktt=>$vtt){
		$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,($nott+1));
		$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
		$this->myexcel->getActiveSheet()->setCellValue('C'.$rc,$vtt->pekerjaan);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setWrapText(true);
		$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':J'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('K'.$rc.':Q'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7);
		$rc++;$nott++;
	}
	if($nott==0){
		$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
		$this->myexcel->getActiveSheet()->setCellValue('C'.$rc,' - ');
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setWrapText(true);
		$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':J'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('K'.$rc.':Q'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7);
		$rc++;
	}

	if($nott>0){
		if($nott<3){
			$nilai_tt = 1; 
		} elseif($nott>=3 && $nott<=6){
			$nilai_tt = 2; 
		} elseif($nott>6){
			$nilai_tt = 3; 
		}
		$this->myexcel->getActiveSheet()->setCellValue('S'.$awal_tt,$nilai_tt);
		$this->myexcel->getActiveSheet()->mergeCells('S'.$awal_tt.':S'.($rc-1));
		$this->myexcel->getActiveSheet()->getStyle('S'.$awal_tt)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	}

	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, "");
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
	$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, "III. KREATIFITAS");
	$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, "PENANDATANGAN SURAT KEPUTUSAN");
	$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':R'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
	$this->myexcel->getActiveSheet()->setCellValue('K'.$rc, "No. / TANGGAL SURAT KEPUTUSAN");
	$this->myexcel->getActiveSheet()->getStyle('K'.$rc.':Q'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
	$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray3c);
	$this->myexcel->getActiveSheet()->setCellValue('S'.$rc, "");
	$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray4);
$rc++;
	$awal_kr = $rc;
	$kr = $this->m_skp->get_kreatifitas($val->id_skp);
	$nokr = 0;
	foreach($kr as $kkr=>$vkr){
		$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,($nokr+1));
		$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
		$this->myexcel->getActiveSheet()->setCellValue('C'.$rc,$vkr->kreatifitas);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setWrapText(true);
		$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':J'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('K'.$rc.':Q'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7);
		$rc++;$nokr++;
	}
	if($nokr==0){
		$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray5);
		$this->myexcel->getActiveSheet()->setCellValue('C'.$rc,' - ');
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setWrapText(true);
		$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':J'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':J'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('K'.$rc.':Q'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->mergeCells('K'.$rc.':Q'.$rc);
		$this->myexcel->getActiveSheet()->getStyle('R'.$rc)->applyFromArray($styleArray6);
		$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7);
		$rc++;
	}
	if($nokr>0){
		if($nokr<3){
			$nilai_kr = 1; 
		} elseif($nokr>=3 && $nokr<=6){
			$nilai_kr = 2; 
		} elseif($nokr>6){
			$nilai_kr = 3; 
		}
		$this->myexcel->getActiveSheet()->setCellValue('S'.$awal_kr,$nilai_kr);
		$this->myexcel->getActiveSheet()->mergeCells('S'.$awal_kr.':S'.($rc-1));
		$this->myexcel->getActiveSheet()->getStyle('S'.$awal_kr)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
	}


$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'NILAI CAPAIAN SKP');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':R'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc,'=(V'.$akhir.'/'.'U'.$akhir.')+S'.$awal_tt.'+S'.$awal_kr);
$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7a);
$this->myexcel->getActiveSheet()->setCellValue('AH'.$rc,'1');
$this->myexcel->getActiveSheet()->setCellValue('AI'.$rc,'=S'.$rc);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':R'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->mergeCells('B'.($rc-1).':R'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc,'=IF(S'.($rc-1).'<=50,"Buruk",IF(S'.($rc-1).'<=60,"Sedang",IF(S'.($rc-1).'<=75,"Cukup",IF(S'.($rc-1).'<=90.99,"Baik","Sangat Baik"))))');
$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray10b);
$rc++;
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('N'.$rc,'Tangerang, .....');
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('N'.$rc,'PEJABAT PENILAI');
$this->myexcel->getActiveSheet()->mergeCells('N'.$rc.':S'.$rc);
$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$rc++;
$rc++;
$rc++;
$nama_penilai = ((trim($val->penilai_gelar_depan) != '-')?trim($val->penilai_gelar_depan).' ':'').$val->penilai_nama_pegawai.((trim($val->penilai_gelar_belakang) != '-')?', '.trim($val->penilai_gelar_belakang):'');
$this->myexcel->getActiveSheet()->setCellValue('N'.$rc,$nama_penilai);
$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->getFont()->setUnderline(true);
$this->myexcel->getActiveSheet()->mergeCells('N'.$rc.':S'.$rc);
$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('N'.$rc,'NIP. '.$val->penilai_nip_baru);
$this->myexcel->getActiveSheet()->mergeCells('N'.$rc.':S'.$rc);
$this->myexcel->getActiveSheet()->getStyle('N'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$rc++;
$rc++;
}


////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
//if($item_n!=0){
////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
$rc++;
$rc++;
$rc++;
$r_nilai=$rc;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'NILAI AKHIR SKP');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':R'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->setCellValue('AH'.$rc,'=SUM(AH1:AH'.($rc-4).')');
$this->myexcel->getActiveSheet()->setCellValue('AI'.$rc,'=SUM(AI1:AI'.($rc-4).')');
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc,'=AI'.$rc.'/AH'.$rc);
$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray7a);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':S'.$rc)->applyFromArray(array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
            )
        ));
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':R'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->mergeCells('B'.($rc-1).':R'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('S'.$rc,'=IF(S'.($rc-1).'<=50,"Buruk",IF(S'.($rc-1).'<=60,"Sedang",IF(S'.($rc-1).'<=75,"Cukup",IF(S'.($rc-1).'<=90.99,"Baik","Sangat Baik"))))');
$this->myexcel->getActiveSheet()->getStyle('S'.$rc)->applyFromArray($styleArray10b);
$rc++;

///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$this->myexcel->createSheet(NULL, 2);
$this->myexcel->setActiveSheetIndex(2);
$this->myexcel->getActiveSheet()->setTitle('PENILAIAN');
//$this->myexcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A3);
$this->myexcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
$this->myexcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);


$this->myexcel->getActiveSheet()->getPageSetup()->setScale(75);
$this->myexcel->getActiveSheet()->getPageMargins()->setTop(.7);
$this->myexcel->getActiveSheet()->getPageMargins()->setRight(.1);
$this->myexcel->getActiveSheet()->getPageMargins()->setBottom(.4);
$this->myexcel->getActiveSheet()->getPageMargins()->setLeft(.4);

$this->myexcel->getActiveSheet()->getColumnDimension("A")->setWidth(3);
$this->myexcel->getActiveSheet()->getColumnDimension("B")->setWidth('3');
$this->myexcel->getActiveSheet()->getColumnDimension("C")->setWidth('20');
$this->myexcel->getActiveSheet()->getColumnDimension("D")->setWidth('14');
$this->myexcel->getActiveSheet()->getColumnDimension("E")->setWidth('14');
$this->myexcel->getActiveSheet()->getColumnDimension("J")->setWidth('4');
$this->myexcel->getActiveSheet()->getColumnDimension("K")->setWidth('4');
$this->myexcel->getActiveSheet()->getColumnDimension("L")->setWidth('3');
$this->myexcel->getActiveSheet()->getColumnDimension("V")->setWidth(3);

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('PHPExcel logo');
$objDrawing->setDescription('PHPExcel logo');
$objDrawing->setPath('assets/images/garuda.gif');       // filesystem reference for the image file
$objDrawing->setHeight(100);                 // sets the image height to 36px (overriding the actual image height); 
$objDrawing->setCoordinates('P29');    // pins the top-left corner of the image to cell D24
$objDrawing->setOffsetX(35);                // pins the top left corner of the image at an offset of 10 points horizontally to the right of the top-left corner of the cell
$objDrawing->setWorksheet($this->myexcel->getActiveSheet());

$rc=3;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, '4.');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'UNSUR YANG DINILAI');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':H'.$rc)->applyFromArray($styleArray8b);
$this->myexcel->getActiveSheet()->mergeCells('C'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, 'JUMLAH');
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8h);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '6. TANGGAPAN PEJABAT PENILAI ATAS KEBERATAN');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray8g);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8h);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8ba);
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'a. Sasaran Kerja Pegawai (SKP)');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=PENGUKURAN!S'.$r_nilai);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'x');
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '60%');
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '=F'.$rc.'*H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('C'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray(array(
            'borders' => array(
                'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->setCellValue('C'.$rc, 'b. Perilaku Kerja');
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '1. Orientasi Pelayanan');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=SKP!O'.($r_perilaku+1));
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, '');
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$sebut='=IF(F'.$rc.'<=50,"Buruk",IF(F'.$rc.'<=60,"Sedang",IF(F'.$rc.'<=75,"Cukup",IF(F'.$rc.'<=90.99,"Baik","Sangat Baik"))))';
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $sebut);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '2. Integritas');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=SKP!P'.($r_perilaku+1));
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, '');
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$sebut='=IF(F'.$rc.'<=50,"Buruk",IF(F'.$rc.'<=60,"Sedang",IF(F'.$rc.'<=75,"Cukup",IF(F'.$rc.'<=90.99,"Baik","Sangat Baik"))))';
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $sebut);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '3. Komitmen');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=SKP!Q'.($r_perilaku+1));
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$sebut='=IF(F'.$rc.'<=50,"Buruk",IF(F'.$rc.'<=60,"Sedang",IF(F'.$rc.'<=75,"Cukup",IF(F'.$rc.'<=90.99,"Baik","Sangat Baik"))))';
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $sebut);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);

$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '4. Disiplin');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=SKP!R'.($r_perilaku+1));
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$sebut='=IF(F'.$rc.'<=50,"Buruk",IF(F'.$rc.'<=60,"Sedang",IF(F'.$rc.'<=75,"Cukup",IF(F'.$rc.'<=90.99,"Baik","Sangat Baik"))))';
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $sebut);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '5. Kerjasama');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=SKP!S'.($r_perilaku+1));
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$sebut='=IF(F'.$rc.'<=50,"Buruk",IF(F'.$rc.'<=60,"Sedang",IF(F'.$rc.'<=75,"Cukup",IF(F'.$rc.'<=90.99,"Baik","Sangat Baik"))))';
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $sebut);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '6. Kepemimpinan');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$isi_kepemimpinan =($kepemimpinan==0)?' - ':'=SKP!T'.($r_perilaku+1);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, $isi_kepemimpinan);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$sebut =($kepemimpinan==0)?' - ':'=IF(F'.$rc.'<=50,"Buruk",IF(F'.$rc.'<=60,"Sedang",IF(F'.$rc.'<=75,"Cukup",IF(F'.$rc.'<=90.99,"Baik","Sangat Baik"))))';
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, $sebut);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '7. Jumlah');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$isi_kepemimpinan =($kepemimpinan==0)?'=SUM(F5:F9)':'=SUM(F5:F10)';
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, $isi_kepemimpinan);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '8. Nilai Rata-rata');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$isi_kepemimpinan =($kepemimpinan==0)?'=F11/5':'=F11/6';
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, $isi_kepemimpinan);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('G'.$rc.':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('D'.$rc, '9. Nilai Perilaku Kerja');
$this->myexcel->getActiveSheet()->getStyle('D'.$rc.':I'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->setCellValue('F'.$rc, '=F'.($rc-1));
$this->myexcel->getActiveSheet()->setCellValue('G'.$rc, 'x');
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->setCellValue('H'.$rc, '40%');
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '=F'.$rc.'*H'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('D'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('B4:B'.$rc);
$this->myexcel->getActiveSheet()->mergeCells('C6:C'.$rc);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '7. KEPUTUSAN ATASAN PEJABAT PENILAI ATAS KEBERATAN');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray8g);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8h);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'NILAI PRESTASI KERJA');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8a);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8h);

$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '=I4+I13');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray9);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('I'.$rc, '=IF(I14<=50,"Buruk",IF(I14<=60,"Sedang",IF(I14<=75,"Cukup",IF(I14<=90.99,"Baik","Sangat Baik"))))');
$this->myexcel->getActiveSheet()->mergeCells('B'.($rc-1).':H'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, '5. KEBERATAN DARI PEGAWAI NEGERI SIPIL YANG DINILAI (APABILA ADA)');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8h);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
//$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8f);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('D'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('F'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('G'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('H'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8j);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8f);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8j);
$rc++;
$rc++;
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc.':H'.$rc)->applyFromArray($styleArray8g);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8h);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, '8. REKOMENDASI');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, 'PENILAIAN PRESTASI KERJA');
$this->myexcel->getActiveSheet()->mergeCells('L'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getFont()->setSize(16);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getFont()->setBold(true);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, 'PEGAWAI NEGERI SIPIL');
$this->myexcel->getActiveSheet()->mergeCells('L'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getFont()->setSize(16);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->getFont()->setBold(true);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, 'BKPP');
$this->myexcel->getActiveSheet()->setCellValue('R'.$rc, 'JANGKA WAKTU PENILAIAN');
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, 'KOTA TANGERANG');
$this->myexcel->getActiveSheet()->setCellValue('R'.$rc, 'BULAN');
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '1');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'YANG DINILAI');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc.':M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':U'.$rc)->applyFromArray($styleArray8b);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8h);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'a. Nama');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!I'.$r_nama);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, '9. Dibuat tanggal: ... Januari ....');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':H'.$rc)->applyFromArray($styleArray8g);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8h);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'b. NIP');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!I'.($r_nama+1));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, 'PEJABAT PENILAI');
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'c. Pangkat / Gol.Ruang / TMT');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!I'.($r_nama+2));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'd. Jabatan / Pekerjaan');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!I'.($r_nama+3));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc,'=Q46');
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getFont()->setUnderline(true);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'e. Unit Kerja');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!I'.($r_nama+4));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc,'NIP. '.$nip_penilai);
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '2');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'PEJABAT PENILAI');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc.':M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':U'.$rc)->applyFromArray($styleArray8b);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8h);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'10. Diterima tanggal: .. Januari ....');
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'a. Nama');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!D'.$r_nama);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'Pegawai Negeri Sipil Yang Dinilai');
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'b. NIP');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!D'.($r_nama+1));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'c. Pangkat / Gol.Ruang / TMT');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!D'.($r_nama+2));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'=Q40');
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getFont()->setUnderline(true);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'd. Jabatan / Pekerjaan');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!D'.($r_nama+3));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('B'.$rc,'NIP. '.$nip_baru);
$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':E'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'e. Unit Kerja');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, '=SKP!D'.($r_nama+4));
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc,'11. Diterima tanggal .. Januari ....');
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->setCellValue('L'.$rc, '3');
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8aa);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'ATASAN PEJABAT PENILAI');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc.':M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':U'.$rc)->applyFromArray($styleArray8b);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8h);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc,'ATASAN PEJABAT PENILAI');
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'a. Nama');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$nama_atasan = $this->session->userdata('nama_atasan_penilai');
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, $nama_atasan);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'b. NIP');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$nip_atasan = $this->session->userdata('nip_atasan_penilai');
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, ' '.$nip_atasan);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc,'=Q52');
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getFont()->setUnderline(true);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'c. Pangkat / Gol.Ruang / TMT');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$pangkat_atasan = $this->session->userdata('pangkat_atasan_penilai');
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, $pangkat_atasan);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->setCellValue('E'.$rc, 'NIP. '.$nip_atasan);
$this->myexcel->getActiveSheet()->mergeCells('E'.$rc.':I'.$rc);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('E'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8i);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8d);
$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'd. Jabatan / Pekerjaan');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray6);
$jabatan_atasan = $this->session->userdata('jabatan_atasan_penilai');
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, $jabatan_atasan);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$rc++;
$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray8f);
$this->myexcel->getActiveSheet()->getStyle('C'.$rc.':H'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('I'.$rc)->applyFromArray($styleArray8j);
$this->myexcel->getActiveSheet()->getStyle('L'.$rc)->applyFromArray($styleArray8f);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc)->applyFromArray($styleArray6);

$unor_atasan = $this->session->userdata('unor_atasan_penilai');
$this->myexcel->getActiveSheet()->setCellValue('Q'.$rc, $unor_atasan);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->applyFromArray($styleArray7);
$this->myexcel->getActiveSheet()->mergeCells('Q'.$rc.':U'.$rc);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setWrapText(true);
$this->myexcel->getActiveSheet()->getStyle('Q'.$rc.':U'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$this->myexcel->getActiveSheet()->setCellValue('M'.$rc, 'e. Unit Kerja');
$this->myexcel->getActiveSheet()->getRowDimension($rc)->setRowHeight(30);
$this->myexcel->getActiveSheet()->mergeCells('M'.$rc.':P'.$rc);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc)->applyFromArray($styleArray8c);
$this->myexcel->getActiveSheet()->getStyle('M'.$rc.':T'.$rc)->applyFromArray($styleArray8e);
$this->myexcel->getActiveSheet()->getStyle('U'.$rc)->applyFromArray($styleArray8j);






///////////////////////////////////////////////////////////////////////////
$filename='skp_realisasi.xls'; //save our workbook as this file name
header('Content-Type: application/vnd.ms-excel'); //mime type
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->myexcel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$objWriter->save('php://output');
}

}
?>