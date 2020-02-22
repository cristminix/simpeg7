<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class User extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('cmssetting/m_user');
		$this->auth->restrict();
	}

	function index(){
		$data['jform']="Pengaturan Pengguna";
		$this->load->view('user/index',$data);
	}

	function getuser(){
		$batas=$_POST['batas'];
		$grup=$_POST['grup'];
		if($grup!="xx"){ $path=$grup; } else { $path="xx"; }
		$dt=$this->m_user->hitung_user($path); 

		if($dt['count']==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else { 

			if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
	
			$data['hslquery']=$this->m_user->getuser($mulai,$batas,$path)->result();
			foreach($data['hslquery'] as $it=>$val){
				$id=$data['hslquery'][$it]->user_id;
					$cek=$this->m_user->cek_user($id,$data['hslquery'][$it]->group_name);
					if(!empty($cek)){$data['hslquery'][$it]->cek="ada";}	else	{$data['hslquery'][$it]->cek="kosong";}
			}
			$de = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
			$data['pager']=$de;
		}
		echo json_encode($data);
	}
	function formtambah(){
		if($_POST['grup']=="xx"){
				$dt=$this->m_user->getusergroup()->result();
				$vv="\n<select id='group_id' name='gorup_id' class=ipt_text style=\"width:250px;\">\n<option value=''>-- Pilih --</option>\n";
				foreach($dt as $it=>$val){	$vv=$vv."<option value='".$val->group_id."'>".$val->group_name."</option>\n";	}
				$vv=$vv."</select>\n";
		} else {
				$dt=$this->m_user->detail_grup($_POST['grup'])->result();
				$vv="<input type=hidden id='group_id' name='group_id' value='".$dt[0]->id_item."'>";
				$vv=$vv."<b>".$dt[0]->nama_item."</b>";
		}
		$data['pilgr']=$vv;
		$this->load->view('user/formtambah_user',$data);
	}
	function tambah_aksi(){
		$ang=explode("*",$_POST['nama_user']);
			$ipp['nama_user']=$ang[0];
			$ipp['username']=$ang[1];
			$ipp['group_id']=$ang[2];
		$this->m_user->tambah_user_aksi($ipp);
	}
	function formedit(){
		$data['user_id']=$_POST['user_id'];
		$data['hslquery']=$this->m_user->detail_user($_POST['user_id']);
		$data['hslqueryb']=$this->m_user->getusergroup()->result();
		$this->load->view('user/formedit_user',$data);
	}
	function edit_aksi(){
		$idd=$_POST['user_id'];
		$ang=explode("*",$_POST['nama_user']);
			$ipp['nama_user']=$ang[0];
			$ipp['username']=$ang[1];
			$ipp['group_id']=$ang[2];
		$this->m_user->edit_user_aksi($idd,$ipp);
	}
	function formhapus(){
		$data['user_id']=$_POST['user_id'];
		$data['hslquery']=$this->m_user->detail_user($_POST['user_id']);
		$data['hslqueryb']=$this->m_user->getusergroup()->result();
		$this->load->view('user/formhapus_user',$data);
	}
	function hapus_aksi(){
		$idd=$_POST['user_id'];
		$this->m_user->hapus_user_aksi($idd);
	}

	function password(){
			$sess = $this->session->userdata('logged_in');
			$data['ssb'] = $sess;
			$data['nama_user'] = $sess['nama_user'];
			$data['user_id'] = $sess['id_user'];
			$data['username'] = $sess['username'];
			$data['group_name'] = $sess['group_name'];
			$sess = $this->session->all_userdata();
			$data['ssn'] = $sess;
			$data['PHPSESSID']= $this->session->userdata('session_id');
		$this->load->view('user/password',$data);
	}
	function edit_pw(){
		$idd=$_POST['idd'];
		$ang=explode("*",$_POST['hasil']);
			$ipp=$ang[0];
		$this->m_user->edit_password_aksi($idd,$ipp);
	}
////////////////////////////////////////////////////////////////////
}
?>