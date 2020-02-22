<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Home extends MX_Controller {

	function __construct(){
		parent::__construct();
	}
	function index(){
//		$content['dtbody'] = $this->getdtbody();
		$content = array();
		$this->load->view('home/default',$content);
	}
	function getdtbody($isAjax=false){
    $this->load->model('auth/auths');
    $acl = $this->auths->get_user_acl_unor($this->session->userdata('user_id'));
    if(is_array($acl)){
      $sqlselect="a.*,
        DATE_FORMAT(a.tanggal_lahir,'%d-%m-%Y') AS tanggal_lahir,
        DATE_FORMAT(a.tmt_cpns,'%d-%m-%Y') AS tmt_cpns,
        DATE_FORMAT(a.tmt_pns,'%d-%m-%Y') AS tmt_pns,
        DATE_FORMAT(a.tmt_pangkat,'%d-%m-%Y') AS tmt_pangkat,
        DATE_FORMAT(a.tmt_jabatan,'%d-%m-%Y') AS tmt_jabatan";
      $this->db->select($sqlselect,false);
      $this->db->where_in('a.id_unor',$acl);
      $data = $this->db->get('rekap_peg a')->result();
    }else{
      $data = array();
    }
		$result = '';
		foreach($data as $row){
			$result .= $this->load->view('home/dtrow',array('row'=>$row),true);
		}
		if($isAjax){
			echo $result;
		}else{
			return $result;
		}
	}
}
?>