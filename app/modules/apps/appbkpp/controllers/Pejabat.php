<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pejabat extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_unor');
        $this->load->model('appbkpp/m_pegawai');
        date_default_timezone_set('UTC');
    }


    public function index()
    {
        $data['satu'] = "Daftar Pemangku Jabatan";
        $data['hal'] = (isset($_POST['hal']))?$_POST['hal']:1;
        $data['batas'] = (isset($_POST['batas']))?$_POST['batas']:10;
        $data['cari'] = (isset($_POST['cari']))?$_POST['cari']:"";
        $this->load->view('pejabat/index', $data);
    }
    public function getdata()
    {
        $tanggal = (isset($_POST['tanggal']))?date("Y-m-d", strtotime($_POST['tanggal'])):"xx";

        $kehal = (isset($_POST['kehal']))?$_POST['kehal']:"paging";


        $cari = $_POST['cari'];
        $data['count'] = $this->m_unor->hitung_master_unor($cari, $tanggal, "eselon");

        if ($data['count']==0) {
            $data['hslquery']="";
            $data['pager'] = "<input type=hidden id='inputpaging' value='1'>";
        } else {
            $batas=$_POST['batas'];
            $hal = ($_POST['hal']=="end")?ceil($dt['count']/$batas):$_POST['hal'];
            $mulai=($hal-1)*$batas;
            $data['mulai']=$mulai+1;
            $data['hslquery'] = $this->m_unor->get_master_unor($cari, $mulai, $batas, $tanggal, "eselon");
            foreach ($data['hslquery'] as $ky=>$vl) {
                $pejabat = $this->m_unor->get_pejabat($vl->id_unor);
                foreach ($pejabat as $key=>$val) {
                    $data['hslquery'][$ky]->pejabat[$key]['id_pegawai'] = $val->id_pegawai;
                    $data['hslquery'][$ky]->pejabat[$key]['nama_pegawai'] = ((trim($val->gelar_depan) != '-')?trim($val->gelar_depan).' ':'').((trim($val->gelar_nonakademis) != '-')?trim($val->gelar_nonakademis).' ':'').$val->nama_pegawai.((trim($val->gelar_belakang) != '-')?', '.trim($val->gelar_belakang):'');
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

    public function tree()
    {
        $data['satu']="Daftar Pemangku Jabatan";
        $this->load->view('pejabat/tree', $data);
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
            $anak=$this->m_unor->gettree($data['hslquery'][$it]->kode_unor, ($lgh+3), $tanggal);
            $data['hslquery'][$it]->toggle=(!empty($anak))?"tutup":"buka";
            $data['hslquery'][$it]->idchild=($_POST['id_parent']==0)?$id:$_POST['id_parent']."_".$id;



            $pejabat = $this->m_unor->get_pejabat($val->id_unor);
            foreach ($pejabat as $key=>$vl) {
                $data['hslquery'][$it]->pejabat[$key]['id_pegawai'] = $vl->id_pegawai;
                $data['hslquery'][$it]->pejabat[$key]['nama_pegawai'] = ((trim($vl->gelar_depan) != '-')?trim($vl->gelar_depan).' ':'').((trim($vl->gelar_nonakademis) != '-')?trim($vl->gelar_nonakademis).' ':'').$vl->nama_pegawai.((trim($vl->gelar_belakang) != '-')?', '.trim($vl->gelar_belakang):'');
                $data['hslquery'][$it]->pejabat[$key]['nip_baru'] = $vl->nip_baru;
                $data['hslquery'][$it]->pejabat[$key]['nama_pangkat'] = $vl->nama_pangkat;
                $data['hslquery'][$it]->pejabat[$key]['nama_golongan'] = $vl->nama_golongan;
                $data['hslquery'][$it]->pejabat[$key]['tmt_pangkat'] = date("d-m-Y", strtotime($vl->tmt_pangkat));
                $data['hslquery'][$it]->pejabat[$key]['tmt_jabatan'] = date("d-m-Y", strtotime($vl->tmt_jabatan));
                // $data['hslquery'][$it]->pejabat[$key]['tmt_ese'] = date("d-m-Y", strtotime($vl->tmt_ese));
            }
        }
        $data['mulai'] = 1;
        $data['pager'] = "";
        echo json_encode($data);
    }




    public function formlihat()
    {
        $id_pegawai = $_POST['idd'];

        $this->session->set_userdata("pegawai_info", $id_pegawai);
        $data['data'] = $this->m_pegawai->ini_pegawai_master($id_pegawai);

        $foto = $this->m_pegawai->ini_pegawai_foto($id_pegawai);
        $data['fotoSrc']=site_url()."assets/file/".$foto->foto;

        $jabatan = end($this->m_pegawai->ini_pegawai_jabatan($id_pegawai));
        $data['data']->tmt_jabatan=$jabatan->tmt_jabatan;

        $data['cpns']=$this->m_pegawai->ini_cpns($id_pegawai);
        $data['pns']=$this->m_pegawai->ini_pns($id_pegawai);

        $pangkat = end($this->m_pegawai->ini_pegawai_pangkat($id_pegawai));
        $data['data']->tmt_pangkat=$pangkat->tmt_golongan;
        $data['data']->nama_pangkat=$pangkat->nama_pangkat;
        $data['data']->nama_golongan=$pangkat->nama_golongan;

        $this->load->view('pejabat/profile', $data);
    }






    public function formedit()
    {
    }
    public function edit_aksi()
    {
    }
    public function formtambah()
    {
        $this->load->view('unor/formtambah');
    }
    public function tambah_aksi()
    {
    }

    public function formcopy()
    {
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
}
