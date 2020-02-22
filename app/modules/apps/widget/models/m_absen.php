<?php 
class M_Absen extends CI_Model{
	
	public $ttlRows 	= 0;
	private $tblTrans 	= "chekinout";
	private $tblSumm	= "attsummfix";
	private $tblEmp		= "rekap_peg";
	private $tblCal		= "calendar";
	private $late 		= '07:30:10';
	
	function getAttendanceAll($params){
		$sql 	= "";
		$limit 	= "";
		$this->ttlrRows = $this->db->query($sql)->num_rows;
		return $this->db->query($sql.$limit);
	}
	
	
	function getSumAttendance($params){
		$sql = "";
		switch ($params["case"]){
			case "present":
				$sql = " SELECT b.id_pegawai FROM ".$this->tblSumm." a RIGHT JOIN ".$this->tblEmp." b ON SUBSTRING(b.nip_baru,-4) = a.EmpID WHERE DATE(a.Day) = CURDATE() AND a.TimeIn IS NOT NULL AND a.TimeOut IS NOT NULL";
			break;
			case "notpresent":
				$sql = " SELECT b.id_pegawai FROM ".$this->tblSumm." a RIGHT JOIN ".$this->tblEmp." b ON SUBSTRING(b.nip_baru,-4) = a.EmpID WHERE DATE(a.Day) = CURDATE() AND a.TimeIn IS NULL AND a.TimeOut IS NULL";
			break;
			case "late":
				$sql = " SELECT b.id_pegawai FROM ".$this->tblSumm." a RIGHT JOIN ".$this->tblEmp." b ON SUBSTRING(b.nip_baru,-4) = a.EmpID WHERE DATE(a.Day) = CURDATE() AND a.TimeIn IS NOT NULL AND Status='telat'";
				//$sql = " AND a.TimeIn IS NOT NULL AND TIME_TO_SEC(a.TimeIn) > '".strtotime("1970-01-01 ".$this->late." UTC")."' ";
			break;
			case "all":
				$sql = "SELECT id_pegawai FROM rekap_peg";
			break;
		}
		
		return $this->db->query($sql);
	}
	
	function getAttendanceFiltered($params){
		$where = "WHERE c.calendar_date BETWEEN '".$params['str']."' AND '".$params['end']."' ";
		$order = " ORDER by a.Day ASC";
		switch ($params["case"]){
			case "present":
				$where .= " AND a.TimeIn IS NOT NULL AND a.TimeOut IS NOT NULL";
			break;
			case "notpresent":
				//$where .= " AND a.TimeIn IS NULL AND a.TimeOut IS NULL";
			break;
			case "late":
				$where .= " AND a.TimeIn IS NOT NULL AND Status='telat' ";
			break;
			case "all":
				$where .= "";
			break;
			
		}
		
		if($params['key'] && $params['key']!=""){
			$where .= " AND (b.nip_baru like '%".$params['key']."%' OR b.nama_pegawai like '%".$params['key']."%' OR b.nama_unor like'%".$params['key']."%')";
		}
		
		if($params["case"]!="notpresent"){
			$sql 	= "SELECT b.nip_baru,b.nama_pegawai,b.nama_unor,DATE_FORMAT(a.Day,'%d-%m-%Y') AS tgl,TIME(a.TimeIn) AS timein,TIME(a.TimeOut) AS timeout
					   FROM ".$this->tblSumm." a 
					   RIGHT JOIN ".$this->tblEmp." b ON SUBSTRING(b.nip_baru,-4) = a.EmpID 
					   RIGHT JOIN ".$this->tblCal." c ON a.Day = c.calendar_date ";
			$limit 	= " LIMIT ".$params['limit']." OFFSET ".$params['start']."";
			$this->ttlRows = $this->db->query($sql.$where)->num_rows;
			return $this->db->query($sql.$where.$order.$limit);
		}else{
			$sql	= "SELECT * FROM(
						select a.nip_baru,a.nama_pegawai,a.nama_unor,c.calendar_date as tgl
						FROM rekap_peg a CROSS JOIN calendar c
							$where
					 ) A
					 LEFT JOIN(SELECT a.EmpID,a.Day,TIME(a.TimeIn) AS timein,TIME(a.TimeOut) AS timeout FROM attsummfix a) B 
					 ON B.EmpID = SUBSTRING(A.nip_baru,-4) AND B.Day = A.tgl
					 WHERE B.timein IS NULL AND B.timeout IS NULL
					";
			$this->ttlRows = $this->db->query($sql)->num_rows;
			$limit 	= " LIMIT ".$params['limit']." OFFSET ".$params['start']."";
			return $this->db->query($sql.$limit);
		}
				   
		
	}
}