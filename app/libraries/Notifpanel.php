<?php
////////////////////////////////////////////////////////////////
class Notifpanel {
	function __construct ()
	{
        $this->obj =& get_instance();
        $this->obj->load->model('m_notif');

	}
	function notification(){
		$data 		= $this->obj->m_notif->getData(0,0);
		$display	= "";
		foreach($data as $key=>$val){
			$extract = json_decode($data[$key]["meta_value"]);
			if($extract->status == 1){
				$display .= $this->setPanel($extract);
			}
		}
		return $display;
	}
	
	private function setPanel($extract){
		if(!empty($extract->custom_query)){
			$info = $this->obj->db->query($extract->custom_query);
		}else{
			$info = "";
		}
		$panel 		= '<div class="col-lg-3 col-md-6">
						<a class="uk-panel custom-box" href="'.$extract->path.'">
							<div class="tile-stats tile-aqua" style="background:'.$extract->color.'">
								<div class="icon"><i class="fa '.$extract->icon.'"></i></div>
								<div class="num" data-start="0" data-end="0" data-postfix="" data-duration="1500" data-delay="0">'.$info.' <sup class="uk-text-right"><small></small></sup></div>
								<h3>'.$extract->text.'</h3>
							</div>
						</a>
				</div>';
		return $panel;
	}
	
	
	function item($active,$item,$mode="normal"){
			if($mode=="test"){$item = "";}
			if($this->obj->session->userdata("logged_in") || isset($item["force_link"]) && $item["force_link"]===true){
				$item["link"] = $item["link"];
			}else{
				$item["link"]="#";
			}
			$info  = ""; 
			if($item["info"]){
				$info = '<div class="num" data-start="0" data-end="0" data-postfix="" data-duration="1500" data-delay="0">'.($item["info"]?$item["info"]:"").'</div>';
			}
			$items = '<a class="uk-panel custom-box" href="'.$item["link"].'">
							<div class="tile-stats tile-aqua" style="background:'.$item["bg"].'">
								<div class="icon"><i class="fa '.$item["icon"].'"></i></div>
								'.$info.'
								<h3 class="tilecaption">'.$item["title"].'</h3>
							</div>
						</a>';
			if($active==true){
				$html = '
							<div class="item active">
								'.$items.'
							</div>
				';
			} else {
				$html = '
							<div class="item">
								'.$items.'
							</div>
				';
			}
			return $html;
		}

		function tile($sm,$xs,$class,$items,$bg,$url,$init=false){
			$inner = '';
			for($i=0; $i<=(count($items)-1); $i++){
				if($i==0){$active=true;} else {$active=false;}
				$inner .= $this->item($active,$items[$i]);
			}
			if($init){$id = " id='tile0'";} else {$id = "";}
			if($bg){$bg = " style='background:".$bg."'";} else {$bg = " style='background:#CCC'";}
			if($url && $url!="#"){$url = base_url().$url;} else {$url = $url;}
			$html = "
			<div class='col-sm-".$sm." col-xs-".$xs."'>
				<div".$id." class='tile ".$class."'>
					<div class='carousel slide'  data-ride='carousel'>
						<div class='carousel-inner'>
							".$inner."
						</div>
					</div>
				</div>
			</div>	
			";
			return $html;
		}

		function metrotiles(){
			error_reporting(0);
			$data 		= $this->obj->m_notif->getData(0,0)->result_array();
			$ttl		= 1;
			$setDisplay = 2;
			$html = "<div class='tileContainer dynamicTile'>
					 <div class='row '>";
			$i		 	= 0;		 
			$a	 		= 0;		 
			$display 	= array();
			$rowsCols   = 0;
			if(!$this->obj->session->userdata("logged_in")){
					$display[$i]["title"] 	= "LOG IN";
					$display[$i]["icon"] 	= "fa fa-sign-in";
					$display[$i]["link"] 	= base_url()."login";
					$display[$i]["info"] 	= "<i class='fa fa-sign-in'></i>";
					$display[$i]["bg"] 		= "#888";
					$display[$i]["force_link"] = true;
					$html .= $this->tile(2,4,"tile1",$display,"#888","",true);
					$rowsCols  = 2;
			}
			foreach($data as $key=>$val){
				$extract = json_decode($data[$key]["meta_value"]);
				$bg		 = $extract->color;
				if($extract->status == 1){
					$bootstrap[$key] = $key;
					$display = array();
					$display[$i]["title"] 	= (!empty($extract->note)?$extract->note:$extract->text);
					$display[$i]["icon"] 	= $extract->icon;
					$display[$i]["link"] 	= (!isset($extract->module) && empty($extract->module) || !empty($extract->path) && $extract->path !="#"?base_url().$extract->path:"#");
					$display[$i]["info"] 	= FALSE;
					$display[$i]["bg"] 	= $bg;
					if(isset($extract->module)&&!empty($extract->module)){
						
						$sql = explode(",",$extract->module);
						foreach($sql as $key=>$val){
							if(!empty($sql[$key])){
								$i=$i+1;
								$pos = strpos($sql[$key], "param:");
								if($pos!==false){
									$param = explode("--",substr($sql[$key],$pos+6)); 
									$mod   = substr($sql[$key],0,$pos-1); 
									$link  = base_url()."admin/module/".$mod."/".implode("/",$param);
								}else{
									$mod 	= $sql[$key];
									$param  = "";
									$link 	= base_url()."admin/module/".$mod;
								}
								$_data = Modules::run($mod,$param,true);
								if(!is_array($_data)){
									$display[$i]["title"] = (!empty($_data->title)?"<strong>".$extract->text.'</strong><br>'.$_data->title:$extract->text);
									$display[$i]["icon"] 	= $extract->icon;
									$display[$i]["link"] 	= $link;
									$display[$i]["info"] 	= (isset($_data->total) && !empty($_data->total) || $_data->total!=0? $_data->total:false);
									$display[$i]["bg"] 		= $bg;
								}else{
									foreach($_data as $key=>$value){
										$display[$key+1]["title"] = (!empty($_data[$key]["title"])?$_data[$key]["title"]:$extract->text);
										$display[$key+1]["icon"] 	= $extract->icon;
										$display[$key+1]["link"] 	= $link.(isset($_data[$key]["keys_data"])?"/".$_data[$key]["keys_data"]:"");
										$display[$key+1]["info"] 	= (isset($_data[$key]["total"]) && !empty($_data[$key]["total"]) || $_data[$key]["total"]!=0? $_data[$key]["total"]:false);
										$display[$key+1]["bg"] 		= $bg;
									}
								}
							}
						}
					}
					$url	 = $extract->path;
					if($ttl === $setDisplay || $this->obj->session->userdata("logged_in") && $ttl===4){
						$numCols = 4;
						if( !each( $data ) ) {
							$numCols = 12-$rowsCols;
						}
						$html 	.= $this->tile($numCols,8,"tile1",$display,$bg,$url,true);
						$setDisplay = $setDisplay+3;
						$rowsCols = $rowsCols+$numCols;
					}else{
						$numCols = 2;
						if( !each( $data ) ) {
							$numCols = 12-$rowsCols;
						}
						$html .= $this->tile($numCols,4,"tile1",$display,$bg,$url,true);
						$rowsCols = $rowsCols+$numCols;
					}
					$ttl 	  = $ttl+1;
					$i 		  = 0;
					$rowsCols = ($rowsCols === 12?0:$rowsCols);
				}
				
			}
			$html .= "
				</div>
			</div>
			";
			return $html;
		}
}