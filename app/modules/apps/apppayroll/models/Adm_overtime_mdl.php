<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;
require_once 'payslip_mdl' . EXT;

class Adm_Overtime_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'apr_sv_payslip';
    public $rs_confirm_list      = array();
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list        = array(
        '1' => 'print_dt',
        'nipp',
        'empl_name',
        'job_unit',
        'job_title',
        'alw_ot',
    );
    public $rs_masked_field_list = array(
        '1' => 'Print Date',
        'NIPP',
        'Name',
        'Job Unit',
        'Job Title',
        'Overtime Allowance',
    );
    public $rs_use_form_filter   = 'apr_sv_payslip';
    public $rs_select            = "*, `lock` `locked`";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'alw_ot',
        ),
        'cell_nowrap'         => array(
            'print_dt',
            'nipp',
            'empl_name',
            'alw_ot',
        ),
        'date_field_list'     => array(
            'print_dt' => 'd/m/Y',
        )
    );
    
    public function fetch_all_overtime() {
        $this->db->from($this->tbl);
        
        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        if ($this->rs_index_where) {
            $this->db->where($this->rs_index_where, null, false);
        }
        $this->filter_result($this->db);
        if (method_exists($this, 'custom_filter_result')) {
            $this->custom_filter_result($this->db);
        }
        $this->db->order_by('nipp + 0');
        $this->db->order_by('empl_name');
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);

        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        $this->db->where('id', $id);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function fetch_ids_by_empl_id_print_dt($empls_id, $print_dt){
        $this->db->from($this->tbl);
        $this->db->select('id, empl_id');
        $this->db->where('lock', 0);
        $this->db->where('print_dt', $print_dt);
        $this->db->where_in('empl_id', $empls_id);
        $rs = $this->db->get();
       
        if(!$rs){
            return array();
        }
        $res = $rs->result();
        if(!$res){
            return array();
        }
        $ids = array();
        foreach($res as $row){
            $ids[$row->empl_id] = $row->id;
        }
        return $ids;
    }
    
    public function generate_sv_data($year, $month) {
        $this->load->model($this->payslip_mdl_inst);
        $this->{$this->payslip_mdl_inst}->generate_sv_data($year, $month);
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
        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $dl_title .= lang('Overtime Download');
        $dl_title .= ' ';
        $dl_title .= $this->rs_cf_cur_year;
        $dl_title .= '-';
        $dl_title .= $this->rs_cf_cur_month;

        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $im_title .= lang('Overtime Import');
        $im_title .= ' ';
        $im_title .= $this->rs_cf_cur_year;
        $im_title .= '-';
        $im_title .= $this->rs_cf_cur_month;
        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    'dl' => array(
                        'url'  => sprintf($r_url, md5('dl-overtime-tpl' . date('ymd'))),
                        'text' => $dl_title,
                    ),
                    'im' => array(
                        'url'     => sprintf($r_url, md5('import' . date('ymd'))),
                        'text'    => $im_title,
                        'a_class' => 'btn-warning'
                    )
                ),
                'action_list' => array(
                    'e' => array(
                        'url'    => $r_url,
                        'text'   => '<span class="fa fa-edit fa-border"></span>',
                        'locked' => true,
                    ),
                    'd' => array(
                        'url'           => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text'          => '<span class="fa fa-eraser fa-border text-warning"></span>',
                        'show_by_field' => 'alw_ot',
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

    public function delete_overtime($id) {
        $now = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        $this->db->where('lock', 0);
        $this->db->set('alw_ot', NULL);
        $this->db->set('modified', $now);
        $this->db->update($this->tbl);
        $this->load->model('payslip_mdl');
        $row = $this->db->where('id', $id)->get('apr_sv_payslip')->row();
        $this->payslip_mdl->fix_pph21($row,$row->empl_stat);

        if ($this->db->affected_rows()) {
            return array('success' => lang('Delete success'));
        }
        return array('error' => lang('Delete has failed'));
    }

    public function update_batch_overtime($data, $key) {
        $this->db->update_batch($this->tbl, $data, $key);
        $this->load->model('payslip_mdl');
        foreach($data as $item){
            $row = $this->db->where('empl_id', $item['empl_id'])->get('apr_sv_payslip')->row();
            // echo json_encode($row) . "\n";
            if(!empty($row)){
                $this->payslip_mdl->fix_pph21($row,$row->empl_stat);
            }
        }
        // die('-------------------------');
        return $this->db->affected_rows();
    }
    
    public function update_overtime($id, $alw_ot) {
        $now = date('Y-m-d H:i:s');
        $this->db->set('alw_ot', $alw_ot);
        $this->db->set('modified', $now);
        $this->db->where('id', $id);
        $this->db->where('lock', 0);
        $this->db->update($this->tbl);

        $this->load->model('payslip_mdl');

        $row = $this->db->where('id', $id)->get('apr_sv_payslip')->row();
        $this->payslip_mdl->fix_pph21($row,$row->empl_stat);
        return $this->db->affected_rows();
    }

    public function set_joins() {
    }

    public function set_rs_select() {
    }

}
