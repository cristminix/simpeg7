<?php
class M_direktori extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
	function detail_kategori($idd){
		$hslquery = $this->db->get_where('p_setting_item', array('id_item' => $idd));
		return $hslquery->result();
	}
	function atribut_kategori($idd){
		$sqlstr="SELECT a.id_atribut,a.nama_atribut,a.urutan FROM direktori_atribut a 
		WHERE a.id_kategori='$idd' ORDER BY a.urutan ASC";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
    function reurut_atribut_aksi($isi){
				$sqlstr="UPDATE direktori_atribut SET	 urutan='99' WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan_ini']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE direktori_atribut SET	 urutan='".$isi['urutan_ini']."' WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan_lawan']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE direktori_atribut SET	 urutan='".$isi['urutan_lawan']."'	 WHERE id_kategori='".$isi['idd']."' AND urutan='99'";
				$this->db->query($sqlstr);
	}

    function save_kategori_aksi($isi){
		if($isi['idd']==""){
			$query=$this->db->query("SELECT MAX(urutan) as count_nik, MAX(id_kategori) as count_nik2 FROM p_kanal_kategori"); 
			$row = $query->row_array();		$max = $row['count_nik']+1;$max2 = $row['count_nik2']+1;
	
		
			$sqlstr="INSERT INTO p_kanal_kategori (nama_kategori,keterangan,urutan,id_kategori,status,komponen) VALUES ('".$isi['nama_kategori']."','".$isi['keterangan']."','$max','$max2','pending','direktori')";
			$this->db->query($sqlstr);
			$isi['idd']=$max2;
		} else {
			$sqlstr="UPDATE p_kanal_kategori SET
			 nama_kategori='".$isi['nama_kategori']."',keterangan='".$isi['keterangan']."'
			 WHERE id_kategori='".$isi['idd']."'";
			$this->db->query($sqlstr);
		}

		for($i=0;$i<count($isi['atribut']);$i++){
				$sqlstrC="SELECT id_atribut FROM direktori_atribut WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan'][$i]."'";
				$hslqueryC=$this->db->query($sqlstrC)->result();
				if(!empty($hslqueryC)){
					$sqlstr="UPDATE direktori_atribut SET
					 nama_atribut='".$isi['atribut'][$i]."'
					 WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan'][$i]."'";
					$this->db->query($sqlstr);
				} else {
					$sqlstr="INSERT INTO direktori_atribut (id_kategori,nama_atribut,urutan) VALUES ('".$isi['idd']."','".$isi['atribut'][$i]."','".$isi['urutan'][$i]."')";
					$this->db->query($sqlstr);
				}
		}
		$sqlstr="DELETE FROM direktori_atribut WHERE id_kategori='".$isi['idd']."' AND urutan>'".$i."'";
		$this->db->query($sqlstr);
	}
    function hapus_kategori_aksi($isi){
		$sqlstr="DELETE FROM p_kanal_kategori WHERE id_kategori='".$isi['idd']."'";
		$this->db->query($sqlstr);

		$sqlstr="DELETE FROM direktori_atribut WHERE id_kategori='".$isi['idd']."'";
		$this->db->query($sqlstr);
	}

    function hapus_atribut_aksi($isi){
		$sqlstr="DELETE FROM direktori_atribut WHERE id_kategori='".$isi['idd']."' AND urutan='".$isi['urutan']."'";
		$this->db->query($sqlstr);

		$sqlstr="SELECT * FROM direktori_atribut  WHERE id_kategori='".$isi['idd']."' ORDER BY urutan ASC";
		$hslquery=$this->db->query($sqlstr)->result();
		$ur=1;
		foreach ($hslquery as $key=>$val) {
				$sqlstr="UPDATE direktori_atribut SET urutan='$ur' WHERE id_atribut='".$hslquery[$key]->id_atribut."'";
				$this->db->query($sqlstr);
			$ur++;
		}
	}
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
	function hitung_direktori($path){
		$query=$this->db->query("SELECT count(id_konten) as count_nik FROM konten_judul WHERE komponen='direktori' AND id_kategori='$path'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getdirektori($mulai,$batas,$path){
		$sqlstr="SELECT * FROM konten_judul  WHERE komponen='direktori' ORDER BY urutan ASC  LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
    function tambah_direktori_aksi($isi){
			$this->db->select_max('urutan','count_nik');
			$this->db->where('id_kategori',$isi['id_kategori']);
			$row = $this->db->get('konten_judul')->result();
			$max = $row[0]->count_nik+1;

		$ini="[";
		foreach($isi['isi_atribut'] AS $key=>$val){
			$ini.=($key==0)?"{\"label\":\"".$isi['label'][$key]."\",\"nilai\":\"".$val."\"}":", {\"label\":\"".$isi['label'][$key]."\",\"nilai\":\"".$val."\"}";
		}
		$ini.="]";

		$sqlstr="INSERT INTO konten_judul (judul,id_kategori,komponen,isi_artikel,urutan) 
		VALUES ('".$isi['nama_direktori']."','".$isi['id_kategori']."','direktori','$ini','$max')";		
		$this->db->query($sqlstr);

	}
	function inidirektori($idd){
		$hslquery = $this->db->get_where('konten_judul', array('id_konten' => $idd));
		return $hslquery->result();
	}
	function iniatribut($idd,$itt){
		$sqlstr2="SELECT a.id_atribut,a.nama_atribut,a.urutan,b.isi_atribut FROM direktori_atribut a 
		LEFT JOIN (direktori_atribut_isi b) ON (a.id_atribut=b.id_atribut)
		WHERE a.id_kategori='$idd' AND b.id_item='$itt' ORDER BY a.urutan ASC";

		$sqlstr="SELECT a.id_atribut,a.nama_atribut,a.urutan,b.isi_atribut FROM direktori_atribut a 
		LEFT JOIN (direktori_atribut_isi b) ON (a.id_atribut=b.id_atribut AND b.id_item='$itt')
		WHERE a.id_kategori='$idd' ORDER BY a.urutan ASC";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
    function edit_direktori_aksi($isi){
		$ini="[";
		foreach($isi['isi_atribut'] AS $key=>$val){
			$ini.=($key==0)?"{\"label\":\"".$isi['label'][$key]."\",\"nilai\":\"".$val."\"}":", {\"label\":\"".$isi['label'][$key]."\",\"nilai\":\"".$val."\"}";
		}
		$ini.="]";
		$sqlstr="UPDATE konten_judul SET judul='".$isi['nama_direktori']."', isi_artikel='$ini' WHERE id_konten='".$isi['id_konten']."'";
		$this->db->query($sqlstr);
	}
    function hapus_direktori_aksi($isi){
		$sqlstr="DELETE FROM konten_judul WHERE id_kategori='".$isi['id_kategori']."' AND id_item='".$isi['id_item']."'";
		$this->db->query($sqlstr);

		$sqlstr="DELETE FROM direktori_atribut_isi WHERE id_kategori='".$isi['id_kategori']."' AND id_item='".$isi['id_item']."'";
		$this->db->query($sqlstr);
	}


}
