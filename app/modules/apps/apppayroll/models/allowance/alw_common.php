<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$dir = realpath(dirname(dirname(__FILE__)));
require_once $dir . '/apppayroll_frontmdl' . EXT;

class Alw_Common extends Apppayroll_Frontmdl {

    public $tbl         = 'apr_allowance_var';
    public $payslip_tbl = 'apr_sv_payslip';
    public $alw_mdl;
    public $alw_var_mdl;

    protected function get_alw() {
        $res               = array();
        $rs_allowance_data = $this->alw_var_mdl->rs_allowance_data;
        if (!$rs_allowance_data) {
            return $res;
        }
        $alw_id = $rs_allowance_data->id;

        $ls = $this->alw_var_mdl->fetch_data_by_alw_id($alw_id);
        if (!$ls) {
            return $res;
        }
        return $ls;
    }

    public function get_alw_child() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_ch($row->effective_date, $row->value);
        }
        return $res;
    }

    public function get_alw_fd() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_fd($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function get_alw_job() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_job($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function get_alw_mar() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_mar($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    /* Performance */

    public function get_alw_prf() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_prf($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function get_alw_rc() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_rc($row->effective_date, $row->value);
        }
        return $res;
    }

    public function get_alw_rs() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            // print_r($row);
            // die();
            $res[$row->id] = $this->update_payslip_rs($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function get_alw_sh() {
        $res = array();
        return $res;

        
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_sh($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    /* Transport */

    public function get_alw_tr() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }
        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_tr($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function get_alw_vhc_rt() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_vhc_rt($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function get_alw_wt() {
        $res = array();
        $ls  = $this->get_alw();
        if (!$ls) {
            return $res;
        }

        foreach ($ls as $row) {
            $res[$row->id] = $this->update_payslip_wt($row->effective_date, $row->value, $row->variable_name);
        }
        return $res;
    }

    public function update_payslip_ch($eff_date, $val) {
        $value = "`base_sal` * {$val} * IFNULL(child_cnt, 0)";
        $this->db->set('alw_ch', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas' AND empl_stat <> 'Kontrak'";
       // $where .= " AND child_cnt > 0 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    public function update_payslip_fd($eff_date, $val, $var) {
        $var   = (int) $var;
        $val   = (float) $val;
        $this->db->set('alw_fd_perday', $val, false);
//        $this->db->set('work_day', $var, false);
        $where = " print_dt >= '{$eff_date}' AND `lock`=0 AND `empl_gr` <> 'Dewan Pegawas'";
//        $where .= " AND attn_i <= 0 ";
//        $where .= " AND attn_a <= 0 ";
//        $where .= " AND attn_l <= 0 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    public function update_payslip_job($eff_date, $val, $var) {
        $this->db->set('alw_jt', $val, false);
        $alw_jt_tax = $val-500000;
        if($alw_jt_tax <= 0){
            $alw_jt_tax = 0;
        }
        $this->db->set('alw_jt_tax', $alw_jt_tax, false);
        
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND job_title = '{$var}' ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    public function update_payslip_mar($eff_date, $val, $var) {
        $value = " `base_sal` * {$val}";
        $this->db->set('alw_mar', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas' AND empl_stat <> 'Kontrak'";
        $where .= " AND mar_stat = '{$var}' ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    /* performance */

    public function update_payslip_prf($eff_date, $val, $var) {
        $var   = (int) $var;
        $val   = (float) $val;
        $value = " `base_sal` * '{$val}' ";
        $this->db->set('alw_prf_perday', $value, false);
//        $this->db->set('work_day', $var, false);
        $where = " print_dt >= '{$eff_date}' AND `lock`=0 ";
//        $where .= " AND attn_i <= 0 ";
//        $where .= " AND attn_a <= 0 ";
//        $where .= " AND attn_l <= 0 ";
        $this->db->where($where, null, false)->where("empl_stat <> 'Kontrak'  AND `empl_gr` <> 'Dewan Pegawas'  AND empl_stat='Tetap'");
        $this->db->update($this->payslip_tbl);
        
        $affected_rows  += $this->db->affected_rows();

        $value = " `base_sal_tmp` * '{$val}' * 0.8";
        $this->db->set('alw_prf_perday', $value, false);
//        $this->db->set('work_day', $var, false);
        $where = " print_dt >= '{$eff_date}' AND `lock`=0 ";
//        $where .= " AND attn_i <= 0 ";
//        $where .= " AND attn_a <= 0 ";
//        $where .= " AND attn_l <= 0 ";
        $this->db->where($where, null, false)->where("empl_stat <> 'Kontrak'  AND `empl_gr` <> 'Dewan Pegawas' AND empl_stat='Capeg'");
        $this->db->update($this->payslip_tbl);
        $affected_rows  += $this->db->affected_rows();

            // echo "Alw_Common\n;";


        return $affected_rows;
    }

    public function update_payslip_rc($eff_date, $val, $var=null) {
        // $value = "(CASE WHEN empl_stat != 'Kontrak' THEN ( ( 1+ IFNULL( alw_rc_sp_cnt, 0 ) + IFNULL( alw_rc_ch_cnt, 0 ) ) * '{$val}' ) ELSE 0 END )";
        $value = "((1+ IFNULL(alw_rc_sp_cnt,0) + IFNULL(alw_rc_ch_cnt,0)) * '{$val}') ";

        $this->db->set('alw_rc', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND empl_stat = 'Tetap'";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);

        // echo $this->db->last_query() . "\n";

        $affected_rows = $this->db->affected_rows();

        $value = "((1+ IFNULL(alw_rc_sp_cnt,0) + IFNULL(alw_rc_ch_cnt,0)) * '{$val}') * 0.8 ";

        $this->db->set('alw_rc', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND empl_stat = 'Capeg'";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);

        // echo $this->db->last_query() . "\n";

        $affected_rows += $this->db->affected_rows();

        return $affected_rows;
    }

    public function update_payslip_rs($eff_date, $val, $var) {
        // $val = "(CASE WHEN `empl_stat` = 'Capeg' THEN (0.8 * '{$val}') ELSE '{$val}' END)";
        $this->db->set('alw_rs', $val, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND  (empl_stat = 'Tetap' )";
        $where .= " AND job_title = '{$var}' ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);

        $affected_rows = $this->db->affected_rows();
        // echo $this->db->last_query() . ";\n";

        $value = ($val * 0.8);
        $this->db->set('alw_rs', $value, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_stat` = 'Capeg'";
        $where .= " AND job_title = '{$var}' ";

        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        // echo $this->db->last_query() . ";\n";
        $affected_rows += $this->db->affected_rows();
        return $affected_rows;
    }

    public function update_payslip_sh($eff_date, $val, $var) {
        $this->db->set('alw_sh', $val, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND job_title = '{$var}' ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    /* transportation */

    public function update_payslip_tr($eff_date, $val, $var) {
        $var   = (int) $var;
        $val   = (float) $val;
        $this->db->set('alw_tr_perday', $val, false);
//        $this->db->set('work_day', $var, false);
        $where = " print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
//        $where .= " AND attn_i <= 0 ";
//        $where .= " AND attn_a <= 0 ";
//        $where .= " AND attn_l <= 0 ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    public function update_payslip_vhc_rt($eff_date, $val, $var) {
        $this->db->set('alw_vhc_rt', $val, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0  AND `empl_gr` <> 'Dewan Pegawas'";
        $where .= " AND job_title = '{$var}' ";
        $this->db->where($where, null, false);
        $this->db->update($this->payslip_tbl);
        return $this->db->affected_rows();
    }

    public function update_payslip_wt($eff_date, $val, $var) {
        // $val = "(CASE WHEN `empl_stat` = 'Capeg' THEN (0.8 * '{$val}') ELSE '{$val}' END)";
        
        $this->db->set('alw_wt', $val, false);
        $where = "print_dt >= '{$eff_date}' AND `lock`=0 ";
        switch ($var) {
            case 's':
                $where .= " AND mar_stat IS NULL ";
                break;
            case 'm0':
                $where .= " AND mar_stat = 'Menikah' AND child_cnt =0 ";
                break;
            case 'm1':
                $where .= " AND mar_stat = 'Menikah' AND child_cnt =1 ";
                break;

            case 'm2':
                $where .= " AND mar_stat = 'Menikah' AND child_cnt =2 ";
                break;
            case 'm3':
                $where .= " AND mar_stat = 'Menikah' AND child_cnt >=3 ";
                break;
        }
        $this->db->where($where, null, false)->where("empl_stat", 'Tetap');
        $this->db->update($this->payslip_tbl);
        $affected_rows = $this->db->affected_rows();

        $this->db->set('alw_wt', ($val * 0.8), false);
        $this->db->where($where, null, false)->where('empl_stat','Capeg');
        $this->db->update($this->payslip_tbl);
        $affected_rows += $this->db->affected_rows();    
        return $affected_rows;
    }

}
