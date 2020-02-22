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
        error_reporting(0);
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
    public function mass_rename()
    {
        $folders = ['web_agenda','web_artikel','web_artikel_lastten','web_artikel_slider'
                            ,'web_banner_main','web_banner_slider','web_calendar','web_commented'
                            ,'web_daftar','web_detail_samping','web_direktori','web_galeri','web_index_tutorial','web_statis','web_statis_main'];

        foreach ($folders as $folder) {
           $path = APPPATH.'modules/widget/'.$folder.'/controllers/';
            $path2 = APPPATH.'modules/widget/'.$folder.'/models/';

            $file_container = [$path,$path2];
            foreach ($file_container as $pth) {
                
                $files = glob(  $pth."*.{php}", GLOB_BRACE);
                foreach ($files as $file) {
                    $old_name = $file;
                    $filename = basename($old_name);
                    $new_name = ucfirst($filename);
                    $new_name = str_replace($filename, $new_name, $old_name);
                        echo  $new_name. "\n";
                    rename( $old_name, $new_name);
                }
            }

            
            // print_r($files);
        }
        
    }
}