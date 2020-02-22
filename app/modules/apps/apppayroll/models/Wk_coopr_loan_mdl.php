<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Wk_Coopr_Loan_Mdl extends Apppayroll_Frontmdl {

    public $tbl                  = 'apr_sv_empl_wcl';
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list        = array(
        '1' => 'nipp',
        'empl_name',
        'obl_dep_amt',
        'mo_amt',
        'modified',
    );
    public $rs_masked_field_list = array(
        '1' => 'NIPP',
        'Name',
        'Obligatory Deposit',
        'Monthly Payment',
        'Last update',
    );
    public $rs_use_form_filter   = 'wk_coopr_loan';
    public $rs_select            = "*";
    public $rs_order_by          = null;
    public $rs_common_views = array(
        /* call_user_func */
        'call_user_func' => array(
            'gender'            => array(
                'callable' => 'strtoupper',
                'args'     => array()
            ),
            'tempat_lahir'      => array(
                'callable' => 'strtoupper',
                'args'     => array()
            ),
            'agama'             => array(
                'callable' => 'strtoupper',
                'args'     => array()
            ),
            'status_pegawai'    => array(
                'callable' => 'strtoupper',
                'args'     => array()
            ),
            'status_perkawinan' => array(
                'callable' => 'strtoupper',
                'args'     => array()
            )
        ),
        'currency_field_list' => array(
            'obl_dep_amt',
            'mo_amt',
        )
    );

    public function fetch_detail($eid) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->db->where('id_pegawai', $eid);
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
        $db->where('YEAR(paid_date)', $this->rs_cf_cur_year, false);
        $db->where('MONTH(paid_date)', $this->rs_cf_cur_month, false);
    }

}
