<form role="form" id="form_sk_jabatan" action="<?=site_url();?>appbkpp/pegawai/formjabatan_<?=(isset($val->id_peg_jab))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
	<input type=hidden name="id_unor" id="id_unor">
	<input type=hidden name="kode_unor" id="kode_unor">
	<input type=hidden name="nama_unor" id="nama_unor">
	<input type=hidden name="id_jabatan" id="id_jabatan">
	<input type=hidden name="nama_jabatan" id="nama_jabatan">
	<input type=hidden name="nomenklatur_pada" id="nomenklatur_pada">
	<input type=hidden name="kode_ese" id="kode_ese">
	<input type=hidden name="nama_ese" id="nama_ese">
	<div id="tampung" style="display:none;"></div>
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form SK Jabatan</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row prinsip">
			<div class="col-lg-4">
					<div class="form-group">
						<label>TMT Jabatan</label>
						<input type="text" name="tmt_jabatan" id="tmt_jabatan" value="<?=(!isset($val->tmt_jabatan))?'':$val->tmt_jabatan;?>" class="form-control" <?=(isset($hapus))?"disabled":"";?>>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-2-->
			<div class="col-lg-8">
						<label>Unit kerja</label>
						<div id="ipt_unor">
							<?php
							if(isset($hapus)){	echo '<div id="div_unor">'.$val->nama_unor.' <br/><u>pada</u><br/> '.$val->nomenklatur_pada.'</div>';	} else {
							if(!isset($val->id_unor)){
							?>
							<span onclick="pilunor();return false;" id="bt_ipt_unor" style="color:#0000FF;cursor:pointer;"><div id="div_unor">Pilih...</div></span>
							<?php
							} else {
							?>
							<span onclick="pilulang();return false;" id="bt_ipt_unor" style="color:#0000FF;cursor:pointer;"><div id="div_unor"><?=$val->nama_unor;?> <br/><u>pada</u><br/> <?=$val->nomenklatur_pada;?></div></span>
							<?php
							}}
							?>
						</div>
			</div>
			<!--//col-lg-5-->
		</div>
		<!--// row prinsip-->
		<div class="row prinsip2" id="ipt_jabatan" style="padding-top:10px;">
			<div class="col-lg-4">
					<div class="form-group">
						<label>Jenis jabatan</label>
						<select class="form-control" id="nama_jenis_jabatan" name="nama_jenis_jabatan" <?=(!isset($val->nama_jenis_jabatan))?'disabled=""':'';?> onchange="pil_nama();" <?=(isset($hapus))?"disabled":"";?>>
							<option value="">Pilih...</option>
							<option value="js" <?=(isset($val->nama_jenis_jabatan) && $val->nama_jenis_jabatan=="js")?"selected":"";?>>Jabatan Struktural</option>
							<option value="jfu" <?=(isset($val->nama_jenis_jabatan) && $val->nama_jenis_jabatan=="jfu")?"selected":"";?>>Jabatan Fungsional Umum</option>
							<option value="jft" <?=(isset($val->nama_jenis_jabatan) && $val->nama_jenis_jabatan=="jft")?"selected":"";?>>Jabatan Fungsional Tertentu</option>
							<option value="jft-guru" <?=(isset($val->nama_jenis_jabatan) && $val->nama_jenis_jabatan=="jft-guru")?"selected":"";?>>Guru</option>
						</select>
					</div>
			</div>
			<!--col-lg-4-->
			<div class="col-lg-4">
					<div class="form-group">
						<label>Jabatan</label>
						<span><div style="display:table;" id="div_jabatan">
						<?php
							if(isset($hapus)){	echo '<b">'.$val->nama_jabatan.'</b>';	} else {
							if(!isset($val->nama_jabatan)){
						?>
						...
						<?php
						} else {
							if($val->nama_jenis_jabatan=="js"){
								echo "<b>".$val->nama_jabatan."</b>";
							} else {
								echo '<span onclick="pil_nama();return false;" style="color:#0000FF;cursor:pointer;">'.$val->nama_jabatan.'</span>';
							}
						}}
						?>
						</div></span>
					</div>
			</div>
			<!--col-lg-4-->
		</div>
		<!--//row-->
		<div class="row" style="padding-top:10px;">
			<div class="col-lg-4">
					<div class="form-group">
						<label>Nomor SK</label>
						<input type="text" class="form-control" id="sk_nomor" name="sk_nomor" value="<?=(!isset($val->sk_nomor))?'':$val->sk_nomor;?>" <?=(isset($hapus))?"disabled":"";?>>
					</div>
			</div>
			<!--col-lg-4-->
			<div class="col-lg-4">
					<div class="form-group">
						<label>Tanggal SK</label>
						<input type="text" class="form-control" id="sk_tanggal" name="sk_tanggal" value="<?=(!isset($val->sk_tanggal))?'':$val->sk_tanggal;?>" placeholder="dd-mm-yyyy" <?=(isset($hapus))?"disabled":"";?>>
					</div>
			</div>
			<!--col-lg-4-->
			<div class="col-lg-4">
					<div class="form-group">
						<label>Tugas tambahan</label>
						<?=form_dropdown('tugas_tambahan',$this->dropdowns->tugas_tambahan(),(!isset($val->tugas_tambahan))?'':$val->tugas_tambahan,(isset($hapus))?'class="form-control" disabled':'class="form-control"');?>
					</div>
			</div>
			<!--col-lg-4-->
		</div>
		<!--// row -->
<?php if(isset($val->id_peg_jab)){	?>
			<input type=hidden name="id_peg_jab" id="id_peg_jab" value="<?=$val->id_peg_jab;?>">
<?php	}	?>
				<?=form_hidden('id_pegawai',$val->id_pegawai);?>
				<div class="row"><div class="col-lg-12" style="padding-top:10px;">
			        <button type="submit" class="btn btn-<?=(isset($hapus))?"danger":"primary";?>" onclick="simpan();return false;"><i class="fa fa-save fa-fw"></i> <?=(isset($hapus))?"Hapus":"Simpan";?></button>
					<button class="btn btn-default" type="button" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i> Batal...</button>
				</div></div>

	</div>
	<!-- /.panel-body -->
</div>
<!-- /.panel -->
      </form>
<?php if(isset($val->id_unor)){	?>
<script type="text/javascript">
$(document).ready(function(){
	$('#kode_ese').val('<?=$val->kode_ese;?>');
	$('#nama_ese').val('<?=$val->nama_ese;?>');
	$('#div_unor').html('<?=$val->nama_unor;?><br/><u>pada</u><br/><?=$val->nomenklatur_pada;?><div style="display:hidden;" id="pre_jabatan"><?=$val->nama_jab_struk;?></div><div style="display:none;" id="pre_kese"><?=$val->kode_ese;?></div><div style="display:none;" id="pre_nese"><?=$val->nama_ese;?></div>');
	$('#id_unor').val('<?=$val->id_unor;?>');
	$('#kode_unor').val('<?=$val->kode_unor;?>');
	$('#nama_unor').val('<?=$val->nama_unor;?>');
	$('#nama_jabatan').val('<?=$val->nama_jabatan;?>');
	$('#nomenklatur_pada').val('<?=$val->nomenklatur_pada;?>');
});
</script>
<?php	}	?>

<script type="text/javascript">
function pilunor(){
	$('#id_unor').val('');
	$('#nama_unor').val('');
	$('#kode_unor').val('');
	$('#nama_ese').val('');
	$('#kode_ese').val('');
	$('#id_jabatan').val('');
	$('#nama_jabatan').val('');
	if($('#tmt_jabatan').val()!=""){
		$('.sub').remove();
		var table ='<div class="table-responsive sub" id="row_tt"><table class="table"><tr class="success"><td colspan="7">';
		table = table + '<div class="row">';
			table = table + '<div class="col-lg-6">';
				table = table + '<div style="float:left;">';
					table = table + '<select class="form-control input-sm" id="item_lengthB" style="width:70px;" onchange="gridpagingB(1)">';
						table = table + '<option value="10" selected>10</option>';
						table = table + '<option value="25">25</option>';
						table = table + '<option value="50">50</option>';
						table = table + '<option value="100">100</option>';
					table = table + '</select>';
				table = table + '</div>';
				table = table + '<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>';
			table = table + '</div>'; //col-lg-6
			table = table + '<div class="col-lg-6">';
				table = table + '<div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">';
					table = table + '<input id="caripagingB" onchange="gridpagingB(1)" type="text" class="form-control" placeholder="Masukkan kata kunci...">';
					table = table + '<span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span></div><div style="float:right; margin:7px 0px 0px 0px;">Cari:</div></div></div>';
				table = table + '</div>';//input group
			table = table + '</div>';  // col-lg-6
		table = table + '</div>';  // row

		table = table + '<div class="row">';
			table = table + '<div class="col-lg-12">';

						table = table + '<table class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">';
						table = table + '<thead>';
						table = table + '<tr>';
						table = table + '<th style="width:30px;text-align:center; vertical-align:middle">Pilih</th>';
						table = table + '<th style="width:105px;text-align:center; vertical-align:middle">KODE</th>';
						table = table + '<th style="width:250px;text-align:center; vertical-align:middle">NAMA UNIT KERJA</th>';
						table = table + '<th style="width:390px;text-align:center; vertical-align:middle">ESELON</th>';
						table = table + '</tr>';
						table = table + '</thead>';
						table = table + '<tbody id=listB><tr><td colspan="7"><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr></tbody>';
						table = table + '</table>';

			table = table + '</div>';  // col-lg-12
		table = table + '</div>';  // row
		table = table + '<div id="pagingB"></div>';
		table = table + '</td></tr></table></div>';
		$('#id_unor').val('');
		$('#bt_ipt_unor').attr("onclick","tutup_ulang();");
		$(table).insertAfter('.prinsip');
		gridpagingB(1);
	} else {
		alert ("TMT JABATAN harap diisi dulu...");
	}
}

function tutup_unor(){
	$('#bt_ipt_unor').attr("onclick","pilunor();return false;");
	$('.sub').remove();
}
function pilulang(){
	var jbt = $('#div_jabatan').html();
	$('#bt_ipt_unor').attr("onclick","tutup_ulang();return false;");
	$('#tampung').html(jbt);
	$('#nama_jenis_jabatan').attr('disabled','');
	$('#div_jabatan').html('');
	pilunor();
}
function tutup_ulang(){
	var jbt = $('#tampung').html();
	$('#bt_ipt_unor').attr("onclick","pilulang();return false;");
	$('#div_jabatan').html(jbt);
	$('#nama_jenis_jabatan').removeAttr('disabled');
	$('.sub').remove();
}


function gridpagingB(hal){
var cari = $('#caripagingB').val();
var batas = $('#item_lengthB').val();
var tanggal = $('#tmt_jabatan').val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/unor/getdata",
		data:{"hal": hal, "batas": batas,"tanggal":tanggal,"cari":cari,"kehal":"pagingB"},
		beforeSend:function(){	
			$('#listB').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
			$('#pagingB').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					table = table+ "<tr id='row_"+item.id_unor+"'>";
					table = table+ '<td style="padding:3px;text-align:center;"><div class="btn btn-success btn-xs pilih" data-idd="'+item.id_unor+'" data-nama="'+item.nama_unor+'" data-kode="'+item.kode_unor+'" data-pada="'+item.nomenklatur_pada+'" data-jab="'+item.nomenklatur_jabatan+'" data-kese="'+item.kode_ese+'" data-nese="'+item.nama_ese+'"><i class="fa fa-check fa-fw"></i></td>';
					table = table+ "<td style='padding:3px;'>"+item.kode_unor+"</td>";
					table = table+ "<td style='padding:3px;'>"+item.nama_unor+"</td>";
					table = table+ "<td style='padding:3px;'><div id='kol_2_"+item.id_unor+"'>" +item.nama_ese+", <u>pada</u>:<br />"+item.nomenklatur_pada+"</div></td>";
					table = table+ "</tr>";
					no++;
				}); //endeach
					$('#listB').html(table);
					$('#pagingB').html(data.pager);
			} else {
				$('#listB').html('<tr><td colspan=5 align=center><b>Tidak ada data</b></td></tr>');
				$('#pagingB').html("");
			} // end if
		}, // end success
	dataType:"json"}); // end ajax
}
function gopagingB(){
	var gohal=$("#inputpagingB").val();
	gridpagingB(gohal);
}
$(document).on('click', '.btn.pilih',function(){
	var nama_unor = $(this).attr('data-nama');
	var kode_unor = $(this).attr('data-kode');
	var nama_pada = $(this).attr('data-pada');
	var id_unor = $(this).attr('data-idd');
	var nama_jab = $(this).attr('data-jab');
	var kese = $(this).attr('data-kese');
	var nese = $(this).attr('data-nese');
	$('#kode_ese').val($(this).attr('data-kese'));
	$('#nama_ese').val($(this).attr('data-nese'));
	$('#div_unor').html(nama_unor+'<br/><u>pada</u><br/>'+nama_pada+'<div style="display:hidden;" id="pre_jabatan">'+nama_jab+'</div><div style="display:none;" id="pre_kese">'+kese+'</div><div style="display:none;" id="pre_nese">'+nese+'</div>');
	$('#id_unor').val(id_unor);
	$('#kode_unor').val(kode_unor);
	$('#nama_unor').val(nama_unor);
	$('#nama_jabatan').val('');
	$('#nomenklatur_pada').val(nama_pada);
	$('.sub').remove();
	$('#bt_ipt_unor').attr("onclick","pilulang();");
	$('#div_jabatan').html('');
	$('#nama_jenis_jabatan').removeAttr("disabled").html('<option value="">Pilih...</option><option value="js">Jabatan Struktural</option><option value="jfu">Jabatan Fungsional Umum</option><option value="jft">Jabatan Fungsional Tertentu</option><option value="jft-guru">Guru</option>');
});
function pil_nama(){
	$('.sub').remove();
	$('#div_jabatan').html('');
	$('#id_jabatan').val('');
	var jn_jabatan = $('#nama_jenis_jabatan').val();
	if(jn_jabatan==""){
		$('#nama_jabatan').val('');
	}
	if(jn_jabatan=="js"){
		var pre_jab = $('#pre_jabatan').html();
		var pre_kese = $('#pre_kese').html();
		var pre_nese = $('#pre_nese').html();
		$('#div_jabatan').html('<b>'+pre_jab+'</b>');
		$('#nama_jabatan').val(pre_jab);
		$('#kode_ese').val(pre_kese);
		$('#nama_ese').val(pre_nese);
//		$('#kode_bkn').val('');
	}
	if(jn_jabatan=="jfu" || jn_jabatan=="jft" || jn_jabatan=="jft-guru"){
		pil_jf();
		$('#nama_jabatan').val('');
		$('#kode_bkn').val('');
	}
}

function pil_jf(){
		$('.sub').remove();
//		var table ='<tr id="row_tt" class="success sub"><td colspan="7">';
		var table ='<div class="table-responsive sub" id="row_tt"><table class="table"><tr class="success"><td colspan="7">';
		table = table + '<div class="row">';
			table = table + '<div class="col-lg-6">';
				table = table + '<div style="float:left;">';
					table = table + '<select class="form-control input-sm" id="item_lengthC" style="width:70px;" onchange="gridpagingC(1)">';
						table = table + '<option value="10" selected>10</option>';
						table = table + '<option value="25">25</option>';
						table = table + '<option value="50">50</option>';
						table = table + '<option value="100">100</option>';
					table = table + '</select>';
				table = table + '</div>';
				table = table + '<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>';
			table = table + '</div>'; //col-lg-6
			table = table + '<div class="col-lg-6">';
				table = table + '<div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">';
					table = table + '<input id="caripagingC" onchange="gridpagingC(1)" type="text" class="form-control" placeholder="Masukkan kata kunci...">';
					table = table + '<span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span></div><div style="float:right; margin:7px 0px 0px 0px;">Cari:</div></div></div>';
				table = table + '</div>';//input group
			table = table + '</div>';  // col-lg-6
		table = table + '</div>';  // row

		table = table + '<div class="row">';
			table = table + '<div class="col-lg-12">';

						table = table + '<table class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">';
						table = table + '<thead>';
						table = table + '<tr>';
						table = table + '<th style="width:30px;text-align:center; vertical-align:middle">Pilih</th>';
						table = table + '<th style="width:120px;text-align:center; vertical-align:middle">KODE</th>';
						table = table + '<th style="width:550px;text-align:center; vertical-align:middle">NAMA JABATAN FUNGSIONAL UMUM</th>';
						table = table + '</tr>';
						table = table + '</thead>';
						table = table + '<tbody id=listC><tr><td colspan="7"><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr></tbody>';
						table = table + '</table>';

			table = table + '</div>';  // col-lg-12
		table = table + '</div>';  // row
		table = table + '<div id="pagingC"></div>';
		table = table + '</td></tr></table></div>';
		$(table).insertAfter('.prinsip2');
		gridpagingC(1);

}
function gridpagingC(hal){
var cari = $('#caripagingC').val();
var batas = $('#item_lengthC').val();
var jenis = $('#nama_jenis_jabatan').val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/getjfu",
		data:{"hal": hal, "batas": batas,"cari":cari,"jenis":jenis,"kehal":"pagingC"},
		beforeSend:function(){	
			$('#listC').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
			$('#pagingB').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					if(item.kode_bkn==null){	var kode_bkn="-";	} else {	var kode_bkn=item.kode_bkn;	}					
					table = table+ "<tr id='row_"+item.id_jabatan+"'>";
					table = table+ '<td style="padding:3px;text-align:center;"><div class="btn btn-success btn-xs pilih_jf" data-idd="'+item.id_jabatan+'" data-nama="'+item.nama_jabatan+'" data-kode="'+kode_bkn+'"><i class="fa fa-check fa-fw"></i></td>';
					table = table+ "<td style='padding:3px;'>"+kode_bkn+"</td>";
					table = table+ "<td style='padding:3px;'>"+item.nama_jabatan+"</td>";
					table = table+ "</tr>";
					no++;
				}); //endeach
					$('#listC').html(table);
					$('#pagingC').html(data.pager);
			} else {
				$('#listC').html('<tr><td colspan=5 align=center><b>Tidak ada data</b></td></tr>');
				$('#pagingC').html("");
			} // end if
		}, // end success
	dataType:"json"}); // end ajax
}
function gopagingC(){
	var gohal=$("#inputpagingC").val();
	gridpagingC(gohal);
}
$(document).on('click', '.btn.pilih_jf',function(){
	var id_jabatan = $(this).attr('data-idd');
	var kode = $(this).attr('data-kode');
	var nama_jabatan = $(this).attr('data-nama');
	$('#id_jabatan').val(id_jabatan);
	$('#nama_jabatan').val(nama_jabatan);
//	$('#kode_bkn').val(kode);
	$('#kode_ese').val("99");
	$('#nama_ese').val("Non Eselon");

	$('#div_jabatan').html('<span onclick="pil_nama();return false;" style="color:#0000FF;cursor:pointer;">'+nama_jabatan+'</span>');
	$('.sub').remove();
});


</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}

.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>

