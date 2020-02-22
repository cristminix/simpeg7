<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cetak extends MX_Controller {

	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
		// $this->load->helper('sikda');
	}
	function index($id_pegawai=false){
		$this->load->library('mypdf');
    
		$this->mypdf->SetCreator(PDF_CREATOR);
		$this->mypdf->SetAuthor('BKPP');
		$this->mypdf->SetTitle('CV PEGAWAI');
		$this->mypdf->SetSubject('CV PEGAWAI');
		$this->mypdf->SetKeywords('BKPP, PDF, CV');
		$tglCetak = date("s:i:H d/m/Y",mktime(date('s'),date('i'),date('H'),date('d'),date('h'),date('Y')));
    
		$this->mypdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->mypdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->mypdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->mypdf->SetMargins(10, 20, 10);
		$this->mypdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->mypdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->mypdf->SetAutoPageBreak(TRUE, 10);
		$this->mypdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->mypdf->SetFont('times', '', 9);
    $this->createcv($id_pegawai);
		$this->mypdf->Output('example_001.pdf', 'I');
	}
	function createcv($id_pegawai=false){
		$this->mypdf->AddPage();
		$this->mypdf->SetFillColor(255, 255, 127);
    
		// $this->load->model('pegawai__model');
		// $foto = $this->pegawai__model->get_peg_foto($id_peg);
		// dump($foto);
		// $fotopath = Modules::run("datamodel/pegawai/get_peg_fotosrc",$id_pegawai);
		$fotopath = Modules::run("datamodel/pegawai/get_peg_fotopath",$id_pegawai);
		
    
		$this->mypdf->Image($fotopath, 15, 20, '', 30, '', '', '', true, 100);
		
		$html = $this->gethtml($id_pegawai);
    
		$this->mypdf->writeHTML($html, true, 0, true, 0);;
	}
	function gethtml($id_pegawai=false){
		$html = $this->getdata($id_pegawai);
		return $this->load->view('cv/template',array('data'=>$html),true );
	}
	function getdata($id_pegawai=false){
     
    
    
		$data['head'] = Modules::run("datamodel/pegawai/get_pegawai",$id_pegawai);
		$html['head'] = $this->load->view('cv/head',array('data'=>$data['head']),true );
		
    
 		$data['pribadi'] = Modules::run("datamodel/pegawai/get_peg_biodata",$id_pegawai);
		$html['pribadi'] = $this->load->view('cv/pribadi',array('data'=>$data['pribadi']),true );
    
		$data['alamat'] = Modules::run("datamodel/pegawai/get_peg_alamat",$id_pegawai);
		$html['alamat'] = $this->load->view('cv/alamat',array('data'=>$data['alamat']),true );
    
		$data['marital'] = Modules::run("datamodel/pegawai/get_riwayat_perkawinan",$id_pegawai);
    if(count($data['marital']) > 0){
      $html['marital'] = $this->load->view('cv/marital',array('data'=>$data['marital']),true );
    }else{
      $html['marital'] = 'Tidak Ada Data untuk ditampilkan';
    }
    
		$data['anak'] = Modules::run("datamodel/pegawai/get_riwayat_anak",$id_pegawai);
    if(count($data['anak']) > 0){
      $html['anak'] = $this->load->view('cv/anak',array('data'=>$data['anak']),true );
    }else{
      $html['anak'] = 'Tidak Ada Data untuk ditampilkan';
    }
    
		$data['pendidikan'] = Modules::run("datamodel/pegawai/get_riwayat_pend",$id_pegawai);
    if(count($data['anak']) > 0){
      $html['pendidikan'] = $this->load->view('cv/pendidikan',array('data'=>$data['pendidikan']),true,true );
      }else{
      $html['pendidikan'] = 'Tidak Ada Data untuk ditampilkan';
    }
    
		$data['pengangkatan']['pns'] = Modules::run("datamodel/pegawai/get_peg_pns",$id_pegawai);
		$data['pengangkatan']['cpns'] = Modules::run("datamodel/pegawai/get_peg_cpns",$id_pegawai);
		$html['pengangkatan'] = $this->load->view('cv/pengangkatan',array('data'=>$data['pengangkatan']),true );
    
		$data['pangkat'] = Modules::run("datamodel/pegawai/get_riwayat_pangkat",$id_pegawai);
    if(count($data['pangkat']) > 0){
      $html['pangkat'] = $this->load->view('cv/pangkat',array('data'=>$data['pangkat']),true );
      }else{
      $html['pangkat'] = 'Tidak Ada Data untuk ditampilkan';
    }
    
    
		return $html;
	}
	function banyak(){
    $this->load->model('auth/auths');
    $acl = $this->auths->get_user_acl_unor($this->session->userdata('user_id'));
    $nama_unor = $this->session->userdata('nama_unor');

    $path = str_replace('\\','/',FCPATH)."assets/file/cv/".$nama_unor;
    if (!file_exists($path)) {
      if (!mkdir($path, 0777, true)) {
        die('Failed to create folders...');
      }
    }
    if(is_array($acl)){
      $sqlselect="a.*";
      $this->db->select($sqlselect,false);
      $this->db->where_in('a.id_unor',$acl);
      // $this->db->limit(2);
      $data = $this->db->get('rekap_peg a')->result();
    }
    if($data){
      foreach($data as $row){
        // echo 'Membuat file '.$row->nama_pegawai.' - '.$row->nip_baru.".pdf";
        
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, site_url('appdatapegawai/cetak/index/'.$row->id_pegawai) );
        
        $data = curl_exec($ch);
        $result = file_put_contents($path.'/'.$row->nama_pegawai.' - '.$row->nip_baru.".pdf", $data);
        // echo '.... Selesai<br/>';
      }
      // echo '<a href="'.site_url('appdatapegawai/cetak/zipdownload').'">Download CV</a>';
      $this->zipdownload();
    }
	}
	function zipdownload(){
    $nama_unor = $this->session->userdata('nama_unor');
    
    $path = str_replace('\\','/',FCPATH)."assets/file/cv/".$nama_unor.'/';

    $this->load->library('zip');
    
    $this->zip->read_dir($path, FALSE);
    $this->zip->download($nama_unor.'.zip'); 
  }
}
?>