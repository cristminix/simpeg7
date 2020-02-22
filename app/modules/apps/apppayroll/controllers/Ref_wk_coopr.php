<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


require_once 'apppayroll_frontctl.php';

/*
 * Worker Cooperative Reference Setup
 */

class Ref_Wk_Coopr extends Apppayroll_Frontctl {
    public $main_mdl = "ref_wk_coopr_mdl";
    
    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
//        $detail = array();
        if ($id) {
            $detail = $this->{$mdl}->fetch_detail($id);
            $data   = array('employee' => $detail);
            $this->set_data($data);
            return $this->print_page($tpl . '_detail');
        }
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $ls       = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang('Worker Cooperative Setup'));
        $this->set_pagination($mdl);
        
        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    
    }

}
