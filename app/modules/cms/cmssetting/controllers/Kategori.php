<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Kategori extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('cmssetting/m_kanal');
		$this->auth->restrict();
	}
////////////////////////////////////////////////////////
//   NAIK / TURUN URUTAN ITEM
////////////////////////////////////////////////////////
	function urutitem(){
		$this->m_kanal->naik_index($_POST['id_ini'],$_POST['id_lawan'],$_POST['urutan_ini'],$_POST['urutan_lawan']);
	} 
////////////////////////////////////////////////////////
	function index(){
		$data['jform']="Pengaturan Rubrik Artikel Yang Ada dalam Kanal";
		$data['kanalall']=$this->m_kanal->getkanalall(0);
		$row=$this->m_kanal->getkanal(0);
		$data['kanal']="";
		foreach($row as $key=>$val){	$data['kanal'].="<option value='".$row[$key]->id_kanal."'>".$row[$key]->nama_kanal."";	}
		$this->load->view('kategori/index',$data);
	}

	function getkategori(){
		$id_kanal=$_POST['id_kanal'];
		$batas=$_POST['batas'];
		$dt=$this->m_kanal->hitung_kanalrubrik($id_kanal); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		if($dt['count']!=0){
			$data['hslquery']=$this->m_kanal->getkanalrubrik($mulai,$batas,$id_kanal);	
			foreach($data['hslquery'] as $it=>$val){
				$jj=json_decode($val->meta_value);
				$data['hslquery'][$it]->keterangan=$jj->keterangan;
					$kpn = $this->m_kanal->ini_komponen_by_nama($jj->komponen);
					$jkpn = json_decode($kpn[0]->meta_value);
				$data['hslquery'][$it]->komponen=$jkpn->label;
				$data['hslquery'][$it]->status=$jj->status;
				if(($mulai+$it)==0){	
					$data['hslquery'][$it]->naik="tidak";
				} else {
					$data['hslquery'][$it]->naik="ya";
					$data['hslquery'][$it]->id_lawan_naik=$data['hslquery'][$it-1]->id_kategori;
					$data['hslquery'][$it]->urutan_lawan_naik=$data['hslquery'][$it-1]->urutan;
				}
				if(($mulai+$it+1)==$dt['count']){
					$data['hslquery'][$it]->turun="tidak";
				} else {
					$data['hslquery'][$it]->turun="ya";
					$data['hslquery'][$it]->id_lawan_turun=$data['hslquery'][$it+1]->id_kategori;
					$data['hslquery'][$it]->urutan_lawan_turun=$data['hslquery'][$it+1]->urutan;
				}

					$cek = $this->m_kanal->cek_kategori($val->id_kategori);
					$data['hslquery'][$it]->j_konten=$cek[0]->j_konten;
					$data['hslquery'][$it]->hapus=($cek[0]->j_konten>0)?"tidak":"ya";
			}
		}
		$de = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}

	function formtambahkategori(){
		$data['idd'] = $_POST['idd'];
		$data['id_kanal'] = $_POST['id_kanal'];
		$kanalini=$this->m_kanal->ini_item($_POST['id_kanal']);
		$data['kanal'] = $kanalini[0]->nama_item;
			$kpn= Modules::run("cmshome/komponen_options");
			$data['komponen']="<select id=komponen onChange=\"lanjut();\" name=komponen class='ipt_text' style=\"width:200px;\">".$kpn."</select>";
		$this->load->view('kategori/formtambah_kategori',$data);
	}
	function tambah_kategori_aksi(){
		$this->m_kanal->tambah_kategori_aksi($_POST);
		echo "sukses#"."add#";
	}
	function formeditkategori($fix){
		$data['idd'] = $_POST['idd'];
		$data['id_kanal'] = $_POST['id_kanal'];
		$kanalini=$this->m_kanal->ini_item($_POST['id_kanal']);
		$data['kanal'] = $kanalini[0]->nama_item;
		$kategori = $this->m_kanal->ini_item($_POST['idd']);
			$jj = json_decode($kategori[0]->meta_value);
		$data['nama_kategori']=$kategori[0]->nama_item;
		$data['keterangan']=$jj->keterangan;

		if($fix=="ya"){
					$kpn= Modules::run("cmshome/komponen_options",$jj->komponen);
					$data['komponen']="<select id=komponen name=komponen class='ipt_text' style=\"width:200px;\">".$kpn."</select>";
		} else {
					$data['komponen']="<input type=hidden name=komponen id=komponen value='".$jj->komponen."'><div class='ipt_text' style=\"width:200px;\"><b>".$jj->komponen."</b></div>";
		}

		$this->load->view('kategori/formedit_kategori',$data);
	}
	function edit_kategori_aksi(){
		$this->m_kanal->edit_kategori_aksi($_POST);
		echo "sukses#"."add#";
	}
	function formhapuskategori(){
		$data['idd'] = $_POST['idd'];
		$data['id_kanal'] = $_POST['id_kanal'];
		$kanalini=$this->m_kanal->ini_item($_POST['id_kanal']);
		$data['kanal'] = $kanalini[0]->nama_item;
		$kat = $this->m_kanal->ini_item($_POST['idd']);
			$jj = json_decode($kat[0]->meta_value);
		$data['nama_kategori'] = $kat[0]->nama_item;
		$data['komponen'] = $jj->komponen;
		$data['keterangan'] = $jj->keterangan;
		$this->load->view('kategori/formhapus_kategori',$data);
	}
	function hapus_kategori_aksi(){
		$this->m_kanal->hapus_aksi($_POST['idd']);
		echo "sukses#"."add#";
	}

}
?>