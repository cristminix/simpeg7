<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="content-wrapper" style="padding-bottom:30px;">
<div class="row" style="padding-bottom:5px;">
	<div class="col-lg-12">
		<div class="btn-group pull-right">
			<a class="btn btn-primary btn-xs" href="<?=site_url('admin/module/appbkpp/pegawai/aktif');?>"><i class="fa fa-fast-backward fa-fw"></i> Kembali</a>
		</div>
	</div>
</div>
<div class="row">
		<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
   			<div class="row">
				<div class="col-lg-6">
  					<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-arrows-alt fa-fw"></span></button>
  						<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuT">
  							<li><a href="#" onClick="setForm('sub','penambahan');return false;"><i class="fa fa-bookmark fa-fw"></i> Penambahan Pegawai</a></li>
  							<!-- <li><a href="#"><i class="fa fa-star-half-o fa-fw"></i> Pengangkatan CPNS</a></li>
  							<li><a href="<?=site_url('admin/module/appbkpp/pegawai/injek_k2');?>"><i class="fa fa-flash fa-fw"></i> Inject K2</a></li> -->
  						</ul>
  						Daftar Master Pegawai (Aktif & Non-Aktif)
  					</div>
				</div>
   			</div>
		</div>
		<div class="panel-body" style="padding-left:5px;padding-right:5px;">

<div class="row">
	<div class="col-lg-6" style="margin-bottom:5px;">
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
<option value="10" <?=($batas == 10) ? "selected" : "";?>>10</option>
<option value="25" <?=($batas == 25) ? "selected" : "";?>>25</option>
<option value="50" <?=($batas == 50) ? "selected" : "";?>>50</option>
<option value="100" <?=($batas == 100) ? "selected" : "";?>>100</option>
</select>
</div>
<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="margin-bottom:5px;">
                            <div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
                                <input id="caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="<?=$cari;?>">
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

			<div class="table-responsive">
<form id="form_sub" method="post" enctype="multipart/form-data">
<table class="table table-striped table-bordered table-hover" style="width:1024px;">
<thead>
<tr>
<th style="width:35px;text-align:center; vertical-align:middle">No.</th>
<th style="width:30px;text-align:center; vertical-align:middle;padding:0px;">AKSI</th>
<th style="width:350px;text-align:center; vertical-align:middle">NAMA PEGAWAI</th>
<th style="width:150px;text-align:center; vertical-align:middle">GENDER</th>
<th style="width:350px;text-align:center; vertical-align:middle">TEMPAT, TANGGAL LAHIR</th>
<th style="width:150px;text-align:center; vertical-align:middle">NIP</th>
</tr>
</thead>
<tbody id=list>
</tbody>
</table>
</form>
			</div>
			<!-- table-responsive --->
	<div id=paging></div>
		</div>
	</div>
		</div>
		<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.content -->
<div id="form-wrapper" style="padding-bottom:30px; display:none;">
</div>

<script type="text/javascript">
$(document).ready(function(){
	gridpaging(<?=$hal;?>);
});
function gridpaging(hal){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/getdata",
		data:{"hal": hal, "batas": batas,"cari":cari},
		beforeSend:function(){
			
			$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></p></td></tr>');
			$('#paging').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					table = table+ "<tr id='row_"+no+"'>";
					table = table+ "<td style='padding:3px;'>"+no+"</td>";
	//tombol aksi-->
					table = table+ "<td valign=top style='padding:3px 0px 0px 0px;' align=center>";
						table = table+ '<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
						table = table+ '<ul class="dropdown-menu" role="menu">';
						if(item.status!="pensiun" && item.status!="meninggal"){
							table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSub(\'pensiun\',\''+item.id_pegawai +'\',\''+no+'\');"><i class="fa fa-trophy fa-fw"></i> Set Pegawai Pensiun</a></li>';
							table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSub(\'meninggal\',\''+item.id_pegawai +'\',\''+no+'\');"><i class="fa fa-fire fa-fw"></i> Set Pegawai Meninggal Dunia</a></li>';
							table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSub(\'keluar\',\''+item.id_pegawai +'\',\''+no+'\');"><i class="fa fa-external-link fa-fw"></i> Set Pegawai Keluar</a></li>';
							table = table+ '<li role="presentation" class="divider">';
						}
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onclick="setSub(\'lihat\',\''+item.id_pegawai +'\',\''+no+'\');"><i class="fa fa-binoculars fa-fw"></i> Lihat Rincian Data Pegawai</a></li>';
						table = table+ "</ul>";
						table = table+ "</div>";
					table = table+ "</td>";
	//tombol aksi<--
					table = table+ "<td style='padding:3px;'>"+item.nama_pegawai+"</td>";
					table = table+ "<td style='padding:3px;'>"+item.gender+"</td>";
					table = table+ "<td style='padding:3px;'>"+item.tempat_lahir+", "+item.tanggal_lahir+"</td>";
					table = table+ "<td style='padding:3px;'>"+item.nip_baru+"</td>";
					table = table+ "</tr>";
					no++;
				}); //endeach
					$('#list').html(table);
					$('#paging').html(data.pager);
			} else {
				$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");
			} // end if
		}, // end success
	dataType:"json"}); // end ajax
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
function setForm(aksi,idd){
var cari = $('#a_caripaging').val();
var batas = $('#item_length').val();
var hal=$("#inputpaging").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/form"+aksi,
		data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd},
		beforeSend:function(){
			$('#content-wrapper').hide();
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></p>').show();
		},
		success:function(data){
			
			$('#form-wrapper').html(data);
		}, // end success
	dataType:"html"}); // end ajax
}



function setFormDD(aksi,idd){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
var hal=$("#inputpaging").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/unor/form"+aksi,
		data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd},
		beforeSend:function(){
			$('#content-wrapper').hide();
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></p>').show();
		},
		success:function(data){
			$('#form-wrapper').html(data);
		}, // end success
	dataType:"html"}); // end ajax
}
function batal(aksi,idd){
	$('#content-wrapper').show();
	$('#form-wrapper').hide();
}
function setSub(aksi,idd,no){
	$('.btn.batal').click();
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/pegawai/formsub_"+aksi,
		data:{"sub":aksi,"idd": idd,"nomor":no },
		beforeSend:function(){
			$('#row_'+no).addClass('success');
			$('<tr id="row_tt" class="success"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i></p></td></tr>').insertAfter('#row_'+no);
		},
        success:function(data){
			
			$('#form_sub').attr('action','<?=site_url("appbkpp/pegawai/formsub_");?>'+aksi+'_aksi');
			$('#row_tt').replaceWith(data);
		},
        dataType:"html"});
}

$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	$("[id^='row_']").removeClass().show();
});
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>