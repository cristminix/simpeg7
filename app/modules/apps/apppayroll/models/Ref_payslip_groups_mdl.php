<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'apppayroll_frontmdl' . EXT;

class Ref_Payslip_Groups_Mdl extends Apppayroll_Frontmdl {

    public $tbl                  = 'apr_payslip_group';
    public $tbl_detail           = 'apr_payslip_group_detail';
    public $rs_field_list        = array(
        '1' => 'name',
        'text',
    );
    public $rs_masked_field_list = array(
        '1' => 'Name',
        'Notes',
    );
    public $rs_use_form_filter   = 'apr_payslip_group';
//    public $rs_select            = "*,  CONCAT(TIMESTAMPDIFF(YEAR, hire_date, NOW()), ' thn') as `los`";
    public $rs_order_by          = null;
    public $rs_common_views      = array(
        /* call_user_func */
//        'call_user_func'      => array(
//        ),
//        'currency_field_list' => array(
//            'gaji_pokok',
//        ),
//        'cell_alignments'     => array(
//            'gaji_pokok'     => 'right',
//        )
    );
    public $rs_index_where       = 'active_status=1';

    public function add_new_payslip_group($name, $text){
        
        $this->db->set('name', $name);
        $this->db->set('text', $text);
        $this->db->set('active_status', 1);
        $now = date('Y-m-d H:i:s');
        $this->db->set('created', $now);
        $this->db->set('modified', $now);
        $this->db->insert($this->tbl);
        $aff = $this->db->affected_rows();
        if (!$aff) {
            return $aff;
        }
        return $this->db->insert_id();
    }
    
    public function buildDB() {
        $tbl = $this->tbl;
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `{$tbl}` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `text` text,
  `annotation` text,
  `active_status` tinyint(1) DEFAULT '1',
  `menu_code` varchar(50) DEFAULT NULL,
  `menu_order` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Payslip Grups';

SQL;
        $this->db->query($sql);
        $tbl_detail = $this->tbl_detail;
        $sql = <<<SQL
            CREATE TABLE IF NOT EXISTS `{$tbl_detail}` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `{$tbl}_id` int(20) NOT NULL,
  `field_name` varchar(50) DEFAULT NULL COMMENT 'apr_sv_payslip.@field',
  `operator` varchar(50) DEFAULT NULL COMMENT 'ex: =, != , <=,>= etc',
  `value` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `text` text,
  `annotation` text,
  `active_status` tinyint(1) DEFAULT '1',
  `menu_code` varchar(50) DEFAULT NULL,
  `menu_order` int(10) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Payslip Grups Detail';

SQL;
        $this->db->query($sql);
    }

    public function delete_row_by_id($id){
        $this->db->where('id', $id);
        $this->db->set('active_status', 0);
        $this->db->update($this->tbl); 
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
        $this->db->where('id', $id);
        $this->db->where($this->rs_index_where, null, false);

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
                'id_alias'    => 'id',
                'action_top' => array(
                    'a' => array(
                        'url'  => sprintf($r_url, md5('new'.date('ymd'))),
                        'text' => '<span class="fa fa-plus"></span> '.lang('Add new'),
                    )
                ),
                'action_list' => array(
//                    'r' => array(
//                        'url' => $r_url,
//                        'text' => '<span class="fa fa-eye fa-border fa-fw"><span>',
//                    ),
                    'e' => array(
                        'url'  => $r_url,
                        'text' => '<span class="fa fa-edit fa-fw"></span>',
                    ),
                    'r' => array(
                        'url'  => sprintf($r_url, md5('detail'.date('ymd')). '/%s'),
                        'text' => '<span class="fa fa-cog fa-fw"></span>',
                    ),
                    'd' => array(
                        'url'  => sprintf($r_url, md5('del'.date('ymd')). '/%s'),
                        'text' => '<span class="fa fa-trash fa-fw text-warning"></span>',
                    ),
                ),
            )
        );
        return $action;
    }
    
    

    public function is_duplicated($name, $not_id = null) {
        $this->db->where('name', $name);
        $this->db->where('active_status', 1);
        $this->db->select('COUNT(id) cgp', false);
        if ($not_id) {
            $this->db->not_like('id', $not_id, 'none');
        }
        $rs     = $this->db->get($this->tbl);
        $result = false;
        if (!$rs) {
            return $result;
        }
        $res = $rs->row();
        if (!$res) {
            return $result;
        }
        $result = (bool) $res->cgp;
        return $result;
    }
    
    public function set_joins() {
        
    }

    public function set_rs_select() {
        
    }

    public function update_payslip_group($id, $name, $text){
        
        $this->db->set('name', $name);
        $this->db->set('text', $text);
        $now = date('Y-m-d H:i:s');
        $this->db->set('modified', $now);
        $this->db->where('id', $id);
        $this->db->update($this->tbl);
        return $this->db->affected_rows();
        
    }
    
}
