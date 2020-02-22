<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Adm_Fkp extends Apppayroll_Frontctl {

    public $main_mdl = "adm_fkp_mdl";
    
     protected function _do_add_new($mdl, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc', $id = null) {

        $tpl                                      = __FUNCTION__;
        $suffix                                   = '_unsigned';
        $this->{$mdl}->rs_field_list              = $this->{$mdl}->rs_field_list_unsigned;
        $this->{$mdl}->rs_masked_field_list       = $this->{$mdl}->rs_masked_field_list_unsigned;
        $this->{$mdl}->rs_common_views            = $this->{$mdl}->rs_common_views_unsigned;
        $this->{$mdl}->rs_index_where_unsigned    = 'id_pegawai NOT IN (SELECT `empl_id` FROM `apr_empl_fkp` WHERE `active_status`=1)';
        $this->session->set_userdata(md5(__FILE__ . 'back-add-new'), base_url(uri_string()));
        $this->set_custom_filter($mdl, $suffix);
        $this->set_common_views($mdl, $suffix);
        $this->set_form_filter($mdl, $suffix);
        $ls                                       = $this->{$mdl}->fetch_data_unsigned($cur_page, $per_page, $order_by, $sort_order);
        $this->set_page_title(lang("FKP Add New Member"));
        $this->{$mdl}->rs_ppo_url_prefix_unsigned = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('new' . date('ymd')) . '/';
        $this->set_pagination($mdl, $suffix);

        $this->set_data(compact('ls'));
        $back_url = $this->session->userdata(md5(__FILE__ . 'back'));
        $this->set_rs_action_unsigned($mdl, $back_url);
        $this->print_page($tpl);
    }
    
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

        $this->set_page_title(lang("FKP Member") . ': ' . lang('Add new'));

        if (!$post) {
            $md5                          = md5('empl_id');
            $rs_form_input[$md5]['value'] = $detail->id_pegawai;
            $data                         = compact('rs_form_input', 'detail');
            $this->set_data($data);

            return $this->print_page($tpl);
        }
        $rs_form_inputs = array(
            'empl_id',
            'fkp_id',
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
        $fkp_id       = filter_var($data[md5('fkp_id')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $member_pos  = filter_var($data[md5('member_pos')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $member_term = filter_var($data[md5('member_term')], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$error) {

            $do_update = $this->{$mdl}->add_new_member($empl_id, $fkp_id, $member_pos, $member_since, $member_term);
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
        $this->set_page_title(lang("Warning") . ' : ' . lang('You are about to assign all employees as F-KP member'));
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
        $this->set_page_title(lang("F-KP") . ' : ' . lang('Delete Confirmation'));
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
            'fkp_id',
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
        $this->set_page_title(lang("FKP Member Edit"));
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

        $var    = 'fkp_id';
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

            $do_update = $this->{$this->main_mdl}->update_member($edit_id, $wc_id, $member_pos, $member_since, $member_term);
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
        $this->set_page_title(lang("FKP Member Administration"));
        $this->set_pagination($mdl);

        $this->set_data(compact('ls'));
        $this->set_rs_action($mdl);
        $this->print_page($tpl);
    }
    
    public function index($id = null, $cur_page = 1, $per_page = 10, $order_by = null, $sort_order = 'asc') {
        $tpl = __FUNCTION__;
        $mdl = $this->main_mdl;
        $this->load_mdl($mdl);
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
        $this->set_page_title(lang("FKP Member List"));
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