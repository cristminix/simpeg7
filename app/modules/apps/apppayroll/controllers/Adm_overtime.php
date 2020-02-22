<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontctl.php';

class Adm_Overtime extends Apppayroll_Frontctl {

    public $main_mdl = "adm_overtime_mdl";

    protected function _do_overtime_import($mdl) {
        $tpl = 'overtime_import';
        $this->set_data(array('use_fileinput' => true));

        $mdl   = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);
        $cf    = $this->{$mdl}->get_custom_filter_data();
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            if (isset($post[md5('confirm-upload')])) {
                $error = $this->_do_overtime_post_confirm($mdl, $post);
            } else {
                $error = $this->_do_overtime_post($mdl, $post);
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
            'file_import_overtime',
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

        $data                 = compact('rs_form_input');
        $data['cf_cur_year']  = $this->{$mdl}->rs_cf_cur_year;
        $data['cf_cur_month'] = $this->{$mdl}->rs_cf_cur_month;
        $this->set_data($data);
        $this->set_page_title(lang("Overtime Data Import"));
        return $this->print_page($tpl);
    }

    protected function _do_overtime_post($mdl, $input) {
        $this->load->library('pr_phpexcel');
        $error         = array();
        $flash_message = array();
        $fn_var        = 'file_import_overtime';
        $field_name    = md5($fn_var);
        $_file         = isset($_FILES[$field_name]) ? $_FILES[$field_name] : '';

        if (!isset($_file['tmp_name'])) {
            $flash_message['error'] = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[$fn_var]         = lang('Required');
            return $error;
        }
        if (!$this->pr_phpexcel->is_valid_meta($_file['type'])) {
            $flash_message['error'] = lang('Invalid file type');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[$fn_var]         = $_file['type'];
            return $error;
        }
        $this->pr_phpexcel->_init_from_file($_file['tmp_name']);
        $x_year  = (int) $this->pr_phpexcel->getCellValue('E2');
        $x_month = (int) $this->pr_phpexcel->getCellValue('E3');

        $cf_cur_year  = (int) $this->{$mdl}->rs_cf_cur_year;
        $cf_cur_month = (int) $this->{$mdl}->rs_cf_cur_month;
        if ($x_year != $cf_cur_year && $x_month != $cf_cur_month) {
            $flash_message['error'] = lang('Period does not match') . ' ' . sprintf('%s-%s', $cf_cur_year, $cf_cur_month);
            $this->session->set_userdata('flash_message', $flash_message);
            $error[$fn_var]         = sprintf('%s-%s', $x_year, $x_month);
            return $error;
        }
        $list = $this->pr_phpexcel->getList(5, null, 'A', 'E');
        if (!$list) {
            $flash_message['error'] = lang('List are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }

        $ls = array();
        foreach ($list as $key => $val) {
            if (!isset($val[1])) {
                continue;
            }
            if (!$val[1]) {
                continue;
            }
            $isset = isset($val[4]);
            if (!$isset) {
                continue;
            }
            $has_val = $val[4];
            if (!$has_val) {
                continue;
            }

            $ls[$val[1]] = array(
                'empl_id'   => $val[1],
                'nipp'      => $val[2],
                'empl_name' => $val[3],
                'alw_ot'   => $val[4],
            );
        }

        if (!$ls) {
            $flash_message['error'] = lang('Overtime list are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $this->{$mdl}->rs_confirm_list = $ls;
    }

    protected function _do_overtime_post_confirm($mdl, $input) {
        $error         = array();
        $flash_message = array();
        $list          = array(
            'empl_id',
            'alw_ot',
        );
        foreach ($list as $val) {
            ${$val . 's'} = $input[md5($val)];
        }


        $cf_cur_year  = $this->{$mdl}->rs_cf_cur_year;
        $cf_cur_month = $this->{$mdl}->rs_cf_cur_month;
        $print_dt     = date('Y-m-t', strtotime($cf_cur_year . '-' . $cf_cur_month . '-01'));
        $ids          = $this->{$mdl}->fetch_ids_by_empl_id_print_dt($empl_ids, $print_dt);
        $data         = array();
        foreach ($empl_ids as $i => $empl_id) {
            if (!isset($ids[$empl_id])) {
                continue;
            }
            $data[$i]['id'] = $ids[$empl_id];
            foreach ($list as $val) {
                $data[$i][$val] = ${$val . 's'}[$i];
            }
        }

        $do_update = $this->{$mdl}->update_batch_overtime($data, 'id');
        if ($do_update) {
            $flash_message['success'] = lang('Data has been saved') . sprintf(' (%d)', $do_update);
            $this->session->set_userdata('flash_message', $flash_message);
            $back_url                 = $this->session->userdata(md5(__FILE__ . 'back'));
            return redirect($back_url);
        }
        $flash_message['error'] = lang('error_saving');
        $this->session->set_userdata('flash_message', $flash_message);
    }

    protected function _do_del($mdl, $id) {
        $tpl    = 'del_detail';
        $detail = $this->{$mdl}->fetch_detail($id);
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
        $this->set_page_title(lang("Overtime") . ' : ' . lang('Delete Confirmation'));
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

        return $this->{$mdl}->delete_overtime($del_id);
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
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id',
            'alw_ot',
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
        $this->set_data(array('detail' => $detail));

        $print_dt = strtotime($detail->print_dt);
        $year     = date('Y', $print_dt);
        $month    = date('F', $print_dt);
        $month    = lang(ucfirst($month));
        $periode  = $year;
        $periode  .= ' ';
        $periode  .= $month;
        $this->set_page_title(lang("Overtime") . ': ' . sprintf(' %s', $periode));

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
            $flash_message['error'] = lang('Invalid transaction ID');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $error   = array();
        $var     = 'alw_ot';
        $var_str = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ${$var}  = filter_var($var_str, FILTER_SANITIZE_NUMBER_FLOAT);
        if (!${$var}) {
            $error['alw_tpp'] = lang('required float value') . ': ' . $var_str;
        }
        if (!$error) {

            $do_update = $this->{$mdl}->update_overtime($edit_id, $alw_ot);
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

    public function _do_dl_overtime_tpl() {
        $mdl                          = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);
        $cf                           = $this->{$mdl}->get_custom_filter_data();
        $this->{$mdl}->rs_index_where = "`lock`=0";
        $this->{$mdl}->rs_select      = "empl_id, nipp, empl_name, alw_ot";
//        $this->{$mdl}->set_joins();
        $list                         = $this->{$mdl}->fetch_all_overtime();
        $this->load->library('pr_phpexcel');
        $this->pr_phpexcel->_init();
        $sheet_title                  = 'OT-' . $cf['cf_cur_year'] . '-' . $cf['cf_cur_month'];
        $this->pr_phpexcel->sheetTitle($sheet_title);
        $title                        = array(
            array(
                'Daftar Lemburan Pegawai'
            ),
            array(
                'Periode Tahun:',
                NULL,
                NULL,
                NULL,
                $cf['cf_cur_year']
            ),
            array(
                'Periode Bulan:',
                NULL,
                NULL,
                NULL,
                $cf['cf_cur_month']
            ),
        );

        $this->pr_phpexcel->dataFromArray($title);
        $this->pr_phpexcel->merge('A1:E1');
        $this->pr_phpexcel->setAlignment('A1', 'c');
        $this->pr_phpexcel->merge('A2:D2');
        $this->pr_phpexcel->merge('A3:D3');
        $this->pr_phpexcel->setAlignment('A2:A3', 'r');


        $header = array(
            'NO',
            'EMPL_ID',
            'NIPP',
            'NAMA',
            'JML LEMBUR',
        );
        $this->pr_phpexcel->dataFromArray($header, 'A4');
        $this->pr_phpexcel->setFillColor('A4:E4', 'FFDCDCDC');

        //
        $fn = 'overtime' . $cf['cf_cur_year'] . $cf['cf_cur_month'];
        ;
        if (!$list) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $ls = array();
        foreach ($list as $i => $row) {
            $ls[$i] = array(
                $i + 1,
                $row->empl_id,
                $row->nipp,
                $row->empl_name,
                $row->alw_ot,
            );
        }
        if (!$ls) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $this->pr_phpexcel->setValues($ls, 0, 5);
        $this->pr_phpexcel->sheetAutosize('A', 'E');
        $this->pr_phpexcel->download_xlsx($fn);
        //
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
            if ($id == md5('dl-overtime-tpl' . date('ymd'))) {
                return $this->_do_dl_overtime_tpl($mdl);
            }
            if ($id == md5('import' . date('ymd'))) {
                return $this->_do_overtime_import($mdl);
            }
            return $this->_do_edit($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back'), base_url(uri_string()));
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);

        $this->set_form_filter($mdl);
//        $this->{$mdl}->set_rs_select();
//        $this->{$mdl}->set_joins();
        $ls     = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Overtime Management') . sprintf(' %s', $period));
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
        $ls     = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Overtime Administration') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

}
