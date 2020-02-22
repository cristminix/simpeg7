<?php
/**
 * 
 */
class Console extends MX_Controller
{
	public function __construct($value = '')
    {
    	if(!defined('CLI_APP')){
    		// redirect(base_url());
    	}

        parent::__construct();
    }
    
    public function index($cmd = '', $a = '', $b = '', $c = '', $d = '', $e = '')
    {
        $method = str_replace(':', '_', $cmd);

        if (method_exists($this, $method)) {
            return $this->{$method}($a, $b, $c, $d, $e);
        }

        echo ('Unexistent command '."$cmd\n");
    }

    public function m_web_test()
    {
        $this->load->model('m_web');
        $o = $this->m_web->cari_kanal(1);

        var_dump( $o);
    }
}