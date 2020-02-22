<?php
class M_artikel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function tambah_aksi($isi){
		$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM konten_judul WHERE komponen='".$isi['komponen']."'"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;
		$catatan=str_replace("/thumbs_","/",$isi['catatan']);
		$sqlstr="INSERT INTO konten_judul (komponen,id_kategori,judul,sub_judul,id_penulis,tanggal,isi_artikel,urutan)
		VALUES ('".$isi['komponen']."','".$isi['id_kategori']."','".$isi['judul']."','".$isi['sub_judul']."','".$isi['id_penulis']."','".$isi['tanggal']."','$catatan','$max')";		
		$this->db->query($sqlstr);
	}
    function edit_aksi($isi){
		$sqlstr="UPDATE konten_judul SET judul='".$isi['judul']."',sub_judul='".$isi['sub_judul']."',
		id_penulis='".$isi['id_penulis']."',id_kategori='".$isi['id_kategori']."',
		tanggal='".$isi['tanggal']."',isi_artikel='".$isi['catatan']."' WHERE id_konten='".$isi['id_konten']."'";
		$this->db->query($sqlstr);
	}
    function hapus_aksi($isi){
		$sqlstr="DELETE FROM konten_judul WHERE id_konten='".$isi['id_konten']."'";
		$this->db->query($sqlstr);

		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='".$isi['id_konten']."' AND tipe='foto'";
		$hslquery=$this->db->query($sqlstr)->result();
		foreach($hslquery as $key=>$val){
			$sqlstr="DELETE FROM konten_foto WHERE id_foto='".$val->id_foto."'";
			$this->db->query($sqlstr);
		}


		$sqlstr="DELETE FROM konten_slider WHERE id_konten='".$isi['id_konten']."'";
		$this->db->query($sqlstr);

		return $hslquery;
	}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
    function tambah_rubrik_aksi($nama,$ket,$komp){
		$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM p_kanal_kategori"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;

		$sqlstr="INSERT INTO p_kanal_kategori (nama_kategori,keterangan,komponen,status,urutan) 
		VALUES ('$nama','$ket','$komp','pending','$max')";		
		$this->db->query($sqlstr);
	}

    function edit_rubrik_aksi($idd,$idp,$ipp){
		$sqlstr="UPDATE p_kanal_kategori SET nama_kategori='$idp',keterangan='$ipp' WHERE id_kategori='$idd'";
		$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
    function hapus_rubrik_aksi($idd){
		$sqlstr="DELETE FROM p_kanal_kategori WHERE id_kategori='$idd'";
		$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
    function naik_index($id_ini,$id_lawan,$urutan_ini,$urutan_lawan){
		$sqlstr="UPDATE p_kanal_kategori SET urutan='$urutan_lawan' WHERE id_kategori='$id_ini'";
		$this->db->query($sqlstr);
		$sqlstr="UPDATE p_kanal_kategori SET urutan='$urutan_ini' WHERE id_kategori='$id_lawan'";
		$this->db->query($sqlstr);
	}	
//////////////////////////////////////////////////////////////////////////////////
	function simpan_foto($idd,$nama,$komponen){
		$query=$this->db->query("SELECT MAX(foto_urutan) as count_nik FROM konten_foto WHERE id_konten='$idd' AND komponen='$komponen'"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;

		$sqlstr="INSERT INTO konten_foto (id_konten,komponen,foto,foto_thumbs,foto_urutan) 
		VALUES ('$idd','$komponen','$nama','thumbs_".$nama."','$max')";		
		$this->db->query($sqlstr);
	}
    function reurut_foto_aksi($isi){
				$sqlstr="UPDATE konten_foto SET	 foto_urutan='99' WHERE id_konten='".$isi['idd']."' AND foto_urutan='".$isi['urutan_ini']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE konten_foto SET	 foto_urutan='".$isi['urutan_ini']."' WHERE id_konten='".$isi['idd']."' AND foto_urutan='".$isi['urutan_lawan']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE konten_foto SET	 foto_urutan='".$isi['urutan_lawan']."'	 WHERE id_konten='".$isi['idd']."' AND foto_urutan='99'";
				$this->db->query($sqlstr);
	}
    function hapus_foto_aksi($isi){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='".$isi['idd']."' AND foto_urutan='".$isi['urutan']."'"; 
		$hslquery=$this->db->query($sqlstr);

		$sqlstr="DELETE FROM konten_foto WHERE id_konten='".$isi['idd']."' AND foto_urutan='".$isi['urutan']."'";
		$this->db->query($sqlstr);

		$sqlstr="UPDATE konten_foto SET foto_urutan=(foto_urutan-1) WHERE id_konten='".$isi['idd']."' AND foto_urutan>'".$isi['urutan']."'";
		$this->db->query($sqlstr);

		return $hslquery;
	}
    function edit_info_aksi($isi){
		for($i=0;$i<count($isi['judul_foto']);$i++){
				$sqlstr="UPDATE konten_foto SET
				 judul_foto='".$isi['judul_foto'][$i]."',
				 ket_foto='".$isi['ket_foto'][$i]."',
				 fotografer='".$isi['fotografer'][$i]."',
				 foto_from='".$isi['foto_from'][$i]."'
				 WHERE id_konten='".$isi['idd']."' AND foto_urutan='".$isi['urutan'][$i]."'";
				$this->db->query($sqlstr);
		}
	}
/////////////////////////////////////////////////////////////////////////
	function slider_artikel($idd){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konten='$idd' AND tipe='artikel_slider'";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}
	function simpan_slider($idd,$nama){
		$sqlstr="INSERT INTO konten_slider (id_konten,file_slider,file_thumb) 
		VALUES ('$idd','$nama','thumbs_".$nama."')";		
		$this->db->query($sqlstr);
	}
    function hapus_slider_aksi($isi){
		$sqlstr="SELECT * FROM konten_slider WHERE id_konten='".$isi['idd']."'"; 
		$hslquery=$this->db->query($sqlstr);

		$sqlstr="DELETE FROM konten_slider WHERE id_konten='".$isi['idd']."'";
		$this->db->query($sqlstr);
		return $hslquery;
	}
/////////////////////////////////////////////////////////////////////////
    function tambah_penulis_aksi($isi){
		$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM konten_penulis"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;
		$sqlstr="INSERT INTO konten_penulis (nama_penulis,urutan)
		VALUES ('".$isi['nama_penulis']."','$max')";		
		$this->db->query($sqlstr);
	}
    function edit_penulis_aksi($isi){
		$sqlstr="UPDATE konten_penulis SET nama_penulis='".$isi['nama_penulis']."' WHERE id_penulis='".$isi['id_penulis']."'";		
		$this->db->query($sqlstr);
	}
/////////////////////////////////////////////////////////////////////////
	function hitung_komentar(){
		$query=$this->db->query("SELECT count(id_komentar) as count_nik FROM artikel_komentar"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
	function getkomentar($mulai,$batas){
		$sqlstr="SELECT * FROM artikel_komentar ORDER BY id_komentar ASC  LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr);
		return $hslquery;
	}

}
