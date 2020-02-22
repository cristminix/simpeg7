<?php
class M_kanal extends CI_Model{
	function __construct(){
		parent::__construct();
	}

//////////////////////////////////////////////////////////////////////////////////
// FUNGSI UTAMA: Detail Item
//////////////////////////////////////////////////////////////////////////////////
	function ini_item($nid){
		$hslquery = $this->db->get_where('p_setting_item', array('id_item' => $nid));
		return $hslquery->result();
	}

	function ini_komponen_by_nama($nm){
		$hslquery = $this->db->get_where('p_setting_item', array('id_setting' => '7', 'nama_item'=> $nm));
		return $hslquery->result();
	}
//////////////////////////////////////////////////////////////////////////////////
	function getkanal($idparent){
		$this->db->select('id_item AS id_kanal, nama_item AS nama_kanal, id_parent,urutan,meta_value');
		$this->db->from('p_setting_item');
		$this->db->where('id_setting','1');
		$this->db->where('id_parent',$idparent);
		$this->db->order_by('urutan','ASC');
		$query = $this->db->get()->result();
		return $query;
	}

    function cek_kanal_header($path_kanal){
		$this->db->select('id_item ,meta_value');
		$this->db->from('p_setting_item');
		$this->db->where('id_setting','13');
		$this->db->where('nama_item','header');
		$this->db->like('meta_value','\"path_kanal\":\"'.$path_kanal.'\"');
		$query = $this->db->get()->result();
		return $query;
	}
    function cek_kanal_rubrik($id_kanal){
		$this->db->select('nama_item');
		$this->db->from('p_setting_item');
		$this->db->where('id_setting','6');
		$this->db->like('meta_value','\"id_kanal\":\"'.$id_kanal.'\"');
		$query = $this->db->get()->result();
		return $query;
	}
    function cek_kanal_wrapper($id_kanal){
		$this->db->select('meta_value');
		$this->db->from('p_setting_item');
		$this->db->where('id_setting','10');
		$this->db->like('meta_value','\"id_kanal\":\"'.$id_kanal.'\"');
		$query = $this->db->get()->result();
		return $query;
	}

    function tambah_aksi($ipp){
			$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM p_setting_item WHERE id_setting='1' AND id_parent='".$ipp['idparent']."'"); 
			$row = $query->row_array();		$max = $row['count_nik']+1;
			if($ipp['idparent']==0){
				$path_root=$ipp['kanal_path'];
			} else {
				$root=explode("_",$ipp['root']);
				$croot = $this->ini_item($root[0]);
				$jj = json_decode($croot[0]->meta_value);
				$path_root=$jj->path_kanal;
			}
			$ini="{\"path_kanal\":\"".$ipp['kanal_path']."\",\"path_root\":\"".$path_root."\",\"status\":\"on\",\"keterangan\":\"".$ipp['keterangan']."\",\"tipe\":\"".$ipp['tipe']."\",\"theme\":\"".$ipp['theme']."\"}";

			$sqlstr="INSERT INTO p_setting_item (id_setting,id_parent,nama_item,urutan,meta_value) 
			VALUES ('1','".$ipp['idparent']."','".$ipp['nama_kanal']."','$max','$ini')";
			$this->db->query($sqlstr);
	}

    function edit_aksi($ipp){
			if($ipp['level']==0){
				$path_root=$ipp['kanal_path'];
			} else {
				$root=explode("_",$ipp['root']);
				$croot = $this->ini_item($root[0]);
				$jj = json_decode($croot[0]->meta_value);
				$path_root=$jj->path_kanal;
			}
			$ini="{\"path_kanal\":\"".$ipp['kanal_path']."\",\"path_root\":\"".$path_root."\",\"status\":\"on\",\"keterangan\":\"".$ipp['keterangan']."\",\"tipe\":\"".$ipp['tipe']."\",\"theme\":\"".$ipp['theme']."\"}";
			$sqlstr="UPDATE p_setting_item SET nama_item='".$ipp['nama_kanal']."',meta_value='$ini' WHERE id_item='".$ipp['idd']."'";
			$this->db->query($sqlstr);

		$sqlstr1="SELECT id_item,meta_value FROM p_setting_item WHERE meta_value LIKE '%\"path_kanal\":\"".$ipp['path_lama']."\"%'";
		$hslquery1=$this->db->query($sqlstr1)->result();
		foreach($hslquery1 AS $key=>$val){
			$baru = str_replace($ipp['path_lama'], $ipp['kanal_path'],$val->meta_value);
			$sqlstr="UPDATE p_setting_item SET meta_value='$baru' WHERE id_item='".$val->id_item."'";
			$this->db->query($sqlstr);
		}

	}

    function tambah_header_aksi($ipp){
			$ini="{\"path_kanal\":\"".$ipp['path_kanal']."\",\"judul_header\":\"".$ipp['judul_header']."\",\"sub_judul\":\"".$ipp['sub_judul']."\",\"height\":\"".$ipp['height']."\",\"margin_top\":\"".$ipp['margin_top']."\",\"margin_bottom\":\"".$ipp['margin_bottom']."\",\"padding_top\":\"".$ipp['padding_top']."\",\"padding_bottom\":\"".$ipp['padding_bottom']."\"}";

			$sqlstr="INSERT INTO p_setting_item (id_setting,nama_item,meta_value) 
			VALUES ('13','header','$ini')";
			$this->db->query($sqlstr);
	}
    function edit_header_aksi($ipp){
			$ini="{\"path_kanal\":\"".$ipp['path_kanal']."\",\"judul_header\":\"".$ipp['judul_header']."\",\"sub_judul\":\"".$ipp['sub_judul']."\",\"height\":\"".$ipp['height']."\",\"margin_top\":\"".$ipp['margin_top']."\",\"margin_bottom\":\"".$ipp['margin_bottom']."\",\"padding_top\":\"".$ipp['padding_top']."\",\"padding_bottom\":\"".$ipp['padding_bottom']."\"}";

			$sqlstr="UPDATE p_setting_item SET meta_value='$ini' WHERE id_item='".$ipp['idh']."'";
			$this->db->query($sqlstr);
	}
//////////////////////////////////////////////////////////////////////////////////
    function naik_index($id_ini,$id_lawan,$urutan_ini,$urutan_lawan){
		$sqlstr="UPDATE p_setting_item SET urutan='$urutan_lawan' WHERE id_item='$id_ini'";
		$this->db->query($sqlstr);
		$sqlstr="UPDATE p_setting_item SET urutan='$urutan_ini' WHERE id_item='$id_lawan'";
		$this->db->query($sqlstr);
	}	
//////////////////////////////////////////////////////////////////////////////////
    function hitung_kanalrubrik($id_kanal){
		$query=$this->db->query("SELECT count(id_item) as count_nik FROM p_setting_item WHERE id_setting='6' AND meta_value LIKE '%\"id_kanal\":\"$id_kanal\"%'"); 
		$row = $query->row_array();
		$hslrow['count'] = $row['count_nik'];
		return $hslrow;
	}
    function getkanalrubrik($mulai,$batas,$id_kanal){
		$sqlstr="SELECT a.nama_item AS nama_kategori, a.id_item AS id_kategori,a.urutan,a.meta_value
		 FROM p_setting_item a 
		 WHERE a.id_setting='6'  AND a.meta_value LIKE '%\"id_kanal\":\"$id_kanal\"%'
		 ORDER BY a.urutan ASC LIMIT $mulai,$batas";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function cek_kategori($id_kategori){
		$sqlstr="SELECT COUNT(id_konten) AS j_konten FROM konten_judul WHERE id_kategori='$id_kategori'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

    function tambah_kategori_aksi($ipp){
			$query=$this->db->query("SELECT MAX(urutan) as count_nik FROM p_setting_item WHERE id_setting='6' AND meta_value LIKE '%\"id_kanal\":\"".$ipp['idd_kanal']."\"%'"); 
			$row = $query->row_array();		$max2 = $row['count_nik']+1;
			$ini="{\"id_kanal\":\"".$ipp['idd_kanal']."\",\"komponen\":\"".$ipp['komponen']."\",\"keterangan\":\"".$ipp['keterangan']."\",\"status\":\"publish\"}";

			$sqlstr="INSERT INTO p_setting_item (id_setting,nama_item,urutan,meta_value) VALUES ('6','".$ipp['nama_kategori']."','$max2','$ini')";		
			$this->db->query($sqlstr);
	}
    function edit_kategori_aksi($ipp){
			if(isset($ipp['label'])){
				$atr = ", \"atribut\":[";
				foreach($ipp['label'] AS $key=>$val){
					$atr.=($key==0)?"{\"label\":\"".$val."\"}":", {\"label\":\"".$val."\"}";
							$hslquery = $this->db->get_where('konten_judul', array('id_kategori' => $ipp['idd']))->result();
							foreach($hslquery AS $kk=>$vv){
								$baru=str_replace("\"label\":\"".$ipp['labellama'][$key]."\"","\"label\":\"".$val."\"",$vv->isi_artikel);
								$sqlstr="UPDATE konten_judul SET isi_artikel='$baru' WHERE id_konten='".$vv->id_konten."'";
								$this->db->query($sqlstr);
							}
				}
				$atr.="]";
			} else {
				$atr="";
			}
			$ini="{\"id_kanal\":\"".$ipp['idd_kanal']."\",\"komponen\":\"".$ipp['komponen']."\",\"keterangan\":\"".$ipp['keterangan']."\",\"status\":\"publish\"".$atr."}";
			$sqlstr="UPDATE p_setting_item SET nama_item='".$ipp['nama_kategori']."', meta_value='$ini'
			WHERE id_item='".$ipp['idd']."'";		
			$this->db->query($sqlstr);
	}
////////////////////////////////////////
//  WRAPPER
//////////////////////////////////////////////////////////////////////////////////
	function getkanalwrapper($path_kanal,$lokasi){
		$sqlstr="SELECT id_item,meta_value FROM p_setting_item WHERE id_setting='10' AND nama_item='".$lokasi."' AND meta_value LIKE '%\"path_kanal\":\"".$path_kanal."\"%'";
		$hslquery=$this->db->query($sqlstr)->result();
		return $hslquery;
	}

	function getwrapper_by_posisi($posisi){
		$sqlstr="SELECT a.id_item AS id_wrapper,a.nama_item AS nama_wrapper,a.meta_value FROM p_setting_item a WHERE a.id_setting='9'";
		$hslquery=$this->db->query($sqlstr)->result();
			$hasil=array();$nb=0;
			foreach($hslquery AS $key=>$val){
				$jj=json_decode($val->meta_value);
				
				$sqlstrb="SELECT a.id_item AS id_widget,a.nama_item AS nama_widget,a.meta_value FROM p_setting_item a WHERE a.id_item='".$jj->id_widget."'";
				$hslqueryb=$this->db->query($sqlstrb)->result();
				$jjj = json_decode($hslqueryb[0]->meta_value);
				if($jjj->lokasi_widget==$posisi){
					@$hasil[$nb]->nama_wrapper=$val->nama_wrapper;
					$hasil[$nb]->id_wrapper=$val->id_wrapper;
					$hasil[$nb]->keterangan=$jj->keterangan;
					$hasil[$nb]->nama_widget=$hslqueryb[0]->nama_widget;
					$hasil[$nb]->id_widget=$hslqueryb[0]->id_widget;
					$hasil[$nb]->komponen=$jjj->komponen;

				if(@$jj->id_kategori || @$jj->id_kategori!=""){
					$rbr=explode(",",@$jj->id_kategori);
					$rub="";
					for($i=0;$i<count($rbr);$i++){
						$sqlstrc="SELECT a.nama_item FROM p_setting_item a WHERE a.id_item='".$rbr[$i]."'";
						$hslqueryc=$this->db->query($sqlstrc)->result();
						$rub.=($i==0)?@$hslqueryc[0]->nama_item:", ".@$hslqueryc[0]->nama_item;
					}
					$hasil[$nb]->rubrik=$rub;
				} else {
					$hasil[$nb]->rubrik="";
				}

					$nb++;
				}
			}
		return $hasil;
	}

	function save_wrapper_aksi($ipp){
		$yu="";
		for($i=0;$i<count($ipp['widget_isi']);$i++){
			$rk=explode("**",$ipp['widget_isi'][$i]);
			$ren="{\"nama_widget\":\"".$rk[0]."\",\"id_widget\":\"".$rk[1]."\",\"id_wrapper\":\"".$rk[2]."\",\"opsi\":".$rk[3]."}";
			$yu.=($i==0)?$ren:",".$ren;
		}
		$ini="{\"id_kanal\":\"".$ipp['id_kanalx']."\",\"path_kanal\":\"".$ipp['path_kanalx']."\",\"widget\":[".$yu."]}";


		$sqlstr="SELECT id_item FROM p_setting_item  WHERE id_setting='10' AND nama_item='".$ipp['posisix']."' AND meta_value LIKE '%\"id_kanal\":\"".$ipp['id_kanalx']."\"%'";
		$data = $this->db->query($sqlstr)->result();

		if(empty($data)){
			$sqlstr="INSERT INTO p_setting_item (id_setting,nama_item,meta_value) VALUES ('10','".$ipp['posisix']."','$ini')";
		} else {
			$sqlstr="UPDATE p_setting_item SET nama_item='".$ipp['posisix']."',meta_value='$ini' WHERE id_setting='10' AND nama_item='".$ipp['posisix']."' AND meta_value LIKE '%\"id_kanal\":\"".$ipp['id_kanalx']."\"%'";		
		}
		$this->db->query($sqlstr);
	}
	function hapus_wrapper_aksi($ipp){
		$sqlstr="SELECT id_item,meta_value FROM p_setting_item  WHERE id_setting='10' AND nama_item='".$ipp['posisi']."' AND meta_value LIKE '%\"id_kanal\":\"".$ipp['kanal']."\"%'";
		$data = $this->db->query($sqlstr)->result();
		$jj=json_decode($data[0]->meta_value);
		
		if(count($jj->widget)==1){
			$sqlstr="DELETE FROM p_setting_item WHERE id_item='".$data[0]->id_item."'";		
		} else {
			$yu="";$no=0;
			foreach($jj->widget AS $key=>$val){
				if($val->id_wrapper!=$ipp['idd']){
					$yui=json_encode($val);
					$yu.=($no==0)?$yui:",".$yui;
					$no++;
				}
			}
			$ini="{\"id_kanal\":\"".$jj->id_kanal."\",\"path_kanal\":\"".$jj->path_kanal."\",\"widget\":[".$yu."]}";
			$sqlstr="UPDATE p_setting_item SET meta_value='$ini' WHERE id_item='".$data[0]->id_item."'";		
		}
		$this->db->query($sqlstr);
	}

	function edit_wrapper_aksi($ipp){
		$sqlstr="SELECT id_item,meta_value FROM p_setting_item  WHERE id_setting='10' AND nama_item='".$ipp['posisi']."' AND meta_value LIKE '%\"id_kanal\":\"".$ipp['id_kanal']."\"%'";
		$data = $this->db->query($sqlstr)->result();
		$jj=json_decode($data[0]->meta_value);
		
			$ini="{\"id_kanal\":\"".$jj->id_kanal."\",\"path_kanal\":\"".$jj->path_kanal."\",\"widget\":".$ipp['ini']."}";
			$sqlstr="UPDATE p_setting_item SET meta_value='$ini' WHERE id_item='".$data[0]->id_item."'";		
			$this->db->query($sqlstr);
	}
    function edit_setting_aksi($ipp){
			$ini="\"id_wrapper\":\"".$ipp['id_wrapper']."\",\"opsi\":[";
			for($i=0;$i<count($ipp['label']);$i++){
				$ini.=($i==0)?"{\"label\":\"".$ipp['label'][$i]."\",\"nama\":\"".$ipp['nama'][$i]."\",\"nilai\":\"".$ipp['nilai'][$i]."\"}":",{\"label\":\"".$ipp['label'][$i]."\",\"nama\":\"".$ipp['nama'][$i]."\",\"nilai\":\"".$ipp['nilai'][$i]."\"}";
			}
			$ini.="]";

		$sqlstr="SELECT meta_value FROM p_setting_item  WHERE id_item='".$ipp['id_item']."'";
		$data = $this->db->query($sqlstr)->result();
		$baru=str_replace($ipp['asli'], $ini, $data[0]->meta_value);
	
			$sqlstr="UPDATE p_setting_item SET meta_value='$baru' WHERE id_item='".$ipp['id_item']."'";
			$this->db->query($sqlstr);
	}


//////////////////////////////////////////////////////////////////////////////////
	function getkanalall($id_parent,$untuk='rubrik'){
		$sqlstr="SELECT a.id_item AS id_kanal,a.nama_item AS nama_kanal,a.id_parent AS id_parent,a.urutan AS urutan,a.meta_value
		FROM p_setting_item a 
		WHERE a.id_setting='1' AND a.id_parent='$id_parent'  ORDER BY a.urutan ASC";

		$data = $this->db->query($sqlstr)->result();
			$menu_sidebar = "";
			foreach($data as $row){
				$child = $this->getkanalall($row->id_kanal,$untuk);
				if(strlen($child)>0){
					if($untuk=="wrapper"){
						$menu_sidebar .= "<option value='".$row->id_kanal."'>".$row->nama_kanal."</option>";
					}
					$menu_sidebar .= $child;
				} else {
					$menu_sidebar .= "<option value='".$row->id_kanal."'>".$row->nama_kanal."</option>";
				}
			}
		return $menu_sidebar;
	}

	function gettheme_by_path($path){
		$sqlstr="SELECT * FROM p_setting_item WHERE id_setting='12' AND meta_value LIKE '%\"theme_path\":\"$path\"%' ";
		$data = $this->db->query($sqlstr)->result();
		return $data;
	}


}
