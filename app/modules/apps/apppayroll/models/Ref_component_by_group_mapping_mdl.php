<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Ref_Component_By_Group_Mapping_Mdl extends Apppayroll_Frontmdl {

    public $tbl              = 'apr_payslip_group_component';
    public $tbl_ps_component = 'apr_payslip_component';
    public $rs_index_where   = 'active_status=1';
    public $rs_detail_data   = null;
    public $rs_select        = "*";
    public $rs_uri_segment   = 7;
    public $rs_per_page      = 1000;

    protected function _get_mapped_by_group($group_id) {
        $this->db->select('apr_payslip_component_id');
        $this->db->where('apr_payslip_group_register_id', $group_id);
//        $this->db->where('active_status', 1);
        $rs  = $this->db->get($this->tbl)->result();
        $res = array();
        if (!$rs) {
            return $res;
        }

        foreach ($rs as $row) {
            $res[] = $row->apr_payslip_component_id;
        }
        return $res;
    }

    protected function _insert_batch_by_group($insert, $group_id) {
        $now    = date('Y-m-d H:i:s', time());
        $common = array(
            'apr_payslip_group_register_id' => $group_id,
            'active_status'                 => 1,
            'created'                       => $now,
        );
        $data   = array();

        foreach ($insert as $n => $component_id) {
            $data[$n]                             = $common;
            $data[$n]['apr_payslip_component_id'] = $component_id;
        }
        $this->db->insert_batch($this->tbl, $data);
        return $this->db->affected_rows();
    }

    protected function _update_batch_by_group($update, $group_id) {
        if(!$update){
            return 0;
        }
        $now    = date('Y-m-d H:i:s', time());
        $common = array(
            'active_status' => 1,
            'modified'      => $now,
        );
        $data   = array();

        foreach ($update as $n => $component_id) {
            $data[$n]                             = $common;
            $data[$n]['apr_payslip_component_id'] = $component_id;
        }
        $this->db->where( 'apr_payslip_group_register_id', $group_id);
        $this->db->update_batch($this->tbl, $data, 'apr_payslip_component_id');
        return $this->db->affected_rows();
    }
    protected function _drop_batch_by_group($drop, $group_id) {
        if(!$drop){
            return 0;
        }
        $now    = date('Y-m-d H:i:s', time());
        $common = array(
            'active_status' => 0,
            'modified'      => $now,
        );
        $data   = array();

        foreach ($drop as $n => $component_id) {
            $data[$n]                             = $common;
            $data[$n]['apr_payslip_component_id'] = $component_id;
        }
        $this->db->where( 'apr_payslip_group_register_id', $group_id);
        $this->db->update_batch($this->tbl, $data, 'apr_payslip_component_id');
        return $this->db->affected_rows();
    }

    public function add_new_group_detail($field_name, $name, $operator_val, $value, $apr_payslip_group_id) {
        $this->db->set('field_name', $field_name);
        $this->db->set('name', $name);
        $this->db->set('operator', $operator_val);
        if ($value == 'NULL') {
            $value = null;
        }
        $this->db->set('value', $value);
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

    public function fetch_data_index() {
//        $this->db->where('apr_allowance_id', $alw_id);
        $this->db->where('active_status', 1);
//        $this->db->order_by('effective_date');
        $rs = $this->db->get($this->tbl_ps_component);
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
            '1' => 'name',
            'text',
            'menu_code',
            'annotation',
        );
        $this->rs_masked_field_list                = array(
            '1' => 'ID',
            'Name',
            'Category',
            'Notes',
        );
        $this->rs_common_views['field_no_sorting'] = array(
            'name',
            'text',
            'menu_code',
            'annotation',
        );
    }

    public function get_rs_field_ls($idx = null) {
        $ls = array(
            'empl_stat' => 'Employement Status',
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

    public function get_data_checked($reg_id) {
//        $this->db->where('apr_allowance_id', $alw_id);
        $this->db->where('apr_payslip_group_register_id', $reg_id);
        $this->db->where('active_status', 1);
//        $this->db->order_by('effective_date');
        $rs  = $this->db->get($this->tbl);
        $res = $rs->result();
        if (!$res) {
            return $res;
        }
        $result = array();
        foreach ($res as $row) {
            $result[$row->apr_payslip_component_id] = $row->apr_payslip_component_id;
        }
        return $result;
    }

    public function get_rs_action($detail_id, $back_url) {
        $r_url  = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/' . md5('detail' . date('ymd')) . '/' . $detail_id . '/%s');
        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'   => 'id',
                'action_top' => array(
                    'back' => array(
                        'url'  => $back_url,
                        'text' => '<span class="fa fa-arrow-left"></span> ' . lang('back'),
                    ),
//                    'a'    => array(
//                        'url'  => sprintf($r_url, md5('new' . date('ymd'))),
//                        'text' => '<span class="fa fa-plus fa-fw"></span> ' . lang('Add new'),
//                    ),
                ),
//                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
//                    'e' => array(
//                        'url'  => $r_url,
//                        'text' => '<span class="fa fa-check fa-border fa-fw"></span>',
//                    ),
//                    'd' => array(
//                        'url'  => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
//                        'text' => '<span class="fa fa-trash fa-border fa-fw text-warning"></span>',
//                    ),
//                ),
            )
        );
        return $action;
    }

    public function set_joins() {
        
    }

    public function update_mapping_by_group($input, $group_id) {
        $res           = new stdClass();
        $res->inserted = 0;
        $res->updated  = 0;
        $res->dropped  = 0;
        $mapped        = $this->_get_mapped_by_group($group_id);
        
        $insert        = $input;
        if ($mapped) {
            $update = array_intersect($mapped, $input);
            $drop   = array_diff($mapped, $input);
            $insert = array_diff($input, $mapped);
            
        }
        if ($insert) {
            $res->inserted = $this->_insert_batch_by_group($insert, $group_id);
            
        }
        if (isset($update)) {
            $res->updated = $this->_update_batch_by_group($update, $group_id);
        }
        if (isset($drop)) {
            
            $res->dropped = $this->_drop_batch_by_group($drop, $group_id);
        }
        return $res;
    }

//    public function update_allowance_var($id, $effective_date, $variable_name, $value, $unit) {
//        $this->db->set('effective_date', $effective_date);
//        $this->db->set('variable_name', $variable_name);
//        $this->db->set('value', $value);
//        $this->db->set('unit', $unit);
//        $now = date('Y-m-d H:i:s');
//        $this->db->set('modified', $now);
//        $this->db->where('id', $id);
//        $this->db->update($this->tbl);
//        $aff = $this->db->affected_rows();
//        if (!$aff) {
//            return $aff;
//        }
//        return $id;
//    }
}
