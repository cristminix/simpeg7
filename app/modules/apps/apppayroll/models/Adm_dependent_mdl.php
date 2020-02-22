<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Dependent_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'r_pegawai';
    public $tbl_dependent        = 'apr_adm_dependent';
    public $tbl_payslip          = 'apr_sv_payslip';
    public $tbl_r_pegawai        = 'r_pegawai';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list        = array(
        '1' => 'nipp',
        'name',
        'child_cnt',
        'alw_rc_cnt',
        'eff_date',
    );
    public $rs_masked_field_list = array(
        '1' => 'NIPP',
        'Name',
        'Ch. Count in Alw.',
        'Rice Alw. Count',
        'Since',
    );
    public $rs_masked_search_fields = array(
        '1' => 'r_pegawai.nip_baru',
        'r_pegawai.nama_pegawai',
        'apr_adm_dependent.child_cnt',
        'apr_adm_dependent.alw_rc_cnt',
        'apr_adm_dependent.eff_date',
    );
    public $rs_use_form_filter   = 'apr_adm_dependent';
    public $rs_select            = "*";
    public $rs_select_unsigned   = "*";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        /* date_field_list */
        'date_field_list' => array(
            'eff_date' => 'd/m/Y',
        ),
        
    );
    public $rs_index_where       = "";

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);
        $this->{$payslip_mdl}->get_update_all_deduction();
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

    public function add_new_member($empl_id, $wc_id, $member_pos, $member_since, $member_term) {
        $detail = $this->fetch_detail_unsigned($empl_id);
        if (!$detail) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $this->db->trans_begin();
        $this->db->set('empl_id', $empl_id);
        $this->db->set('name', $detail->nama_pegawai);
        $this->db->set('nipp', $detail->nip_baru);
        $this->db->set('wc_id', $wc_id);
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
        $this->db->set('npwp', NULL);
        $this->db->set('reg_date', NULL);
        $this->db->set('text', NULL);
        $this->db->update($this->tbl);

        if ($this->db->affected_rows()) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                return array('error' => lang('Delete has failed'));
            } else {
                $this->_unset_npwp($detail->empl_id, $detail->reg_date);
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

        $sqlstr1 = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp_wc";
        $sqlstr1 .= " SELECT empl_id FROM {$tbl} WHERE active_status=1";
        //
        $sqlstr2 = "INSERT INTO {$tbl} (empl_id, nipp, member_pos, member_status, member_since,`name`, active_status, `created`) ";
        $sqlstr2 .= " SELECT id_pegawai empl_id, nip_baru nipp, 'Anggota' member_pos, 1 member_status, tgl_terima member_since, nama_pegawai `name`, 1 active_status, NOW() `created`";
        $sqlstr2 .= " FROM {$tbl_rpeg} ";
        $sqlstr2 .= " WHERE id_pegawai NOT IN (";
        $sqlstr2 .= " SELECT empl_id FROM tmp_wc";
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

    public function fetch_all_npwp() {
        $this->db->from($this->tbl);

        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        if ($this->rs_index_where) {
            $this->db->where($this->rs_index_where, null, false);
        }

        $this->db->order_by('apr_adm_npwp.nipp + 0');
        $this->db->order_by('apr_adm_npwp.name');
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function get_detail_by_empl_id($empl_id) {
        //Max
        $sql_str = <<<SQL
            SELECT 
                r_pegawai.id_pegawai as id, 
                r_pegawai.nip_baru as nipp, 
                r_pegawai.nama_pegawai as name, 
                marjoin.mar_stat as mar_stat,
                marjoin.eff_date as eff_date, 
                marjoin.term_date as term_date,
                marjoin.annotation as annotation, 
                marjoin.text as text, 
                marjoin.alw_rc_sp_cnt as alw_rc_sp_cnt
            FROM (`r_pegawai`)
            LEFT JOIN (
                SELECT empl_id,mar_stat, eff_date, term_date, annotation, text, alw_rc_sp_cnt
                FROM apr_adm_marstat 
                WHERE empl_id='{$empl_id}'
                ORDER BY eff_date DESC
                LIMIT 1
            ) AS marjoin
                ON `marjoin`.`empl_id`=`r_pegawai`.`id_pegawai`
            WHERE `r_pegawai`.`id_pegawai` =  '{$empl_id}'
SQL;
        $res     = $this->db->query($sql_str)->result();
        if (!isset($res[0])) {
            return $res;
        }
        return $res[0];
    }
    
    public function get_rs_action() {

        $r_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $dl_title .= lang('Download NPWP');

        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $im_title .= lang('Import NPWP');

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
//                    'dl' => array(
//                        'url'     => sprintf($r_url, md5('dl-npwp-tpl' . date('ymd'))),
//                        'text'    => $dl_title,
//                        'a_class' => 'btn-info',
//                    ),
//                    'im' => array(
//                        'url'     => sprintf($r_url, md5('import' . date('ymd'))),
//                        'text'    => $im_title,
//                        'a_class' => 'btn-success'
//                    )
                ),
                'action_list' => array(
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-list text-warning"></span>',
                    ),
                    'd' => array(
                        'url'           => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text'          => '<span class="fa fa-eraser text-warning"></span>',
                        'show_by_field' => 'npwp',
                    ),
                ),
            )
        );
        return $action;
    }
    
    public function update_batch($data, $key) {
        $this->db->trans_begin();
        $now     = date('Y-m-d H:i:s');
        $tbl     = $this->tbl;
        $sql_str = "UPDATE `{$tbl}` SET `npwp`=NULL, `reg_date`=NULL, `modified`='{$now}'";
        $this->db->query($sql_str);

        $tbl     = $this->tbl_payslip;
        $sql_str = "UPDATE `{$tbl}` SET `empl_npwp`=NULL WHERE `lock`= 0";
        $this->db->query($sql_str);

        $this->db->update_batch($this->tbl, $data, $key);
        $affected = $this->db->affected_rows();
        if ($affected <= 0) {
            $this->db->trans_rollback();
            return false;
        }
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        $this->_set_all_npwp();
        $this->_update_payslip();
        return $affected;
    }

    public function update_npwp($edit_id, $npwp, $reg_date, $text) {

        $now        = date('Y-m-d H:i:s');
        $old_detail = $this->fetch_detail($edit_id);
        if (!$old_detail) {
            return false;
        }
        $this->db->trans_begin();

        $this->db->set('npwp', $npwp);
        $this->db->set('reg_date', $reg_date);
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
            $this->_unset_npwp($old_detail->empl_id, $reg_date);
            $this->_set_npwp($old_detail->empl_id, $npwp, $reg_date);
            $this->_update_payslip();
            return $affected;
        }
        return $this->db->affected_rows();
    }

    public function set_joins() {
        $tbl_dependent = $this->tbl_dependent;
        $tbl           = $this->tbl;
        $join_on       = <<<JOIN
            {$tbl_dependent}.empl_id={$tbl}.id_pegawai
            AND {$tbl_dependent}.active_status=1

JOIN;

        $joinq_1 = <<<JOINQ
            
JOINQ;
        $print_dt = date('Y-m-t');

        $joins             = array(
            array(
                "(SELECT 
                    {$tbl_dependent}.empl_id,
                    ch.ch_cnt child_cnt,
                    rc.rc_cnt alw_rc_cnt,
                    MAX({$tbl_dependent}.eff_date) eff_date
                FROM {$tbl_dependent} 
                    
                INNER JOIN (
                    SELECT 
                        empl_id,
                        alw_ch_cnt,
                        SUM(alw_ch_cnt) ch_cnt
                    FROM {$tbl_dependent}
                    WHERE active_status=1
                        AND alw_ch_cnt=1
                        AND eff_date <= '{$print_dt}'
                        AND IF(term_date IS NULL, TRUE,
                            term_date >= '{$print_dt}'
                        )
                    GROUP BY empl_id

                ) ch 
                ON ch.empl_id={$tbl_dependent}.empl_id 
                    AND ch.alw_ch_cnt=1
                
                INNER JOIN (
                    SELECT 
                        empl_id,
                        alw_rc_ch_cnt,
                        SUM(alw_rc_ch_cnt) rc_cnt
                    FROM {$tbl_dependent}
                    WHERE active_status=1
                        AND alw_rc_ch_cnt=1
                         AND eff_date <= '{$print_dt}'
                        AND IF(term_date IS NULL, TRUE,
                            term_date >= '{$print_dt}'
                        )
                    GROUP BY empl_id

                ) rc 
                ON rc.empl_id={$tbl_dependent}.empl_id 
                    AND rc.alw_rc_ch_cnt=1
                

                WHERE {$tbl_dependent}.active_status=1
                GROUP BY {$tbl_dependent}.empl_id
            ) AS {$tbl_dependent}",
                $join_on,
                'left'
            )
        );
        $this->rs_joins    = $joins;
        $this->rs_group_by = "{$tbl}.id_pegawai";
    }

    public function set_rs_select() {

        $this->rs_select = $this->tbl . '.id_pegawai as id';
        $this->rs_select .= ',' . $this->tbl . '.nip_baru as nipp';
        $this->rs_select .= ',' . $this->tbl . '.nama_pegawai as name';
        $this->rs_select .= ',' . $this->tbl_dependent . '.child_cnt as child_cnt';
        $this->rs_select .= ',' . $this->tbl_dependent . '.alw_rc_cnt as alw_rc_cnt';
        $this->rs_select .= ', MAX(' . $this->tbl_dependent . '.eff_date) as eff_date';
    }

}
