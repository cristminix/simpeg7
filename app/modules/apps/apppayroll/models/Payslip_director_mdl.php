<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'payslip_mdl'. EXT;;
class Payslip_Director_Mdl extends Payslip_Mdl
{
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
        // 'los', // length of service
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
        // 'Length of Service',
    );
}
