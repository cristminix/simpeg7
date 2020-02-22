  <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<i class="fa fa-edit fa-fw"></i> <b>Form Update Kontrak Pegawai</b>
								</div>
								<!--//col-lg-6-->
								<div class="col-lg-6">
									<div class="btn-group pull-right">
									<button class="btn btn-primary btn-xs" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-6-->
						</div>
						<!--//row-->
			</div>
			<div class="panel-body" style="padding-left:5px;padding-right:5px;">


<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default" style="margin-bottom:5px;" id="panel_pegawai">
			<div class="panel-heading">
				<span class="fa fa-user fa-fw"></span>
				<span id=judul_box_pegawai><b>RIWAYAT KONTRAK PEGAWAI</b></span>
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
										<span><div style="display:table;"><?=$pegawai->nip_baru;?></div></span>
								</div>
								<!--div style="clear:both">
										<div style="float:left; width:90px;">Pangkat/Gol.</div>
										<div style="float:left; width:5px;">:</div>
										<div style="float:left;" id="pegawai_pangkat"><?=$pegawai->nama_pangkat." / ".$pegawai->nama_golongan;?></div>
								</div-->
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
</div>
<!-- /.row -->





<div class="row sanksi" id="grid-data">
	<div class="col-lg-12">
		<div class="table-responsive">
<form id="form_kontrak" method="post" enctype="multipart/form-data">
	<input type=hidden name="id_pegawai" value="<?=$pegawai->id_pegawai;?>">
	<div id="tampung" style="display:none;"></div>
<table class="table table-striped table-bordered table-hover" style="width:1024px;" id="riwayat_kontrak">
<thead id=gridhead>
<tr>
	<th style="width:8%;text-align:center;vertical-align:middle;" rowspan="2">No.</th>
	<th style="width:10%;text-align:center;vertical-align:middle;" rowspan="2">AKSI</th>
	<th style="width:12%;text-align:center;vertical-align:middle;" rowspan="2">TMT Kontrak</th>
	<th style="width:20%;text-align:center;vertical-align:middle;" colspan="2">Masa Kerja Pengangkatan</th>
	<th style="width:50%;text-align:center;vertical-align:middle;" colspan="3">Surat Keputusan (SK)</th>
</tr>
<tr>
	<th>TAHUN</th>
	<th>BULAN</th>
	<th style="width:18%;text-align:center;vertical-align:middle;">NOMOR</th>
	<th style="width:12%;text-align:center;vertical-align:middle;">TANGGAL</th>
	<th style="width:20%;text-align:center;vertical-align:middle;">PEJABAT</th>
	

</tr>
</thead>
<tbody>
<?php echo $kontrak;?>
<tr id='row_xx'>
<td id='nomor_xx'><?=$no;?></td>
<td id='aksi_xx' align=center>...</td>
<td id='pekerjaan_xx' colspan="6">
<button class="btn btn-primary" type="button" onclick="setSubForm('tambah','xx',<?=$no;?>);"><i class="fa fa-plus fa-fw"></i> Tambah riwayat kontrak</button>
</td>
</tr>
<tbody>
</table>
</form>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row jabatan #grid-data-->

						<div class="row">
								<div class="col-lg-12">
									<div class="btn-group pull-right">
									<button class="btn btn-primary" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-12-->
						</div>
						<!--//row-->


			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->


<script type="text/javascript">
var tpspinner = '<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>';

$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	$("[id^='row_']").removeClass().show();
	$('#simpan').html('');
});

function setSubForm(aksi,idd,no){
	$('.btn.batal').click();

		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/formkontrak_"+aksi,
		data:{"idd": idd,"nomor":no },
		beforeSend:function(){
			$('#row_'+idd).addClass('success');
			$('<tr id="row_tt" class="success"><td colspan=10>'+tpspinner+'</td></tr>').insertAfter('#row_'+idd);
		},
        success:function(data){
			$('#form_kontrak').attr('action','<?=site_url("appbkpp/pegawai/formkontrak_");?>'+aksi+'_aksi');
			$('#row_'+idd).hide();
			$('#row_tt').replaceWith(data);
		},
        dataType:"html"});
}
////////////////////////////////////////////////////////////////////////////
function baru(){
	$.ajax({
		type:"POST",
		url: "<?=site_url();?>appbkpp/pegawai/kontrak_riwayat",
		data: $("#form_kontrak").serialize(),
		beforeSend:function(){
			$('#riwayat_kontrak tbody').remove();
			$('<tbody><tr id="list_riwayat"><td colspan=8>'+tpspinner+'</td></tr></tbody>').insertAfter('#riwayat_kontrak thead');
		},
		success:function(data){
			var footer = '<tr id="row_xx"><td id="nomor_xx">'+data.no+'</td>';
			footer = footer +'<td id="aksi_xx" align=center>...</td><td id="pekerjaan_xx" colspan="7">';
			footer = footer +'<button class="btn btn-primary" type="button" onclick="setSubForm(\'tambah\',\'xx\','+data.no+');"><i class="fa fa-plus fa-fw"></i> Tambah riwayat kontrak</button>';
			footer = footer +'</td></tr>';
			var table = data.kontrak+footer;
			$('#list_riwayat').replaceWith(table);
			gopaging();
		}, // end success
	dataType:"json"}); // end ajax
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
//	var hasil=validasi_isian();
//	if (hasil!=false) {
	$.ajax({
		type:"POST",
		url: $("#form_kontrak").attr('action'),
		data: $("#form_kontrak").serialize(),
		beforeSend:function(){	
			$('.bt_simpan').remove();
		},
		success:function(data){
			baru();
			$('.btn.batal').click();
		}, // end success
		dataType:"html"}); // end ajax
//	} //endif Hasil
}
function validasi_isian(){
	var data="";
	var dati="";
			var iunr = $.trim($("#id_unor").val());
			var skno = $.trim($("#nomor_sk").val());
			var sktgl = $.trim($("#tanggal_sk").val());
			var uraian = $.trim($("#uraian").val());
			data=data+""+iunr+"*"+spno+"**";
			if( iunr ==""){	dati=dati+"UNIT KERJA tidak boleh kosong\n";	}
			if( skno ==""){	dati=dati+"NOMOR SK tidak boleh kosong\n";	}
			if( sktgl ==""){	dati=dati+"TANGGAL SK tidak boleh kosong\n";	}
			if( uraian ==""){	dati=dati+"URAIAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
function hapus(){
	$.ajax({
		type:"POST",
		url: $("#form_kontrak").attr('action'),
		data: $("#form_kontrak").serialize(),
		beforeSend:function(){	
			$('.bt_simpan').remove();
		},
		success:function(data){
			baru();
			$('.btn.batal').click();
		}, // end success
		dataType:"html"}); // end ajax
}
////////////////////////////////////////////////////////////////////////////
</script>