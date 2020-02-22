<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Attn_Fp_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst              = 'payslip_mdl';
    public $tbl                           = 'apr_adm_fp';
    public $tbl_payslip                   = 'apr_sv_payslip';
    public $tbl_r_pegawai                 = 'r_pegawai';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list                 = array(
        '1' => 'nipp',
        'empl_id',
        'fpid',
        'name',
        'reg_date',
        'text',
    );
    
    public $rs_masked_field_list          = array(
        '1' => 'NIPP',
        'Empl ID',
        'FP ID',
        'Name',
        'Registered',
        'Notes',
    );
    
    public $rs_use_form_filter            = 'apr_adm_fp';
    public $rs_select                     = "*";
    public $rs_order_by                   = null;
    public $rs_common_views               = array(
    );
    public $rs_index_where                = " active_status=1";
    
    protected function _init_fp($empl_id, $nipp, $name, $now) {
        $this->db->set('empl_id', $empl_id);
        $this->db->set('nipp', $nipp);
        $this->db->set('name', $name);
        $this->db->set('active_status', 1);
        $this->db->set('created', $now);
        $this->db->insert($this->tbl);
    }

    public function fetch_ids_fpid($empls_id) {
        $this->db->from($this->tbl);
        $this->db->select('id, empl_id');
        $this->db->where('active_status', 1);
        $this->db->where_in('empl_id', $empls_id);
        $rs = $this->db->get();

        if (!$rs) {
            return array();
        }
        $res = $rs->result();
        if (!$res) {
            return array();
        }
        $ids = array();
        foreach ($res as $row) {
            $ids[$row->empl_id] = $row->id;
        }
        return $ids;
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

    public function delete_row_by_id($id) {
        $detail = $this->fetch_detail($id);

        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->set('fpid', NULL);
        $this->db->set('reg_date', NULL);
        $this->db->set('text', NULL);
        $this->db->update($this->tbl);

        if ($this->db->affected_rows()) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                return array('error' => lang('Delete has failed'));
            } else {
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

        $sqlstr1 = "CREATE TEMPORARY TABLE IF NOT EXISTS tmp_fc";
        $sqlstr1 .= " SELECT empl_id FROM {$tbl} WHERE active_status=1";
        //
        $sqlstr2 = "INSERT INTO {$tbl} (empl_id, nipp, reg_date,`name`, active_status, `created`) ";
        $sqlstr2 .= " SELECT id_pegawai empl_id, nip_baru nipp, tgl_terima reg_date, nama_pegawai `name`, 1 active_status, NOW() `created`";
        $sqlstr2 .= " FROM {$tbl_rpeg} ";
        $sqlstr2 .= " WHERE id_pegawai NOT IN (";
        $sqlstr2 .= " SELECT empl_id FROM tmp_fc";
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

    public function fetch_all_fpid() {
        $this->db->from($this->tbl);

        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        if ($this->rs_index_where) {
            $this->db->where($this->rs_index_where, null, false);
        }

        $this->db->order_by('apr_adm_fp.nipp + 0');
        $this->db->order_by('apr_adm_fp.name');
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function get_rs_action() {

        $r_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $dl_title .= lang('Download FP ID');

        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $im_title .= lang('Import FP ID');

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

                    'dl' => array(
                        'url'     => sprintf($r_url, md5('dl-fp-tpl' . date('ymd'))),
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
                        'url'           => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text'          => '<span class="fa fa-eraser text-warning"></span>',
                        'show_by_field' => 'fpid',
                    ),
                ),
            )
        );
        return $action;
    }

    public function init_fp() {
        $tbl      = $this->tbl_r_pegawai;
        $tbl_fp = $this->tbl;
        $sqlstr   = "SELECT id_pegawai,nip_baru,nama_pegawai, tgl_terima FROM {$tbl} WHERE ";
        $sqlstr   .= " id_pegawai NOT IN (SELECT empl_id FROM {$tbl_fp} WHERE active_status=1)";
        $rs       = $this->db->query($sqlstr);
        if (!$rs) {
            return false;
        }
        $res = $rs->result();
        if (!$res) {
            return false;
        }
//        debug($res);die();

        $now  = date('Y-m-d H:i:s');
        $data = array();


        foreach ($res as $row) {
            $data[] = array(
                'empl_id'       => $row->id_pegawai,
                'nipp'          => $row->nip_baru,
                'name'          => $row->nama_pegawai,
                'reg_date'          => $row->tgl_terima,
                'active_status' => 1,
                'created'       => $now,
            );
        }
        $this->db->insert_batch($tbl_fp, $data);
    }

    public function is_unique_fpid($id, $npwp) {
        $this->db->from($this->tbl);
        $this->db->where('id !=', $id);
        $this->db->where('fpid', $npwp);
        $res = $this->db->get()->result();
        if ($res) {
            return false;
        }
        return true;
    }

    public function update_batch($data, $key) {
        $this->db->trans_begin();
        $now     = date('Y-m-d H:i:s');
        $tbl     = $this->tbl;
        $sql_str = "UPDATE `{$tbl}` SET `fpid`=NULL, `modified`='{$now}'";
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
        
        return $affected;
    }

    public function update_fpid($edit_id, $fpid, $text) {

        $now        = date('Y-m-d H:i:s');
        $old_detail = $this->fetch_detail($edit_id);
        if (!$old_detail) {
            return false;
        }
        $this->db->trans_begin();

        $this->db->set('fpid', $fpid);
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
            return $affected;
        }
        return $this->db->affected_rows();
    }

}
