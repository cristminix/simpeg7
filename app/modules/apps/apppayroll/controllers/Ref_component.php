<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Ref_Component extends Apppayroll_Frontctl {

    public $main_mdl                           = "ref_component_mdl";
    public $detail_mdl                         = "ref_component_detail_mdl";
    public $by_group_mdl                       = "ref_component_by_group_mdl";
    public $by_group_mapping_mdl               = "ref_component_by_group_mapping_mdl";
    public $payslip_group_register_mdl         = "ref_payslip_group_register_mdl";
    public $payslip_group_register_mapping_mdl = "ref_payslip_group_register_mapping_mdl";
    public $ps_group_mdl                       = "ref_payslip_groups_mdl";

    protected function _do_add_new($mdl) {
        $tpl   = 'add_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_post($mdl, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'back'));
        $cat_ls        = $this->{$mdl}->get_cat_ls();
        $rs_form_input = array(
            'back_url' => $back_url,
            'cat_ls'   => $cat_ls,
        );
        $this->set_page_title(lang("Payslip Component") . ': ' . lang('Add new'));

        if (!$post) {
            $data = compact('rs_form_input');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'name',
            'text',
            'menu_code',
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

    protected function _do_add_post($mdl, $input) {
        $error         = array();
        $flash_message = array();
        if (!$input) {
            return $error;
        }

        extract($input);
        $var    = 'name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'menu_code';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $duplicated = $this->{$this->main_mdl}->is_duplicated($name);
            if ($duplicated) {
                $error['name'] = lang('duplicated') . ': ' . $name;
            }
        }
        if (!$error) {

            $do_add = $this->{$this->main_mdl}->add_new_payslip_component($name, $text, $menu_code);
            if ($do_add) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $do_add));
            }
            $error = array(true);
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_mapping_by_group($payslip_register_mdl, $detail_id, $detail_action = null, $var_id = null) {
        $ymd    = date('ymd');
        $mdl    = $this->by_group_mapping_mdl;
        $this->load_mdl($mdl);
        $this->load_mdl($this->ps_group_mdl);
        $detail = $this->{$payslip_register_mdl}->rs_main_data;

        $register_data = $this->{$payslip_register_mdl}->fetch_detail($var_id);
//        $this->{$mdl}->rs_detail_data = $detail;
        $input         = $this->input->post();
        if ($input) {
            $this->_do_mapping_by_group_post($mdl, $input, $var_id);
        }

        if (!$var_id) {
            $cur_page = 1;
        } else {
            $cur_page = $var_id;
        }
        $cur_page = 1;
        if (!$per_page) {
            $per_page = $this->{$mdl}->rs_per_page;
        }

        $this->{$mdl}->set_rs_attr($detail_id);

        $this->set_common_views($mdl);
        $this->{$mdl}->rs_index_where .= " AND apr_payslip_group_register_id LIKE '" . $register_data->id . "'";
//        $this->{$mdl}->set_joins();
        $ls_index                     = $this->{$mdl}->fetch_data_index();
        $ls_checked                   = $this->{$mdl}->fetch_data($cur_page, $per_page);

        $ls = array();
        if ($ls_checked) {
            foreach ($ls_checked as $row) {
                $ls[$row->apr_payslip_component_id] = $row->apr_payslip_component_id;
            }
        }

        $pg_title                   = lang("Payslip Component Mapping Register List") . ': ' . $detail->text;
        $pg_title                   .= ': ' . $register_data->name;
        $this->set_page_title($pg_title);
        $this->{$mdl}->rs_base_url  = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $detail_id . '/page/') . '/';
        $this->set_pagination($mdl);
        $back_url                   = $this->session->userdata(md5(__FILE__ . 'detail-back'));
        $rs_action                  = $this->{$mdl}->get_rs_action($detail_id, $back_url);
        $this->set_data(compact('ls', 'rs_action', 'ls_index'));
//        debug($ls);die();
//        debug( $tpl);
        $tpl                        = 'index_groups_mapping';
        $this->page_data['page_js'] = $this->_get_page_js_by_group_mapping();
        $this->print_page($tpl);
    }

    protected function _do_mapping_by_group_post($mdl, $input, $group_id) {
        if (!$mdl) {
            return;
        }
        if (!$input) {
            return;
        }
        if (!$group_id) {
            return;
        }
        if (!isset($input['input_check_select'])) {
            return;
        }
//        if(!$input['input_check_select']){
//            return;
//        }
//        debug($input['input_check_select']);die();
        $res                      = $this->{$mdl}->update_mapping_by_group($input['input_check_select'], $group_id);
//        if (property_exists($res, 'inserted')) {
        $msg                      = $res->inserted . lang(' rows created') . '; ';
        $msg                      .= $res->updated . lang(' rows updated') . '; ';
        $msg                      .= $res->dropped . lang(' rows dropped') . '; ';
        $flash_message['success'] = $msg;
        $this->session->set_userdata('flash_message', $flash_message);
        $r_url                    = base_url(uri_string());
        return redirect($r_url);
//        }
    }

    public function _do_payslip_group_register($detail_id, $detail_action = null, $var_id = null) {
        $ymd = date('ymd');

        $mdl    = $this->payslip_group_register_mdl;
        $this->load_mdl($mdl);
        $detail = $this->{$this->by_group_mdl}->fetch_detail($detail_id);

        $this->{$mdl}->rs_main_data = $detail;
        if ($detail_action) {

            if ($detail_action == md5('new' . date('ymd'))) {
                return $this->_do_payslip_group_register_add_new($mdl, $detail_id);
            }
            if ($detail_action == md5('mapping' . date('ymd'))) {
                return $this->_do_mapping_by_group($mdl, $detail_id, $detail_action, $var_id);
            }
            if ($detail_action == md5('del' . date('ymd'))) {
                if ($var_id) {
                    return $this->_do_payslip_group_register_del($mdl, $var_id);
                }
            }
            $eid = $detail_action;
            return $this->_do_payslip_group_register_edit($mdl, $detail_id, $eid);
        }
        $this->session->set_userdata(md5(__FILE__ . 'detail-back'), base_url(uri_string()));

//        $this->set_form_filter($mdl);
//        $this->{$mdl}->set_rs_select();
//        $this->{$mdl}->set_joins();
        $cur_page = 1;
        if (!$cur_page) {
            $cur_page = 1;
        }
        if (!$per_page) {
            $per_page = 10;
        }


//        debug($this->detail_instance);
        $this->{$mdl}->set_rs_attr($detail_id);
        $this->set_common_views($mdl);
        $this->{$mdl}->rs_index_where .= " AND apr_payslip_group_id LIKE '" . $detail->id . "'";
        $ls                           = $this->{$mdl}->fetch_data();
//        debug($ls->result());die();
        $this->set_page_title(lang("Payslip Component Mapping Register") . ': ' . $detail->text);
        $this->set_pagination($mdl);
        $back_url                     = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_action                    = $this->{$mdl}->get_rs_action($detail_id, $back_url);
        $this->set_data(compact('ls', 'rs_action'));
//        $this->set_rs_action($mdl);
        $tpl = 'index';
        $this->print_page($tpl);
    }

    protected function _do_payslip_group_register_mapping($payslip_register_mdl, $register_id) {
        $ymd = date('ymd');
        if (!$cur_page) {
            $cur_page = 1;
        }
        if (!$per_page) {
            $per_page = 10;
        }
        $detail = $this->{$payslip_register_mdl}->rs_main_data;

        $register_data = $this->{$payslip_register_mdl}->fetch_detail($register_id);

        $mdl                          = $this->payslip_group_register_mapping_mdl;
        $this->load_mdl($mdl);
        $this->{$mdl}->set_rs_attr($detail_id);
        $this->set_common_views($mdl);
        $this->{$mdl}->rs_index_where .= " AND apr_payslip_group_register_id LIKE '" . $detail->id . "'";
        $ls                           = $this->{$mdl}->fetch_data();
//        debug($ls->result());die();
        $pg_title                     = lang("Payslip Component Mapping Register List") . ': ' . $detail->text;
        $pg_title                     .= ': ' . $register_data->name;
        $this->set_page_title($pg_title);
        $this->set_pagination($mdl);
        $back_url                     = $this->session->userdata(md5(__FILE__ . 'detail-back'));
        $rs_action                    = $this->{$mdl}->get_rs_action($detail_id, $back_url);
        $tpl                          = 'index_groups_mapping';
        $this->set_data(compact('ls', 'rs_action'));
//        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    protected function _do_edit($mdl, $id) {
        $tpl   = 'edit_detail';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(md5(__FILE__ . 'back'));
        $cat_ls         = $this->{$mdl}->get_cat_ls();
        $rs_form_input  = array(
            'back_url' => $back_url,
            'cat_ls'   => $cat_ls,
        );
        $rs_form_inputs = array(
            'id',
            'name',
            'text',
            'menu_code',
            'modified',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                       = md5($item);
            $rs_form_input[md5($item)] = array(
                'value' => $detail->{$item}
            );
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Payslip Component Edit") . ': ' . sprintf('%s - %s ', $detail->name, $detail->text));
        return $this->print_page($tpl);
    }

    protected function _do_edit_post($mdl, $id, $input) {

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

        $error  = array();
        $var    = 'name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'menu_code';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $duplicated = $this->{$this->main_mdl}->is_duplicated($name, $edit_id);
            if ($duplicated) {
                $error['name'] = lang('duplicated') . ': ' . $name;
            }
        }
        if (!$error) {

            $do_update = $this->{$this->main_mdl}->update_payslip_component($edit_id, $name, $text, $menu_code);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $edit_id));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_payslip_group_register_add_new($mdl) {
        $tpl   = 'add_detail_pgr';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_payslip_group_register_add_post($mdl, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'detail-back'));
//        $cat_ls        = $this->{$mdl}->get_cat_ls();
        $rs_form_input = array(
            'back_url' => $back_url,
//            'cat_ls'   => $cat_ls,
        );
//        debug($this->{$mdl}->rs_main_data);die();
        $this->set_page_title(lang("Payslip Component Mapping Register") . ': ' . $this->{$mdl}->rs_main_data->text . ' : ' . lang('Add new'));

        if (!$post) {
            $data = compact('rs_form_input');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'name',
            'start_date',
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

    protected function _do_payslip_group_register_add_post($mdl, $input) {
        $error         = array();
        $flash_message = array();
        if (!$input) {
            return $error;
        }

        $apr_payslip_group_id = $this->{$mdl}->rs_main_data->id;
        extract($input);
        $var                  = 'name';
        ${$var}               = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'start_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'term_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $duplicated = $this->{$mdl}->is_duplicated($apr_payslip_group_id, $name);
            if ($duplicated) {
                $error['name'] = lang('duplicated') . ': ' . $name;
            }
        }
        if (!$error) {

            $do_add = $this->{$mdl}->add_new_payslip_group_register($apr_payslip_group_id, $name, $start_date, $term_date);
            if ($do_add) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $apr_payslip_group_id . '/%s');
                return redirect(sprintf($r_url, $do_add));
            }
            $error = array(true);
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_payslip_group_register_edit($mdl, $apr_payslip_group_id, $id) {
        $tpl   = 'edit_detail_pgr';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_payslip_group_register_edit_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url = $this->session->userdata(md5(__FILE__ . 'detail-back'));

        $rs_form_input  = array(
            'back_url' => $back_url,
        );
        $rs_form_inputs = array(
            'id',
            'apr_payslip_group_id',
            'name',
            'start_date',
            'term_date',
        );

        foreach ($rs_form_inputs as $item) {
            $md5                       = md5($item);
            $rs_form_input[md5($item)] = array(
                'value' => $detail->{$item}
            );
            if (isset($error[$item])) {
                $rs_form_input[$md5]['err_msg'] = $error[$item];
            }
        }

        $data = compact('rs_form_input');
        $this->set_data($data);
        $this->set_page_title(lang("Payslip Component Edit") . ': ' . sprintf('%s - %s ', $detail->name, $detail->text));
        return $this->print_page($tpl);
    }

    protected function _do_payslip_group_register_edit_post($mdl, $id, $input) {
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

        $error  = array();
        $var    = 'name';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'start_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }
        $var    = 'term_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $duplicated = $this->{$mdl}->is_duplicated($name, $edit_id);
            if ($duplicated) {
                $error['name'] = lang('duplicated') . ': ' . $name;
            }
        }
        if (!$error) {

            $apr_payslip_group_id = $this->{$mdl}->rs_main_data->id;
            $do_update            = $this->{$mdl}->update_payslip_group_register($id, $apr_payslip_group_id, $name, $start_date, $term_date);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $apr_payslip_group_id . '/%s');
                return redirect(sprintf($r_url, $edit_id));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _get_page_js_by_group_mapping() {
        $js = array();
        if (isset($this->page_data['page_js'])) {
            $js = $this->page_data['page_js'];
        }
        $js[] = base_url('assets/js/apppayroll/ref_component/by_groups/setup.js');
        return $js;
    }

    public function by_groups($id = null, $cur_page = null, $per_page = null, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->by_group_mdl;
        $this->load_mdl($mdl);

        if ($id) {

            if ($id == md5('detail' . date('ymd'))) {
                $detail_id        = $cur_page;
                $detail_action    = $per_page;
                $detail_action_id = $order_by;
                if ($detail_id) {
//                    debug('here');die();
                    return $this->_do_payslip_group_register($detail_id, $detail_action, $detail_action_id);
                }
            }
//            if ($id == md5('del' . date('ymd'))) {
//                if ($cur_page) {
//                    return $this->_do_del($mdl, $cur_page);
//                }
//            }
//            if ($id == md5('new' . date('ymd'))) {
//                return $this->_do_add_new($mdl);
//            }
//            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->{$mdl}->set_rs_select();
        $this->{$mdl}->set_joins();
        if (!$cur_page) {
            $cur_page = 1;
        }
        if (!$per_page) {
            $per_page = 10;
        }
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Payslip Component Mapping"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function edit($id = null, $cur_page = null, $per_page = null, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        if (!$per_page) {
            $per_page = $this->{$mdl}->rs_per_page;
        }
        if ($id) {

            if ($id == md5('detail' . date('ymd'))) {
                $detail_id        = $cur_page;
                $detail_action    = $per_page;
                $detail_action_id = $order_by;
                if ($detail_id) {
                    return $this->_do_detail($detail_id, $detail_action, $detail_action_id);
                }
            }
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
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        $this->{$mdl}->set_rs_select();
        $this->{$mdl}->set_joins();
        if (!$cur_page) {
            $cur_page = 1;
        }
        
        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Payslip Component Management"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

}
