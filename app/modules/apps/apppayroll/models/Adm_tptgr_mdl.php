<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Adm_Tptgr_Mdl extends Apppayroll_Frontmdl {

    public $payslip_mdl_inst     = 'payslip_mdl';
    public $tbl                  = 'apr_sv_payslip';
    public $tbl_app              = 'apr_adm_tptgr';
    public $rs_confirm_list      = array();
    public $rs_cf_cur_year;
    public $rs_cf_cur_month;
    public $rs_field_list        = array(
        '1' => 'print_dt',
        'nipp',
        'empl_name',
        'ddc_tpt',
        'ddc_tpt_remark',
        'job_unit',
        'job_title',
        'grade',
    );
    public $rs_masked_field_list = array(
        '1' => 'Print Date',
        'NIPP',
        'Name',
        'TPTGR',
        'TPTGR Remark',
        'Job Unit',
        'Job Title',
        'Grade',
    );
    public $rs_use_form_filter   = 'apr_sv_payslip';
    public $rs_select            = "*, `lock` `locked`";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'ddc_tpt',
        ),
        'cell_alignments'     => array(
//            'gaji_pokok'     => 'right',
        ),
        'date_field_list'     => array(
            'print_dt' => 'd/m/Y',
        )
    );

//    public function delete_row_by_id($id) {
//        $this->db->where('id_gaji_pokok', $id);
//        $this->db->delete($this->tbl);
//        if ($this->db->affected_rows()) {
//            return array('success' => lang('Delete success'));
//        }
//        return array('error' => lang('Delete has failed'));
//    }

    public function fetch_all_tptgr() {
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

        $rs = $this->db->get()->row();
        if (empty($rs)) {
            return array();
        }
        
        
        return $rs;
    }

    public function fetch_ids_by_empl_id_print_dt($empls_id, $print_dt) {
        $this->db->from($this->tbl);
        $this->db->select('id, empl_id');
        $this->db->where('lock', 0);
        $this->db->where('print_dt', $print_dt);
        $this->db->where_in('empl_id', $empls_id);
        $rs = $this->db->get();

        if (!$rs) {
            return array();
        }
        $res = $rs->result();
        if (!$res) {
            return array();
        }
        $ids = array();
        foreach ($res as $row) {
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
        $r_url    = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $dl_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $dl_title .= lang('TPTGR Download');
        $dl_title .= ' ';
        $dl_title .= $this->rs_cf_cur_year;
        $dl_title .= '-';
        $dl_title .= $this->rs_cf_cur_month;

        $im_title = '<span class="fa fa-file-excel-o fa-fw"></span> ';
        $im_title .= lang('TPTGR Import');
        $im_title .= ' ';
        $im_title .= $this->rs_cf_cur_year;
        $im_title .= '-';
        $im_title .= $this->rs_cf_cur_month;
        $action   = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id',
                'action_top'  => array(
                    'dl' => array(
                        'url'  => sprintf($r_url, md5('dl-tptgr-tpl' . date('ymd'))),
                        'text' => $dl_title,
                    ),
                    'im' => array(
                        'url'     => sprintf($r_url, md5('import' . date('ymd'))),
                        'text'    => $im_title,
                        'a_class' => 'btn-warning'
                    )
                ),
                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
                    'e' => array(
                        'url'    => $r_url,
                        'text'   => '<span class="fa fa-edit fa-border"></span>',
                        'locked' => true,
                    ),
                    'd' => array(
                        'url'           => sprintf($r_url, md5('del' . date('ymd')) . '/%s'),
                        'text'          => '<span class="fa fa-eraser fa-border text-warning"></span>',
                        'show_by_field' => 'ddc_tpt',
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

    public function delete_tptgr($id) {
        $rowx = $this->db->where('apr_sv_payslip_id',$id)
                            ->get($this->tbl_app)
                            ->row();
            // die($this->db->last_query());                
        if(!empty($rowx)){
            $data = [];
            $data['ddc_tpt'] = 0;
            $data['ddc_tpt_remark'] = '';

            $row = $this->db->where("id='{$id}'  AND print_dt = '{$rowx->print_dt}'",null,false)->update($this->tbl,$data);
        }

        $this->db->where('apr_sv_payslip_id', $id);
        $this->db->delete($this->tbl_app);
        if ($this->db->affected_rows()) {
            return array('success' => lang('Delete success'));
        }
        return array('error' => lang('Delete has failed'));
    }

    public function update_batch_tptgr($data, $key) {
        $this->db->update_batch($this->tbl, $data, $key);
        // foreach ($data as $r) {
            // $cond= "empl_id='{$r->id}'  AND `print_dt` >= '{$print_dt}'";
            // $row = $this->db->where($cond,null,false)->update($this->tbl,$data);
        // }
        return $this->db->affected_rows();
    }

    public function update_tptgr($id, $ddc_tpt, $ddc_tpt_remark) {


        $this->db->select('COUNT(id) as cid', false);
        $this->db->where('apr_sv_payslip_id', $id);
        $res    = $this->db->get($this->tbl_app)->row();
        $update = $res->cid;

        $this->db->select('print_dt, empl_id');
        $this->db->where('id', $id);
        $res = $this->db->get($this->tbl)->row();

        if (!$res) {
            return false;
        }
        if (!property_exists($res, 'print_dt')) {
            return false;
        }
        if (!$res->print_dt) {
            return false;
        }
        $print_dt = $res->print_dt;
        if (!property_exists($res, 'empl_id')) {
            return false;
        }
        if (!$res->empl_id) {
            return false;
        }
        $empl_id = $res->empl_id;
        $now     = date('Y-m-d H:i:s');

        $data = [
            'ddc_tpt' => $ddc_tpt,
            'ddc_tpt_remark'=> $ddc_tpt_remark,
            
        ];
        // $cond= "empl_id='{$id}'  AND print_dt >= '{$print_dt}'";
        $row = $this->db->where('id',$id)->update($this->tbl,$data);
        if ($update) {
            $data['modified'] = $now;
            $this->db->where("apr_sv_payslip_id='{$id}'  AND print_dt = '{$print_dt}'",null,false)
                     ->update($this->tbl_app,$data);
          
           
        } else {
           
            $data['apr_sv_payslip_id'] = $id;
            $data['created']=$now;
            $data['print_dt'] = $print_dt;
            $data['empl_id'] = $empl_id;
            $this->db->insert($this->tbl_app,$data);
        }
        
     
        // $this->db->query($sqlquery);
         

        return $this->db->affected_rows();
    }

    public function set_joins() {
//        $joins = array(
//            array(
//                'apr_sv_payslip',
//                'apr_sv_payslip.base_sal_id='.$this->tbl.'.id_gaji_pokok',
//                'left'
//            )
//        );
//        $this->rs_joins = $joins;
    }

    public function set_rs_select() {
//        $this->rs_select = $this->tbl.'.*, apr_sv_payslip.base_sal_id locked';
    }

}
