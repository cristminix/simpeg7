<?php 
function sikda_goltopangkat($gol='')
{
	$arr = array(
		'11'=>'I a*Juru Muda',
		'12'=>'I b*Juru Muda Tk.I',
		'13'=>'I c*Juru',
		'14'=>'I d*Juru Tk.I',

		'21'=>'II a*Pengatur Muda',
		'22'=>'II b*Pengatur Muda Tk.I',
		'23'=>'II c*Pengatur',
		'24'=>'II d*Pengatur Tk.I',

		'31'=>'III a*Penata Muda',
		'32'=>'III b*Penata Muda Tk.I',
		'33'=>'III c*Penata',
		'34'=>'III d*Penata Tk.I',

		'41'=>'IV a*Pembina',
		'42'=>'IV b*Pembina Tk.I',
		'43'=>'IV c*Pembina Utama Muda',
		'44'=>'IV d*Pembina Utama Madya',
		'45'=>'IV e*Pembina Utama',
	);
	if(isset($arr[$gol])){
		return $arr[$gol];
	}else{
		return '*';
	}
}
function sikda_gender($gender='')
{
	$arr = array(
		''=>'-',
		'l'=>'Laki-laki',
		'p'=>'Perempuan',
	);
	if(isset($arr[$gender])){
		return $arr[$gender];
	}else{
		return '-';
	}
}
function sikda_gender_dropdown()
{
	return array(
		''=>'Silahkan Pilih',
		'l'=>'Laki-laki',
		'p'=>'Perempuan',
	);
}
function sikda_skpdnamapath_read($skpd_nama_path = '',$glue='<br/>- ')
{
	$path = explode('*',$skpd_nama_path);
	if(count($path) == 0){
		return $skpd_nama_path;
	}
	$last = count($path) - 1;
	if($path[$last] == ""){
		unset($path[$last]);
	}
	return implode($glue,$path);
}

