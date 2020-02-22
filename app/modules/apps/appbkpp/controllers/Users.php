<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_user');
        date_default_timezone_set('UTC');
    }


    public function index()
    {
        $data['satu'] = "Daftar Struktur Organisasi & Struktur Jabatan";
        $data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
        $data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
        $data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";

        if ($this->session->userdata('group_id')=="6") {
            $this->load->view('unor/index_umpeg', $data);
        } else {
            $this->load->view('unor/index', $data);
        }
    }
    public function getdata()
    {
        $tanggal = (isset($_POST['tanggal']))?date("Y-m-d", strtotime($_POST['tanggal'])):"xx";

        $kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";


        $cari = $_POST['cari'];
        $data['count'] = $this->m_unor->hitung_master_unor($cari, $tanggal);

        if ($data['count']==0) {
            $data['hslquery']="";
            $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
        } else {
            $batas=$_POST['batas'];
            $hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
            $mulai=($hal-1)*$batas;
            $data['mulai']=$mulai+1;
            $data['hslquery'] = $this->m_unor->get_master_unor($cari, $mulai, $batas, $tanggal);
            foreach ($data['hslquery'] as $key=>$val) {
                $data['hslquery'][$key]->tmt_berlaku = date("d-m-Y", strtotime($val->tmt_berlaku));
                $data['hslquery'][$key]->tst_berlaku = date("d-m-Y", strtotime($val->tst_berlaku));
            }
            $data['pager'] = Modules::run("appskp/appskp/pagerB", $data['count'], $batas, $hal, $kehal);
        }
        echo json_encode($data);
    }
    public function formedit()
    {
        $data['unit'] = $this->m_unor->ini_unor($_POST['idd']);
        $data['unit']->tmt_berlaku = date("d-m-Y", strtotime($data['unit']->tmt_berlaku));
        $data['unit']->tst_berlaku = date("d-m-Y", strtotime($data['unit']->tst_berlaku));
        $this->load->view('unor/formedit', $data);
    }
    public function edit_aksi()
    {
        $this->form_validation->set_rules("nama_unor", "Nama Unor", "trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_jabatan", "Jabatan (nomenklatur)", "trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_pada", "Lokasi Jabatan (pada)", "trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_cari", "Index Pencarian", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $ese = $this->dropdowns->kode_ese();
            // $_POST['nama_ese']=$ese[$_POST['kode_ese']];
            $_POST['tmt_berlaku']=date("Y-m-d", strtotime($_POST['tmt_berlaku']));
            $_POST['tst_berlaku']=date("Y-m-d", strtotime($_POST['tst_berlaku']));
            $ddir=$this->m_unor->edit_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    public function formtambah()
    {
        $this->load->view('unor/formtambah');
    }
    public function tambah_aksi()
    {
        $this->form_validation->set_rules("nama_unor", "Nama Unor", "trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_jabatan", "Jabatan (nomenklatur)", "trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_pada", "Lokasi Jabatan (pada)", "trim|required|xss_clean");
        $this->form_validation->set_rules("nomenklatur_cari", "Index Pencarian", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $ese = $this->dropdowns->kode_ese();
            // $_POST['nama_ese']=$ese[$_POST['kode_ese']];
            $_POST['tmt_berlaku']=date("Y-m-d", strtotime($_POST['tmt_berlaku']));
            $_POST['tst_berlaku']=date("Y-m-d", strtotime($_POST['tst_berlaku']));
            $ddir=$this->m_unor->tambah_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }

    public function formcopy()
    {
        $data['unit'] = $this->m_unor->ini_unor($_POST['idd']);
        $data['unit']->tmt_berlaku = date("d-m-Y", strtotime($data['unit']->tmt_berlaku));
        $data['unit']->tst_berlaku = date("d-m-Y", strtotime($data['unit']->tst_berlaku));
        $this->load->view('unor/formcopy', $data);
    }

    public function formhapus()
    {
        $data['cekPegUnor'] =  $this->m_unor->cek_pegawai_unor($_POST['idd']);
        $data['unit'] = $this->m_unor->ini_unor($_POST['idd']);
        $data['unit']->tmt_berlaku = date("d-m-Y", strtotime($data['unit']->tmt_berlaku));
        $data['unit']->tst_berlaku = date("d-m-Y", strtotime($data['unit']->tst_berlaku));
        $this->load->view('unor/formhapus', $data);
    }
    public function hapus_aksi()
    {
        $this->m_unor->hapus_aksi($_POST);
        echo "sukses#"."add#";
    }

    public function formsetberlaku()
    {
        $data['idd'] = $_POST['idd'];
        $this->load->view('unor/formsetberlaku', $data);
    }
    public function setberlaku_aksi()
    {
        $dd=array("{","}");
        $unortt = 	explode(",", str_replace($dd, "", $_POST['idd']));
        $isi['tmt_berlaku']=date("Y-m-d", strtotime($_POST['tmt_berlaku']));
        $isi['tst_berlaku']=date("Y-m-d", strtotime($_POST['tst_berlaku']));

        foreach ($unortt as $key=>$val) {
            $isi['id_unor'] = $val;
            $this->m_unor->setberlaku_aksi($isi);
        }
        echo "sukses#"."add#";
    }

    public function master()
    {
        $data['satu'] = "Daftar Struktur Organisasi & Struktur Jabatan";
        $data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
        $data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
        $data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
        $this->load->view('unor/master', $data);
    }

    public function tree()
    {
        $data['satu']="Daftar Struktur Organisasi & Struktur Jabatan";

        if ($this->session->userdata('group_id')=="3") {
            $this->load->view('unor/tree_umpeg', $data);
        } else {
            $this->load->view('unor/tree', $data);
        }
    }

    public function gettree()
    {
        $tanggal = date("Y-m-d", strtotime($_POST['tanggal']));

        $level=($_POST['level']+1);
        $spare=3+(($level*20)-20);
        $lgh=5+(($level*3)-3);
        $id_parent=end(explode("_", $_POST['id_parent']));

        $iUnor = $this->m_unor->ini_unor($id_parent);
        $uUnor = ($_POST['id_parent']==0)?0:$iUnor->kode_unor;
        $data['hslquery'] = $this->m_unor->gettree($uUnor, $lgh, $tanggal);

        foreach ($data['hslquery'] as $it=>$val) {
            $id=$data['hslquery'][$it]->id_unor;
            $data['hslquery'][$it]->idparent=$_POST['id_parent'];
            $data['hslquery'][$it]->spare=$spare;
            $data['hslquery'][$it]->level=$level;
            $data['hslquery'][$it]->tmt_berlaku = date("d-m-Y", strtotime($val->tmt_berlaku));
            $data['hslquery'][$it]->tst_berlaku = date("d-m-Y", strtotime($val->tst_berlaku));
            $anak=$this->m_unor->gettree($data['hslquery'][$it]->kode_unor, ($lgh+3), $tanggal);
            $data['hslquery'][$it]->toggle=(!empty($anak))?"tutup":"buka";
            $data['hslquery'][$it]->idchild=($_POST['id_parent']==0)?$id:$_POST['id_parent']."_".$id;
        }
        $data['mulai'] = 1;
        $data['pager'] = "";
        echo json_encode($data);
    }
}
