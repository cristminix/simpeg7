  <div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<i class="fa fa-edit fa-fw"></i> <b>Daftar Pegawai Keluar</b>
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
	<div class="col-lg-6" style="margin-bottom:5px;">
<div style="float:left;">
<select class="form-control input-sm" id="item_lengthB" style="width:70px;" onchange="gridpagingB('end')">
<option value="10" <?=($batas==10)?"selected":"";?>>10</option>
<option value="25" <?=($batas==25)?"selected":"";?>>25</option>
<option value="50" <?=($batas==50)?"selected":"";?>>50</option>
<option value="100" <?=($batas==100)?"selected":"";?>>100</option>
</select>
</div>
<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="margin-bottom:5px;">
                            <div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
                                <input id="caripagingB" onchange="gridpagingB('end')" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="<?=$cari;?>">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
<div style="float:right; margin:7px 0px 0px 0px;">Cari:</div>
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<div class="row jabatan" id="grid-data">
	<div class="col-lg-12">
		<div class="table-responsive">
<form id="form_sub" method="post" enctype="multipart/form-data">
<table class="table table-striped table-bordered table-hover" style="width:1024px;">
<thead id=gridhead>
<tr>
<th style="width:35px;text-align:center; vertical-align:middle">No.</th>
<th style="width:30px;text-align:center; vertical-align:middle;padding:0px;">AKSI</th>
<th style="width:250px;text-align:center; vertical-align:middle">NAMA PEGAWAI ( GENDER )<br />NIP / PANGKAT TERAKHIR</th>
<th style="width:300px;text-align:center; vertical-align:middle">JABATAN TERAKHIR</th>
<th style="text-align:center; vertical-align:middle">KETERANGAN</th>
</tr>
</thead>
<tbody>
<tr id='brow_xx'>
<td id='nomor_xx'>xx</td>
<td id='aksi_xx' align=center>...</td>
<td id='pekerjaan_xx' colspan="3">
<button class="btn btn-primary" type="button" onclick="setSubForm('tambah','xx','xx');"><i class="fa fa-plus fa-fw"></i> Tambah pegawai keluar</button>
</td>
</tr>
<tbody>
</table>
</form>
	<div id=pagingB></div>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row jabatan #grid-data-->

						<div class="row">
								<div class="col-lg-12" style="padding-top:10px;">
									<div class="btn-group pull-right">
									<button class="btn btn-primary" type="button" onclick="batal();"><i class="fa fa-fast-backward fa-fw"></i> Kembali</button>
									</div>
								</div>
								<!--//col-lg-12-->
						</div>
						<!--//row-->




			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->

<script type="text/javascript">
$(document).ready(function(){
	gridpagingB('end');
});
function gridpagingB(hal){
			$('#brow_xx').attr('id','sbrow_xx');
			$("[id^='brow_']").each(function(key,val) {	$(this).remove();	});
			$('<tr id="listB"><td colspan="5">...</td></tr>').insertBefore('#sbrow_xx');
			$('#sbrow_xx').attr('id','brow_xx');
var cari = $('#caripagingB').val();
var batas = $('#item_lengthB').val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/getsub_keluar",
		data:{"hal": hal, "batas": batas,"sub":"keluar","cari":cari,"kehal":"pagingB"},
		beforeSend:function(){	
			$('#listB').html('<td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td>');
			$('#pagingB').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					table = table+ "<tr id='brow_"+item.id_pegawai+"'>";
					table = table+ "<td style='padding:3px;'>"+no+"</td>";
	//tombol aksi-->
					table = table+ "<td valign=top style='padding:3px 0px 0px 0px;' align=center>";
						table = table+ '<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
						table = table+ '<ul class="dropdown-menu" role="menu">';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm(\'edit\',\''+item.id_pegawai +'\',\''+no+'\');"><i class="fa fa-edit fa-fw"></i> Edit Data</a></li>';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSubForm(\'hapus\',\''+item.id_pegawai +'\',\''+no+'\');"><i class="fa fa-trash fa-fw"></i> Hapus Data</a></li>';
						table = table+ "</ul>";
						table = table+ "</div>";
					table = table+ "</td>";
	//tombol aksi<--
					table = table+ "<td style='padding:3px;'>"+item.nama_pegawai+" ("+item.gender+")<br/>"+item.nip_baru+"<br/>"+item.nama_pangkat+" / "+item.nama_golongan+"</td>";
					table = table+ "<td style='padding:3px;'>"+item.nomenklatur_jabatan+" <br><u>pada</u>:<br />"+item.nomenklatur_pada+"</div></td>";
					table = table+ "<td style='padding:3px;'>";
					table = table+ "<div>";
					table = table+ '<div style="float:left; width:130px;">TMT keluar</div>';
					table = table+ '<div style="float:left; width:10px;">:</div>';
					table = table+ '<div style="float:left;">'+item.tanggal_keluar+'</div>';
					table = table+ '</div>';
					table = table+ '<div style="clear:both;">';
					table = table+ '<div style="float:left; width:130px;">No. SK Pindah</div>';
					table = table+ '<div style="float:left; width:10px;">:</div>';
					table = table+ '<div style="float:left;">'+item.no_sk+'</div>';
					table = table+ '</div>';
					table = table+ '<div style="clear:both;">';
					table = table+ '<div style="float:left; width:130px;">Tanggal SK Pindah</div>';
					table = table+ '<div style="float:left; width:10px;">:</div>';
					table = table+ '<div style="float:left;">'+item.tanggal_sk+'</div>';
					table = table+ '</div>';
					table = table+ '<div style="clear:both;">';
					table = table+ '<div style="float:left; width:130px;">Instansi tujuan</div>';
					table = table+ '<div style="float:left; width:10px;">:</div>';
					table = table+ '<div style="float:left;">'+item.instansi_tujuan+'</div>';
					table = table+ '</div>';
					table = table+ "</td>";
					table = table+ "</tr>";
					no++;
				}); //endeach
					$('#listB').replaceWith(table);
					$('#pagingB').html(data.pager);
			} else {
				$('#listB').html('<td colspan=5 align=center><b>Tidak ada data</b></td>');
				$('#pagingB').html("");
			} // end if
		}, // end success
	dataType:"json"}); // end ajax
}
function gopagingB(){
	var gohal=$("#inputpagingB").val();
	gridpagingB(gohal);
}
function setSubForm(aksi,idd,no){
	$('.btn.batal').click();
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/formsub_keluar_"+aksi,
		data:{"idd": idd,"nomor":no,"sub":"keluar" },
		beforeSend:function(){
			$('#brow_'+idd).addClass('success');
			$('<tr id="brow_tt" class="success"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td></tr>').insertAfter('#brow_'+idd);
		},
        success:function(data){
			$('#form_sub').attr('action','<?=site_url("appbkpp/pegawai/formsub_keluar_");?>'+aksi+'_aksi');
			$('#brow_'+idd).hide();
			$('#brow_tt').replaceWith(data);
		},
        dataType:"html"});
}
function simpan(){
	var idm = $('#id_pegawai').val();
	if(idm){
		var hasil=validasi_isian();
		if (hasil!=false) {
				$.ajax({
					type:"POST",
					url: $("#form_sub").attr('action'),
					data: $("#form_sub").serialize(),
					beforeSend:function(){	
						$('.bt_simpan').remove();
					},
					success:function(data){
						setForm('sub','keluar');
						gopaging();
					}, // end success
					dataType:"html"}); // end ajax
		} //endif Hasil
	} else {
		alert("Pegawai harus diisi...!");
	}
}

function validasi_isian(){
	var data="";
	var dati="";
			var tgmg = $.trim($("#tanggal_keluar").val());
			var tpmg = $.trim($("#no_sk").val());
			var tgsk = $.trim($("#tanggal_sk").val());
			var jnps = $.trim($("#instansi_tujuan").val());
			data=data+""+tpmg+"*"+tgmg+"**";
			if( tgmg ==""){	dati=dati+"TMT KELUAR tidak boleh kosong\n";	}
			if( tpmg ==""){	dati=dati+"NO SK PINDAH tidak boleh kosong\n";	}
			if( tgsk ==""){	dati=dati+"TANGGAL SK PINDAH tidak boleh kosong\n";	}
			if( jnps ==""){	dati=dati+"INSTANSI TUJUAN tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}

$(document).on('click', '.btn.batal',function(){
	$("[id='brow_tt']").each(function(key,val) {	$(this).remove();	});
	$("[id^='brow_']").removeClass().show();
	$('#simpan').html('');
});

</script>