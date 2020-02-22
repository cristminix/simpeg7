<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Skp_formpegawai extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('appskp/m_skp');
		$this->load->model('datamodel/pegawai__model','pegawai_m');

		$this->id_skp = $this->session->userdata('id_skp');
		($this->id_skp) or redirect('admin/module/appskp/skp');
	}




	function index($type=false,$title='')
	{
		($type) or redirect('admin/module/appskp/skp');
		$content['type'] = $type;
		$content['title'] = $title;

		$skp = $content['skp'] = $this->m_skp->ini_skp($this->id_skp);

		$id_pegawai = $content['id_pegawai'] = $skp->id_pegawai;
		$content['nama_pegawai'] = $skp->nama_pegawai;
		$content['nip_baru'] = $skp->nip_baru;

		if($type == 'penilai')
		{
			$id_pegawai = $content['id_pegawai'] = $skp->id_penilai;
			$content['nama_pegawai'] = $skp->penilai_nama_pegawai;
			$content['nip_baru'] = $skp->penilai_nip_baru;
		}
		
		$content['datapangkat'] = $this->pegawai_m->get_riwayat_pangkat($id_pegawai);
		$content['datajabatan'] = $this->pegawai_m->get_riwayat_jabatan($id_pegawai);
		
		$this->session->set_userdata("idskp",$this->id_skp);
		$this->load->view('skp_formpegawai/index',$content);
	}
	function penilai()
	{
		$this->index('penilai','Form Edit Data Pejabat Penilai');
	}
	function dinilai()
	{
		$this->index('dinilai','Form Edit Data Pegawai Yang Dinilai');
	}
	function save()
	{
		$post = $this->input->post();
		
		$type = $post['type'];
		
		$prefix = '';
		($type == 'penilai') and $prefix = 'penilai_';
		
		$data = array();
		
		if(isset($post['id_peg_golongan']))
		{
			$pkt = $this->pegawai_m->get_peg_pkt($post['id_peg_golongan']);
			if($pkt)
			{
				$data[$prefix.'kode_golongan'] 			= $pkt->kode_golongan;
				$data[$prefix.'nama_pangkat'] 			= $pkt->nama_pangkat;
				$data[$prefix.'nama_golongan'] 			= $pkt->nama_golongan;
			}
		}
		
		if(isset($post['id_peg_jab']))
		{
			$jab = $this->pegawai_m->get_peg_jabatan($post['id_peg_jab']);
			if($jab)
			{
				$data[$prefix.'id_unor'] 							= $jab->id_unor;
				$data[$prefix.'nomenklatur_jabatan'] 	= $jab->nama_jabatan;
				$data[$prefix.'nomenklatur_pada'] 		= $jab->nomenklatur_pada;
				$data[$prefix.'tugas_tambahan'] 			= $jab->tugas_tambahan;
				$data[$prefix.'nama_ese'] 						= $jab->nama_ese;
			}
		}
		if(count($data) > 0)
		{
			$this->db->where('id_skp',$this->id_skp);
			$result['success'] = $this->db->update('p_skp',$data);
			// $result['success'] = true;
		}
		
		// $result['data'] = $data;
		$this->session->set_userdata("idskp",$this->id_skp);
		echo json_encode($result);
	}
}
?>