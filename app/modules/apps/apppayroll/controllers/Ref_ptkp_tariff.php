<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Ref_Ptkp_Tariff extends Apppayroll_Frontctl {

    public $main_mdl  = "ref_ptkp_tariff_mdl";
    public $group_mdl = "ref_ptkp_tariff_group_mdl";

    protected function _do_add_new($mdl) {
        $this->set_data(array('use_zebra_datepicker' => true));
        $tpl   = 'add_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_post($mdl, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_form_input = array(
            'back_url' => $back_url
        );
        $this->set_page_title(lang("PTKP Tariff") . ': ' . lang('Add new'));

        if (!$post) {
            $data = compact('rs_form_input');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'name',
            'text',
            'menu_code',
            'amt',
            'eff_date',
            'term_date',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                 = md5($item);
            $rs_form_input[$md5] = array();
            if (isset($post['data'][$md5])) {
                $rs_form_input[$md5]['value'] = $post['data'][$md5];
            }
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        return $this->print_page($tpl);
    }

    public function edit($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        if ($id) {
            if ($id == md5('del' . date('ymd'))) {
                if ($cur_page) {
                    return $this->_do_del($mdl, $cur_page);
                }
            }
            if ($id == md5('new' . date('ymd'))) {
                return $this->_do_add_new($mdl);
            }
            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);

        $this->set_form_filter($mdl);
//        $this->{$mdl}->set_rs_select();
//        $this->{$mdl}->set_joins();
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("PTKP Tariff Management"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function group($id = null, $cur_page = null, $per_page = 12, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->group_mdl;
        $this->load_mdl($mdl);

        if ($id) {
//            if ($id == md5('dl-wd-tpl' . date('ymd'))) {
//                return $this->_do_dl_wd_tpl($mdl);
//            }
//            if ($id == md5('import' . date('ymd'))) {
//                return $this->_do_wd_import($mdl);
//            }
            return $this->_do_edit_group($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back-group'), base_url(uri_string()));
//        $this->set_wd_year_filter($mdl);
        $this->set_common_views($mdl);
        if (!$cur_page) {
            $cur_page = 1;
        }
        $this->{$mdl}->rs_index_where = "active_status=1";
//        $this->{$mdl}->set_joins();
//        $this->{$mdl}->set_rs_select();

        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);

        $this->set_page_title(lang('PTKP Tariff Group'));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        $this->set_custom_filter($mdl);

        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("PTKP Tariff"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

}
