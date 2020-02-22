<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Zkt_Sh extends Apppayroll_Frontctl {

    public $main_mdl = "zkt_sh_mdl";

    protected function _do_edit($mdl, $id) {
        $tpl = 'edit_detail';

        $post = $this->input->post();
        if ($post) {
            $this->_do_edit_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url = $this->session->userdata(__FILE__ . 'back');

        $rs_form_input                   = array(
            'back_url' => $back_url
        );
        $rs_form_input[md5('id')]        = array(
            'value' => $detail->id
        );
        $rs_form_input[md5('print_dt')]  = array(
            'value' => $detail->print_dt
        );
        $rs_form_input[md5('zakat_amt')] = array(
            'value' => $detail->zakat_amt
        );
        $rs_form_input['zakat_amt']      = array(
            'value' => $detail->zakat_amt
        );

        $rs_form_input[md5('shodaqoh_amt')] = array(
            'value' => $detail->shodaqoh_amt
        );

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Zakat & Shodaqoh") . ': ' . sprintf('[%s][%s] %s ', $detail->print_dt, $detail->nipp, $detail->empl_name));
        return $this->print_page($tpl);
    }

    protected function _do_edit_post($mdl, $id, $input) {
        if (!$input) {
            return;
        }
        extract($input);

        $id       = filter_var($data[md5('id')], FILTER_SANITIZE_NUMBER_INT);
        $print_dt = filter_var($data[md5('print_dt')], FILTER_SANITIZE_STRING);
        $zkt      = filter_var($data[md5('zakat_amt')], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $shq      = filter_var($data[md5('shodaqoh_amt')], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $data     = array(
            'zakat_amt'    => $zkt,
            'shodaqoh_amt' => $shq,
        );
        $where    = array(
           
                'print_dt'=>$print_dt
           
        );
        $this->{$mdl}->update_row_by_id($id, $data, $where);
    }

    public function edit($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        if ($id) {
            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(__FILE__ . 'back', base_url(uri_string()));
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Zakat & Shodaqoh Management"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

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
        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Zakat & Shodaqoh Administration"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

}
