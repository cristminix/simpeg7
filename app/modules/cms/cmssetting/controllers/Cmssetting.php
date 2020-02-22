<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Cmssetting extends MX_Controller {

	function __construct(){
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('m_setting');
	}


	function index(){
		$data['setting']	= "Menu";
		$data['batas']	= 10;
		$this->load->view('index',$data);
	}

	function getsetting(){
		$dt = $this->hitungmain(); 
		if($dt==0){
			$data['hslquery']="";
			$data['pager'] = "";
		} else { 
			$batas=$_POST['batas'];
			if($_POST['hal']=="end"){	$hal=ceil($dt/$batas);		} else {	$hal=$_POST['hal'];	}
			$mulai=($hal-1)*$batas;
			$data['mulai']=$mulai+1;
			$data['isi'] = $this->getmain($mulai,$batas);
			$data['pager'] = Modules::run("cmshome/pagerB",$dt,$batas,$hal);
		}
			echo json_encode($data);
	}

	function hitungmain(){
		$dt = $this->mainitem(); 
		$cdt = count($dt);
		return $cdt;
	}

	function getmain($mulai,$batas){
		$dt = $this->mainitem();
		return $dt;
	}

	function mainitem(){
		$setting = @array(	array(	id_setting=>"1",
									nama_setting=>"Kanal",
									meta_key=>"Keterangan::Path Kanal::Status::Tipe Kanal::",
									keterangan=>"Kanal adalah navigasi utama halaman website (publik)",
									status=>"publish"),
							array(	id_setting=>"2",
									nama_setting=>"Menu",
									meta_key=>"Path Menu::Icon Menu::Keterangan::",
									keterangan=>"Menu adalah navigasi utama halaman backoffice",
									status=>"publish")
		);
		return $setting;
	}

/*
CREATE TABLE IF NOT EXISTS `p_setting` (
  `id_setting` int(11) NOT NULL AUTO_INCREMENT,
  `nama_setting` varchar(100) NOT NULL,
  `meta_key` text NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `status` enum('pending','publish') DEFAULT NULL,
  PRIMARY KEY (`id_setting`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `p_setting`
--

INSERT INTO `p_setting` (`id_setting`, `nama_setting`, `meta_key`, `keterangan`, `status`) VALUES
(1, 'Kanal', 'Keterangan::Path Kanal::Status::Tipe Kanal::', 'Kanal adalah navigasi utama halaman website (publik)', 'publish'),
(2, 'Menu', 'Path Menu::Icon Menu::Keterangan::', 'Menu adalah navigasi utama halaman backoffice', 'publish'),
(3, 'Menu Pengguna', 'Group ID::ID Menu::', '-', 'publish'),
(4, 'Grup Pengguna', 'Group ID::Group Name::Section Name::Back Office', '-', 'publish'),
(5, 'Identitas Aplikasi', 'Nama Aplikasi::Slogan Aplikasi::', '', 'publish'),
(6, 'Kanal Rubrik', 'Komponen::Keterangan::Status::', 'Mendefinisikan rubrik-rubrik apa saja yang terdapat dalam masing-masing kanal', 'publish'),
(7, 'Master Komponen', '', 'Daftar Komponen (tipe konten) yang didukung oleh CMS ini', 'publish'),
(8, 'Master Widget', 'Lokasi Widget::Keterangan::Komponen::', 'ex. tabel m_widget, berisi daftar widget yang siap dipakai', 'publish'),
(9, 'Widget Wrapper', 'Nama Wrapper::Keterangan::', 'Dafar Wrapper yang siap dipasang ke kanal', 'publish'),
(10, 'Kanal Wrapper', '', 'Daftar Wrapper yang terpasang di masing-masing kanal untuk tiap posisi', 'publish'),
(11, 'Penulis Konten', 'Daftar Penulis yang berhak menulis konten', '', 'publish'),
(12, 'Kanal Template', 'Template Path::Keterangan::Status::', 'Daftar Template yang siap dipakai untuk kanal', 'publish'),
(13, 'Opsi Kanal', 'Kanal Header::', '', 'publish'),
(14, 'Hak Kelola Pengguna (user previlege)', 'ID Menu::', '', 'publish');
*/
}
?>