<?php
Class Pegawai__model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	}
	
	function _db_set($fields=array(),$data= array())
	{
		foreach($fields as $field){
      if(isset($data[$field])){
        $this->db->set($field,$data[$field]);
      }
		}
	}
  /* ----------------------------------------- */
  
  
  /* Pegawai */
	function get_pegawai($id_pegawai=false)
	{
		$sqlselect="a.*,rp.nomor_hp,rp.nomor_tlp_rumah,rp.gol_darah,
			DATE_FORMAT(a.tanggal_lahir,'%d-%m-%Y') AS tanggal_lahir,
			DATE_FORMAT(a.tmt_cpns,'%d-%m-%Y') AS tmt_cpns,
			DATE_FORMAT(a.tmt_pns,'%d-%m-%Y') AS tmt_pns,
			DATE_FORMAT(a.tmt_pangkat,'%d-%m-%Y') AS tmt_pangkat,
			DATE_FORMAT(a.tmt_jabatan,'%d-%m-%Y') AS tmt_jabatan";
		$this->db->select($sqlselect,false);
		$this->db->join('r_pegawai rp','a.id_pegawai=rp.id_pegawai','left');
		$this->db->from('rekap_peg a');
		// $this->db->join('m_jab_struk d','a.id_jab_struk=d.id_jab_struk','left');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
				$data = $this->db->get()->result();
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
			$data = $this->db->get()->row();
		}
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
  /* ----------------------------------------- */
  
  
  /* Biodata Pegawai */
	function get_peg_biodata($id_pegawai=false)
	{
		$sqlselect = "a.*, DATE_FORMAT(a.tanggal_lahir,'%d-%m-%Y') AS tanggal_lahir";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$row = $this->db->from('r_pegawai a')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_pegawai');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_pegawai')->get()->row();
		}
		return $row;
	}
	function set_peg_biodata($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->from('r_pegawai');
		$pegawai = $this->db->get()->row();
		if(!$pegawai){
			$this->db->insert('r_pegawai');
			$id_pegawai = $this->db->insert_id();

			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('rekap_peg');
		}
		
		$this->db->set('nip',$data['nip']);
		$this->db->set('nip_baru',$data['nip_baru']);
		$this->db->set('gelar_nonakademis',$data['gelar_nonakademis']);
		$this->db->set('nama_pegawai',$data['nama_pegawai']);
		$this->db->set('gelar_depan',$data['gelar_depan']);
		$this->db->set('gelar_belakang',$data['gelar_belakang']);
		$this->db->set('gender',$data['gender']);
		$this->db->set('tempat_lahir',$data['tempat_lahir']);
		$this->db->set('tanggal_lahir',"STR_TO_DATE('".$data['tanggal_lahir']."','%d-%m-%Y')",false);
		$this->db->set('agama',$data['agama']);
		$this->db->set('status_pegawai',$data['status_pegawai']);
		$this->db->set('kelompok_pegawai',$data['kelompok_pegawai']);
		$this->db->set('status_perkawinan',$data['status_perkawinan']);
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->set('last_updated',"NOW()",false);
		// $this->db->set('golongan_darah',$data['golongan_darah']);

		$this->db->update('rekap_peg');

		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('nip',$data['nip']);
		$this->db->set('nip_baru',$data['nip_baru']);
		$this->db->set('gelar_nonakademis',$data['gelar_nonakademis']);
		$this->db->set('nama_pegawai',$data['nama_pegawai']);
		$this->db->set('gelar_depan',$data['gelar_depan']);
		$this->db->set('gelar_belakang',$data['gelar_belakang']);
		$this->db->set('gender',$data['gender']);
		$this->db->set('tempat_lahir',$data['tempat_lahir']);
		$this->db->set('tanggal_lahir',"STR_TO_DATE('".$data['tanggal_lahir']."','%d-%m-%Y')",false);
		$this->db->set('agama',$data['agama']);
		$this->db->set('status_pegawai',$data['status_pegawai']);
		$this->db->set('kelompok_pegawai',$data['kelompok_pegawai']);
		$this->db->set('status_perkawinan',$data['status_perkawinan']);
		$this->db->set('nomor_hp',$data['nomor_hp']);
		$this->db->set('gol_darah',$data['gol_darah']);
		$this->db->set('nomor_tlp_rumah',$data['nomor_tlp_rumah']);
		$this->db->where('id_pegawai',$id_pegawai);
		return  $this->db->update('r_pegawai');
	}
  /* ----------------------------------------- */
  
  
  /* Alamat pegawai */
	function get_peg_alamat($id_pegawai=false)
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$row = $this->db->from('r_peg_alamat')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_alamat');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_peg_alamat')->get()->row();
		}
		return $row;
	}
	function set_peg_alamat($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$alamat = $this->db->from('r_peg_alamat')->get()->row();
		if(! $alamat){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_alamat');
		}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('jalan',$data['jalan']);
		$this->db->set('rt',$data['rt']);
		$this->db->set('rw',$data['rw']);
		$this->db->set('kel_desa',$data['kel_desa']);
		$this->db->set('kecamatan',$data['kecamatan']);
		$this->db->set('kab_kota',$data['kab_kota']);
		$this->db->set('propinsi',$data['propinsi']);
		$this->db->set('kode_pos',$data['kode_pos']);
		$this->db->set('jarak_meter',$data['jarak_meter']);
		$this->db->set('jarak_menit',$data['jarak_menit']);
		$this->db->where('id_pegawai',$id_pegawai);
		$result = $this->db->update('r_peg_alamat');
		return  $result;
	}
  /* ----------------------------------------- */
  
  
  /* Foto pegawai */
	function get_peg_foto($id_pegawai=false)
	{
		$this->db->select("*,'' as srcFoto, '' as fileFoto",false);
		$this->db->where('id_pegawai',$id_pegawai);
		$foto = $this->db->from('r_peg_foto')->get()->row();
		if(! $foto){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->set('foto','photo.jpg');
			$this->db->insert('r_peg_foto');
			
			$this->db->select("*,'' as srcFoto",false);
			$this->db->where('id_pegawai',$id_pegawai);
			$foto = $this->db->from('r_peg_foto')->get()->row();
		}
		if($foto->foto){
			$fileFoto =  str_replace('\\','/',FCPATH).'assets/file/'.$foto->foto;
			}else{
			$fileFoto = str_replace('\\','/',FCPATH).'assets/file/foto/photo.jpg';
		}
		$foto->fileFoto = $fileFoto;
		if ( ! file_exists($fileFoto)):
			$foto->fileFoto = str_replace('\\','/',FCPATH).'assets/file/foto/photo.jpg';
			$foto->srcFoto = base_url().'assets/file/foto/photo.jpg';
		else:
			$foto->srcFoto = base_url().'assets/file/'.$foto->foto;
		endif;
		return $foto;
	}
	function set_peg_foto($id_pegawai=false,$data=array())
	{
		$this->db->set('foto',$data['foto']);
		$this->db->where('id_pegawai',$id_pegawai);
		return  $this->db->update('r_peg_foto');
	}
  /* ----------------------------------------- */
  
  
  /* Perkawinan pegawai */
	function get_riwayat_perkawinan($id_pegawai=false)
	{
		$sqlselect = "a.*, 
      DATE_FORMAT(a.tanggal_lahir_suris,'%d-%m-%Y') AS tanggal_lahir_suris,
      DATE_FORMAT(a.tanggal_menikah,'%d-%m-%Y') AS tanggal_menikah,
      DATE_FORMAT(a.tanggal_aktif,'%d-%m-%Y') AS tanggal_aktif
      ";
		$this->db->order_by('a.status_aktif','desc');
		$this->db->select($sqlselect,false);
		$this->db->from('r_peg_perkawinan a');
		$this->db->order_by('a.tanggal_menikah');
		
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			foreach($data as &$row) {
				$row->list_tunjangan = $this->get_peg_perkawinan_tunjangan_list($row->id_peg_perkawinan)->result();
			}
			return $data;
		}
	}
	function get_peg_perkawinan($id_peg_perkawinan=false)
	{
		$sqlselect = "a.*, 
      DATE_FORMAT(a.tanggal_lahir_suris,'%d-%m-%Y') AS tanggal_lahir_suris,
      DATE_FORMAT(a.tanggal_menikah,'%d-%m-%Y') AS tanggal_menikah,
      DATE_FORMAT(a.tanggal_aktif,'%d-%m-%Y') AS tanggal_aktif
      ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_peg_perkawinan',$id_peg_perkawinan);
		return  $this->db->from('r_peg_perkawinan a')->get()->row();
	}

	function set_peg_perkawinan($id_pegawai=false,$id_peg_perkawinan=false,$data=array())
	{
		$tbl = 'r_peg_perkawinan';
		$this->db->trans_begin();
		
		$perkawinan = $this->get_peg_perkawinan($id_peg_perkawinan);
		if($data['status_aktif'] === '1') {
			$this->db->set('status_aktif', '0');
			$this->db->where('id_pegawai',$id_pegawai);
			
			$this->db->update($tbl);
		}
		
		$fields = array(
			'nama_suris', 
			'tempat_lahir_suris', 
			'pendidikan_suris', 
			'pekerjaan_suris', 
			'status_tunjangan', 
			'status_aktif', 
			'keterangan', 
		);
		$this->_db_set($fields,$data);
		$this->db->set('tanggal_lahir_suris',"STR_TO_DATE('".$data['tanggal_lahir_suris']."','%d-%m-%Y')",false);
		$this->db->set('tanggal_menikah',"STR_TO_DATE('".$data['tanggal_menikah']."','%d-%m-%Y')",false);
		$this->db->set('tanggal_aktif',"STR_TO_DATE('".$data['tanggal_aktif']."','%d-%m-%Y')",false);
		$this->db->set('last_updated',"NOW()",false);
		$saved =false;
		if($perkawinan){

			$this->db->where('id_peg_perkawinan',$id_peg_perkawinan);
			$saved = $this->db->update($tbl);
		}else{
			$this->db->set('id_pegawai',$data['id_pegawai']);
			$this->db->insert($tbl);
			$saved = $this->db->insert_id();
		}
		if(!$saved) {
			$this->db->trans_rollback();
			return $saved;
		}
		$this->db->trans_commit();
		return  $saved;
	}
	function set_peg_perkawinan_tunjangan($id=false,$data=array())
	{
		/**
		  { ["status_tunjangan"]=> string(1) "1" 
			["keterangan"]=> string(0) "" 
			["tgl_efektif"]=> string(0) "" 
			["id_pegawai"]=> string(3) "345" 
			["id_sub"]=> string(3) "342" 
			["ID"]=> string(3) "add" 
			["m"]=> string(10) "pernikahan" 
			["f"]=> string(8) "save_sub" }  
		 
		 */
		$tbl= 'r_peg_perkawinan_tunj';
		$tunj = $this->get_peg_perkawinan_tunjangan($id);
    	$fields = array(
			'status_tunjangan', 
			'keterangan',
		);
		$this->_db_set($fields,$data);
		$this->db->set('tgl_efektif',"STR_TO_DATE('".$data['tgl_efektif']."','%d-%m-%Y')",false);
		
		if($tunj){
			$this->db->set('updated', date('Y-m-d H:i:s'));
			$this->db->where('id',$id);
			return  $this->db->update($tbl);
		}else{
			$this->db->set('created', date('Y-m-d H:i:s'));
			$this->db->set('id_r_peg_perkawinan',$data['id_sub']);
			$this->db->insert($tbl);
			$id_ = $this->db->insert_id();
			return $id_;
		}
	}

	function del_peg_perkawinan($id_peg_perkawinan=false)
	{
		$this->db->where('id_peg_perkawinan',$id_peg_perkawinan);
		return  $this->db->delete('r_peg_perkawinan');
	}
  /* ----------------------------------------- */
  /* tunjangan perkawinan */
  	function get_peg_perkawinan_tunjangan($id=false)
	{
		$sqlselect = "a.* ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id',$id);
		return  $this->db->from('r_peg_perkawinan_tunj a')->get()->row();
	}

	function get_peg_perkawinan_tunjangan_list($id=false)
	{
		$sqlselect = "a.* ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_r_peg_perkawinan',$id);
		return  $this->db->from('r_peg_perkawinan_tunj a')->get();
	}

  /* ----------------------------------------- */
  
  /* Anak pegawai */
	function get_riwayat_anak($id_pegawai=false)
	{
		$sqlselect = "a.*, 
      DATE_FORMAT(a.tanggal_lahir_anak,'%d-%m-%Y') AS tanggal_lahir_anak
      ";
		$this->db->order_by('a.tanggal_lahir_anak','asc');
		$this->db->select($sqlselect,false);
		$this->db->from('r_peg_anak a');
		$this->db->order_by('a.tanggal_lahir_anak');
		
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
	function get_peg_anak($id_peg_anak=false)
	{
		$sqlselect = "a.*, 
      DATE_FORMAT(a.tanggal_lahir_anak,'%d-%m-%Y') AS tanggal_lahir_anak
      ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_peg_anak',$id_peg_anak);
		return  $this->db->from('r_peg_anak a')->get()->row();
	}
	function set_peg_anak($id_pegawai=false,$id_peg_anak=false,$data=array())
	{
		$anak = $this->get_peg_anak($id_peg_anak);
		$fields = array(
			'nama_anak',
			'tempat_lahir_anak',
			'gender_anak',
			'status_anak',
			'pendidikan_anak',
			'pekerjaan_anak',
			'keterangan_tunjangan',
		);
		$this->_db_set($fields,$data);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tanggal_lahir_anak',"STR_TO_DATE('".$data['tanggal_lahir_anak']."','%d-%m-%Y')",false);

		if($anak)
		{
			$this->db->where('id_peg_anak',$id_peg_anak);
			$result  = $this->db->update('r_peg_anak');
		}else
		{
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_anak');
			$id_peg_pendidikan = $this->db->insert_id();
			$result  =  $id_peg_pendidikan;
		}
		return $result;
	}
	function del_peg_anak($id_peg_anak=false)
	{
		$this->db->where('id_peg_anak',$id_peg_anak);
		return  $this->db->delete('r_peg_anak');
	}
  /* ----------------------------------------- */
  
   /* Orang tua pegawai */
	function get_riwayat_orangtua($id_pegawai=false)
	{
		$sqlselect = "a.*, 
      DATE_FORMAT(a.tanggal_lahir_orangtua,'%d-%m-%Y') AS tanggal_lahir_orangtua
      ";
		$this->db->order_by('a.tanggal_lahir_orangtua','asc');
		$this->db->select($sqlselect,false);
		$this->db->from('r_peg_orangtua a');
		$this->db->order_by('a.tanggal_lahir_orangtua');
		
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
	function get_peg_orangtua($id_peg_orangtua=false)
	{
		$sqlselect = "a.*, 
      DATE_FORMAT(a.tanggal_lahir_orangtua,'%d-%m-%Y') AS tanggal_lahir_orangtua
      ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_peg_orangtua',$id_peg_orangtua);
		return  $this->db->from('r_peg_orangtua a')->get()->row();
	}
	function set_peg_orangtua($id_pegawai=false,$id_peg_orangtua=false,$data=array())
	{
		$orangtua = $this->get_peg_orangtua($id_peg_orangtua);
		$fields = array(
			'nama_orangtua',
			'tempat_lahir_orangtua',
			'gender_orangtua',
			'status_orangtua',
			'keterangan_tunjangan',
			'keterangan',
		);
		$this->_db_set($fields,$data);
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tanggal_lahir_orangtua',"STR_TO_DATE('".$data['tanggal_lahir_orangtua']."','%d-%m-%Y')",false);

		if($orangtua)
		{
			$this->db->where('id_peg_orangtua',$id_peg_orangtua);
			$result  = $this->db->update('r_peg_orangtua');
		}else
		{
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_orangtua');
			$id_peg_orangtua = $this->db->insert_id();
			$result  =  $id_peg_orangtua;
		}
		return $result;
	}
	function del_peg_orangtua($id_peg_orangtua=false)
	{
		$this->db->where('id_peg_orangtua',$id_peg_orangtua);
		return  $this->db->delete('r_peg_orangtua');
	}
  /* ----------------------------------------- */
  
  /* pendidikan pegawai */
	function get_riwayat_pend($id_pegawai=false)
	{
		$sqlselect = "a.*, DATE_FORMAT(a.tanggal_lulus,'%d-%m-%Y') AS tanggal_lulus";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_lulus desc');
		$this->db->from('r_peg_pendidikan a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
	function get_riwayat_pend_lama($id_pegawai=false)
	{
		$sqlselect="a.*,
    DATE_FORMAT(a.tanggal_sttb,'%d-%m-%Y') AS tanggal_sttb";
		$this->db->order_by('a.tanggal_sttb','desc');
		$this->db->select($sqlselect,false);
    $this->db->where('a.id_pegawai',$id_pegawai);
    $this->db->from('r_peg_pendidikan_lama a');
    $data = $this->db->get()->result();
    
    return $data;
	}
	function get_peg_pend($id_peg_pendidikan=false)
	{
		$sqlselect = "a.*, DATE_FORMAT(a.tanggal_lulus,'%d-%m-%Y') AS tanggal_lulus";
		$this->db->select($sqlselect,false);
		$this->db->from('r_peg_pendidikan a');
		$this->db->where('a.id_peg_pendidikan',$id_peg_pendidikan);
		return  $this->db->get()->row();
	}
	function _get_m_pendidikan($id_pendidikan=false)
	{
		$this->db->where('id_pendidikan',$id_pendidikan);
		$pend = $this->db->get('m_pendidikan')->row();
    return $pend;
	}
	function set_peg_pend($id_pegawai=false,$id_peg_pendidikan=false,$data=array())
	{
		$pend = $this->get_peg_pend($id_peg_pendidikan);
		$pendidikan = $this->_get_m_pendidikan($data['id_pendidikan']);
    if($pendidikan){
      $data['nama_pendidikan'] = $pendidikan->nama_pendidikan;
      $data['kode_jenjang'] = $pendidikan->kode_jenjang;
      $data['nama_jenjang'] = $pendidikan->nama_jenjang;
      $data['nama_jenjang_rumpun'] = $pendidikan->nama_jenjang_rumpun;
    }
		
		$fields = array(
      'id_peg_pendidikan',
      'id_pendidikan',
      'nip_baru',
      'nama_pegawai',
      'kode_jenjang',
      'nama_jenjang',
      'nama_jenjang_rumpun',
      'tahun_lulus',
      'nomor_ijazah',
      'nama_sekolah',
      'jurusan',
      'lokasi_sekolah',
      'gelar_depan',
      'gelar_belakang',
      'pendidikan_pertama',
      'jenis_pendidikan',
      'diakui'
      );
		$this->_db_set($fields,$data);
		if(isset($data['tanggal_lulus'])) 
		$this->db->set('tanggal_lulus',"STR_TO_DATE('".$data['tanggal_lulus']."','%d-%m-%Y')",false);
		
		$this->db->set('last_updated',"NOW()",false);

		if($pend)
		{
			$this->db->where('id_peg_pendidikan',$id_peg_pendidikan);
			$result  = $this->db->update('r_peg_pendidikan');
      // log_message('error',$this->db->last_query());
		}else
		{
				
		$sql2="SELECT * FROM r_pegawai WHERE id_pegawai = $id_pegawai";
		$get2= $this->db->query($sql2)->result();

			foreach($get2 as $row2){
				$nipbaru=$row2->nip_baru;		
				$namapegawai=$row2->nama_pegawai;		
			}
		
		
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->set('nip_baru',$nipbaru);
			$this->db->set('nama_pegawai',$namapegawai);
			$this->db->insert('r_peg_pendidikan');
			$id_peg_pendidikan = $this->db->insert_id();
			$result  =  $id_peg_pendidikan;
		}
		$this->rekap_pend($id_pegawai);
		return $result;
	}
	function del_peg_pend($id_peg_pendidikan=false)
	{
		$row = $this->get_peg_pend($id_peg_pendidikan);
    $result = false;
    if($row){
      $this->db->where('id_peg_pendidikan',$id_peg_pendidikan);
      $result = $this->db->delete('r_peg_pendidikan');
      $this->rekap_pend($row->id_pegawai);
    }
		return $result;
	}
	function rekap_pend($id_peg=false)
	{
		$this->db->where('a.id_pegawai',$id_peg);
		$this->db->where('a.diakui','V');
		$this->db->from('r_peg_pendidikan a');
		$this->db->order_by('a.tahun_lulus desc, a.tanggal_lulus desc');
		$pend = $this->db->get()->row();
		if($pend){
			$this->db->where('id_pegawai',$pend->id_pegawai);
			$this->db->set('id_pendidikan',$pend->id_pendidikan);
			$this->db->set('nama_pendidikan',$pend->nama_pendidikan);
			$this->db->set('nama_sekolah',$pend->nama_sekolah);
			$this->db->set('tanggal_lulus',$pend->tanggal_lulus);
			$this->db->set('tahun_lulus',$pend->tahun_lulus);
			$this->db->set('nama_jenjang',$pend->nama_jenjang);
			$this->db->set('nama_jenjang_rumpun',$pend->nama_jenjang_rumpun);
      $this->db->set('last_updated',"NOW()",false);
			$this->db->update('rekap_peg');
		}
	}
  /* ----------------------------------------- */
  
  
  /* CPNS pegawai */
	function get_peg_cpns($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_cpns,'%d-%m-%Y') AS tmt_cpns,
    DATE_FORMAT(a.sk_cpns_tgl,'%d-%m-%Y') AS sk_cpns_tgl
    ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$row = $this->db->from('r_peg_cpns a')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_cpns');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_peg_cpns')->get()->row();
		}
		return $row;
	}
	function set_peg_cpns($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$cpns = $this->db->from('r_peg_cpns')->get()->row();
		if(! $cpns){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_cpns');
		}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tmt_cpns',"STR_TO_DATE('".$data['tmt_cpns']."','%d-%m-%Y')",false);
		$this->db->set('mk_th',$data['mk_th']);
		$this->db->set('mk_bl',$data['mk_bl']);
		$this->db->set('sk_cpns_nomor',$data['sk_cpns_nomor']);
		$this->db->set('sk_cpns_tgl',"STR_TO_DATE('".$data['sk_cpns_tgl']."','%d-%m-%Y')",false);
		$this->db->set('sk_cpns_pejabat',$data['sk_cpns_pejabat']);
		$this->db->where('id_pegawai',$id_pegawai);
		$result = $this->db->update('r_peg_cpns');
		$this->rekap_cpns($id_pegawai);
		return  $result;
	}
	private function rekap_cpns($id_peg=false){
		if($id_peg){
			$this->db->set('tmt_cpns',NULL);
			$this->db->where('id_pegawai',$id_peg);
			$this->db->update('rekap_peg');
      
			$this->db->from('r_peg_cpns a');
			$this->db->where('a.id_pegawai',$id_peg);
			$dt = $this->db->get()->row();
			if($dt){
				$this->db->set('tmt_cpns',$dt->tmt_cpns);
        $this->db->set('last_updated',"NOW()",false);
				$this->db->where('id_pegawai',$id_peg);
				$this->db->update('rekap_peg');
			}
		}
	}	
  /* ----------------------------------------- */
  
  
  /* PNS pegawai */
	function get_peg_pns($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_pns,'%d-%m-%Y') AS tmt_pns,
    DATE_FORMAT(a.sk_pns_tanggal,'%d-%m-%Y') AS sk_pns_tanggal
    ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$row = $this->db->from('r_peg_pns a')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_pns');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_peg_pns')->get()->row();
		}
		return $row;
	}
	function set_peg_pns($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$pns = $this->db->from('r_peg_pns')->get()->row();
		if(! $pns){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_pns');
		}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tmt_pns',"STR_TO_DATE('".$data['tmt_pns']."','%d-%m-%Y')",false);
		$this->db->set('sk_pns_nomor',$data['sk_pns_nomor']);
		$this->db->set('sk_pns_tanggal',"STR_TO_DATE('".$data['sk_pns_tanggal']."','%d-%m-%Y')",false);
		$this->db->set('sk_pns_pejabat',$data['sk_pns_pejabat']);
		$this->db->where('id_pegawai',$id_pegawai);
		$result = $this->db->update('r_peg_pns');
		$this->rekap_pns($id_pegawai);
		return  $result;
	}
	private function rekap_pns($id_peg=false){
		if($id_peg){
			$this->db->set('tmt_pns',NULL);
			$this->db->where('id_pegawai',$id_peg);
			$this->db->update('rekap_peg');
      
			$this->db->from('r_peg_pns a');
			$this->db->where('a.id_pegawai',$id_peg);
			$dt = $this->db->get()->row();
			if($dt){
				$this->db->set('tmt_pns',$dt->tmt_pns);
        $this->db->set('last_updated',"NOW()",false);
				$this->db->where('id_pegawai',$id_peg);
				$this->db->update('rekap_peg');
			}
		}
	}	
  /* ----------------------------------------- */
    /* KONTRAK pegawai */
	function get_peg_kontrak($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_kontrak,'%d-%m-%Y') AS tmt_kontrak,
	DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal
    ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$res = $this->db->from('r_peg_kontrak a')->get()->result();
		if(!$res) {
			return $this->get_peg_kontrak_bak($id_pegawai);
		}
		return $res;
		// if(! $row){
		// 	$this->db->set('id_pegawai',$id_pegawai);
		// 	$this->db->insert('r_peg_kontrak');
		// 	$this->db->where('id_pegawai',$id_pegawai);
		// 	$row = $this->db->from('r_peg_kontrak')->get()->row();
		// }
		// return $row;
	}
	function get_peg_kontrak_bak($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_kontrak,'%d-%m-%Y') AS tmt_kontrak,
	DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal
    ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$row = $this->db->from('r_peg_kontrak a')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_kontrak');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_peg_kontrak')->get()->row();
		}
		return $row;
	}
	function set_peg_kontrak($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$pns = $this->db->from('r_peg_kontrak')->get()->row();
		if(! $pns){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_kontrak');
		}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tmt_kontrak',"STR_TO_DATE('".$data['tmt_kontrak']."','%d-%m-%Y')",false);
		$this->db->set('sk_nomor',$data['sk_nomor']);
		$this->db->set('sk_tanggal',"STR_TO_DATE('".$data['sk_tanggal']."','%d-%m-%Y')",false);
		$this->db->set('sk_pejabat',$data['sk_pejabat']);
		$this->db->set('mk_th',$data['mk_th']);
		$this->db->set('mk_bl',$data['mk_bl']);
		$this->db->where('id_pegawai',$id_pegawai);
		$result = $this->db->update('r_peg_kontrak');
		$this->rekap_kontrak($id_pegawai);
		return  $result;
	}
	private function rekap_kontrak($id_peg=false){
		if($id_peg){
			$this->db->set('tmt_kontrak',NULL);
			$this->db->where('id_pegawai',$id_peg);
			$this->db->update('rekap_peg');
      
			$this->db->from('r_peg_kontrak a');
			$this->db->where('a.id_pegawai',$id_peg);
			$dt = $this->db->get()->row();
			if($dt){
				$this->db->set('tmt_kontrak',$dt->tmt_kontrak);
				$this->db->set('last_updated',"NOW()",false);
				$this->db->where('id_pegawai',$id_peg);
				$this->db->update('rekap_peg');
			}
		}
	}	
  /* ----------------------------------------- */
   /* ----------------------------------------- */
    /* CAPEG pegawai */
	function get_peg_capeg($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_capeg,'%d-%m-%Y') AS tmt_capeg,
    DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal
    ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$row = $this->db->from('r_peg_capeg a')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_capeg');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_peg_capeg')->get()->row();
		}
		return $row;
	}
	function set_peg_capeg($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$pns = $this->db->from('r_peg_capeg')->get()->row();
		if(! $pns){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_capeg');
		}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tmt_capeg',"STR_TO_DATE('".$data['tmt_capeg']."','%d-%m-%Y')",false);
		$this->db->set('sk_nomor',$data['sk_nomor']);
		$this->db->set('sk_tanggal',"STR_TO_DATE('".$data['sk_tanggal']."','%d-%m-%Y')",false);
		$this->db->set('sk_pejabat',$data['sk_pejabat']);
		$this->db->set('mk_th',$data['mk_th']);
		$this->db->set('mk_bl',$data['mk_bl']);
		$this->db->where('id_pegawai',$id_pegawai);
		$result = $this->db->update('r_peg_capeg');
		$this->rekap_capeg($id_pegawai);
		return  $result;
	}
	private function rekap_capeg($id_peg=false){
		if($id_peg){
			$this->db->set('tmt_capeg',NULL);
			$this->db->where('id_pegawai',$id_peg);
			$this->db->update('rekap_peg');
      
			$this->db->from('r_peg_capeg a');
			$this->db->where('a.id_pegawai',$id_peg);
			$dt = $this->db->get()->row();
			if($dt){
				$this->db->set('tmt_capeg',$dt->tmt_capeg);
        $this->db->set('last_updated',"NOW()",false);
				$this->db->where('id_pegawai',$id_peg);
				$this->db->update('rekap_peg');
			}
		}
	}	
  /* ----------------------------------------- */
  /* TETAP pegawai */
	function get_peg_tetap($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_tetap,'%d-%m-%Y') AS tmt_tetap,
    DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal
    ";
		$this->db->select($sqlselect,false);
		$this->db->where('a.id_pegawai',$id_pegawai);
		$row = $this->db->from('r_peg_tetap a')->get()->row();
		if(! $row){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_tetap');
			$this->db->where('id_pegawai',$id_pegawai);
			$row = $this->db->from('r_peg_tetap')->get()->row();
		}
		return $row;
	}
	function set_peg_tetap($id_pegawai=false,$data=array())
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$pns = $this->db->from('r_peg_tetap')->get()->row();
		if(! $pns){
			$this->db->set('id_pegawai',$id_pegawai);
			$this->db->insert('r_peg_tetap');
		}
		$this->db->set('last_updated',"NOW()",false);
		$this->db->set('tmt_tetap',"STR_TO_DATE('".$data['tmt_tetap']."','%d-%m-%Y')",false);
		$this->db->set('sk_nomor',$data['sk_nomor']);
		$this->db->set('sk_tanggal',"STR_TO_DATE('".$data['sk_tanggal']."','%d-%m-%Y')",false);
		$this->db->set('sk_pejabat',$data['sk_pejabat']);
		$this->db->where('id_pegawai',$id_pegawai);
		$result = $this->db->update('r_peg_tetap');
		$this->rekap_tetap($id_pegawai);
		return  $result;
	}
	private function rekap_tetap($id_peg=false){
		if($id_peg){
			$this->db->set('tmt_tetap',NULL);
			$this->db->where('id_pegawai',$id_peg);
			$this->db->update('rekap_peg');
      
			$this->db->from('r_peg_tetap a');
			$this->db->where('a.id_pegawai',$id_peg);
			$dt = $this->db->get()->row();
			if($dt){
				$this->db->set('tmt_tetap',$dt->tmt_tetap);
        $this->db->set('last_updated',"NOW()",false);
				$this->db->where('id_pegawai',$id_peg);
				$this->db->update('rekap_peg');
			}
		}
	}	
  /* ----------------------------------------- */
  function get_riwayat_diklat($id_pegawai=false)
	{
		$sqlselect = "a.*, 
									DATE_FORMAT(a.tanggal_mulai,'%d-%m-%Y') AS tanggal_mulai,
									DATE_FORMAT(a.tanggal_selesai,'%d-%m-%Y') AS tanggal_selesai,
									DATE_FORMAT(a.tanggal_sk,'%d-%m-%Y') AS tanggal_sk,
									UPPER(a.jenis_diklat) AS jenis_diklat
									";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_sk desc');
		$this->db->from('r_peg_diklat a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
  
  /* Kepangkatan pegawai */
	function get_riwayat_pangkat($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.bkn_tanggal,'%d-%m-%Y') AS bkn_tanggal,
    DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal,
    DATE_FORMAT(a.tmt_golongan,'%d-%m-%Y') AS tmt_golongan
    ";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tmt_golongan desc');
		$this->db->from('r_peg_golongan a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
	function get_riwayat_pangkat_lama($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.sk_tgl,'%d-%m-%Y') AS sk_tgl,
    DATE_FORMAT(a.tmt_pangkat,'%d-%m-%Y') AS tmt_pangkat
    ";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.id_pangkat desc');
		$this->db->from('r_peg_golongan_lama a');
    $this->db->where('a.id_pegawai',$id_pegawai);
		$data = $this->db->get()->result();
    return $data;
	}
	function get_peg_pkt($id_peg_golongan=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.sk_nomor,'%d-%m-%Y') AS sk_nomor,
    DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal,
    DATE_FORMAT(a.tmt_golongan,'%d-%m-%Y') AS tmt_golongan
    ";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tmt_golongan desc');
		$this->db->from('r_peg_golongan a');
		$this->db->where('a.id_peg_golongan',$id_peg_golongan);
		return  $this->db->get()->row();
	}
	function set_peg_pkt($id_pegawai=false,$id_peg_golongan=false,$data=array())
	{
    $row = $this->get_peg_pkt($id_peg_golongan);
    $fields = array(
      'id_peg_golongan',
      'id_pegawai',
      'nip_baru',
      'nama_pegawai',
      'kode_jenis_kp',
      'jenis_kp',
      'kode_golongan',
      'nama_golongan',
      'nama_pangkat',
      'sk_nomor',
      'bkn_nomor',
      'kredit_utama',
      'kredit_tambahan',
      'mk_gol_tahun',
      'mk_gol_bulan'
		);
		$result = false;
		$this->_db_set($fields,$data);
		$this->db->set('last_updated',"NOW()",false);
		if(isset($data['sk_tanggal'])) 
      $this->db->set('sk_tanggal',"STR_TO_DATE('".$data['sk_tanggal']."','%d-%m-%Y')",false);
		if(isset($data['bkn_tanggal'])) 
      $this->db->set('bkn_tanggal',"STR_TO_DATE('".$data['bkn_tanggal']."','%d-%m-%Y')",false);
		if(isset($data['tmt_golongan'])) 
      $this->db->set('tmt_golongan',"STR_TO_DATE('".$data['tmt_golongan']."','%d-%m-%Y')",false);

    $kode_golongan = $this->dropdowns->kode_golongan_pangkat(true);
		if(isset($kode_golongan[$data['kode_golongan']]))
    {
      $k =  $data['kode_golongan'];
      $gol_pangkat = explode(', ',$kode_golongan[$k]);
      $this->db->set('nama_golongan',$gol_pangkat[0]);
      $this->db->set('nama_pangkat',$gol_pangkat[1]);
    }
    $kode_jenis_kp = $this->dropdowns->kode_jenis_kp(true);
		if(isset($kode_jenis_kp[$data['kode_jenis_kp']]))
    {
      $k =  $data['kode_jenis_kp'];
      $this->db->set('jenis_kp',$kode_jenis_kp[$k]);
    }

		if($row){
			$this->db->where('id_peg_golongan',$id_peg_golongan);
			$result = $this->db->update('r_peg_golongan');
		}else{
			$this->db->set('id_pegawai',$data['id_pegawai']);
			$this->db->insert('r_peg_golongan');
			$id_peg_golongan = $this->db->insert_id();
			$result = $id_peg_golongan;
		}
		$this->rekap_pkt($data['id_pegawai']);
		return  $result;
	}
	function del_peg_pkt($id_peg_golongan=false)
	{
		$row = $this->get_peg_pkt($id_peg_golongan);
    $result = false;
    if($row){
      $this->db->where('id_peg_golongan',$id_peg_golongan);
      $result = $this->db->delete('r_peg_golongan');
      $this->rekap_pkt($row->id_pegawai);
    }
		return $result;
	}
	function rekap_pkt($id_pegawai=false)
	{
		$this->db->where('id_pegawai',$id_pegawai);
		$this->db->from('r_peg_golongan');
		$this->db->order_by('tmt_golongan desc');
		$dt_pkt = $this->db->get();
		if($dt_pkt->num_rows() > 1){
      $row = $dt_pkt->row();
			$this->db->where('id_pegawai',$row->id_pegawai);
			$this->db->set('kode_golongan',$row->kode_golongan);
			$this->db->set('nama_golongan',$row->nama_golongan);
			$this->db->set('nama_pangkat',$row->nama_pangkat);
			$this->db->set('tmt_pangkat',$row->tmt_golongan);
      $this->db->set('last_updated',"NOW()",false);
			$this->db->update('rekap_peg');
		}
	}
  /* ----------------------------------------- */
//diklat
  // function get_riwayat_diklat($id_pegawai=false)
	// {
		// $sqlselect = "a.*, 
							// DATE_FORMAT(a.tanggal_mulai,'%d-%m-%Y') AS tanggal_mulai,
							// DATE_FORMAT(a.tanggal_selesai,'%d-%m-%Y') AS tanggal_selesai
							// ";
		// $this->db->select($sqlselect,false);
		// $this->db->order_by('a.tanggal_tes desc');
		// $this->db->from('r_peg_diklat a');
		// if(is_array($id_pegawai)){
			// if(count($id_pegawai) > 0){
				// $this->db->where_in('a.id_pegawai',$id_pegawai);
        // }else{
				// return array();
			// }
      // }else{
			// $this->db->where('a.id_pegawai',$id_pegawai);
		// }
		// $data = $this->db->get()->result();
		// if(!$data){
			// return array();
      // }else{
			// return $data;
		// }
	// }
	 
 //pengalaman
  function get_riwayat_pengalaman($id_pegawai=false)
	{
		$sqlselect = "a.*, 
							DATE_FORMAT(a.tanggal_awal,'%d-%m-%Y') AS tanggal_awal,
							DATE_FORMAT(a.tanggal_akhir,'%d-%m-%Y') AS tanggal_akhir
							";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_akhir desc');
		$this->db->from('r_peg_pengalaman a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
        }else{
				return array();
			}
      }else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
      }else{
			return $data;
		}
	}
	
  //psikotes
  function get_riwayat_psikotes($id_pegawai=false)
	{
		$sqlselect = "a.*, 
							DATE_FORMAT(a.tanggal_tes,'%d-%m-%Y') AS tanggal_tes
							";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_tes desc');
		$this->db->from('r_peg_psikotes a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
        }else{
				return array();
			}
      }else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
      }else{
			return $data;
		}
	}
	
	//kesehatan
  function get_riwayat_kesehatan($id_pegawai=false)
	{
		$sqlselect = "a.*, 
							DATE_FORMAT(a.tanggal_tes,'%d-%m-%Y') AS tanggal_tes
							";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_tes desc');
		$this->db->from('r_peg_kesehatan a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
        }else{
				return array();
			}
      }else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
      }else{
			return $data;
		}
	}
	
	 //penghargaan
  function get_riwayat_penghargaan($id_pegawai=false)
	{
		$sqlselect = "a.*, 
							DATE_FORMAT(a.tanggal_sk,'%d-%m-%Y') AS sk_tanggal
							";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_sk desc');
		$this->db->from('r_peg_penghargaan a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
        }else{
				return array();
			}
      }else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
      }else{
			return $data;
		}
	}
	
	 //sanksi
  function get_riwayat_sanksi($id_pegawai=false)
	{
		$sqlselect = "a.*, 
							DATE_FORMAT(a.tanggal_sk,'%d-%m-%Y') AS sk_tanggal
							";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tanggal_sk desc');
		$this->db->from('r_peg_sanksi a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
        }else{
				return array();
			}
      }else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
      }else{
			return $data;
		}
	}
  
  /* Jabatan pegawai */
	function get_riwayat_jabatan($id_pegawai=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_jabatan,'%d-%m-%Y') AS tmt_jabatan,
    DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal,
    DATE_FORMAT(a.tmt_pelantikan,'%d-%m-%Y') AS tmt_pelantikan
    ";
		$this->db->select($sqlselect,false);
		$this->db->order_by('a.tmt_jabatan desc');
		$this->db->from('r_peg_jab a');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
        }else{
				return array();
			}
      }else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
      }else{
			return $data;
		}
	}
	function get_peg_jabatan($id_peg_jab=false)
	{
		$sqlselect = "a.*, 
    DATE_FORMAT(a.tmt_jabatan,'%d-%m-%Y') AS tmt_jabatan,
    DATE_FORMAT(a.sk_tanggal,'%d-%m-%Y') AS sk_tanggal,
    DATE_FORMAT(a.tmt_pelantikan,'%d-%m-%Y') AS tmt_pelantikan
    ";
		$this->db->select($sqlselect,false);
		$this->db->from('r_peg_jab a');
		$this->db->where('a.id_peg_jab',$id_peg_jab);
		return  $this->db->get()->row();
	}
	function set_peg_jabatan($id_pegawai=false,$id_peg_jab=false,$data=array())
	{
    $row = $this->get_peg_jabatan($id_peg_jab);
    $fields = array(
      'id_unor',
      'nama_jenis_jabatan',
      'tugas_tambahan',
      'sk_pejabat',
      'sk_nomor'
		);

		$result = false;
		$this->_db_set($fields,$data);
		$this->db->set('last_updated',"NOW()",false);

		if(isset($data['id_jabatan'])) 
    $this->db->set('tmt_jabatan',"STR_TO_DATE('".$data['tmt_jabatan']."','%d-%m-%Y')",false);

		if(isset($data['tmt_jabatan'])) 
    $this->db->set('tmt_jabatan',"STR_TO_DATE('".$data['tmt_jabatan']."','%d-%m-%Y')",false);

		if(isset($data['sk_tanggal'])) 
    $this->db->set('sk_tanggal',"STR_TO_DATE('".$data['sk_tanggal']."','%d-%m-%Y')",false);

		if(isset($data['tmt_pelantikan'])) 
    $this->db->set('tmt_pelantikan',"STR_TO_DATE('".$data['tmt_pelantikan']."','%d-%m-%Y')",false);

    // get unor atribute
    $unor = $this->db->where('id_unor',$data['id_unor'])->get('m_unor')->row();
      $this->db->set('kode_unor',$unor->kode_unor);
      $this->db->set('nama_unor',$unor->nama_unor);
      $this->db->set('nomenklatur_pada',$unor->nomenklatur_pada);
    
    if($data['nama_jenis_jabatan'] == 'js'){
      $this->db->set('nama_jabatan',$data['nama_jabatan_js']);
      $this->db->set('nama_jabatan_js',$unor->nomenklatur_jabatan);
      // $this->db->set('kode_ese',$unor->kode_ese);
      // $this->db->set('nama_ese',$unor->nama_ese);
    }else{
      $this->db->set('nama_jabatan',$data['nama_jabatan_jf']);
      $this->db->set('id_jabatan',$data['id_jabatan']);
      $this->db->set('nama_jabatan_jf',$data['nama_jabatan_jf']);
      // $this->db->set('kode_ese','99');
      // $this->db->set('nama_ese','Non Eselon');
    }
    
		if($row){
			$this->db->where('id_peg_jab',$id_peg_jab);
			$result = $this->db->update('r_peg_jab');
      }else{
			$this->db->set('id_pegawai',$data['id_pegawai']);
			$this->db->insert('r_peg_jab');
			$id_peg_jab = $this->db->insert_id();
			$result = $id_peg_jab;
		}
		$this->rekap_jabatan($id_pegawai);
		return  $result;
	}
	function del_peg_jabatan($id_peg_jab=false)
	{
		$row = $this->get_peg_jabatan($id_peg_jab);
    $result = false;
    if($row){
      $this->db->where('id_peg_jab',$id_peg_jab);
      $result = $this->db->delete('r_peg_jab');
      $this->rekap_jabatan($row->id_pegawai);
    }
		return $result;
	}
	function rekap_jabatan($id_pegawai=false){
    $this->db->where('id_pegawai',$id_pegawai);
    $this->db->order_by('tmt_jabatan','desc');
    $this->db->from('r_peg_jab');
    $ds = $this->db->get();
    
    if($ds->num_rows() > 0){
      $row = $ds->row();
      if($row->nama_jenis_jabatan == 'js' ){
        $this->db->set('nomenklatur_jabatan',$row->nama_jabatan_js);
        // $this->db->set('kode_ese',$row->kode_ese);
        // $this->db->set('nama_ese',$row->nama_ese);
      }else{
        $this->db->set('nomenklatur_jabatan',$row->nama_jabatan_jf);
        // $this->db->set('kode_ese','99');
        // $this->db->set('nama_ese','Non Eselon');
      }

      $this->db->set('id_unor',$row->id_unor);
      $this->db->set('kode_unor',$row->kode_unor);
      $this->db->set('nama_unor',$row->nama_unor);
      $this->db->set('nomenklatur_pada',$row->nomenklatur_pada);
      $this->db->set('jab_type',$row->nama_jenis_jabatan);
      $this->db->set('tugas_tambahan',$row->tugas_tambahan);
      $this->db->set('tmt_jabatan',$row->tmt_jabatan);

      $this->db->set('last_updated',"NOW()",false);
      
      $this->db->where('id_pegawai',$id_pegawai);
      $this->db->update('rekap_peg');
    }
  }
  /* ----------------------------------------- */
 
  
  
  /* Kediklatan pegawai */
	function get_riwayat_diklat_struk($id_pegawai=false)
	{
		$this->db->select('year(a.tmt_diklat) as tahun,a.*,b.*',false);
		$this->db->from('r_peg_diklat_struk a');
		$this->db->join('m_rumpun_diklat_struktural b','a.id_rumpun=b.id_rumpun','left');
		$this->db->order_by('a.tmt_diklat desc');
		if(is_array($id_pegawai)){
			if(count($id_pegawai) > 0){
				$this->db->where_in('a.id_pegawai',$id_pegawai);
			}else{
				return array();
			}
		}else{
			$this->db->where('a.id_pegawai',$id_pegawai);
		}
		$data = $this->db->get()->result();
		if(!$data){
			return array();
		}else{
			return $data;
		}
	}
	function get_peg_diklat_struk($id=false)
	{
		$this->db->select('year(a.tmt_diklat) as tahun,a.*,b.*',false);
		$this->db->from('r_peg_diklat_struk a');
		$this->db->join('m_rumpun_diklat_struktural b','a.id_rumpun=b.id_rumpun','left');
		$this->db->where('a.id_peg_diklat_struk',$id);
		return  $this->db->get()->row();
	}
	function set_peg_diklat_struk($id_peg_diklat_struk=false,$data=array())
	{
		$fields = array(
			'id_rumpun',
			'nama_diklat',
			'tempat_diklat',
			'penyelenggara',
			'angkatan',
			'tmt_diklat',
			'tst_diklat',
			'jam',
			'nomor_sttpl',
			'tanggal_sttpl',
			);
		$this->_db_set($fields,$data);
		
		if($id_peg_diklat_struk){
			$this->db->where('id_peg_diklat_struk',$id_peg_diklat_struk);
			return  $this->db->update('r_peg_diklat_struk');
		}else{
			$this->db->set('id_pegawai',$data['id_pegawai']);
			$this->db->insert('r_peg_diklat_struk');
			$id_peg_diklat_struk = $this->db->insert_id();
			return $id_peg_diklat_struk;
		}
	}
	function rekap_diklat_struk($id_peg=false){
    $this->db->where('a.id_pegawai',$id_peg);
    $this->db->where('a.id_rumpun !=',0);
    $this->db->where('a.id_rumpun !=',5);
    $this->db->order_by('a.id_rumpun desc');
    $this->db->join('m_rumpun_diklat_struktural b','a.id_rumpun=b.id_rumpun');
    $rdikstruk  = $this->db->get('r_peg_diklat_struk a')->result();
    if(count($rdikstruk) > 0){
      $this->db->set('id_peg_diklat_struk',$rdikstruk[0]->id_peg_diklat_struk);
      $this->db->set('id_rumpun_diklat_struk',$rdikstruk[0]->id_rumpun);
      $this->db->set('nama_diklat_struk',$rdikstruk[0]->nama_diklat);
      $this->db->set('nama_diklat_struk_rumpun',$rdikstruk[0]->nama_rumpun);
      $this->db->set('nomor_sttpl_diklat_struk',$rdikstruk[0]->nomor_sttpl);
      $this->db->set('tanggal_sttpl_diklat_struk',$rdikstruk[0]->tanggal_sttpl);
			}else{
      $this->db->set('id_peg_diklat_struk',NULL);
      $this->db->set('id_rumpun_diklat_struk',NULL);
      $this->db->set('nama_diklat_struk',NULL);
      $this->db->set('nama_diklat_struk_rumpun',NULL);
      $this->db->set('nomor_sttpl_diklat_struk',NULL);
      $this->db->set('tanggal_sttpl_diklat_struk',NULL);
    }
    $this->db->where('id_pegawai',$id_peg);
    $this->db->update('rekap_peg');
	}	
}