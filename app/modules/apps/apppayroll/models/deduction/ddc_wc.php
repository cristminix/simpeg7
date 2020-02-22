<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$dir = realpath(dirname(dirname(__FILE__)));
require_once $dir . '/apppayroll_frontmdl' . EXT;

class Ddc_Wc extends Apppayroll_Frontmdl {

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

    public function get_ddc_wc_od() {
        $res = array();
        $ls  = $this->get_ddc();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_wc_od($row->effective_date, $row->value);
        }
        return $res;
    }

    
    public function update_payslip_wc_od($eff_date, $val) {
        $this->db->set('ddc_wc', $val, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND empl_wc=1 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

}
