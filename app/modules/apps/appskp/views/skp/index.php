<script type="text/javascript">
function tutupForm(){
	$('#pageForm').hide();
	$('#pageKonten').show();
}
function ajukan(){
		$.ajax({
        type:"POST",
		url:	$("#pageFormTo").attr('action'),
		data:$("#pageFormTo").serialize(),
		beforeSend:function(){	
			$('#btAct').hide();
			$('#isiForm').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p>');
		},
        success:function(data){
			location.href = '<?=site_url();?>'+'admin/module/appskp/skp';
		},
        dataType:"json"});
	return false;
}

function setForm(tujuan,idd,no){
	var kop = []; 
	kop['baru'] = "FORM SKP BARU"; 
	kop['form_skp'] = "FORM EDIT SKP"; 
	kop['form_skp_hapus'] = "FORM PENGHAPUSAN SKP"; 
	kop['form_skp_ajupenilai'] = "FORM PENGAJUAN SKP KEPADA PEJABAT PENILAI"; 
	kop['arsip'] = "DAFTAR ARSIP SKP"; 
	var act = []; 
	act['baru'] = "<?=site_url();?>appskp/skp/form_aksi_skp"; 
	act['form_skp'] = "<?=site_url();?>appskp/skp/form_aksi_skp"; 
	act['form_skp_hapus'] = "<?=site_url();?>appskp/skp/hapus_skp"; 
	act['form_skp_ajupenilai'] = "<?=site_url();?>appskp/skp/aju_penilai"; 
	act['arsip'] = ""; 
	var btt = []; 
	btt['baru'] = "<button id='btAct' type=sumbit class='btn btn-primary' onclick='ajukan(); return false;'><i class='fa fa-save fa-fw'></i> Simpan</button>"; 
	btt['form_skp'] = "<button id='btAct' type=sumbit class='btn btn-primary' onclick='ajukan(); return false;'><i class='fa fa-save fa-fw'></i> Simpan</button>"; 
	btt['form_skp_hapus'] = "<button id='btAct' type=sumbit class='btn btn-primary' onclick='ajukan(); return false;'><i class='fa fa-trash fa-fw'></i> Hapus</button>"; 
	btt['form_skp_ajupenilai'] = "<button id='btAct' type=sumbit class='btn btn-primary' onclick='ajukan(); return false;'><i class='fa fa-upload fa-fw'></i> Ajukan</button>"; 
	btt['arsip'] = "<div id='btAct'></div>"; 

			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/skp/"+tujuan,
			data:{"idd": idd },
			beforeSend:function(){	
				$("#pageKonten").hide();
				$('#kopForm').html(kop[tujuan]);
				$('#btAct').replaceWith('<div id="btAct"></div>');
				$('#pageFormTo').attr('action',act[tujuan]);
				$("#isiForm").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
				$("#pageForm").show();
			},
			success:function(data){
				$('#btAct').replaceWith(btt[tujuan]);
				$('#isiForm').html(data);
			},
			dataType:"html"});
}
</script>
<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row" id="pageForm" style="display:none;">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<span id="kopForm"></span>
				<button class="btn btn-info btn-xs pull-right" onclick="tutupForm();"><i class="fa fa-close fa-fw"></i></button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body" style="padding-top:15px; padding-bottom:5px; padding-right:5px; padding-left:5px;">
			<form id="pageFormTo" method="post" action="" enctype="multipart/form-data">
				<div id="isiForm"></div>
				<div id="tbForm" style="text-align:right;">
					<button id="btAct"></button>
					<button type=button class="btn btn-default" onClick='tutupForm();'><i class="fa fa-fast-backward fa-fw"></i> Batal...</button>
				</div>
			</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel-default -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.pageForm -->
<div id="pageKonten">
<?php
if($id_skp!="xx"){
?>
<!-- /.row -->
<div class="row target">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
	<div style="float:left;">
		<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-tasks fa-fw"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuT">
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('form_skp','<?=$id_skp;?>','1');"><i class="fa fa-edit fa-fw"></i>Edit SKP</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('form_skp_hapus','<?=$id_skp;?>','1');"><i class="fa fa-trash fa-fw"></i>Hapus SKP</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('form_skp_ajupenilai','<?=$id_skp;?>','1');"><i class="fa fa-upload fa-fw"></i>Ajukan kepada Pejabat Penilai</a></li>
				<li role="presentation"><a href="<?=site_url('appskp/xls_skp');?>" role="menuitem" tabindex="-1" style="cursor:pointer;" target="_blank"><i class="fa fa-print fa-fw"></i>Cetak SKP</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('baru','xx','1');"><i class="fa fa-star fa-fw"></i>Buat SKP Baru</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('arsip','1','1');"><i class="fa fa-binoculars fa-fw"></i>Lihat Arsip SKP</a></li>
			</ul>
		</div>
	</div>
			<span style="margin-left:5px;" id=judul_skp><b>SKP TAHUN <?=$skp->tahun;?></b></span>
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div class="row">
									<div class="col-lg-12">
										<div style="float:left; width:95px;">Periode</div>
										<div style="float:left; width:10px;"> : </div>
										<span><div style="display:table;">
											<?php
												$bulan = $this->dropdowns->bulan();
												echo $bulan[$skp->bulan_mulai]." s.d. ".$bulan[$skp->bulan_selesai];
											?>
										</div></span>
									</div>
								</div>
								<div class="row" id=status_skp>
									<div class="col-lg-12">
										<div style="float:left; width:95px;">Tahapan</div>
										<div style="float:left; width:10px;"> : </div>
										<span onClick="bsmShow('track','1','1','r');" id='trackbutton'>
											<div class="btn-warning btn-xs" style="display:table;">
												<div style="float:left; width:25px; text-align:right; padding-right:5px;" id="tahapan_skp_nomor"><?=$tahapan_skp_nomor[$skp->status];?>.</div>
												<span><div style="display:table;"><?=$tahapan_skp[$skp->status];?> <i class="fa fa-caret-down fa-fw"></i></div></span>
											</div>
										</span>
									</div>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row target">
	<div class="col-lg-6">
		<div class="panel panel-default" id="panel_penilai">
			<div class="panel-heading">
				<span class="fa fa-user fa-fw"></span>
				<span id=judul_box_penilai><b>PEJABAT PENILAI</b></span>
				<a href="<?php echo site_url('admin/module/appskp/skp_formpegawai/penilai'); ?>" class="btn btn-primary btn-xs pull-right" title="Edit Data Pejabat Penilai"><i class="fa fa-edit"></i></a>
			</div>
			
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div id="panel_nama_penilai">
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=(trim($skp->penilai_gelar_depan) != '-')?trim($skp->penilai_gelar_depan).' ':'';?><?=(trim($skp->penilai_gelar_nonakademis) != '-')?trim($skp->penilai_gelar_nonakademis).' ':'';?><?=$skp->penilai_nama_pegawai;?><?=(trim($skp->penilai_gelar_belakang) != '-')?', '.trim($skp->penilai_gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->penilai_nip_baru;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id="penilai_pangkat"><?=$skp->penilai_nama_pangkat." / ".$skp->penilai_nama_golongan;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;" id="penilai_jabatan"><?=$skp->penilai_nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Unit kerja</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;" id="penilai_unor"><?=$skp->penilai_nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="panel panel-default" style="margin-bottom:5px;" id="panel_pegawai">
			<div class="panel-heading">
				<span class="fa fa-user fa-fw"></span>
				<span id=judul_box_pegawai><b>PEGAWAI YANG DINILAI</b></span>
				<a href="<?php echo site_url('admin/module/appskp/skp_formpegawai/dinilai'); ?>" class="btn btn-primary btn-xs pull-right" title="Edit Data Pegawai Dinilai"><i class="fa fa-edit"></i></a>
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=(trim($skp->gelar_depan) != '-')?trim($skp->gelar_depan).' ':'';?><?=(trim($skp->gelar_nonakademis) != '-')?trim($skp->gelar_nonakademis).' ':'';?><?=$skp->nama_pegawai;?><?=(trim($skp->gelar_belakang) != '-')?', '.trim($skp->gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->nip_baru;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id="pegawai_pangkat"><?=$skp->nama_pangkat." / ".$skp->nama_golongan;?></div>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;" id="pegawai_jabatan"><?=$skp->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Unit kerja</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;" id="pegawai_unor"><?=$skp->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div class="row target" id="grid-data">
	<div class="col-lg-12">
		<div class="table-responsive" style="padding-bottom:50px;">
<form id="content-form" method="post" action="<?=site_url("appskp/skp/edit_aksi");?>" enctype="multipart/form-data">
<table class="table table-striped table-bordered table-hover" style="width:1038px;">
<thead id=gridhead>
<tr height=20>
<th rowspan="2" style="width:25px;text-align:center;vertical-align:middle;">No.</th>
<th rowspan="2" style="width:25px;text-align:center;vertical-align:middle;">AKSI</th>
<th rowspan="2" style="width:300px;text-align:center;vertical-align:middle;">KEGIATAN TUGAS JABATAN</th>
<th rowspan="2" style="width:80px;text-align:center;vertical-align:middle;">AK</th>
<th colspan="2" align=center valign=center>KUANTITAS</th>
<th rowspan="2" style="width:60px;text-align:center;vertical-align:middle;">K.LITAS</th>
<th colspan="2" align=center valign=center>WAKTU</th>
<th rowspan="2" style="width:140px;text-align:center;vertical-align:middle;">BIAYA</th>
</tr>
<tr height=20>
<th style="width:80px;text-align:center;vertical-align:middle;">VOLUME</th>
<th style="width:80px;text-align:center;vertical-align:middle;">SATUAN</th>
<th style="width:60px;text-align:center;vertical-align:middle;">LAMA</th>
<th style="width:70px;text-align:center;vertical-align:middle;">SATUAN</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach($target AS $key=>$val){
?>
<tr id='row_<?=$val->id_target;?>'>
<td id='nomor_<?=$val->id_target;?>'><?=$no;?></td>
<td id='aksi_<?=$val->id_target;?>' align=center>
	<div class="btn-group" id="btMenu<?=$val->id_target;?>">
	<?php
	if($val->icon=="pentung")
	{
	?>
		<button class="btn btn-danger dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_target;?>" data-toggle="dropdown"><i class="fa fa-exclamation fa-fw"></i></button>
	<?php
	}
	elseif($val->icon=="acc")
	{
	?>
		<button class="btn btn-success dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_target;?>" data-toggle="dropdown"><i class="fa fa-check fa-fw"></i></button>
	<?php
	}
	else
	{
	?>
		<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenu<?=$val->id_target;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
	<?php
	}
	?>
		<ul class="dropdown-menu" role="menu">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp/formedit','<?=$val->id_target;?>','<?=$val->id_target."**".$no;?>');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp/formhapus','<?=$val->id_target;?>','<?=$val->id_target."**".$no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp/formkomentar','<?=$val->id_target;?>','<?=$val->id_target."**".$no;?>');"><i class="fa fa-exclamation fa-fw"></i>Lihat komentar</a></li>
		</ul>
	</div>
</td>
<td><div id='pekerjaan_<?=$val->id_target;?>'><?=$val->pekerjaan;?></div></td>
<td id='ak_<?=$val->id_target;?>'><?=$val->ak;?></td>
<td id='volume_<?=$val->id_target;?>'><?=$val->volume;?></td>
<td id='satuan_<?=$val->id_target;?>'><?=$val->satuan;?></td>
<td id='kualitas_<?=$val->id_target;?>'><?=$val->kualitas;?></td>
<td id='waktu_lama_<?=$val->id_target;?>'><?=$val->waktu_lama;?></td>
<td id='waktu_satuan_<?=$val->id_target;?>'><?=$val->waktu_satuan;?></td>
<td id='biaya_<?=$val->id_target;?>' align="right"><?=number_format($val->biaya,2,"."," ");?></td>
</tr>
<?php
$no++;
}
?>
<tr id='row_xx'>
<td id='nomor_xx'><?=$no;?></td>
<td id='aksi_xx' align=center>...</td>
<td id='pekerjaan_xx'>
<button class="btn tambah btn-primary btn-xs" type="button" data-nomor="<?=($no);?>" id='xx'><i class="fa fa-plus fa-fw"></i> Tambah kegiatan...</button>
</td>
<td id='ak_xx'>...</td>
<td id='volume_xx'>...</td>
<td id='satuan_xx'>...</td>
<td id='kualitas_xx'>...</td>
<td id='waktu_lama_xx'>...</td>
<td id='waktu_satuan_xx'>...</td>
<td id='biaya_xx'>...</td>
</tr>
</table>
</form>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row target #grid-data-->
<?php
} else {
?>
<div class="row target">
	<div class="col-lg-12">
		<a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('baru','xx','1');"><i class="fa fa-star fa-fw"></i>Buat SKP Pertama</a>
	</div>
	<!-- /.col-lg-12 -->
</div>
<?php
}
?>
</div>	
<!--#pageKonten-->
		<!-- SIMPAN -->
		<div id="simpan" style="display:none;"></div>
		<!-- /.SIMPAN -->

<script type="text/javascript"> 
$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	var ini = $(this).attr("id");
	var nomor = $(this).attr("data-nomor");
	var tt= $('#simpan').html();
	$('#row_'+ini+'').removeClass().html(tt);
	$('#simpan').html('');
});

	function editPenilai(){
		$(".target").hide();
		$('#form_editpenilai').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
		$('#form_editpenilai').show();
		
		var data = {"id_skp": <?=$id_skp;?> };
		
		$.post("<?php echo site_url('appskp/skp/get_penilai_form');?>", data, 
		function(result){
			$("#form_editpenilai").html(result);
		}
		);
	}		
	function editPenilaiCancel(){
		$('#form_editpenilai').hide();
		$(".target").show();
	}		
	function bsmShow(tujuan,no,idd){
	$('.btn.batal').click();
	tutup_track();
		if(tujuan=="skp/formedit")
		{
			var nomer = $('#nomor_'+no+'').html();
			var ini = no+'**'+nomer;
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"ini": ini },
			beforeSend:function(){	
				var ts = $('#row_'+no+'').html();
				$('#simpan').html(ts);
				$('#row_'+no+'').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
			},
			success:function(data){
				$('#row_'+no+'').replaceWith(data);
			},
			dataType:"html"});
		} 
		
		if(tujuan=="skp/formhapus")
		{
			var nomer = $('#nomor_'+no+'').html();
			var ini = no+'**'+nomer;
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"ini": ini },
			beforeSend:function(){	
				var ts = $('#row_'+no+'').html();
				$('#simpan').html(ts);
				$('#row_'+no+'').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
			},
			success:function(data){
				$('#row_'+no+'').replaceWith(data);
			},
			dataType:"html"});
		}

		if(tujuan=="skp/formkomentar")
		{
			var nomer = $('#nomor_'+no+'').html();
			var ini = no+'**'+nomer;
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"idd": no },
			beforeSend:function(){	
				var ts = $('#row_'+no+'').html();
				$('#simpan').html(ts);
				$('<tr id="row_tt" class="warning"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-1x"></i><p></td></tr>').insertAfter('#row_'+no);
				$('#row_'+no).addClass('warning');
			},
			success:function(data){
				$('#row_tt').html(data);
			},
			dataType:"html"});
		}

		if(tujuan=="track")
		{
			var no = $('#tahapan_skp_nomor').html();
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/skp/track/",
			data:{"idd": <?=$id_skp;?>,"no":no },
			beforeSend:function(){	
				$('<div class="row track" id=track_status><div class="col-lg-12"><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></div></div>').insertAfter('#status_skp');
			},
			success:function(data){
				$('#track_status').html(data);
				$('#trackbutton i.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-up');
				$('#trackbutton').attr('onclick','tutup_track()');
			},
			dataType:"html"});
		}

		if(tujuan=="pangkat" || tujuan=="jabatan")
		{
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/skp/riwayat_"+tujuan+"/",
			data:{"orang": no,"no":2 },
			beforeSend:function(){	
				$('<div style="display:block;z-index:3;position:absolute;background-color:#ffffFF;width:900px;" class=track id=track_status><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>'+no+'</div>').insertBefore('#panel_nama_penilai');
			},
			success:function(data){
				$('#track_status').html(data);
				$('#panel_'+no+'').addClass('panel-warning');
				$('#trackbutton').attr('onclick','tutup_track()');
			},
			dataType:"html"});
		}
}

function tutup_track(){
	$("[id^='panel_']").removeClass('panel-warning');
	$("[id^='row_']").removeClass();
	$('.track').remove();
	$('#trackbutton i.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
	$('#trackbutton').attr('onclick','bsmShow("track",1,1,"r")');
}

function hapus(){
	var idd = $('#idhapus').html();
	var iii = 1;
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/skp/hapus_aksi",
		data:{"idd": idd },
		beforeSend:function(){	
			tutup_track();
			$('#row_tt').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
		},
        success:function(data){
			$('#row_'+idd+'').remove();
			$('#row_tt').remove();
			$("[id^='nomor_']").each(function(key,val) {
				$(this).html(iii);
				iii++;
			});
				var ts = parseInt($('#xx').attr('data-nomor'));
				$('#xx').attr('data-nomor',(ts-1));
		},
        dataType:"html"});
}

$(document).on('click', '.btn.tambah',function(){
	var ini = $(this).attr("id");
	var nomor = $(this).attr("data-nomor");
	$('.btn.batal').click();
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/skp/formtambah",
		data:{"ini": ini,"nomor":nomor },
		beforeSend:function(){	
			tutup_track();
			var ts = $('#row_xx').html();
			$('#simpan').html(ts);
			$('#row_'+ini+'').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
		},
        success:function(data){
			$('#row_'+ini+'').replaceWith(data);
		},
        dataType:"html"});
});

function validasi(){
	var data="";
	var dati="";
			var nama = $.trim($("textarea[name='target']").val());
			data=data+""+nama+"";
			if( nama ==""){	dati=dati+"KEGIATAN TUGAS JABATAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
$(document).on('click', '.btn.simpan',function(){
	var hasil=validasi();
	if (hasil!=false) {
	$('#row_tt').remove();
	var idd = $(this).attr('id');
		$.ajax({
        type:"POST",
		url:$("#content-form").attr('action'),
		data:$("#content-form").serialize(),
		beforeSend:function(){	
				$('#row_'+idd+'').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
		},
        success:function(data){
				var tab="";
				if(data[0].aksi=="edit"){
					$('#pekerjaan_'+idd+'').html(data[0].pekerjaan);
					$('#ak_'+idd+'').html(data[0].ak);
					$('#volume_'+idd+'').html(data[0].volume);
					$('#satuan_'+idd+'').html(data[0].satuan);
					$('#kualitas_'+idd+'').html(data[0].kualitas);
					$('#waktu_lama_'+idd+'').html(data[0].waktu_lama);
					$('#waktu_satuan_'+idd+'').html(data[0].waktu_satuan);
					$('#biaya_'+idd+'').html(data[0].biaya);
					var ts = $('#simpan').html();
					$('#row_'+idd+'').removeClass().html(ts);
				} else	{  // tambah
					var no = parseInt($('#nomor_xx').html());
					$('#nomor_xx').html(no+1);
					tab = '<tr id=row_'+data[0].id_target+'>';
					tab = tab + '<td id="nomor_'+data[0].id_target+'">'+no+'</td>';
					tab = tab + '<td id="aksi_'+data[0].id_target+'" align="center">';
					tab = tab + '<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenu'+data[0].id_target+'" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
					tab = tab + '<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu'+data[0].id_target+'">';
					tab = tab + '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow(\'skp/formedit\','+data[0].id_target+',\''+data[0].id_target+'**'+no+'\');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>';
					tab = tab + '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow(\'skp/formhapus\','+data[0].id_target+',\''+data[0].id_target+'**'+no+'\');"><i class=\"fa fa-trash fa-fw\"></i>Hapus data</a></li>';
					tab = tab + '<li role="presentation" class="divider"></li>';
					tab = tab + '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow(\'skp/formkomentar\','+data[0].id_target+',\''+data[0].id_target+'**'+no+'\');"><i class="fa fa-exclamation fa-fw"></i>Lihat komentar</a></li>';
					tab = tab + "</ul></div></td>";
					tab = tab + '<td><div id="pekerjaan_'+data[0].id_target+'">'+data[0].pekerjaan+'</td>';
					tab = tab + "<td id='ak_"+data[0].id_target+"'>"+data[0].ak+"</td>";
					tab = tab + "<td id='volume_"+data[0].id_target+"'>"+data[0].volume+"</td>";
					tab = tab + "<td id='satuan_"+data[0].id_target+"'>"+data[0].satuan+"</td>";
					tab = tab + "<td id='kualitas_"+data[0].id_target+"'>"+data[0].kualitas+"</td>";
					tab = tab + "<td id='waktu_lama_"+data[0].id_target+"'>"+data[0].waktu_lama+"</td>";
					tab = tab + "<td id='waktu_satuan_"+data[0].id_target+"'>"+data[0].waktu_satuan+"</td>";
					tab = tab + "<td id='biaya_"+data[0].id_target+"' align=right>"+data[0].biaya+"</td>";
					tab = tab + "</tr>";
					var ts = parseInt($('#xx').attr('data-nomor'));
					$('#xx').attr('data-nomor',(ts+1));

					$(tab).insertBefore('#row_xx');
					var ts = $('#simpan').html();
					$('#row_'+idd+'').removeClass().html(ts);
				}
		},
        dataType:"json"});
	}// if =>hasil
});

</script>
<style>
.modal .modal-body {  max-height:400px; overflow-y:auto; }
.modal-wide .modal-dialog {	width: 900px;	}
table th {	text-align:center; vertical-align:middle;	}
</style>
