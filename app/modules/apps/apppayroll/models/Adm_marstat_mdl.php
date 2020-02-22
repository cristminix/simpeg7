<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Marstat_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst = 'payslip_mdl';
    public $tbl              = 'r_pegawai';
    public $tbl_marstat      = 'apr_adm_marstat';
    public $tbl_payslip      = 'apr_sv_payslip';
    public $tbl_r_pegawai    = 'r_pegawai';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $custom_filter_print_dt_field = 'apr_adm_marstat.print_dt';
    public $rs_field_list    = array(
        '1' => 'nipp',
        'name',
        'text',
        'mar_stat',
        'alw_rc_sp_cnt',
        'annotation',
    );
    public $rs_masked_field_list    = array(
        '1' => 'NIPP',
        'Name',
        'Active Spouse',
        'Active Status',
        'Rice Alw. Stat.',
        'Notes',
    );
    public $rs_masked_search_fields = array(
        '1' => 'r_pegawai.nip_baru',
        'r_pegawai.nama_pegawai',
        'apr_adm_marstat.text',
        'apr_adm_marstat.mar_stat',
        'apr_adm_marstat.alw_rc_sp_cnt',
        'apr_adm_marstat.annotation',
    );
    public $rs_use_form_filter      = 'apr_adm_marstat';
    public $rs_select               = "*";
    public $rs_order_by             = null;
    public $rs_common_views         = array(
        /* date_field_list */
        'date_field_list' => array(
            'eff_date'  => 'd/m/Y',
        )
    );
    public $rs_index_where          = "";

    protected function _update_payslip() {
        $payslip_mdl = $this->payslip_mdl_inst;
        $this->load->model($payslip_mdl);
        $this->{$payslip_mdl}->get_update_all_deduction();
    }
    public function fetch_data($cur_page = 1, $per_page = 10, $order_by = null, $sort_order = null) {
        $res = parent::fetch_data($cur_page, $per_page, $order_by, $sort_order);
        // debug($this->db->last_query());
        return $res;
    }
    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        if (method_exists($this, 'set_joins')) {
            $this->set_joins();
        }
        if (method_exists($this, 'set_rs_select')) {
            $this->set_rs_select();
        }

        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        $this->db->where('id', $id);
        $this->db->where($this->rs_index_where, null, false);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }    
    
    public function delete_row_by_id($id) {
        $detail = $this->fetch_detail($id);

        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->set('npwp', NULL);
        $this->db->set('reg_date', NULL);
        $this->db->set('text', NULL);
        $this->db->update($this->tbl);

        if ($this->db->affected_rows()) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();

                return array('error' => lang('Delete has failed'));
            } else {
                $this->_unset_npwp($detail->empl_id, $detail->reg_date);
                $this->db->trans_commit();
//$this->_update_payslip();
                return array('success' => lang('Delete success'));
            }
        }
        $this->db->trans_rollback();
        return array('error' => lang('Delete has failed'));
    }

    public function get_rs_action() {

        $r_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');

        $rs_cf_cur_date  = strtotime(sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month));
        
        $rs_cf_cur_month = date('F', $rs_cf_cur_date);
        $dl_title = '<span class="fa fa-refresh fa-fw"></span> ';

        $dl_title .= lang('Sync') .sprintf(' %s %s', $this->rs_cf_cur_year, lang(ucfirst($rs_cf_cur_month)));

        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    //                    'a' => array(
                    //                        'url'  => sprintf($r_url, md5('new' . date('ymd'))),
                    //                        'text' => '<span class="fa fa-plus  "></span> ' . lang('Add new'),
                    ////                        'a_class' => 'btn btn-sm btn-primary',
                    //                    ),
                    
                    'sync' => array(
                        'url'     => sprintf($r_url, md5('sync' . date('ymd'))),
                        'text'    => $dl_title,
                        'a_class' => 'btn-info',
                    )
                ),
                // 'action_list' => array(
                //     'e' => array(
                //         'url'  => $r_url,
                //         'text' => '<span class="fa fa-list text-warning"></span>',
                //     ),
                // ),
            )
        );
        return $action;
    }

    public function get_detail_by_empl_id($empl_id) {
        //Max
        $sql_str = <<<SQL
            SELECT 
                r_pegawai.id_pegawai as id, 
                r_pegawai.nip_baru as nipp, 
                r_pegawai.nama_pegawai as name, 
                marjoin.mar_stat as mar_stat,
                marjoin.eff_date as eff_date, 
                marjoin.term_date as term_date,
                marjoin.annotation as annotation, 
                marjoin.text as text, 
                marjoin.alw_rc_sp_cnt as alw_rc_sp_cnt
            FROM (`r_pegawai`)
            LEFT JOIN (
                SELECT empl_id,mar_stat, eff_date, term_date, annotation, text, alw_rc_sp_cnt
                FROM apr_adm_marstat 
                WHERE empl_id='{$empl_id}'
                ORDER BY eff_date DESC
                LIMIT 1
            ) AS marjoin
                ON `marjoin`.`empl_id`=`r_pegawai`.`id_pegawai`
            WHERE `r_pegawai`.`id_pegawai` =  '{$empl_id}'
SQL;
        $res     = $this->db->query($sql_str)->result();
        if (!isset($res[0])) {
            return $res;
        }
        return $res[0];
    }

    public function set_joins_bak() {
        $tbl_marstat       = $this->tbl_marstat;
        $tbl               = $this->tbl;
        $join_on           = <<<JOIN
            {$tbl_marstat}.empl_id={$tbl}.id_pegawai
            AND {$tbl_marstat}.active_status=1

JOIN;
        $joins             = array(
            array(
                "(
                SELECT 
                apr_adm_marstat.print_dt,
                apr_adm_marstat.empl_id, apr_adm_marstat.mar_stat, 
                apr_adm_marstat.eff_date, apr_adm_marstat.term_date, apr_adm_marstat.annotation, apr_adm_marstat.text, apr_adm_marstat.alw_rc_sp_cnt
                FROM apr_adm_marstat 
                INNER JOIN (
  SELECT empl_id, MAX(eff_date) AS max_eff
  FROM apr_adm_marstat GROUP BY empl_id
) AS max_mar ON apr_adm_marstat.empl_id =max_mar.empl_id AND max_mar.max_eff = apr_adm_marstat.eff_date 
                GROUP BY apr_adm_marstat.empl_id
                
            ) AS {$tbl_marstat}",
                $join_on,
                'left'
            )
        );
        $this->rs_joins    = $joins;
        $this->rs_group_by = "{$tbl}.id_pegawai";
    }

    public function set_joins() {
        $tbl_marstat       = $this->tbl_marstat;
        $tbl               = $this->tbl;
        $join_on           = <<<JOIN
            {$tbl_marstat}.empl_id={$tbl}.id_pegawai
            AND {$tbl_marstat}.active_status=1

JOIN;
        $joins             = array(
            array(
                " {$tbl_marstat} ",
                $join_on,
                'left'
            )
        );
        $this->rs_joins    = $joins;
        $this->rs_group_by = "{$tbl}.id_pegawai";
    }


    public function set_rs_select() {
//        '1' => 'nipp',
//        'name',
//        'text',
//        'mar_stat',
//        'alw_rc_sp_cnt',
//        'eff_date',
//        'term_date',
//        'annotation',
        $this->rs_select = $this->tbl . '.id_pegawai as id';
        $this->rs_select .= ',' . $this->tbl . '.nip_baru as nipp';
        $this->rs_select .= ',' . $this->tbl . '.nama_pegawai as name';
        $this->rs_select .= ',' . $this->tbl_marstat . '.mar_stat as mar_stat';
        $this->rs_select .= ', MAX(' . $this->tbl_marstat . '.eff_date) as eff_date';
        $this->rs_select .= ', MAX(' . $this->tbl_marstat . '.term_date) as term_date';
        $this->rs_select .= ',' . $this->tbl_marstat . '.annotation as annotation';
        $this->rs_select .= ',' . $this->tbl_marstat . '.text as text';
        $this->rs_select .= ',' . $this->tbl_marstat . '.alw_rc_sp_cnt as alw_rc_sp_cnt';
        $this->rs_select .= ',' . $this->tbl_marstat . '.print_dt as print_dt';
    }

    public function custom_filter_result(&$db)
    {
        $field = isset($this->custom_filter_print_dt_field) ? $this->custom_filter_print_dt_field: 'print_dt';

        $db->where(sprintf('YEAR(%s)', $field), $this->rs_cf_cur_year, false);
        $db->where(sprintf('MONTH(%s)', $field), $this->rs_cf_cur_month, false);
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

    public function init_by_ym() {
        

        $first_mo = sprintf('%s-%s-01', $this->rs_cf_cur_year, $this->rs_cf_cur_month);
        $time = strtotime($first_mo);
        $print_dt = date('Y-m-t', $time);
        printf('<pre>');
        printf("Delete Current Record for %s\n", $print_dt);
        $tbl = 'apr_adm_marstat';
        $this->db
            ->where(['print_dt' => $print_dt])->delete($tbl);
        printf("Executing Query:\n%s\n", $this->db->last_query());
        printf("Affected Rows: %s\n",$this->db->affected_rows());
        $this->db->query("ALTER TABLE {$tbl} AUTO_INCREMENT=0");
        printf("Executing Query:\n%s\n", $this->db->last_query());
        printf("Syncronizing for %s\n", $print_dt);
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
        printf("Executing Query:\n%s\n", $this->db->last_query());
        printf("Row Count: %s\n",$rs->num_rows());
        $insert = <<<INS
        INSERT INTO {$tbl} {$sel_q}
INS;
        $this->db->query($insert);
        printf("Executing Query:\n%s\n", $this->db->last_query());
        printf("Affected Rows: %s\n",$this->db->affected_rows());
        printf('</pre>');
        printf('<a href="%s">%s</a>',$_SERVER['HTTP_REFERER'], '&gt;&gt; Back');
    }
}
