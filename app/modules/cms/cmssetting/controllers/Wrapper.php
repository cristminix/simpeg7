<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Wrapper extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_setting');
		$this->auth->restrict();
	}

	function index(){
		$data['jform']="Pengaturan Wrapper";
		$row=$this->m_setting->getwidget(0,0);
		$data['widget']="";
		foreach($row as $key=>$val){
			$data['widget'].="<option value='".$val->id_item."'>".$val->nama_item."";
		}
		$this->load->view('wrapper/index',$data);
	}

	function getwrapper(){
		$id_widget=$_POST['id_widget'];

		$ini_widget = $this->m_setting->ini_item($id_widget);
		$re = json_decode($ini_widget[0]->meta_value);
		$data['posisi']="<b>".ucfirst($re->lokasi_widget)."</b>";

		$batas=$_POST['batas'];
		$dt=$this->m_setting->hitung_wrapper($id_widget); 

		if($_POST['hal']=="end"){	$hal=ceil($dt['count']/$batas);		} else {	$hal=$_POST['hal'];	}
		$mulai=($hal-1)*$batas;
		$data['mulai']=$mulai+1;

		if($dt['count']!=0){
			$data['hslquery']=$this->m_setting->getwrapper($mulai,$batas,$id_widget)->result();	
			foreach($data['hslquery'] as $it=>$val){
					$jj=json_decode($val->meta_value);
					$data['hslquery'][$it]->nama_wrapper=$val->nama_item;
					$data['hslquery'][$it]->keterangan=$jj->keterangan;
	
					if($jj->id_kategori){
						$rb = explode(",",$jj->id_kategori);
						$data['hslquery'][$it]->pengisi="";
						foreach($rb as $keyy=>$vall){
							$rbr = $this->m_setting->ini_item($vall);
							$data['hslquery'][$it]->pengisi.=($keyy==0)?$rbr[0]->nama_item : (", ".$rbr[0]->nama_item);
						}
					} else {
						$data['hslquery'][$it]->pengisi="";
					}

									$kk = $this->m_setting->getkanalpemakaiwrapper_by_idwrapper($val->id_item);
									$data['hslquery'][$it]->kanal = "";
									foreach($kk AS $ky=>$vl){
										$jkn = json_decode($vl->meta_value);
										$knl = $this->m_setting->ini_item($jkn->id_kanal);
										$data['hslquery'][$it]->kanal.= ($ky==0)?$knl[0]->nama_item:", ".$knl[0]->nama_item;
									}
					

			}
		}
		$de = Modules::run("cmshome/pagerB",$dt['count'],$batas,$hal);
		$data['pager']=$de;
		echo json_encode($data);
	}


	function formtambah_wrapper(){
			$rbr = $this->m_setting->ini_item($_POST['id_widget']);
			$jj = json_decode($rbr[0]->meta_value);
		$data['id_widget'] = $_POST['id_widget'];
		$data['nama_widget'] = $rbr[0]->nama_item;
		$data['posisi'] = $jj->lokasi_widget;
		$data['komponen'] = $jj->komponen;
			$rbk = $this->m_setting->getkategori_by_komponen($jj->komponen);
						
		$data['pilisi']="";
		foreach($rbk as $key=>$val){
			$jb=json_decode($val->meta_value);
			$seling=($key%2==0)?"even":"odd";
			$data['pilisi'].="<tr class=\"gridrow ".$seling."\" height=20>";
			$data['pilisi'].="<td class=\"gridcell left\">".($key+1)."</td><td class=\"gridcell\">";
			$data['pilisi'].="<input type=checkbox name=widget_isi[] id=widget_isi value='".$val->id_item."'>";
			$data['pilisi'].="</td><td class=\"gridcell\">".$val->nama_item."</td><td class=\"gridcell\">".$jb->keterangan."</td></tr>";
		}
		$this->load->view('wrapper/formtambah_wrapper',$data);
	}

	function tambah_wrapper_aksi(){
		$this->m_setting->tambah_wrapper_aksi($_POST);
		echo "sukses#"."add#";
	}

	function formedit_wrapper(){
			$rbw = $this->m_setting->ini_item($_POST['idd']);
			$jw = json_decode($rbw[0]->meta_value);
		$data['nama_wrapper'] = $rbw[0]->nama_item;
		$data['keterangan'] = $jw->keterangan;
			$dkat = explode(",",$jw->id_kategori);
			$rbr = $this->m_setting->ini_item($_POST['id_widget']);
			$jj = json_decode($rbr[0]->meta_value);
		$data['idd'] = $_POST['idd'];
		$data['id_widget'] = $_POST['id_widget'];
		$data['nama_widget'] = $rbr[0]->nama_item;
		$data['posisi'] = $jj->lokasi_widget;
		$data['komponen'] = $jj->komponen;
			$rbk = $this->m_setting->getkategori_by_komponen($jj->komponen);
		$data['pilisi']="";
		foreach($rbk as $key=>$val){
			$jb=json_decode($val->meta_value);
			$seling=($key%2==0)?"even":"odd";
			$data['pilisi'].="<tr class=\"gridrow ".$seling."\" height=20>";
			$data['pilisi'].="<td class=\"gridcell left\">".($key+1)."</td><td class=\"gridcell\">";
			$data['pilisi'].= (in_array($val->id_item,$dkat)) ? "<input type=checkbox checked name=widget_isi[] id=widget_isi value='".$val->id_item."'>" : "<input type=checkbox name=widget_isi[] id=widget_isi value='".$val->id_item."'>" ;
			$data['pilisi'].="</td><td class=\"gridcell\">".$val->nama_item."</td><td class=\"gridcell\">".$jb->keterangan."</td></tr>";
		}
		$this->load->view('wrapper/formedit_wrapper',$data);
	}
	function edit_wrapper_aksi(){
		$this->m_setting->edit_wrapper_aksi($_POST);
		echo "sukses#"."add#";
	}
	function formhapus_wrapper(){
			$rbw = $this->m_setting->ini_item($_POST['idd']);
			$jw = json_decode($rbw[0]->meta_value);
		$data['nama_wrapper'] = $rbw[0]->nama_item;
		$data['keterangan'] = $jw->keterangan;
			$dkat = explode(",",$jw->id_kategori);
			$rbr = $this->m_setting->ini_item($_POST['id_widget']);
			$jj = json_decode($rbr[0]->meta_value);
		$data['idd'] = $_POST['idd'];
		$data['id_widget'] = $_POST['id_widget'];
		$data['nama_widget'] = $rbr[0]->nama_item;
		$data['posisi'] = $jj->lokasi_widget;
		$data['komponen'] = $jj->komponen;
			$rbk = $this->m_setting->getkategori_by_komponen($jj->komponen);
		$data['pilisi']="";$no=1;
		foreach($rbk as $key=>$val){
			if(in_array($val->id_item,$dkat)){
			$jb=json_decode($val->meta_value);
			$seling=($key%2==0)?"even":"odd";
			$data['pilisi'].="<tr class=\"gridrow ".$seling."\" height=20>";
			$data['pilisi'].="<td class=\"gridcell left\">".$no."</td>";
			$data['pilisi'].="<td class=\"gridcell\">".$val->nama_item."</td><td class=\"gridcell\">".$jb->keterangan."</td></tr>";
			$no++;
			}
		}
		$this->load->view('wrapper/formhapus_wrapper',$data);
	}
	function hapus_wrapper_aksi(){
		$this->m_setting->hapus_item_aksi($_POST['idd']);
		echo "sukses#"."add#";
	}

}
?>