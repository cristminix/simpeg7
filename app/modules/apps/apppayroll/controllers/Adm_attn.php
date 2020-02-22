<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';
// require_once '../models/payslip_mdl.php';
require_once (APPPATH.'modules/apps/apppayroll/models/payslip_mdl.php');
// die();
class Adm_Attn extends Apppayroll_Frontctl {

    public $main_mdl   = "adm_attn_mdl";
    public $att_wd_mdl = "adm_attn_wd_mdl"; // working day model
    public $att_fp_mdl = "adm_attn_wd_mdl"; // finger print model
    
    protected function _attn_import($mdl) {
        $tpl = 'attn_import';
        $this->set_data(array('use_fileinput' => true));

        $mdl   = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);
        $cf    = $this->{$mdl}->get_custom_filter_data();
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            if (isset($post[md5('confirm-upload')])) {
                $error = $this->_attn_import_post_confirm($mdl, $post);
            } else {
                $error = $this->_attn_import_post($mdl, $post);
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
            'file_import_attn',
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
        $this->set_page_title(lang("Attendance Data Import"));
        return $this->print_page($tpl);
    }

    protected function _attn_import_post($mdl, $input) {
        $this->load->library('pr_phpexcel');
        $error         = array();
        $flash_message = array();
        $field_name    = md5('file_import_attn');
        $_file         = isset($_FILES[$field_name]) ? $_FILES[$field_name] : '';

        if (!isset($_file['tmp_name'])) {
            $flash_message['error']    = lang('Missing input');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_attn'] = lang('Required');
            return $error;
        }
        if (!$this->pr_phpexcel->is_valid_meta($_file['type'])) {
            $flash_message['error']    = lang('Invalid file type');
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_attn'] = $_file['type'];
            return $error;
        }
        $this->pr_phpexcel->_init_from_file($_file['tmp_name']);
        $x_year  = (int) $this->pr_phpexcel->getCellValue('F2');
        $x_month = (int) $this->pr_phpexcel->getCellValue('F3');

        $cf_cur_year  = (int) $this->{$mdl}->rs_cf_cur_year;
        $cf_cur_month = (int) $this->{$mdl}->rs_cf_cur_month;
        if ($x_year != $cf_cur_year && $x_month != $cf_cur_month) {
            $flash_message['error']    = lang('Period does not match') . ' ' . sprintf('%s-%s', $cf_cur_year, $cf_cur_month);
            $this->session->set_userdata('flash_message', $flash_message);
            $error['file_import_attn'] = sprintf('%s-%s', $x_year, $x_month);
            return $error;
        }
        $list = $this->pr_phpexcel->getList(5, null, 'A', 'J');
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
            if (!$val[3]) {
                continue;
            }
            $isset = isset($val[5]) && isset($val[6]) && isset($val[7]) && isset($val[8]) && isset($val[9]);
            if (!$isset) {
                continue;
            }
            $has_val = $val[5] || $val[6] || $val[7] || $val[8] || $val[9];
            if (!$has_val) {
                continue;
            }

            $ls[$val[1]] = array(
                'empl_id'   => $val[1],
                'nipp'      => $val[2],
                'empl_fpid' => $val[3],
                'empl_name' => $val[4],
                'attn_s'    => $val[5],
                'attn_i'    => $val[6],
                'attn_a'    => $val[7],
                'attn_l'    => $val[8],
                'attn_c'    => $val[9],
            );
        }

        if (!$ls) {
            $flash_message['error'] = lang('Attendance are empty');
            $this->session->set_userdata('flash_message', $flash_message);
            $error[]                = true;
            return $error;
        }
        $this->{$mdl}->rs_confirm_list = $ls;
    }

    protected function _attn_import_post_confirm($mdl, $input) {
        $error         = array();
        $flash_message = array();
        $list          = array(
            'empl_id',
            'attn_s',
            'attn_i',
            'attn_a',
            'attn_l',
            'attn_c',
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

        $do_update = $this->{$mdl}->update_batch_attn($data, 'id');
        // var_dump($do_update);
        if ($do_update) {
            $flash_message['success'] = lang('Data has been saved') . sprintf(' (%d)', $do_update);
            $this->session->set_userdata('flash_message', $flash_message);
            $back_url                 = $this->session->userdata(md5(__FILE__ . 'back'));

            // $this->load->model('payslip_mdl');
        
            // foreach($data as $item){
                

            //     $row = $this->db->where('empl_id', $item['empl_id'])->get('apr_sv_payslip')->row();
            //     //echo json_encode($row) . "\n";
            //     if(!empty($row)){
            //         $this->payslip_mdl->fix_pph21($row,$row->empl_stat);
            //     }
                

                
            // }

            return redirect($back_url);
        }
        $flash_message['error'] = lang('error_saving');
        $this->session->set_userdata('flash_message', $flash_message);
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
            'attn_s',
            'attn_i',
            'attn_a',
            'attn_l',
            'attn_c',
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

        $print_dt = strtotime($detail->print_dt);
        $year     = date('Y', $print_dt);
        $month    = date('F', $print_dt);
        $month    = lang(ucfirst($month));
        $periode  = $year;
        $periode  .= ' ';
        $periode  .= $month;
        $this->set_page_title(lang("Attendance") . ': ' . sprintf(' %s / %s - %s / %s', $periode, $detail->nipp, $detail->empl_name, $detail->job_unit));

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
        $error  = array();
        $attn_s = filter_var($data[md5('attn_s')], FILTER_SANITIZE_NUMBER_INT);
        $attn_i = filter_var($data[md5('attn_i')], FILTER_SANITIZE_NUMBER_INT);
        $attn_a = filter_var($data[md5('attn_a')], FILTER_SANITIZE_NUMBER_INT);
        $attn_l = filter_var($data[md5('attn_l')], FILTER_SANITIZE_NUMBER_FLOAT);
        $attn_c = filter_var($data[md5('attn_c')], FILTER_SANITIZE_NUMBER_INT);
        if (!$error) {

            $do_update = $this->{$mdl}->update_attn($edit_id, $attn_s, $attn_i, $attn_a, $attn_l, $attn_c);
            if ($do_update) {
                $flash_message['success'] = lang('Data has been saved');
                $this->session->set_userdata('flash_message', $flash_message);
                $r_url                    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
                $row = $this->db->where('empl_id', $edit_id)->get('apr_sv_payslip')->row();
                $this->load->model('payslip_mdl');            
                  if(!empty($row)){
                    $this->payslip_mdl->fix_pph21($row,$row->empl_stat);
                }
echo json_encode($row) . "\n";
                return redirect(sprintf($r_url, $edit_id));
            }
        }
        if ($error) {

            $flash_message['error'] = lang('error_saving');
            $this->session->set_userdata('flash_message', $flash_message);
            return $error;
        }
    }

    public function _do_edit_wd($mdl, $id) {
        $tpl   = 'edit_detail_wd';
        $error = array();
        $post  = $this->input->post();
        if ($post) {
            $error = $this->_do_edit_wd_post($mdl, $id, $post);
        }
        $detail = $this->{$mdl}->fetch_detail($id);
        if (!$detail) {
            return $this->print_page($tpl);
        }
        $back_url       = $this->session->userdata(md5(__FILE__ . 'back-admattn'));
        $rs_form_input  = array(
            'back_url' => $back_url
        );
        $rs_form_inputs = array(
            'id',
            'work_day',
            'text',
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
        $data['detail'] = $detail;
        $this->set_data($data);
        
        $this->set_page_title(lang("Working Day Edit"));

        return $this->print_page($tpl);
    }

    protected function _do_edit_wd_post($mdl, $id, $input) {

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
        $error  = array();
        $var    = 'work_day';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_NUMBER_INT);
        if (!${$var}) {
            $error[$var] = lang('required');
        }

        $var    = 'text';
        ${$var} = filter_var($data[md5($var)], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        if (!$error) {

            $do_update = $this->{$mdl}->update_work_day($edit_id, $work_day, $text);
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
    
    public function _download_attn_template() {
        $mdl                          = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->set_custom_filter($mdl);
        $cf                           = $this->{$mdl}->get_custom_filter_data();
        $this->{$mdl}->rs_index_where = "`lock`=0";
        $rs_select = array(
            $this->{$mdl} -> tbl . ".empl_id", 
            $this->{$mdl} -> tbl . ".nipp", 
            $this->{$mdl} -> tbl_fp . ".fpid empl_fpid", 
            $this->{$mdl} -> tbl . ".empl_name", 
            $this->{$mdl} -> tbl . ".attn_s", 
            $this->{$mdl} -> tbl . ".attn_i", 
            $this->{$mdl} -> tbl . ".attn_a", 
            $this->{$mdl} -> tbl . ".attn_l", 
            $this->{$mdl} -> tbl . ".attn_c"
        );
        $this->{$mdl}->rs_select      = implode(',', $rs_select);
//        $this->{$mdl}->set_joins();
        $list                         = $this->{$mdl}->fetch_all_attn();
        $this->load->library('pr_phpexcel');
        $this->pr_phpexcel->_init();
        $sheet_title                  = 'ATTN-' . $cf['cf_cur_year'] . '-' . $cf['cf_cur_month'];
        $this->pr_phpexcel->sheetTitle($sheet_title);
        $title                        = array(
            array(
                'Daftar Kehadiran Pegawai'
            ),
            array(
                'Periode Tahun:',
                NULL,
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
                NULL,
                $cf['cf_cur_month']
            ),
        );

        $this->pr_phpexcel->dataFromArray($title);
        $this->pr_phpexcel->merge('A1:J1');
        $this->pr_phpexcel->setAlignment('A1', 'c');
        $this->pr_phpexcel->merge('A2:E2');
        $this->pr_phpexcel->merge('F2:J2');
        $this->pr_phpexcel->merge('A3:E3');
        $this->pr_phpexcel->merge('F3:J3');
        $this->pr_phpexcel->setAlignment('A2:A3', 'r');


        $header = array(
            'NO',
            'EMPL_ID',
            'NIPP',
            'FPID',
            'NAMA',
            'S',
            'I',
            'A',
            'L',
            'C',
        );
        $this->pr_phpexcel->dataFromArray($header, 'A4');
        $this->pr_phpexcel->setFillColor('A4:J4', 'FFDCDCDC');

        //
        $fn = 'absensi' . $cf['cf_cur_year'] . $cf['cf_cur_month'];
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
                $row->empl_fpid,
                $row->empl_name,
                $row->attn_s,
                $row->attn_i,
                $row->attn_a,
                $row->attn_l,
                $row->attn_c,
            );
        }
        if (!$ls) {
            $this->pr_phpexcel->download_xlsx($fn);
        }
        $this->pr_phpexcel->setValues($ls, 0, 5);
        $this->pr_phpexcel->sheetAutosize('A', 'J');
        $this->pr_phpexcel->download_xlsx($fn);
        //
    }

    public function edit($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
        $this->{$mdl}->set_joins();
        $this->{$mdl}->set_rs_select();
        if ($id) {
            if ($id == md5('del' . date('ymd'))) {
                if ($cur_page) {
                    return $this->_do_del($mdl, $cur_page);
                }
            }
            if ($id == md5('dl-attn-tpl' . date('ymd'))) {
                return $this->_download_attn_template($mdl);
            }
            if ($id == md5('import' . date('ymd'))) {
                return $this->_attn_import($mdl);
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
        
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Attendance') . sprintf(' %s', $period));
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
        $period = $this->_set_ym_period($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        $this->set_page_title(lang('Attendance') . sprintf(' %s', $period));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->print_page($tpl);
    }

    protected function set_wd_year_filter($mdl = null, $suffix = '') {
        $var = 'get_custom_filter_config' . $suffix;
        if (!method_exists($mdl, $var)) {
            return;
        }
        $var = 'get_custom_filter_data' . $suffix;
        if (!method_exists($mdl, $var)) {
            return;
        }
        $var = 'handle_custom_filter' . $suffix;
        if (!method_exists($mdl, $var)) {
            return;
        }
        $var     = 'get_custom_filter_config' . $suffix;
        $config  = $this->{$mdl}->{$var}();
        $input   = $this->input->post();
        $var     = 'handle_custom_filter' . $suffix;
        $this->{$mdl}->{$var}($input);
        $var     = 'get_custom_filter_data' . $suffix;
        $cf_data = $this->{$mdl}->{$var}();
        $var     = 'generate_sv_data' . $suffix;
        if (method_exists($this->{$mdl}, $var)) {
            $this->{$mdl}->{$var}($this->{$mdl}->rs_cf_cur_year);
        }

        $this->{$mdl}->rs_common_views['custom_filter'] = $this->load->view($config['tpl'], compact('cf_data'), true);
    }

    public function working_day($id = null, $cur_page = null, $per_page = 12, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->att_wd_mdl;
        $this->load_mdl($mdl);

        if ($id) {
            if ($id == md5('dl-wd-tpl' . date('ymd'))) {
                return $this->_do_dl_wd_tpl($mdl);
            }
            if ($id == md5('import' . date('ymd'))) {
                return $this->_do_wd_import($mdl);
            }
            return $this->_do_edit_wd($mdl, $id);
        }
        $this->session->set_userdata(md5(__FILE__ . 'back-admattn'), base_url(uri_string()));
        $this->set_wd_year_filter($mdl);
        $this->set_common_views($mdl);
        if (!$cur_page) {
            $cur_page = 1;
        }
        $this->{$mdl}->rs_index_where = "active_status=1";
//        $this->{$mdl}->set_joins();
//        $this->{$mdl}->set_rs_select();

        $ls = $this->{$mdl}->fetch_data($cur_page, $per_page, $order_by, $sort_order);

        $this->set_page_title(lang('Working Day Management') . sprintf(' %s %s', lang('Year'), $this->{$mdl}->rs_cf_cur_year));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }

}
