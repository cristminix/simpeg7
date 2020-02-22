<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Marstat_Detail_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'apr_adm_marstat';
    public $tbl_payslip          = 'apr_sv_payslip';
    public $tbl_wc               = 'apr_empl_wb';
    public $rs_empl_id;
    public $rs_action_back_url;
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_confirm_list      = array();
    public $rs_field_list        = array(
        '1' => 'text',
        'mar_stat',
        'alw_rc_sp_cnt',
        'eff_date',
        'term_date',
        'annotation',
    );
    public $rs_masked_field_list = array(
        '1' => 'Spouse Name',
        'Status',
        'Rice Alw. Stat.',
        'Since',
        'Until',
        'Notes',
    );
    public $rs_last_list_orders = array(
       
        array(
            "apr_adm_marstat.eff_date",
            "asc",
        )
    );
    public $rs_common_views      = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'ddc_wb',
        ),
        'cell_alignments'     => array(
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

    protected function _set_spouse($empl_id) {
        $this->_unset_all_spouse($empl_id);
        $spouses = $this->get_spouse_by_empl_id($empl_id);
        if (!$spouses) {
            return;
        }
        foreach ($spouses as $spouse) {
            $this->_update_spouse_payslip($empl_id, $spouse->eff_date, $spouse->term_date, $spouse->mar_stat, $spouse->alw_rc_sp_cnt);
        }
    }

    protected function _unset_all_spouse($empl_id) {
        $tbl = $this->tbl_payslip;
        $this->db->where('empl_id', $empl_id);
        $this->db->where('lock', 0);
        $this->db->set('mar_stat', NULL);
        $this->db->set('alw_mar', NULL);
        $this->db->set('alw_rc_sp_cnt', NULL);
        $now = $this->rs_now ? $this->rs_now : date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        $this->db->update($tbl);
    }

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);

        $this->{$payslip_mdl}->get_update_all_allowance();
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

    public function add_new_spouse($empl_id, $nipp, $eff_date, $term_date, $alw_rc_sp_cnt, $mar_stat, $name, $text, $annotation) {
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

        if (!$alw_rc_sp_cnt) {
            $alw_rc_sp_cnt = null;
        }
        $this->db->set('alw_rc_sp_cnt', $alw_rc_sp_cnt);

        if (!$mar_stat) {
            $mar_stat = null;
        }
        $this->db->set('mar_stat', $mar_stat);

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
        $this->_set_spouse($empl_id);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->_update_payslip();
            return $id;
        }
    }

    public function delete_row_spouse_by_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->tbl);
        if ($this->db->affected_rows()) {
            $this->_set_spouse($this->rs_empl_id);
            return array('success' => lang('Delete success'));
        }
        return array('error' => lang('Delete has failed'));
    }

//    public function delete_row_by_id($id) {
//        $this->db->where('id', $id);
//        $this->db->delete($this->tbl);
//        if ($this->db->affected_rows()) {
//            return array('success' => lang('Delete success'));
//        }
//        return array('error' => lang('Delete has failed'));
//    }

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

//    public function fetch_ids_by_empl_id_print_dt($empls_id, $print_dt) {
//        $this->db->from($this->tbl);
//        $this->db->select('id, empl_id');
//        $this->db->where('lock', 0);
//        $this->db->where('print_dt', $print_dt);
//        $this->db->where_in('empl_id', $empls_id);
//        $rs = $this->db->get();
//
//        if (!$rs) {
//            return array();
//        }
//        $res = $rs->result();
//        if (!$res) {
//            return array();
//        }
//        $ids = array();
//        foreach ($res as $row) {
//            $ids[$row->empl_id] = $row->id;
//        }
//        return $ids;
//    }
//    public function generate_sv_data($year, $month) {
//        $this->load->model($this->payslip_mdl_inst);
//        $this->{$this->payslip_mdl_inst}->generate_sv_data($year, $month);
//    }
//    public function get_custom_filter_config() {
//        $res        = array();
//        $res['tpl'] = 'elements/scaffolding/custom_filter_year_month';
//        return $res;
//    }
//
//    public function get_custom_filter_data() {
//        $res             = array();
//        $res['cf_label'] = lang('Period');
//        $this_year       = date('Y'); // year
//
//        $cur_year = $this_year;
//        if ($this->rs_cf_cur_year) {
//            $cur_year = $this->rs_cf_cur_year;
//        }
//        $res['cf_cur_year'] = $cur_year;
//        $res['cf_year_min'] = $cur_year - 10;
//        $diff               = $this_year - $cur_year;
//        $res['cf_year_max'] = $diff < 7 ? $cur_year + $diff : $cur_year + 7;
//        $this_month         = date('m'); // month
//        $cur_month          = $this_month;
//        if ($this->rs_cf_cur_month) {
//            $cur_month = $this->rs_cf_cur_month;
//        }
//        $res['cf_cur_month'] = $cur_month;
//        $res['cf_months']    = array(
//            '01' => lang('January'),
//            '02' => lang('February'),
//            '03' => lang('March'),
//            '04' => lang('April'),
//            '05' => lang('May'),
//            '06' => lang('June'),
//            '07' => lang('July'),
//            '08' => lang('August'),
//            '09' => lang('September'),
//            '10' => lang('October'),
//            '11' => lang('November'),
//            '12' => lang('December'),
//        );
//        return $res;
//    }


    public function get_rs_action() {
        $r_url = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
//        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
//        $dl_title .= lang('Download Bill');
//        $dl_title .= ' ';
//        $dl_title .= $this->rs_cf_cur_year;
//        $dl_title .= '-';
//        $dl_title .= $this->rs_cf_cur_month;
//
//        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
//        $im_title .= lang('Bill Import');
//        $im_title .= ' ';
//        $im_title .= $this->rs_cf_cur_year;
//        $im_title .= '-';
//        $im_title .= $this->rs_cf_cur_month;

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

    public function get_spouse_by_empl_id($empl_id) {
        $this->db->where('active_status', 1);
        $this->db->where('empl_id', $empl_id);
        $this->db->order_by('eff_date', 'asc');
        return $this->db->get($this->tbl)->result();
    }

//    public function handle_custom_filter($input = array()) {
//        $rs_cf_cur_year  = date('Y'); //fallback
//        $rs_cf_cur_month = date('m'); //fallback
//        $do_filter       = false;
//        $do_reset        = false;
//        $mod             = $this->router->fetch_module();
//        $ctl             = $this->router->fetch_class();
//        $mtd             = $this->router->fetch_method();
//        $sess_name       = sprintf('%s%s%s%s', 'cf_', $mod, $ctl, $mtd);
//
//        if ($input) {
//            if (isset($input['cf_do_filter'])) {
//                $do_filter = $input['cf_do_filter'] ? true : false;
//            }
//            if (isset($input['cf_do_reset'])) {
//                $do_reset = $input['cf_do_reset'] ? true : false;
//            }
//        }
//        if ($do_reset) {
//            $rs_cf_cur_year  = date('Y');
//            $rs_cf_cur_month = date('m');
//            $this->session->set_userdata($sess_name, array($rs_cf_cur_year, $rs_cf_cur_month));
//        }
//        if ($do_filter) {
//            $rs_cf_cur_year  = $input['cf_year'];
//            $rs_cf_cur_month = $input['cf_month'];
//            $this->session->set_userdata($sess_name, array($rs_cf_cur_year, $rs_cf_cur_month));
//        }
//
//        $sess = $this->session->userdata($sess_name);
//        if ($sess) {
//            $rs_cf_cur_year  = $sess[0];
//            $rs_cf_cur_month = $sess[1];
//        }
//
//        $this->rs_cf_cur_year  = $rs_cf_cur_year;
//        $this->rs_cf_cur_month = $rs_cf_cur_month;
//        $this->session->set_userdata($sess_name, array($rs_cf_cur_year, $rs_cf_cur_month));
//    }
//
//    public function custom_filter_result(&$db) {
////        $db->where('YEAR(print_dt)', $this->rs_cf_cur_year, false);
////        $db->where('MONTH(print_dt)', $this->rs_cf_cur_month, false);
//    }

    public function delete_tpp($id) {
        $this->db->where('apr_sv_payslip_id', $id);
        $this->db->delete($this->tbl_app);
        if ($this->db->affected_rows()) {
            return array('success' => lang('Delete success'));
        }
        return array('error' => lang('Delete has failed'));
    }

    public function update_batch_bill($data, $key) {
        $this->db->update_batch($this->tbl, $data, $key);
        return $this->db->affected_rows();
        //        $data = array(
//   array(
//      'title' => 'My title' ,
//      'name' => 'My Name 2' ,
//      'date' => 'My date 2'
//   ),
//   array(
//      'title' => 'Another title' ,
//      'name' => 'Another Name 2' ,
//      'date' => 'Another date 2'
//   )
//);
//$this->db->update_batch('mytable', $data, 'title');
    }

    public function update_spouse($id, $eff_date, $term_date, $alw_rc_sp_cnt, $mar_stat, $text, $annotation) {
        $now      = date('Y-m-d H:i:s');
        $this->db->trans_begin();
        $this->db->set('eff_date', $eff_date);
        if(!$term_date){
            $term_date = null;
        }
        $this->db->set('term_date', $term_date);
        if(!$alw_rc_sp_cnt){
            $alw_rc_sp_cnt=null;
        }
        $this->db->set('alw_rc_sp_cnt', $alw_rc_sp_cnt);
        if(!$mar_stat){
            $mar_stat = null;
        }
        $this->db->set('mar_stat', $mar_stat);
        $this->db->set('text', $text);
        $this->db->set('annotation', $annotation);
        $this->db->where('id', $id);
        $this->db->update($this->tbl);
        $affected = $this->db->affected_rows();
        if ($affected <= 0) {
            $this->db->trans_rollback();
            return false;
        }
        $this->_set_spouse($this->rs_empl_id);
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
