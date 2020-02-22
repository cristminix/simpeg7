<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12" style="padding-bottom:5px; text-align:right">
		<button class="btn btn-primary" type="button" onclick="kembali(); return false;"><i class="fa fa-fast-backward fa-fw"></i>Kembali...</button>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
	<div style="float:left;">
	<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenu1" data-toggle="dropdown"><span class="fa fa-tasks fa-fw"></span></button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu1">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp_kelola/form_kembalikan','1','1');"><i class="fa fa-download fa-fw"></i>Dikoreksi, kembalikan kepada Pegawai</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp_kelola/form_acc','1','1');"><i class="fa fa-upload fa-fw"></i>Disetujui, Ajukan kepada Verifikatur</a></li>
		</ul>
	</div>
	</div>
			<span style="margin-left:5px;"><b>SKP TAHUN <?=$skp->tahun;?></b></span>
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
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>PEJABAT PENILAI</b></div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=(trim($skp->penilai_gelar_depan) != '-')?trim($skp->penilai_gelar_depan).' ':'';?><?=(trim($skp->penilai_gelar_nonakademis) != '-')?trim($skp->penilai_gelar_nonakademis).' ':'';?><?=$skp->penilai_nama_pegawai;?><?=(trim($skp->penilai_gelar_belakang) != '-')?', '.trim($skp->penilai_gelar_belakang):'';?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->penilai_nip_baru;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->penilai_nama_pangkat." / ".$skp->penilai_nama_golongan;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->penilai_nomenklatur_jabatan;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">Unit kerja</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->penilai_nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6">
		<div class="panel panel-default" style="margin-bottom:5px;">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>PEGAWAI YANG DINILAI</b></div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=(trim($skp->gelar_depan) != '-')?trim($skp->gelar_depan).' ':'';?><?=(trim($skp->gelar_nonakademis) != '-')?trim($skp->gelar_nonakademis).' ':'';?><?=$skp->nama_pegawai;?><?=(trim($skp->gelar_belakang) != '-')?', '.trim($skp->gelar_belakang):'';?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->nip_baru;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->nama_pangkat." / ".$skp->nama_golongan;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->nomenklatur_jabatan;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">Unit kerja</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div id="grid-data">
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
<form id="content-form" method="post" action="<?=site_url("appskp/skp/edit_aksi");?>" enctype="multipart/form-data">
<table style="width:100%;" class="table table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th style="width:65px;" rowspan="2" align=center valign=center>No.</th>
<th style="width:45px;" rowspan="2" align=center valign=center>AKSI</th>
<th rowspan="2" style="width:300px;">KEGIATAN TUGAS JABATAN</th>
<th rowspan="2" style="width:50px;">AK</th>
<th colspan="2" align=center valign=center>KUANTITAS</th>
<th rowspan="2" style="width:50px;">K.LITAS</th>
<th colspan="2" align=center valign=center>WAKTU</th>
<th rowspan="2" style="width:120px;" align=center valign=center>BIAYA</th>
</tr>
<tr height=20>
<th style="width:60px;"align=center valign=center>VOLUME</th>
<th style="width:75px;" align=center valign=center>SATUAN</th>
<th style="width:50px;" align=center valign=center>LAMA</th>
<th style="width:70px;" align=center valign=center>SATUAN</th>
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
	<div class="dropdown">
	<?php
	if($val->icon=="pentung")
	{
	?>
	<button class="btn btn-danger dropdown-toggle btn-xs" type="button" id="dropdownMenu_<?=$val->id_target;?>" data-toggle="dropdown"><i class="fa fa-exclamation fa-fw"></i></button>
	<?php
	}
	elseif($val->icon=="acc")
	{
	?>
	<button class="btn btn-success dropdown-toggle btn-xs" type="button" id="dropdownMenu_<?=$val->id_target;?>" data-toggle="dropdown"><i class="fa fa-check fa-fw"></i></button>
	<?php
	}
	else
	{
	?>
	<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenu_<?=$val->id_target;?>" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
	<?php
	}
	?>

		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp_kelola/form_target_acc','<?=$val->id_target;?>','<?=$val->id_target."**".$no;?>');"><i class="fa fa-check fa-fw"></i>ACC Kegiatan Tugas Jabatan</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp_kelola/target_koreksi','<?=$val->id_target;?>','<?=$val->id_target."**".$no;?>');"><i class="fa fa-edit fa-fw"></i>Koreksi Kegiatan Tugas Jabatan, dan beri komentar</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp/formkomentar','<?=$val->id_target;?>','<?=$val->id_target."**".$no;?>');"><i class="fa fa-comment fa-fw"></i>Lihat komentar</a></li>
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
</table>
</form>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.grid-data -->
<br/><br/>
		<!-- Modal -->
		<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form id="modal-form" method="post" action="" enctype="multipart/form-data">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"></h4>
                                        </div>
                                        <div class="modal-body" id="isi_modal">
										  satu
                                        </div>
	                                    <!-- /.modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary simpan_skp" id="modalButtonAksi"></button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close fa-fw"></i>Batal...</button>
                                        </div>
	                                    <!-- /.modal-footer -->
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
			</form>
		</div>
		<!-- /.modal -->
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
function bsmShow(tujuan,idd,idx){
	$('.btn.batal').click();
	tutup_track();
		if(tujuan=="skp_kelola/form_acc")
		{
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"idd": idd },
			beforeSend:function(){	
				$('#myModalLabel').html('FORM PERSETUJUAN TARGET SKP dan PENGAJUAN KEPADA VERIFIKATUR');
				$('#modal-form').attr('action','<?=site_url();?>appskp/skp_kelola/ajuverifikatur_aksi');
				$('#modalButtonAksi').attr('onclick','acc_skp();').html('<i class="fa fa-upload fa-fw"></i> Setuju dan Ajukan').show();
				$("#isi_modal").html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p>');
				$('#myModal').addClass('modal-wide').modal('show');
			},
			success:function(data){
				$('#isi_modal').html(data);
			},
			dataType:"html"});
		}
		if(tujuan=="skp_kelola/form_kembalikan")
		{
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"idd": idd },
			beforeSend:function(){	
				$('#myModalLabel').html('FORM KOREKSI TARGET SASARAN KINERJA PEGAWAI');
				$('#modal-form').attr('action','<?=site_url();?>appskp/skp_kelola/kembali_aksi');
				$('#modalButtonAksi').attr('onclick','kembali();').html('<i class="fa fa-download fa-fw"></i> Kembalikan').show();
				$("#isi_modal").html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p>');
				$('#myModal').addClass('modal-wide').modal('show');
			},
			success:function(data){
				$('#isi_modal').html(data);
			},
			dataType:"html"});
		}
		if(tujuan=="skp_kelola/form_target_acc")
		{
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"idd": idd },
			beforeSend:function(){	
				var ts = $('#row_'+idd+'').html();
				$('#simpan').html(ts);
				$('#content-form').attr('action','<?=site_url();?>appskp/skp_kelola/target_acc');
				var data = '<tr id="row_tt" class=success><td colspan=10><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-1x\"></i><p></td></tr>';
				$(data).insertAfter('#row_'+idd+'');
				$('#row_'+idd+'').addClass('success');
			},
			success:function(data){
				$('#row_tt').html(data);
			},
			dataType:"html"});
		}

		if(tujuan=="skp_kelola/target_koreksi")
		{  // hapus
			var ts = $('#row_'+idd+'').html();
			$('#simpan').html(ts);
			$('#content-form').attr('action','<?=site_url();?>appskp/skp_kelola/target_koreksi');
			var data = '<tr id="row_tt" class=info><td colspan=2 align=right><b>Komentar :</b></td><td colspan=8><textarea class=form-control id=komentar cols=60 style="height:50px;"></textarea>';
			data = data + '<div style="clear:both;margin-top:5px;"><button class="btn btn-primary btn-xs" type="button" onclick="simpan();"><i class="fa fa-save"></i> Simpan</button>&nbsp;<button class="btn batal btn-primary btn-xs" id="'+idd+'" data-nomor="'+idd+'" type="button"><i class="fa fa-close"></i> Batal...</button>';
			data = data + '</div><div style="display:none;" id=idd>'+idd+'</div></td></tr>';
			$(data).insertAfter('#row_'+idd+'');
			$('#row_'+idd+'').addClass('info');
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
		if(tujuan=="skp/formkomentar")
		{
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"idd": idd },
			beforeSend:function(){	
				$('#row_'+idd+'').addClass('danger');
				$('<div class="track" id="komentar_'+no+'" style="clear:both;display:block;z-index:3;position:absolute; margin-top:4px; margin-left:15px;"><i class=\"fa fa-spinner fa-spin fa-2x\"></i><p></div>').insertAfter('#pekerjaan_'+idd+'');
			},
			success:function(data){
				$('#komentar_'+no+'').html(data);
			},
			dataType:"html"});
		}
}
function tutup_track(){
	$("[id^='row_']").removeClass();
	$('.track').remove();
	$('#trackbutton i.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
	$('#trackbutton').attr('onclick','bsmShow("track",1,1,"r")');
}

function kembali(){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/sett/pantau_target",
			data:{"hal": <?=$hal;?>,"cari":"<?=$cari;?>","batas":"<?=$batas;?>" },
			beforeSend:function(){	
				$("#page-wrapper").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				$('#page-wrapper').html(data);
			},
			dataType:"html"});
}

function simpan(){
	var idd = $('#idd').html();
	var komen = $('#komentar').val();
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/skp_kelola/target_koreksi",
			data:{"komentar": komen,"idd":idd },
			beforeSend:function(){	
				$('#row_tt').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td>');
			},
			success:function(data){
				$('#dropdownMenu_'+idd+'').removeClass('btn-success').removeClass('btn-primary').addClass('btn-danger').html('<i class="fa fa-exclamation fa-fw"></i>');
				$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
				$('#row_'+idd).removeClass();
				var data2 = '<span id="tahapan_skp_nomor">4</span>. Koreksi target sasaran kerja pegawai oleh Pejabat Penilai &nbsp;<span class="fa fa-caret-down"></span>';
				$('#trackbutton').html(data2);
			},
			dataType:"html"});
	
}
function acc_skp(){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/skp_kelola/acc_penilai_aksi",
			data:{"komentar": "saya" },
			beforeSend:function(){	
				$('#modalButtonAksi').hide();
				$('#isi_modal').html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-2x\"></i><p>');
			},
			success:function(data){
				location.href = '<?=site_url();?>'+'admin/module/appskp/skp_kelola';
			},
			dataType:"html"});
}



function acc(){
	var idd = $('#idd').html();
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/skp_kelola/target_acc",
			data:{"idd":idd },
			beforeSend:function(){	
				$('#row_tt').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-1x"></i><p></td>');
			},
			success:function(data){
				$('#dropdownMenu_'+idd+'').removeClass('btn-danger').removeClass('btn-primary').addClass('btn-success').html('<i class="fa fa-check fa-fw"></i>');
				$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
				$('#row_'+idd).removeClass();
			},
			dataType:"html"});
	
}
</script>
<style>
.modal-wide .modal-dialog {	width: 950px;	}
table th {	text-align:center; vertical-align:middle;	}
</style>
