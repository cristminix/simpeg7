<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$dir = realpath(dirname(dirname(__FILE__)));
require_once $dir . '/apppayroll_frontmdl' . EXT;

class Ddc_Bpjs_Kes extends Apppayroll_Frontmdl {

    public $tbl         = 'apr_deduction_var';
    public $payslip_tbl = 'apr_sv_payslip';
    public $ddc_mdl;
    public $ddc_var_mdl;

    public function get_bpjs_kes_knt() {
        $res = array();
        // return $res;
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
            $res[$row->id] = $this->update_payslip_kontrak($row->effective_date, $row->value);
        }
        return $res;
    }
    public function get_bpjs_kes_peg() {
        $res = array();
        // return $res;
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

        // echo "ddc<br/>\n";
        // die();

        $this->db->set('ddc_bpjs_kes',$val);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0 ";
        $where .= "AND (empl_stat = 'Capeg' OR  empl_stat = 'Tetap' OR job_unit = 'Direksi') AND `empl_gr` <> 'Dewan Pegawas'";
        
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
        
    }
    public function update_payslip_kontrak($eff_date, $val) {
        $value="IFNULL(gross_sal, 0) * 0.01";
        // $value = " (base_sal+alw_amt) * {$val}";
        $this->db->set('ddc_bpjs_kes',$value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0 ";
        $where .= " AND empl_stat = 'Kontrak' ";        
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
        
    }
    
} 
