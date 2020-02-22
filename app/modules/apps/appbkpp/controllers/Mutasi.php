<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mutasi extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_mutasi');
        $this->load->model('appbkpp/m_unor');
        $this->load->model('appbkpp/m_pegawai');
        date_default_timezone_set('UTC');
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function index()
    {
        $data['satu'] = "Mutasi Pegawai";
        $data['hal'] = (isset($_POST['hal'])) ? $_POST['hal'] : 1;
        $data['batas'] = (isset($_POST['batas'])) ? $_POST['batas'] : 10;
        $data['cari'] = (isset($_POST['cari'])) ? $_POST['cari'] : "";
        $this->load->view('mutasi/index', $data);
    }

    public function cari_nip()
    {
        $this->form_validation->set_rules("nip", "NIP", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $data = $this->m_pegawai->get_pegawai_by_nip($_POST['nip']);
        } else {
            $data = "";
        }
        echo json_encode($data);
    }

    public function cari_nip_kandidat()
    {
        $this->form_validation->set_rules("nip", "NIP", "trim|required|xss_clean");
        if ($this->form_validation->run()) {
            $data = $this->m_pegawai->get_pegawai_by_nip($_POST['nip']);
            if (!empty($data)) {
                $id_rancangan = $this->session->userdata('id_rancangan');
                $cek_jabatan = $this->m_mutasi->cek_jabatan_pegawai($data->id_pegawai, $id_rancangan);
                if (!empty($cek_jabatan)) {
                    $this->m_mutasi->mutasi($data, $_POST, $id_rancangan);
                } else {
                    $this->m_mutasi->promosi($data, $_POST, $id_rancangan);
                }
            }
        } else {
            $data = "";
        }
        echo json_encode($data);
    }

    public function rancangan()
    {
        $data['satu'] = "Rancangan Mutasi";
        $data['hal'] = (isset($_POST['hal'])) ? $_POST['hal'] : 1;
        $data['batas'] = (isset($_POST['batas'])) ? $_POST['batas'] : 10;
        $data['cari'] = (isset($_POST['cari'])) ? $_POST['cari'] : "";

        $rancangan = $this->m_mutasi->get_rancangan();
        if (!empty($rancangan)) {
            $idrancangan = $this->session->userdata('idrancangan');
            if ($idrancangan == "") {
                $pilih = end($rancangan);
                $this->session->set_userdata("id_rancangan", $pilih->id_rancangan);
            } else {
                $this->session->set_userdata("id_rancangan", $idrancangan);
            }
            $this->session->set_userdata("idrancangan", "");
            $id_rancangan = $this->session->userdata('id_rancangan');
            $data['id_rancangan'] = $id_rancangan;
            $data['rancangan'] = $this->m_mutasi->ini_rancangan($id_rancangan);
            $this->load->view('mutasi/rancangan', $data);
        } else {
            $data['id_rancangan'] = "xx";
            $this->load->view('mutasi/rancangan_pertama', $data);
        }
    }

    public function getdata()
    {
        $id_rancangan = $this->session->userdata('id_rancangan');
        $tanggal = (isset($_POST['tanggal'])) ? date("Y-m-d", strtotime($_POST['tanggal'])) : "xx";
        $kehal = (isset($_POST['kehal'])) ? $_POST['kehal'] : "paging";
        $cari = $_POST['cari'];
        $data['count'] = $this->m_unor->hitung_master_unor($cari, $tanggal, "eselon");

        if ($data['count'] == 0) {
            $data['hslquery'] = "";
            $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
        } else {
            $batas = $_POST['batas'];
            $hal = ($_POST['hal'] == "end") ? ceil($dt['count'] / $batas) : $_POST['hal'];
            $mulai = ($hal - 1) * $batas;
            $data['mulai'] = $mulai + 1;
            $data['hslquery'] = $this->m_unor->get_master_unor($cari, $mulai, $batas, $tanggal, "eselon");
            foreach ($data['hslquery'] as $ky => $vl) {
                $pejabat = $this->m_mutasi->get_pejabat_rancangan($vl->id_unor, $id_rancangan);
                foreach ($pejabat as $key => $val) {
                    $data['hslquery'][$ky]->pejabat[$key]['nama_pegawai'] = ((trim($val->gelar_depan) != '-') ? trim($val->gelar_depan) . ' ' : '') . ((trim($val->gelar_nonakademis) != '-') ? trim($val->gelar_nonakademis) . ' ' : '') . $val->nama_pegawai . ((trim($val->gelar_belakang) != '-') ? ', ' . trim($val->gelar_belakang) : '');
                    $data['hslquery'][$ky]->pejabat[$key]['id_pegawai'] = $val->id_pegawai;
                    $data['hslquery'][$ky]->pejabat[$key]['nip_baru'] = $val->nip_baru;
                    $data['hslquery'][$ky]->pejabat[$key]['nama_pangkat'] = $val->nama_pangkat;
                    $data['hslquery'][$ky]->pejabat[$key]['nama_golongan'] = $val->nama_golongan;
                    $data['hslquery'][$ky]->pejabat[$key]['tmt_pangkat'] = date("d-m-Y", strtotime($val->tmt_pangkat));
                    $data['hslquery'][$ky]->pejabat[$key]['tmt_jabatan'] = date("d-m-Y", strtotime($val->tmt_jabatan));
                    $data['hslquery'][$ky]->pejabat[$key]['tmt_ese'] = date("d-m-Y", strtotime($val->tmt_ese));
                }
            }
            $data['pager'] = Modules::run("appskp/appskp/pagerB", $data['count'], $batas, $hal, $kehal);
        }
        echo json_encode($data);
    }

    public function arsip()
    {
        $data['rancangan'] = $this->m_mutasi->get_rancangan();
        $this->load->view('mutasi/rancangan_arsip', $data);
    }

    public function baru()
    {
        $this->load->view('mutasi/rancangan_baru');
    }

    public function baru_aksi()
    {
        $this->m_mutasi->rancangan_baru_aksi($_POST);
        echo "success";
    }

    public function edit()
    {
        $data['isi'] = $this->m_mutasi->ini_rancangan($_POST['idd']);
        $this->load->view('mutasi/rancangan_baru', $data);
    }

    public function edit_aksi()
    {
        $this->m_mutasi->rancangan_edit_aksi($_POST);
        $this->session->set_userdata("idrancangan", $_POST['id_rancangan']);
        echo "success";
    }

    public function hapus()
    {
        $data['isi'] = $this->m_mutasi->ini_rancangan($_POST['idd']);
        $this->load->view('mutasi/rancangan_hapus', $data);
    }

    public function hapus_aksi()
    {
        $this->m_mutasi->rancangan_hapus_aksi($_POST);
        echo "success";
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    public function alih_rancangan()
    {
        $this->session->set_userdata("idrancangan", $_POST['idd']);
        echo "success";
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////
    public function formsub_lihat()
    {
        $id_pegawai = $_POST['idd'];
        $data['id_unor'] = $_POST['nomor'];

        $this->session->set_userdata("pegawai_info", $id_pegawai);


        $data['data'] = $this->m_pegawai->ini_pegawai_master($id_pegawai);

        $foto = $this->m_pegawai->ini_pegawai_foto($id_pegawai);
        $data['fotoSrc'] = site_url() . "assets/file/" . $foto->foto;

        $jabatan = end($this->m_pegawai->ini_pegawai_jabatan($id_pegawai));
        $data['data']->tmt_jabatan = $jabatan->tmt_jabatan;

        $data['cpns'] = $this->m_pegawai->ini_cpns($id_pegawai);
        $data['pns'] = $this->m_pegawai->ini_pns($id_pegawai);

        $pangkat = end($this->m_pegawai->ini_pegawai_pangkat($id_pegawai));
        $data['data']->tmt_pangkat = $pangkat->tmt_golongan;
        $data['data']->nama_pangkat = $pangkat->nama_pangkat;
        $data['data']->nama_golongan = $pangkat->nama_golongan;

        $this->load->view('mutasi/formsub_lihat', $data);
    }
}
