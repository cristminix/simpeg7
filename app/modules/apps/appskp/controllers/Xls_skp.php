<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Xls_skp extends MX_Controller {

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
		$id_skp = $this->session->userdata('id_skp');
		$bulan = $this->dropdowns->bulan();
		$val = $this->m_skp->ini_skp($id_skp);
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



///////////////////////////////////////////////////////////////////////////
$filename='skp_target.xls'; //save our workbook as this file name
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