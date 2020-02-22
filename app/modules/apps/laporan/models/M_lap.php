<?php
class M_lap extends CI_Model{
	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
	}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
	function ini_pegawai($id_pegawai){
		$this->db->from('rekap_peg');
		$this->db->where('id_pegawai',$id_pegawai);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function hitung_pegawai($cari){
$carib = ($cari=="")?"":"WHERE (b.nama_pegawai LIKE '%$cari%' OR b.nip_baru LIKE '%$cari%' OR b.nomenklatur_jabatan LIKE '%$cari%' OR b.nomenklatur_pada LIKE '%$cari%' OR b.tempat_lahir LIKE '%$cari%' OR b.kode_unor LIKE '$cari%')";
		$sqlstr="SELECT COUNT(b.id_pegawai) AS numrows
FROM (rekap_peg b)
$carib
";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function get_pegawai($cari,$mulai,$batas){
$carib = ($cari=="")?"":"WHERE (b.nama_pegawai LIKE '%$cari%' OR b.nip_baru LIKE '%$cari%' OR b.nomenklatur_jabatan LIKE '%$cari%' OR b.nomenklatur_pada LIKE '%$cari%' OR b.tempat_lahir LIKE '%$cari%' OR b.kode_unor LIKE '$cari%')";
		$sqlstr="SELECT b.*
FROM (rekap_peg b)
$carib
ORDER BY b.kode_unor ASC
LIMIT $mulai,$batas
";
		$hslquery = $this->db->query($sqlstr)->result();
		return $hslquery;
	}


	function ini_user_pegawai($id_pegawai){
		$this->db->from('users a');
		$this->db->join('user_pegawai b','a.user_id=b.user_id','left');
		$this->db->where('b.id_pegawai',$id_pegawai);
		$hslquery = $this->db->get()->row();

		return $hslquery;
	}

	function ini_user($userid){
//		$this->db->select('a.*,b.group');
		$this->db->from('users a');
//		$this->db->join('user_group b','a.group_id=b.group_id','left');
		$this->db->where('a.user_id',$userid);
		$hslquery = $this->db->get()->row();
		return $hslquery;
	}

	function ganti_password($isi){
        $this->db->set('passwd',sha1($isi['pw1']));
        $this->db->where('user_id',$isi['user_id']);
		$this->db->update('users');
	}

	function get_lap_kepangkatan($mulai,$batas,$dt1,$dt2){
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"WHERE tmt_golongan BETWEEN '$tanggal' AND '$tanggal2'";					
			}
			
					
			if($mulai=='0'){
				$limit="";
			}else{
				$mulai=$mulai-1;
				$mulai=$mulai;
				$batas=$batas-$mulai;
				$limit="LIMIT $mulai,$batas ";			
			}
			
			
			$sqlstr="SELECT *
							FROM r_peg_golongan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal
							ORDER BY a.nama_pegawai,a.tmt_golongan
							$limit";
			
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}
		
		function get_kepangkatan($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tmt_golongan BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			
			$sqlstr="SELECT *
							FROM r_peg_golongan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (a.nama_pegawai  LIKE '%$cari%'
							OR  a.nip_baru  LIKE '%$cari%' OR a.sk_nomor LIKE '%$cari%')	
							$iTanggal
							ORDER BY a.nama_pegawai,a.tmt_golongan
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_kepangkatan($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tmt_golongan BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			

			$sqlstr="SELECT COUNT(id_peg_golongan) AS `numrows`
							FROM (`r_peg_golongan`)
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `sk_nomor`  LIKE '%$cari%'
							) $iTanggal
							";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
		
		
		//========================================
		
		function get_lap_jabatan($mulai,$batas,$dt1,$dt2){
				if (($dt1=="") OR ($dt2=="") ) {
					$iTanggal = "";			
				}else{
					$tanggal=$dt1;
					$tanggal2=$dt2;
					$iTanggal = ($tanggal=="xx")?"":"WHERE tmt_jabatan BETWEEN '$tanggal' AND '$tanggal2'";					
				}
	
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				$sqlstr="SELECT *
							FROM r_peg_jab a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal
							ORDER BY a.nama_pegawai,a.sk_tanggal
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_jabatan($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tmt_jabatan BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			$sqlstr="SELECT *
							FROM r_peg_jab a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							JOIN m_unor c ON a.id_unor=c.id_unor
							WHERE  (a.nama_pegawai  LIKE '%$cari%'
							OR  a.nip_baru  LIKE '%$cari%' OR a.sk_nomor LIKE '%$cari%')	
							$iTanggal
							ORDER BY a.nama_pegawai,a.sk_tanggal
							LIMIT $mulai,$batas";

			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_jabatan($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tmt_jabatan BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			$sqlstr="SELECT COUNT(id_peg_jab) AS `numrows`
							FROM (`r_peg_jab`)
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `sk_nomor`  LIKE '%$cari%'
							) $iTanggal
							";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
	
		
		//========================================
		//========================================
		
		function get_lap_sanksi($mulai,$batas,$dt1,$dt2){
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"WHERE tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";					
			}
			
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				$sqlstr="SELECT *
							FROM r_peg_sanksi a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal 
							ORDER BY b.nama_pegawai,a.tanggal_sk
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_sanksi($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			$sqlstr="SELECT *
							FROM r_peg_sanksi a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (b.nama_pegawai  LIKE '%$cari%'
							OR  b.nip_baru  LIKE '%$cari%' OR a.nomor_sk LIKE '%$cari%')	
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_sk
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_sanksi($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			$sqlstr="SELECT COUNT(id_peg_sanksi) AS `numrows`
							FROM r_peg_sanksi a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `nomor_sk`  LIKE '%$cari%') $iTanggal";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
	
		
		//========================================
		//========================================
		
		function get_lap_penghargaan($mulai,$batas,$dt1,$dt2){
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"WHERE tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";					
			}
			
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				$sqlstr="SELECT *
							FROM r_peg_penghargaan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_sk
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_penghargaan($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			
			$sqlstr="SELECT *
							FROM r_peg_penghargaan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (b.nama_pegawai  LIKE '%$cari%'
							OR  b.nip_baru  LIKE '%$cari%' OR a.nomor_sk LIKE '%$cari%')	
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_sk
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_penghargaan($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				// $tanggal=date('Y-d-m',strtotime($dt1));
				// $tanggal2=date('Y-d-m',strtotime($dt2));
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			
			$sqlstr="SELECT COUNT(id_peg_penghargaan) AS `numrows`
							FROM r_peg_penghargaan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `nomor_sk`  LIKE '%$cari%') $iTanggal";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
			//========================================
		
		function get_lap_kesehatan($mulai,$batas,$dt1,$dt2){
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"WHERE tanggal_tes BETWEEN '$tanggal' AND '$tanggal2'";					
			}
			
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				
				$sqlstr="SELECT *
							FROM r_peg_kesehatan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							ORDER BY b.nama_pegawai,a.tanggal_tes
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_kesehatan($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_tes BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			
			$sqlstr="SELECT *
							FROM r_peg_kesehatan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (b.nama_pegawai  LIKE '%$cari%'
							OR  b.nip_baru  LIKE '%$cari%' OR a.tempat LIKE '%$cari%')	
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_tes
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_kesehatan($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_tes BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			
			$sqlstr="SELECT COUNT(id_peg_kesehatan) AS `numrows`
							FROM r_peg_kesehatan a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `tempat`  LIKE '%$cari%') $iTanggal ";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
		
			//========================================
		
		function get_lap_psikotes($mulai,$batas,$dt1,$dt2){
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"WHERE tanggal_tes BETWEEN '$tanggal' AND '$tanggal2'";					
			}
			
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				$sqlstr="SELECT *
							FROM r_peg_psikotes a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_tes
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_psikotes($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_tes BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			$sqlstr="SELECT *
							FROM r_peg_psikotes a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (b.nama_pegawai  LIKE '%$cari%'
							OR  b.nip_baru  LIKE '%$cari%' OR a.tempat LIKE '%$cari%')	
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_tes
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_psikotes($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_tes BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			
			$sqlstr="SELECT COUNT(id_peg_psikotes) AS `numrows`
							FROM r_peg_psikotes a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `tempat`  LIKE '%$cari%') $iTanggal ";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
			//========================================
		
		function get_lap_pengalaman($mulai,$batas,$dt1,$dt2){
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"WHERE tanggal_akhir BETWEEN '$tanggal' AND '$tanggal2'";					
			}
			
			
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				$sqlstr="SELECT *
							FROM r_peg_pengalaman a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_awal,a.tanggal_akhir
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_pengalaman($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_akhir BETWEEN '$tanggal' AND '$tanggal2'";						
			}
			
			$sqlstr="SELECT *
							FROM r_peg_pengalaman a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (b.nama_pegawai  LIKE '%$cari%'
							OR  b.nip_baru  LIKE '%$cari%' OR a.perusahaan LIKE '%$cari%' OR a.pekerjaan LIKE '%$cari%')	
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_awal,a.tanggal_akhir
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_pengalaman($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_akhir BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			$sqlstr="SELECT COUNT(id_peg_pengalaman) AS `numrows`
							FROM r_peg_pengalaman a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `perusahaan`  LIKE '%$cari%'
							OR  `pekerjaan`  LIKE '%$cari%') $iTanggal ";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
		
			//========================================
		
		function get_lap_diklat($mulai,$batas,$dt1,$dt2){
				if (($dt1=="") OR ($dt2=="") ) {
					$iTanggal = "";			
				}else{
					$tanggal=$dt1;
					$tanggal2=$dt2;
					$iTanggal = ($tanggal=="xx")?"":"WHERE tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";					
				}
				if($mulai=='0'){
					$limit="";
				}else{
					$mulai=$mulai-1;
					$mulai=$mulai;
					$batas=$batas-$mulai;
					$limit="LIMIT $mulai,$batas ";			
				}
				$sqlstr="SELECT *
							FROM r_peg_diklat a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_mulai,a.tanggal_selesai
							$limit";
				$hslquery=$this->db->query($sqlstr)->result();
				return $hslquery;
		}
		
		function get_diklat($cari,$mulai,$batas){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";						
			}
		
			$sqlstr="SELECT *
							FROM r_peg_diklat a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (b.nama_pegawai  LIKE '%$cari%'
							OR  b.nip_baru  LIKE '%$cari%' OR a.nama_diklat LIKE '%$cari%' OR a.tempat_diklat LIKE '%$cari%')	
							$iTanggal
							ORDER BY b.nama_pegawai,a.tanggal_mulai,a.tanggal_selesai
							LIMIT $mulai,$batas";
			$hslquery=$this->db->query($sqlstr)->result();
			return $hslquery;
		}

		
		function hitung_diklat($cari){
			$dt1 = $_POST['tanggal'];
			$dt2 = $_POST['tanggal2'];
			if (($dt1=="") OR ($dt2=="") ) {
				$iTanggal = "";			
			}else{
				$tanggal=$dt1;
				$tanggal2=$dt2;
				$iTanggal = ($tanggal=="xx")?"":"AND tanggal_sk BETWEEN '$tanggal' AND '$tanggal2'";						
			}		
			$sqlstr="SELECT COUNT(id_peg_diklat) AS `numrows`
							FROM r_peg_diklat a
							JOIN r_pegawai b ON a.id_pegawai=b.id_pegawai
							WHERE  (`nama_pegawai`  LIKE '%$cari%'
							OR  `nip_baru`  LIKE '%$cari%'
							OR  `nama_diklat`  LIKE '%$cari%'
							OR  `tempat_diklat`  LIKE '%$cari%') $iTanggal ";
			$query = $this->db->query($sqlstr)->row(); 
			return $query->numrows;
		}
	
}
