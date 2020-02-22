<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!defined('EXT'))
    define('EXT', '.php');

if (!defined('PR_PHPEXCEL_ROOT')) {
    define('PR_PHPEXCEL_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

    require_once PR_PHPEXCEL_ROOT . 'PHPExcel' . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . 'PHPExcel' . EXT;
}

class Pr_phpexcel {

    public $obj;
    protected $ext_xlsx   = '.xlsx';
    protected $valid_meta = array(
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

//    public function __construct() {
//        parent::__construct();
//    }

    public function _init() {
        $objPHPExcel = new PHPExcel;
        $objPHPExcel->getProperties()
            ->setCreator("Sutrisno Hadi")
            ->setLastModifiedBy("Sutrisno Hadi")
            ->setTitle("Office 2007 XLSX Document")
            ->setSubject("Office 2007 XLSX Document")
            ->setDescription("Document for Office 2007 XLSX, generated using
PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Generated PHPExcel file");
        $this->obj   = $objPHPExcel;
    }

    public function _init_from_file($fn) {
        $this->obj = PHPExcel_IOFactory::load($fn);
    }

    public function dataFromArray($array, $startCell = 'A1', $ws = '0') {

        $this->obj->getActiveSheet()
            ->fromArray(
                $array, // The data to set
                NULL, // Array values with this value will not be set
                $startCell         // Top left coordinate of the worksheet range where
                //    we want to set these values (default is A1)
        );
    }

    public function download_xlsx($filename = 'xlsx_document') {
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header(sprintf('Content-Disposition: attachment;filename="%s%s"', $filename, $this->ext_xlsx));
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($this->obj, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function getRows($ws_index = '0') {
        return $this->obj->getActiveSheet()->getRowIterator();
    }

//    $date = date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($objWorksheet->getCellByColumnAndRow(1, $i)->getValue()));
    public function getList($start_row = 1, $end_row = null, $start_col = 'A', $end_col = null, $date_columns = array()) {
        $obj                = $this->obj->getActiveSheet();
        $highestRow         = $end_row ? $end_row : $obj->getHighestRow(); // e.g. 10
        $highestColumn      = $end_col ? $end_col : $obj->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
        $list               = array();

        for ($row = $start_row; $row <= $highestRow; ++$row) {

            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                $list[$row][$col] = $obj->getCellByColumnAndRow($col, $row)->getValue();
                if (in_array($col, $date_columns) && $list[$row][$col]) {
                    $list[$row][$col] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($list[$row][$col]));
                }
            }
        }
        return $list;
    }

    public function getCellValue($cell, $ws_index = '0') {
        return $this->obj->getActiveSheet()->getCell($cell)->getValue();
    }

    public function is_valid_meta($meta) {
        return in_array($meta, $this->valid_meta);
    }

    public function merge($range, $ws = '0') {
        $this->obj->getActiveSheet()->mergeCells($range);
    }

    public function setAlignment($range, $halign = null, $valign = null, $ws_index = '0') {
        // $objPHPExcel->getActiveSheet()->getStyle('B2')
//    ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $obj       = $this->obj->getActiveSheet()->getStyle($range)->getAlignment();
        $halignObj = null;
        switch ($halign) {
            case 'c':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_CENTER;
                break;
            case 'cc':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS;
                break;
            case 'd':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_DISTRIBUTED;
                break;
            case 'f':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_FILL;
                break;
            case 'g':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_GENERAL;
                break;
            case 'j':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY;
                break;
            case 'l':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_LEFT;
                break;
            case 'r':
                $halignObj = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT;
                break;
            default:
                $halignObj = null;
                break;
        }
        if ($halignObj) {
            $obj->setHorizontal($halignObj);
        }
        $valignObj = null;
        switch ($valign) {
            case 'b':
                $valignObj = PHPExcel_Style_Alignment::VERTICAL_BOTTOM;
                break;
            case 'c':
                $valignObj = PHPExcel_Style_Alignment::VERTICAL_CENTER;
                break;
            case 'd':
                $valignObj = PHPExcel_Style_Alignment::VERTICAL_DISTRIBUTED;
                break;
            case 'j':
                $valignObj = PHPExcel_Style_Alignment::VERTICAL_JUSTIFY;
                break;
            case 't':
                $valignObj = PHPExcel_Style_Alignment::VERTICAL_TOP;
                break;

            default:
                $valignObj = null;
                break;
        }
        if ($valignObj) {
            $obj->setVertical($valignObj);
        }
    }

    public function setFillColor($range, $argb) {
//        $objPHPExcel->getActiveSheet()->getStyle('B3:B7')->getFill()
//    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
//    ->getStartColor()->setARGB('FFFF0000');
        $obj = $this->obj->getActiveSheet()->getStyle($range)->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB($argb);
    }

    public function sheetAutosize($left_col, $right_col, $ws_index = '0') {
        /**
         * support only from A to Z
         */
        $obj   = $this->obj->getActiveSheet();
        $start = ord($left_col);
        if ($start < 65 || $start > 90) {
            return;
        }
        $end = ord($right_col);
        if ($end < 65 || $end > 90) {
            return;
        }
        for ($i = $start; $i <= $end; $i++) {
            $obj->getColumnDimension(chr($i))->setAutoSize(true);
        }
    }

    public function sheetTitle($title, $ws = '0') {
        $this->obj->getActiveSheet()->setTitle($title);
    }

    public function setValues($data, $col_start = '0', $row_start = '1', $date_columns = array(), $custom_format = [], $explicit= []) {
        if (!$data) {
            return;
        }
        
        $sheet = $this->obj->getActiveSheet();
        foreach ($data as $i => $rows) {
            foreach ($rows as $n => $cell) {
                if (in_array($n + $col_start, $date_columns) && $cell) {
                    $t_year  = substr($cell, 0, 4);
                    $t_month = substr($cell, 5, 2);  // Fixed problems with offsets
                    $t_day   = substr($cell, 8, 2);
                    $t_date  = PHPExcel_Shared_Date::FormattedPHPToExcel($t_year, $t_month, $t_day);
                    $sheet->setCellValueByColumnAndRow($n + $col_start, $i + $row_start, $t_date);
                    $sheet->getStyleByColumnAndRow($n + $col_start, $i + $row_start)
                        ->getNumberFormat()->setFormatCode(
                        PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2
                    );
                    continue;
                }
                
                if (isset($explicit[$n + $col_start]) && $cell) {
                    
                    $sheet->getCellByColumnAndRow($n + $col_start, $i + $row_start)->setValueExplicit($cell,$explicit[$n + $col_start]);
                    continue;
                }
                $sheet->setCellValueByColumnAndRow($n + $col_start, $i + $row_start, $cell);
                if (isset($custom_format[$n + $col_start]) && $cell) {
                    
                    // $sheet->setCellValueByColumnAndRow($n + $col_start, $i + $row_start, money_format ( '%i',$cell));
                    $sheet->getStyleByColumnAndRow($n + $col_start, $i + $row_start)
                        ->getNumberFormat()->setFormatCode($custom_format[$n + $col_start]);
                    continue;
                }
            }
        }
    }

}
