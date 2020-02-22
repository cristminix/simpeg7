<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_user');
        date_default_timezone_set('UTC');
    }


    public function index()
    {
        $data['satu'] = "Daftar Pengguna";
        $data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
        $data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
        $data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
        $data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"all";
        $this->load->view('user/index', $data);
    }
    public function getdata()
    {
        $tipe = $_POST['tipe'];
        
        $judul['jsuperadmin'] = "Daftar Super Admin";
        $judul['jadmin'] = "Daftar Admin";
        $judul['jpegawai'] = "Daftar Pegawai";
        
        // $data['judul'] = $judul[$tipe];

        $kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
        $cari = $_POST['cari'];
        $data['count'] = $this->m_user->hitung_user($cari, $tipe);

        if ($data['count']==0) {
            $data['hslquery']="";
            $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
        } else {
            $batas=$_POST['batas'];
            $hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
            $mulai=($hal-1)*$batas;
            $data['mulai']=$mulai+1;
            $data['hslquery'] = $this->m_user->get_user($cari, $mulai, $batas, $tipe);

            $data['pager'] = Modules::run("appskp/appskp/pagerB", $data['count'], $batas, $hal, $kehal);
        }
        echo json_encode($data);
    }
    public function formedit()
    {
        $data['idd']=$_POST['idd'];
        $data['unit'] = $this->m_user->ini_user($data['idd']);
        $this->load->view('user/formedit', $data);
    }
    public function edit_aksi()
    {
        $this->form_validation->set_rules("username", "Username", "trim|required|xss_clean");
        $this->form_validation->set_rules("nama_user", "Nama Pengguna", "trim|required|xss_clean");
        $this->form_validation->set_rules("status", "Nama Pengguna", "trim|required|xss_clean");
        $this->form_validation->set_rules("group", "Grup Pengguna", "trim|required|xss_clean");
        $this->form_validation->set_rules("idd", "ID User", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $ddir=$this->m_user->edit_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    public function formtambah()
    {
        $data['tipe'] = $_POST['tipe'];
        $this->load->view('user/formtambah', $data);
    }
    public function tambah_aksi()
    {
        $this->form_validation->set_rules("username", "Username", "trim|required|xss_clean");
        $this->form_validation->set_rules("nama_user", "Nama Pengguna", "trim|required|xss_clean");
        $this->form_validation->set_rules("status", "Nama Pengguna", "trim|required|xss_clean");
        $this->form_validation->set_rules("group", "Grup Pengguna", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $ddir=$this->m_user->tambah_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    public function formhapus()
    {
        $data['idd']=$_POST['idd'];
        $data['unit'] = $this->m_user->ini_user($data['idd']);
        $this->load->view('user/formhapus', $data);
    }
    public function hapus_aksi()
    {
        $ddir=$this->m_user->hapus_aksi($_POST);
        echo "sukses#"."add#";
    }
}
