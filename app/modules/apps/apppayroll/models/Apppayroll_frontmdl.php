<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apppayroll_Frontmdl extends CI_Model {

    public $app_curr_path                = null;
    public $app_curr_usr                 = null;
    public $rs_common_views              = array();
    public $rs_sort_natural              = array(); // natural sort for numeric column
    public $rs_num_links                 = 7;
    public $rs_per_page_options   = array(
        10,
        20,
        25,
        30,
        40,
        50,
        100,
        250,
        500,
        1000
    );
    public $rs_reset_cur_page            = false;
    public $rs_scaffolding_action        = 'elements/scaffolding/rs_action';
    public $rs_scaffolding_index         = 'elements/scaffolding/index';
    public $rs_vars                      = array();
    public $sys_main_menu                = null;
    public $rs_joins                     = null;
    public $rs_index_where = null;

    public function __construct() {

        parent::__construct();

        $CI     = & get_instance();
        if (is_null($CI->db))
            $CI->db = & $this->load->database('default', TRUE, TRUE);
    }

    public function add_filter_text_before_pagination() {
        $text = '';
        $prop = 'rs_search_field';
        if (!property_exists($this, $prop)) {
            return $text;
        }
        $prop = 'rs_field_list';
        if (!property_exists($this, $prop)) {
            return $text;
        }
        $rs_flist = $this->{$prop};
        $prop = 'rs_masked_field_list';
        if (property_exists($this, $prop)) {
            $rs_flist = $this->{$prop};
        }
        $content = '';
        $prop = 'rs_search_val';
        if (property_exists($this, $prop)) {
            $content = $this->{$prop};
        }
        if($content===null){
            $content = 'NULL';
        }
        $exception = false;
        if($content=== 0){
            $exception = true;
        }
        if($content=== '0'){
            $exception = true;
        }
        if (!isset($rs_flist[$this->rs_search_field])) {
            return $text;
        }
        
       
        if (!$content && $exception===false) {
            return $text;
        }
        
        $text .= '<h5>';
        $text .= lang('Filter by');
        $text .= ': ';
        $text .= lang($rs_flist[$this->rs_search_field]);
        $text .= ' ';
        $text .= lang('containing');
        $text .= ' "<em>';
        $text .= $content;
        $text .= '</em>"';
        $text .= '</h5>';
        return $text;
    }
    
    public function assign_rs_var($var, $mixed) {
        $this->rs_vars[$var] = $mixed;
    }

    public function fetch_data($cur_page = 1, $per_page = 10, $order_by = null, $sort_order = null) {
//        $this->db = $this->load->database('default', true, true);
        if ($this->rs_reset_cur_page) {
            $cur_page = 1;
        }
        $this->db->from($this->tbl);
        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if (property_exists($this, 'rs_select')) {

            $this->db->select($this->rs_select, false);
        }
        if (property_exists($this, 'rs_group_by')) {
            $this->db->group_by($this->rs_group_by);
        }
        if($this->rs_index_where){
            $this->db->where($this->rs_index_where, null, false);
        }
        $this->filter_result($this->db);
        if (method_exists($this, 'custom_filter_result')) {
            $this->custom_filter_result($this->db);
        }
        if(property_exists($this, 'rs_first_list_orders')){
            $list_orders = $this->rs_first_list_orders;

            if($list_orders){
                foreach($list_orders as $ls_order){
                    if(!$ls_order){
                        continue;
                    }
                    if(!isset($ls_order[0])){
                        continue;
                    }
                    $ob = $ls_order[0];
                    $so = isset($ls_order[1]) ? $ls_order[1] : null; 
                    $so = in_array($so, array('asc', 'desc')) ?  $so : null; 
                    $this->db->order_by($ob, $so, false);
                }
            }
        }
        if ($order_by) {
            // echo "$order_by";
            // die();
            $order_by = isset($this->rs_field_list[$order_by]) ? $order_by : null;
        }
        if ($order_by) {
            $sort_order   = $sort_order ? $sort_order : 'asc';
            $order_by_col = $this->rs_field_list[$order_by];
            if (in_array($this->rs_field_list[$order_by], $this->rs_sort_natural)) {
                $order_by_col = $this->rs_field_list[$order_by] . '+0';
            }
            if(isset($this->rs_masked_search_fields[$order_by])){
                $order_by_col = $this->rs_masked_search_fields[$order_by];
            }
            $this->db->order_by($order_by_col, $sort_order, false);

            $this->rs_sort_order = $sort_order;
            $this->rs_order_by   = $order_by;
        }
        if(property_exists($this, 'rs_last_list_orders')){
            $list_orders = $this->rs_last_list_orders;
            if($list_orders){
                foreach($list_orders as $ls_order){
                    if(!$ls_order){
                        continue;
                    }
                    if(!isset($ls_order[0])){
                        continue;
                    }
                    $ob = $ls_order[0];
                    $so = isset($ls_order[1]) ? $ls_order[1] : null; 
                    $so = in_array($so, array('asc', 'desc')) ?  $so : null; 
                    $this->db->order_by($ob, $so, false);
                }
            }
        }
        $offset = $cur_page - 1;

        if ($offset < 0)
            $offset            = 0;
        if ($offset >= 1)
            $offset            = ($offset * $per_page);
//        debug($offset);die();
        $this->rs_per_page = $per_page;
        $this->rs_offset   = $offset + 1;
        $this->db->limit($per_page, $offset);
        $rs                = $this->db->get();
        if ($rs->num_rows() <= 0) {
            return array();
        }
        $res = $rs->result();

        return $res;
    }

    public function fetch_total_rows() {
//        $this->db  = $this->load->database('default', true);
        $this->db->from($this->tbl);
        if ($this->rs_joins) {
            foreach ($this->rs_joins as $joins) {
                $this->db->join($joins[0], $joins[1], $joins[2]);
            }
        }
        if($this->rs_index_where){
            $this->db->where($this->rs_index_where, null, false);
        }
        $this->filter_result($this->db);
        if (method_exists($this, 'custom_filter_result')) {
            $this->custom_filter_result($this->db);
        }
        $res = $this->db->count_all_results();
        return $res;
    }
    
    public function filter_result(&$db) {
        if (!property_exists($this, 'rs_search_field')) {
            return;
        }
        if (!property_exists($this, 'rs_search_val')) {
            return;
        }

        $rs_field_list = $this->rs_field_list;
        $prop_name = 'rs_masked_search_fields';
        if(property_exists($this, $prop_name)){
            if($this->{$prop_name}){
                 $rs_field_list = $this->{$prop_name};
            }
        }
        $field = $this->rs_search_field;
        
        if ($field != $this->config->item('ff_all_value')) {
            if (!isset($this->rs_field_list[$field])) {
                return;
            }
        }
        $val = $this->rs_search_val;
        if ($field != $this->config->item('ff_all_value')) {

            $fieldname = $rs_field_list[$field];
            
            if($val === NULL){
                $db->where($fieldname, $val);
            } else {
                $db->like($fieldname, $val);
            }
            
            return;
        }
        
        foreach ($rs_field_list as $fieldname) {
            $db->or_like($fieldname, $val);
        }
    }

    public function get_app_main_menu() {
        if ($this->sys_main_menu) {
            $sys_app_main_menu = $this->sys_main_menu;
            return compact('sys_app_main_menu');
        }
        $sys_app_main_menu = array(
//            'app_main_menu_root'  => array(),
            'app_main_menu_child' => array(),
            'app_main_menu_all'   => array(),
        );

        $sess      = $this->session->userdata('logged_in');
        //debug($sess);
//        $idd       = $sess['id_user'];
        $id_groups = $sess['id_group'];
//        $db        = $this->load->database('default', true);
        $this->db->from('p_setting_item');
        $this->db->select('meta_value');
        $this->db->where('id_setting', 3);
        $this->db->like('meta_value', '"group_id":"' . $sess['id_group'] . '"', 'both');
//         var_dump($db);die();
        $rs        = $this->db->get();
        $res       = $rs->result();
        if (!$res) {
            return compact('sys_app_main_menu');
        }
        $ids = array();
        foreach ($res as $key => $val) {
            $obj   = json_decode($val->meta_value);
            $ids[] = $obj->id_menu;
        }
        if (!$ids) {
            return compact('sys_app_main_menu');
        }
        $this->db->from('p_setting_item');
        $this->db->where('id_setting', 2);
        $this->db->where_in('id_item', $ids);
        $this->db->order_by('urutan', 'asc');

        $rs  = $this->db->get();
        $res = $rs->result();
        /**
         * foreach ($result as $key => $val) {

          if ($val->parent_id) {
          $app_main_menu['app_main_menu_child'][$val->parent_id][] = $val;
          }
          $app_main_menu['app_main_menu_all'][$val->id] = $val;
          }

         */
        if (!$res) {
            return compact('sys_app_main_menu');
        }

        $currpath = $this->get_curr_path();
        $curr_id  = property_exists($currpath, 'id_item') ? $currpath->id_item : null;
        $icon     = '<span class="%s"></span>';
        foreach ($res as $key => $val) {
            $rec            = new stdClass();
            $rec->id        = $val->id_item;
            $rec->parent_id = $val->id_parent;
            $rec->menu_text = $val->nama_item;
            $rec->current   = $rec->id == $curr_id ? 'current' : '';

            $meta                  = json_decode($val->meta_value);
            $rec->slug             = $meta->path_menu;
            $rec->menu_text_before = sprintf($icon, $meta->icon_menu);
            $rec->menu_text_after  = '';
            if ($rec->parent_id > 0) {
                $sys_app_main_menu['app_main_menu_child'][$rec->parent_id][] = $rec;
            }

            $sys_app_main_menu['app_main_menu_all'][$rec->id] = $rec;
        }
//        var_dump($sys_app_main_menu);
//        die();
        $this->sys_main_menu = $sys_app_main_menu;
        return compact('sys_app_main_menu');
    }

    public function is_has_access($auto_redir = true) {
        $access = false;
        $ls     = $this->get_app_main_menu();
        if (!$ls) {
            if ($auto_redir) {
                return $this->log_out();
            }
            return $access;
        }
        $top = isset($ls['sys_app_main_menu']) ? $ls['sys_app_main_menu'] : null;
        if (!$top) {
            if ($auto_redir) {
                return $this->log_out();
            }
            return $access;
        }
        $all = isset($top['app_main_menu_all']) ? $top['app_main_menu_all'] : null;
        if (!$all) {
            if ($auto_redir) {
                return $this->log_out();
            }
            return $access;
        }
//        var_dump($this->session->userdata('logged_in')); die();
        $currpath = $this->get_curr_path();
        $curr_id  = property_exists($currpath, 'id_item') ? $currpath->id_item : null;
        if (!$curr_id) {
            if ($auto_redir) {
                return $this->log_out();
            }
            return $access;
        }

        if (!isset($all[$curr_id])) {
            if ($auto_redir) {
                return $this->log_out();
            }
            return $access;
        }
        return true;

//        echo '<pre>';
//        var_dump($all);
//        die();
    }

    protected function log_out() {
        redirect('login/out');
    }

    public function get_curr_path() {
        if ($this->app_curr_path) {
            return $this->app_curr_path;
        }
        $this->app_curr_path = $this->get_path();
        return $this->app_curr_path;
    }

    public function get_curr_usr() {
        if ($this->app_curr_usr) {
            return $this->app_curr_usr;
        }
        $this->app_curr_usr = $this->get_usr();
        return $this->app_curr_usr;
    }

    protected function get_path($mod = null, $ctl = null, $mtd = null) {
        $mod        = $mod ? $mod : $this->router->fetch_module();
        $ctl        = $ctl ? $ctl : $this->router->fetch_class();
        $mtd        = $mtd ? $mtd : $this->router->fetch_method();
        $path       = sprintf('%s/%s/%s', $mod, $ctl, $mtd);
        $meta       = '{"path_menu":"%s","icon_menu":';
        $meta_value = sprintf($meta, $path);
//        $this->db         = $this->load->database('default', true);
        $this->db->from('p_setting_item');
        $this->db->where('id_setting', 2);
        $this->db->like('meta_value', $meta_value, 'both');
//         var_dump($db);die();
        $rs         = $this->db->get();
        $res        = $rs->row();
        return $res;
    }

    protected function get_usr($uid = null) {
        if (!$uid) {
            $sess = $this->session->userdata('logged_in');
            $uid  = $sess['id_user'];
        }
//        $db  = $this->load->database('default', true);
        $this->db->from('users');
        $this->db->where('user_id', $uid);
        $rs  = $this->db->get();
        $res = $rs->row();

        return $res;
    }

    public function get_pagination_config() {

        $config = array();
        if (!property_exists($this, 'rs_base_url')) {
            $this->rs_base_url = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/0/';
        }
//        debug($this->rs_base_url);die();
        $config['suffix']   = '/' . $this->rs_per_page;
        $config['base_url'] = $this->rs_base_url;
        if ($this->rs_order_by) {
            $config['suffix'] .= '/' . $this->rs_order_by;
            if ($this->rs_sort_order) {
                $config['suffix'] .= '/' . $this->rs_sort_order;
            }
        }
        $config['uri_segment'] = 5; // $this->rs_uri_segment;
        if (property_exists($this, 'rs_uri_segment')) {
            $config['uri_segment'] = $this->rs_uri_segment;
        }
        

        $config['per_page']         = $this->rs_per_page;
        $config['num_links']        = $this->rs_num_links;
        $config['use_page_numbers'] = true;

        $config['full_tag_open']  = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';

        $config['first_link']      = '<span class="fa fa-angle-double-left"></span>';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link']      = '<span class="fa fa-angle-double-right"></span>';
        $config['last_tag_open']  = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link']      = '<span class="fa fa-angle-right"></span>';
        $config['next_tag_open']  = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link']      = '<span class="fa fa-angle-left"></span>';
        $config['prev_tag_open']  = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open']  = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';

        return $config;
    }

}
