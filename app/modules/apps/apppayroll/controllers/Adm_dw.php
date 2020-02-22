<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Adm_Dw extends Apppayroll_Frontctl {

    public $ddc_mdl  = "adm_dw_ddc_mdl";
    public $main_mdl = "adm_dw_mdl";

    protected function _do_add_new_form($mdl, $empl_id) {
        $tpl   = 'add_detail';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_add_new_form_post($mdl, $empl_id, $post);
        }

        $back_url      = $this->session->userdata(md5(__FILE__ . 'back-add-new'));
        $rs_form_input = array(
            'back_url' => $back_url
        );
        $detail        = $this->{$mdl}->fetch_detail_unsigned($empl_id);

        $this->set_page_title(lang("Dharma Wanita Member") . ': ' . lang('Add new'));

        if (!$post) {
            $md5                          = md5('empl_id');
            $rs_form_input[$md5]['value'] = $detail->id_pegawai;
            $data                         = compact('rs_form_input', 'detail');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'empl_id',
            'dw_id',
            'member_pos',
            'member_status',
            'member_since',
            'member_term',
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
        $dw_id       = filter_var($data[md5('dw_id')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $member_pos  = filter_var($data[md5('member_pos')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $member_term = filter_var($data[md5('member_term')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $do_update = $this->{$mdl}->add_new_member($empl_id, $dw_id, $member_pos, $member_since, $member_term);
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

    protected function _do_add_new($mdl, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc', $id = null) {

        $tpl                                      = __FUNCTION__;
        $suffix                                   = '_unsigned';
        $this->{$mdl}->rs_field_list              = $this->{$mdl}->rs_field_list_unsigned;
        $this->{$mdl}->rs_masked_field_list       = $this->{$mdl}->rs_masked_field_list_unsigned;
        $this->{$mdl}->rs_common_views            = $this->{$mdl}->rs_common_views_unsigned;
        $this->{$mdl}->rs_index_where_unsigned    = 'id_pegawai NOT IN (SELECT `empl_id` FROM `apr_empl_dw` WHERE `active_status`=1)';
        $this->session->set_userdata(md5(__FILE__ . 'back-add-new'), base_url(uri_string()));
        $this->set_custom_filter($mdl, $suffix);
        $this->set_common_views($mdl, $suffix);
        $this->set_form_filter($mdl, $suffix);
        $ls                                       = $this->{$mdl}->fetch_data_unsigned($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("Dharma Wanita Add New Member"));
        $this->{$mdl}->rs_ppo_url_prefix_unsigned = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('new' . date('ymd')) . '/';
        $this->set_pagination($mdl, $suffix);

        $this->set_data(compact('ls'));
        $back_url = $this->session->userdata(md5(__FILE__ . 'back'));
        $this->set_rs_action_unsigned($mdl, $back_url);
        $this->print_page($tpl);
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
            'dw_id',
            'member_pos',
            'member_status',
            'member_since',
            'member_term',
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
        $this->set_page_title(lang("Dharma Wanita Member Edit"));
        return $this->print_page($tpl);
    }

    protected function _do_edit_ddc($mdl, $id) {
        $tpl   = 'edit_detail_ddc';
        $this->set_data(array('use_zebra_datepicker' => true));
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_ddc_post($mdl, $id, $post);
        }
        $this->{$mdl}->rs_index_where = "active_status=1";
        $this->{$mdl}->set_joins();
        $this->{$mdl}->set_rs_select_detail();

        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(md5(__FILE__ . 'back-dw'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id',
            'ddc_dw',
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
        $this->set_page_title(lang("Dharma Wanita Deduction Edit"));
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

        $var    = 'dw_id';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $var    = 'empl_id';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $var    = 'member_pos';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $var    = 'member_since';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'member_term';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $do_update = $this->{$this->main_mdl}->update_member($edit_id, $dw_id, $member_pos, $member_since, $member_term);
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

    protected function _do_edit_ddc_post($mdl, $id, $input) {

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

        $var    = 'ddc_dw';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_NUMBER_FLOAT);


        if (!$error) {

            $do_update = $this->{$mdl}->update_ddc($edit_id, $ddc_dw);
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

    protected function _do_batch_assignment($mdl) {
        $tpl = 'batch_assignment_confirm';

        $back_url = $this->session->userdata(md5(__FILE__ . 'back'));
        $post     = $this->input->post();
        if ($post) {

            if ($this->_do_batch_assignment_post($mdl, $post)) {
                redirect($back_url);
            }
        }
        $detail                   = new stdClass();
        $detail->action           = $tpl;
        $data                     = compact('back_url', 'detail');
        $this->set_data($data);
        $this->set_page_title(lang("Warning") . ' : ' . lang('You are about to assign all employees as Dharma Wanita member'));
        $flash_message['warning'] = lang('This action is irreversible when its done!');
        $this->session->set_userdata('flash_message', $flash_message);
        return $this->print_page($tpl);
    }

    protected function _do_batch_assignment_post($mdl, $input) {

        $flash_message = array();
        if (!$input) {
            $flash_message['error'] = lang('Action error');
            return $flash_message;
        }
        $ymd        = date('ymd');
        $confirm_id = filter_var($input[md5('confirm_id' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($confirm_id != 'batch_assignment_confirm') {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }
        $confirm_id_hash = filter_var($input[md5('confirm_id_hash' . $ymd)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (md5($confirm_id . $ymd) != $confirm_id_hash) {
            $flash_message['error'] = lang('Invalid transaction ID');
            return $flash_message;
        }

        return $this->{$mdl}->do_batch_assignment();
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
        $this->set_page_title(lang("Dharma Wanita Member") . ' : ' . lang('Delete Confirmation'));
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

        return $this->adm_dw_mdl->delete_row_by_id($del_id);
    }

    public function _download_ddc_template() {
        $mdl                          = $this->ddc_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);
        $cf                           = $this->{$mdl}->get_custom_filter_data();
        $this->{$mdl}->rs_index_where = "empl_dw=1";
        $this->{$mdl}->rs_select      = "apr_sv_payslip.ddc_dw, apr_empl_dw.empl_id, apr_empl_dw.nipp, apr_empl_dw.name";
        $this->{$mdl}->set_joins();
        $list                         = $this->{$mdl}->fetch_all_member();
        $this->load->library('pr_phpexcel');
        $this->pr_phpexcel->_init();
        $sheet_title                  = 'DW-' . $cf['cf_cur_year'] . '-' . $cf['cf_cur_month'];
        $this->pr_phpexcel->sheetTitle($sheet_title);
        $title                        = array(
            array(
                'Daftar Potongan Dharma Wanita'
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
            'POTONGAN',
        );
        $this->pr_phpexcel->dataFromArray($header, 'A4');
        $this->pr_phpexcel->setFillColor('A4:E4', 'FFDCDCDC');

        //
        $fn = 'blanko_potongan_dharma_wanita';
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
                $row->ddc_dw,
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

    protected function _ddc_import($mdl) {
        $tpl = 'ddc_import';
        $this->set_data(array('use_fileinput' => true));

        $mdl   = $this->ddc_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);
        $cf    = $this->{$mdl}->get_custom_filter_data();
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            if (isset($post[md5('confirm-upload')])) {
                $error = $this->_ddc_import_post_confirm($mdl, $post);
            } else {
                $error = $this->_ddc_import_post($mdl, $post);
            }

            $confirm_list = $this->{$mdl}->rs_confirm_list;

            if ($confirm_list) {
                $this->set_data(array('rs_confirm_list' => $confirm_list));
            }
        }

        $back_url       = $this->session->userdata(md5(__FILE__ . 'back-dw'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'file_import_ddc',
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
        $this->set_page_title(lang("Dharma Wanita Deduction Data Import"));
        return $this->print_page($tpl);
    }

    protected function _ddc_import_post($mdl, $input) {
        $this->load->library('pr_phpexcel');
        $error         = array();
        $flash_message = array();
        $field_name    = md5('file_import_ddc');
        $_file         = isset($_FILES[$field_name]) ? $_FILES[$field_name] : '';

        if (!isset($_file['tmp_name'])) {
            $flash_message['error']   = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_ddc'] = lang('Required');
            return $error;
        }
        if (!$this->pr_phpexcel->is_valid_meta($_file['type'])) {
            $flash_message['error']   = lang('Invalid file type');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_ddc'] = $_file['type'];
            return $error;
        }
        $this->pr_phpexcel->_init_from_file($_file['tmp_name']);
        $x_year  = (int) $this->pr_phpexcel->getCellValue('E2');
        $x_month = (int) $this->pr_phpexcel->getCellValue('E3');

        $cf_cur_year  = (int) $this->{$mdl}->rs_cf_cur_year;
        $cf_cur_month = (int) $this->{$mdl}->rs_cf_cur_month;
        if ($x_year != $cf_cur_year && $x_month != $cf_cur_month) {
            $flash_message['error']   = lang('Period does not match') . ' ' . sprintf('%s-%s', $cf_cur_year, $cf_cur_month);
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_ddc'] = sprintf('%s-%s', $x_year, $x_month);
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
            if (!isset($val[4])) {
                continue;
            }
            if (!$val[4]) {
                continue;
            }

            $ls[$val[1]] = array(
                'empl_id' => $val[1],
                'nipp'    => $val[2],
                'name'    => $val[3],
                'ddc'     => $val[4],
            );
        }

        if (!$ls) {
            $flash_message['error'] = lang('Loans are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $this->{$mdl}->rs_confirm_list = $ls;
    }

    protected function _ddc_import_post_confirm($mdl, $input) {
        $error         = array();
        $flash_message = array();
        $list          = array(
            'empl_id',
            'ddc_dw',
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

        $do_update = $this->{$mdl}->update_batch($data, 'id');
        if ($do_update) {
            $flash_message['success'] = lang('Data has been saved') . sprintf(' (%d)', $do_update);
            $this->session->set_userdata('flash_message', $flash_message);
            $back_url                 = $this->session->userdata(md5(__FILE__ . 'back-dw'));
            return redirect($back_url);
        }
        $flash_message['error'] = lang('error_saving');
        $this->session->set_userdata('flash_message', $flash_message);
    }

    public function edit($id = null, $cur_page = null, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);

        if ($id) {
            if ($id == md5('new' . date('ymd'))) {
                if (!$cur_page) {
                    $cur_page = 1;
                }
                return $this->_do_add_new($mdl, $cur_page, $per_page, $order_by, $sort_order);
            }
            if ($id == md5('del' . date('ymd'))) {
                $empl_id = $cur_page;
                if ($empl_id) {
                    return $this->_do_del($mdl, $empl_id);
                }
            }
            if ($id == md5('add_new_form' . date('ymd'))) {
                $empl_id = $cur_page;
                return $this->_do_add_new_form($mdl, $empl_id);
            }
            if ($id == md5('batch-assignment' . date('ymd'))) {
                return $this->_do_batch_assignment($mdl);
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
        $this->set_page_title(lang("Dharma Wanita Member Administration"));
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
        $this->set_page_title(lang("Dharma Wanita Member Administration"));
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

    public function loan($id = null, $cur_page = null, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->ddc_mdl;
        $this->load_mdl($mdl);

        if ($id) {
            if ($id == md5('del' . date('ymd'))) {
                if ($cur_page) {
                    return $this->_do_del($mdl, $cur_page);
                }
            }
            if ($id == md5('dl-ddc-tpl' . date('ymd'))) {
                return $this->_download_ddc_template($mdl);
            }
            if ($id == md5('import' . date('ymd'))) {
                return $this->_ddc_import($mdl);
            }
           
            return $this->_do_edit_ddc($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back-dw'), base_url(uri_string()));
        $this->set_custom_filter($mdl);
        $this->set_common_views($mdl);
        $this->set_form_filter($mdl);
        if (!$cur_page) {
            $cur_page = 1;
        }
        $this->{$mdl}->rs_index_where = "empl_dw=1";
        $this->{$mdl}->set_joins();
        $this->{$mdl}->set_rs_select();
        $ls                           = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);
        
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Dharma Wanita Deduction Administration') . sprintf(' %s', $period));
        
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

}
