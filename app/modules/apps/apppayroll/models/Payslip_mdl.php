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
        'empl_stat'
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
        'Employee Status'
    );
    public $rs_select             = "*";
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
            // $this->get_update_all_allowance();
            // $this->get_update_all_deduction();
            $tbl = $this->tbl;
            $lastdate  = date('t', strtotime($this->rs_cf_cur_year . '-' . $this->rs_cf_cur_month . '-01'));
            // $this->get_update_all_pph21($tbl, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);

            $records = $this->db->where($filter_base_sal_dir, null, false)
                                    ->where('print_dt',$print_dt)
                                    ->get($this->tbl)
                                    ->result();
                foreach ($records as &$row) {
                    $this->fix_pph21($row,'Khusus');
                } 
            die();
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
                // $this->get_update_all_allowance();
                // $this->get_update_all_deduction();
                $tbl = $this->tbl;
                $lastdate  = date('t', strtotime($this->rs_cf_cur_year . '-' . $this->rs_cf_cur_month . '-01'));
                // $this->get_update_all_pph21($tbl, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);

                $records = $this->db->where($filter_alias_spv, null, false)
                                    ->where('print_dt',$print_dt)
                                    ->get($this->tbl)
                                    ->result();
                foreach ($records as &$row) {
                    $this->fix_pph21($row,'Khusus');
                }    
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
    public function update_ptp($print_dt)
    {
        $this->_update_ptp($print_dt);
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
        // $this->db->where('lock', 1);
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
        // $this->db->where('print_dt', $print_dt)->delete($tbl);
        if(empty($res)){
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
        return 1;
        
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
    public function _update_ch()
    {
      $rs = $this->db->select("r.*,rpa.status_anak,rpa.tanggal_lahir_anak,rpa.nama_anak,rpa.status_anak,rpa.gender_anak,rpa.keterangan_tunjangan") 
                      ->join('r_peg_anak rpa','rpa.id_pegawai=r.id_pegawai','left')
                      // ->where('rpa.keterangan_tunjangan','Dapat')
                      ->group_by('rpa.id_peg_anak')
                      ->get("rekap_peg r")
                      ->result() ;
      foreach ($rs as $r) {
        $cond = [
          'empl_id'=>$r->id_pegawai,
          'text' => $r->nama_anak,
          'relatives'=>$r->status_anak,
          'gender'=>$r->gender_anak

        ];
        $check = $this->db->where($cond)->get('apr_adm_dependent')->num_rows();
        if($check > 0){
          // echo "$check : DEL\n";

          $check = $this->db->where($cond)->delete('apr_adm_dependent');
        }
        if($r->keterangan_tunjangan == 'Dapat'){
          $apr_adm_dependent = [
            'empl_id' => $r->id_pegawai,
            'nipp'=>$r->nip_baru,
            'eff_date'=>$r->tanggal_lahir_anak,
            'gender'=>$r->gender_anak,
            'alw_rc_ch_cnt'=>1,
            'alw_ch_cnt'=>1,
            'dependent_status'=>1,
            'relatives'=> $r->status_anak,
            'name' => $r->nama_pegawai,
            'text' =>$r->nama_anak,
            'active_status'=>1,
            'created'=>date('Y:m:d H:i:s')
          ];

          // echo "insert\n";
          $this->db->insert('apr_adm_dependent',$apr_adm_dependent);

        }
      }
    }

    protected function _update_marstat($year, $month)
    {
        $first_mo = sprintf('%s-%s-01', $year, $month);
        $time = strtotime($first_mo);
        $print_dt = date('Y-m-t', $time);
        // printf('<pre>');
        // printf("Delete Current Record for %s\n", $print_dt);
        $tbl = 'apr_adm_marstat';
        $this->db
            ->where(['print_dt' => $print_dt])->delete($tbl);
        // printf("Executing Query:\n%s\n", $this->db->last_query());
        // printf("Affected Rows: %s\n",$this->db->affected_rows());
        $this->db->query("ALTER TABLE {$tbl} AUTO_INCREMENT=0");
        // printf("Executing Query:\n%s\n", $this->db->last_query());
        // printf("Syncronizing for %s\n", $print_dt);
        $tbl_peg = 'rekap_peg r';
        $tbl_peg2 = 'r_pegawai r2';
        $tbl_peg_perkawinan = 'r_peg_perkawinan a';
        $tbl_peg_perkawinan_tunj = 'r_peg_perkawinan_tunj b';
        $select = <<<SEL
        NULL id,
        '{$print_dt}' print_dt,
        a.id_pegawai empl_id,
        r2.nip_baru nipp,
        b.tgl_efektif eff_date,
        NULL term_date,
        1 alw_rc_sp_cnt,
        r.status_perkawinan mar_stat,
        r2.nama_pegawai name,
        a.nama_suris text,
        NULL annotation,
        1 active_status,
        NULL menu_code,
        NULL menu_order,
        NOW() created,
        NULL modified
SEL;
        $where = [
            'a.status_aktif'=> '1',
            'a.tanggal_menikah <>' => '0000-00-00',
            'b.tgl_efektif <>' => '0000-00-00',
            'b.tgl_efektif <=' => $print_dt
        ];
        $join = [$tbl_peg_perkawinan_tunj, 'a.id_peg_perkawinan = b.id_r_peg_perkawinan AND b.status_tunjangan = 1', 'left'];
        $join2 = [$tbl_peg, 'a.id_pegawai = r.id_pegawai', 'left'];
        $join3 = [$tbl_peg2, 'a.id_pegawai = r2.id_pegawai', 'left'];
        $rs = $this->db->select($select)
            ->where($where)
            ->join($join[0], $join[1], $join[2])
            ->join($join2[0], $join2[1], $join2[2])
            ->join($join3[0], $join3[1], $join3[2])
            ->get($tbl_peg_perkawinan);
        $sel_q = $this->db->last_query();
        // printf("Executing Query:\n%s\n", $this->db->last_query());
        // printf("Row Count: %s\n",$rs->num_rows());
        $insert = <<<INS
        INSERT INTO {$tbl} {$sel_q}
INS;
        $this->db->query($insert);
        // printf("Executing Query:\n%s\n", $this->db->last_query());
        // printf("Affected Rows: %s\n",$this->db->affected_rows());
        // printf('</pre>');
        // printf('<a href="%s">%s</a>',$_SERVER['HTTP_REFERER'], '&gt;&gt; Back'); 
    }

    public function generate_sv_data($year, $month, $skip_check = false)
    {
        
        if($this->tbl !== 'apr_sv_payslip') {
            return true;
        }
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
        $this->_update_ch();
        $this->_update_marstat($year, $month);
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
        //$sqlstr   = 
        $query_list = Payslip_Mdl_Schema::get_init_insert($tbl, $year, $month, $lastdate, $excl_ids_str);
        foreach ($query_list as $sql) {
            $this->db->query( $sql);
        }
        
        //$query    = $this->db->query($sqlstr);
        //debug($sqlstr);
        // update job unit / jb title
        $tbl_join = 'r_peg_jab';
        $sqlstr   = Payslip_Mdl_Schema::get_update_job_unit_title($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);
//return;
        // update status kontrak
        // $tbl_join  = 'r_peg_kontrak';
        // $empl_stat = 'Kontrak';
        // $sqlstr    = Payslip_Mdl_Schema::get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $empl_stat);
        // $query     = $this->db->query($sqlstr);

        // update status capeg
        // $tbl_join  = 'r_peg_capeg';
        // $empl_stat = 'Capeg';
        // $sqlstr    = Payslip_Mdl_Schema::get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $empl_stat);
        // $query     = $this->db->query($sqlstr);

        // update status kontrak
        // $tbl_join  = 'r_peg_tetap';
        // $empl_stat = 'Tetap';
        // $sqlstr    = Payslip_Mdl_Schema::get_update_status($tbl, $tbl_join, $year, $month, $lastdate, $empl_stat);
        // $query     = $this->db->query($sqlstr);

        // update work day
        $tbl_join = 'apr_adm_work_day';
        $sqlstr   = Payslip_Mdl_Schema::get_update_work_day($tbl, $tbl_join, $year, $month, $lastdate);
        $query    = $this->db->query($sqlstr);

//        // update marital status
//        $tbl_join = 'r_peg_perkawinan';
        $tbl_join = 'apr_adm_marstat';
        $sqlstr   = Payslip_Mdl_Schema::get_update_marstat($tbl, $tbl_join, $year, $month, $lastdate);
    //   var_dump($sqlstr);die();

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
        // $tbl_join = 'r_peg_golongan';
        // $sqlstr   = Payslip_Mdl_Schema::get_update_grade($tbl, $tbl_join, $year, $month, $lastdate);
        // // // echo $sqlstr;die();
        // $query    = $this->db->query($sqlstr);

        // update Base Salary
        $tbl_join = 'm_gaji_pokok';
        $sqlstr   = Payslip_Mdl_Schema::get_update_base_salary($tbl, $tbl_join, $year, $month, $lastdate);
        // echo $sqlstr;die();
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
        $this->get_update_all_deduction();
        

        // Update tax_netto & tax base PKP // penghasilan kena pajak
        // $sqlstr   = Payslip_Mdl_Schema::get_update_tax_netto($tbl, $year, $month, $lastdate, 'tax_netto');
        // $query    = $this->db->query($sqlstr);

        // Update pph21 tarif
        $tbl_join = 'apr_ref_pph21_tariff';
        $sqlstr   = Payslip_Mdl_Schema::get_update_pph21($tbl, $tbl_join, $year, $month, $lastdate, 1, 0.05);
        $query    = $this->db->query($sqlstr);

        // Update tax annual
        // $sqlstr   = Payslip_Mdl_Schema::get_update_tax_annual($tbl, $year, $month, $lastdate, 0);
        // $query    = $this->db->query($sqlstr);

        // Update tax ddc ddc_pph21 alw_pph21
        // $sqlstr   = Payslip_Mdl_Schema::get_update_ddc_pph21($tbl, $year, $month, $lastdate, 0);
        // $query    = $this->db->query($sqlstr);

        //update PTP penghasilan tertinggi pegawai
        
        $this->_update_component('','',$print_dt);

        //
        // die('IA HERE');
        $records = $this->db->where("print_dt","{$year}-{$month}-{$lastdate}")
                            ->where("empl_stat","Tetap")
                            ->get('apr_sv_payslip')
                            ->result();
        foreach ($records as &$row) {
            $this->fix_pph21($row,'Tetap');
        }                    
        $records = $this->db->where("print_dt","{$year}-{$month}-{$lastdate}")
                            ->where("empl_stat","Capeg")
                            ->get('apr_sv_payslip')
                            ->result();
        foreach ($records as &$row) {
            $this->fix_pph21($row,'Capeg');
        }
        $records = $this->db->where("print_dt","{$year}-{$month}-{$lastdate}")
                            ->where("empl_stat","Kontrak")
                            ->get('apr_sv_payslip')
                            ->result();
        foreach ($records as &$row) {
            $this->fix_pph21($row,'Kontrak');
        }

        $this->_update_ptp($print_dt);
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
        if($res['cf_cur_year'] <= 2016) {
            $res['cf_cur_year'] = 2016;
            $this->rs_cf_cur_year = 2016;
            $cur_year = $this->rs_cf_cur_year;
            // $this->rs_cf_cur_year = 2016;
        }
        $res['cf_year_min'] = $cur_year - 10;
        if($res['cf_year_min'] <= 2016) {
            $res['cf_year_min'] = 2016;
            // $this->rs_cf_cur_year = 2016;
        }
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
        $curmonthyear = date('Ym');
        $selmonthyear = sprintf('%s%s', $this->rs_cf_cur_year,$this->rs_cf_cur_month);
        $salt = date('ymd');
        if($curmonthyear > $selmonthyear) {
            $thisurl = sprintf($r_url, md5('set-archive' . $salt ).'/' . base64_encode($salt.$selmonthyear.$salt));
            $thistext = '<span class="fa fa-file-o"></span> Set to Archive';
            if($this->tbl !== 'apr_sv_payslip') {
                $thisurl = '#';
                $thistext = '<span class="fa fa-lock"></span> Archived';
            }
            $action['view_data']['action_top']['b'] = [
                'url' => $thisurl,
                'text'=> $thistext
            ];
        }
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
    public function get_deduction_var($print_dt)
    {
        $deduction_var_list = [];

        $sql_apr_payslip_group = "SELECT
            apgr.apr_payslip_group_id 
            FROM
            apr_payslip_group_register AS apgr
            WHERE
            apgr.active_status = 1 AND
            (apgr.start_date <= '{$print_dt}' AND
            (apgr.term_date IS NULL OR
            apgr.term_date >= '{$print_dt}'))
            ORDER BY
            apgr.created DESC,
            apgr.start_date DESC
            LIMIT 1";

        $apr_payslip_group_id = $this->db->query($sql_apr_payslip_group)->row()->apr_payslip_group_id;

        if(empty($apr_payslip_group_id)){
            return $deduction_var_list;
        }
        //apr_payslip_group_id = 4



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
        // $sqlstr   = Payslip_Mdl_Schema::get_update_tax_annual($tbl, $year, $month, $lastdate, 0);
        // $query    = $this->db->query($sqlstr);

        // Update tax ddc ddc_pph21 alw_pph21
        // $sqlstr   = Payslip_Mdl_Schema::get_update_ddc_pph21($tbl, $year, $month, $lastdate, 0);
        // $query    = $this->db->query($sqlstr);
        
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
        $this->set_tbl_by_archive();
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

        $this->db->set('alw_adv', $updateset, false);
        $this->db->update($this->tbl);

        // echo "update_alw_dir".$this->db->last_query()."\n";

    }

    public function update_base_sal($filter = null)
    {

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
       //  var_dump($this->rs_cf_cur_year);
       // var_dump($this->rs_cf_cur_month);

       // die();
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
        $this->update_ptp($print_dt);
        // update MD
        $md_identifier      = $this->ref_md_identifier;

        // echo $md_identifier . "\n";

        $filter_base_sal_md = $this->get_filter_ref_payslip($print_dt, $md_identifier); //'2019-04-24','md_identifier'
        // print_r($filter_base_sal_md);
        // exit;
        if ($filter_base_sal_md) {
            //update md base sal
            $conf_name = $this->conf_base_sal_md;

            
            $update = $this->get_base_sal_dir($conf_name, $print_dt); //'base_sal_md','2019-04-24'
            /*
                stdClass Object
                (
                    [id] => 26
                    [print_dt] => 2019-03-31
                    [value] => 38622837.545925
                    [lock] => 
                    [name] => base_sal_md
                    [text] => 
                    [annotation] => 
                    [active_status] => 1
                    [menu_code] => 
                    [menu_order] => 
                    [created] => 2019-03-21 11:54:29
                    [modified] => 2019-03-24 12:56:03
                )
            */
            // print_r($this->tbl);
            // exit;
            //        $this->db->flush_cache();
            $this->db->set('base_sal', $update->value); // 38622837.545925
            $this->db->where('print_dt', $print_dt);
            $this->db->where('lock', 0);
            
            // print_r($filter_base_sal_md);
            // die();
            
            if ($filter_base_sal_md) {
                $this->db->where($filter_base_sal_md, null, false); // ( `job_title` = 'Direktur Utama' )
            }
            $this->db->update($this->tbl); // apr_sv_payslip

            $affected = $this->db->affected_rows();

            if ($affected) {
                // $this->get_update_all_allowance();
                // $this->get_update_all_deduction();
                $this->update_alw_dir();

                $tbl = $this->tbl;
                $lastdate  = date('t', strtotime($this->rs_cf_cur_year . '-' . $this->rs_cf_cur_month . '-01'));
                // $this->get_update_all_pph21($tbl, $this->rs_cf_cur_year, $this->rs_cf_cur_month, $lastdate);\
                //echo "update_base_sal_dir\n";                  
                $records = $this->db->where($filter_base_sal_md, null, false)
                                    ->where('print_dt',$print_dt)
                                    ->get($this->tbl)
                                    ->result();
                foreach ($records as &$row) {
                    $this->fix_pph21($row,'Khusus');
                }  
            }
        }
    }

    public function update_base_sal_spv()
    {
        $print_dt = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));
        // $this->update_ptp($print_dt);

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

    public function fix_pph21(&$row,$empl_stat,$update=true)
    {
        // SAVE PK
        $pk = $row->id;
        unset($row->id);
        // REMOVE TUNJANGAN SHIFT 
        $row->alw_sh = 0;
        $tz  = new DateTimeZone('Asia/Jakarta');
        
            $age = DateTime::createFromFormat('Y-m-d', $row->dob, $tz)
            ->diff(DateTime::createFromFormat('Y-m-d', $row->print_dt, $tz))
            ->y;
        // echo $row->dob,'-',$age,'<br>';
        if($empl_stat == 'Capeg'){
           // $row->alw_rs = 350000*0.8;//80round($row->alw_rc) * 0.8;
            
            // $row->base_sal = round($row->base_sal) * 0.8;
            // $row->alw_prf = round($row->alw_wt) * 0.8;

            // echo "\n;"
        }
        if($empl_stat == 'Kontrak'){
            $row->alw_rc = 0;
            $row->alw_wt = 0;
            $row->alw_mar = 0;
            $row->alw_ch = 0;
            $row->alw_prf = 0;
            $row->alw_adv = 53731;
        }
        
        if($row->empl_gr == 'Dewan Pengawas'){
            $row->alw_tr  = 0;
            $row->alw_prf  = 0;
            $row->alw_mar = 0;
            $row->alw_ch = 0;
            $row->alw_fd = 0;
            $row->alw_rc  = 0;
            $row->alw_adv = 0;
            $row->alw_wt = 0;
            $row->alw_jt = 0;
            $row->alw_rs = 0;
            $row->alw_ot = 0;
            $row->alw_tpp = 0;
            $row->alw_vhc_rt = 0;
        }
        $ad = 0; $bl = -1;
        $stop = false;
        
        // $row->alw_fd = $row->alw_tr;

        foreach ($row as &$item) {
            if(empty($item)){
                $item = 0;
            }
        }
        while(!$stop){

            $o  = round($row->base_sal); // GAJI POKOK
            $p  = round($row->alw_mar); // ISTERI 
            $q  = round($row->alw_ch); // ANAK
            $r  = round($row->alw_rc); // BERAS
            $s  = round($row->alw_wt); // AIR
            $t  = round($row->alw_jt); // JABATAN
            $u  = round($row->alw_prf); // PRESTASI
            $v  = round($row->alw_ot); // LEMBUR
            $w  = round($row->alw_adv); // KHUSUS
            $x  = round($row->alw_rs); // PERUMAHAN 
            $y  = round($row->alw_tr); // TRANSPORT 
            
            $z  = round($row->alw_vhc_rt); // TTPP
            
            $aa = round($row->alw_fd); // MAKAN
            $ab = round($row->alw_sh); // SHIFT
            $ac = round($row->alw_tpp); // TPP

            $ad = $bl > 0 ? $bl: 0; // PPH21 , BL look at bottom

            // echo "alw_pph21 = $ad <br>";
            $row->alw_pph21 = $ad;
            $row->ddc_pph21 = $ad;
            
            $ae = $o + $p + $q + $r + $s + $t + $u + $v + $w + $x + $y + $z + $aa + $ab + $ac + $ad  ;  // GAJI KOTOR , =SUM(O4:AD4)
            // echo "$o + $p + $q + $r + $s + $t + $u + $v + $w + $x + $y + $z + $aa + $ab + $ac + $ad <br>";
            // echo "gaji_bruto :$ae<br>";
            $ag = round(($ae - $z) * 0.02);  // POTONGAN ASTEK  , =(AE4-Z4)*2% 
            
            
            $ai = ($o + $p + $q + $x) * 0.05;//$r->ddc_aspen;  // POTOGAN ASPEN, =(SUM(O4:Q4)+X4)*5%

            
            if($empl_stat == 'Kontrak' || $empl_stat == 'Capeg'){
                $ai = 0;
            }
            $ah = ($empl_stat != 'Kontrak' ? $row->ddc_bpjs_kes : ($ae * 0.01));  // POTONGAN ASKES 
           
            if($row->empl_gr == 'Dewan Pengawas'){
                $ai = 0;
                $ag = 0;
                $ah = 0;
            }

            $row->ddc_bpjs_ket = $ag;
            $row->ddc_aspen = round($ai);
            $row->ddc_bpjs_kes = $ah;
            $ay = $ae; // GAJI BRUTO
                
            $ddc_bpjs_pen = 0;
            $ddc_bpjs_pen_base = 0;

            if($empl_stat === 'Kontrak' || $row->empl_gr === 'Direksi') {
                if($age <= $row->bpjs_pen_maxage) {
                    $ddc_bpjs_pen_base = $ae <= $row->bpjs_pen_max ? $ae : $row->bpjs_pen_max;
                    $ddc_bpjs_pen = $row->bpjs_pen_tariff * $ddc_bpjs_pen_base;
                }
            }
            
            if($empl_stat === 'Tetap' || $empl_stat === 'Capeg') {
                
                $ddc_bpjs_pen_base = $ae <= $row->bpjs_pen_max ? $ae : $row->bpjs_pen_max;
                $ddc_bpjs_pen = $row->bpjs_pen_tariff * $ddc_bpjs_pen_base;
            }
            // $row->gross_sal = $ay;
            $pph_21_calc_gaji_bruto = $ay;

            $az = $ag; // POTONGAN ASTEK
            $ba = $ai; // POTONGAN ASPEN
            $bb = $ah; // POTONGAN ASKES
            //    
            $bc = $ay + $az + $ba + $bb + $ddc_bpjs_pen; // PAJAK BRUTO, =SUM(AY4:BB4)


            $pph_21_calc_pajak_bruto = $bc;

            $bd = (0.05 * $bc) <= 500000 ? (0.05 * $bc) : 500000; //BIAYA JABATAN , =IF((5%*BC4)<=500000,BC4*5%,500000) 
            $pph_21_calc_biaya_jabatan = $bd;

            $be = $az + $ba + $bb + $ddc_bpjs_pen; // Astek + Aspen + Askes, =SUM(AZ4:BB4)
            $pph_21_calc_biaya_astek_askes_aspen = $be;
            
            $bf = ($bd + $be); // TOTAL PENGURANG , =SUM(BD4:BE4)
            $pph_21_calc_total_pengurang = $bf;

            $bg = ($bc - $bf); // PAJAK NETTO , BC4-BF4 
            $pph_21_calc_pajak_netto = $bg;

            $bh = ($bg * 12); // PAJAK DISTAHUNKAN , BG4*12
            $pph_21_calc_pajak_disetahunkan = $bh;    

            $bi = round($row->ptkp_tariff); // PTKP
            $pph_21_calc_ptkp = $bi;

            $bj = ($bh - $bi) > 0 ? ($bh - $bi) : 0; // NILAI KENA PAJAK , =IF(BH4-BI4>0,BH4-BI4,0)
            
            $pph_21_calc_nilai_kena_pajak = $bj;
            //PAJAK SETAHUN
            $bk = round(($bj<=0?0:($bj<=50000000?($bj*0.05):($bj>500000000?(($bj-500000000)*0.30)+95000000:($bj>250000000?(($bj-250000000)*0.25)+32500000:($bj>50000000?((($bj-50000000)*0.15)+2500000):0))))),0);
            

            $pph_21_calc_pajak_setahun = $bk;
            $bl = ($bk / 12); // PAJAK PERBULAN , =BK4/12
            //  echo "pajak_perbulan = $bl <br>";
            $pph_21_calc_pajak_perbulan = $bl;

            $af = $ad; // PPH21

            $aj = round($row->ddc_f_kp); // FKP
            $ak = round($row->ddc_wcl); // Koperasi
            $al = round($row->ddc_wc); // Koperasi Wajib
            $am = round($row->ddc_dw); // DM ., Dharma wanita
            $an = round($row->ddc_tpt); // TPTGR
            $ao = round($row->ddc_wb); // REK AER
            $ap = ($ae * 0.025);  // ZAKAT , 2.5%*AE4

            // CEK ZAKAT
            $where_date_is_valid = "(eff_date <= '".$row->print_dt."' AND (term_date IS NULL OR term_date >= '".$row->print_dt."'))";

            $zk_must_set = $this->db->where('empl_id',$row->empl_id)
                                    ->where($where_date_is_valid,null,false)
                                    ->get('apr_empl_zk')
                                    ->num_rows() > 0;
            if(!$zk_must_set){
                $ap = 0;
            }                        
            // if($row->empl_gr == 'Dewan Pengawas'){
            //     $ap = 0;
            // }
            $row->ddc_zk = $ap;

            $acc_number = $this->db->where('empl_id',$row->empl_id)
                                    ->where($where_date_is_valid,null,false)
                                    ->order_by('eff_date','desc')
                                    ->get('apr_ref_acc_number')
                                    ->row();
            if(!empty($acc_number)){
                $row->acc_number = $acc_number->text;
            }                        
            
                                    
            $aq = round($row->ddc_shd);  // SHODAQOH

            $ar   = $af + $ag + $ah + $ai + $aj + $ak + $al + $am + $an + $ao + $ap + $aq + $ddc_bpjs_pen; // JUMLAH POTONGAN , =SUM(AF4:AQ4)
            
            // $row->ddc_amt = $ar;     

            $as   = $ae - $ar; // GAJI DITERIMA
            $row->ddc_bpjs_pen = $ddc_bpjs_pen;
            $row->net_pay = $as;

            $aw   = 0; // ?

            $bn   = $as - $aw;

            
            $pph_21_calc = (object)[
                'gaji_bruto'    => $pph_21_calc_gaji_bruto,
                
                'potongan_astek' => $row->ddc_bpjs_ket,    
                'potongan_aspen' => $row->ddc_aspen,    
                'potongan_askes' => $row->ddc_bpjs_kes,  

                'pajak_bruto'   => $pph_21_calc_pajak_bruto,

                'biaya_jabatan' => $pph_21_calc_biaya_jabatan,
                'biaya_astek_askes_aspen' => ($row->ddc_bpjs_kes + $row->ddc_bpjs_ket + $row->ddc_aspen + $row->ddc_bpjs_pen),
                'total_pengurang' => $pph_21_calc_total_pengurang,
                'pajak_netto'   => $pph_21_calc_pajak_netto,
                'pajak_disetahunkan' => $pph_21_calc_pajak_disetahunkan,
                'ptkp' => $pph_21_calc_ptkp,
                'nilai_kena_pajak' => $pph_21_calc_nilai_kena_pajak,
                'pajak_setahun' => $pph_21_calc_pajak_setahun,
                'pajak_perbulan' =>  $pph_21_calc_pajak_perbulan ,
                // 'bn' => $bn
            ];    
            


            if($bl == $ad || $bl <= 0){
                $row->tax_netto  = $pph_21_calc_pajak_netto;
                $row->tax_annual = $pph_21_calc_pajak_setahun;
                $row->pph21_tax  = $pph_21_calc_pajak_perbulan;
                $row->gross_sal_tax = $pph_21_calc_pajak_bruto;
                $row->tax_base = $pph_21_calc_pajak_disetahunkan;
                $stop = true;
            } 
        }
        if($update){
            // $row->lock = 1;
            // echo json_encode($row) . '<br/>' . "\n";
            
            $this->db->where('id',$pk)->update('apr_sv_payslip',$row);

        }
    }

    protected function init_archive_table ($curyear) {
        $mod = $curyear % 10;
        $year = $curyear - $mod;
        
        $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS  `apr_sv_payslip_archive_{$year}` (
    `archive_id` int(20) NOT NULL AUTO_INCREMENT,
    `archived_at` datetime DEFAULT NULL,
    `archived_by` int(20) NOT NULL,
    `id` int(20) NOT NULL,
    `print_dt` date DEFAULT NULL COMMENT 'Printed date - Periodical Report Group',
    `empl_id` int(20) DEFAULT NULL COMMENT 'Employee ID for DB',
    `nipp` varchar(20) DEFAULT NULL COMMENT 'Official Employee ID',
    `empl_name` varchar(50) DEFAULT NULL COMMENT 'Employee Name',
    `job_unit` varchar(100) DEFAULT NULL,
    `job_title` varchar(100) DEFAULT NULL,
    `pdm_eff_date` date DEFAULT NULL COMMENT 'Promotion,  Demotion and Mutation Effective Date',
    `attn_s` varchar(20) DEFAULT '0' COMMENT 'Attendance Code S',
    `attn_i` varchar(20) DEFAULT '0' COMMENT 'Attendance Code I',
    `attn_a` varchar(20) DEFAULT '0' COMMENT 'Attendance Code A',
    `attn_l` varchar(20) DEFAULT '0' COMMENT 'Attendance Code L',
    `attn_c` varchar(20) DEFAULT '0' COMMENT 'Attendance Code C',
    `attn_t` varchar(20) DEFAULT '0' COMMENT 'Attendance Code T',
    `alw_work_day` int(2) DEFAULT '22' COMMENT 'Allowance Day on Current Month',
    `work_day` int(2) DEFAULT '22' COMMENT 'Work Day on Current Month',
    `empl_work_day` int(2) DEFAULT '22' COMMENT 'Attend Day on Current Month',
    `base_sal_id` int(11) DEFAULT NULL COMMENT 'Base Salary ID on m_gaji_pokok',
    `base_sal` double DEFAULT NULL COMMENT 'Base Salary',
    `base_sal_perhour` double DEFAULT NULL COMMENT 'Base Salary per Hour',
    `gross_sal` double DEFAULT NULL COMMENT 'Brutto',
    `gross_sal_tax` double DEFAULT NULL COMMENT 'Brutto for Tax',
    `net_pay` double DEFAULT NULL COMMENT 'Take home pay',
    `alw_mar_check` tinyint(2) DEFAULT NULL COMMENT '{0: tidak dapat, 1: dapat} Marital Allowance',
    `alw_mar` double DEFAULT NULL COMMENT 'Marital Allowance',
    `alw_ch` double DEFAULT NULL COMMENT 'Children Allowance',
    `alw_rc` double DEFAULT NULL COMMENT 'Rice Allowance',
    `alw_rc_ch_cnt` int(2) DEFAULT '0' COMMENT 'Children count for Rice Allowance',
    `alw_rc_sp_cnt` int(1) DEFAULT '0' COMMENT 'Spouse count for Rice Allowance',
    `alw_adv` double DEFAULT NULL COMMENT 'Advance Allowance',
    `alw_wt` double DEFAULT NULL COMMENT 'Water Allowance',
    `alw_jt` double DEFAULT NULL COMMENT 'Job Title Allowance',
    `alw_jt_tax` double DEFAULT NULL COMMENT 'Job Title Allowance for Tax',
    `alw_fd` double DEFAULT NULL COMMENT 'Lunch Allowance',
    `alw_fd_set` tinyint(1) DEFAULT '1',
    `alw_fd_perday` double DEFAULT '0' COMMENT 'Lunch Allowance per day',
    `alw_rs` double DEFAULT NULL COMMENT 'Residence Allowance',
    `alw_ot` double DEFAULT NULL COMMENT 'Overtime Allowance',
    `alw_tr` double DEFAULT NULL COMMENT 'Transportation Allowance',
    `alw_tr_set` tinyint(1) DEFAULT '1',
    `alw_tr_perday` double DEFAULT '0' COMMENT 'Transportation Allowance per day per day',
    `alw_prf` double DEFAULT NULL COMMENT 'Performance Allowance',
    `alw_prf_set` tinyint(1) DEFAULT '1',
    `alw_prf_perday` double DEFAULT '0' COMMENT 'Performance Allowance per day',
    `alw_sh` double DEFAULT NULL COMMENT 'Work Shift Allowance',
    `alw_vhc_rt` double DEFAULT NULL COMMENT 'Vehicle Rental Allowance',
    `alw_tpp` double DEFAULT NULL COMMENT 'TPP Allowance',
    `alw_tpp_remark` varchar(255) DEFAULT NULL COMMENT 'TPP Allowance Remarks',
    `alw_pph21` double DEFAULT NULL COMMENT 'PPh21 Allowance',
    `apr_ref_ptkp_tariff_id` int(11) DEFAULT NULL,
    `ptkp_tariff` double DEFAULT NULL COMMENT 'Tariff PTKP',
    `apr_ref_pph21_tariff_id` int(11) DEFAULT NULL,
    `pph21_tax` double DEFAULT NULL COMMENT 'Tariff Pph 21',
    `tax_ddc_jt` double DEFAULT NULL COMMENT 'Job Title for Tax Deduction',
    `tax_ddc_jht` double DEFAULT NULL COMMENT 'JHT for Tax Deduction',
    `tax_ddc_jp` double DEFAULT NULL COMMENT 'JP for Tax Deduction',
    `tax_ddc` double DEFAULT NULL COMMENT 'Tax Deduction',
    `tax_netto` double DEFAULT NULL COMMENT 'Net Pay for Tax',
    `tax_base` double DEFAULT NULL COMMENT 'Basic amount  for Tax calculation',
    `tax_annual` double DEFAULT NULL COMMENT 'Tax in a year',
    `alw_amt` double DEFAULT NULL COMMENT 'Total Allowance Amount',
    `ddc_pph21` double DEFAULT NULL COMMENT 'PPh21 Deduction',
    `empl_npwp` varchar(100) DEFAULT NULL COMMENT 'NPWP',
    `ddc_bpjs_ket` double DEFAULT NULL COMMENT 'BPJS Ketenagakerjaan Deduction',
    `ddc_bpjs_kes` double DEFAULT NULL COMMENT 'BPJS Kesehatan Deduction',
    `ddc_aspen` double DEFAULT NULL COMMENT 'ASPEN Deduction',
    `ddc_f_kp` double DEFAULT NULL COMMENT 'F-KP Deduction',
    `empl_fkp` int(11) DEFAULT NULL COMMENT 'FKP Member',
    `ddc_wcl` double DEFAULT NULL COMMENT 'Worker Cooperative Loan Deduction',
    `ddc_wc` double DEFAULT NULL COMMENT 'Worker Cooperative Obligatory Deposit Deduction',
    `empl_wc` int(1) DEFAULT '0' COMMENT 'Worker Cooperative Member',
    `ddc_dw` double DEFAULT NULL COMMENT 'DHARMA WANITA Deduction',
    `empl_dw` int(1) DEFAULT NULL COMMENT 'DHARMA WANITA Member',
    `ddc_zk` double DEFAULT NULL COMMENT 'ZAKAT Deduction',
    `empl_zk` int(1) DEFAULT NULL COMMENT 'ZAKAT Member',
    `ddc_shd` double DEFAULT NULL COMMENT 'SHODAQOH Deduction',
    `ddc_tpt` double DEFAULT NULL COMMENT 'TPTGR Deduction',
    `ddc_tpt_remark` varchar(255) DEFAULT NULL COMMENT 'TPTGR Deduction Notes',
    `ddc_wb` double DEFAULT NULL COMMENT 'Water Bill Deduction',
    `empl_wb` int(1) DEFAULT NULL,
    `ddc_bpjs_pen` double DEFAULT NULL COMMENT 'BPJS Pension Deduction',
    `bpjs_pen_max` double DEFAULT '8512400' COMMENT 'BPJS Pension Maximum',
    `bpjs_pen_maxage` double DEFAULT NULL COMMENT 'BPJS Pension Maximum Age',
    `bpjs_pen_tariff` double DEFAULT NULL COMMENT 'BPJS Pension Tariff',
    `ddc_amt` double DEFAULT NULL COMMENT 'Deduction Amount',
    `ptkp_amt` double DEFAULT NULL COMMENT 'PTKP Amount',
    `gender` varchar(20) DEFAULT NULL,
    `pob` varchar(50) DEFAULT NULL COMMENT 'Place of Birth',
    `dob` date DEFAULT NULL COMMENT 'Date of Birth',
    `empl_stat` varchar(50) DEFAULT NULL COMMENT 'Employement Status',
    `empl_gr` varchar(50) DEFAULT NULL COMMENT 'Employement Group',
    `mar_stat` varchar(20) DEFAULT NULL COMMENT 'Marital Status',
    `child_cnt` tinyint(2) DEFAULT '0' COMMENT 'Child count',
    `hire_date` date DEFAULT NULL,
    `los` int(11) DEFAULT NULL COMMENT 'Length of Service in year',
    `grade_id` int(11) DEFAULT NULL COMMENT 'kode_golongan on r_peg_golongan',
    `grade` varchar(50) DEFAULT NULL,
    `lock` int(1) DEFAULT '1' COMMENT 'No Update',
    `created` datetime DEFAULT NULL,
    `modified` datetime DEFAULT NULL,
    `kode_peringkat` varchar(100) DEFAULT NULL,
    `lama_kontrak` int(1) DEFAULT NULL,
    `base_sal_tmp` double DEFAULT NULL,
    `kode_unor` varchar(25) DEFAULT NULL,
    `acc_number` varchar(50) DEFAULT NULL,
    PRIMARY KEY (`archive_id`) USING BTREE,
    KEY `id` (`id`) USING BTREE,
    KEY `print_dt` (`print_dt`) USING BTREE,
    KEY `empl_id` (`empl_id`) USING BTREE,
    KEY `nipp` (`nipp`) USING BTREE,
    KEY `apr_ref_pph21_tariff_id` (`apr_ref_pph21_tariff_id`) USING BTREE
    ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='Sheet View of Employee''s Pay Slip'

SQL;

        $this->db->query($sql);
        return 'apr_sv_payslip_archive_'. $year;
    }

    public function set_archive($ym, $backurl) {
        $y = (int) substr($ym, 0,4);
        $m = (int) substr($ym, 4,2);
       
        if($y < 2016) {
            die('Invalid year!');
        }
        if($y > 9999) {
            die('Invalid year!!');
        }
        if($m < 1) {
            die('Invalid month!');
        }
        if($m > 12) {
            die('Invalid month!!');
        }
        
        $month = substr(($m + 1000), 2,2);
        $print_dt = date('Y-m-t', strtotime($y . '-' . $month . '-01'));
        $table = $this->init_archive_table($y);
        // echo $print_dt;
        $where = " WHERE `print_dt` = '{$print_dt}' ";
        $sess = $this->session->userdata('logged_in');
        $uid  = $sess['id_user'];
        $select = "NULL, NOW(), {$uid},`id`,";
        $lock = 1;
        $table_ref = 'apr_sv_payslip';
        // insert into archive year table
        $this->db->query($this->generate_insert_query_archive($table, $select, $lock, $where,$table_ref));
        // delete apr_sv_payslip
        $this->db->query(" DELETE FROM `apr_sv_payslip` {$where}");
        // truncate archive
        $this->db->query("TRUNCATE `apr_sv_payslip_archive`");
        // insert into archive table
        $table = 'apr_sv_payslip_archive';
        $select = "NULL,";
        $lock = "`lock`";
        $where = "";
        $this->db->query($this->generate_insert_query_archive($table, $select, $lock, $where, $table_ref));
        // lock 
        $this->db->query("TRUNCATE `apr_sv_payslip`");
        // put back
        $table = 'apr_sv_payslip';
        $table_ref = 'apr_sv_payslip_archive';
        $select = "NULL,";
        $lock = "`lock`";
        $where = "";
        $this->db->query($this->generate_insert_query_archive($table, $select, $lock, $where, $table_ref));
        // truncate archive
        $this->db->query("TRUNCATE `apr_sv_payslip_archive`");

        echo "Success!!<br>";
        $a = sprintf('<a href="%s">Reload</a>', $backurl);
        die($a);
    }

    protected function generate_insert_query_archive($table, $select, $lock, $where, $table_ref) {
        $sql = <<<SQL
            INSERT INTO {$table} 
            (SELECT 
            {$select}
            `print_dt`,
            `empl_id`,
            `nipp`,
            `empl_name`,
            `job_unit`,
            `job_title`,
            `pdm_eff_date`,
            `attn_s`,
            `attn_i`,
            `attn_a`,
            `attn_l`,
            `attn_c`,
            `attn_t`,
            `alw_work_day`,
            `work_day`,
            `empl_work_day`,
            `base_sal_id`,
            `base_sal`,
            `base_sal_perhour`,
            `gross_sal`,
            `gross_sal_tax`,
            `net_pay`,
            `alw_mar_check`,
            `alw_mar`,
            `alw_ch`,
            `alw_rc`,
            `alw_rc_ch_cnt`,
            `alw_rc_sp_cnt`,
            `alw_adv`,
            `alw_wt`,
            `alw_jt`,
            `alw_jt_tax`,
            `alw_fd`,
            `alw_fd_set`,
            `alw_fd_perday`,
            `alw_rs`,
            `alw_ot`,
            `alw_tr`,
            `alw_tr_set`,
            `alw_tr_perday`,
            `alw_prf`,
            `alw_prf_set`,
            `alw_prf_perday`,
            `alw_sh`,
            `alw_vhc_rt`,
            `alw_tpp`,
            `alw_tpp_remark`,
            `alw_pph21`,
            `apr_ref_ptkp_tariff_id`,
            `ptkp_tariff`,
            `apr_ref_pph21_tariff_id`,
            `pph21_tax`,
            `tax_ddc_jt`,
            `tax_ddc_jht`,
            `tax_ddc_jp`,
            `tax_ddc`,
            `tax_netto`,
            `tax_base`,
            `tax_annual`,
            `alw_amt`,
            `ddc_pph21`,
            `empl_npwp`,
            `ddc_bpjs_ket`,
            `ddc_bpjs_kes`,
            `ddc_aspen`,
            `ddc_f_kp`,
            `empl_fkp`,
            `ddc_wcl`,
            `ddc_wc`,
            `empl_wc`,
            `ddc_dw`,
            `empl_dw`,
            `ddc_zk`,
            `empl_zk`,
            `ddc_shd`,
            `ddc_tpt`,
            `ddc_tpt_remark`,
            `ddc_wb`,
            `empl_wb`,
            `ddc_bpjs_pen`,
            `bpjs_pen_max`,
            `bpjs_pen_maxage`,
            `bpjs_pen_tariff`,
            `ddc_amt`,
            `ptkp_amt`,
            `gender`,
            `pob`,
            `dob`,
            `empl_stat`,
            `empl_gr`,
            `mar_stat`,
            `child_cnt`,
            `hire_date`,
            `los`,
            `grade_id`,
            `grade`,
            {$lock},
            `created`,
            `modified`,
            `kode_peringkat`,
            `lama_kontrak`,
            `base_sal_tmp`,
            `kode_unor`,
            `acc_number` FROM `{$table_ref}`
            {$where}
            )
SQL;
        return $sql;
    }

    protected function set_tbl_by_archive() {
        // $this->rs_cf_cur_year  = $rs_cf_cur_year;
        // $this->rs_cf_cur_month = $rs_cf_cur_month;
        $table = $this->init_archive_table($this->rs_cf_cur_year);
        $print_dt = date('Y-m-t', strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month)));
        $q = $this->db->query("SELECT COUNT(`print_dt`) AS `cnt` from `{$table}` WHERE `print_dt`='{$print_dt}' ");
        $row = $q->row();
        if($row->cnt > 0) {
            $this->tbl = $table;
        }
        return $this->tbl;
    }

    public function get_filter_by_group($group_name, $print_dt = null) {
        $filter = $this->_get_filter_by_group($group_name, $print_dt);
        $filter_sql = '';
        if ($filter) {
            $filter_sql = '';
            $filter_arr = array();
            foreach ($filter as $n => $val) {
                $val->operator = $val->value == null && $val->operator == '!=' ? 'IS NOT' : $val->operator;
                $val->value    = $val->value == null ? 'NULL' : "'" . $val->value . "'";

                $filter_arr [] = $val->field_name . ' ' . $val->operator . " " . $val->value;
            }

            $filter_sql .= implode(' AND ', $filter_arr);
            $filter_sql .= '';
        }
        return $filter_sql;
    }

    protected function _get_filter_by_group($group_name, $print_dt = null) {
        if (!$print_dt) {
            $print_dt = date('Y-m-t');
        }

        $tbl = 'apr_payslip_group';
        $this->db->select('id');
        $this->db->where('name', $group_name);
        $this->db->where('active_status', 1);
        $this->db->from($tbl);
        $rs  = $this->db->get()->result();

        $res = array();
        if (!isset($rs[0])) {
            return $res;
        }
        $group_id = $rs[0]->id;

        $tbl = 'apr_payslip_group_detail';
        $this->db->select('field_name, operator, value');
        $this->db->where('apr_payslip_group_id', $group_id);
        $this->db->where('active_status', 1);
        $this->db->where('eff_date <=', $print_dt);
        $this->db->where("IF(term_date is NULL, true, term_date >= '{$print_dt}')", null, false);
        $this->db->from($tbl);
        $rs  = $this->db->get()->result();
        if (!$rs) {
            return $res;
        }
        return $rs;
    }

    public function get_archive_table($y, $m) { 
        $table = $this->init_archive_table($y);
        $print_dt = date('Y-m-t', strtotime(sprintf('%s-%s-01', $y, $m)));
        $q = $this->db->query("SELECT COUNT(`print_dt`) AS `cnt` from `{$table}` WHERE `print_dt`='{$print_dt}' ");
        $row = $q->row();
        $tbl ='apr_sv_payslip';
        if($row->cnt > 0) {
            $tbl = $table;
        }
        return $tbl;        
    }
}
