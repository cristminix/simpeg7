<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontctl.php';

class Adm_Marstat extends Apppayroll_Frontctl {

    public $main_mdl   = "adm_marstat_mdl";
    public $detail_mdl = "adm_marstat_detail_mdl";

    protected function _do_add_new_form($mdl, $empl_id) {
        $tpl   = 'add_detail';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_new_form_post($mdl, $empl_id, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'back-list'));
        $rs_form_input = array(
            'back_url' => $back_url
        );
        $detail        = $this->{$this->main_mdl}->get_detail_by_empl_id($empl_id);

        $this->set_page_title(lang("Spouse") . ': ' . lang('Add new'));
        $md5                          = md5('id');
        $rs_form_input[$md5]['value'] = $detail->id;
        if (!$post) {
            $data = compact('rs_form_input', 'detail');
            $this->set_data($data);
            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'id',
            'text',
            'mar_stat',
            'eff_date',
            'term_date',
            'alw_sp_rc_cnt',
            'annotation',
        );

        foreach ($rs_form_inputs as $item) {
            if ($item == 'id') {
                continue;
            }
            $md5                 = md5($item);
            $rs_form_input[$md5] = array();
            if (isset($post['data'][$md5])) {
                $rs_form_input[$md5]['value'] = $post['data'][$md5];
            }
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }
        $data = compact('rs_form_input', 'detail');
        $this->set_data($data);
        return $this->print_page($tpl);
    }

    protected function _do_add_new_form_post($mdl, $empl_id, $input) {

        $error         = array();
        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        extract($input);
        $ymd     = date('ymd');
        $edit_id = filter_var($data[md5('edit_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($edit_id != $empl_id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $edit_id_hash = filter_var($data[md5('edit_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($edit_id . $ymd) != $edit_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        $error  = array();
        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
//        $var     = 'mar_stat';
//        $var_str = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        ${$var}  = filter_var($var_str, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        if (!${$var}) {
//            $error[$var] = lang('required float value') . ': ' . $var_str;
//        }
        $var    = 'mar_stat';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'eff_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'term_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $var    = 'alw_rc_sp_cnt';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_NUMBER_INT);

        $var    = 'annotation';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {
            $detail    = $this->{$this->main_mdl}->get_detail_by_empl_id($edit_id);
            $do_update = $this->{$mdl}->add_new_spouse($edit_id, $detail->nipp, $eff_date, $term_date, $alw_rc_sp_cnt, $mar_stat, $detail->name, $text, $annotation);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                $ymd                      = date('ymd');
                return redirect(sprintf($r_url, $empl_id . '/' . md5('edit' . $ymd) . '/' . $do_update));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_del($mdl, $empl_id, $id) {
        $tpl                          = 'del_detail';
        $this->{$mdl}->rs_index_where = '`active_status` =1';
        $detail                       = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url = $this->session->userdata(md5(__FILE__ . 'back-list'));
        $post     = $this->input->post();
        if ($post) {
            $flash_message = $this->_do_del_post($mdl, $empl_id, $id, $post);
            if ($flash_message) {

                $this->session->set_userdata('flash_message', $flash_message);
//                return $error;
            }
            redirect($back_url);
        }

        $data = compact('back_url', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("Spouse") . ' : ' . lang('Delete Confirmation'));
        return $this->print_page($tpl);
    }

    protected function _do_del_post($mdl, $empl_id, $id, $input) {

        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Delete error');
            return $flash_message;
        }
        $ymd    = date('ymd');
        $del_id = filter_var($input[md5('del_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($del_id != $id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }
        $del_id_hash = filter_var($input[md5('del_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($del_id . $ymd) != $del_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }
        $this->{$mdl}->rs_empl_id = $empl_id;
        return $this->{$mdl}->delete_row_spouse_by_id($del_id);
    }

    protected function _do_list_by_empl($id = null, $cur_page = null, $per_page = 10, $order_by = '4', $sort_order = 'desc') {
        $tpl                              = __FUNCTION__;
        $mdl                              = $this->detail_mdl;
        $this->load_mdl($mdl);
        $back_url                         = $this->session->userdata(md5(__FILE__ . 'back'));
        $this->{$mdl}->rs_action_back_url = $back_url;
        $this->{$mdl}->rs_empl_id         = $id;

        $main_mdl = $this->main_mdl;
        $this->load_mdl($main_mdl);
        $this->{$main_mdl}->set_joins();
        $this->{$main_mdl}->set_rs_select();
        $detail   = $this->{$main_mdl}->get_detail_by_empl_id($id);

//        $this->{$mdl}->init_npwp();

        if ($cur_page) {
            if ($cur_page == md5('new' . date('ymd'))) {
                return $this->_do_add_new_form($mdl, $id);
            }
            if ($cur_page == md5('edit' . date('ymd'))) {
                // $per_page : detail id
                // $id : empl_id
                return $this->_do_edit($mdl, $id, $per_page);
            }
//            if ($id == md5('import' . date('ymd'))) {
//                return $this->_npwp_import($mdl);
//            }
            if ($cur_page == md5('del' . date('ymd'))) {
                return $this->_do_del($mdl, $id, $per_page);
            }
//            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back-list'), base_url(uri_string()));
       $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        if (!$cur_page) {
            $cur_page = 1;
        }
        $this->{$mdl}->rs_index_where = $this->{$mdl}->tbl . ".empl_id=" . $id;
        $this->{$mdl}->set_joins();
        $this->{$mdl}->set_rs_select();
        if (!$order_by) {
//            $order_by   = '4';
//            $sort_order = 'desc';
        }
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Marital Status Management") . ' ' . $detail->nipp . ' ' . $detail->name);

        $this->{$mdl}->rs_base_url = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . $id . '/';

        $this->set_pagination($mdl);

        $this->set_data(compact('ls', 'detail'));
        // $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    protected function _do_edit($mdl, $empl_id, $id) {
        $tpl   = 'edit_detail';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_post($mdl, $empl_id, $id, $post);
        }
        $this->{$mdl}->rs_index_where = "active_status=1";
        $detail                       = $this->{$this->main_mdl}->get_detail_by_empl_id($empl_id);
        $detail_data                  = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(md5(__FILE__ . 'back-list'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id',
            'text',
            'mar_stat',
            'eff_date',
            'term_date',
            'alw_rc_sp_cnt',
            'annotation',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                       = md5($item);
            $rs_form_input[md5($item)] = array(
                'value' => $detail_data->{$item}
            );
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("Edit Spouse"));
        return $this->print_page($tpl);
    }

    protected function _do_edit_post($mdl, $empl_id, $id, $input) {

        $error         = array();
        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        extract($input);
        $ymd     = date('ymd');
        $edit_id = filter_var($data[md5('edit_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($edit_id != $id) {
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $edit_id_hash = filter_var($data[md5('edit_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($edit_id . $ymd) != $edit_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID!');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        $error = array();

        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
//        $var     = 'mar_stat';
//        $var_str = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        ${$var}  = filter_var($var_str, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        if (!${$var}) {
//            $error[$var] = lang('required float value') . ': ' . $var_str;
//        }
        $var    = 'mar_stat';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'eff_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'term_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $var    = 'alw_rc_sp_cnt';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_NUMBER_INT);

        $var    = 'annotation';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {
            $this->{$mdl}->rs_empl_id = $empl_id;
            $do_update                = $this->{$mdl}->update_spouse($edit_id, $eff_date, $term_date, $alw_rc_sp_cnt, $mar_stat, $text, $annotation);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                return redirect(base_url(uri_string()));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    public function edit($id = null, $cur_page = null, $per_page = 10, $order_by = null, $sort_order = 'desc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        if ($id) {
            if ($id == md5('sync' . date('ymd'))) {
                return $this->_sync_mar_stat($mdl);
            }
            return $this->_do_list_by_empl($id, $cur_page, $per_page, $order_by, $sort_order);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        if (!$cur_page) {
            $cur_page = 1;
        }

        $this->{$mdl}->set_joins();
        $this->{$mdl}->set_rs_select();
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);

        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang("Marital Status Management") . sprintf(' %s', $period));
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

        $this->{$mdl}->set_joins();
        $this->{$mdl}->set_rs_select();
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang("Marital Status List") . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

    protected function _sync_mar_stat($mdl) {
        $this->set_custom_filter($mdl);
        $this->{$mdl}->init_by_ym();
    }

}
