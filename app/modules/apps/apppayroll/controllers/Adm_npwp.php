<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Adm_Npwp extends Apppayroll_Frontctl {

    public $main_mdl = "adm_npwp_mdl";

    protected function _do_add_new_form($mdl, $empl_id) {
        $tpl   = 'add_detail';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_new_form_post($mdl, $empl_id, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_form_input = array(
            'back_url' => $back_url
        );
        $detail        = $this->{$mdl}->fetch_detail_unsigned($empl_id);

        $this->set_page_title(lang("NPWP") . ': ' . lang('Add new'));

        if (!$post) {
            $md5                          = md5('empl_id');
            $rs_form_input[$md5]['value'] = $detail->id_pegawai;
            $data                         = compact('rs_form_input', 'detail');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'empl_id',
            'npwp',
            'reg_date',
            'text',
        );

        foreach ($rs_form_inputs as $item) {
            if ($item == 'empl_id') {
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

        $member_since = filter_var($data[md5('member_since')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!$member_since) {
            $flash_message['error'] = lang('Error input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['member_since']  = lang('Required');
            return $error;
        }
        $error       = array();
        $wc_id       = filter_var($data[md5('wc_id')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $member_pos  = filter_var($data[md5('member_pos')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $member_term = filter_var($data[md5('member_term')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $do_update = $this->{$mdl}->add_new_npwp($empl_id, $npwp, $reg_date, $text);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(sprintf($r_url, $do_update));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    protected function _do_del($mdl, $id) {
        $tpl                          = 'del_detail';
        $this->{$mdl}->rs_index_where = '`active_status` =1';
        $detail                       = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url = $this->session->userdata(md5(__FILE__ . 'back'));
        $post     = $this->input->post();
        if ($post) {
            $flash_message = $this->_do_del_post($mdl, $id, $post);
            if ($flash_message) {

                $this->session->set_userdata('flash_message', $flash_message);
//                return $error;
            }
            redirect($back_url);
        }

        $data = compact('back_url', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("NPWP") . ' : ' . lang('Delete Confirmation'));
        return $this->print_page($tpl);
    }

    protected function _do_del_post($mdl, $id, $input) {

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

        return $this->{$mdl}->delete_row_by_id($del_id);
    }

    protected function _do_edit($mdl, $id) {
        $tpl   = 'edit_detail';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_post($mdl, $id, $post);
        }
        $this->{$mdl}->rs_index_where = "active_status=1";
        $detail                       = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id',
            'empl_id',
            'npwp',
            'name',
            'text',
            'reg_date',
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

        $data = compact('rs_form_input', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("NPWP Edit"));
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

        $error = array();

        $var    = 'npwp';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $is_unique = $this->{$this->main_mdl}->is_unique_npwp($edit_id, ${$var});
        if (!$is_unique) {
            $error[$var] = lang('duplicated') . ':' . ${$var};
        }

        $var    = 'reg_date';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $do_update = $this->{$this->main_mdl}->update_npwp($edit_id, $npwp, $reg_date, $text);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
//                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                return redirect(base_url(uri_string()));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    public function _download_npwp_template() {
        $mdl                          = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->{$mdl}->rs_index_where = "active_status=1";
        $this->{$mdl}->rs_select      = "apr_adm_npwp.empl_id, apr_adm_npwp.nipp, apr_adm_npwp.name, apr_adm_npwp.npwp, apr_adm_npwp.reg_date, apr_adm_npwp.text";
        $list                         = $this->{$mdl}->fetch_all_npwp();
        $this->load->library('pr_phpexcel');
        $this->pr_phpexcel->_init();
        $sheet_title                  = 'NPWP-' . time();
        $this->pr_phpexcel->sheetTitle($sheet_title);
        $title                        = array(
            array(
                'Daftar NPWP Pegawai'
            ),
        );

        $this->pr_phpexcel->dataFromArray($title);
        $this->pr_phpexcel->merge('A1:G1');
        $this->pr_phpexcel->setAlignment('A1', 'c');


        $header = array(
            'NO',
            'EMPL_ID',
            'NIPP',
            'NAMA',
            'NPWP',
            'TGL NPWP',
            'KET',
        );
        $this->pr_phpexcel->dataFromArray($header, 'A2');
        $this->pr_phpexcel->setFillColor('A2:G2', 'FFDCDCDC');

        //
        $fn = 'list_npwp';
        if (!$list) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $ls = array();
        foreach ($list as $i => $row) {
            $ls[$i] = array(
                $i + 1,
                $row->empl_id,
                $row->nipp,
                $row->name,
                $row->npwp,
                $row->reg_date,
                $row->text,
            );
        }
        if (!$ls) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $this->pr_phpexcel->setValues($ls, 0, 3, array(5));
        $this->pr_phpexcel->sheetAutosize('A', 'G');
        $this->pr_phpexcel->download_xlsx($fn);
        //
    }

    protected function _npwp_import($mdl) {
        $tpl = 'npwp_import';
        $this->set_data(array('use_fileinput' => true));

        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);

        $error = array();
        $post  = $this->input->post();
        if ($post) {
            if (isset($post[md5('confirm-upload')])) {
                $error = $this->_npwp_import_post_confirm($mdl, $post);
            } else {
                $error = $this->_npwp_import_post($mdl, $post);
            }

            $confirm_list = $this->{$mdl}->rs_confirm_list;

            if ($confirm_list) {
                $this->set_data(array('rs_confirm_list' => $confirm_list));
            }
        }

        $back_url       = $this->session->userdata(md5(__FILE__ . 'back'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'file_import_npwp',
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
        $this->set_page_title(lang("NPWP Data Import"));
        return $this->print_page($tpl);
    }

    protected function _npwp_import_post($mdl, $input) {
        $this->load->library('pr_phpexcel');
        $error         = array();
        $flash_message = array();
        $field_name    = md5('file_import_npwp');
        $_file         = isset($_FILES[$field_name]) ? $_FILES[$field_name] : '';

        if (!isset($_file['tmp_name'])) {
            $flash_message['error']    = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_npwp'] = lang('Required');
            return $error;
        }
        if (!$this->pr_phpexcel->is_valid_meta($_file['type'])) {
            $flash_message['error']    = lang('Invalid file type');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_npwp'] = $_file['type'];
            return $error;
        }
        $this->pr_phpexcel->_init_from_file($_file['tmp_name']);
        $list = $this->pr_phpexcel->getList(3, null, 'A', 'G', array(5));
        if (!$list) {
            $flash_message['error'] = lang('List are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        $ls               = array();
        $ids_to_remove    = array();
        $npwps            = array();
        $duplicated_npwps = array();
        foreach ($list as $key => $val) {
            if (!isset($val[1])) {
                continue;
            }
            if (!$val[1]) {
                continue;
            }
            if (!isset($val[4])) {
                continue;
            }
            if (!$val[4]) {
                continue;
            }
            if (!isset($val[5])) {
                continue;
            }
            if (!$val[5]) {
                continue;
            }
            if (isset($npwps[$val[4]])) {
                $duplicated_npwps[]             = $val[4];
                $ids_to_remove[$npwps[$val[4]]] = $npwps[$val[4]];
                continue;
            }
            $npwps[$val[4]] = $val[1];

            $ls[$val[1]] = array(
                'empl_id'  => $val[1],
                'nipp'     => $val[2],
                'name'     => $val[3],
                'npwp'     => $val[4],
                'reg_date' => $val[5],
                'text'     => $val[6],
            );
        }

        if (!$ls) {
            $flash_message['error'] = lang('NPWP are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        if ($duplicated_npwps) {

            foreach ($ids_to_remove as $i) {
                unset($ls[$i]);
            }

            $flash_message['warning'] = lang('NPWP') . ' ' . lang('duplicated') . ': ' . implode(', ', $duplicated_npwps);
            $this->session->set_userdata('flash_message', $flash_message);
        }
        $this->{$mdl}->rs_confirm_list = $ls;
    }

    protected function _npwp_import_post_confirm($mdl, $input) {
        $error         = array();
        $flash_message = array();
        $list          = array(
            'empl_id',
            'npwp',
            'reg_date',
            'text',
        );
        foreach ($list as $val) {
            ${$val . 's'} = $input[md5($val)];
        }

        $ids  = $this->{$mdl}->fetch_ids_npwp($empl_ids);
        $data = array();
        foreach ($empl_ids as $i => $empl_id) {
            if (!isset($ids[$empl_id])) {
                continue;
            }
            $data[$i]['id'] = $ids[$empl_id];
            foreach ($list as $val) {
                $data[$i][$val] = ${$val . 's'}[$i];
            }
        }
        
        $do_update = $this->{$mdl}->update_batch($data, 'id');
        if ($do_update) {
            $flash_message['success'] = lang('Data has been saved') . sprintf(' (%d)', $do_update);
            $this->session->set_userdata('flash_message', $flash_message);
            $back_url                 = $this->session->userdata(md5(__FILE__ . 'back'));
            return redirect($back_url);
        }
        $flash_message['error'] = lang('error_saving');
        $this->session->set_userdata('flash_message', $flash_message);
    }

    public function edit($id = null, $cur_page = null, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        $this->{$mdl}->init_npwp();

        if ($id) {
            if ($id == md5('dl-npwp-tpl' . date('ymd'))) {
                return $this->_download_npwp_template($mdl);
            }
            if ($id == md5('import' . date('ymd'))) {
                return $this->_npwp_import($mdl);
            }
            if ($id == md5('del' . date('ymd'))) {
                $empl_id = $cur_page;
                if ($empl_id) {
                    return $this->_do_del($mdl, $empl_id);
                }
            }
            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        if (!$cur_page) {
            $cur_page = 1;
        }
        $this->{$mdl}->rs_index_where = "active_status=1";
        $ls                           = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("NPWP Management"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->{$mdl}->init_npwp();
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
        $this->set_page_title(lang("NPWP Administration"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

    public function set_rs_action_unsigned($mdl = null, $back_url = null) {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }
        if (!method_exists($this->{$mdl}, 'get_rs_action_unsigned')) {
            return;
        }
        $rs_action = $this->{$mdl}->get_rs_action_unsigned($back_url);
        $this->set_data(compact('rs_action'));
    }

}
