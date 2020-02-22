<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Adm_Attn_Fp extends Apppayroll_Frontctl {

    public $main_mdl = "adm_attn_fp_mdl";
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
        $this->set_page_title(lang("Employee Fingerprint") . ' : ' . lang('Delete Confirmation'));
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
            'fpid',
            'name',
            'text'
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
        $this->set_page_title(lang("Employee Fingerprint Edit"));
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

        $var    = 'fpid';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $is_unique = $this->{$this->main_mdl}->is_unique_fpid($edit_id, ${$var});
        if (!$is_unique) {
            $error[$var] = lang('duplicated') . ':' . ${$var};
        }

        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $do_update = $this->{$this->main_mdl}->update_fpid($edit_id, $fpid, $text);
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

    public function _download_fp_template() {
        $mdl                          = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->{$mdl}->rs_index_where = "active_status=1";
        $this->{$mdl}->rs_select      = "apr_adm_fp.empl_id, apr_adm_fp.nipp, apr_adm_fp.name, apr_adm_fp.fpid, apr_adm_fp.reg_date, apr_adm_fp.text";
        $list                         = $this->{$mdl}->fetch_all_fpid();
        $this->load->library('pr_phpexcel');
        $this->pr_phpexcel->_init();
        $sheet_title                  = 'FPID-' . time();
        $this->pr_phpexcel->sheetTitle($sheet_title);
        $title                        = array(
            array(
                lang('Employee ID and Fingerprint Mapping List')
            ),
        );

        $this->pr_phpexcel->dataFromArray($title);
        $this->pr_phpexcel->merge('A1:G1');
        $this->pr_phpexcel->setAlignment('A1', 'c');


        $header = array(
            'NO',
            'EMPL_ID',
            'FPID',
            'NIPP',
            'NAMA',
            'TGL MASUK',
            'KET',
        );
        $this->pr_phpexcel->dataFromArray($header, 'A2');
        $this->pr_phpexcel->setFillColor('A2:G2', 'FFDCDCDC');

        //
        $fn = 'list_fpid';
        if (!$list) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $ls = array();
        foreach ($list as $i => $row) {
            $ls[$i] = array(
                $i + 1,
                $row->empl_id,
                $row->fpid,
                $row->nipp,
                $row->name,
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

    protected function _attn_fp_import($mdl) {
        $tpl = 'attn_fp_import';
        $this->set_data(array('use_fileinput' => true));

        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);

        $error = array();
        $post  = $this->input->post();
        if ($post) {
            if (isset($post[md5('confirm-upload')])) {
                $error = $this->_attn_fp_import_post_confirm($mdl, $post);
            } else {
                $error = $this->_attn_fp_import_post($mdl, $post);
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
            'file_import_fpid',
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
        $this->set_page_title(lang("FPID Data Import"));
        return $this->print_page($tpl);
    }

    protected function _attn_fp_import_post($mdl, $input) {
        $this->load->library('pr_phpexcel');
        $error         = array();
        $flash_message = array();
        $field_name    = md5('file_import_fpid');
        $_file         = isset($_FILES[$field_name]) ? $_FILES[$field_name] : '';

        if (!isset($_file['tmp_name'])) {
            $flash_message['error']    = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_fpid'] = lang('Required');
            return $error;
        }
        if (!$this->pr_phpexcel->is_valid_meta($_file['type'])) {
            $flash_message['error']    = lang('Invalid file type');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_fpid'] = $_file['type'];
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
        $fpids            = array();
        $duplicated_fpids = array();
        foreach ($list as $key => $val) {
            if (!isset($val[1])) {
                continue;
            }
            if (!$val[1]) {
                continue;
            }
            if (!isset($val[2])) {
                continue;
            }
            if (!$val[2]) {
                continue;
            }
            if (!isset($val[5])) {
                continue;
            }
            if (!$val[5]) {
                continue;
            }
            if (isset($fpids[$val[2]])) {
                $duplicated_fpids[]             = $val[2];
                $ids_to_remove[$fpids[$val[2]]] = $fpids[$val[2]];
                continue;
            }
            $fpids[$val[2]] = $val[1];

            $ls[$val[1]] = array(
                'empl_id'  => $val[1],
                'fpid'     => $val[2],
                'nipp'     => $val[3],
                'name'     => $val[4],
                'reg_date' => $val[5],
                'text'     => $val[6],
            );
        }

        if (!$ls) {
            $flash_message['error'] = lang('FPID are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        if ($duplicated_fpids) {

            foreach ($ids_to_remove as $i) {
                unset($ls[$i]);
            }

            $flash_message['warning'] = lang('FPID') . ' ' . lang('duplicated') . ': ' . implode(', ', $duplicated_fpids);
            $this->session->set_userdata('flash_message', $flash_message);
        }
        $this->{$mdl}->rs_confirm_list = $ls;
    }

    protected function _attn_fp_import_post_confirm($mdl, $input) {
        $error         = array();
        $flash_message = array();
        $list          = array(
            'empl_id',
            'fpid',
            'text',
        );
        foreach ($list as $val) {
            ${$val . 's'} = $input[md5($val)];
        }

        $ids  = $this->{$mdl}->fetch_ids_fpid($empl_ids);
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

        $this->{$mdl}->init_fp();

        if ($id) {
            if ($id == md5('dl-fp-tpl' . date('ymd'))) {
                return $this->_download_fp_template($mdl);
            }
            if ($id == md5('import' . date('ymd'))) {
                return $this->_attn_fp_import($mdl);
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
        $this->set_page_title(lang("Employee Fingerprint Administration"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->{$mdl}->init_fp();
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
        $this->set_page_title(lang("Employee Fingerprint List"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

}
