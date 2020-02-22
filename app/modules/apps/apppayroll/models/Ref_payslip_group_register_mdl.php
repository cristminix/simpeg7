<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Ref_Payslip_Group_Register_Mdl extends Apppayroll_Frontmdl {

    public $tbl            = 'apr_payslip_group_register';
    public $rs_index_where = 'active_status=1';
    public $rs_main_data   = null;
    public $rs_uri_segment = 7;
    public $rs_per_page    = 1000;

    public function add_new_payslip_group_register($apr_payslip_group_id, $name, $start_date, $term_date) {
        $this->db->set('apr_payslip_group_id', $apr_payslip_group_id);
        $this->db->set('name', $name);
        $this->db->set('start_date', $start_date);
        if ($term_date) {
            $this->db->set('term_date', $term_date);
        }
        $this->db->set('active_status', 1);
        $now = date('Y-m-d H:i:s');
        $this->db->set('created', $now);
        $this->db->set('modified', $now);
        $this->db->insert($this->tbl);
        $aff = $this->db->affected_rows();
        if (!$aff) {
            return $aff;
        }
        return $this->db->insert_id();
    }

    public function delete_row_by_id($id) {
        $this->db->where('id', $id);
        $this->db->set('active_status', 0);
        $this->db->update($this->tbl);
        if ($this->db->affected_rows()) {
            return array('success' => lang('Delete success'));
        }
        return array('error' => lang('Delete has failed'));
    }

    public function fetch_data_by_alw_id($alw_id) {
        $this->db->where('apr_allowance_id', $alw_id);
        $this->db->where('active_status', 1);
        $this->db->order_by('effective_date');
        $rs = $this->db->get($this->tbl);
        return $rs->result();
    }

    public function fetch_detail($id) {
        $this->db->from($this->tbl);

        $this->db->where('id', $id);
        $this->db->where($this->rs_index_where, null, false);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function is_duplicated($apr_payslip_group_id, $name, $not_id = null) {
        $this->db->where('apr_payslip_group_id', $apr_payslip_group_id);
        $this->db->where('name', $name);
        $this->db->where('active_status', 1);
        $this->db->select('COUNT(id) cgp', false);
        if ($not_id) {
            $this->db->not_like('id', $not_id, 'none');
        }
        $rs     = $this->db->get($this->tbl);
        $result = false;
        if (!$rs) {
            return $result;
        }
        $res = $rs->row();
        if (!$res) {
            return $result;
        }
        $result = (bool) $res->cgp;
        return $result;
    }

    public function set_rs_attr($detail_id) {
        $this->rs_field_list                       = array(
            '1' => 'name',
            'start_date',
            'term_date',
        );
        $this->rs_masked_field_list                = array(
            '1' => 'ID',
            'Since',
            'Until',
            'Unit',
        );
        $this->rs_common_views['field_no_sorting'] = array(
        );
    }

    public function get_rs_action($detail_id, $back_url) {
        $r_url  = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $detail_id . '/%s');
        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    'back' => array(
                        'url'  => $back_url,
                        'text' => '<span class="fa fa-arrow-left fa-border"></span> ' . lang('back'),
                    ),
                    'a'    => array(
                        'url'  => sprintf($r_url, md5('new' . date('ymd'))),
                        'text' => '<span class="fa fa-plus fa-border fa-fw"></span> ' . lang('Add new'),
                    ),
//                    'update' => array(
//                        'url'  => sprintf($r_url . '/%s', md5('update' . date('ymd')), $detail_id),
//                        'text' => '<span class="fa fa-upload fa-border fa-fw"></span> ' . lang('Update Payslip') . ' (' . $this->rs_allowance_data->payslip_update_dt . ')',
//                    )
                ),
                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-edit fa-border fa-fw"></span>',
                    ),
                    'm' => array(
                        'url'  => sprintf($r_url, md5('mapping' . date('ymd')) . '/%s'),
                        'text' => '<span class="fa fa-cog fa-border fa-fw"></span>',
                    ),
                    'd' => array(
                        'url'  => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text' => '<span class="fa fa-trash fa-border fa-fw text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function update_payslip_group_register($id, $apr_payslip_group_id, $name, $start_date, $term_date) {
        $this->db->set('apr_payslip_group_id', $apr_payslip_group_id);
        $this->db->set('name', $name);
        $this->db->set('start_date', $start_date);
        if ($term_date) {
            $this->db->set('term_date', $term_date);
        } else {
            $this->db->set('term_date', NULL);
        }
        $this->db->set('active_status', 1);
        $now = date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        $this->db->where('id', $id);
        $this->db->update($this->tbl);
        $aff = $this->db->affected_rows();
        if (!$aff) {
            return $aff;
        }
        return $id;
    }

}
