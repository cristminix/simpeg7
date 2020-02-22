<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dafkpo extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($content=array())
    {
        $this->load->view('dafkpo/default', $content);
    }
    public function data()
    {
        $this->load->model('dg_dafkpo');
        echo $this->dg_dafkpo->get_data();
    }
}
