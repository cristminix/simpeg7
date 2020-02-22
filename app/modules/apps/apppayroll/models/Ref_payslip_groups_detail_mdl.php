<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Ref_Payslip_Groups_Detail_Mdl extends Apppayroll_Frontmdl {

    public $tbl             = 'apr_payslip_group_detail';
    public $rs_index_where  = 'active_status=1';
    public $rs_detail_data  = null;
    public $rs_select       = "*, IFNULL(`value`, 'NULL') `value`";
    public $rs_uri_segment  = 7;
    public $rs_per_page     = 1000;
    public $rs_common_views = array(
        'date_field_list' => array(
            'eff_date'  => 'd/m/Y',
            'term_date' => 'd/m/Y',
        )
    );

    public function add_new_group_detail($field_name, $name, $operator_val, $value, $apr_payslip_group_id, $eff_date, $term_date) {
        $this->db->set('field_name', $field_name);
        $this->db->set('name', $name);
        $this->db->set('operator', $operator_val);
        if ($value == 'NULL') {
            $value = null;
        }
        $this->db->set('value', $value);
        if (!$term_date) {
            $term_date = null;
        }
        $this->db->set('term_date', $term_date);
        $this->db->set('eff_date', $eff_date);
        $this->db->set('apr_payslip_group_id', $apr_payslip_group_id);
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

    public function set_rs_attr($detail_id) {
        $this->rs_field_list                       = array(
            '1' => 'eff_date',
            'term_date',
            'field_name',
            'name',
            'operator',
            'value',
        );
        $this->rs_masked_field_list                = array(
            '1' => 'Since',
            'Until',
            'Fieldname',
            'Name',
            'Operator',
            'Value',
        );
        $this->rs_common_views['field_no_sorting'] = array(
            'eff_date',
            'term_date',
            'field_name',
            'name',
            'operator',
            'value',
        );
    }

    public function get_rs_field_ls($idx = null) {
        $ls = array(
            'empl_stat' => 'Employement Status',
            'job_unit'  => 'Job Unit',
            'job_title' => 'Job Title',
            'grade'     => 'Grade',
        );
        if (!$idx) {
            return $ls;
        }
        return $ls[$idx];
    }

    public function get_rs_operator($idx = null) {
        $ls = array(
            '1' => '=',
            '!=',
        );
        if (!$idx) {
            return $ls;
        }
        return $ls[$idx];
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
                        'text' => '<span class="fa fa-arrow-left"></span> ' . lang('back'),
                    ),
                    'a'    => array(
                        'url'  => sprintf($r_url, md5('new' . date('ymd'))),
                        'text' => '<span class="fa fa-plus fa-fw"></span> ' . lang('Add new'),
                    ),
//                    'update' => array(
//                        'url'  => sprintf($r_url . '/%s', md5('update' . date('ymd')), $detail_id),
//                        'text' => '<span class="fa fa-upload fa-fw"></span> ' . lang('Update Payslip') . ' (' . $this->rs_allowance_data->payslip_update_dt . ')',
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
                    'd' => array(
                        'url'  => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text' => '<span class="fa fa-trash fa-border fa-fw text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function update_group_detail($id, $field_name, $name, $operator_val, $value, $eff_date, $term_date) {

        $this->db->set('field_name', $field_name);
        $this->db->set('name', $name);
        $this->db->set('operator', $operator_val);
        if ($value == 'NULL' || !$value) {
            $value = null;
        }
        $this->db->set('value', $value);
        if (!$term_date) {
            $term_date = null;
        }
        $this->db->set('term_date', $term_date);
        $this->db->set('eff_date', $eff_date);
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
