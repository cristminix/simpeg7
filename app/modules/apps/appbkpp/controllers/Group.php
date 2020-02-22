<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Group extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('appbkpp/m_user');
        $this->auth->restrict();
    }

    public function index()
    {
        $data['default']="amin";
        $this->load->view('group/index', $data);
    }
    public function getusergroup()
    {
        $data['hslquery']=$this->m_user->getusergroup()->result();
        foreach ($data['hslquery'] as $it=>$val) {
            $jj = json_decode($val->meta_value);

            $data['hslquery'][$it]->section_name=$jj->section_name;
            $data['hslquery'][$it]->back_office=$jj->back_office;
            $data['hslquery'][$it]->keterangan=$jj->keterangan;
            $cek=$this->m_user->cek_grup($val->group_id)->result();
            $data['hslquery'][$it]->cek=(!empty($cek))?"ada":"kosong";
        }
        echo json_encode($data['hslquery']);
    }
    ///////////////////////////////////////////////////////////////////////////////
    public function formtambahgroup()
    {
        $data="asdkj";
        $this->load->view('group/formtambah_group', $data);
    }
    public function tambah_group_aksi()
    {
        $this->form_validation->set_rules("nama_section", "Nama Section", "required");
        if ($this->form_validation->run()) {
            $this->m_user->tambah_grup_aksi($_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    ////////////////////////////////////////////////////////////////////
    public function formeditgroup()
    {
        $data['group_id']=$_POST['group_id'];
        $hslquery=$this->m_user->detail_grup($_POST['group_id'])->result();
        $jj = json_decode($hslquery[0]->meta_value);
        $data['group_name']=$hslquery[0]->nama_item;
        $data['section_name']=$jj->section_name;
        $data['backoffice']=$jj->back_office;
        $data['keterangan']=$jj->keterangan;
        $this->load->view('group/formedit_group', $data);
    }
    public function edit_group_aksi()
    {
        $this->form_validation->set_rules("nama_section", "Nama Section", "required");
        if ($this->form_validation->run()) {
            $this->m_user->edit_grup_aksi($_POST['idd'], $_POST);
            echo "sukses#"."add#";
        } else {
            echo "error-".validation_errors()."#0";
        }
    }
    ////////////////////////////////////////////////////////////////////
    public function formhapusgroup()
    {
        $data['group_id']=$_POST['group_id'];
        $hslquery=$this->m_user->detail_grup($_POST['group_id'])->result();
        $jj = json_decode($hslquery[0]->meta_value);
        $data['group_name']=$hslquery[0]->nama_item;
        $data['section_name']=$jj->section_name;
        $data['backoffice']=$jj->back_office;
        $data['keterangan']=$jj->keterangan;
        $this->load->view('group/formhapus_group', $data);
    }
    public function hapus_group_aksi()
    {
        $group_id=$_POST['idd'];
        $this->m_user->hapus_grup_aksi($group_id);
        echo "sukses#"."add#";
    }
}
