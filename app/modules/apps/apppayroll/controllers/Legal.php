<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Legal extends Apppayroll_Frontctl {

    public $main_mdl = "legal_mdl";
    
    public function add() {        
        $this->print_page('form');
    }
    public function del() {        
        $this->print_page();
    }
    public function edit() {        
        $this->print_page();
    }
    public function index($eid = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {        
        $tpl = __FUNCTION__;
//        $detail = array();
        if ($eid) {
            $detail = $this->{$this->main_mdl}->fetch_detail($eid);
            $data   = array('document' => $detail);
            $this->set_data($data);
            return $this->print_page($tpl . '_detail');
        }
        $this->set_form_filter();
        $ls       = $this->{$this->main_mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang('Legal Documents'));
        $this->set_pagination();
        
        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }
    

}
