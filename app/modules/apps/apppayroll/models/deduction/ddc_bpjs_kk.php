<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$dir = realpath(dirname(dirname(__FILE__)));
require_once $dir . '/apppayroll_frontmdl' . EXT;

class Ddc_Bpjs_Kk extends Apppayroll_Frontmdl {

    public $tbl         = 'apr_deduction_var';
    public $payslip_tbl = 'apr_sv_payslip';
    public $ddc_mdl;
    public $ddc_var_mdl;

    public function get_bpjs_kk() {
        $res = array();
        return $res;
        $rs_deduction_data = $this->ddc_var_mdl->rs_deduction_data;
        
        if(!$rs_deduction_data){
            return $res;
        }
        $this->ddc_var_mdl->rs_index_where .= " AND apr_deduction_id LIKE '".$rs_deduction_data->id."'";
        $ls = $this->ddc_var_mdl->fetch_data();
         if(!$ls){
            return $res;
        }
        
        foreach($ls as $row){

            $res[$row->id] = $this->update_payslip($row->effective_date, $row->value);
        }
        return $res;
    }

    public function update_payslip($eff_date, $val) {
        $value = "((IFNULL(alw_pph21, 0)+IFNULL(gross_sal, 0))-IFNULL(alw_vhc_rt, 0)) * 0.02";
        $this->db->set('ddc_bpjs_ket',$value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
        
    }
    
} 
