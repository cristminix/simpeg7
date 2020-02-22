<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Ref_Base_Salary_Mdl extends Apppayroll_Frontmdl {

    public $tbl                  = 'm_gaji_pokok';
    public $rs_field_list        = array(
        '1' => 'tahun',
        'mk_peringkat',
        'kode_golongan',
        'nama_pangkat',
        
        'gaji_pokok',
        'tahun',
    );
    public $rs_masked_field_list = array(
        '1' => 'Year',
        'Length of Service',
        'Grade ID',
        'Grade',        
        'Base Salary',
        'Year',
    );
    public $rs_use_form_filter   = 'm_gaji_pokok';
//    public $rs_select            = "*,  CONCAT(TIMESTAMPDIFF(YEAR, hire_date, NOW()), ' thn') as `los`";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        /* call_user_func */
        'call_user_func'      => array(
        ),
        'currency_field_list' => array(
            'gaji_pokok',
        ),
        'cell_alignments'     => array(
//            'gaji_pokok'     => 'right',
        )
    );

    public function delete_row_by_id($id){
        $this->db->where('id_gaji_pokok', $id);
        $this->db->delete($this->tbl); 
        if($this->db->affected_rows()){
            return array('success'=> lang('Delete success'));
        }
        return array('error'=> lang('Delete has failed'));
    }

    public function fetch_detail($id) {
//        $db = $this->load->database('default', true);
        $this->db->from($this->tbl);
        $this->set_joins();
        $this->set_rs_select();
        if($this->rs_joins){
            foreach($this->rs_joins as $joins){
                $this->db->join($joins[0],$joins[1],$joins[2]);
            }
        }
        if (property_exists($this, 'rs_select')) {
            $this->db->select($this->rs_select, false);
        }
        $this->db->where('id_gaji_pokok', $id);

        $rs = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->row();
        return $res;
    }

    public function get_rs_action() {
        $r_url  = base_url($this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/%s');
        $action = array(
            'tpl'       => $this->rs_scaffolding_action,
            'view_data' => array(
                'id_alias'    => 'id_gaji_pokok',
                'action_top' => array(
                    'a' => array(
                        'url'  => sprintf($r_url, md5('new'.date('ymd'))),
                        'text' => '<span class="fa fa-plus fa-border fa-fw"></span> '.lang('Add new'),
                    )
                ),
                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-edit fa-border fa-fw"></span>',
                    ),
                    'd' => array(
                        'url'  => sprintf($r_url, md5('del'.date('ymd')). '/%s'),
                        'text' => '<span class="fa fa-trash fa-border fa-fw text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }

    public function update_row_by_id($id, $data, $where = array()) {


        $now = date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        if ($where) {
            foreach ($where as $set) {
                if (!isset($set[2])) {
                    $this->db->where($set[0], $set[1]);
                    continue;
                }

                $this->db->where($set[0], $set[1], $set[2]);
            }
        }
        $this->db->where('id', $id);
        $this->db->update($this->tbl, $data);
    }

    public function set_joins(){
//        $joins = array(
//            array(
//                'apr_sv_payslip',
//                'apr_sv_payslip.base_sal_id='.$this->tbl.'.id_gaji_pokok GROUP BY apr_sv_payslip.base_sal_id',
//                'left outer'
//            )
//        );
//        $this->rs_joins = $joins;
    }
    
    public function set_rs_select(){
        $this->rs_select = $this->tbl.'.*';
    }
}
