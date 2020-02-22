<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php'; 

class Payslip extends Apppayroll_Frontctl {

    public $main_mdl = "payslip_mdl";
    public $contract_mdl = "payslip_contract_mdl";
    public $director_mdl = "payslip_director_mdl";
    public $supervisory_board_mdl = "payslip_supervisory_board_mdl";
    public $dash_mdl = "dashboard_mdl";

    public function _do_pdf_preview($alias) {

    }

    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl         = __FUNCTION__;
        $pdf_preview = md5('pdf-preview' . date('ymd'));
        $set_archive = md5('set-archive' . date('ymd'));
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);


        //        $detail = array();
        if ($id) {
            if ($id === $pdf_preview) {

                $tpl .= '_pdf';
                $this->layout = 'layouts/blank';
                $this->elements_page_wrapper = 'elements/page_wrapper_blank';
            } elseif ($id === $set_archive) {
                
                $salt = date('ymd');
                $expl = explode($salt,base64_decode($cur_page), 2);
                $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                return $this->{$mdl}->set_archive($expl[1], $back_url);
            } else {
                $detail           = $this->{$mdl}->fetch_detail($id);
                if($detail) {
                    $data             = array('detail' => $detail);
                    $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                    $data['back_url'] = $back_url;
                    $this->set_data($data);
                    return $this->print_page($tpl . '_detail');
                }
                
            }
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);


        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
//         $this->{$mdl}->rs_index_where = " ( empl_stat != 'Kontrak' AND job_title != 'Direktur' AND job_title != 'Dewan Pengawas')";
        $ls     = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Employee Payslip') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function permanent($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {

        $tpl         = __FUNCTION__;
        $pdf_preview = md5('pdf-preview' . date('ymd'));
        $set_archive = md5('set-archive' . date('ymd'));
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);


        //        $detail = array();
        if ($id) {
            if ($id === $pdf_preview) {

                $tpl .= '_pdf';
                $this->layout = 'layouts/blank';
                $this->elements_page_wrapper = 'elements/page_wrapper_blank';
            } elseif ($id === $set_archive) {
                
                $salt = date('ymd');
                $expl = explode($salt,base64_decode($cur_page), 2);
                $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                return $this->{$mdl}->set_archive($expl[1], $back_url);
            } else {
                $detail           = $this->{$mdl}->fetch_detail($id);
                if($detail) {
                    $data             = array('detail' => $detail);
                    $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                    $data['back_url'] = $back_url;
                    $this->set_data($data);
                    return $this->print_page($tpl . '_detail');
                }
                
            }
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));

        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);

        $this->load_mdl($this->dash_mdl);
        $print_dt = date('Y-m-t', strtotime($this->{$mdl}->rs_cf_cur_year . '-' . $this->{$mdl}->rs_cf_cur_month . '-01'));

        $this->{$mdl}->rs_index_where = $this->{$this->dash_mdl}->get_filter_by_group('permanent', $print_dt);
        $this->{$mdl}->update_base_sal($this->{$mdl}->rs_index_where);
        $this->{$mdl}->update_base_sal($this->{$this->dash_mdl}->get_filter_by_group('contract', $print_dt));
        $this->{$mdl}->update_base_sal_dir();
        $this->{$mdl}->update_base_sal_spv();
        $ls     = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Probation & Permanent Employement Payslip') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function contract($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl         = __FUNCTION__;
        $pdf_preview = md5('pdf-preview' . date('ymd'));
        $set_archive = md5('set-archive' . date('ymd'));
        $this->main_mdl = $this->contract_mdl;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
//        $detail = array();
        if ($id) {
            if ($id === $pdf_preview) {

                $tpl .= '_pdf';
                $this->layout = 'layouts/blank';
                $this->elements_page_wrapper = 'elements/page_wrapper_blank';
            } elseif ($id === $set_archive) {
                
                $salt = date('ymd');
                $expl = explode($salt,base64_decode($cur_page), 2);
                $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                return $this->{$mdl}->set_archive($expl[1], $back_url);

            } else {
                $detail           = $this->{$mdl}->fetch_detail($id);
                if($detail) {
                    $data             = array('detail' => $detail);
                    $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                    $data['back_url'] = $back_url;
                    $this->set_data($data);
                    return $this->print_page($tpl . '_detail');
                }
                
            }
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->load_mdl($this->dash_mdl);
        $print_dt                     = date('Y-m-t', strtotime($this->{$mdl}->rs_cf_cur_year . '-' . $this->{$mdl}->rs_cf_cur_month . '-01'));
        $this->{$mdl}->rs_index_where = $this->{$this->dash_mdl}->get_filter_by_group('contract', $print_dt);
        $this->{$mdl}->update_base_sal($this->{$mdl}->rs_index_where);
        $this->{$mdl}->update_base_sal($this->{$this->dash_mdl}->get_filter_by_group('permanent', $print_dt));
        $this->{$mdl}->update_base_sal_dir();
        $this->{$mdl}->update_base_sal_spv();
        $ls                           = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period                       = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Contract Employement Payslip') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function directors($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl         = __FUNCTION__;
        $pdf_preview = md5('pdf-preview' . date('ymd'));
        $set_archive = md5('set-archive' . date('ymd'));
        $this->main_mdl = $this->director_mdl;

        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
//        $detail = array();
        if ($id) {
            if ($id === $pdf_preview) {

                $tpl .= '_pdf';
                $this->layout = 'layouts/blank';
                $this->elements_page_wrapper = 'elements/page_wrapper_blank';
            } elseif ($id === $set_archive) {
                
                $salt = date('ymd');
                $expl = explode($salt,base64_decode($cur_page), 2);
                $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                return $this->{$mdl}->set_archive($expl[1], $back_url);
            } else {
                $detail           = $this->{$mdl}->fetch_detail($id);
                if($detail) {
                    $data             = array('detail' => $detail);
                    $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                    $data['back_url'] = $back_url;
                    $this->set_data($data);
                    return $this->print_page($tpl . '_detail');
                }
            }
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->load_mdl($this->dash_mdl);
        $print_dt                     = date('Y-m-t', strtotime($this->{$mdl}->rs_cf_cur_year . '-' . $this->{$mdl}->rs_cf_cur_month . '-01'));
        $this->{$mdl}->rs_index_where = $this->{$this->dash_mdl}->get_filter_by_group('directors', $print_dt);
        $this->{$mdl}->update_base_sal($this->{$this->dash_mdl}->get_filter_by_group('permanent', $print_dt));
        $this->{$mdl}->update_base_sal($this->{$this->dash_mdl}->get_filter_by_group('contract', $print_dt));
        $this->{$mdl}->update_base_sal_dir();
        $this->{$mdl}->update_base_sal_spv();
        // $this->{$mdl}->update_alw_dir();
        $this->{$mdl}->update_component($this->{$mdl}->rs_index_where,'directors', $print_dt);
        $ls                           = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period                       = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Directors Payslip') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function supervisory_boards($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl         = __FUNCTION__;
        $pdf_preview = md5('pdf-preview' . date('ymd'));
        $set_archive = md5('set-archive' . date('ymd'));
        $this->main_mdl = $this->supervisory_board_mdl;

        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
//        $detail = array();
        if ($id) {
            if ($id === $pdf_preview) {

                $tpl .= '_pdf';
                $this->layout = 'layouts/blank';
                $this->elements_page_wrapper = 'elements/page_wrapper_blank';
            } elseif ($id === $set_archive) {
                
                $salt = date('ymd');
                $expl = explode($salt,base64_decode($cur_page), 2);
                $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                return $this->{$mdl}->set_archive($expl[1], $back_url);
            } else {
                $detail           = $this->{$mdl}->fetch_detail($id);
                if($detail) {
                    $data             = array('detail' => $detail);
                    $back_url         = $this->session->userdata(md5(__FILE__ . 'back'));
                    $data['back_url'] = $back_url;
                    $this->set_data($data);
                    return $this->print_page($tpl . '_detail');
                }
            }
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->load_mdl($this->dash_mdl);
        $print_dt                     = date('Y-m-t', strtotime($this->{$mdl}->rs_cf_cur_year . '-' . $this->{$mdl}->rs_cf_cur_month . '-01'));
        $this->{$mdl}->rs_index_where = $this->{$this->dash_mdl}->get_filter_by_group('supervisory_boards', $print_dt);
        $this->{$mdl}->update_base_sal($this->{$this->dash_mdl}->get_filter_by_group('permanent', $print_dt));
        $this->{$mdl}->update_base_sal($this->{$this->dash_mdl}->get_filter_by_group('contract', $print_dt));
        $this->{$mdl}->update_base_sal_dir();
        $this->{$mdl}->update_base_sal_spv();
        $this->{$mdl}->update_component($this->{$mdl}->rs_index_where,'supervisory_boards', $print_dt);
        $ls                           = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period                       = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Supervisory Boards Payslip') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

}
