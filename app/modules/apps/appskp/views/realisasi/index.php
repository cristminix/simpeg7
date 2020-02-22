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
			location.href = '<?=site_url();?>'+'admin/module/appskp/realisasi';
		},
        dataType:"json"});
	return false;
}
function setForm(tujuan,idd,no,urutan){

	var kop = []; 
	kop['form_skp_ajupenilai'] = "FORM PENGAJUAN REALISASI KINERJA KEPADA PEJABAT PENILAI"; 
	kop['arsip'] = "DAFTAR ARSIP REALISASI KINERJA"; 
	var act = []; 
	act['form_skp_ajupenilai'] = "<?=site_url();?>appskp/realisasi/aju_penilai"; 
	act['arsip'] = "<?=site_url();?>appskp/realisasi/arsip_aksi"; 
	var btt = []; 
	btt['form_skp_ajupenilai'] = "<button id='btAct' type=sumbit class='btn btn-primary' onclick='ajukan(); return false;'><i class='fa fa-upload fa-fw'></i> Ajukan</button>"; 
	btt['arsip'] = "<div id='btAct'></div>"; 

			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/realisasi/"+tujuan,
			data:{"idd": <?=$id_skp;?> },
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
<!-- /.row -->
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
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
					<div style="float:left;">
					<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown"><span class="fa fa-tasks fa-fw"></span></button>
						<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
							<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('form_skp_ajupenilai',1,1,1);"><i class="fa fa-upload fa-fw"></i>Ajukan kepada Pejabat Penilai</a></li>
							<li role="presentation"><a href="<?=site_url('appskp/cetak');?>" role="menuitem" tabindex="-1" style="cursor:pointer;" target="_blank"><i class="fa fa-print fa-fw"></i>Cetak Lembar Penilaian</a></li>
							<li role="presentation" class="divider"></li>
							<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('arsip',1,1,1);"><i class="fa fa-binoculars fa-fw"></i>Lihat Arsip Realisasi SKP</a></li>
						</ul>
					</div>
					</div>
					<span style="margin-left:5px;"><b>REALISASI SKP TAHUN <?=$skp->tahun;?></b></span>
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
												<div style="float:left; width:25px; text-align:right; padding-right:5px;" id="tahapan_skp_nomor"><?=$tahapan_skp_nomor[$realisasi_tahapan->status];?>.</div>
												<span><div style="display:table;"><?=$tahapan_skp[$realisasi_tahapan->status];?> <i class="fa fa-caret-down fa-fw"></i></div></span>
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
			<div class="panel-body">
								<div>
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
										<span><div style="display:table;"><?=$skp->penilai_nama_pangkat." / ".$skp->penilai_nama_golongan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->penilai_nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
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
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>PEGAWAI YANG DINILAI</b></div>
			<div class="panel-body">
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
										<span><div style="display:table;"><?=$skp->nama_pangkat." / ".$skp->nama_golongan;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$skp->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both">
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
<div class="row">
	<div class="col-lg-12">
                  <div class="panel panel-default">
                        <div class="panel-body" style="padding:0px;">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tugas_pokok" data-toggle="tab"><i class="fa fa-briefcase fa-fw"></i> Tugas pokok</a></li>
                                <li><a href="#tugas_tambahan" data-toggle="tab" onClick="vTab('tugas_tambahan');return false;" id="key_tugas_tambahan"><i class="fa fa-ra fa-fw"></i>Tugas tambahan</a></li>
                                <li><a href="#kreatifitas" data-toggle="tab" onClick="vTab('kreatifitas');return false;" id="key_kreatifitas"><i class="fa fa-trophy fa-fw"></i> Kreatifitas</a></li>
                                <li><a href="#perilaku" data-toggle="tab" onClick="vTab('perilaku');return false;" id="key_perilaku"><i class="fa fa-child fa-fw"></i> Perilaku</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content" style="padding:5px;">
                                <div class="tab-pane fade in active" id="tugas_pokok">
<div id="grid-data">
		<div class="table-responsive">
<form id="content-form" method="post" action="<?=site_url("appskp/skp/edit_aksi");?>" enctype="multipart/form-data">
<table class="table table-striped table-bordered table-hover" style="width:1024px;">
<thead id=gridhead>
<tr height=20>
<th style="width:55px" valign=center>No.</th>
<th style="width:45px">AKSI</th>
<th style="width:450px">KEGIATAN TUGAS JABATAN</th>
<th style="width:100px">UNSUR</th>
<th style="width:150px">TARGET</th>
<th style="width:150px">REALISASI</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
foreach($target AS $key=>$val){
?>
<tr id='row_tugas_pokok_<?=$val->id_target;?>'>
<td id='nomor_<?=$val->id_target;?>'><?=$no;?></td>
<td id='aksi_<?=$val->id_target;?>' style="text-align:center;">
	<button class="btn beku btn-primary btn-xs" type="button" style="display:none;"><span class="caret"></span></button>
	<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('point','<?=$val->id_target;?>','tugas_pokok','komentar');"><i class="fa fa-comment fa-fw"></i>Lihat komentar</a></li>
		</ul>
	</div>
</td>
<td id='pekerjaan_<?=$val->id_target;?>'><?=$val->pekerjaan;?></td>
<td id='unsur_<?=$val->id_target;?>'>
	<div style="text-align:right;" class="ket ak_<?=$val->id_target;?>">AK :</div>
	<div style="text-align:right;" class="ket volume_<?=$val->id_target;?>">KUANTITAS :</div>
	<div style="text-align:right;" class="ket kualitas_<?=$val->id_target;?>">KUALITAS :</div>
	<div style="text-align:right;" class="ket waktu_lama_<?=$val->id_target;?>">WAKTU :</div>
	<div style="text-align:right;" class="ket biaya_<?=$val->id_target;?>">BIAYA :</div>
</td>
<td id='target_<?=$val->id_target;?>'>
	<div class="ket ak_<?=$val->id_target;?>"><?=$val->ak;?></div>
	<div><span class="ket volume_<?=$val->id_target;?>"><?=$val->volume;?></span> <?=$val->satuan;?></div>
	<div><span class="ket kualitas_<?=$val->id_target;?>"><?=$val->kualitas;?></span></div>
	<div><span class="ket waktu_lama_<?=$val->id_target;?>"><?=$val->waktu_lama;?></span> <?=$val->waktu_satuan;?></div>
	<div class="ket biaya_<?=$val->id_target;?>" style="text-align:right;"><?=number_format($val->biaya,2,"."," ");?></div>
</td>
<td id='realisasi_<?=$val->id_target;?>' style="padding:7px 0px 0px 0px;">
	<input type="text" class="form-control rel" data-idt="<?=$val->id_target;?>" data-var="ak" id="ipt_ak_<?=$val->id_target;?>" placeholder="Masukkan angka saja" data-lama="<?=(!isset($realisasi[$key]->ak))?'':$realisasi[$key]->ak;?>" value="<?=(!isset($realisasi[$key]->ak))?'':$realisasi[$key]->ak;?>" <?=$avail;?> style="width:100%;height:20px;padding:1px 0px 0px 5px;">
	<input type="text" class="form-control rel" data-idt='<?=$val->id_target;?>' data-var='volume' id="ipt_volume_<?=$val->id_target;?>" placeholder="Masukkan angka saja" data-lama="<?=(!isset($realisasi[$key]->volume))?'':$realisasi[$key]->volume;?>" value="<?=(!isset($realisasi[$key]->volume))?'':$realisasi[$key]->volume;?>" <?=$avail;?> style="width:100%;height:20px;padding:1px 0px 0px 5px;">
	<input type="text" class="form-control rel" data-idt='<?=$val->id_target;?>' data-var='kualitas' id="ipt_kualitas_<?=$val->id_target;?>" placeholder="Masukkan angka saja" data-lama="<?=(!isset($realisasi[$key]->kualitas))?'':$realisasi[$key]->kualitas;?>" value="<?=(!isset($realisasi[$key]->kualitas))?'':$realisasi[$key]->kualitas;?>" <?=$avail;?> style="width:100%;height:20px;padding:1px 0px 0px 5px;">
	<input type="text" class="form-control rel" data-idt='<?=$val->id_target;?>' data-var='waktu_lama' id="ipt_waktu_lama_<?=$val->id_target;?>" placeholder="Masukkan angka saja" data-lama="<?=(!isset($realisasi[$key]->waktu_lama))?'':$realisasi[$key]->waktu_lama;?>" value="<?=(!isset($realisasi[$key]->waktu_lama))?'':$realisasi[$key]->waktu_lama;?>" <?=$avail;?> style="width:100%;height:20px;padding:1px 0px 0px 5px;">
	<input type="text" class="form-control rel biaya" data-idt='<?=$val->id_target;?>' data-var='biaya' id="ipt_biaya_<?=$val->id_target;?>" placeholder="Masukkan angka saja" data-lama="<?=(!isset($realisasi[$key]->biaya))?'':number_format($realisasi[$key]->biaya,2,"."," ");?>" value="<?=(!isset($realisasi[$key]->biaya))?'':number_format($realisasi[$key]->biaya,2,"."," ");?>" <?=$avail;?> style="width:100%;height:20px;padding:1px 5px 0px 5px;text-align:right;">
</td>
</tr>
<?php
$no++;
}
if($no==1){
?>
<tr><td colspan=6 align=center>Belum ada kegiatan tugas jabatan</td></tr>
<?php
}
?>
</table>
</form>
<script type="text/javascript">
</script>

		</div>
		<!-- table-responsive --->
</div>
<!-- /.grid-data -->
								</div>
								<!-- tab id=tugas -->
                                <div class="tab-pane fade" id="tugas_tambahan" style="padding-top:5px;">Tugas tambahan</div>
                                <div class="tab-pane fade" id="kreatifitas" style="padding-top:5px;">Kreatifitaskkk</div>
                                <div class="tab-pane fade" id="perilaku" style="padding-top:5px;">Perilaku</div>
							</div>
						</div>
						<!-- /.panel-body -->
				  </div>
				<!-- /.panel-default -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>	
<!--#pageKonten-->

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
$(function() {
	$('.biaya').maskMoney({thousands:' ', decimal:'.', allowZero:true});
})
$(document).on('click', '.nav.nav-tabs li',function(){
	$('.btn.batal').click();
});
$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	var ini = $(this).attr("id");
	var nomor = $(this).attr("data-nomor");
	var tt= $('#simpan').html();
	$('#row_'+ini+'').removeClass().html(tt);
	$('#simpan').html('');
});

function vTab(isi){
	$('.btn.batal').click();
	$('#'+isi+'').html('');
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/realisasi/lembar_"+isi+"/",
			data:{"idd": <?=$id_skp;?> },
			beforeSend:function(){	
				$('#'+isi+'').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				$('#'+isi+'').html(data);
//				$('#key_'+isi+'').removeAttr("onClick");
			},
			dataType:"html"});
}

$(document).on('click', '.btn.tambah',function(){
	var ini = $(this).attr("data-ini");
	var nomor = $(this).attr("data-nomor");
	var formtambah = $(this).attr("data-form");
	$('.btn.batal').click();
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/realisasi/formtambah_"+formtambah+"",
		data:{"ini": ini,"nomor":nomor },
		beforeSend:function(){	
			tutup_track();
			var ts = $('#row_'+ini+'').html();
			$('#simpan').html(ts);
			$('#row_'+ini+'').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
		},
        success:function(data){
			$('#row_'+ini+'').replaceWith(data);
		},
        dataType:"html"});
});

$(document).on('click', '.btn.simpan_xx',function(){
	lembar = $(this).attr('data-lembar');
	aksi = $(this).attr('data-aksi');
		$.ajax({
        type:"POST",
		url:	aksi,
		data:$("#"+lembar+"-form").serialize(),
		beforeSend:function(){	
			$('#'+lembar+'').html();
			$('#row_tt').hide();
			$('#row_xx').html('<tr><td colspan=7><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td></tr>');
		},
        success:function(data){
			vTab(lembar);
		},
        dataType:"html"});
	return false;
});

function bsmShow(tujuan,no,idd,operasi){
tutup_track();
$('.btn.batal').click();
		if(tujuan=="point")
		{
			$('#row_tt').remove();
			$("[id='row_']").removeClass();
			if(operasi=="edit"){	var pclass="success";	}	if(operasi=="hapus"){	var pclass="danger";	}	if(operasi=="komentar"){	var pclass="warning";	}
			var nomor = $('#nomor_'+idd+'_'+no+'').html();
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/realisasi/form"+operasi+"_"+idd+"/",
			data:{"idd": no,"nomor":nomor },
			beforeSend:function(){	
				var ts = $('#row_'+idd+'_'+no+'').html();
				$('#simpan').html(ts);
				$('#content-form').attr('action','<?=site_url();?>appskp/realisasi/target_acc');
				$('<tr id="row_tt" class='+pclass+'><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-1x"></i><p></td></tr>').insertAfter('#row_'+idd+'_'+no+'');
				$('#row_'+idd+'_'+no+'').addClass(pclass);
			},
			success:function(data){
				$('#row_tt').replaceWith(data);
			},
			dataType:"html"});
		}
		if(tujuan=="editpoint")
		{
			var nomor = $('#nomor_'+idd+'_'+no+'').html();
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/realisasi/formedit_"+idd+"/",
			data:{"idd": no,"nomor":nomor },
			beforeSend:function(){	
				var ts = $('#row_'+idd+'_'+no+'').html();
				$('#simpan').html(ts);
				$('#row_'+idd+'_'+no+'').html('<td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td>');
			},
			success:function(data){
				$('#row_'+idd+'_'+no+'').replaceWith(data);
			},
			dataType:"html"});
		}
		if(tujuan=="track")
		{
			var no = $('#tahapan_skp_nomor').html();
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/realisasi/track/",
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
}

function tutup_track(){
	$("[id^='row_']").removeClass();
	$('.track').remove();
	$('#trackbutton i.fa-caret-up').removeClass('fa-caret-up').addClass('fa-caret-down');
	$('#trackbutton').attr('onclick','bsmShow("track",1,1)');
}

$(document).on('click', '.btn.simpan_skp',function(){
		$.ajax({
        type:"POST",
		url:	$("#modal-form").attr('action'),
		data:$("#modal-form").serialize(),
		beforeSend:function(){	
			$('#modalButtonAksi').hide();
			$('#isi_modal').html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-2x\"></i><p>');
		},
        success:function(data){
			location.href = '<?=site_url();?>'+'admin/module/appskp/realisasi';
		},
        dataType:"json"});
	return false;
});

///////////////////////////////////////////////////////////////////////
$(document).on('blur', '.form-control.rel',function(){
	var iniVar = $(this).attr('data-var');
	var iniDD = $(this).attr('data-idt');
	$('.aktif.'+iniVar+'_'+iniDD+'').removeClass('aktif').addClass('ket');
	var lama = $(this).attr('data-lama');
	var baru = $(this).val(); 
			if(lama!=baru){
					var baruu = baru.split(" ").join("");
					$.ajax({
					type:"POST",
					url:"<?=site_url();?>appskp/realisasi/ipt_realisasi",
					data:{"idd": iniDD,"nilai":baruu,"nama":iniVar },
					beforeSend:function(){
						$('#ipt_'+iniVar+'_'+iniDD).hide();
						$('<div style="height:20px;margin:0px;padding:0px;" id="paraC"><p class="text-center"><i class="fa fa-spinner fa-spin fa-1x"></i><p></div>').insertAfter('#ipt_'+iniVar+'_'+iniDD);
					},
					success:function(data){
						if(data.pesan=="sukses"){
							$('#ipt_'+iniVar+'_'+iniDD).attr('data-lama',data.isi).val(data.isi).show();
						} else {
							alert(data.pesan);
							$('#ipt_'+iniVar+'_'+iniDD).val(baru).show().focus();
						}
						$('#paraC').remove();
					},
					dataType:"json"});//end jax
			} // end if
});
$(document).on('focus', '.form-control.rel',function(){
	var iniVar = $(this).attr('data-var');
	var iniDD = $(this).attr('data-idt');
	$('.ket.'+iniVar+'_'+iniDD+'').removeClass('ket').addClass('aktif');
});
///////////////////////////////////////////////////////////////////////
</script>
<style>
.aktif { color:#ff0000; font-weight:bold;	}
.modal-wide .modal-dialog {	width: 950px;	}
table th {	text-align:center; vertical-align:middle;	}

.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px;padding-left: 10px;}
.panel-default .panel-body .nav-tabs li a { padding-right: 10px; padding-left: 5px; padding-top:7px; padding-bottom:7px; margin-left:0px;	}
</style>
