<html>
<head>
	<title>Dokumen View</title>
</head>
<body>
<br>
<?php
foreach($dokumen AS $key=>$val){
?>

<img src="<?=base_url();?>assets/media/file/<?=$nip_baru;?>/<?=$komponen;?>/<?=$val->file_dokumen;?>"><br>

<?php
}
?>
</body>
</html>