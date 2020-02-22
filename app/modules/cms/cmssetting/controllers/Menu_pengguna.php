<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Menu_pengguna extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_setting');
		$this->auth->restrict();
	}

	function index(){
		$data['setting']	= "Menu Pengguna";
		$data['setting_ref']	= "Menu";

		$data['id_setting']	= 3;
		$data['id_setting_ref']	= 2;

		$this->load->view('menu_pengguna/index',$data);
	}

	function getmenupengguna(){
		$group_id	= $_POST['group_id'];
		$id_setting	= $_POST['id_setting'];
		$id_setting_ref	= $_POST['id_setting_ref'];
		$idparent=end(explode("_",$_POST['idparent']));	
		$level=($_POST['level']+1);
		$spare=3+(($level*15)-15);

		$data['isi']	= $this->m_setting->getmenupengguna($id_setting,$id_setting_ref,$idparent,$group_id);

		foreach($data['isi'] as $key=>$val){
			$id=$val->id_item;//////////////
			$jj=json_decode($val->meta_value);
			$data['isi'][$key]->icon_menu=$jj->icon_menu;
			$data['isi'][$key]->path_menu=$jj->path_menu;
			$data['isi'][$key]->keterangan=$jj->keterangan;

			$data['isi'][$key]->spare=$spare;	
			$data['isi'][$key]->level=$level;
				$anak=$this->m_setting->getmenupengguna($id_setting,$id_setting_ref,$id,$group_id);
				$data['isi'][$key]->toggle=(!empty($anak))?"tutup":"buka";
				$data['isi'][$key]->idchild=($_POST['idparent']==0)?$id:$_POST['idparent']."_".$id;
		}

		echo  json_encode($data);
	}
	function formtambah_menu_pengguna(){
		$data['id_setting'] = $_POST['id_setting'];
		$data['id_setting_ref'] = $_POST['id_setting_ref'];
		$data['group_id'] = $_POST['group_id'];
			$grup = $this->m_setting->detail_grup($_POST['group_id']);
		$data['nama_group']=$grup[0]->group_name;
		$this->load->view('menu_pengguna/formtambah_menu_pengguna',$data);
	}
	function getmenuuserAll(){
		$gg = $this->getpanggilmenu(2,0,1,"","",$_POST['id_setting'],$_POST['id_setting_ref'],$_POST['group_id']);
		echo $gg;
	}

	function getpanggilmenu($sett,$idp,$level=1,$ni="",$di="",$set,$set_ref,$grup){
		$gh	= $this->m_setting->getitem($sett,$idp);
		if(!empty($gh)){
		$bb="";
		$no=1;
			foreach($gh as $key=>$val){
				$spare=3+(($level*20)-15);
				if($ni!=""){$na=$ni.".".$no;}else{$na=$no;}
				if($di!=""){$da=$di."_".$val->id_item;}else{$da=$val->id_item;}
				if(($no % 2) == 1){$seling="odd";}else{$seling="even";}
				$val_meta = json_decode($val->meta_value);
				$ghh = $this->m_setting->getitem($sett,$val->id_item);
					$bb .= "<tr class=\"gridrow ".$seling."\" height=20>";
					$bb .= "<td class=\"gridcell left\" align=\"left\"><b><div id=\"nomer_".$val->id_item."\">".$na."</div></b></td>";
				if(empty($ghh)){
					$cek = $this->m_setting->cekmenupengguna($val->id_item,$set,$set_ref,$grup);
					if(empty($cek)){
						$bb .= "<td class=\"gridcell\"><input type=checkbox id='ccshdk_".$val->id_item."' name='menu_path' value='".$da."'></td>";
					} else {
						$bb .= "<td class=\"gridcell\">&nbsp;</td>";
					}
					$bb .= "<td class=\"gridcell\" style=\"padding-left: ".$spare."px;\"><div class=\"ui-icon ui-icon-document-b tree-leaf treeclick\" style=\"float: left;\"></div>".$val->nama_item."</td>";
					$bb .= "<td class=\"gridcell\">".$val_meta->path_menu."</td>";
					$bb .= "<td class=\"gridcell\">".$grup."</td>";
					$bb .= "</tr>";
				} else {
					$bb .= "<td class=\"gridcell\">&nbsp;</td>";
					$bb .= "<td class=\"gridcell\" style=\"padding-left: ".$spare."px;\"><div class=\"ui-icon treeclick ui-icon-triangle-1-s tree-minus\" style=\"float: left;\"></div>".$val->nama_item."</td>";
					$bb .= "<td class=\"gridcell\">".$val_meta->path_menu."</td>";
					$bb .= "<td class=\"gridcell\">".$grup."</td>";
					$bb .= "</tr>";
					$ne = 1;
					foreach($ghh as $keyb=>$valb){
						$valb_meta = json_decode($valb->meta_value);
						$cc = $this->getpanggilmenu($sett,$valb->id_item,($level+2),$na.".".$ne,$da."_".$valb->id_item,$set,$set_ref,$grup);
						$bb .= "<tr class=\"gridrow ".$seling."\" height=20>";
						$bb .= "<td class=\"gridcell left\" align=\"left\"><b><div id=\"nomer_".$valb->id_item."\">".$na.".".$ne."</div></b></td>";
						if(empty($cc)){
								$cek2 = $this->m_setting->cekmenupengguna($valb->id_item,$set,$set_ref,$grup);
								if(empty($cek2)){
										$bb .= "<td class=\"gridcell\"><input type=checkbox id='ccshdk_".$val->id_item."' name='menu_path' value='".$da."_".$valb->id_item."'></td>";
								} else {
										$bb .= "<td class=\"gridcell\">&nbsp;</td>";
								}
								$bb .= "<td class=\"gridcell\" style=\"padding-left: ".($spare+20)."px;\"><div class=\"ui-icon ui-icon-document-b tree-leaf treeclick\" style=\"float: left;\"></div>".$valb->nama_item."</td>";
						} else {
								$bb .= "<td class=\"gridcell\">&nbsp;</td>";
								$bb .= "<td class=\"gridcell\" style=\"padding-left: ".($spare+20)."px;\"><div class=\"ui-icon treeclick ui-icon-triangle-1-s tree-minus\" style=\"float: left;\"></div>".$valb->nama_item."</td>";
						}
						$bb .= "<td class=\"gridcell\">".$valb_meta->path_menu."</td>";
						$bb .= "<td class=\"gridcell\">".$grup."</td>";
						$bb .= "</tr>";
						$bb = $bb.$cc;
						$ne++;
					}
				}
			$no++;
			}
		return $bb;
		}
	}

	function tambah_menu_pengguna_aksi(){
		$ang=explode("_",$_POST['menu']);
		$this->m_setting->tambah_menu_pengguna_aksi($_POST['group_id'],$_POST['id_setting'],$ang);
	}

	function formhapus_menu_pengguna(){
		$data['idd']=end(explode("_",$_POST['idd']));
		$data['idparent']=$_POST['idparent'];
		$data['group_id']=$_POST['group_id'];
		$data['id_setting']=$_POST['id_setting'];

		if($_POST['level']==1){
			$data['level']=0;
			$data['rowparent']="";
			$data['parent']=0;
		} else {
			$idp=explode("_",$_POST['idd']);
			$isi	= $this->m_setting->getmenupengguna($_POST['id_setting'],$_POST['id_setting_ref'],$_POST['idparent'],$_POST['group_id']);

			$data['rowparent']="";
			$data['parent']="";
			if(count($isi)==1){
				$data['level']=$_POST['level']-2;
				for($i=0;$i<count($idp)-2;$i++){	$data['rowparent'].=$idp[$i]."_";	$data['parent'].=($i==0)?$idp[$i]:"_".$idp[$i];	}
			} else {
				$data['level']=$_POST['level']-1;
				for($i=0;$i<count($idp)-1;$i++){	$data['rowparent'].=$idp[$i]."_";	$data['parent'].=($i==0)?$idp[$i]:"_".$idp[$i];	}
			}
			if($data['parent']==""){$data['parent']=0;}
		}


		$hslquery= $this->m_setting->ini_item($data['idd']); 
			$jj = json_decode($hslquery[0]->meta_value);
		@$data['hslquery'][0]->menu_name=$hslquery[0]->nama_item;
		$data['hslquery'][0]->menu_path=$jj->path_menu;
		$data['hslquery'][0]->icon_menu=$jj->icon_menu;
		$data['hslquery'][0]->keterangan=$jj->keterangan;

		$this->load->view('menu_pengguna/formhapus_menu_pengguna',$data);
	}
	function hapus_menu_pengguna_aksi(){
			$this->m_setting->hapus_menu_pengguna_aksi($_POST['group_id'],$_POST['idmp']);
	}

}
?>