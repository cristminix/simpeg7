<?php 
class M_widget extends CI_Model{
	
	public $ttlRow				 = "";
	
	
	public function get_kenaikan_berkala($bln,$filter=array(),$limit=""){
		$where = "WHERE YEAR(CURDATE()+INTERVAL $bln MONTH) - YEAR(tmt_pangkat)= 2 AND MONTH(tmt_pangkat) = MONTH(CURDATE()+INTERVAL $bln MONTH)";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (nip_baru like '%".$val."%' OR nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		$sql = "SELECT *,DATE_FORMAT(tmt_pangkat,'%d-%m-%Y') as tmt_pangkat,'$bln' as blnASl,YEAR(CURDATE()+INTERVAL $bln MONTH) as thnss,MONTH(CURDATE()+INTERVAL $bln MONTH) as blnn FROM rekap_peg $where $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	public function get_kenaikan_peringkat($bln,$filter=array(),$limit=""){
		$where = "WHERE YEAR(CURDATE()+INTERVAL $bln MONTH) - YEAR(tmt_pangkat)= 4 AND MONTH(tmt_pangkat) = MONTH(CURDATE()+INTERVAL $bln MONTH)";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (nip_baru like '%".$val."%' OR nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		
		$sql = "SELECT *,DATE_FORMAT(tmt_pangkat,'%d-%m-%Y') as tmt_pangkat,YEAR(CURDATE()+INTERVAL $bln MONTH) as mth,'$bln' as Mo FROM rekap_peg $where $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	public function get_pensiun($bln,$filter=array(),$limit=""){
		$where = "WHERE TIMESTAMPDIFF(YEAR,tanggal_lahir,CURDATE()+INTERVAL $bln MONTH) >= 56 
				AND status_pegawai='Tetap' AND id_pegawai NOT IN(SELECT id_pegawai FROM r_pegawai_pensiun)";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (nip_baru like '%".$val."%' OR nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		
		
		$sql = "SELECT *,DATE_FORMAT(tanggal_lahir,'%d-%m-%Y') as tanggal_lahir FROM rekap_peg 
				$where $limit";
		$execQuery = $this->db->query($sql);
		// die($this->db->last_query());
		return $execQuery;
	}
	
	
	public function get_cuti($bln,$filter=array(),$limit=""){
		$where = "WHERE (MONTH(b.tgl_cuti1) = MONTH(CURDATE()+INTERVAL $bln MONTH) OR MONTH(b.tgl_cuti2) = MONTH(CURDATE()+INTERVAL $bln MONTH)) ";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(a.kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (a.nip_baru like '%".$val."%' OR a.nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND a.kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND a.jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND a.gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND a.agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND a.status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND a.nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		
		
		$sql = "SELECT a.*,b.id_cuti,if(DATEDIFF(b.tgl_cuti2,b.tgl_cuti1) > 0,CONCAT(DATE_FORMAT(b.tgl_cuti1,'%d-%m-%Y'),' s/d ',DATE_FORMAT(b.tgl_cuti2,'%d-%m-%Y')),DATE_FORMAT(b.tgl_cuti1,'%d-%m-%Y')) as tgl_cuti,b.remarks FROM r_peg_cuti b
				LEFT JOIN rekap_peg a ON a.id_pegawai = b.id_pegawai
				$where $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	public function get_kontrak($bln,$filter=array(),$limit=""){
		$where = "WHERE TIMESTAMPDIFF(MONTH,DATE_ADD(a.tmt_kontrak,INTERVAL b.mk_bl MONTH),CURDATE()+INTERVAL $bln MONTH) <= 1 AND TIMESTAMPDIFF(MONTH,DATE_ADD(a.tmt_kontrak,INTERVAL b.mk_bl MONTH),CURDATE()+INTERVAL $bln MONTH) >= 0 AND a.status_pegawai = 'Kontrak'";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(a.kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (a.nip_baru like '%".$val."%' OR a.nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND a.kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND a.jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND a.gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND a.agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND a.status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND a.nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		
		$sql = "SELECT a.*,DATE_FORMAT(a.tmt_kontrak,'%d-%m-%Y') as tmt_kontrak,b.mk_bl FROM rekap_peg a 
			    LEFT JOIN r_peg_kontrak b ON b.id_pegawai = a.id_pegawai AND b.tmt_kontrak = a.tmt_kontrak $where $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	public function get_capeg($bln,$filter=array(),$limit=""){
		$where = "WHERE TIMESTAMPDIFF(MONTH,DATE_ADD(a.tmt_capeg,INTERVAL b.mk_th YEAR),CURDATE()+INTERVAL $bln MONTH) <= 1 AND TIMESTAMPDIFF(MONTH,DATE_ADD(a.tmt_capeg,INTERVAL b.mk_th YEAR),CURDATE()+INTERVAL $bln MONTH) >= 0 AND a.status_pegawai = 'Capeg'";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(a.kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (a.nip_baru like '%".$val."%' OR a.nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND a.kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND a.jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND a.gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND a.agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND a.status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND a.nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		$sql = "SELECT a.*,DATE_FORMAT(a.tmt_capeg,'%d-%m-%Y') as tmt_capeg,b.mk_bl FROM rekap_peg a 
			    LEFT JOIN r_peg_capeg b ON b.id_pegawai = a.id_pegawai AND b.tmt_capeg = a.tmt_capeg $where $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	public function get_tunjangan_anak($filter=array(),$limit=""){
		$sql = "SELECT a.*,DATE_FORMAT(a.tanggal_lahir_anak,'%d-%m-%Y') as tanggal_lahir_anak,b.nama_pegawai,b.nip_baru FROM r_peg_anak a 
				LEFT JOIN rekap_peg b ON b.id_pegawai = a.id_pegawai
				WHERE TIMESTAMPDIFF(YEAR,a.tanggal_lahir_anak,CURDATE()) >= 25 AND a.keterangan_tunjangan='Dapat' $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	
	public function get_rekap_p_sanksi($filter=array(),$limit="",$count=true){
		if(!isset($_POST['kategori']) && $count === true){
			$sql = "SELECT id_pegawai,nomor_sk FROM r_peg_penghargaan
					UNION ALL
					SELECT id_pegawai,nomor_sk FROM r_peg_sanksi";
		}elseif(isset($_POST['kategori']) && $count === true){
			switch ($_POST['kategori']) {
				case "penghargaan":
					$sql = "SELECT a.id_pegawai,b.nip_baru,b.nama_pegawai,a.nomor_sk,DATE_FORMAT(a.tanggal_sk,'%d-%m-%Y')as tanggal_sk,a.uraian 
							FROM r_peg_penghargaan a
							LEFT JOIN rekap_peg b ON b.id_pegawai = a.id_pegawai $limit
					";
				break;
					
				case "sanksi":
					$sql = "SELECT a.id_pegawai,b.nip_baru,b.nama_pegawai,a.nomor_sk,DATE_FORMAT(a.tanggal_sk,'%d-%m-%Y')as tanggal_sk,a.uraian 
							FROM r_peg_sanksi a
							LEFT JOIN rekap_peg b ON b.id_pegawai = a.id_pegawai $limit";
				break;
			}
		}elseif(!isset($_POST['kategori']) && $count === false){
			$sql = "SELECT a.id_pegawai,b.nip_baru,b.nama_pegawai,a.nomor_sk,DATE_FORMAT(a.tanggal_sk,'%d-%m-%Y')as tanggal_sk,a.uraian 
							FROM r_peg_sanksi a
							LEFT JOIN rekap_peg b ON b.id_pegawai = a.id_pegawai $limit";
		}
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	public function get_peg_sotk($count=false,$param,$filter=array(),$limit=""){
		if($count){
			$sql = "SELECT count(a.id_pegawai) as total,b.nama_unor as title,SUBSTRING(b.kode_unor,1,5) as keys_data FROM rekap_peg a 
					LEFT JOIN m_unor b ON SUBSTRING(a.kode_unor,1,5) = b.kode_unor GROUP BY b.id_unor,b.nama_unor,b.kode_unor
					$limit order by b.kode_unor asc";
		}else{
			$where = " WHERE id_pegawai IS NOT NULL";
			if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(kode_unor,1,5) = '".$val."'";
							}
							break;
						case "pns":
							if($val!="" && $val!="all"){
								$where .= " AND status_pegawai = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (nip_baru like '%".$val."%' OR nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
			$sql = "SELECT * FROM rekap_peg $where $limit";
			//die($sql);
		}
		$execQuery = $this->db->query($sql);
		
		return $execQuery;
	}
	
	
	function get_pegawai(){
		$key = $_POST['query'];
		$sql = "SELECT id_pegawai as id, nama_pegawai as label FROM rekap_peg WHERE nip_baru like '%".$key."%' OR nama_pegawai like '%".$key."%'";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	function insert_cuti(){
		$tgl = explode("-",$_POST["tgl_cuti"]);
		$post = array(
			"id_pegawai"=>$_POST["nip_id"],
			"tgl_cuti1"=>trim($tgl[0]),
			"tgl_cuti2"=>trim($tgl[1]),
			"remarks"=>$_POST["remarks"]
		);
		return $this->db->insert('r_peg_cuti',$post);
	}
	
	function remove_cuti(){
		$post = array(
			"id_cuti"=>$_POST["id_cut"]
		);
		return $this->db->delete('r_peg_cuti',$post);
	}
	
	
	public function get_nominatif($filter=array(),$limit=""){
		$where = "WHERE nip_baru IS NOT NULL";
		if(!empty($filter)){
				foreach($filter as $key=>$val){
					switch ($key) {
						case "kode":
							if($val!=""){
								$where .= " AND SUBSTRING(kode_unor,1,5) = '".$val."'";
							}
							break;
						case "cari":
							if($val!=""){
								$where .= " AND (nip_baru like '%".$val."%' OR nama_pegawai like '%".$val."%')";
							}
							break;
						case "pkt":
							if($val!=""){
								$where .= " AND kode_golongan='".$val."'";
							}
							break;
						case "jbt":
							if($val!=""){
								$where .= " AND jab_type='".$val."'";
							}
							break;
						case "gender":
							if($val!=""){
								$where .= " AND gender='".$val."'";
							}
							break;
						case "agama":
							if($val!=""){
								$where .= " AND agama='".$val."'";
							}
							break;
						case "status":
							if($val!=""){
								$where .= " AND status_perkawinan='".$val."'";
							}
							break;
						case "jenjang":
							if($val!=""){
								$where .= " AND nama_jenjang='".$val."'";
							}
							break;
					}
				}
			}
		
		$sql = "SELECT nama_pegawai,
					   nip_baru,
					   nomenklatur_jabatan,
					   nomenklatur_pada,
					   if(gender='l','Laki-laki','Perempuan') as gender,
					   IF(nama_jenjang IS NOT NULL, nama_jenjang, '-') as nama_jenjang,
					   IF(tmt_tetap IS NOT NULL,DATE_FORMAT(tmt_tetap,'%d-%m-%Y'),'-') as tmt_tetap,
					   IF(tanggal_lahir IS NOT NULL,DATE_FORMAT(tanggal_lahir,'%d-%m-%Y'),'-') as tanggal_lahir,
					   IF(tanggal_lahir IS NOT NULL,DATE_FORMAT(DATE_ADD(tanggal_lahir,INTERVAL 56 YEAR),'%d-%m-%Y'),'-') AS tanggal_pensiun,
					   IF(tmt_tetap IS NOT NULL,TIMESTAMPDIFF(YEAR,tmt_tetap,DATE_ADD(tanggal_lahir,INTERVAL 56 YEAR)),'-') AS selisih_pensiun
				FROM rekap_peg 
				$where ORDER BY kode_unor ASC $limit";
		$execQuery = $this->db->query($sql);
		return $execQuery;
	}
	
	function get_detail_cuti($id){
		$sql = "SELECT DATE_FORMAT(a.tgl_cuti1,'%d-%m-%Y') as tgl_cuti1,DATE_FORMAT(a.tgl_cuti2,'%d-%m-%Y') as tgl_cuti2,DATEDIFF(a.tgl_cuti2,a.tgl_cuti1) AS DiffDate,a.remarks,a.tgl_input,b.nip_baru,b.nama_pegawai,b.nomenklatur_pada,b.nomenklatur_jabatan,c.nama_pegawai as atasan,c.nomenklatur_jabatan as jabatan_atasan,SUBSTR(b.kode_unor,1,5) as test 
				FROM r_peg_cuti a
				LEFT JOIN rekap_peg b ON b.id_pegawai = a.id_pegawai
				LEFT JOIN rekap_peg c ON c.kode_unor = SUBSTR(b.kode_unor,1,5) AND c.jab_type = 'js'
				WHERE a.id_cuti='$id'";
		$execQuery = $this->db->query($sql);
		return $execQuery;		
	}
	
}