<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Zkt_Sh_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'apr_sv_empl_zs';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list        = array(
        '1' => 'print_dt',
        'nipp',
        'empl_name',
        'job_unit',
        'job_title',
        'zakat_amt',
        'shodaqoh_amt',
        'hire_date',
        'los', // length of service
    );
    public $rs_masked_field_list = array(
        '1' => 'Print Date',
        'NIPP',
        'Name',
        'Job Unit',
        'Job Title',
        'Zakat',
        'Shodaqoh',
        'Hire Date',
        'Length of Service',
    );
    public $rs_use_form_filter   = 'apr_sv_empl_zs';
    public $rs_select            = "*";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'zakat_amt',
            'shodaqoh_amt',
        ),
        'cell_alignments'     => array(
            'print_dt'     => 'right',
            'zakat_amt'    => 'right',
            'shodaqoh_amt' => 'right',
            'hire_date'    => 'right',
            'los'          => 'right',
        )
    );

    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->db->where('id', $id);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function get_custom_filter_config() {
        $res        = array();
        $res['tpl'] = 'elements/scaffolding/custom_filter_year_month';
        return $res;
    }

    public function get_custom_filter_data() {
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

    public function get_rs_action() {
        $r_url  = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-edit fa-border fa-fw"><span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function handle_custom_filter($input = array()) {
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

    public function custom_filter_result(&$db) {
        $db->where('YEAR(print_dt)', $this->rs_cf_cur_year, false);
        $db->where('MONTH(print_dt)', $this->rs_cf_cur_month, false);
    }

    public function generate_sv_data($year, $month) {
        $this->load->model($this->payslip_mdl_inst);
        $this->{$this->payslip_mdl_inst}->generate_sv_data($year, $month);
        $this->db->from($this->tbl);
        $this->db->where('YEAR(print_dt)', $year, false);
        $this->db->where('MONTH(print_dt)', $month, false);
        $this->db->limit(1);
        $rs = $this->db->get();
        if ($rs->num_rows() > 0) {
            return true;
        }
        $lastdate = date('t', strtotime($year . '-' . $month . '-01'));
        $sqlstr   = <<<SQL
            INSERT INTO apr_sv_empl_zs (
                print_dt,
                empl_id,
                nipp,
                empl_name,
                hire_date
            )
                SELECT 
                    '{$year}-{$month}-{$lastdate}',
                    id_pegawai,
                    nip_baru,
                    nama_pegawai,
                    tgl_terima
                FROM r_pegawai
                    WHERE tgl_terima <= '{$year}-{$month}-{$lastdate}';
    
SQL;
        $query    = $this->db->query($sqlstr);
        $sqlstr   = <<<UPDATE
            
            UPDATE apr_sv_empl_zs r
            INNER JOIN (
                SELECT 
                    a.sk_tanggal, 
                    a.id_pegawai, 
                    a.nama_unor, 
                    a.nama_jabatan, 
                    a.nomenklatur_pada 
                FROM r_peg_jab a
                    INNER JOIN (
                    SELECT 
                        id_pegawai, 
                        count(id_pegawai) cnt, 
                        sk_tanggal, 
                        max(sk_tanggal) maxsk
                    FROM `r_peg_jab` 
                    WHERE
                        sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                    GROUP BY id_pegawai 
                    ORDER BY 
                        id_pegawai, 
                        sk_tanggal DESC
                ) b
                ON 
                    a.id_pegawai=b.id_pegawai
                    AND
                    a.sk_tanggal = b.maxsk
                    AND
                    a.sk_tanggal <= '{$year}-{$month}-{$lastdate}'
                ORDER BY 
                    a.id_pegawai, 
                    a.sk_tanggal DESC
            ) ab
            ON r.empl_id = ab.id_pegawai
            SET 
                r.job_unit = ab.nama_unor, 
                r.job_title = ab.nama_jabatan,
                r.created = NOW(),
                r.modified = NOW()
            WHERE r.print_dt='{$year}-{$month}-{$lastdate}';

UPDATE;

        $query = $this->db->query($sqlstr);
    }

    public function update_row_by_id($id, $data, $where = array()) {
        
        
        $now = date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        $this->db->where($where);
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $data);

        //

        $row = $this->db->where($where)
                        ->where('id',$id)
                        ->get($this->tbl)
                        ->row();
        if(!empty($row)){
            $data = [
                'ddc_zk'   => $row->zakat_amt,
                'ddc_shd'  => $row->shodaqoh_amt
            ];

            $this->db->where('print_dt',$row->print_dt)
                     ->where('empl_id',$row->empl_id)
                     ->update('apr_sv_payslip', $data);
            return 1;
        }
    }

}
