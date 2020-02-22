<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Ref_Wk_Coopr_Mdl extends Apppayroll_Frontmdl {

    public $tbl                  = 'apr_ref_wk_coopr';
    public $rs_field_list        = array(
        '1' => 'name',
        'amt',
        'text',
        'modified',
    );
    public $rs_masked_field_list = array(
        '1' => 'Name',
        'Amount',
        'Annotation',
        'Last Update',
    );
    
    public $rs_common_views = array(
        /* Currency Field */
        'currency_field_list' => array(
            'amt'
        )
    );
    public $rs_use_form_filter = 'ef_wk_coopr';
    public $rs_select = "*";
    public $rs_order_by = null;

    public function fetch_detail($eid) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->db->where('id', $eid);
        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

}
