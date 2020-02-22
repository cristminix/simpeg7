<?php

/**
 * 
 */
class Login extends MX_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_web');
	}
}