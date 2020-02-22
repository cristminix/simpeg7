<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Wrapper_kanal extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('cmssetting/m_kanal');
		$this->auth->restrict();
	}

	function index(){
		$data['jform']="Pengaturan Wrapper Yang Ada dalam Kanal";
		$data['kanalall']=$this->m_kanal->getkanalall(0,"wrapper");
		$row=$this->m_kanal->getkanal(0);
		$data['kanal']="";
		foreach($row as $key=>$val){	$data['kanal'].="<option value='".$row[$key]->id_kanal."'>".$row[$key]->nama_kanal."";	}
		$this->load->view('wrapper_kanal/index',$data);
	}

	function getkanalwrapper(){
		$id_kanal=$_POST['id_kanal'];
		$lokasi=$_POST['lokasi'];
		$batas=$_POST['batas'];
		$dt=$this->m_kanal->ini_item($id_kanal);
			$jj=json_decode($dt[0]->meta_value);
		$dt=$this->m_kanal->getkanalwrapper($jj->path_kanal,$lokasi); 

		if(!empty($dt)){

			$data['asli']=$dt[0]->meta_value;
			$data['lokasi']=$lokasi;

			$dk=json_decode($dt[0]->meta_value);
			$jj=$dk->widget;
			foreach($jj AS $key=>$val){
				$cr = $this->m_kanal->ini_item($val->id_wrapper);
				$jjj=json_decode($cr[0]->meta_value);
				@$data['hslquery'][$key]->id_wrapper=$val->id_wrapper;
				$data['hslquery'][$key]->nama_wrapper=$cr[0]->nama_item;
				$data['hslquery'][$key]->keterangan="";
				foreach($val->opsi AS $kk=>$vv){
					$data['hslquery'][$key]->keterangan.="<b>".$vv->label.":</b>".$vv->nilai.";<br/>";
				}
				$data['hslquery'][$key]->keterangan.="<br/>[ <span onclick=\"loadForm('formedit_setting/".$dt[0]->id_item."','".$val->id_wrapper."');\" class='text_aksi'>Edit...</span> ]";


				$data['hslquery'][$key]->asli=json_encode($val);
				$rb = explode(",",$jjj->id_kategori);
					$ck = $this->m_kanal->ini_item($jjj->id_widget);
					$jjjj = json_decode($ck[0]->meta_value);
				$data['hslquery'][$key]->widget=$ck[0]->nama_item;
					$kpn = $this->m_kanal->ini_komponen_by_nama($jjjj->komponen);
					$jkpn = json_decode($kpn[0]->meta_value);
				$data['hslquery'][$key]->komponen=$jkpn->label;
				$data['hslquery'][$key]->pengisi="";
					foreach($rb as $keyy=>$vall){
						$rbr = $this->m_kanal->ini_item($vall);
						$data['hslquery'][$key]->pengisi.=($keyy==0)?$rbr[0]->nama_item : (", ".$rbr[0]->nama_item);
					}
				
			}
		} else {
			$data['hslquery']="";
		}
		echo json_encode($data);
	}

	function formcontentwrapper($id){
		$data['idd'] = $id;
		$data['id_kanal'] = $_POST['id_kanal'];
		$dt=$this->m_kanal->ini_item($_POST['id_kanal']);
			$jj=json_decode($dt[0]->meta_value);
		$data['kanal'] = $dt[0]->nama_item;
		$data['path_kanal'] = $jj->path_kanal;
		$data['posisi'] = $_POST['piltab'];

		$dt=$this->m_kanal->getkanalwrapper($jj->path_kanal,$_POST['piltab']);
			$idw=array();
			$ido=array();
		if(!empty($dt)){
			$jj=json_decode(@$dt[0]->meta_value);
			foreach($jj->widget AS $key=>$val){
				$idw[$key]=@$val->id_wrapper;
				$ido[$val->id_wrapper]=json_encode(@$val->opsi);
			}
		}

		$pilwrapper=$this->m_kanal->getwrapper_by_posisi($_POST['piltab']);
		$data['pilisi'] = "";
		foreach($pilwrapper as $key=>$val){
			$seling=($key%2==0)?"even":"odd";
			
			$data['pilisi'].="<tr class=\"gridrow ".$seling."\" height=20>";
			$data['pilisi'].="<td class=\"gridcell left\">".($key+1)."</td><td class=\"gridcell\">";
			
			if(in_array($val->id_wrapper,$idw)){
				$jjk=$ido[$val->id_wrapper];
				$data['pilisi'].="<div style='display:none'><input type=checkbox name=widget_isi[]  id='pilisi_".$val->id_wrapper."' value='".$val->nama_widget."**".$val->id_widget."**".$val->id_wrapper."**".$jjk."**' checked></div>";
			} else {
				$iniwidget = $this->m_kanal->ini_item($val->id_widget);
				$jjw = json_decode($iniwidget[0]->meta_value);
				$jjk=json_encode($jjw->opsi);
				$data['pilisi'].="<input type=checkbox name=widget_isi[]  id='pilisi_".$val->id_wrapper."' value='".$val->nama_widget."**".$val->id_widget."**".$val->id_wrapper."**".$jjk."**'>";
			}
			$data['pilisi'].="</td><td class=\"gridcell\"><br/><div><b>".$val->nama_wrapper."</b></div><div>".$val->rubrik."</div><br/></td>";
			$data['pilisi'].="<td class=\"gridcell\"><br/><div><b>".$val->nama_widget."</b></div><div>".$val->komponen."</div><br/></td></tr>";
		}
		$this->load->view('wrapper_kanal/formcontent_wrapper_kanal',$data);
	}

	function edit_wrapper_aksi(){
		$this->m_kanal->edit_wrapper_aksi($_POST);
	}

	function save_wrapper_aksi(){
        $this->form_validation->set_rules("widget_isi[0]","Wrapper","trim|required|xss_clean");
		if($this->form_validation->run()) {
			$this->m_kanal->save_wrapper_aksi($_POST); 
			echo "sukses#"."add#";
		 } else {
			echo "error-".validation_errors()."#0";	
		 }
	}
	function formhapuswrapper(){
		$data['idd'] = $_POST['idd'];
		$data['id_kanal'] = $_POST['id_kanal'];
		$kanalini=$this->m_kanal->ini_item($_POST['id_kanal']);
		$data['kanal'] = $kanalini[0]->nama_item;
		$data['posisi'] = $_POST['piltab'];

		$wrapperini=$this->m_kanal->ini_item($_POST['idd']);
		$jj = json_decode($wrapperini[0]->meta_value);
		$data['pilisi'] = "<b>".$wrapperini[0]->nama_item."</b> (".$jj->keterangan.")<br>";

		$this->load->view('wrapper_kanal/formhapus_wrapper_kanal',$data);
	}

	function hapus_wrapper_aksi(){
		$this->m_kanal->hapus_wrapper_aksi($_POST); 
		echo "sukses#"."add#";
	}
	function formedit_setting($id_item){
		$data['id_item'] = $id_item;
		$data['id_wrapper'] = $_POST['idd'];
		$data['id_kanal'] = $_POST['id_kanal'];
			$kanalini = $this->m_kanal->ini_item($_POST['id_kanal']);
		$data['kanal'] = $kanalini[0]->nama_item;
			$wrapperini = $this->m_kanal->ini_item($_POST['idd']);
		$data['wrapper'] = $wrapperini[0]->nama_item;
		$data['posisi'] = $_POST['piltab'];
			$ini = $this->m_kanal->ini_item($id_item);
		$jj = json_decode($ini[0]->meta_value);


		foreach($jj->widget AS $key=>$val){
			if($val->id_wrapper==$_POST['idd']){
				$data['kl']=$val->opsi;
				$data['asli']="\"id_wrapper\":\"".$_POST['idd']."\",\"opsi\":".json_encode($val->opsi);
			}
		}

		$this->load->view('wrapper_kanal/formedit_wrapper_kanal_setting',$data);
	}
	function edit_setting_aksi(){
		$this->m_kanal->edit_setting_aksi($_POST); 
		echo "sukses#"."add#";
	}

}
?>