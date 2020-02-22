<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dafpeg extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($content=array())
    {
        $this->load->view('dafpeg/default', $content);
    }
    public function data()
    {
        $this->load->model('dg_dafpeg');
        echo $this->dg_dafpeg->get_data();
    }
}
