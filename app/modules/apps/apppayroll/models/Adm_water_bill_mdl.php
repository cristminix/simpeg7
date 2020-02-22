<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Water_Bill_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst              = 'payslip_mdl';
    public $tbl                           = 'apr_empl_wb';
    public $tbl_payslip                   = 'apr_sv_payslip';
    public $tbl_r_pegawai                 = 'r_pegawai';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list                 = array(
        '1' => 'nipp',
        'acc_id',
        'name',
        'acc_reg_date',
        'acc_term',
    );
    public $rs_field_list_unsigned        = array(
        '1' => 'nip_baru',
        'nama_pegawai',
        'status_pegawai',
        'tgl_terima',
    );
    public $rs_masked_field_list          = array(
        '1' => 'NIPP',
        'Account ID',
        'Name',
        'Registered',
        'Termination',
    );
    public $rs_masked_field_list_unsigned = array(
        '1' => 'NIPP',
        'Name',
        'Status',
        'Join date',
    );
    public $rs_per_page_options_unsigned  = array(
        10,
        20,
        25,
        30,
        40,
        50,
        100,
        250,
        500,
        1000
    );
    public $rs_use_form_filter            = 'apr_empl_wb';
    public $rs_use_form_filter_unsigned   = 'r_pegawai';
    public $rs_select                     = "*";
    public $rs_select_unsigned            = "*";
    public $rs_order_by                   = null;
    public $rs_common_views               = array(
        /* date_field_list */
        'date_field_list' => array(
            'acc_reg_date' => 'd/m/Y',
            'acc_term' => 'd/m/Y',
        )
    );
    public $rs_index_where                = " active_status=1";
    public $rs_common_views_unsigned      = array(
        /* date_field_list */
        'date_field_list' => array(
            'tgl_terima' => 'd/m/Y',
        )
    );

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);
        $this->{$payslip_mdl}->get_update_all_deduction();
    }

    protected function _set_all_acc() {
        $tbl    = $this->tbl;
        $sqlstr = "SELECT empl_id, acc_reg_date, acc_term FROM {$tbl} WHERE active_status=1";
        $rs     = $this->db->query($sqlstr);
        if (!$rs) {
            return false;
        }
        $res = $rs->result();
        if (!$res) {
            return false;
        }

        foreach ($res as $row) {
            $this->_set_acc($row->empl_id, $row->acc_reg_date, $row->acc_term);
        }
    }

    protected function _set_acc($empl_id, $acc_reg_date, $acc_term) {
        $tbl_payslip = $this->tbl_payslip;
        $sqlquery    = "UPDATE {$tbl_payslip} ";
        $sqlquery    .= " SET ";
        $sqlquery    .= " modified=NOW()";
        $sqlquery    .= ", empl_wb=1";
        $sqlquery    .= " WHERE empl_id='{$empl_id}'";
        $sqlquery    .= " AND `lock`= 0";
        $sqlquery    .= " AND `print_dt` >= '{$acc_reg_date}'";
        if ($acc_term) {
            $sqlquery .= " AND `print_dt` <= '{$acc_term}'";
        }
        $this->db->query($sqlquery);
    }

    protected function _unset_acc($empl_id, $acc_reg_date, $acc_term) {
        $tbl_payslip = $this->tbl_payslip;
        $sqlquery    = "UPDATE {$tbl_payslip} ";
        $sqlquery    .= " SET ";
        $sqlquery    .= " modified=NOW()";
        $sqlquery    .= ", empl_wb=0";
        $sqlquery    .= ", ddc_wb=NULL";
        $sqlquery    .= " WHERE empl_id='{$empl_id}'";
        $sqlquery    .= " AND `lock`= 0";
        $sqlquery    .= " AND `print_dt` >= '{$acc_reg_date}'";
        if ($acc_term) {
            $sqlquery .= " AND `print_dt` <= '{$acc_term}'";
        }
        $this->db->query($sqlquery);
    }

    public function fetch_total_rows_unsigned() {
//        $this->db  = $this->load->database('default', true);
        $this->db->from($this->tbl_r_pegawai);
        if ($this->rs_joins_unsigned) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if ($this->rs_index_where_unsigned) {
            $this->db->where($this->rs_index_where_unsigned, null, false);
        }
        $this->filter_result($this->db);
        if (method_exists($this, 'custom_filter_result')) {
            $this->custom_filter_result($this->db);
        }
        $res = $this->db->count_all_results();
        return $res;
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

    public function fetch_detail_unsigned($empl_id, $use_filter = true) {
        $this->db->from($this->tbl_r_pegawai);

//        if (property_exists($this, 'rs_select')) {
//            $this->db->select($this->rs_select, false);
//        }
        $this->db->where('id_pegawai', $empl_id);
        if ($use_filter) {
            $this->db->where('id_pegawai NOT IN (SELECT `empl_id` FROM `apr_empl_wb` WHERE `active_status`=1) ', null, false);
        }
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function add_new_acc($empl_id, $acc_id, $acc_reg_date, $acc_term) {
        $detail = $this->fetch_detail_unsigned($empl_id);
        if (!$detail) {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $this->db->trans_begin();
        $this->db->set('empl_id', $empl_id);
        $this->db->set('name', $detail->nama_pegawai);
        $this->db->set('nipp', $detail->nip_baru);
        $this->db->set('acc_id', $acc_id);
        $this->db->set('acc_reg_date', $acc_reg_date);
        if (!$acc_term) {
            $acc_term = null;
        }
        $this->db->set('acc_term', $acc_term);
        $this->db->set('created', $now);
        $this->db->set('active_status', 1);
        $this->db->insert($this->tbl);
        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            return false;
        }
        $id = $this->db->insert_id();
        $this->_set_acc($empl_id, $acc_reg_date, $acc_term);
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
                $this->_unset_acc($detail->empl_id, $detail->acc_reg_date, $detail->acc_term);
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

        $sqlstr1 = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp_wb";
        $sqlstr1 .= " SELECT empl_id FROM {$tbl} WHERE active_status=1";
        //
        $sqlstr2 = "INSERT INTO {$tbl} (empl_id, nipp, acc_id, acc_reg_date,`name`, active_status, `created`) ";
        $sqlstr2 .= " SELECT id_pegawai empl_id, nip_baru nipp, nip_baru acc_id, tgl_terima acc_reg_date, nama_pegawai `name`, 1 active_status, NOW() `created`";
        $sqlstr2 .= " FROM {$tbl_rpeg} ";
        $sqlstr2 .= " WHERE id_pegawai NOT IN (";
        $sqlstr2 .= " SELECT empl_id FROM tmp_wb";
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

    public function fetch_all_empl_id() {
        $this->db->from($this->tbl_r_pegawai);
        $select = $this->tbl_r_pegawai . '.id_pegawai';
        $select .= ', ' . $this->tbl_r_pegawai . '.nip_baru';
        $select .= ', ' . $this->tbl . '.acc_id';
        $select .= ', ' . $this->tbl_r_pegawai . '.nama_pegawai';
        $select .= ', ' . $this->tbl . '.acc_reg_date';
        $select .= ', ' . $this->tbl . '.acc_term';
        $this->db->select($select);
        $joins  = array(
            $this->tbl,
            $this->tbl . '.empl_id=' . $this->tbl_r_pegawai . '.id_pegawai AND ' . $this->tbl . '.active_status=1',
            'left'
        );
        $this->db->join($joins[0], $joins[1], $joins[2]);

        $this->db->order_by($this->tbl_r_pegawai . '.nip_baru + 0');
        $this->db->order_by($this->tbl_r_pegawai . '.nama_pegawai');
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function fetch_data_unsigned($cur_page = 1, $per_page = 10, $order_by = null, $sort_order = null) {

        $suffix = '_unsigned';
        if ($this->rs_reset_cur_page) {
            $cur_page = 1;
        }
        $this->db->from($this->tbl_r_pegawai);
        $var = 'rs_joins' . $suffix;
        if ($this->{$var}) {
            foreach ($this->{$var} as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        $var = 'rs_select' . $suffix;
        if (property_exists($this, $var)) {
            $this->db->select($this->{$var}, false);
        }
        $var = 'rs_index_where' . $suffix;
        if ($this->{$var}) {
            $this->db->where($this->{$var}, null, false);
        }
        $this->filter_result($this->db);

        if (method_exists($this, 'custom_filter_result')) {
            $this->custom_filter_result($this->db);
        }
        if ($order_by) {
            $var      = 'rs_field_list' . $suffix;
            $order_by = isset($this->{$var}[$order_by]) ? $order_by : null;
        }
        if ($order_by) {
            $sort_order   = $sort_order ? $sort_order : 'asc';
            $order_by_col = $this->{$var}[$order_by];
            $var2         = 'rs_sort_natural' . $suffix;
            if (in_array($this->{$var}[$order_by], $this->{$var2})) {
                $order_by_col = $this->{$var}[$order_by] . '+0';
            }
            $this->db->order_by($order_by_col, $sort_order, false);
            $this->rs_sort_order = $sort_order;
            $this->rs_order_by   = $order_by;
        }
        $offset = $cur_page - 1;

        if ($offset < 0)
            $offset            = 0;
        if ($offset >= 1)
            $offset            = ($offset * $per_page);
//        debug($offset);die();
        $this->rs_per_page = $per_page;
        $this->rs_offset   = $offset + 1;
        $this->db->limit($per_page, $offset);
        $rs                = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function get_rs_action() {

        $r_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $dl_title .= lang('Download Account');


        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $im_title .= lang('Account Import');
        $action   = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    'a'  => array(
                        'url'  => sprintf($r_url, md5('new' . date('ymd'))),
                        'text' => '<span class="fa fa-plus  "></span> ' . lang('Add new'),
//                        'a_class' => 'btn btn-sm btn-primary',
                    ),
//                    'b' => array(
//                        'url'     => sprintf($r_url, md5('batch-assignment' . date('ymd'))),
//                        'text'    => '<span class="fa fa-plus-square "></span> ' . lang('Sign all !'),
//                        'a_class' => 'btn-warning',
//                    ),
                    'dl' => array(
                        'url'     => sprintf($r_url, md5('dl-acc-tpl' . date('ymd'))),
                        'text'    => $dl_title,
                        'a_class' => 'btn-info',
                    ),
                    'im' => array(
                        'url'     => sprintf($r_url, md5('import' . date('ymd'))),
                        'text'    => $im_title,
                        'a_class' => 'btn-success'
                    )
                ),
                'action_list' => array(
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-edit text-warning"></span>',
                    ),
                    'd' => array(
                        'url'  => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text' => '<span class="fa fa-trash text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function get_rs_action_unsigned($back_url) {

        $r_url = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');

        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id_pegawai',
                'action_top'  => array(
                    'back' => array(
                        'url'  => $back_url,
                        'text' => '<span class="fa fa-arrow-left fa-border"></span> ' . lang('back'),
                    ),
                ),
                'action_list' => array(
                    'a' => array(
                        'url'  => sprintf($r_url, md5('add_new_form' . date('ymd')) . '/%s'),
                        'text' => '<span class="fa fa-plus fa-border text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function get_pagination_config_unsigned() {

        $config = array();
        if (!property_exists($this, 'rs_base_url_unsigned')) {
            $this->rs_base_url_unsigned = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('new' . date('ymd')) . '/';
        }
        $config['suffix']   = '/' . $this->rs_per_page;
        $config['base_url'] = $this->rs_base_url_unsigned;
        if ($this->rs_order_by) {
            $config['suffix'] .= '/' . $this->rs_order_by;
            if ($this->rs_sort_order) {
                $config['suffix'] .= '/' . $this->rs_sort_order;
            }
        }
        $config['uri_segment'] = 5; // $this->rs_uri_segment;
        if (property_exists($this, 'rs_uri_segment_unsigned')) {
            $config['uri_segment'] = $this->rs_uri_segment_unsigned;
        }


        $config['per_page']         = $this->rs_per_page;
        $config['num_links']        = $this->rs_num_links;
        $config['use_page_numbers'] = true;

        $config['full_tag_open']  = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link']      = '<span class="fa fa-angle-double-left"></span>';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link']      = '<span class="fa fa-angle-double-right"></span>';
        $config['last_tag_open']  = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link']      = '<span class="fa fa-angle-right"></span>';
        $config['next_tag_open']  = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link']      = '<span class="fa fa-angle-left"></span>';
        $config['prev_tag_open']  = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open']  = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

    public function update_acc($edit_id, $acc_id, $acc_reg_date, $acc_term) {

        $now        = date('Y-m-d H:i:s');
        $old_detail = $this->fetch_detail($edit_id);
        if (!$old_detail) {
            return false;
        }
        $this->db->trans_begin();
        $this->_unset_acc($old_detail->empl_id, $old_detail->acc_reg_date, $old_detail->acc_term);
        $this->db->set('acc_id', $acc_id);
        $this->db->set('acc_reg_date', $acc_reg_date);
        if (!$acc_term) {
            $acc_term = null;
        }
        $this->db->set('acc_term', $acc_term);
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
            $this->_set_acc($old_detail->empl_id, $acc_reg_date, $acc_term);
            $this->_update_payslip();
            return $id;
        }
        return $this->db->affected_rows();
    }

    public function update_batch_acc($input) {
        $list    = array(
            'id_pegawai',
            'nip_baru',
            'acc_id',
            'nama_pegawai',
            'acc_reg_date',
            'acc_term',
        );
        $this->db->trans_begin();
        $tbl     = $this->tbl;
        $sql_str = "TRUNCATE TABLE `{$tbl}`";
        $this->db->query($sql_str);

        $tbl     = $this->tbl_payslip;
        $sql_str = "UPDATE `{$tbl}` SET `empl_wb`=NULL, `ddc_wb`=NULL WHERE `lock`= 0";
        $this->db->query($sql_str);

        $now    = date('Y-m-d H:i:s');
        $common = array(
            'active_status' => 1,
            'acc_status'    => 1,
            'created'       => $now,
        );

        $data = array();
        $ls   = array();
        foreach ($input as $md5 => $i) {
            foreach ($i as $n => $val) {
                $ls[$n][$md5] = $val;
            }
        }

        foreach ($ls as $n => $i) {
            $data[$n]                 = $common;
            $data[$n]['empl_id']      = $i[md5('id_pegawai')];
            $data[$n]['nipp']         = $i[md5('nip_baru')];
            $data[$n]['acc_id']       = $i[md5('acc_id')];
            $data[$n]['acc_reg_date'] = $i[md5('acc_reg_date')];
            if (!$i[md5('acc_term')]) {
                $i[md5('acc_term')] = null;
            }
            $data[$n]['acc_term'] = $i[md5('acc_term')];
            $data[$n]['name']     = $i[md5('nama_pegawai')];
        }

        $this->db->insert_batch($this->tbl, $data);
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
        $this->_set_all_acc();
        $this->_update_payslip();
        return $affected;
    }

}
