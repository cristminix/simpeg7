<?php
class Absensi extends MX_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("m_absen","dAbs");
	}
	
	public function index(){
		
	}
	
	public function dashboard(){
		$data["panel"][]=array("title"=>"Jumlah Pegawai","content"=>$this->empl_list(false,true),"color"=>"","mod"=>"widget/absensi/empl_list","init"=>"0");
		$data["panel"][]=array("title"=>"Jumlah Pegawai Hadir","content"=>$this->empl_att(false,true),"mod"=>"widget/absensi/empl_att","color"=>"","init"=>"1");
		$data["panel"][]=array("title"=>"Jumlah Pegawai Terlambat","content"=>$this->empl_late(false,true),"mod"=>"widget/absensi/empl_late","color"=>"","init"=>"0");
		$data["panel"][]=array("title"=>"Jumlah Pegawai Tidak Hadir","content"=>$this->empl_alfa(false,true),"mod"=>"widget/absensi/empl_alfa","color"=>"","init"=>"0");
		$this->load->view("widget/dash_absensi",$data);
	}
	
	public function empl_list($data=false,$sum=false){
		$param["start"] = (isset($_POST["start"])?$_POST["start"]:0);
		$param["end"] 	= "";
		$param["limit"] = (isset($_POST["limit"])?$_POST["limit"]:10);
		$param["ref"] 	= (isset($_POST["ref"])?$_POST["ref"]:false);
		$param["key"] 	= (isset($_POST["key"])?$_POST["key"]:false);
		$param["case"]	= "all";
		$param["page"]	= (isset($_POST["page"]) && $_POST["page"] !=""?$_POST["page"]:1);
		$param["title"]="Pegawai dan Absensi";
		$param["columns"] = array(
										"no"=>"no",
										"nip"=>"nip_baru",
										"nama"=>"nama_pegawai",
										"unit kerja"=>"nama_unor",
										"Tanggal"=>"tgl",
										"Time In"=>"timein",
										"Time Out"=>"timeout"
									);
		if(isset($_POST["export"])){
			$param["start"] = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
			$param["limit"] = 200;
		}else{
			$param["start"] = ($param["page"]!="1"?($param["page"]-1)*$param["limit"]:$param["page"]-1);
		}
		
		if($sum){
			$_data = $this->dAbs->getSumAttendance($param)->num_rows();
			return $_data;
		}elseif(!$data){
			echo $this->load->view("widget/grid_attendance",$param,true);
		}else{
			$number	= ($param["page"]==1?1:$param["limit"]*($param["page"]-1));
			$param["start"] = ($_POST["page"]!="1"?($_POST["page"]-1)*$_POST["limit"]:$_POST["page"]-1);
			$param["str"]	= (isset($_POST["str"]) && $_POST["str"] !=""?$_POST["str"]:"");
			$param["end"]	= (isset($_POST["end"]) && $_POST["end"] !=""?$_POST["end"]:"");
			$_data = $this->dAbs->getAttendanceFiltered($param)->result_array(); 
			foreach($_data as $index=>$val){
				$_data[$index]["no"]=$number;
				$number=$number+1;
			}
			if(!isset($_POST['export'])){
				$data  = array("hslquery"=>$_data,"pager"=>Modules::run("appskp/appskp/pagerB", $this->dAbs->ttlRows, $param["limit"], $param["page"]));
				$data['bat_print'] = 200;
				$data['seg_print'] = ceil($this->dAbs->ttlRows / $data['bat_print']);
			}else{
				$title 	= $param["title"]." Periode ".$param["str"]." - ".$param["end"] ; 
				$columns = $_POST["cols"];
				$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
			}
			echo json_encode($data);
		}
	}
	
	public function empl_att($data=false,$sum=false){
		
		$param["end"] 	= "";
		$param["limit"] = (isset($_POST["limit"])?$_POST["limit"]:10);
		$param["ref"] 	= (isset($_POST["ref"])?$_POST["ref"]:false);
		$param["case"]	= "present";
		$param["page"]	= (isset($_POST["page"]) && $_POST["page"] !=""?$_POST["page"]:1);
		$param["key"] 	= (isset($_POST["key"])?$_POST["key"]:false);
		$param["title"] = "Pegawai Hadir";
		$param["columns"] = array(
									"no"=>"no",
									"nip"=>"nip_baru",
									"nama"=>"nama_pegawai",
									"unit kerja"=>"nama_unor",
									"Tanggal"=>"tgl",
									"Time In"=>"timein",
									"Time Out"=>"timeout"
								);
		if(isset($_POST["export"])){
			$param["start"] = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
			$param["limit"] = 200;
		}else{
			$param["start"] = ($param["page"]!="1"?($param["page"]-1)*$param["limit"]:$param["page"]-1);
		}						
		
		if($sum){
			$_data = $this->dAbs->getSumAttendance($param)->num_rows();
			return $_data;
		}elseif(!$data){
			
			echo $this->load->view("widget/grid_attendance",$param,true);
		}else{
			$number	= ($param["page"]==1?1:$param["limit"]*($param["page"]-1));
			$param["start"] = ($_POST["page"]!="1"?($_POST["page"]-1)*$_POST["limit"]:$_POST["page"]-1);
			$param["str"]	= (isset($_POST["str"]) && $_POST["str"] !=""?$_POST["str"]:"");
			$param["end"]	= (isset($_POST["end"]) && $_POST["end"] !=""?$_POST["end"]:"");
			$_data = $this->dAbs->getAttendanceFiltered($param)->result_array(); 
			foreach($_data as $index=>$val){
				$_data[$index]["no"]=$number;
				$number=$number+1;
			}
			if(!isset($_POST['export'])){
				$data  = array("hslquery"=>$_data,"pager"=>Modules::run("appskp/appskp/pagerB", $this->dAbs->ttlRows, $param["limit"], $param["page"]));
				$data['bat_print'] = 200;
				$data['seg_print'] = ceil($this->dAbs->ttlRows / $data['bat_print']);
			}else{
				$title 	= $param["title"]." Periode ".$param["str"]." - ".$param["end"] ; 
				$columns = $_POST["cols"];
				$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
			}
			echo json_encode($data);
		}
	}
	
	public function empl_late($data=false,$sum=false){
		$param["start"] = (isset($_POST["start"])?$_POST["start"]:0);
		$param["end"] 	= "";
		$param["limit"] = (isset($_POST["limit"])?$_POST["limit"]:10);
		$param["ref"] 	= (isset($_POST["ref"])?$_POST["ref"]:false);
		$param["case"]	= "late";
		$param["page"]	= (isset($_POST["page"]) && $_POST["page"] !=""?$_POST["page"]:1);
		$param["key"] 	= (isset($_POST["key"])?$_POST["key"]:false);
		$param["title"] = "Pegawai Terlambat";
		$param["columns"] = array(
								"no"=>"no",
								"nip"=>"nip_baru",
								"nama"=>"nama_pegawai",
								"unit kerja"=>"nama_unor",
								"Tanggal"=>"tgl",
								"Time In"=>"timein",
								"Time Out"=>"timeout"
							);
		
		if(isset($_POST["export"])){
			$param["start"] = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
			$param["limit"] = 200;
		}else{
			$param["start"] = ($param["page"]!="1"?($param["page"]-1)*$param["limit"]:$param["page"]-1);
		}
		
		if($sum){
			$_data = $this->dAbs->getSumAttendance($param)->num_rows();
			return $_data;
		}elseif(!$data){
			echo $this->load->view("widget/grid_attendance",$param,true);
		}else{
			$number	= ($param["page"]==1?1:$param["limit"]*($param["page"]-1));
			$param["start"] = ($_POST["page"]!="1"?($_POST["page"]-1)*$_POST["limit"]:$_POST["page"]-1);
			$param["str"]	= (isset($_POST["str"]) && $_POST["str"] !=""?$_POST["str"]:"");
			$param["end"]	= (isset($_POST["end"]) && $_POST["end"] !=""?$_POST["end"]:"");
			$_data = $this->dAbs->getAttendanceFiltered($param)->result_array(); 
			foreach($_data as $index=>$val){
				$_data[$index]["no"]=$number;
				$number=$number+1;
			}
			if(!isset($_POST['export'])){
				$data  = array("hslquery"=>$_data,"pager"=>Modules::run("appskp/appskp/pagerB", $this->dAbs->ttlRows, $param["limit"], $param["page"]));
				$data['bat_print'] = 200;
				$data['seg_print'] = ceil($this->dAbs->ttlRows / $data['bat_print']);
			}else{
				$title 	= $param["title"]." Periode ".$param["str"]." - ".$param["end"] ; 
				$columns = $_POST["cols"];
				$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
			}
			echo json_encode($data);
		}
	}

	public function empl_alfa($data=false,$sum=false){
		$param["start"] = (isset($_POST["start"])?$_POST["start"]:0);
		$param["end"] 	= "";
		$param["limit"] = (isset($_POST["limit"])?$_POST["limit"]:10);
		$param["ref"] 	= (isset($_POST["ref"])?$_POST["ref"]:false);
		$param["case"]	= "notpresent";
		$param["page"]	= (isset($_POST["page"]) && $_POST["page"] !=""?$_POST["page"]:1);
		$param["key"] 	= (isset($_POST["key"])?$_POST["key"]:false);
		$param["title"] = "Pegawai Tidak Hadir";
		$param["columns"] = array(
								"no"=>"no",
								"nip"=>"nip_baru",
								"nama"=>"nama_pegawai",
								"unit kerja"=>"nama_unor",
								"Tanggal"=>"tgl"
							);
		if(isset($_POST["export"])){
			$param["start"] = ($_POST["hal"]!="1"?($_POST["hal"]-1)*200:$_POST["hal"]-1);
			$param["limit"] = 200;
		}else{
			$param["start"] = ($param["page"]!="1"?($param["page"]-1)*$param["limit"]:$param["page"]-1);
		}					
			
		if($sum){
			$_data = $this->dAbs->getSumAttendance($param)->num_rows();
			return $_data;
		}elseif(!$data){
			echo $this->load->view("widget/grid_attendance",$param,true);
		}else{
			$number	= ($param["page"]==1?1:$param["limit"]*($param["page"]-1));
			$param["start"] = ($_POST["page"]!="1"?($_POST["page"]-1)*$_POST["limit"]:$_POST["page"]-1);
			$param["str"]	= (isset($_POST["str"]) && $_POST["str"] !=""?$_POST["str"]:"");
			$param["end"]	= (isset($_POST["end"]) && $_POST["end"] !=""?$_POST["end"]:"");
			$_data = $this->dAbs->getAttendanceFiltered($param)->result_array(); 
			foreach($_data as $index=>$val){
				$_data[$index]["no"]=$number;
				$number=$number+1;
			}
			if(!isset($_POST['export'])){
				$data  = array("hslquery"=>$_data,"pager"=>Modules::run("appskp/appskp/pagerB", $this->dAbs->ttlRows, $param["limit"], $param["page"]));
				$data['bat_print'] = 200;
				$data['seg_print'] = ceil($this->dAbs->ttlRows / $data['bat_print']);
			}else{
				$title 	= $param["title"]." Periode ".$param["str"]." - ".$param["end"] ; 
				$columns = $_POST["cols"];
				$data = array("hslquery"=>"","url"=>modules::run('widget/export/save',$columns,$_data,$title));
			}
			echo json_encode($data);
		}
	}
}