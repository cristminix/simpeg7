<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pendidikan extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_pendidikan');
        date_default_timezone_set('UTC');
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function index()
    {
        $data['satu'] = "Daftar Pendidikan Formal";
        $data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
        $data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
        $data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
        $this->load->view('pendidikan/index', $data);
    }
    public function getdata()
    {
        $cari = $_POST['cari'];
        $data['count'] = $this->m_pendidikan->hitung_pendidikan($cari, $_POST['jenjang']);

        if ($data['count']==0) {
            $data['hslquery']="";
            $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
        } else {
            $batas=$_POST['batas'];
            $hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
            $mulai=($hal-1)*$batas;
            $data['mulai']=$mulai+1;
            $data['hslquery'] = $this->m_pendidikan->get_pendidikan($cari, $mulai, $batas, $_POST['jenjang']);

            $data['pager'] = Modules::run("appskp/appskp/pagerB", $data['count'], $batas, $hal);
        }
        echo json_encode($data);
    }
    public function formedit()
    {
        $data['idd']=$_POST['idd'];
        $data['unit'] = $this->m_pendidikan->ini_pendidikan($data['idd']);
        $this->load->view('pendidikan/formedit', $data);
    }
    public function edit_aksi()
    {
        // $this->form_validation->set_rules("username","Username","trim|required|xss_clean");
        // $this->form_validation->set_rules("nama_user","Nama Pengguna","trim|required|xss_clean");
        // $this->form_validation->set_rules("status","Nama Pengguna","trim|required|xss_clean");
        // $this->form_validation->set_rules("group","Grup Pengguna","trim|required|xss_clean");
        // $this->form_validation->set_rules("idd","ID User","trim|required|xss_clean");
        // if($this->form_validation->run()) {
        $ddir=$this->m_pendidikan->edit_aksi($_POST);
        echo "sukses#"."add#";
        // } else {
            // echo "error-".validation_errors()."#0";
         // }
    }
    public function formtambah()
    {
        $data['idd'] = $_POST['idd'];
        // $data['kode_jenjang'] = $_POST['kode_jenjang'];
        // $data['nama_pendidikan'] = $_POST['nama_pendidikan'];
        // $data['kode_bkn'] = $_POST['kode_bkn'];
        $this->load->view('pendidikan/formtambah', $data);
    }
    public function tambah_aksi()
    {
        // $this->form_validation->set_rules("username","Username","trim|required|xss_clean");
        // $this->form_validation->set_rules("nama_user","Nama Pengguna","trim|required|xss_clean");
        // $this->form_validation->set_rules("status","Nama Pengguna","trim|required|xss_clean");
        // $this->form_validation->set_rules("group","Grup Pengguna","trim|required|xss_clean");
        // if($this->form_validation->run()) {
        $ddir=$this->m_pendidikan->tambah_aksi($_POST);
        echo "sukses#"."add#";
        // } else {
            // echo "error-".validation_errors()."#0";
         // }
    }
    public function formhapus()
    {
        $data['idd']=$_POST['idd'];
        $data['unit'] = $this->m_pendidikan->ini_pendidikan($data['idd']);
        $this->load->view('pendidikan/formhapus', $data);
    }
    public function hapus_aksi()
    {
        $ddir=$this->m_pendidikan->hapus_aksi($_POST);
        echo "sukses#"."add#";
    }
}
