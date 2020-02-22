<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header" style="padding-bottom:10px;margin-bottom:10px;">Dokumen Elektronik Pegawai</h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="content-wrapper" style="padding-bottom:30px;">


<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-primary" style="margin-bottom:5px;" id="panel_pegawai">
			<div class="panel-heading">
				<span class="fa fa-user fa-fw"></span>
				<span id=judul_box_pegawai><b>IDENTITAS PEGAWAI</b></span>
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:90px;">Nama</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;"><?=(trim($pegawai->gelar_depan) != '-')?trim($pegawai->gelar_depan).' ':'';?><?=(trim($pegawai->gelar_nonakademis) != '-')?trim($pegawai->gelar_nonakademis).' ':'';?><?=$pegawai->nama_pegawai;?><?=(trim($pegawai->gelar_belakang) != '-')?', '.trim($pegawai->gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">NIP</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="nip_baru"><?=$pegawai->nip_baru;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Pangkat/Gol.</div>
										<div style="float:left; width:5px;">:</div>
										<div style="float:left;" id="pegawai_pangkat"><?=$pegawai->nama_pangkat." / ".$pegawai->nama_golongan;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Jabatan</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="pegawai_jabatan"><?=$pegawai->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:90px;">Unit kerja</div>
										<div style="float:left; width:5px;">:</div>
										<span><div style="display:table;" id="pegawai_unor"><?=$pegawai->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
								<div class="col-lg-6">
									<div class="btn-group pull-right">
									<button class="btn btn-warning btn-sm" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-6-->
</div>
<!-- /.row -->

<div id="accordion" class="panel-group">
<?php
	$no=0;
	foreach($kode_dokumen AS $key=>$val){
		if($no>0){
			if($no==1){
				$clss="in"; 
				$sty="";
			} else {
				$clss="";
				$sty="height: 0px;";
			}
?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title"><a class="collapsed" href="#collapseOne<?=$key;?>" data-parent="#accordion" data-toggle="collapse" onclick="isi('<?=$key;?>');" id="tbtg_<?=$key;?>"><?=$no;?>. <?=$val;?></a></h4>
		</div>
		<div id="collapseOne<?=$key;?>" class="panel-collapse collapse <?=$clss;?>" style="<?=$sty;?>">
			<div class="panel-body"><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></div>
		</div>
	</div>
<?php
		}
	$no++;
	}
?>
</div>


<div class="row" style="display:none;" id="formedok">
	<div class="col-lg-12" id="col_form">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="komponen_temp" style="display:none;"></div>
<div id="idd_temp" style="display:none;"></div>
<div class="row" style="display:none;" id="uppldok">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading" id="head_dok">...</div>
			<div class="panel-body" id="col_dok"></div>
			<div class="panel-footer">
				<div id="stuploader" style="float:left; margin:5px 5px 0px 0px; font-weight:800"></div>
				<div id="uploader" class="btn btn-primary btn-xs" onClick="uppl('uploader','stuploader','nn');"><i class="fa fa-upload fa-sw"></i> Upload dokumen</div>
				<div class="btn btn-warning btn-xs" onClick="kembali2();"><i class="fa fa-fast-backward fa-sw"></i> Kembali</div>
			</div>
		</div>
		<!--panel-->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->
</div>


<form id="sb_act" method="post"></form>
<script language="JavaScript" type="text/javascript" src="<?=base_url();?>assets/js/ajaxupload.3.5.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	isi('pasfoto');
});

function uppl(bttn,stts,dokumen){	
		var komp = $('#komponen_temp').html();
		var idd = $('#idd_temp').html();
		var nip_baru = $('#nip_baru').html();

		var btnUpload=$('#'+bttn+'') , interval;
		var status=$('#'+stts+'');
		new AjaxUpload(btnUpload, {
			action: '<?=site_url();?>appdok/ijazah_pendidikan/saveupload',
			name: 'artikel_file',
			data: { "id_pegawai": nip_baru,"komponen":komp,"idd":idd    },
			onSubmit: function(file, ext){
				status.html('');
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 	status.text('Hanya File dengan ext JPG, PNG or GIF yang dapat diupload !');	return false;	}
				btnUpload.text('Uploading');
				interval = window.setInterval(function(){	var text = btnUpload.text();	if (text.length < 19){	btnUpload.text(text + '.');	} else {	btnUpload.text('Uploading');	}	}, 200);
			},
			onComplete: function(file, response){
				btnUpload.text("Upload dokumen");
				status.html('');
				window.clearInterval(interval);
				status.text('');
				 var arr_result = response.split("-");
				if(arr_result[0]==="success"){
					status.removeClass('notification-error');
					file = file.replace(/%20/g, "");
					insUpload(komp,idd);					
				} else{
					status.html(file  + ", gagal di upload ! <br />" + arr_result[1] );					
				}
			}
		});
}

function insUpload(komponen,idd){
	viewUppl(komponen,idd);
}

function hapus_dok(tipe,idd,no){
	$('#dok_'+tipe).hide();
	$('#konfirm_hapus_'+tipe).show();
	var preview = $('#view_'+tipe+'_'+idd).attr("src");
	$('#head_preview_'+tipe).html('<div class="btn btn-info" id="head_no_'+tipe+'" data-id_dokumen="'+idd+'">'+no+'</div>');
	$('#preview_'+tipe).html('<div class="thumbnail"><img src="'+preview+'"></div>');
}

function ok_hapus(tipe,idd){
	var nip_baru = $('#nip_baru').html();
	var noId = $('#head_no_'+tipe).html();
	var id_dokumen = $('#head_no_'+tipe).attr("data-id_dokumen");
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appdok/ijazah_pendidikan/hapus_dok",
				data:{"noId":noId,"komponen":tipe,"idd":idd,"id_pegawai": nip_baru,"id_dokumen":id_dokumen},
				beforeSend:function(){	
					$('#tb_hapus_'+tipe).hide();
					$('#tunggu_hapus_'+tipe).show();
				},
				success:function(data){
					viewUppl(tipe,idd);
				}, // end success
			dataType:"html"}); // end ajax
}

function batal_hapus(tipe){
	$('#dok_'+tipe).show();
	$('#konfirm_hapus_'+tipe).hide();
}


function isi(dok){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appdok/edok/"+dok,
				data:{"id_pegawai":"<?=$pegawai->id_pegawai;?>"},
				beforeSend:function(){	
					$('#collapseOne'+dok).html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
				},
				success:function(data){
					$('#tbtg_'+dok).attr("onclick","refresh_dok('"+dok+"');");
					$('#collapseOne'+dok).html(data);
					$('#komponen_temp').html(dok);
				}, // end success
			dataType:"html"}); // end ajax
}
function refresh_dok(dok){
	$('#komponen_temp').html(dok);
}

function viewForm(komponen,tuju,idd){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appdok/"+komponen+"/"+tuju,
				data:{"id_pegawai":"<?=$pegawai->id_pegawai;?>","idd":idd},
				beforeSend:function(){	
					$('#accordion').hide();
					$('#formedok').show();
					$('#col_form').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
				},
				success:function(data){
					$('#col_form').html(data);
				}, // end success
			dataType:"html"}); // end ajax
}

function viewUppl(komponen,idd){
	var nip_baru = $('#nip_baru').html();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appdok/"+komponen+"/uploadDok",
				data:{"id_pegawai":nip_baru,"idd":idd,"komponen":komponen},
				beforeSend:function(){	
					$('#accordion').hide();
					$('#uppldok').show();
					$('#col_dok').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
				},
				success:function(data){
					$('#col_dok').html(data);
					$('#idd_temp').html(idd);
					uppl("uploader","stuploader",idd);
				}, // end success
			dataType:"html"}); // end ajax
}

function kembali(){
	$('#accordion').show();
	$('#formedok').hide();
}
function kembali2(){
	var komp = $('#komponen_temp').html();
	$('#accordion').show();
	$('#uppldok').hide();
	isi(komp);
}

function simpan(){
	var komp = $('#komponen_temp').html();
			$.ajax({
				type:"POST",
				url:$('#form_'+komp).attr('action'),
				data:$('#form_'+komp).serialize(),
				beforeSend:function(){	
					$('#accordion').show();
					$('#formedok').hide();
				},
				success:function(data){
					isi(komp);
				}, // end success
			dataType:"html"}); // end ajax
}

function simpan2(){
// khusus setelah update biodata, reload ulang halaman
	var komp = $('#komponen_temp').html();
			$.ajax({
				type:"POST",
				url:$('#form_'+komp).attr('action'),
				data:$('#form_'+komp).serialize(),
				beforeSend:function(){	
					$('#accordion').show();
					$('#formedok').hide();
				},
				success:function(data){
					$('#sb_act').attr('action','<?=site_url();?>admin/module/appdok/edok').removeAttr('target');
					var tab = '<input type="hidden" name="cari" value="<?=$cari;?>">';
					var tab = tab + '<input type="hidden" name="idd" value="<?=$idd;?>">';	
					var tab = tab + '<input type="hidden" name="batas" value="<?=$batas;?>">';	
					var tab = tab + '<input type="hidden" name="hal" value="<?=$hal;?>">';	
					$('#sb_act').html(tab).submit();
				}, // end success
			dataType:"html"}); // end ajax
}

function satuket(idd){
	var keterangan = $('#ket_dok_'+idd).val();
	var sub_keterangan = $('#sub_ket_dok_'+idd).val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appdok/ijazah_pendidikan/edit_keterangan_aksi",
				data:{"keterangan":keterangan,"sub_keterangan":sub_keterangan,"idd":idd},
				beforeSend:function(){	
					$('#ket_dok_'+idd).attr("disabled","");
					$('#sub_ket_dok_'+idd).attr("disabled","");
				},
				success:function(data){	
					$('#ket_dok_'+idd).removeAttr("disabled").val(data.keterangan);
					$('#sub_ket_dok_'+idd).removeAttr("disabled").val(data.sub_keterangan);
				}, // end success
			dataType:"json"}); // end ajax
}

function batal(){
	$('#sb_act').attr('action','<?=site_url();?>admin/module/appbkpp/pegawai/aktif').removeAttr('target');
	var tab = '<input type="hidden" name="cari" value="<?=$cari;?>">';
	var tab = tab + '<input type="hidden" name="batas" value="<?=$batas;?>">';	
	var tab = tab + '<input type="hidden" name="hal" value="<?=$hal;?>">';	
	$('#sb_act').html(tab).submit();
}
function zoom_dok(komponen,idd){
	var nip_baru = $('#nip_baru').html();
	$('#sb_act').attr('action','<?=site_url();?>appdok/zoom').attr('target','_blank');
	var tab = '<input type="hidden" name="komponen" value="'+komponen+'">';
	var tab = tab + '<input type="hidden" name="idd" value="'+idd+'">';	
	var tab = tab + '<input type="hidden" name="nip_baru" value="'+nip_baru+'">';	
	$('#sb_act').html(tab).submit();
}
</script>
<style>
	.thumbnail {	position:relative;	overflow:hidden;	}
	.caption {    position:absolute;    top:0;    right:0;    background:rgba(66, 139, 202, 0.75);    width:100%;    height:100%;    padding:2%;    display: none;    text-align:center;    color:#fff !important;	z-index:2;	}
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}

.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>
