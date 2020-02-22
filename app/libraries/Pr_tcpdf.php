<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
if (!defined('PR_TCPDF_ROOT')) {
    define('PR_TCPDF_ROOT', dirname(__FILE__) . '/');
    require_once PR_TCPDF_ROOT . 'TCPDF' . DIRECTORY_SEPARATOR . 'tcpdf' . EXT;
}

class Pr_tcpdf {
    
    public $pdf;
    
    public function _init($paper_size=null, $page_orientation= NULL){
        if(! $paper_size){
            $paper_size = PDF_PAGE_FORMAT;
        }
        if(! $page_orientation){
            $page_orientation = PDF_PAGE_ORIENTATION;
        }
        $this->pdf = new TCPDF($page_orientation, PDF_UNIT, $paper_size, true, 'UTF-8', false);
    }
    
    public function render($fn){
        $this->pdf->Output($fn, 'I');
    }
    
    
}
