<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Attn_Wd_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'apr_adm_work_day';
    public $tbl_payslip          = 'apr_sv_payslip';
    public $tbl_r_pegawai        = 'r_pegawai';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list        = array(
        '1' => 'eff_month',
        'name',
        'work_day',
        'print_dt',
        'text',
    );
//    public $rs_field_list_unsigned        = array(
//        '1' => 'nip_baru',
//        'nama_pegawai',
//        'status_pegawai',
//        'tgl_terima',
//    );
    public $rs_masked_field_list = array(
        '1' =>  'Month ID',
        'Month',
        'Work Day',
        'Print Date',
        'Notes',
    );
    public $rs_per_page_options  = array(
    );

    public $rs_per_page          = '12';
    public $rs_use_form_filter   = 'apr_adm_work_day';
    public $rs_select            = "*";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        'date_field_list' => array(
            'print_dt' => 'd/m/Y',
        )
    );
    public $rs_index_where       = " active_status=1";

//    public $rs_common_views_unsigned      = array(
//        /* date_field_list */
//        'date_field_list' => array(
//            'print_date' => 'd/m/Y',
//        )
//    );

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);
        $this->{$payslip_mdl}->get_update_all_allowance();
    }
    
    protected function _update_payslip_work_day($print_dt, $work_day) {
        $now = date('Y:m:d H:i:s');
        $this->db->set('work_day', $work_day);
        $this->db->set('modified', $now);
        $this->db->where('lock', 0);
        $this->db->where('print_dt', $print_dt);
        $this->db->update($this->tbl_payslip);
        $this->load->model('payslip_mdl');
        $records = $this->db->where('print_dt',$print_dt)
                            ->where('lock', 0)
                            ->get($this->tbl_payslip)
                            ->result();
        foreach ($records as &$row) {
            $this->payslip_mdl->fix_pph21($row,$row->empl_stat);
        }

    }

    protected function _set_all_work_day() {
        $tbl    = $this->tbl;
        $sqlstr = "SELECT print_dt, work_day FROM {$tbl} WHERE active_status=1";
        $rs     = $this->db->query($sqlstr);
        if (!$rs) {
            return false;
        }
        $res = $rs->result();
        if (!$res) {
            return false;
        }

        foreach ($res as $row) {
            $this->_set_work_day($print_dt, $work_day);
        }
    }

    protected function _set_work_day($print_dt, $work_day) {
        $tbl_payslip = $this->tbl_payslip;
        $sqlquery    = "UPDATE {$tbl_payslip} ";
        $sqlquery    .= " SET ";
        $sqlquery    .= " work_day='{$work_day}'";
        $sqlquery    .= ", modified=NOW()";
        $sqlquery    .= " WHERE `lock`= 0";
        $sqlquery    .= " AND `print_dt` = '{$print_dt}'";
        $this->db->query($sqlquery);
    }

    protected function _unset_work_day($print_dt) {
        $tbl_payslip = $this->tbl_payslip;
        $sqlquery    = "UPDATE {$tbl_payslip} ";
        $sqlquery    .= " SET ";
        $sqlquery    .= " modified=NOW()";
        $sqlquery    .= ", work_day=22";
        $sqlquery    .= " WHERE `lock`= 0";
        $sqlquery    .= " AND `print_dt` = '{$print_dt}'";
        $this->db->query($sqlquery);
    }

    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        if (method_exists($this, 'set_joins')) {
            $this->set_joins();
        }
        if (method_exists($this, 'set_rs_select')) {
            $this->set_rs_select();
        }

        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        $this->db->where('id', $id);
        $this->db->where($this->rs_index_where, null, false);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function add_new_work_day($empl_id, $fkp_id, $member_pos, $member_since, $member_term) {
        $detail = $this->fetch_detail_unsigned($empl_id);
        if (!$detail) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $this->db->trans_begin();
        $this->db->set('empl_id', $empl_id);
        $this->db->set('name', $detail->nama_pegawai);
        $this->db->set('nipp', $detail->nip_baru);
        $this->db->set('fkp_id', $fkp_id);
        $this->db->set('member_pos', $member_pos);
        $this->db->set('member_since', $member_since);
        if (!$member_term) {
            $member_term = null;
        }
        $this->db->set('member_term', $member_term);
        $this->db->set('created', $now);
        $this->db->set('active_status', 1);
        $this->db->insert($this->tbl);
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            return false;
        }
        $id = $this->db->insert_id();
        $this->_set_member($empl_id, $member_since, $member_term);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->_update_payslip();
            return $id;
        }
    }

    public function delete_row_by_id($id) {
        $detail = $this->fetch_detail($id);

        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->set('active_status', 0);
        $this->db->update($this->tbl);

        if ($this->db->affected_rows()) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                return array('error' => lang('Delete has failed'));
            } else {
                $this->_unset_member($detail->empl_id, $detail->member_since, $detail->member_term);
                $this->db->trans_commit();
                //$this->_update_payslip();
                return array('success' => lang('Delete success'));
            }
        }
        $this->db->trans_rollback();
        return array('error' => lang('Delete has failed'));
    }

    public function do_batch_assignment() {
        $tbl      = $this->tbl;
        $tbl_rpeg = $this->tbl_r_pegawai;

        $sqlstr1 = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp_fkp";
        $sqlstr1 .= " SELECT empl_id FROM {$tbl} WHERE active_status=1";
        //
        $sqlstr2 = "INSERT INTO {$tbl} (empl_id, nipp, member_pos, member_status, member_since,`name`, active_status, `created`) ";
        $sqlstr2 .= " SELECT id_pegawai empl_id, nip_baru nipp, 'Anggota' member_pos, 1 member_status, tgl_terima member_since, nama_pegawai `name`, 1 active_status, NOW() `created`";
        $sqlstr2 .= " FROM {$tbl_rpeg} ";
        $sqlstr2 .= " WHERE id_pegawai NOT IN (";
        $sqlstr2 .= " SELECT empl_id FROM tmp_fkp";
        $sqlstr2 .= " )";
        //
        //

        $this->db->trans_begin();

        $this->db->query($sqlstr1);
        //
        $this->db->query($sqlstr2);
        //

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $flash_message['error'] = lang('Action failed!');
            $this->session->set_userdata('flash_message', $flash_message);
        } else {
            $this->db->trans_commit();
            $this->_set_all_member();
            $this->_update_payslip();
            $flash_message['success'] = lang('Success!');
            $this->session->set_userdata('flash_message', $flash_message);
        }
        return $this->db->trans_status();
    }

    public function custom_filter_result(&$db) {
        $db->where('YEAR(print_dt)', $this->rs_cf_cur_year, false);
    }

    public function get_id_by_print_dt($print_dt) {
        $this->db->select('id');
        $this->db->where('print_dt', $print_dt);
        $this->db->where('active_status', 1);
        $this->db->from($this->tbl);
        return $this->db->get()->result();
    }

    public function get_rs_action() {

        $r_url  = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
//                    'a' => array(
//                        'url'  => sprintf($r_url, md5('new' . date('ymd'))),
//                        'text' => '<span class="fa fa-plus  "></span> ' . lang('Add new'),
////                        'a_class' => 'btn btn-sm btn-primary',
//                    ),
//                    'b' => array(
//                        'url'     => sprintf($r_url, md5('batch-assignment' . date('ymd'))),
//                        'text'    => '<span class="fa fa-plus-square "></span> ' . lang('Sign all !'),
//                        'a_class' => 'btn-warning',
//                    )
                ),
                'action_list' => array(
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-edit text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function get_custom_filter_data() {
        $res             = array();
        $res['cf_label'] = lang('Year');
        $this_year       = date('Y')+5; // year

        $cur_year = $this_year;
        if ($this->rs_cf_cur_year) {
            $cur_year = $this->rs_cf_cur_year;
        }
        $res['cf_cur_year'] = $cur_year;
        $res['cf_year_min'] = $cur_year - 10;
        $diff               = $this_year - $cur_year;
        $res['cf_year_max'] = $diff < 5 ? $cur_year + $diff : $cur_year + 5;
        

        return $res;
    }

    public function handle_custom_filter($input = array()) {
        $rs_cf_cur_year = date('Y'); //fallback

        $do_filter = false;
        $do_reset  = false;
        $mod       = $this->router->fetch_module();
        $ctl       = $this->router->fetch_class();
        $mtd       = $this->router->fetch_method();
        $sess_name = sprintf('%s%s%s%s', 'cf_', $mod, $ctl, $mtd);

        if ($input) {
            if (isset($input['cf_do_filter'])) {
                $do_filter = $input['cf_do_filter'] ? true : false;
            }
            if (isset($input['cf_do_reset'])) {
                $do_reset = $input['cf_do_reset'] ? true : false;
            }
        }
        if ($do_reset) {
            $rs_cf_cur_year = date('Y');
            $this->session->set_userdata($sess_name, array($rs_cf_cur_year));
        }
        if ($do_filter) {
            $rs_cf_cur_year = $input['cf_year'];
            $this->session->set_userdata($sess_name, array($rs_cf_cur_year));
        }

        $sess = $this->session->userdata($sess_name);
        if ($sess) {
            $rs_cf_cur_year = $sess[0];
        }

        $this->rs_cf_cur_year = $rs_cf_cur_year;
        $this->session->set_userdata($sess_name, array($rs_cf_cur_year));
    }

    public function generate_sv_data($year) {
        $work_day   = '22';
        $first_date = '01';
        $res_months = array(
            '01' => lang('January'),
            '02' => lang('February'),
            '03' => lang('March'),
            '04' => lang('April'),
            '05' => lang('May'),
            '06' => lang('June'),
            '07' => lang('July'),
            '08' => lang('August'),
            '09' => lang('September'),
            '10' => lang('October'),
            '11' => lang('November'),
            '12' => lang('December'),
        );
        $s_print_dt = $year . '-%s-%s';
        $now        = date('Y-m-d H:i:s');
        foreach ($res_months as $m_id => $m_name) {
            $time       = strtotime(sprintf($s_print_dt, $m_id, $first_date));
            $t_print_dt = date('Y-m-t', $time);

            $id = $this->get_id_by_print_dt($t_print_dt);
            if ($id) {
                continue;
            }
            $affected = $this->generate_work_day($t_print_dt, $year, $m_id, $m_name, $now);
            if($affected){
                $this->_update_payslip_work_day($t_print_dt, $work_day);
            }
        }
    }

    public function generate_work_day($t_print_dt, $year, $m_id, $m_name, $now) {
        $this->db->set('print_dt', $t_print_dt);
        $this->db->set('eff_year', $year);
        $this->db->set('eff_month', $m_id);
        $this->db->set('name', $m_name);
        $this->db->set('active_status', 1);
        $this->db->set('created', $now);
        $this->db->insert($this->tbl);
        return  $this->db->affected_rows();
    }

    public function get_custom_filter_config() {
        $res        = array();
        $res['tpl'] = 'elements/scaffolding/custom_filter_year';
        return $res;
    }

//    public function get_pagination_config() {
//        return array();
//    }

    public function update_work_day($edit_id, $work_day, $text) {

        $now        = date('Y-m-d H:i:s');
        $old_detail = $this->fetch_detail($edit_id);
        if (!$old_detail) {
            return false;
        }
        $this->db->trans_begin();
        
        $this->db->set('work_day', $work_day);
        $this->db->set('text', $text);
        $this->db->set('modified', $now);
        $this->db->where('id', $edit_id);
        $this->db->update($this->tbl);
        $affected = $this->db->affected_rows();
        if ($affected <= 0) {
            $this->db->trans_rollback();
            return false;
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            $this->_update_payslip_work_day($old_detail->print_dt, $work_day);
//            return $id;
        }
        return $affected;
    }

}
