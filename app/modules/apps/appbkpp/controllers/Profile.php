<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Profile extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_pegawai');
    }

    ///////////////////////////////////////////////////////////////////////////////////
    public function index()
    {
        $data['satu'] = "Data Pegawai";
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_master($id_pegawai);
        
        $foto = $this->m_pegawai->ini_pegawai_foto($id_pegawai);
        $data['fotoSrc']=site_url()."assets/file/".$foto->foto;

        $jabatan = end($this->m_pegawai->ini_pegawai_jabatan($id_pegawai));
        $data['data']->tmt_jabatan=$jabatan->tmt_jabatan;

        $data['cpns']=$this->m_pegawai->ini_cpns($id_pegawai);
        $data['pns']=$this->m_pegawai->ini_pns($id_pegawai);
        $data['kontrak']=$this->m_pegawai->ini_kontrak($id_pegawai);
        $data['capeg']=$this->m_pegawai->ini_capeg($id_pegawai);
        $data['tetap']=$this->m_pegawai->ini_tetap($id_pegawai);

        $pangkat = end($this->m_pegawai->ini_pegawai_pangkat($id_pegawai));
        $data['data']->tmt_pangkat=$pangkat->tmt_golongan;
        $data['data']->nama_pangkat=$pangkat->nama_pangkat;
        $data['data']->nama_golongan=$pangkat->nama_golongan;

        $this->load->view('profile/index', $data);
    }

    public function utama()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_master($id_pegawai);
        $this->load->view('profile/utama', $data);
    }

    public function anak()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_anak($id_pegawai);
        $this->load->view('profile/anak', $data);
    }
    
    public function orangtua()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_orangtua($id_pegawai);
        $this->load->view('profile/orangtua', $data);
    }

    public function pernikahan()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_pernikahan($id_pegawai);
        $this->load->view('profile/pernikahan', $data);
    }

    public function alamat()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_alamat($id_pegawai);
        $this->load->view('profile/alamat', $data);
    }

    public function pendidikan()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pegawai_pendidikan($id_pegawai);
        $this->load->view('profile/pendidikan', $data);
    }
    
    public function kontrak()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_kontrak($id_pegawai);
        $this->load->view('profile/kontrak', $data);
    }
    
    public function capeg()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_capeg($id_pegawai);
        $this->load->view('profile/capeg', $data);
    }
    
    public function tetap()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_tetap($id_pegawai);
        $this->load->view('profile/tetap', $data);
    }
    
    public function cpns()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_cpns($id_pegawai);
        $this->load->view('profile/cpns', $data);
    }

    public function pns()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['data'] = $this->m_pegawai->ini_pns($id_pegawai);
        $this->load->view('profile/pns', $data);
    }

    public function kepangkatan()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['pangkat'] = $this->m_pegawai->ini_pegawai_pangkat($id_pegawai);
        $this->load->view('profile/pangkat', $data);
    }

    public function jabatan()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['jabatan'] = $this->m_pegawai->ini_pegawai_jabatan($id_pegawai);
        $this->load->view('profile/jabatan', $data);
    }

    // function kediklatan(){
    // $id_pegawai = $this->session->userdata('pegawai_info');
    // $data['id_pegawai'] = $id_pegawai;
    // $this->load->view('profile/kediklatan',$data);
    // }

    public function kediklatan()
    {
        $id_pegawai = $this->session->userdata('pegawai_info');
        $data['diklat'] = $this->m_pegawai->ini_pegawai_diklat($id_pegawai);
        $this->load->view('profile/kediklatan', $data);
    }
}
