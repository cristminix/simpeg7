<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Widget extends MX_Controller{
	
	 public 	$total   = "";
	 public 	$title   = "";
	 private 	$qMethod = "";
	 public 	$columns = "";
	 public 	$month	 = array("1"=>"januari","2"=>"Pebruari","3"=>"maret","4"=>"april","5"=>"mei","6"=>"juni","7"=>"juli","8"=>"agustus","9"=>"september","10"=>"oktober","11"=>"november","12"=>"desember");
	 
	function __construct() {
        parent::__construct();
        $this->load->model('appbkpp/m_pegawai');
        $this->load->model('appbkpp/m_unor');
        $this->load->model('m_widget','dBase');
        $this->load->library('mypdf');
        date_default_timezone_set('UTC');
    }
	
	function index(){
			$module = $this->uri->segment(4);
			if($this->uri->segment(5)=="" && $this->uri->segment(4)!=""){
				$this->$module(array(),false);
			} else if(method_exists($this,$module)) {
				$params = array();
				$params = $this->uri->segment_array();
				unset($params[1]);
				unset($params[2]);
				unset($params[3]);
				unset($params[4]);
				$this->$module(array_values($params),false);
			}else{
				$url = array();
				for($i=3;$i<=$this->uri->total_segments();$i++){
					array_push($url,$this->uri->segment($i));
				}
				$newMod = implode("/", $url);
				echo modules::run($newMod);
				//var_dump($newMod);
			}
	}
	
	function form_search_pegawai($param=array(),$unset=array()){
		$data['unor'] = $this->m_unor->gettree(0, 5, "2015-01-01");
        $data['pkt'] = $this->dropdowns->kode_golongan_pangkat();
        $data['jbt'] = $this->dropdowns->jenis_jabatan();
        $data['agama'] = $this->dropdowns->agama();
        $data['status_pegawai'] = $this->dropdowns->status_pegawai();
        $data['kelompok_pegawai'] = $this->dropdowns->kelompok_pegawai();
        $data['status'] = $this->dropdowns->status_perkawinan();
        $data['jenjang'] = $this->dropdowns->kode_jenjang_pendidikan();
		$data['param'] = $param;
		$data['unset'] = $unset;
		return $this->load->view("widget/form_search_peg",$data,true);
	}
	
	function displayGrid($param){
		if(!isset($param['search'])){
			$param['search'] = '';
		}
		$this->load->view('widget/grid',$param);
	}
	
	private function generateColumns($basicCols,$filtered = false){
		$newColumns=array();
		foreach($basicCols as $cols){
			$newColumns[$cols]["name"] 		= $cols;
			$newColumns[$cols]["display"] 	= false;
			$newColumns[$cols]["title"] 	= ucwords(str_replace("_"," ",$cols));
		}
		return $newColumns;
	}
	
	function kenaikan_berkala($param,$stat=true){
		if(is_array($param) && $stat === true){
			$this->qMethod = $this->dBase->get_kenaikan_berkala($param[0]);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Bulan ".date("F", mktime(0, 0, 0, date("n")+$param[0], 10));
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				
				$filter = $_POST;
				$limit 	= "";
				if(isset($_POST["year"]) && isset($_POST["month"])){
					$date1	= date_create(date("Y-m"));
					$date2	= date_create(date('Y-m',strtotime($_POST['year'].'-'.$_POST["month"])));
					$params = ((date_diff($date1, $date2)->format('%R%y') * 12) + date_diff($date1, $date2)->format('%R%m'));
				}else{
					$params = $param[0];
				}
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				$this->total = $this->dBase->get_kenaikan_berkala($params,$filter)->num_rows();
				$this->qMethod = $this->dBase->get_kenaikan_berkala($params,$filter,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button class='btn btn-success' onclick='getForm(".$_data[$key]["id_pegawai"].")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 		= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Kenaikan Berkala"." Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$params, 10))."";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_kenaikan_berkala($param[0]);
				$this->total = $this->qMethod->num_rows();
				$_data["title"] 	= "Kenaikan Berkala"." <span class='periodName'>Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$param[0], 10))."</span>";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="Nip";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["status_pegawai"]["display"]=true;
					$_data["columns"]["tmt_pangkat"]["display"]=true;
				$_data["action"] 	= base_url()."appbkpp/pegawai/formpangkat";
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$_data["search"]	= $this->form_search_pegawai();
				$_data["periode"]	= true;
				$_data["param"]		= $param[0];
				$this->displayGrid($_data);
			}
		}
	}
	
	function kenaikan_peringkat($param,$stat=true){
		if(is_array($param) && $stat === true){
			$this->qMethod = $this->dBase->get_kenaikan_peringkat($param[0]);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Bulan ".date("F", mktime(0, 0, 0, date("n")+$param[0], 10));
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				if(isset($_POST["year"]) && isset($_POST["month"])){
					$date1	= date_create(date("Y-m"));
					$date2	= date_create(date('Y-m',strtotime($_POST['year'].'-'.$_POST["month"])));
					$params = ((date_diff($date1, $date2)->format('%R%y') * 12) + date_diff($date1, $date2)->format('%R%m'));
				}else{
					$params = $param[0];
				}
				
				$this->total = $this->dBase->get_kenaikan_peringkat($params,$filter)->num_rows();
				$this->qMethod = $this->dBase->get_kenaikan_peringkat($params,$filter,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button class='btn btn-success' onclick='getForm(".$_data[$key]["id_pegawai"].")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 		= $number;
					$number++;
				}
				
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Kenaikan Peringkat"." Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$params, 10))."";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_kenaikan_peringkat($param[0]);
				$_data["title"] 	= "Kenaikan Peringkat"." <span class='periodName'>Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$param[0], 10))."</span>";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="Nip";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["status_pegawai"]["display"]=true;
					$_data["columns"]["tmt_pangkat"]["display"]=true;
				$_data["batas"] 	= "10";
				$_data["action"] 	= base_url()."appbkpp/pegawai/formpangkat";
				$_data["url"] 		= $this->uri->uri_string();
				$_data["search"]	= $this->form_search_pegawai();
				$_data["periode"]	= true;
				$_data["param"]		= $param[0];
				$this->displayGrid($_data);
			}
			
		}
	}
	
	function cuti($param,$stat=true){
		
		if(!isset($_POST['delData'])){
		
		if(empty($param)){
			$param = 0;
		}
			if(is_array($param) && $stat === true){
				$this->qMethod = $this->dBase->get_cuti($param);
				$_data = $this->qMethod;
				$this->total = $_data->num_rows();
				$this->title = "Bulan ".date("F", mktime(0, 0, 0, date("n")+$param[0], 10));
				return $this;
			}else{
				if($this->input->is_ajax_request()){
					$filter = $_POST;
					$_POST["hal"] = (isset($_POST["hal"])?$_POST["hal"]:'1');
					$limit = "";
					if(!empty($_POST) && isset($_POST["batas"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
						$limit = " ORDER BY id_cuti DESC LIMIT ".$_POST['batas']." OFFSET ".$start."";
						if(isset($_POST["export"])){
							$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
							$limit = " ORDER BY id_cuti DESC LIMIT 200 OFFSET ".$start." ";
						}
					}
					if(isset($_POST["year"]) && isset($_POST["month"])){
						$date1	= date_create(date("Y-m"));
						$date2	= date_create(date('Y-m',strtotime($_POST['year'].'-'.$_POST["month"])));
						$params = ((date_diff($date1, $date2)->format('%R%y') * 12) + date_diff($date1, $date2)->format('%R%m'));
					}else{
						$params = $param;
					}
					$this->total = $this->dBase->get_cuti($params,$filter)->num_rows();
					$this->qMethod = $this->dBase->get_cuti($params,$filter,$limit);
					$_data = $this->qMethod->result_array();
					$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
					foreach($_data as $key=>$value){
						$_data[$key]["aksi"] 	= "<button class='btn btn-danger' onclick='hapusData(".$_data[$key]["id_cuti"].")'><i class='fa fa-minus'></i></button> <button class='btn btn-info' onclick='modalLink(\"".base_url()."widget/getCutiPdf/".$_data[$key]["id_cuti"]."\")'><i class='fa fa-search'></i></button>";
						$_data[$key]["no"] 		= $number;
						$number++;
					}
					if(!isset($_POST['export'])){
						$data = array("hslquery"=>$_data,"param"=>$this->total);
						$data['bat_print'] = 200;
						$data['seg_print'] = ceil($this->total / $data['bat_print']);
						$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
					}else{
						$title 	= "Cuti"." Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$params, 10))."";
						$columns = $_POST["cols"];
						$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
					}
					echo json_encode($data);
					exit();
				}else{
					$this->qMethod = $this->dBase->get_cuti($param);
					$_data["title"] 	= "Pegawai Cuti"." <span class='periodName'> Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$param[0], 10))."</span>";
					$_data["search"] 	= "";
					$_data["action"] 	= "";
					$_data["cari"] 		= "";
						$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
						$_data["columns"]["nip_baru"]["display"]=true;
						$_data["columns"]["nip_baru"]["title"]="Nip";
						$_data["columns"]["nama_pegawai"]["display"]=true;
						$_data["columns"]["nomenklatur_pada"]["display"]=true;
						$_data["columns"]["nomenklatur_pada"]["title"]="Unit Kerja";
						$_data["columns"]["tgl_cuti"]["display"]=true;
						$_data["columns"]["tgl_cuti"]["title"]="Tanggal Cuti";
						$_data["columns"]["remarks"]["display"]=true;
						$_data["columns"]["remarks"]["title"]="Keterangan";
					$_data["action"] 	= base_url()."widget/form_cuti";
					$_data["batas"] 	= "10";
					$_data["url"] 		= $this->uri->uri_string();
					$_data["search"]	= $this->form_search_pegawai();
					$_data["act"]		= "<a href='#' onclick='getForm()'><i class='fa fa-plus-square-o'></i> Tambah Data Cuti</a>";
					$_data["periode"]	= true;
					$_data["param"]		= $param[0];
					$this->displayGrid($_data);
				}
			}
		}else{
			$data = $this->dBase->remove_cuti();
			if($data){
				$res = array("result"=>"success");
			}else{
				$res = array("result"=>"failed");
			}
			echo json_encode($res);
		}
	}
	
	function pegawaiList(){
		$data = $this->dBase->get_pegawai()->result_array();
		echo json_encode($data);
	}
	
	function form_cuti(){
		echo $this->load->view('form_cuti');
	}
	
	function getCutiPdf($id){
		$data = $this->dBase->get_detail_cuti($id)->row();
		if($data){
			$res["result"] 	= "success";
			$res["title"] 	= "FORM CUTI";
			$res["content"] = '<iframe src = "../../../ViewerJS/#../widget/genCutiPdf/'.$id.'" width="100%" height="500" allowfullscreen webkitallowfullscreen></iframe>';
		}else{
			$res["result"] 	= "failed";
			$res["title"] 	= "FORM CUTI";
			$res["content"] = "Data Tidak Ditemukan...";
		}
		echo json_encode($res);
	}
	
	function genCutiPdf($id){
		$data = $this->dBase->get_detail_cuti($id)->row();
		$html               = $this->load->view('cutipdf', $data, true);
		$pdfFilePath        = "form_cuti.pdf";
			$this->mypdf->AddPage();
			$this->mypdf->SetFillColor(255, 255, 127);
			$this->mypdf->SetFont("", "", 9,"", "false");
			$this->mypdf->writeHTML($html, true, false, true, false, '');
			$this->mypdf->Output($pdfFilePath,'I');
	}
	
	function upCuti(){
		$data = $this->dBase->insert_cuti();
		if($data){
			$res = array("result"=>"success");
		}else{
			$res = array("result"=>"failed");
		}
		echo json_encode($res);
	}
	
	function pensiun($param,$stat=true){
		if(is_array($param) && $stat === true){
			$this->qMethod = $this->dBase->get_pensiun($param[0]);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Bulan ".date("F", mktime(0, 0, 0, date("n")+$param[0], 10));
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				if(isset($_POST["year"]) && isset($_POST["month"])){
					$date1	= date_create(date("Y-m"));
					$date2	= date_create(date('Y-m',strtotime($_POST['year'].'-'.$_POST["month"])));
					$params = ((date_diff($date1, $date2)->format('%R%y') * 12) + date_diff($date1, $date2)->format('%R%m'));
				}else{
					$params = $param[0];
				}
				$this->total = $this->dBase->get_pensiun($params,$filter)->num_rows();
				$this->qMethod = $this->dBase->get_pensiun($params,$filter,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button key='${key}' class='btn btn-success' onclick='setSub( \"pensiun\",".$_data[$key]["id_pegawai"].",".$number.")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 		= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Pegawai Pensiun"." Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$params, 10))."";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_pensiun($param[0]);
				$_data["title"] 	= "Pegawai Pensiun"." <span class='periodName'> Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$param[0], 10))."</span>";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="Nip";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["status_pegawai"]["display"]=true;
					$_data["columns"]["tanggal_lahir"]["display"]=true;
				$_data["action"] 	= base_url()."appbkpp/pegawai/formsub_pensiun";
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$_data["search"]	= $this->form_search_pegawai();
				$_data["periode"]	= true;
				$_data["param"]		= $param[0];
				$this->displayGrid($_data);
			}
		}
	}
	
	function kontrak($param,$stat=true){
		if(is_array($param) && $stat === true){
			$this->qMethod = $this->dBase->get_kontrak($param[0]);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Bulan ".date("F", mktime(0, 0, 0, date("n")+$param[0], 10));
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				if(isset($_POST["year"]) && isset($_POST["month"])){
					$date1	= date_create(date("Y-m"));
					$date2	= date_create(date('Y-m',strtotime($_POST['year'].'-'.$_POST["month"])));
					$params = ((date_diff($date1, $date2)->format('%R%y') * 12) + date_diff($date1, $date2)->format('%R%m'));
				}else{
					$params = $param[0];
				}
				$this->total = $this->dBase->get_kontrak($params,$filter)->num_rows();
				$this->qMethod = $this->dBase->get_kontrak($params,$filter,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button class='btn btn-success' onclick='viewDetailPegawai(".$_data[$key]["id_pegawai"].",\"id_pegawai\")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 		= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Pegawai Kontrak"." Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$params, 10))."";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_kontrak($param[0]);
				$_data["title"] 	= "Pegawai Kontrak"." <span class='periodName'>Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$param[0], 10))."</span>";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="Nip";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["status_pegawai"]["display"]=true;
					$_data["columns"]["tmt_kontrak"]["display"]=true;
					$_data["columns"]["mk_bl"]["display"]=true;
					$_data["columns"]["mk_bl"]["title"]="Lama Bulan";
				$_data["action"] 	= base_url()."datapegawai/getprofile";
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$_data["search"]	= $this->form_search_pegawai();
				$_data["periode"]	= true;
				$_data["param"]		= $param[0];
				$this->displayGrid($_data);
			}
		}
	}
	
	function capeg($param,$stat=true){
		if(is_array($param) && $stat === true){
			$this->qMethod = $this->dBase->get_capeg($param[0]);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Bulan ".date("F", mktime(0, 0, 0, date("n")+$param[0], 10));
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				if(isset($_POST["year"]) && isset($_POST["month"])){
					$date1	= date_create(date("Y-m"));
					$date2	= date_create(date('Y-m',strtotime($_POST['year'].'-'.$_POST["month"])));
					$params = ((date_diff($date1, $date2)->format('%R%y') * 12) + date_diff($date1, $date2)->format('%R%m'));
				}else{
					$params = $param[0];
				}
				$this->total = $this->dBase->get_capeg($params,$filter)->num_rows();
				$this->qMethod = $this->dBase->get_capeg($params,$filter,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button class='btn btn-success' onclick='viewDetailPegawai(".$_data[$key]["id_pegawai"].",\"id_pegawai\")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 		= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Data Capeg"." Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$params, 10))."";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_capeg($param[0]);
				$_data["title"] 	= "Calon Pegawai"." <span class='periodName'>Bulan ".date("F Y", mktime(0, 0, 0, date("n")+$param[0], 10))."</span>";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="Nip";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["status_pegawai"]["display"]=true;
					$_data["columns"]["tmt_capeg"]["display"]=true;
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$_data["search"]	= $this->form_search_pegawai();
				$_data["periode"]	= true;
				$_data["param"]		= $param[0];
				$this->displayGrid($_data);
			}
		}
	}
	
	function tunjangan_anak($param=array(),$stat=true){
		if($stat === true){
			$this->qMethod = $this->dBase->get_tunjangan_anak($param);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Tunjangan Anak";
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				$this->total = $this->dBase->get_tunjangan_anak($param)->num_rows();
				$this->qMethod = $this->dBase->get_tunjangan_anak($param,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button class='btn btn-success' onclick='loadForm(".$_data[$key]["id_pegawai"].",".$_data[$key]["id_peg_anak"].",\"anak\",\"form\",\"form_anak\")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 			= $number;
					$_data[$key]["gender_anak"] = ($_data[$key]["gender_anak"] =="l"?"Laki-Laki":"Perempuan");
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Tunjangan Anak";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_tunjangan_anak($param);
				$_data["title"] 	= "Tunjangan Anak";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nama_anak"]["display"]=true;
					$_data["columns"]["tanggal_lahir_anak"]["display"]=true;
					$_data["columns"]["keterangan"]["display"]=true;
					$_data["columns"]["gender_anak"]["display"]=true;
					$_data["columns"]["gender_anak"]["title"]="Jenis Kelamin";
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="NIP Orang Tua";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["nama_pegawai"]["title"]="Nama Orang Tua";
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$this->displayGrid($_data);
			}
		}
	}
	
	function pegawai_sotk($param=array(),$stat=true){
		if($stat === true){
			$this->qMethod = $this->dBase->get_peg_sotk(true,$param);
			$_data = $this->qMethod->result_array();
			return $_data;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				$this->total = $this->dBase->get_peg_sotk(false,$param,$filter)->num_rows();
				$this->qMethod = $this->dBase->get_peg_sotk(false,$param,$filter,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:$_POST["batas"]*($_POST["hal"]-1)+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "<button class='btn btn-success' onclick='viewDetailPegawai(".$_data[$key]["id_pegawai"].",\"id_pegawai\")'><i class='fa fa-pencil-square-o'></i></button>";
					$_data[$key]["no"] 		= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Pegawai SOTK ".$_data[0]["nomenklatur_pada"];
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$filter = $_POST;
				$this->qMethod = $this->dBase->get_peg_sotk(false,$param,$filter);
				$title = $this->qMethod->result_array();
				$_data["title"] 	= "Monitoring Pegawai SOTK ";
				$_data["search"] 	= "";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="Nip";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["status_pegawai"]["display"]=true;
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$_data["search"]	= $this->form_search_pegawai(array("kode_unor"=>$param));
				$this->displayGrid($_data);
			}
		}
	}
	
	function sanksi($param=array(),$stat = true){
		if($stat === true){
			$this->qMethod = $this->dBase->get_rekap_p_sanksi($param);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "Penghargaan Dan Sanksi";
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				$this->total = $this->dBase->get_rekap_p_sanksi($param)->num_rows();
				$this->qMethod = $this->dBase->get_rekap_p_sanksi($param,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "-";
					$_data[$key]["no"] 			= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "Penghargaan Dan Sanksi";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_rekap_p_sanksi($param,"",false);
				$_data["title"] 	= "Penghargaan Dan Sanksi";
				$_data["search"] 	= "<br></br><form class='form-inline'>
									  <select name='kategori' id='kategori' class='form-control' onchange='gridpaging(1)'>
									  <option value='penghargaan'>Penghargaan</option>
									  <option value='sanksi'>Sanksi</option>
									  </select>
									  </form>";
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="NIP";
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["nama_pegawai"]["title"]="Nama";
					$_data["columns"]["nomor_sk"]["display"]=true;
					$_data["columns"]["tanggal_sk"]["display"]=true;
					$_data["columns"]["uraian"]["display"]=true;
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$this->displayGrid($_data);
				
			}
		}
	}
	
	function nominatif($param=array(),$stat = true){
		if($stat === true){
			$this->qMethod = $this->dBase->get_nominatif($param);
			$_data = $this->qMethod;
			$this->total = $_data->num_rows();
			$this->title = "NOMINATIF PEGAWAI";
			return $this;
		}else{
			if($this->input->is_ajax_request()){
				$filter = $_POST;
				$limit = "";
				$_POST["hal"] = (isset($_POST["hal"])?$_POST["hal"]:1);
				if(!empty($_POST) && isset($_POST["batas"])){
					$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*$_POST["batas"]:$_POST["hal"]-1);
					$limit = " LIMIT ".$_POST['batas']." OFFSET ".$start."";
					if(isset($_POST["export"])){
						$start = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
						$limit = " LIMIT 200 OFFSET ".$start."";
					}
				}
				$this->total = $this->dBase->get_nominatif($param)->num_rows();
				$this->qMethod = $this->dBase->get_nominatif($param,$limit);
				$_data = $this->qMethod->result_array();
				$number	= ($_POST["hal"]==1?1:($_POST["batas"]*($_POST["hal"]-1))+1);
				foreach($_data as $key=>$value){
					$_data[$key]["aksi"] 	= "-";
					$_data[$key]["no"] 			= $number;
					$number++;
				}
				if(!isset($_POST['export'])){
					$data = array("hslquery"=>$_data,"param"=>$this->total);
					$data['bat_print'] = 200;
					$data['seg_print'] = ceil($this->total / $data['bat_print']);
					$data['pager'] = Modules::run("appskp/appskp/pagerB", $this->total, $_POST["batas"], $_POST["hal"]);
				}else{
					$title 	= "NOMINATIF PEGAWAI";
					$columns = $_POST["cols"];
					$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
				}
				echo json_encode($data);
				exit();
			}else{
				$this->qMethod = $this->dBase->get_nominatif($param,"",false);
				$_data["title"] 	= "NOMINATIF PEGAWAI";
				$_data["search"]	= $this->form_search_pegawai();
				$_data["action"] 	= "";
				$_data["cari"] 		= "";
					$_data["columns"] = $this->generateColumns($this->qMethod->list_fields());
					$_data["columns"]["nama_pegawai"]["display"]=true;
					$_data["columns"]["nama_pegawai"]["title"]="Nama Pegawai";
					$_data["columns"]["nip_baru"]["display"]=true;
					$_data["columns"]["nip_baru"]["title"]="NIP Pegawai";
					$_data["columns"]["nomenklatur_jabatan"]["display"]=true;
					$_data["columns"]["nomenklatur_jabatan"]["title"]="Jabatan";
					$_data["columns"]["nomenklatur_pada"]["display"]=true;
					$_data["columns"]["nomenklatur_pada"]["title"]="Bagian";
					$_data["columns"]["gender"]["display"]=true;
					$_data["columns"]["gender"]["title"]="Jenis Kelamin";
					$_data["columns"]["nama_jenjang"]["display"]=true;
					$_data["columns"]["nama_jenjang"]["title"]="Pendidikan";
					$_data["columns"]["tmt_tetap"]["display"]=true;
					$_data["columns"]["tmt_tetap"]["title"]="Tanggal Masuk Kerja";
					$_data["columns"]["tanggal_lahir"]["display"]=true;
					$_data["columns"]["tanggal_pensiun"]["display"]=true;
					$_data["columns"]["selisih_pensiun"]["display"]=true;
					$_data["columns"]["selisih_pensiun"]["title"]="MK S/D PENSIUN";
				$_data["batas"] 	= "10";
				$_data["url"] 		= $this->uri->uri_string();
				$this->displayGrid($_data);
				
			}
		}
	}
}