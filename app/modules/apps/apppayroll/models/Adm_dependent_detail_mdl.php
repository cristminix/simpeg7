<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Dependent_Detail_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'apr_adm_dependent';
    public $tbl_payslip          = 'apr_sv_payslip';
    public $tbl_relatives        = 'apr_ref_empl_relatives';
    public $rs_empl_id;
    public $rs_action_back_url;
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_confirm_list      = array();
    public $rs_field_list        = array(
        '1' => 'text',
        'relatives',
        'gender',
        'dependent_status',
        'alw_rc_ch_cnt',
        'eff_date',
        'term_date',
        'annotation',
    );
    public $rs_first_list_orders = array(
//        array(
//            "apr_adm_dependent.relatives"
//        ),
//        array(
//            "apr_adm_dependent.eff_date",
//            "asc",
//        )
    );
    public $rs_last_list_orders  = array(
        array(
            "apr_adm_dependent.relatives"
        ),
        array(
            "apr_adm_dependent.eff_date",
            "asc",
        )
    );
    public $rs_masked_field_list = array(
        '1' => 'Dependent Name',
        'Status',
        'Gender',
        'Alw. Stat.',
        'Rice Alw. Stat.',
        'Since',
        'Until',
        'Notes',
    );
    public $rs_common_views      = array(
        /* call_user_func */
        'call_user_func'      => array(
            'gender' => array(
                'callable' => 'strtoupper'
            ),
        ),
        'currency_field_list' => array(
        ),
        'cell_alignments'     => array(
            'gender'           => 'center',
            'dependent_status' => 'center',
            'alw_rc_ch_cnt'    => 'center',
        ),
        'cell_nowrap'         => array(
            'ddc_wb'
        ),
        'date_field_list'     => array(
            'eff_date'  => 'd/m/Y',
            'term_date' => 'd/m/Y',
        ),
    );
    public $rs_now;
    public $rs_order_by          = 'eff_date';
    public $rs_sort_order        = 'desc';
    public $rs_select            = "*";
    public $rs_use_form_filter   = 'apr_adm_marstat';

    protected function _set_dependent($empl_id) {
        $this->_unset_all_dependent($empl_id);
        $ls = $this->get_payslip_by_empl_id($empl_id);
//        debug($ls);die();
        if (!$ls) {
            return;
        }
        // Get Schema
        require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'payslip_mdl_schema' . EXT;
        $tbl      = $this->tbl_payslip;
        $tbl_join = $this->tbl;
        foreach ($ls as $row) {
            $empl_id   = $row->empl_id;
            $strtotime = strtotime($row->print_dt);
            $year      = date('Y', $strtotime);
            $month     = date('m', $strtotime);
            $lastdate  = date('t', strtotime($year . '-' . $month . '-01'));

            // update child count
            $sqlstr = Payslip_Mdl_Schema::get_update_child_count($tbl, $tbl_join, $year, $month, $lastdate, $empl_id);
//            debug($sqlstr);die();
            $query  = $this->db->query($sqlstr);

// update count children fro rice alw
            $sqlstr = Payslip_Mdl_Schema::get_update_alw_rc_ch_cnt($tbl, $tbl_join, $year, $month, $lastdate, $empl_id);
            $query  = $this->db->query($sqlstr);
        }
    }

    protected function _unset_all_dependent($empl_id) {
        $tbl = $this->tbl_payslip;
        $this->db->where('empl_id', $empl_id);
        $this->db->where('lock', 0);
        $this->db->set('child_cnt', NULL);
        $this->db->set('alw_rc_ch_cnt', NULL);
        $now = $this->rs_now ? $this->rs_now : date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        $this->db->update($tbl);
    }

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);

        $this->{$payslip_mdl}->get_update_all_allowance();
        $this->{$payslip_mdl}->get_update_all_deduction();
    }

    protected function _update_spouse_payslip($empl_id, $eff_date, $term_date, $mar_stat, $alw_rc_sp_cnt) {
        $this->db->where('lock', 0);
        $this->db->where('empl_id', $empl_id);
        $this->db->where('print_dt >=', $eff_date);
        if ($term_date) {
            $this->db->where('print_dt <=', $term_date);
        }

        $this->db->set('mar_stat', $mar_stat);
        $this->db->set('alw_rc_sp_cnt', $alw_rc_sp_cnt);
        $now = $this->rs_now ? $this->rs_now : date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        $this->db->update($this->tbl_payslip);
    }

    public function add_new_dependent($empl_id, $nipp, $eff_date, $term_date, $gender, $alw_rc_ch_cnt, $alw_ch_cnt, $dependent_status, $relatives, $name, $text, $annotation) {
        $now          = date('Y-m-d H:i:s');
        $this->rs_now = $now;
        $this->db->trans_begin();
        $this->db->set('empl_id', $empl_id);
        $this->db->set('nipp', $nipp);
        $this->db->set('eff_date', $eff_date);
        if (!$term_date) {
            $term_date = null;
        }
        $this->db->set('term_date', $term_date);

        $var = 'alw_rc_ch_cnt';
        if (!${$var}) {
            ${$var} = null;
        }
        $this->db->set($var, ${$var});

        $var = 'alw_ch_cnt';
        if (!${$var}) {
            ${$var} = null;
        }
        $this->db->set($var, ${$var});

        $var = 'dependent_status';
        if (!${$var}) {
            ${$var} = null;
        }
        $this->db->set($var, ${$var});

        $this->db->set('gender', $gender);
        $this->db->set('relatives', $relatives);
        $this->db->set('name', $name);
        $this->db->set('text', $text);
        $this->db->set('annotation', $annotation);
        $this->db->set('active_status', 1);
        $this->db->set('created', $now);
        $this->db->insert($this->tbl);
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            return false;
        }
        $id = $this->db->insert_id();
        $this->_set_dependent($empl_id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->_update_payslip();
            return $id;
        }
    }

    public function delete_row_dependent_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
        if ($this->db->affected_rows()) {
            $this->_set_dependent($this->rs_empl_id);
            return array('success' => lang('Delete success'));
        }
        return array('error' => lang('Delete has failed'));
    }

    public function fetch_all_member() {
        $this->db->from($this->tbl);
        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        if ($this->rs_index_where) {
            $this->db->where($this->rs_index_where, null, false);
        }
        $this->filter_result($this->db);
        if (method_exists($this, 'custom_filter_result')) {
            $this->custom_filter_result($this->db);
        }
        $this->db->order_by('apr_empl_wb.nipp + 0');
        $this->db->order_by('apr_empl_wb.name');
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->set_joins();
        $this->set_rs_select_detail();
        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }

        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        $this->db->where($this->tbl . '.id', $id);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function get_rs_action() {
        $r_url = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');

        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    'a' => array(
                        'url'     => sprintf($r_url, $this->rs_empl_id . '/' . md5('new' . date('ymd'))),
                        'text'    => '<span class="fa fa-plus  "></span> ' . lang('Add new'),
                        'a_class' => 'btn btn-sm btn-primary',
                    ),
//                    'dl' => array(
//                        'url'  => sprintf($r_url, md5('dl-bill-tpl' . date('ymd'))),
//                        'text' => $dl_title,
//                    ),
//                    'im' => array(
//                        'url'     => sprintf($r_url, md5('import' . date('ymd'))),
//                        'text'    => $im_title,
//                        'a_class' => 'btn-warning'
//                    )
                ),
                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
                    'e' => array(
                        'url'    => sprintf($r_url, $this->rs_empl_id . '/' . md5('edit' . date('ymd')) . '/%s'),
                        'text'   => '<span class="fa fa-edit fa-border"></span>',
                        'locked' => true,
                    ),
                    'd' => array(
                        'url'           => sprintf($r_url, $this->rs_empl_id . '/' . md5('del' . date('ymd')) . '/%s'),
                        'text'          => '<span class="fa fa-trash fa-border text-warning"></span>',
                        'show_by_field' => 'id',
                    ),
                ),
            )
        );
        if (!property_exists($this, 'rs_action_back_url')) {
            return $action;
        }
        if (!$this->rs_action_back_url) {
            return $action;
        }
        $action['view_data']['action_top']['_back'] = array(
            'url'  => $this->rs_action_back_url,
            'text' => '<span class="fa fa-arrow-left  "></span> ' . lang('back'),
        );
        sort($action['view_data']['action_top']);
        return $action;
    }

    public function get_relatives() {
        $this->db->select('text');
        $this->db->where('active_status', 1);
        $this->db->order_by('menu_order', 'asc');
        $res = $this->db->get($this->tbl_relatives)->result();
        $ls  = array();
        if (!$res) {
            return $ls;
        }
        foreach ($res as $row) {
            $ls[$row->text] = $row->text;
        }
        return $ls;
    }

    public function get_relatives_alw_ch_cnt() {
        $this->db->select('text');
        $this->db->where('menu_code', 'alw_ch_cnt');
        $this->db->where('active_status', 1);
        $this->db->order_by('menu_order', 'asc');
        $res = $this->db->get($this->tbl_relatives)->result();
        $ls  = array();
        if (!$res) {
            return $ls;
        }
        foreach ($res as $row) {
            $ls[$row->text] = $row->text;
        }
        return $ls;
    }

    public function get_payslip_by_empl_id($empl_id) {
        $this->db->where('lock', 0);
        $this->db->where('empl_id', $empl_id);
        $this->db->order_by('print_dt', 'asc');
        return $this->db->get($this->tbl_payslip)->result();
    }

    public function update_dependent($id, $eff_date, $term_date, $gender, $alw_rc_ch_cnt, $alw_ch_cnt, $dependent_status, $relatives, $text, $annotation) {
        $now          = date('Y-m-d H:i:s');
        $this->rs_now = $now;
        $this->db->trans_begin();
        $this->db->set('eff_date', $eff_date);
        if (!$term_date) {
            $term_date = null;
        }
        $this->db->set('term_date', $term_date);

        $var = 'alw_rc_ch_cnt';
        if (!${$var}) {
            ${$var} = null;
        }
        $this->db->set($var, ${$var});

        $var = 'alw_ch_cnt';
        if (!${$var}) {
            ${$var} = null;
        }
        $this->db->set($var, ${$var});

        $var = 'dependent_status';
        if (!${$var}) {
            ${$var} = null;
        }
        $this->db->set($var, ${$var});

        $this->db->set('gender', $gender);
        $this->db->set('relatives', $relatives);
        $this->db->set('name', $name);
        $this->db->set('text', $text);
        $this->db->set('annotation', $annotation);
        $this->db->set('modified', $now);
        $this->db->where('id', $id);
        $this->db->update($this->tbl);
        $affected = $this->db->affected_rows();
        if ($affected <= 0) {
            $this->db->trans_rollback();
            return false;
        }
//        debug($this->rs_empl_id); die();
        $this->_set_dependent($this->rs_empl_id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->_update_payslip();
//            return $affected;
        }
        return $affected;
    }

    public function set_joins() {
//        $joins          = array(
//            array(
//                'apr_empl_wb',
//                'apr_empl_wb.empl_id=' . $this->tbl . '.empl_id AND apr_empl_wb.active_status=1',
//                'left'
//            )
//        );
//        $this->rs_joins = $joins;
    }

    public function set_rs_select() {
//        $this->rs_select = $this->tbl . '.*, apr_empl_wb.acc_id, apr_empl_wb.acc_reg_date, apr_empl_wb.acc_term';
    }

    public function set_rs_select_detail() {
//        $this->rs_select = $this->tbl . '.*,apr_empl_wb.acc_id, apr_empl_wb.acc_reg_date, apr_empl_wb.acc_term';
    }

}
