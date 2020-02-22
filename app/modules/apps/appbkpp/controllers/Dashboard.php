<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_unor');
        $this->load->model('appbkpp/m_pegawai');
        $this->load->model('appbkpp/m_dashboard');
        $this->load->model('appskp/m_skp');
        $this->load->library('notifpanel');
    }

    public function index()
    {
        $data['dash_list'] = $this->m_dashboard->getDashlist();

//                $data['unor'] = $this->m_unor->gettree(0,5,date("Y-m-d"));
        ////        $data['unor'] = array();
        //            foreach($data['unor'] AS $key=>$val){
        //                $j_all = $this->m_dashboard->hitung_pegawai($val->kode_unor);
        //                $j_kontrak = $this->m_dashboard->hitung_pegawai($val->kode_unor,"Kontrak");
        //                $j_capeg = $this->m_dashboard->hitung_pegawai($val->kode_unor,"Capeg");
        //                $j_tetap = $this->m_dashboard->hitung_pegawai($val->kode_unor,"Tetap");
        //                $data['unor'][$key]->j_all = $j_all;
        //                $data['unor'][$key]->j_kontrak = $j_kontrak;
        //                $data['unor'][$key]->j_capeg = $j_capeg;
        //                $data['unor'][$key]->j_tetap = $j_tetap;
        //            }
        //        $golongan = $this->dropdowns->kode_golongan_pangkat();
        //        $data['golongan'] = array();
        //            foreach($golongan as $key=>$val){    if($key!=""){
        //                    $jl = $this->m_dashboard->hitung_pegawai_golongan($key,"l");
        //                    $jp = $this->m_dashboard->hitung_pegawai_golongan($key,"p");
        //                    @$data['golongan'][$key]->nama = $val;
        //                    @$data['golongan'][$key]->l = $jl;
        //                    @$data['golongan'][$key]->p = $jp;
        //            }}
        //
        //        $pendidikan = $this->dropdowns->kode_jenjang_pendidikan();
        //        $data['pendidikan'] = array();
        //            foreach($pendidikan as $key=>$val){    if($key!=""){
        //                    $jl = $this->m_dashboard->hitung_pegawai_pendidikan($val,"l");
        //                    $jp = $this->m_dashboard->hitung_pegawai_pendidikan($val,"p");
        //                    @$data['pendidikan'][$key]->nama = $val;
        //                    @$data['pendidikan'][$key]->l = $jl;
        //                    @$data['pendidikan'][$key]->p = $jp;
        //            }}
        //
        //        $jabatan = $this->dropdowns->jenis_jabatan();
        //        $data['jabatan'] = array();
        //            foreach($jabatan as $key=>$val){    if($key!=""){
        //                    $jl = $this->m_dashboard->hitung_pegawai_jabatan($key,"l");
        //                    $jp = $this->m_dashboard->hitung_pegawai_jabatan($key,"p");
        //                    @$data['jabatan'][$key]->nama = $val;
        //                    @$data['jabatan'][$key]->l = $jl;
        //                    @$data['jabatan'][$key]->p = $jp;
        //            }}
        //
        //
        //        $kawin = $this->dropdowns->status_perkawinan();
        //        $data['kawin'] = array();
        //            foreach($kawin as $key=>$val){    if($key!=""){
        //                    $jl = $this->m_dashboard->hitung_pegawai_kawin($key,"l");
        //                    $jp = $this->m_dashboard->hitung_pegawai_kawin($key,"p");
        //                    @$data['kawin'][$key]->nama = $val;
        //                    @$data['kawin'][$key]->l = $jl;
        //                    @$data['kawin'][$key]->p = $jp;
        //            }}
        //
        //        $gender = $this->dropdowns->gender();
        //        $data['gender'] = array();
        //            foreach($gender as $key=>$val){    if($key!=""){
        //                    $jl = $this->m_dashboard->hitung_pegawai_gender($key,"l");
        //                    $jp = $this->m_dashboard->hitung_pegawai_gender($key,"p");
        //                    @$data['gender'][$key]->nama = $val;
        //                    @$data['gender'][$key]->l = $jl;
        //                    @$data['gender'][$key]->p = $jp;
        //            }}

        $this->load->view('dashboard/index', $data);
    }

    public function getPanel()
    {
        return $this->notifpanel->metrotiles();
    }
    public function monografi()
    {
        $data['dash_list'] = $this->m_dashboard->getDashlist();
        $data['unor']      = $this->m_unor->gettree(0, 5, date("Y-m-d"));
        //        $data['unor'] = array();
        foreach ($data['unor'] as $key => $val) {
            $j_all                         = $this->m_dashboard->hitung_pegawai($val->kode_unor);
            $j_kontrak                     = $this->m_dashboard->hitung_pegawai($val->kode_unor, "Kontrak");
            $j_capeg                       = $this->m_dashboard->hitung_pegawai($val->kode_unor, "Capeg");
            $j_tetap                       = $this->m_dashboard->hitung_pegawai($val->kode_unor, "Tetap");
            $j_khusus                      = $this->m_dashboard->hitung_pegawai($val->kode_unor, "Khusus");
                $data['unor'][$key] = new stdClass();

            $data['unor'][$key]->j_all     = $j_all;
            $data['unor'][$key]->j_kontrak = $j_kontrak;
            $data['unor'][$key]->j_capeg   = $j_capeg;
            $data['unor'][$key]->j_tetap   = $j_tetap;
            $data['unor'][$key]->j_khusus  = $j_khusus;
        }
        $golongan         = $this->dropdowns->kode_golongan_pangkat();
        $data['golongan'] = array();
        foreach ($golongan as $key => $val) {
            if ($key != "") {
                $jl                            = $this->m_dashboard->hitung_pegawai_golongan($key, "l");
                $jp                            = $this->m_dashboard->hitung_pegawai_golongan($key, "p");
                $data['golongan'][$key] = new stdClass();

                @$data['golongan'][$key]->nama = $val;
                @$data['golongan'][$key]->l    = $jl;
                @$data['golongan'][$key]->p    = $jp;
            }
        }

        $pendidikan         = $this->dropdowns->kode_jenjang_pendidikan();
        $data['pendidikan'] = array();
        foreach ($pendidikan as $key => $val) {
            if ($key != "") {
                $jl                              = $this->m_dashboard->hitung_pegawai_pendidikan($val, "l");
                $jp                              = $this->m_dashboard->hitung_pegawai_pendidikan($val, "p");
                $data['pendidikan'][$key] = new stdClass();

                @$data['pendidikan'][$key]->nama = $val;
                @$data['pendidikan'][$key]->l    = $jl;
                @$data['pendidikan'][$key]->p    = $jp;
            }
        }

        $jabatan         = $this->dropdowns->jenis_jabatan();
        $data['jabatan'] = array();
        foreach ($jabatan as $key => $val) {
            if ($key != "") {
                $jl                           = $this->m_dashboard->hitung_pegawai_jabatan($key, "l");
                $jp                           = $this->m_dashboard->hitung_pegawai_jabatan($key, "p");
                $data['jabatan'][$key] = new stdClass();

                @$data['jabatan'][$key]->nama = $val;
                @$data['jabatan'][$key]->l    = $jl;
                @$data['jabatan'][$key]->p    = $jp;
            }
        }

        $kawin         = $this->dropdowns->status_perkawinan();
        $data['kawin'] = array();
        foreach ($kawin as $key => $val) {
            if ($key != "") {
                $jl                         = $this->m_dashboard->hitung_pegawai_kawin($key, "l");
                $jp                         = $this->m_dashboard->hitung_pegawai_kawin($key, "p");
                $data['kawin'][$key] = new stdClass();

                @$data['kawin'][$key]->nama = $val;
                @$data['kawin'][$key]->l    = $jl;
                @$data['kawin'][$key]->p    = $jp;
            }
        }

        $gender         = $this->dropdowns->gender();
        $data['gender'] = array();
        foreach ($gender as $key => $val) {
            if ($key != "") {
                $jl                          = $this->m_dashboard->hitung_pegawai_gender($key, "l");
                $jp                          = $this->m_dashboard->hitung_pegawai_gender($key, "p");
                $data['gender'][$key] = new stdClass();
                @$data['gender'][$key]->nama = $val;
                @$data['gender'][$key]->l    = $jl;
                @$data['gender'][$key]->p    = $jp;
            }
        }

        $this->load->view('dashboard/monografi', $data);
    }
    public function pegawai()
    {
        $id_pegawai               = $this->session->userdata('pegawai_info');
        $data['kelola_skp']       = $this->m_skp->get_skp_kelola($id_pegawai);
        $data['kelola_realisasi'] = $this->m_skp->get_realisasi_kelola($id_pegawai);
        $data['skp']              = $this->m_skp->get_skp($id_pegawai);
        $data['peg']              = $this->m_skp->get_pegawai($id_pegawai);

        $this->load->view('dashboard/pegawai', $data);
    }

    public function verifikatur()
    {
        $data['satu'] = "satu";
        $this->load->view('dashboard/verifikatur', $data);
    }

    public function umpeg()
    {
        $data['satu'] = $this->session->userdata('user_id');
        $data['dua']  = $this->session->userdata('nama_unor');
        $data['unor'] = array();

        $this->load->model('appbkpp/m_umpeg');
        $user_id = $this->session->userdata('user_id');
        $user    = $this->m_umpeg->ini_user($user_id);
        $dd      = array("{", "}");
        $acl     = str_replace($dd, "", $user->unor_akses);

        $data['j_pns_l']  = $this->m_dashboard->hitung_pegawai_unor($acl, "pns", "l");
        $data['j_pns_p']  = $this->m_dashboard->hitung_pegawai_unor($acl, "pns", "p");
        $data['j_cpns_l'] = $this->m_dashboard->hitung_pegawai_unor($acl, "cpns", "l");
        $data['j_cpns_p'] = $this->m_dashboard->hitung_pegawai_unor($acl, "cpns", "p");

        $golongan         = $this->dropdowns->kode_golongan_pangkat();
        $data['golongan'] = array();
        foreach ($golongan as $key => $val) {
            if ($key != "") {
                $jl                            = $this->m_dashboard->hitung_pegawai_golongan($key, "l", $acl);
                $jp                            = $this->m_dashboard->hitung_pegawai_golongan($key, "p", $acl);
                @$data['golongan'][$key]->nama = $val;
                @$data['golongan'][$key]->l    = $jl;
                @$data['golongan'][$key]->p    = $jp;
            }
        }

        $pendidikan         = $this->dropdowns->kode_jenjang_pendidikan();
        $data['pendidikan'] = array();
        foreach ($pendidikan as $key => $val) {
            if ($key != "") {
                $jl                              = $this->m_dashboard->hitung_pegawai_pendidikan($val, "l", $acl);
                $jp                              = $this->m_dashboard->hitung_pegawai_pendidikan($val, "p", $acl);
                @$data['pendidikan'][$key]->nama = $val;
                @$data['pendidikan'][$key]->l    = $jl;
                @$data['pendidikan'][$key]->p    = $jp;
            }
        }

        $jabatan         = $this->dropdowns->jenis_jabatan();
        $data['jabatan'] = array();
        foreach ($jabatan as $key => $val) {
            if ($key != "") {
                $jl                           = $this->m_dashboard->hitung_pegawai_jabatan($key, "l", $acl);
                $jp                           = $this->m_dashboard->hitung_pegawai_jabatan($key, "p", $acl);
                @$data['jabatan'][$key]->nama = $val;
                @$data['jabatan'][$key]->l    = $jl;
                @$data['jabatan'][$key]->p    = $jp;
            }
        }

        $perkawinan         = $this->dropdowns->status_perkawinan();
        $data['perkawinan'] = array();
        foreach ($perkawinan as $key => $val) {
            if ($key != "") {
                $jl                              = $this->m_dashboard->hitung_pegawai_perkawinan($val, "l", $acl);
                $jp                              = $this->m_dashboard->hitung_pegawai_perkawinan($val, "p", $acl);
                @$data['perkawinan'][$key]->nama = $val;
                @$data['perkawinan'][$key]->l    = $jl;
                @$data['perkawinan'][$key]->p    = $jp;
            }
        }

        $agama         = $this->dropdowns->agama();
        $data['agama'] = array();
        foreach ($agama as $key => $val) {
            if ($key != "") {
                $jl                         = $this->m_dashboard->hitung_pegawai_agama($val, "l", $acl);
                $jp                         = $this->m_dashboard->hitung_pegawai_agama($val, "p", $acl);
                @$data['agama'][$key]->nama = $val;
                @$data['agama'][$key]->l    = $jl;
                @$data['agama'][$key]->p    = $jp;
            }
        }

        $this->load->view('dashboard/umpeg', $data);
    }
    public function mutasi()
    {
        $data['satu'] = "satu";
        $this->load->view('dashboard/mutasi', $data);
    }
}
