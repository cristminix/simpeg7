<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Jabfung extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_jabfung');
        date_default_timezone_set('UTC');
    }


    public function index()
    {
        $data['satu'] = "Daftar Jabatan Fungsional";
        $data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
        $data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
        $data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
        $data['tipe'] = (isset($_POST['tipe']))?$_POST['tipe']:"jfu";
        $this->load->view('jabfung/index', $data);
    }
    public function getdata()
    {
        $tipe = $_POST['tipe'];
        
        $judul['jfu'] = "Daftar Jabatan Fungsional Umum";
        $judul['jft'] = "Daftar Jabatan Fungsional Tertentu";
        $judul['jft-staff'] = "Daftar Jabatan Guru";
        
        $data['judul'] = $judul[$tipe];

        $kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";
        $cari = $_POST['cari'];
        $data['count'] = $this->m_jabfung->hitung_jabfung($cari, $tipe);

        if ($data['count']==0) {
            $data['hslquery']="";
            $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
        } else {
            $batas=$_POST['batas'];
            $hal = ($_POST['hal']=="end")?ceil($data['count']/$batas):$_POST['hal'];
            $mulai=($hal-1)*$batas;
            $data['mulai']=$mulai+1;
            $data['hslquery'] = $this->m_jabfung->get_jabfung($cari, $mulai, $batas, $tipe);

            $data['pager'] = Modules::run("appskp/appskp/pagerB", $data['count'], $batas, $hal, $kehal);
        }
        echo json_encode($data);
    }
    public function formedit()
    {
        $data['idd']=$_POST['idd'];
        $data['unit'] = $this->m_jabfung->ini_jabfung($data['idd']);
        $this->load->view('jabfung/formedit', $data);
    }
    public function edit_aksi()
    {
        $this->form_validation->set_rules("kode_bkn", "Kode Jabatan", "trim|required|xss_clean");
        $this->form_validation->set_rules("nama_jabatan", "Nama Jabatan", "trim|required|xss_clean");
        $this->form_validation->set_rules("idd", "ID Jabatan", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $ddir=$this->m_jabfung->edit_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    public function formtambah()
    {
        $data['tipe'] = $_POST['tipe'];
        $this->load->view('jabfung/formtambah', $data);
    }
    public function tambah_aksi()
    {
        $this->form_validation->set_rules("kode_bkn", "Kode Jabatan", "trim|required|xss_clean");
        $this->form_validation->set_rules("nama_jabatan", "Nama Jabatan", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $ddir=$this->m_jabfung->tambah_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    public function formhapus()
    {
        $data['idd']=$_POST['idd'];
        $data['unit'] = $this->m_jabfung->ini_jabfung($data['idd']);
        $this->load->view('jabfung/formhapus', $data);
    }
    public function hapus_aksi()
    {
        $ddir=$this->m_jabfung->hapus_aksi($_POST);
        echo "sukses#"."add#";
    }
}
