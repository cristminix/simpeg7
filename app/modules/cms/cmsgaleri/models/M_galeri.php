<?php
class M_galeri extends CI_Model{
	function __construct(){
		parent::__construct();
	}
//////////////////////////////////////////////////////////////////////////////////
    function tambah_galeri_aksi($isi){
		$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM konten_judul WHERE id_kategori='".$isi['id_kategori']."' AND komponen='galeri'"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;

		$sqlstr="INSERT INTO konten_judul (judul,id_kategori,tanggal,isi_artikel,urutan,komponen) 
		VALUES ('".$isi['judul']."','".$isi['id_kategori']."','".$isi['tgl_buat']."','".$isi['keterangan']."','$max','galeri')";		
		$this->db->query($sqlstr);

		$sqlstr="SELECT id_konten FROM konten_judul WHERE id_kategori='".$isi['id_kategori']."' AND urutan='$max'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery[0];
	}
    function edit_galeri_aksi($isi){

		$sqlstr="UPDATE konten_judul SET judul='".$isi['judul']."',id_kategori='".$isi['id_kategori']."',isi_artikel='".$isi['keterangan']."',tanggal='".$isi['tgl_buat']."' WHERE id_konten='".$isi['idd']."'";
		$this->db->query($sqlstr);
	}
    function hapus_galeri_aksi($isi){
		$sqlstr="DELETE FROM konten_judul WHERE id_konten='$isi'";
		$this->db->query($sqlstr);
	}


    function simpan_foto($id_galeri,$nama_file){
		$query=$this->db->query("SELECT MAX(foto_urutan) as count_nik FROM konten_foto WHERE id_konten='$id_galeri' AND komponen='galeri'"); 
		$row = $query->row_array();		$max = $row['count_nik']+1;

		$sqlstr="INSERT INTO konten_foto (id_konten,foto,foto_thumbs,komponen,foto_urutan) 
		VALUES ('$id_galeri','$nama_file','thumbs_".$nama_file."','galeri','$max')";		
		$this->db->query($sqlstr);
	}

    function hapus_foto_aksi($isi){
		$sqlstr="SELECT * FROM konten_foto WHERE id_konteni='".$isi['idd']."' AND komponen='galeri' AND foto_urutan='".$isi['urutan']."'"; 
		$hslquery=$this->db->query($sqlstr);

		$sqlstr="DELETE FROM konten_foto WHERE id_konten='".$isi['idd']."' AND komponen='galeri' AND foto_urutan='".$isi['urutan']."'";
		$this->db->query($sqlstr);

		$sqlstr="UPDATE konten_foto SET foto_urutan=(foto_urutan-1) WHERE id_konten='".$isi['idd']."' AND komponen='galeri' AND foto_urutan>'".$isi['urutan']."'";
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
				 WHERE id_konten='".$isi['idd']."' AND komponen='galeri' AND foto_urutan='".$isi['urutan'][$i]."'";
				$this->db->query($sqlstr);
		}
	}
    function reurut_foto_aksi($isi){
				$sqlstr="UPDATE konten_foto SET	 foto_urutan='99' WHERE id_konten='".$isi['idd']."' AND komponen='galeri' AND foto_urutan='".$isi['urutan_ini']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE konten_foto SET	 foto_urutan='".$isi['urutan_ini']."' WHERE id_konten='".$isi['idd']."' AND komponen='galeri' AND foto_urutan='".$isi['urutan_lawan']."'";
				$this->db->query($sqlstr);

				$sqlstr="UPDATE konten_foto SET	 foto_urutan='".$isi['urutan_lawan']."'	 WHERE id_konten='".$isi['idd']."' AND komponen='galeri' AND foto_urutan='99'";
				$this->db->query($sqlstr);
	}

}
