<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Apppayroll_Frontctl extends MX_Controller {

    public $main_mdl         = 'apppayroll_frontmdl';
    public $layout           = 'layouts/admpr';
    public $main_menu        = array();
    public $page_content     = array();
    public $page_data        = array();
    public $page_body        = array();
    public $page_content_tpl = 'index';
    protected $use_page_header =true;
    protected $use_page_sidebar =true;
    protected $elements_page_wrapper = 'elements/page_wrapper';


    public function __construct() {
        parent::__construct();
        $this->lang->load('apppayroll', 'bahasa_indonesia');
        $helpers = array('language', 'html');
        $this->load->helper($helpers);
        $this->load_main_mdl();
        $this->load_main_menu();
        if (ENVIRONMENT == 'development' || ENVIRONMENT == 'testing') {
            // $this->output->enable_profiler(TRUE);
        }
        $this->{$this->main_mdl}->is_has_access();
        if (method_exists($this->{$this->main_mdl}, 'buildDB')) {
            $this->{$this->main_mdl}->buildDB();
        }
    }

    protected function load_main_mdl() {

        if (!property_exists($this, 'main_mdl')) {
            return;
        }

        $this->load->model($this->main_mdl);
    }

    protected function load_main_menu() {

        $this->main_menu = $this->{$this->main_mdl}->get_app_main_menu();
    }

    protected function load_mdl($mdl) {
        if (property_exists($this, $mdl)) {
            return;
        }
        $this->load->model($mdl);
    }

    protected function load_page_content() {
        $class     = strtolower(get_class($this));
        $tpl       = $class . '/' . $this->page_content_tpl;
        $view_dir  = realpath(dirname(__FILE__)) .
            DIRECTORY_SEPARATOR .
            '..' .
            DIRECTORY_SEPARATOR .
            'views' .
            DIRECTORY_SEPARATOR;
        $fn        = $view_dir .
            $class .
            DIRECTORY_SEPARATOR .
            $this->page_content_tpl .
            EXT;
              
        $use_scaff = false;
        if (!file_exists($fn)) {
            $tpl       = 'elements/scaffolding/' . $this->page_content_tpl;
            $use_scaff = true;

        }
        if (!$use_scaff) {
            $this->page_body['page_content'] = $this->load->view($tpl, $this->page_content, true);
            
            return;
        }
        $fn = $view_dir .
            'elements' .
            DIRECTORY_SEPARATOR .
            'scaffolding' .
            DIRECTORY_SEPARATOR .
            $this->page_content_tpl .
            EXT;

        if (!file_exists($fn)) {
            $tpl = 'elements/scaffolding/index';
        }
        $this->page_body['page_content'] = $this->load->view($tpl, $this->page_content, true);
    }

    protected function load_page_data() {
        $this->load_page_header();
        $this->load_page_sidebar();
	if(!$this->use_page_header) {
            unset($this->page_body['page_header_nav']);
        }
        if(!$this->use_page_sidebar) {
            unset($this->page_body['page_sidebar']);
        }
        $this->page_data['page_body'] = $this->load->view($this->elements_page_wrapper, $this->page_body, true);
    }

    protected function load_page_header() {
        $data                               = array('usr' => $this->{$this->main_mdl}->get_curr_usr());
        $this->page_body['page_header_nav'] = $this->load->view('elements/page_header_nav', $data, true);
    }

    protected function load_page_sidebar() {

        $this->page_body['page_sidebar'] = $this->load->view('elements/page_sidebar', $this->main_menu, true);
    }

    protected function log_out() {
        redirect('login/out');
    }

    protected function print_page($tpl = false, $content = array()) {
        if ($tpl) {
            $this->page_content_tpl = $tpl;
        }
        if ($content) {
            $this->set_data($content);
        }
        $this->load_page_content();
        $this->load_page_data();
        $this->load->view($this->layout, $this->page_data);
    }

    protected function set_common_views($mdl = null, $suffix = '') {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }
        $var = 'rs_common_views' . $suffix;
        if (!property_exists($this->{$mdl}, $var)) {
            return;
        }
        if (!$this->{$mdl}->{$var}) {
            return;
        }
        $this->set_data($this->{$mdl}->{$var});
    }

    protected function set_custom_filter($mdl = null, $suffix = '') {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }
        $var = 'get_custom_filter_config' . $suffix;
        if (!method_exists($mdl, $var)) {
            return;
        }
        $var = 'get_custom_filter_data' . $suffix;
        if (!method_exists($mdl, $var)) {
            return;
        }
        $var = 'handle_custom_filter' . $suffix;
        if (!method_exists($mdl, $var)) {
            return;
        }
        $var     = 'get_custom_filter_config' . $suffix;
        $config  = $this->{$mdl}->{$var}();
        $input   = $this->input->post();
        $var     = 'handle_custom_filter' . $suffix;
        $this->{$mdl}->{$var}($input);
        $var     = 'get_custom_filter_data' . $suffix;
        $cf_data = $this->{$mdl}->{$var}();
        $var     = 'generate_sv_data' . $suffix;
        if (method_exists($this->{$mdl}, $var)) {
            $this->{$mdl}->{$var}($this->{$mdl}->rs_cf_cur_year, $this->{$mdl}->rs_cf_cur_month);
        }

        $this->{$mdl}->rs_common_views['custom_filter'] = $this->load->view($config['tpl'], compact('cf_data'), true);
    }

    protected function set_data($data = array()) {
        if (!$data) {
            return;
        }
        foreach ($data as $key => $val) {
            $this->page_content[$key] = $val;
        }
    }

    protected function set_form_filter($mdl = null, $suffix = '') {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }
        $var = 'rs_use_form_filter' . $suffix;
        if (!property_exists($this->{$mdl}, $var)) {
            return;
        }
        if (!$this->{$mdl}->{$var}) {
            return;
        }
        $rs_form_filter = "";

        $data                                          = array();
        $data['form_filter']                           = array();
        $ff_prefix                                     = $this->{$mdl}->{$var};
        $sess_name                                     = md5($ff_prefix . date('d'));
        $data['form_filter']['ff_prefix']              = $ff_prefix;
        $data['form_filter'][$ff_prefix . 'sess_name'] = $sess_name;
        $var                                           = 'rs_masked_field_list' . $suffix;
        $data['form_filter'][$ff_prefix . 'cols']      = $this->{$mdl}->{$var};

        $selected_field = '1';
        $selected_val   = null;
        $ff_sess        = $this->session->userdata($sess_name);
        if ($ff_sess) {
            extract($ff_sess);
        }

        $input_post = $this->input->post();
        $do_clear   = false;
        $do_search  = false;
        if ($input_post) {


            if (isset($input_post[$sess_name . '_do_clear'])) {
                $do_clear = $input_post[$sess_name . '_do_clear'];
            }

            if (isset($input_post[$sess_name . '_do_search'])) {
                $do_search = $input_post[$sess_name . '_do_search'];
            }
        }

        if ($do_search) {

            $selected_field                  = $input_post[$sess_name . '_field'];
            $selected_val                    = $input_post[$sess_name . '_val'];
            $this->{$mdl}->rs_reset_cur_page = true;
        }
        if ($do_clear) {
            $selected_field = '1';
            $selected_val   = null;
        }
        $sess_ff = array(
            'selected_field' => $selected_field,
            'selected_val'   => $selected_val,
        );
        $this->session->set_userdata($sess_name, $sess_ff);

        $ff_sess = $this->session->userdata($sess_name);
        extract($ff_sess);
        // $selected_field = $ff_sess['selected_field'];


        $data['form_filter'][$ff_prefix . 'field'] = $selected_field;
        $data['form_filter'][$ff_prefix . 'value'] = $selected_val;
        if ($selected_field) {

            $this->{$mdl}->rs_search_field = $selected_field;
        }
        if (isset($selected_val)) {
            if ($selected_val === 'NULL') {
                $selected_val = null;
            }
            $this->{$mdl}->rs_search_val = $selected_val;
        }

        $page_form_filter = $this->load->view('elements/page_form_filter', $data, true);
        $this->set_data(compact('page_form_filter'));
    }

    protected function set_page_title($title = null) {
        $page_title = $title;
        if (!$page_title) {
            $page_title = $this->router->fetch_class() . ' :: ' . $this->router->fetch_method();
        }
        $this->set_data(compact('page_title'));
    }

    protected function set_pagination($mdl = null, $suffix = '') {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }

        $before_paging_text = '';
        if (method_exists($this->{$mdl}, 'add_filter_text_before_pagination')) {
            $before_paging_text = $this->{$mdl}->add_filter_text_before_pagination();
        }

        $var = 'rs_field_list' . $suffix;
        if (property_exists($this->{$mdl}, $var)) {
            $this->set_data(array('field_list' => $this->{$mdl}->{$var}));
        }
        $var = 'rs_masked_field_list' . $suffix;
        if (property_exists($this->{$mdl}, $var)) {
            $this->set_data(array('masked_field_list' => $this->{$mdl}->{$var}));
        }
        if (property_exists($this->{$mdl}, 'rs_offset')) {
            $this->set_data(array('rs_offset' => $this->{$mdl}->rs_offset));
        }
        $sort_order = 'asc';
        if (property_exists($this->{$mdl}, 'rs_sort_order')) {
            if ($this->{$mdl}->rs_sort_order == 'asc') {
                $sort_order = 'desc';
            }
        }

        $this->set_data(compact('sort_order'));

        if (property_exists($this->{$mdl}, 'rs_order_by')) {
            $this->set_data(array('order_by' => $this->{$mdl}->rs_order_by));
        }
        $per_page = 10;
        if (property_exists($this->{$mdl}, 'rs_per_page')) {
            $per_page = $this->{$mdl}->rs_per_page;
        }
        $this->set_data(compact('per_page'));
        $var = 'get_pagination_config' . $suffix;

        $config               = $this->{$mdl}->{$var}();
        $var                  = 'fetch_total_rows' . $suffix;
        $config['total_rows'] = $this->{$mdl}->{$var}();
        if ($config['total_rows'] <= 10) {
            $pagination = $before_paging_text . "<br>";
            $this->set_data(compact('pagination'));
            return;
        }

        $per_page_options = array();

        $var                            = 'rs_per_page_options' . $suffix;
        $config['full_tag_open']        = '<nav>';
        $rs_ppo                         = $this->{$mdl}->{$var};
        $per_page_options['url_suffix'] = '';
        if ($rs_ppo) {
            $per_page_options['list']       = $this->{$mdl}->{$var};
            $per_page_options['total_rows'] = $config['total_rows'];
            $per_page_options['current']    = $per_page;

            if ($this->{$mdl}->rs_order_by) {
                $per_page_options['url_suffix'] .= '/' . $this->{$mdl}->rs_order_by;
                if ($this->{$mdl}->rs_sort_order) {
                    $per_page_options['url_suffix'] .= '/' . $this->{$mdl}->rs_sort_order;
                }
            }
            $mdl_base_url = base_url() . $this->router->fetch_module() . '/' . $this->router->fetch_class() . '/' . $this->router->fetch_method() . '/0/';
            if (property_exists($this->{$mdl}, 'rs_base_url')) {
                $mdl_base_url = $this->{$mdl}->rs_base_url;
            }
            $per_page_options['url_prefix'] = $mdl_base_url;
            $var                            = 'rs_ppo_url_prefix' . $suffix;
            if (property_exists($this->{$mdl}, $var)) {
                $per_page_options['url_prefix'] = $this->{$mdl}->{$var};
            }
            $per_page_options['url_prefix'] .= '1/';
            $full_tag_open                  = $this->load->view('elements/pagination_per_page', compact('per_page_options'), true);
            $config['full_tag_open']        .= $full_tag_open;
            $config['full_tag_open']        .= '<br>';
        }

        $config['full_tag_open'] .= '<ul class="pagination">';
        $config['first_url']     = $config['base_url'] . '1/' . $per_page . $per_page_options['url_suffix'];
        $this->pagination->initialize($config);
        $pagination              = $before_paging_text;
        $pagination              .= $this->pagination->create_links();

        if (!$pagination && $rs_ppo) {


            $pagination .= $this->load->view('elements/pagination_per_page', compact('per_page_options'), true);
        }

        $this->set_data(compact('pagination'));
    }

    public function set_rs_action($mdl = null, $suffix = '') {
        if (!$mdl) {
            $mdl = $this->main_mdl;
        }
        $var = 'get_rs_action' . $suffix;
        if (!method_exists($this->{$mdl}, $var)) {
            return;
        }
        $rs_action = $this->{$mdl}->{$var}();
        $this->set_data(compact('rs_action'));
    }

    protected function _set_ym_period($y, $m) {
        $rs_cf_cur_date  = strtotime(sprintf('%s-%s-01', $y, $m));
        $rs_cf_cur_year  = date('Y', $rs_cf_cur_date);
        $rs_cf_cur_month = date('F', $rs_cf_cur_date);
        $rs_cf_cur_month = lang(ucfirst($rs_cf_cur_month));
        return sprintf('%s %s', $rs_cf_cur_year, $rs_cf_cur_month);
    }

}
