<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$dir = realpath(dirname(dirname(__FILE__)));
require_once $dir . '/apppayroll_frontmdl' . EXT;

class Ddc_Common extends Apppayroll_Frontmdl {

    public $tbl         = 'apr_deduction_var';
    public $payslip_tbl = 'apr_sv_payslip';
    public $ddc_mdl;
    public $ddc_var_mdl;
    public $rs_field_list;

    protected function get_ddc() {
        $res               = array();
        $rs_deduction_data = $this->ddc_var_mdl->rs_deduction_data;
        
        if (!$rs_deduction_data) {
            return $res;
        }
        $this->ddc_var_mdl->rs_index_where = " active_status=1 ";
        $this->ddc_var_mdl->rs_index_where .= " AND apr_deduction_id LIKE '" . $rs_deduction_data->id . "'";
        $ls                                = $this->ddc_var_mdl->fetch_data(1, 1000, 'effective_date');
        if (!$ls) {
            return $res;
        }
        return $ls;
    }

    public function get_ddc_aspen() {
        $res = array();
        return $res;
        $ls  = $this->get_ddc();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_aspen($row->effective_date, $row->value);
        }
        return $res;
    }

    public function get_ddc_fkp() {
        $res = array();
        $ls  = $this->get_ddc();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_fkp($row->effective_date, $row->value);
        }
        return $res;
    }
    
    public function get_ddc_zk() {
        $res = array();
        return $res;
        $ls  = $this->get_ddc();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_zk($row->effective_date, $row->value);
        }
        return $res;
    }
    
    public function update_payslip_aspen($eff_date, $val) {
        $value = " (IFNULL(`base_sal`,0)+IFNULL(`alw_mar`,0)+IFNULL(`alw_ch`+`alw_rs`,0)) * {$val} ";
        $this->db->set('ddc_aspen', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND child_cnt > 0 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    public function update_payslip_fkp($eff_date, $val) {
        $this->db->set('ddc_f_kp', $val, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND empl_fkp=1 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }
    
    public function update_payslip_zk($eff_date, $val) {
        $value = " (IFNULL(base_sal, 0) + IFNULL(alw_amt, 0)) * {$val} ";
        $this->db->set('ddc_zk', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND empl_zk=1 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }
}
