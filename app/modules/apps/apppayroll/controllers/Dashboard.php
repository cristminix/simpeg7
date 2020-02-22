<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//$dirname = dirname(__FILE__);
//require_once $dirname.'/apppayroll_frontctl.php';
require_once 'apppayroll_frontctl.php';

class Dashboard extends Apppayroll_Frontctl {
    public $main_mdl = "dashboard_mdl";
    public function index() {
        $mdl = $this->main_mdl;
        $ptp['permanent'] = $this->{$mdl}->get_ptp('permanent');
        $total['permanent'] = $this->{$mdl}->get_total('permanent');
        $bruto['permanent'] = $this->{$mdl}->get_bruto('permanent');
        
        $total['contract'] = $this->{$mdl}->get_total('contract');
        $bruto['contract'] = $this->{$mdl}->get_bruto('contract');
        
        $total['directors'] = $this->{$mdl}->get_total('directors');
        $bruto['directors'] = $this->{$mdl}->get_bruto('directors');
        
        $total['supervisory_boards'] = $this->{$mdl}->get_total('supervisory_boards');
        $bruto['supervisory_boards'] = $this->{$mdl}->get_bruto('supervisory_boards');
        $this->set_data(compact('bruto', 'total','ptp'));
        $this->print_page();
    }
    

}
