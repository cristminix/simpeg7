<?php
class M_dashboard extends CI_Model{
	function __construct(){
		parent::__construct();
		date_default_timezone_set('UTC');
	}
//////////////////////////////////////////////////////////////////////////////////
	function hitung_pegawai($unor="all",$status_pegawai="all"){
			if($unor=="all"){	
				$iUnor = "";	
			} else{
				$iUnor = "WHERE kode_unor LIKE '$unor%'";	
			}
			
			if($status_pegawai=="all"){	
				$iStatus_pegawai = "";	
			} elseif($status_pegawai=="Kontrak"){
				$iStatus_pegawai = "AND status_pegawai='Kontrak'"; //tmt_pns='0000-00-00'";	
			} elseif($status_pegawai=="Capeg"){	
				$iStatus_pegawai = "AND status_pegawai='Capeg'"; //tmt_pns='0000-00-00'";	
			} else {
				$iStatus_pegawai = "AND status_pegawai='Tetap'"; //tmt_pns!='0000-00-00'";	
			}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iUnor
		$iStatus_pegawai
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function hitung_pegawai_unor($unor="all",$pns="all",$gender="all"){
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "WHERE id_unor IN ($unor)";	}
			if($pns=="all"){	$iPns = "";	} elseif($pns=="cpns"){	$iPns = "AND tmt_pns='0000-00-00'";	} else {	$iPns = "AND tmt_pns!='0000-00-00'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iUnor
		$iPns
		$iGender
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function hitung_pegawai_golongan($golongan="all",$gender="all",$unor="all"){
			if($golongan=="all"){	$iGolongan = "";	} else {	$iGolongan = "WHERE kode_golongan='$golongan'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iGolongan
		$iGender
		$iUnor
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function hitung_pegawai_pendidikan($pendidikan="all",$gender="all",$unor="all"){
			if($pendidikan=="all"){	$iPendidikan = "";	} else {	$iPendidikan = "WHERE nama_jenjang='$pendidikan'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iPendidikan
		$iGender
		$iUnor
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function hitung_pegawai_jabatan($jabatan="all",$gender="all",$unor="all"){
			if($jabatan=="all"){	$iJabatan = "";	} else {	$iJabatan = "WHERE jab_type='$jabatan'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iJabatan
		$iGender
		$iUnor
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	
	function hitung_pegawai_kawin($kawin="all",$gender="all",$unor="all"){
			if($kawin=="all"){	$iKawin = "";	} else {	$iKawin = "WHERE status_perkawinan='$kawin'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
			// if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iKawin
		$iGender
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}
	
	function hitung_pegawai_gender($gender="all",$unor="all"){
			// if($kawin=="all"){	$iKawin = "";	} else {	$iKawin = "WHERE status_perkawinan='$kawin'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "WHERE gender='$gender'";	}
			// if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iGender
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}



	function hitung_pegawai_agama($agama="all",$gender="all",$unor="all"){
			if($agama=="all"){	$iAgama = "";	} else {	$iAgama = "WHERE agama='$agama'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iAgama
		$iGender
		$iUnor
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}

	function hitung_pegawai_perkawinan($perkawinan="all",$gender="all",$unor="all"){
			if($perkawinan=="all"){	$iPerkawinan = "";	} else {	$iPerkawinan = "WHERE status_perkawinan='$perkawinan'";	}
			if($gender=="all"){	$iGender = "";	}  else {	$iGender = "AND gender='$gender'";	}
			if($unor=="all"){	$iUnor = "";	} else {	$iUnor = "AND id_unor IN ($unor)";	}
		$sqlstr="SELECT COUNT(a.id_pegawai) AS numrows
		FROM (rekap_peg a)
		$iPerkawinan
		$iGender
		$iUnor
		";
		$query = $this->db->query($sqlstr)->row(); 
		return $query->numrows;
	}



}
