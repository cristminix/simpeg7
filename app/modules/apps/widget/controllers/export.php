<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Export extends MX_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
	}

///////////////////////////////////////////////////////////////////////////////////
function save($cols,$data,$title){


$this->load->library('myexcel');

$this->myexcel->setActiveSheetIndex(0);
//name the worksheet
$this->myexcel->getActiveSheet()->setTitle("export data");
//set cell A1 content with some text
$this->myexcel->getActiveSheet()->setCellValue('B1', $title);
//change the font size
$this->myexcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(20);
//make the font become bold
$this->myexcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
//$this->myexcel->getActiveSheet()->getColumnDimension("B")->setWidth(25);


$this->myexcel->getActiveSheet()->getRowDimension(4)->setRowHeight(30);

$styleArray2 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
);
$styleArray3 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
);
$styleArray4 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,), 
      ),
);

$styleArray = array(
      'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
      ),
      'font' => array(
        'name' => 'Arial',
        'size' => '12',
		'bold' => true,
      ),
      'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array('rgb' => 'CCCCCC',),
      ),
	  'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE,)
      )
);

$basicStyle = array(
	  'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,)
      )
);

$rc=2;
$periode="";
// $this->myexcel->getActiveSheet()->setCellValue('B'.$rc, $periode);
$rc=4;
	$this->myexcel->getActiveSheet()->setCellValue('B'.$rc, 'No.');
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray2);
	$this->myexcel->getActiveSheet()->getStyle('B'.$rc)->applyFromArray($styleArray);
$columns = explode(",",$cols);
$alphabet = range("A","Z");
$al	     = "2";
$i=1;

$lengths = count($data);

foreach($columns as $column){
	$col = explode(":",$column);
	$this->myexcel->getActiveSheet()->setCellValue($alphabet[$al].$rc, strtoupper($col[1]));
	if( !each( $columns ) ) {
		$this->myexcel->getActiveSheet()->getStyle($alphabet[$al].$rc)->applyFromArray($styleArray4);
	}else{
		$this->myexcel->getActiveSheet()->getStyle($alphabet[$al].$rc)->applyFromArray($styleArray3);
	}
	$this->myexcel->getActiveSheet()->getStyle($alphabet[$al].$rc)->applyFromArray($styleArray);
	
	$w = mb_strlen(strtoupper($col[1]));
	if ( !isset($maxwidth[$alphabet[$al]]) ) $maxwidth[$alphabet[$al]] = $w;
	elseif ( $w > $maxwidth[$alphabet[$al]] ) $maxwidth[$alphabet[$al]] = $w;
	$rcd =5;
	foreach($data as $key=>$val){
		$this->myexcel->getActiveSheet()->setCellValue($alphabet[$al].$rcd, $data[$key][$col[0]]);
		$this->myexcel->getActiveSheet()->getStyle($alphabet[$al].$rcd)->applyFromArray($basicStyle);
		$rcd++;
	}
	$al = $al+1;
}
$ii = 5;
for($i=1;$i<=$lengths;$i++){
		$this->myexcel->getActiveSheet()->setCellValue('B'.$ii, $i);
		$this->myexcel->getActiveSheet()->getStyle('B'.$ii)->applyFromArray($basicStyle);
		$ii++;
	}
foreach($maxwidth as $col=>$width)
    {
        $this->myexcel->getActiveSheet()->getColumnDimension( $col )->setAutoSize( false );
        $this->myexcel->getActiveSheet()->getColumnDimension( $col )->setWidth( (int)($width * 2.6) ); // add padding as well
    }


$this->myexcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

$styleArray5 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_HAIR,), 
      ),
);
$styleArray6 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
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

$styleArray8 = array(
      'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray9 = array(
      'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
$styleArray10 = array(
      'borders' => array(
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN,), 
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM,), 
      ),
);
//$this->myexcel->getActiveSheet()->mergeCells('B'.$rc.':N'.$rc);

///////////////////////////////////////////////////////////////////////////
$filename='data_export.xls'; //save our workbook as this file name

             
//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
//if you want to save it as .XLSX Excel 2007 format
$objWriter = PHPExcel_IOFactory::createWriter($this->myexcel, 'Excel5');  
//force user to download the Excel file without writing it to server's HD
$filePath = './assets/file/excel/'.$filename;
$fileUrl  = base_url().'assets/file/excel/'.$filename;
$objWriter->save($filePath);
return $fileUrl;
}


}

