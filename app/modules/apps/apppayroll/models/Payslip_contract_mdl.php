<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'payslip_mdl' . EXT;

class Payslip_Contract_Mdl extends Payslip_Mdl
{
    public $rs_common_views       = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'base_sal',
            'gross_sal',
            'ddc_amt',
            'net_pay',
        ),
        'cell_alignments'     => array(
//            'print_dt'  => 'right',
//            'base_sal'  => 'right',
//            'gross_sal' => 'right',
//            'ddc_amt'   => 'right',
//            'net_pay'   => 'right',
//            'hire_date' => 'right',
//            'los'       => 'right',
        ),
        'date_field_list'     => array(
            'print_dt'  => 'd/m/Y',
            'hire_date' => 'd/m/Y',
        ),
        'cell_nowrap'         => array(
            'print_dt',
            'nipp',
            'empl_name',
            'base_sal',
            'gross_sal',
            'ddc_amt',
            'net_pay',
            'job_unit',
            'job_title',
            // 'grade',
            // 'kode_peringkat',
            // 'lama_kontrak',
        )
    );
    public $rs_field_list         = array(
        '1' => 'print_dt',
        'nipp',
        'empl_name',
        'base_sal',
        'gross_sal',
        'ddc_amt',
        'net_pay',
        'job_unit',
        'job_title',
        // 'grade',
        // 'kode_peringkat',
        // 'lama_kontrak', // length of service
    );
    public $rs_masked_field_list  = array(
        '1' => 'Print Date',
        'NIPP',
        'Name',
        'Base Salary',
        'Gross Salary',
        'Total Deduction',
        'Net Pay',
        'Job Unit',
        'Job Title',
        // 'Grade',
        // 'Ranking Code',
        // 'Contract',
    );
    public $rs_select             = "*, CONCAT( (CASE WHEN  TIMESTAMPDIFF( YEAR, hire_date, NOW( ) ) % 2 = 0 THEN 2 ELSE 1 END ), ' thn' ) lama_kontrak";
    
    
    
}
