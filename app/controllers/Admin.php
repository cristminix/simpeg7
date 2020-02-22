<?php

class Admin extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth->restrict();
    }

    public function index() {
        $sess = $this->session->userdata('logged_in');
        $data['ssn'] = $sess;
        $data['menu_side'] = $this->menu_side() . '<li><a href="' . site_url() . 'login/out"><i class="fa fa-sign-out fa-fw"></i><span class="masked"> Keluar</span></a></li>';


        $sess = $this->session->userdata('logged_in');
        $group_id = $sess['id_group'];
        $data['group_id'] = $group_id;
        
        if ($group_id == 7) {
            $data['dts'] = Modules::run("appbkpp/dashboard/pegawai");
            $data['judul'] = "Sistem Informasi Kepegawaian";
        } elseif ($group_id == 5) {
            $data['dts'] = Modules::run("appbkpp/dashboard/index");
            $data['judul'] = "Sistem Informasi Kepegawaian";
        } elseif ($group_id == 477) {
            $data['dts'] = Modules::run("appbkpp/dashboard/verifikatur");
            $data['judul'] = "Sistem Informasi Kepegawaian";
        } elseif ($group_id == 488) {
            $data['dts'] = Modules::run("appbkpp/dashboard/mutasi");
            $data['judul'] = "Sistem Informasi Kepegawaian";
        } elseif ($group_id == 6) {
            $data['dts'] = Modules::run("appbkpp/dashboard/umpeg");
            $data['judul'] = "Sistem Informasi Kepegawaian";
        } else if ($group_id == 598) {
            $data['dts'] = Modules::run("apppenggajian/dashboard/index");
            $data['judul'] = "Sistem Informasi Kepegawaian";
        }

        if ($group_id == 5) {
            // $data['sub_menu'] = '<li><a href="#" onClick="pindah_keluar(); return false;"><i class="fa fa-sign-out fa-fw"></i> Kinerja Bulanan</a></li>';
        } else {
            $data['sub_menu'] = '';
        }

        $data['konten'] = $data['dts'];

        $this->templateName = $sess['section_name'];

        if ($group_id == 598) {
            $this->templateName = 'penggajian';
        }

        $this->load->add_view_path('public/assets/themes/penggajian/');

        $this->load->view( 'index', $data);
    }

/////////////////////////////////////////////////////////
    public function module($modulename = '') {

        $sess = $this->session->userdata('logged_in');
        $group_id = $sess['id_group'];
        if ($group_id == 7) {
            $data['judul'] = "SIKDA - MODUL SKP ONLINE";
        } elseif ($group_id == 5) {
            $data['judul'] = "SISTEM INFORMASI KEPEGAWAIAN";
        } elseif ($group_id == 477) {
            $data['judul'] = "SIKDA - MODUL VERIFIKATUR";
        } elseif ($group_id == 488) {
            $data['judul'] = "SIKDA - MUTASI KEPEGAWAIAN";
        } elseif ($group_id == 6) {
            $data['judul'] = "SIKDA - PENGELOLA KEPEGAWAIAN";
        }

        // if($group_id==5){
        // $data['sub_menu'] = '<li><a href="#" onClick="pindah_keluar(); return false;"><i class="fa fa-sign-out fa-fw"></i> Kinerja Bulanan</a></li>';
        // } else {
        // $data['sub_menu'] = '';
        // }


        $data['ssn'] = $sess;
        $data['menu_side'] = $this->menu_side() . '<li><a href="' . site_url() . 'login/out"><i class="fa fa-sign-out fa-fw"></i> <span class="masked">Keluar</span></a></li>';
        $data['konten'] = Modules::run($modulename . "/index");

        $this->templateName = $sess['section_name'];
        if ($group_id == 598) {
            $this->templateName = 'penggajian';
        }
        $this->load->add_view_path('public/assets/themes/penggajian/');

        $this->load->view( 'index', $data);
    }

/////////////////////////////////////////////////////////
    public function moduledatapeg($modulename = '', $funcname = 'index') {
        $sess = $this->session->userdata('logged_in');
        $data['ssn'] = $sess;
        $data['menu_side'] = $this->menu_side() . '<li><a href="' . site_url() . 'login/out"><i class="fa fa-sign-out fa-fw"></i> Keluar</a></li>';
        $data['konten'] = Modules::run($modulename . "/" . $funcname . "/index");
        $this->templateName = $sess['section_name'];

        $this->load->add_view_path('public/assets/themes/' . $this->templateName . '/');
        

        $this->load->view($this->viewPath . 'index', $data);
    }

/////////////////////////////////////////////////////////
    private function menu_side($id_menu = 0, $level = 1) {
        $sess = $this->session->userdata('logged_in');
        $idd = $sess['id_user'];
        $id_groups = $sess['id_group'];

        $lvl[2] = "second";
        $lvl[3] = "third";
        $lvl[4] = "fourth";

        $sqlstr = "SELECT a.* FROM p_setting_item a WHERE a.id_setting='2' AND a.id_parent='$id_menu' ORDER BY a.urutan ASC";
        $hslquery = $this->db->query($sqlstr)->result();

        $data = array();
        //$jj="kosong";
        foreach ($hslquery as $key => $val) {
            $sqlstrb = "SELECT a.meta_value
			FROM p_setting_item a 
			WHERE a.id_setting='3' AND a.meta_value LIKE '%\"id_menu\":\"" . $val->id_item . "\"%'  AND a.meta_value LIKE '%\"group_id\":\"$id_groups\"%'";
            $hslqueryb = $this->db->query($sqlstrb)->result();
            if (!empty($hslqueryb)) {
                $jj = json_decode($hslqueryb[0]->meta_value);
                $data[] = $jj;
            } 
            
        }
       //print_r($sqlstrb);
        $menu_sidebar = "";
        foreach ($data as $row) {
            $sqlstrd = "SELECT a.* FROM p_setting_item a WHERE a.id_item='" . @$row->id_menu . "'";
            $hslqueryd = $this->db->query($sqlstrd)->result();
            $jj = json_decode($hslqueryd[0]->meta_value);

            $child = $this->menu_side(@$row->id_menu, ($level + 1));
            if (strlen($child) > 0) {
                $menu_sidebar .= '<li><a href="#"><i class="fa fa-' . @$jj->icon_menu . ' fa-fw"></i> <span class="masked"> ' . @$hslqueryd[0]->nama_item . '<span class="fa arrow"></span></span></a><ul class="nav nav-' . $lvl[($level + 1)] . '-level">' . $child . '</ul></li>';
            } else {
				
//						$menu_sidebar .= '<li><a href="#"  onclick="loadFragment(\'#page-wrapper\',\''.site_url().@$jj->path_menu.'\'); return false;"><i class="fa fa-'.@$jj->icon_menu.' fa-fw"></i> '.@$hslqueryd[0]->nama_item.'</a></li>';
                $menu_sidebar .= '<li><a href="' . site_url() . 'admin/' . @$jj->path_menu . '"><i class="fa fa-' . @$jj->icon_menu . ' fa-fw"></i> <span class="'.($level==1?"masked":"").'">' . @$hslqueryd[0]->nama_item . '</span></a></li>';
            }
        }
        return $menu_sidebar;
    }

}
