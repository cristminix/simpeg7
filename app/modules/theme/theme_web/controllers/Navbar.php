<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Navbar extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('m_pack_web');
	}

	function index($id_kanal){	 // 0 = default-> INDUK	
		$sess = $this->session->userdata('visit');
		$knll = $sess['kanal'];

		$sqlstr="SELECT a.* FROM p_setting_item a 
		WHERE a.id_setting='1' 
		AND a.id_parent='$id_kanal' 
		AND a.meta_value LIKE '%\"status\":\"on\"%'  
		AND a.meta_value LIKE '%\"tipe\":\"biasa\"%' 
		ORDER BY a.urutan ASC";
		$data = $this->db->query($sqlstr)->result();

			$menu_sidebar = '<ul class="nav navbar-nav navbar-right">';
			foreach($data as $row){
				$child = $this->getChild($row->id_item);
				$jj=json_decode($row->meta_value);
				if(strlen($child)>0){
					$menu_sidebar .= ($jj->path_kanal==$knll)?"<li class=\"dropdown active\"><a href=\"".site_url()."kanal/".$jj->path_kanal."\"  class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$row->nama_item." <b class=\"caret\"></b></a>":"<li class=\"dropdown\"><a href=\"#\"  class=\"dropdown-toggle\" data-toggle=\"dropdown\">".$row->nama_item." <b class=\"caret\"></b></a>";
					$menu_sidebar .= "<ul class=\"dropdown-menu\">".$child."</ul>";
					$menu_sidebar .= "</li>";
				}else{
					$menu_sidebar .= ($jj->path_kanal==$knll)?"<li class=active><a href=\"".site_url()."kanal/".$jj->path_kanal."\">".$row->nama_item."</a></li>":"<li><a href=\"".site_url()."kanal/".$jj->path_kanal."\">".$row->nama_item."</a></li>";
				}
			}
			$menu_sidebar .= '</ul>';

		$data['list_menu'] = $menu_sidebar;
		$this->load->view("navbar",$data);
	}
//////////////////////////////////////////////////////////////////////////////////////////
	function getChild($id_kanal){
		$sqlstr="SELECT a.* FROM p_setting_item a 
		WHERE a.id_setting='1' 
		AND a.id_parent='$id_kanal' 
		AND a.meta_value LIKE '%\"status\":\"on\"%'  
		AND a.meta_value LIKE '%\"tipe\":\"biasa\"%' 
		ORDER BY a.urutan ASC";
		$data = $this->db->query($sqlstr)->result();
		$list_menu = '';
		foreach($data as $i => $row):
			$child = $this->getChild($row->id_item);
				$jj=json_decode($row->meta_value);
				if(strlen($child)>0){			
					$list_menu .= "<li class=active><a href=\"".site_url()."kanal/".$jj->path_kanal."\">".$row->nama_item."</a>";
					$list_menu .= '<ul>'.$child.'</ul>';
					$list_menu .= '</li>';
				} else {
					$list_menu .= "<li><a href=\"".site_url()."kanal/".$jj->path_kanal."\">".$row->nama_item."</a></li>";
				}
		endforeach;
		return $list_menu;
	}
//////////////////////////////////////////////////////////////////////////////////////////
}	
?>