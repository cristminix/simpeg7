<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Legal_Mdl extends Apppayroll_Frontmdl {

    public $tbl                  = 'apr_legal';
    public $rs_field_list        = array(
        '1' => 'doc_no',
        'name',
        'subject',
        'text',
        'resource_path',
        'modified',
    );
    public $rs_masked_field_list = array(
        '1' => 'Doc No',
        'Name',
        'Subject',
        'Remark',
        'Documents',
        'Last update',
    );
    public $rs_use_form_filter = 'legal_master_data';

    public function fetch_detail($id) {
        $db = $this->load->database('default', true);
        $db->from($this->tbl);
        $db->where('id', $id);
        $rs = $db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

}
