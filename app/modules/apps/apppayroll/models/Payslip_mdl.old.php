<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require_once 'apppayroll_frontmdl' . EXT;

class Payslip_Mdl extends Apppayroll_Frontmdl
{
    protected $conf_base_sal_md         = 'base_sal_md';
    protected $conf_base_sal_dir        = 'base_sal_dir';
    protected $conf_base_sal_spv_chief  = 'base_sal_spv_chief';
    protected $conf_base_sal_spv_sect   = 'base_sal_spv_sect';
    protected $conf_base_sal_spv_memb   = 'base_sal_spv_memb';
    protected $dash_mdl                 = 'dashboard_mdl';
    public $ptp_config_name             = 'ptp';
    protected $ref_dir_identifier       = 'dir_identifier';
    protected $ref_dir_alw_identifier   = 'dir_alw_identifier';
    protected $ref_dir_alw_var          = 'dir_alw_var';
    protected $ref_dir_var              = 'dir_var';
    protected $ref_md_identifier        = 'md_identifier';
    protected $ref_md_var               = 'md_var';
    protected $ref_spv_identifier       = 'spv_identifier';
    protected $ref_spv_chief_identifier = 'spv_chief_identifier';
    protected $ref_spv_chief_var        = 'spv_chief_var';
    protected $ref_spv_sect_identifier  = 'spv_sect_identifier';
    protected $ref_spv_sect_var         = 'spv_sect_var';
    protected $ref_spv_memb_identifier  = 'spv_memb_identifier';
    protected $ref_spv_memb_var         = 'spv_memb_var';
    public $rs_cf_cur_month;
    public $rs_cf_cur_year;
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
            'grade',
            'kode_peringkat',
            'los',
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
        'grade',
        'kode_peringkat',
        'los', // length of service
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
        'Grade',
        'Ranking Code',
        'Length of Service',
    );
    public $rs_select             = "*, IFNULL(alw_pph21, 0) + IFNULL(gross_sal, 0) AS `gross_sal`,  IFNULL(ddc_pph21, 0) + IFNULL(ddc_amt, 0) AS `ddc_amt`,  IFNULL(gross_sal, 0) - IFNULL(ddc_amt, 0 ) AS `net_pay`";
    public $rs_order_by           = null;
    public $rs_use_form_filter    = 'apr_sv_payslip';
    public $tbl                   = 'apr_sv_payslip';
    public $tbl_component         = 'apr_payslip_component';
    public $tbl_config            = 'apr_sv_payslip_config';
    public $tbl_group             = 'apr_payslip_group';
    public $tbl_group_component   = 'apr_payslip_group_component';
    public $tbl_group_reg         = 'apr_payslip_group_register';
    public $tbl_ref               = 'apr_ref_payslip';

    protected function _update_base_sal_dir($base_sal_md, $print_dt)
    {
        //formula base salary for md
        if (!$base_sal_md) {
            return;
        }
        $dir_var = $this->get_ref_payslip_var($this->ref_dir_var, $print_dt);
        $tbl    = $this->tbl_config;


        $value   = $dir_var * $base_sal_md;
        $name    = $this->conf_base_sal_dir;
        $current = $this->get_base_sal_dir($name, $print_dt);

        $this->db->set('value', $value);

        if (!$current) {
            $this->db->set('print_dt', $print_dt);
            $this->db->set('name', $name);
            $this->db->set('active_status', 1);
            $this->db->set('created', 'NOW()', false);
            $this->db->insert($tbl);
        }
        //force update
        if ($current) {
            $this->db->set('modified', 'NOW()', false);
            $this->db->where('id', $current->id);
            $this->db->update($tbl);
        }
        $affected = $this->db->affected_rows();

        // NOTE: add marker
        $dir_identifier      = $this->ref_dir_identifier;
        $filter_base_sal_dir = $this->get_filter_ref_payslip($print_dt, $dir_identifier);
        if (!$filter_base_sal_dir) {
            return;
        }
        //update md base sal
        $update = $this->get_base_sal_dir($name, $print_dt);

//        $this->db->flush_cache();
        $this->db->set('base_sal', $update->value);
        $this->db->where('print_dt', $print_dt);
        $this->db->where('lock', 0);
        if ($filter_base_sal_dir) {
            $this->db->where($filter_base_sal_dir, null, false);
        }
        $this->db->update($this->tbl);
        $affected = $this->db->affected_rows();
        if ($affected) {
            $this->get_update_all_allowance();
            $this->get_update_all_deduction();
            $tbl = $this->tbl;
            $lastdate  = date('t', strtotime($this->rs_cf_cur_year . '-' . $this->rs_cf_cur_month . '-01'));
            $this->get_update_all_pph21($tbl, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);
        }
    }

    // FIXME: under development
    protected function _update_base_sal_spv($print_dt)
    {
        $group_id = '4';
        $spv_identifier      = $this->ref_spv_identifier;
        $filter_spv = $this->get_filter_ref_payslip($print_dt, $spv_identifier, $group_id);

        if (!$filter_spv) {
            // NOTE: There are/is no SPV
            $this->session->set_userdata('flash_message', array('warning'=> lang('SPV not set')));

            return;
        }
        $aliases = array(
            'spv_chief',
            'spv_sect',
            'spv_memb',
        );
        $warning = array();
        foreach ($aliases as $alias) {
            $val_var = $this->get_ref_payslip_var($this->{'ref_' . $alias . '_var'}, $print_dt, $group_id);
            $spv_alias_identifier      = $this->{'ref_' . $alias . '_identifier'};
            $filter_alias_spv = $this->get_filter_ref_payslip($print_dt, $spv_alias_identifier, $group_id);

            if (!$filter_alias_spv) {
                // NOTE: There are /is no spv with alias
                $warning[] = 'Base salary not set: ' . $filter_alias_spv;
                continue;
            }
            // NOTE: get base sal value
            $spv_set = $this->get_base_sal_conf($this->{'conf_base_sal_' . $alias}, $print_dt);

            //        $this->db->flush_cache();
            $this->db->set('base_sal', $spv_set->value);
            $this->db->where('print_dt', $print_dt);
            $this->db->where('lock', 0);
            if ($filter_spv) {
                $this->db->where($filter_spv, null, false);
            }
            if ($filter_alias_spv) {
                $this->db->where($filter_alias_spv, null, false);
            }
            $this->db->update($this->tbl);
            $affected = $this->db->affected_rows();
            if ($affected) {
                $this->get_update_all_allowance();
                $this->get_update_all_deduction();
                $tbl = $this->tbl;
                $lastdate  = date('t', strtotime($this->rs_cf_cur_year . '-' . $this->rs_cf_cur_month . '-01'));
                $this->get_update_all_pph21($tbl, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);
            } else {
                // NOTE: add warning
                $warning[] = lang('Employee not found') . ': ' . $filter_alias_spv;
            }

        } // end foreach
        if($warning){
            $flash_message             = array();
            $flash_message ['warning'] = lang('Base Salary not update') . ':<br>' .
                implode('<br>', $warning);
            $this->session->set_userdata('flash_message', $flash_message);

        }

    }
    // SEE: self::update_base_sal_dir
    protected function _update_conf_base_sal_md($print_dt)
    {
        $this->_update_ptp($print_dt);
        //get ptp
        $this->load->model($this->dash_mdl);
        $ptp      = $this->{$this->dash_mdl}->get_ptp('permanent', $print_dt);

        if (!$ptp) {
            return;
        }

        if (!property_exists($ptp, 'ptp')) {
            return;
        }
        //formula base salary for md
        $md_var = $this->get_ref_payslip_var($this->ref_md_var, $print_dt);
        $tbl    = $this->tbl_config;

        $value     = $md_var * $ptp->ptp;
        $md_value = $value;
        $conf_name = $this->conf_base_sal_md;
        $current   = $this->get_base_sal_dir($conf_name, $print_dt);
        $this->db->set('value', $value);

        if (!$current) {
            $this->db->set('print_dt', $print_dt);
            $this->db->set('name', $conf_name);
            $this->db->set('active_status', 1);
            $this->db->set('created', 'NOW()', false);
            $this->db->insert($tbl);
        }
        //force update
        if ($current) {
            $this->db->set('modified', 'NOW()', false);
            $this->db->where('id', $current->id);
            $this->db->update($tbl);
        }

        $affected = $this->db->affected_rows();
        return $affected ? $md_value : $affected;
    }

    // TODO: unit test
    protected function _update_conf_base_sal_spv($print_dt)
    {
        $conf_name  = $this->conf_base_sal_md;
        $md_conf    = $this->get_base_sal_dir($conf_name, $print_dt);
        if (!$md_conf) {
            // NOTE: There are/is no SPV
            $this->session->set_userdata('flash_message', array('warning'=> lang('Fail to get MD base')));

            return;
        }
        $md_value = $md_conf->value;
        $aliases = array(
            'spv_chief',
            'spv_sect',
            'spv_memb',
        );

        $tbl    = $this->tbl_config;
        $group_id = '4';
        foreach ($aliases as $alias) {
            // TODO: test update each base sal spv conf
            // $this->db->flush_cache();
            $spv_var = $this->get_ref_payslip_var($this->{'ref_' . $alias . '_var'}, $print_dt, $group_id);
            $value     = $md_value * $spv_var;
            $conf_name = $this->{'conf_base_sal_' . $alias};
            $current   = $this->get_base_sal_conf($conf_name, $print_dt);
            $this->db->set('value', $value);

            if (!$current) {
                $this->db->set('print_dt', $print_dt);
                $this->db->set('name', $conf_name);
                $this->db->set('active_status', 1);
                $this->db->set('created', 'NOW()', false);
                $this->db->insert($tbl);
            }
            //force update
            if ($current) {
                $this->db->set('modified', 'NOW()', false);
                $this->db->where('id', $current->id);
                $this->db->update($tbl);
            }
        }
    }

    /**
     * To set payslip based on components assigned
     * @param  [type] $filter     [description]
     * @param  [type] $group_name [description]
     * @param  [type] $print_dt   [description]
     * @return [type]             [description]
     */
    protected function _update_component($filter, $group_name, $print_dt)
    {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }
        $components = $this->get_component();

        if (!$components) {
            return;
        }
        $group_components = $this->get_component_by_group($group_name, $print_dt);
        if (!$group_components) {
            return;
        }
        $excludelist = $components;
        foreach ($components as $key => $val) {
            if (isset($group_components[$key])) {
                unset($excludelist[$key]);
            }
        }

        if (!$excludelist) {
            return;
        }

        $tbl       = $this->tbl;
        $setfields = array('alw_fd', 'alw_tr', 'alw_prf');
        foreach ($excludelist as $key => $val) {
            if (in_array($val, $setfields)) {
                $this->db->set($val . '_set', null);
                continue;
            }
            $this->db->set($val, null);
        }

        $this->db->where($filter, null, false);
        $this->db->where('lock', 0);
        $this->db->where('print_dt', $print_dt);
        $this->db->update($tbl);
//        debug($this->db->last_query());die();
    }

    protected function _update_ptp($print_dt)
    {
        $group_name = 'permanent';
        $this->load->model($this->dash_mdl);
        $ptp        = $this->{$this->dash_mdl}->get_ptp($group_name, $print_dt);

        if (!$ptp) {
            log_message('error', 'PTP not found' . $print_dt);
            return;
        }
        $tbl = $this->tbl_config;
        $this->db->from($tbl);
        $this->db->where('name', $this->ptp_config_name);
        $this->db->where('active_status', 1);
        $this->db->where('menu_code', $group_name);
        $this->db->where('lock', 1);
        $this->db->where('print_dt', $print_dt);
        $q   = $this->db->get();
        $res = $q->result();
        if ($res) {
            log_message('error', 'PTP config has been set' . $print_dt);
            return;
        }
//        $this->db->from($tbl);
        $this->db->set('value', $ptp->ptp);
        $this->db->set('modified', 'NOW()', false);
        $this->db->where('name', $this->ptp_config_name);
        $this->db->where('active_status', 1);
        $this->db->where('menu_code', $group_name);
//        $this->db->where('lock', 1);
        $this->db->where('print_dt', $print_dt);
        $q        = $this->db->update($tbl);
        $affected = $this->db->affected_rows();
        if ($affected) {
            return $affected;
        }

        $this->db->set('value', $ptp->ptp);
        $this->db->set('created', 'NOW()', false);
        $this->db->set('name', $this->ptp_config_name);
        $this->db->set('active_status', 1);
        $this->db->set('menu_code', $group_name);
        $this->db->where('lock', 0);
        $this->db->set('print_dt', $print_dt);
        $q        = $this->db->insert($tbl);
        $affected = $this->db->affected_rows();
        if ($affected) {
            return $affected;
        }
    }

    public function custom_filter_result(&$db)
    {
        $db->where('YEAR(print_dt)', $this->rs_cf_cur_year, false);
        $db->where('MONTH(print_dt)', $this->rs_cf_cur_month, false);
    }

    public function fetch_detail($id)
    {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->db->select($this->rs_select, false);
        $this->db->where('id', $id);
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function generate_sv_data($year, $month, $skip_check = false)
    {
        if (!$skip_check) {
            $this->db->from($this->tbl);
            $this->db->where('YEAR(print_dt)', $year, false);
            $this->db->where('MONTH(print_dt)', $month, false);
            $this->db->where('`lock`', '0', false);
            $this->db->limit(1);
            $rs = $this->db->get();
            if ($rs->num_rows() > 0) {
                return true;
            }
        }

        // Get Schema
        require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . basename(__FILE__, EXT) . '_schema' . EXT;

        $lastdate  = date('t', strtotime($year . '-' . $month . '-01'));
        $excl_ids  = array(); //id to exclude
        // get resignation
        $tbls_date = array(
            "r_pegawai_meninggal" => "tanggal_meninggal",
            "r_pegawai_keluar"    => "tanggal_keluar",
            "r_pegawai_pensiun"   => "tanggal_pensiun",
        );
        foreach ($tbls_date as $tbl => $datefield) {
            $sqlstr = Payslip_Mdl_Schema::get_resignation_id($tbl, $year, $month, $datefield);
            $query  = $this->db->query($sqlstr);
            $rs     = $query->result();

            if ($rs) {
                foreach ($rs as $row) {
                    $excl_ids[$row->id_pegawai] = $row->id_pegawai;
                }
            }

            $query->free_result();
        }

        // locked ids to exclude
        $tbl      = $this->tbl;
        $print_dt = $year . '-' . $month . '-' . $lastdate;
        $sqlstr   = Payslip_Mdl_Schema::get_locked_id($tbl, $print_dt);
        $query    = $this->db->query($sqlstr);
        $rs       = $query->result();

        if ($rs) {
            foreach ($rs as $row) {
                $excl_ids[$row->empl_id] = $row->empl_id;
            }
        }
        //
        $excl_ids_str = "";
        if ($excl_ids) {
            $excl_ids_str = implode("','", $excl_ids);
        }
        if ($excl_ids_str) {
            $excl_ids_str = " AND rp.id_pegawai NOT IN ('" . $excl_ids_str . "')";
        }
        //
        $tbl      = $this->tbl;
        $sqlstr   = Payslip_Mdl_Schema::get_init_insert($tbl, $year, $month, $lastdate, $excl_ids_str);
        $query    = $this->db->query($sqlstr);
        //debug($sqlstr);
        // update job unit / jb title
        $tbl_join = 'r_peg_jab';
        $sqlstr   = Payslip_Mdl_Schema::get_update_job_unit_title($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // update status kontrak
        $tbl_join  = 'r_peg_kontrak';
        $empl_stat = 'Kontrak';
        $sqlstr    = Payslip_Mdl_Schema::get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $empl_stat);
        $query     = $this->db->query($sqlstr);

        // update status capeg
        $tbl_join  = 'r_peg_capeg';
        $empl_stat = 'Capeg';
        $sqlstr    = Payslip_Mdl_Schema::get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $empl_stat);
        $query     = $this->db->query($sqlstr);

        // update status kontrak
        $tbl_join  = 'r_peg_tetap';
        $empl_stat = 'Tetap';
        $sqlstr    = Payslip_Mdl_Schema::get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $empl_stat);
        $query     = $this->db->query($sqlstr);

        // update work day
        $tbl_join = 'apr_adm_work_day';
        $sqlstr   = Payslip_Mdl_Schema::get_update_work_day($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

//        // update marital status
//        $tbl_join = 'r_peg_perkawinan';
        $tbl_join = 'apr_adm_marstat';
        $sqlstr   = Payslip_Mdl_Schema::get_update_marstat($tbl, $tbl_join, $year, $month, $lastdate);
//       debug($sqlstr);die();
        $query    = $this->db->query($sqlstr);

        // update child count
//        $tbl_join = 'r_peg_anak';
        $tbl_join = 'apr_adm_dependent';
        $sqlstr   = Payslip_Mdl_Schema::get_update_child_count($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // update count children fro rice alw
//        $tbl_join = 'r_peg_anak';
        $tbl_join = 'apr_adm_dependent';
        $sqlstr   = Payslip_Mdl_Schema::get_update_alw_rc_ch_cnt($tbl, $tbl_join, $year, $month, $lastdate);
//        debug($sqlstr);die();
        $query    = $this->db->query($sqlstr);

        // update grade
        $tbl_join = 'r_peg_golongan';
        $sqlstr   = Payslip_Mdl_Schema::get_update_grade($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // update Base Salary
        $tbl_join = 'm_gaji_pokok';
        $sqlstr   = Payslip_Mdl_Schema::get_update_base_salary($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // WC status
        $tbl_join = 'apr_empl_wc';
        $sqlstr   = Payslip_Mdl_Schema::get_update_wc($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // NPWP
        $tbl_join = 'apr_adm_npwp';
        $sqlstr   = Payslip_Mdl_Schema::get_update_npwp($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // FKP status
        $tbl_join = 'apr_empl_fkp';
        $sqlstr   = Payslip_Mdl_Schema::get_update_fkp($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // Dharma Wanita status
        $tbl_join = 'apr_empl_dw';
        $sqlstr   = Payslip_Mdl_Schema::get_update_dw($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // ZAKAT status
        $tbl_join = 'apr_empl_zk';
        $sqlstr   = Payslip_Mdl_Schema::get_update_zk($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        // Water Bill status
        $tbl_join = 'apr_empl_wb';
        $sqlstr   = Payslip_Mdl_Schema::get_update_wb($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

        $this->get_update_all_allowance();
        $this->get_update_all_pph21($tbl, $year, $month, $lastdate);
       
        

        // Update tax_netto & tax base PKP // penghasilan kena pajak
        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_netto($tbl, $year, $month, $lastdate, 'tax_netto');
        $query    = $this->db->query($sqlstr);

        // Update pph21 tarif
        $tbl_join = 'apr_ref_pph21_tariff';
        $sqlstr   = Payslip_Mdl_Schema::get_update_pph21($tbl, $tbl_join, $year, $month, $lastdate, 1, 0.05);
        $query    = $this->db->query($sqlstr);

        // Update tax annual
        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_annual($tbl, $year, $month, $lastdate, 0);
        $query    = $this->db->query($sqlstr);

        // Update tax ddc ddc_pph21 alw_pph21
        $sqlstr   = Payslip_Mdl_Schema::get_update_ddc_pph21($tbl, $year, $month, $lastdate, 0);
        $query    = $this->db->query($sqlstr);

         $this->get_update_all_deduction();
        //update PTP penghasilan tertinggi pegawai
        $this->_update_ptp($print_dt);
        $this->_update_component($print_dt);
    }

    public function get_component()
    {
        $tbl = $this->tbl_component;
        $this->db->where('active_status', 1);
        $rs  = $this->db->get($tbl)->result();
        $res = array();
        if (!$rs) {
            return $res;
        }
        foreach ($rs as $row) {
            $res[$row->id] = $row->name;
        }

        return $res;
    }

    public function get_component_by_group($group_name, $print_dt)
    {
        $tbl = $this->tbl_group;
        $this->db->where('active_status', 1);
        $this->db->where('name', $group_name);
        $res = array();
        $rs  = $this->db->get($tbl)->result();
        if (!$rs) {
            return $res;
        }
        if (!isset($rs[0])) {
            return $res;
        }
        $id         = $rs[0]->id;
        $tbl        = $this->tbl_group_reg;
        $this->db->where('active_status', 1);
        $this->db->where('apr_payslip_group_id', $id);
        $this->db->where('start_date <=', $print_dt);
        $where_term = "IF(`term_date` IS NULL, TRUE, `term_date`>='{$print_dt}')";
        $this->db->where($where_term, null, false);
        $rs         = $this->db->get($tbl)->result();
        if (!$rs) {
            return $res;
        }
        if (!isset($rs[0])) {
            return $res;
        }
        $reg_id = $rs[0]->id;
        $tbl    = $this->tbl_group_component;
        $this->db->where('active_status', 1);
        $this->db->where('apr_payslip_group_register_id', $reg_id);
        $rs     = $this->db->get($tbl)->result();
        if (!$rs) {
            return $res;
        }

        foreach ($rs as $row) {
            $res[$row->apr_payslip_component_id] = $row->apr_payslip_component_id;
        }
        return $res;
    }

    public function get_custom_filter_config()
    {
        $res        = array();
        $res['tpl'] = 'elements/scaffolding/custom_filter_year_month';
        return $res;
    }

    public function get_custom_filter_data()
    {
        $res             = array();
        $res['cf_label'] = lang('Period');
        $this_year       = date('Y'); // year

        $cur_year = $this_year;
        if ($this->rs_cf_cur_year) {
            $cur_year = $this->rs_cf_cur_year;
        }
        $res['cf_cur_year'] = $cur_year;
        $res['cf_year_min'] = $cur_year - 10;
        $diff               = $this_year - $cur_year;
        $res['cf_year_max'] = $diff < 7 ? $cur_year + $diff : $cur_year + 7;
        $this_month         = date('m'); // month
        $cur_month          = $this_month;
        if ($this->rs_cf_cur_month) {
            $cur_month = $this->rs_cf_cur_month;
        }
        $res['cf_cur_month'] = $cur_month;
        $res['cf_months']    = array(
            '01' => lang('January'),
            '02' => lang('February'),
            '03' => lang('March'),
            '04' => lang('April'),
            '05' => lang('May'),
            '06' => lang('June'),
            '07' => lang('July'),
            '08' => lang('August'),
            '09' => lang('September'),
            '10' => lang('October'),
            '11' => lang('November'),
            '12' => lang('December'),
        );
        return $res;
    }

    public function get_rs_action()
    {
        $r_url      = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $pdf_md5    = md5('pdf-preview' . date('ymd'));
        $pdf_url    = sprintf($r_url, $pdf_md5);
        $rs_perpage = $this->rs_per_page;
        $rs_offset  = $this->rs_offset;
        $cur_page   = (($rs_offset - 1) / $rs_perpage) + 1;
        $pdf_url    .= '/' . $cur_page . '/' . $rs_perpage;
//        debug($cur_page);
//        debug($rs_perpage);
//        debug($rs_offset);die();
        $action     = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    'a' => array(
                        'url'          => $pdf_url,
                        'text'         => '<span class="fa fa-file-pdf-o"></span> ' . lang('Preview'),
                        'anchor_popup' => array(
                            'width'      => '800',
                            'height'     => '600',
                            'scrollbars' => 'no',
                            'status'     => 'no',
                            'resizable'  => 'no',
                            'screenx'    => '0',
                            'screeny'    => '0'
                        ),
                    )
                ),
                'action_list' => array(
                    'r' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-eye"><span>',
                    )
                ),
            )
        );
        return $action;
    }

    public function get_update_all_allowance()
    {
        $sqlstr = "SELECT * FROM (`apr_allowance`) WHERE active_status=1";
        $query  = $this->db->query($sqlstr);
        $res    = $query->result();
        if ($res) {
            $var_mdl = 'ref_allowance_detail_mdl';
            $this->load->model($var_mdl, $var_mdl);
            $base    = realpath(dirname(__FILE__));
            foreach ($res as $i => $row) {
                $mdl = $row->class_mdl;
                $fn  = $base . DIRECTORY_SEPARATOR . $mdl . EXT;
                if (!file_exists($fn)) {
//                    die($fn);
                    continue;
                }
                $instance = basename($fn, EXT) . $i;
                $this->load->model($mdl, $instance);
                $method   = $row->fetch_method;
                if (!method_exists($this->{$instance}, $method)) {
//                     die($method);
                    continue;
                }

                $this->{$var_mdl}->rs_allowance_data = $row;
                $this->{$instance}->alw_var_mdl      = $this->{$var_mdl};
                $this->{$instance}->{$method}();
            }
        }
    }

    public function get_update_all_deduction()
    {
        $sqlstr = "SELECT *
FROM (`apr_deduction`)
WHERE active_status=1 ORDER BY `menu_order` ";
        $query  = $this->db->query($sqlstr);
        $res    = $query->result();
        if ($res) {
            $var_mdl = 'ref_deduction_detail_mdl';
            $this->load->model($var_mdl, $var_mdl);
            $base    = realpath(dirname(__FILE__));
            foreach ($res as $i => $row) {
                $mdl = $row->class_mdl;
                $fn  = $base . DIRECTORY_SEPARATOR . $mdl . EXT;
                if (!file_exists($fn)) {
                    continue;
                }

                $instance = basename($fn, EXT) . $i;
                $this->load->model($mdl, $instance);
                $method   = $row->fetch_method;
                if (!method_exists($this->{$instance}, $method)) {
                    continue;
                }
                $this->{$var_mdl}->rs_index_where    = 'active_status=1';
                $this->{$var_mdl}->rs_deduction_data = $row;
                $this->{$instance}->ddc_var_mdl      = $this->{$var_mdl};
                $stat                                = $this->{$instance}->{$method}();
            }
        }
    }

    /**
     * [get_update_all_pph21 description]
     * @param  [type] $tbl      [description]
     * @param  [type] $year     [description]
     * @param  [type] $month    [description]
     * @param  [type] $lastdate [description]
     * @return [type]           [description]
     */
    public function get_update_all_pph21($tbl, $year, $month, $lastdate)
    {
        // Get Schema
        require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . basename(__FILE__, EXT) . '_schema' . EXT;

        // Update PTKP
        $tbl_join = 'apr_ref_ptkp_tariff';
        $sqlstr   = Payslip_Mdl_Schema::get_update_ptkp($tbl, $tbl_join, $year, $month, $lastdate, 1, 54000000);
        $query    = $this->db->query($sqlstr);

        // Update Tax Deduction Components biaya_jabatan
        $tbl_join = 'apr_ref_tax_ddc';
        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_comp($tbl, $tbl_join, $year, $month, $lastdate, 'tax_ddc_jt', 'biaya_jabatan', 'gross_sal');
        $query    = $this->db->query($sqlstr);

        // Update Tax Deduction Components iuran_jht
        $tbl_join = 'apr_ref_tax_ddc';
        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_comp($tbl, $tbl_join, $year, $month, $lastdate, 'tax_ddc_jht', 'iuran_jht', 'base_sal');
        $query    = $this->db->query($sqlstr);

        // Update Tax Deduction Components jaminan_pensiun
        $tbl_join = 'apr_ref_tax_ddc';
        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_comp($tbl, $tbl_join, $year, $month, $lastdate, 'tax_ddc_jp', 'jaminan_pensiun', 'base_sal');
        $query    = $this->db->query($sqlstr);

        // Update tax_netto & tax base PKP // penghasilan kena pajak

        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_netto($tbl, $year, $month, $lastdate, 'tax_netto');
        $query    = $this->db->query($sqlstr);

        // Update pph21 tarif
        $tbl_join = 'apr_ref_pph21_tariff';
        $sqlstr   = Payslip_Mdl_Schema::get_update_pph21($tbl, $tbl_join, $year, $month, $lastdate, 1, 0.05);
        $query    = $this->db->query($sqlstr);

        // Update tax annual
        $sqlstr   = Payslip_Mdl_Schema::get_update_tax_annual($tbl, $year, $month, $lastdate, 0);
        $query    = $this->db->query($sqlstr);

        // Update tax ddc ddc_pph21 alw_pph21
        $sqlstr   = Payslip_Mdl_Schema::get_update_ddc_pph21($tbl, $year, $month, $lastdate, 0);
        $query    = $this->db->query($sqlstr);
    }

    public function handle_custom_filter($input = array())
    {
        $rs_cf_cur_year  = date('Y'); //fallback
        $rs_cf_cur_month = date('m'); //fallback
        $do_filter       = false;
        $do_reset        = false;
        $mod             = $this->router->fetch_module();
        $ctl             = $this->router->fetch_class();
        $mtd             = $this->router->fetch_method();
        $sess_name       = sprintf('%s%s%s%s', 'cf_', $mod, $ctl, $mtd);

        if ($input) {
            if (isset($input['cf_do_filter'])) {
                $do_filter = $input['cf_do_filter'] ? true : false;
            }
            if (isset($input['cf_do_reset'])) {
                $do_reset = $input['cf_do_reset'] ? true : false;
            }
        }
        if ($do_reset) {
            $rs_cf_cur_year  = date('Y');
            $rs_cf_cur_month = date('m');
            $this->session->set_userdata($sess_name, array($rs_cf_cur_year, $rs_cf_cur_month));
        }
        if ($do_filter) {
            $rs_cf_cur_year  = $input['cf_year'];
            $rs_cf_cur_month = $input['cf_month'];
            $this->session->set_userdata($sess_name, array($rs_cf_cur_year, $rs_cf_cur_month));
        }

        $sess = $this->session->userdata($sess_name);
        if ($sess) {
            $rs_cf_cur_year  = $sess[0];
            $rs_cf_cur_month = $sess[1];
        }

        $this->rs_cf_cur_year  = $rs_cf_cur_year;
        $this->rs_cf_cur_month = $rs_cf_cur_month;
        $this->session->set_userdata($sess_name, array($rs_cf_cur_year, $rs_cf_cur_month));
    }

    public function update_alw_dir()
    {
        $print_dt = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));
        //formula dir_alw_var
        $dir_alw_var = $this->get_ref_payslip_var($this->ref_dir_alw_var, $print_dt);

        $filter_dir = $this->get_filter_ref_payslip($print_dt, $this->ref_dir_alw_identifier);
        $this->db->where('print_dt', $print_dt);
        $this->db->where('lock', 0);
        $this->db->where($filter_dir, null, false);
        $updateset = <<<UPDATE
        '{$dir_alw_var}' * empl_work_day * `base_sal`
UPDATE;

        $this->db->set('alw_jt', $updateset, false);
        $this->db->update($this->tbl);
    }

    public function update_base_sal($filter = null)
    {
//        debug($this->rs_cf_cur_year);
//        debug($this->rs_cf_cur_month);
        $t_date = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));

        $this->db->where('print_dt', $t_date);
        $this->db->where('lock', 0);
        $this->db->where('base_sal_id', null);
        if ($filter) {
            $this->db->where($filter, null, false);
        }
        $this->db->select("nipp as sample_NIP,empl_id as ID_PEGAWAI,IFNULL(grade_id, 'NULL') AS KODE_PERINGKAT,IFNULL(grade, 'NULL') AS PERINGKAT,los AS MASA_KERJA_PERINGKAT", false);
        $this->db->group_by(array('grade_id', 'los'));
        $res = $this->db->get($this->tbl)->result();
        if (!$res) {
            return;
        }
        // Get Schema
        require_once realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . basename(__FILE__, EXT) . '_schema' . EXT;

        $lastdate = date('t', strtotime($t_date));
        $tbl_join = 'm_gaji_pokok';
        $sqlstr   = Payslip_Mdl_Schema::get_update_base_salary($this->tbl, $tbl_join, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);
        $query    = $this->db->query($sqlstr);
        $this->get_update_all_allowance();
        $this->get_update_all_deduction();

        $this->db->where('print_dt', $t_date);
        $this->db->where('lock', 0);
        $this->db->where('base_sal_id', null);
        if ($filter) {
            $this->db->where($filter, null, false);
        }
        $this->db->select("nipp as sample_NIP,empl_id as ID_PEGAWAI,IFNULL(grade_id, 'NULL') AS KODE_PERINGKAT,IFNULL(grade, 'NULL') AS PERINGKAT,los AS MASA_KERJA_PERINGKAT", false);
        $this->db->group_by(array('grade_id', 'los'));
        $res = $this->db->get($this->tbl)->result();
        if (!$res) {
            return;
        }
        $flash_message             = array();
        $flash_message ['warning'] = lang('Missing Base Salary Setup') . ':' .
            str_replace(array('(', 'Array', ')', 'stdClass Object'), array('', '<br>', '<br>', '', '=', " "), print_r($res, true));
        $this->session->set_userdata('flash_message', $flash_message);
//        die();
    }

    public function update_base_sal_dir()
    {
        $print_dt = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));
        $md_value  = $this->_update_conf_base_sal_md($print_dt);
        /**
        $this->_update_ptp($print_dt);
        //get ptp
        $this->load->model($this->dash_mdl);
        $ptp      = $this->{$this->dash_mdl}->get_ptp('permanent', $print_dt);

        if (!$ptp) {
            return;
        }

        if (!property_exists($ptp, 'ptp')) {
            return;
        }
        //formula base salary for md
        $md_var = $this->get_ref_payslip_var($this->ref_md_var, $print_dt);
        $tbl    = $this->tbl_config;

        $value     = $md_var * $ptp->ptp;
        $md_value = $value;
        $conf_name = $this->conf_base_sal_md;
        $current   = $this->get_base_sal_dir($conf_name, $print_dt);
        $this->db->set('value', $value);

        if (!$current) {
            $this->db->set('print_dt', $print_dt);
            $this->db->set('name', $conf_name);
            $this->db->set('active_status', 1);
            $this->db->set('created', 'NOW()', false);
            $this->db->insert($tbl);
        }
        //force update
        if ($current) {
            $this->db->set('modified', 'NOW()', false);
            $this->db->where('id', $current->id);
            $this->db->update($tbl);
        }
        */
        // $md_value = $this->db->affected_rows();
        if ($md_value) {
            $this->_update_base_sal_dir($md_value, $print_dt);
        }

        // update MD
        $md_identifier      = $this->ref_md_identifier;
        $filter_base_sal_md = $this->get_filter_ref_payslip($print_dt, $md_identifier);
        if ($filter_base_sal_md) {
            //update md base sal
            $conf_name = $this->conf_base_sal_md;
            $update = $this->get_base_sal_dir($conf_name, $print_dt);

            //        $this->db->flush_cache();
            $this->db->set('base_sal', $update->value);
            $this->db->where('print_dt', $print_dt);
            $this->db->where('lock', 0);
            //        debug($filter_base_sal_md);die();
            if ($filter_base_sal_md) {
                $this->db->where($filter_base_sal_md, null, false);
            }
            $this->db->update($this->tbl);
            $affected = $this->db->affected_rows();

            if ($affected) {
                $this->get_update_all_allowance();
                $this->get_update_all_deduction();
                $tbl = $this->tbl;
                $lastdate  = date('t', strtotime($this->rs_cf_cur_year . '-' . $this->rs_cf_cur_month . '-01'));
                $this->get_update_all_pph21($tbl, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);
            }
        }
    }

    public function update_base_sal_spv()
    {
        $print_dt = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));
        $md_value  = $this->_update_conf_base_sal_md($print_dt);
        $this->_update_conf_base_sal_spv($print_dt);
        $this->_update_base_sal_spv($print_dt);
    }

    public function update_component($filter, $group_name, $print_dt = null)
    {
        return $this->_update_component($filter, $group_name, $print_dt);
    }

    public function get_filter_ref_payslip($print_dt, $menu_code, $group_id = '3')
    {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }

        $tbl = $this->tbl_ref;
        //params

        $payslip_group_id = $group_id;

        $this->db->where('apr_payslip_group_id', $payslip_group_id);
        $this->db->where('menu_code', $menu_code);
        $this->db->where('eff_date <=', $print_dt);

        $where_term_date = "IF (`term_date` IS NULL, TRUE, `term_date` >= '{$print_dt}')";
        $this->db->where($where_term_date, null, false);
        $res             = $this->db->get($tbl)->result();
//        $this->db->reset();
//        debug($this->db->last_query());die();
        if (!$res) {
//            missing filter
            return false;
        }
        $arr = array();
        foreach ($res as $i=>$val) {
            $arr[] = sprintf("`%s` %s '%s'", $val->name, $val->operator, $val->text);
        }
        $result = "( ".implode(" AND ", $arr)." )";
        return $result;
//        debug($res);die();
    }

    public function get_ref_payslip_var($ref_name, $print_dt, $group_id = '3')
    {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }

        $tbl              = $this->tbl_ref;
        //params
        $name             = $ref_name;
        $payslip_group_id = $group_id;

        $this->db->where('apr_payslip_group_id', $payslip_group_id);
        $this->db->where('name', $name);
        $this->db->where('eff_date <=', $print_dt);

        $where_term_date = "IF (`term_date` IS NULL, TRUE, `term_date` >= '{$print_dt}')";
        $this->db->where($where_term_date, null, false);
        $res             = $this->db->get($tbl)->result();

//        debug($this->db->last_query());die();
        if (!$res) {
//            missing value
            return 0;
        }
        if (!isset($res[0])) {
            //missing record
            return 0;
        }

        return $res[0]->value;
//        debug($res);die();
    }

    public function get_base_sal_conf($conf_name, $print_dt, $lock = 0)
    {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }
        $tbl    = $this->tbl_config;
        $this->db->where('print_dt', $print_dt);
        $this->db->where('name', $conf_name);
        $q_lock = "(";
        if ($lock === null) {
            $q_lock .= "`lock` IS NULL";
        } else {
            $q_lock .= "`lock`='{$lock}'";
        }

        if ($lock === 0) {
            $q_lock .= " OR `lock` IS NULL";
        }
        $q_lock .= ")";
        $this->db->where($q_lock, null, false);


        $this->db->where('active_status', 1);
        $res = $this->db->get($tbl)->result();
        if (!$res) {
//            missing result
            return 0;
        }
        if (!isset($res[0])) {
            //missing record
            return 0;
        }

        return $res[0];
    }

    //RFCTR: see self::get_base_sal_conf
    public function get_base_sal_dir($conf_name, $print_dt, $lock = 0)
    {
        return $this->get_base_sal_conf($conf_name, $print_dt, $lock);
    }
}
