<link href="<?php echo base_url();?>assets/css/bootcomplete.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/plugins/jquery.bootcomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-datepicker/js/moment.min.js"></script>
<link href="<?php echo base_url();?>assets/bootstrap-datepicker/css/daterangepicker.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/bootstrap-datepicker/js/daterangepicker.js"></script>


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<i class="fa fa-edit fa-fw"></i> <b>Form Cuti Pegawai</b>
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
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
				<form id="formCuti" onsubmit="return simpan(); return false;" method="POST">
				  <div class="form-group">
					<label for="nip">Nama Pegawai:</label>
					<input type="text" name="nip" class="form-control" id="nip">
				  </div>
				  <div class="form-group">
					<label for="tgl_cuti">Tanggal Cuti:</label>
					<input id="iptTanggal" name="tgl_cuti" value="" class="form-control" type="text"  style="float:left;">
				  </div>
				  <div class="form-group">
					<label for="remarks">Keterangan:</label>
					<textarea class="form-control" id="remarks" name="remarks"></textarea>
				  </div>
				  <button class="btn btn-success"><i class='fa fa-save'></i> Simpan</button>
				</form>				
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->

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


$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	$("[id^='row_']").removeClass().show();
	$('#simpan').html('');
});
  $(function() {
	$('#nip').bootcomplete({
        url		:'<?php echo base_url();?>widget/pegawaiList',
		method	:'post'
    });
	
	$('input[name="tgl_cuti"]').daterangepicker({
		locale: {
			format: 'YYYY/MM/DD'
		}
	});
  });
function setSubForm(aksi,idd,no){
	$('.btn.batal').click();

		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/formpangkat_"+aksi,
		data:{"idd": idd,"nomor":no },
		beforeSend:function(){
			$('#row_'+idd).addClass('success');
			$('<tr id="row_tt" class="success"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td></tr>').insertAfter('#row_'+idd);
		},
        success:function(data){
			$('#form_pangkat').attr('action','<?=site_url("appbkpp/pegawai/formpangkat_");?>'+aksi+'_aksi');
			$('#row_'+idd).hide();
			$('#row_tt').replaceWith(data);
		},
        dataType:"html"});
}
////////////////////////////////////////////////////////////////////////////
function baru(){
	$.ajax({
		type:"POST",
		url: "<?=site_url();?>appbkpp/pegawai/pangkat_riwayat",
		data: $("#form_pangkat").serialize(),
		beforeSend:function(){
			$('#riwayat_pangkat tbody').remove();
			$('<tbody><tr id="list_riwayat"><td colspan=7><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr></tbody>').insertAfter('#riwayat_pangkat thead');
		},
		success:function(data){
			var footer = '<tr id="row_xx"><td id="nomor_xx">'+data.no+'</td>';
			footer = footer +'<td id="aksi_xx" align=center>...</td><td id="pekerjaan_xx" colspan="7">';
			footer = footer +'<button class="btn btn-primary" type="button" onclick="setSubForm(\'tambah\',\'xx\','+data.no+');"><i class="fa fa-plus fa-fw"></i> Tambah riwayat kepangkatan</button>';
			footer = footer +'</td></tr>';
			var table = data.pangkat+footer;
			$('#list_riwayat').replaceWith(table);
			gopaging();
		}, // end success
	dataType:"json"}); // end ajax
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
	$.ajax({
		type:"POST",
		url: "<?php echo base_url();?>widget/upCuti",
		data: $("#formCuti").serialize(),
		beforeSend:function(){	
			$('.bt_simpan').remove();
			if($("input[name='nip']").val()==""){
				alert("Harap pilih pegawai");
				return false;
			}else if($("input[name='tgl_cuti']").val()==""){
				alert("Harap pilih tanggal cuti");
				return false;
			}else if($("textarea[name='remarks']").val()==""){
				alert("Harap masukkan keterangan");
				return false;
			}
		},
		success:function(data){
			batal();
		},
		dataType:"html"}); 
	
	return false;
}
function validasi_isian(){
	var data="";
	var dati="";
			var iunr = $.trim($("#id_unor").val());
			var nkjb = $.trim($("#nama_jabatan").val());
			var sknr = $.trim($("#sk_nomor").val());
			var sktg = $.trim($("#sk_tanggal").val());
			var skpj = $.trim($("#sk_pejabat").val());
			data=data+""+iunr+"*"+nkjb+"**";
			if( iunr ==""){	dati=dati+"UNIT KERJA tidak boleh kosong\n";	}
			if( sknr ==""){	dati=dati+"NOMOR SK tidak boleh kosong\n";	}
			if( sktg ==""){	dati=dati+"TANGGAL SK tidak boleh kosong\n";	}
			// if( skpj ==""){	dati=dati+"PENANDATANGAN SK tidak boleh kosong\n";	}
			if( nkjb ==""){	dati=dati+"JABATAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
function hapus(){
	$.ajax({
		type:"POST",
		url: $("#form_pangkat").attr('action'),
		data: $("#form_pangkat").serialize(),
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