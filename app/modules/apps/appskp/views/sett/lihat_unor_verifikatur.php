<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header" style="margin-bottom:5px;"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12" style="text-align:right;">
		<button class="btn btn-primary" type="button" onclick="kembali(); return false;"><i class="fa fa-fast-backward fa-fw"></i>Kembali...</button>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>Verifikatur</b></div>
			<div class="panel-body">
								<div>
										<div style="float:left; width:110px;">Nama petugas</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$pegawai->nama_pegawai;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:110px;">Username</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$verifikatur->username;?></div></span>
								</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="padding-left:0px;padding-right:10px;">&nbsp;</div>
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">10</option>
</select>
</div>
<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="margin-bottom:5px;">
                            <div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
                                <input id="caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
<div style="float:right; margin:7px 5px 0px 0px;">Cari:</div>
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
<table class="table info table-striped table-bordered table-hover">
<thead>
<tr>
<th style="width:40px;text-align:center; padding:20px 0px 17px 0px;">No.</th>
<th style="width:120px;text-align:center; vertical-align:middle">KODE</th>
<th style="width:320px;text-align:center; vertical-align:middle">NAMA UNIT ORGANISASI</th>
<th style="width:320px;text-align:center; vertical-align:middle">JABATAN STRUKTURAL</th>
</tr>
</thead>
<tbody id=list>
	<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tbody>
</table>
			</div>
			<!-- table-responsive --->
	<div id=paging></div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
<br/><br/>
<script type="text/javascript">
$(document).ready(function(){
	gridpaging(1);
});
function gridpaging(hal){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/sett/verifikatur_lihat_getdata/",
				data:{"hal": hal, "batas": batas,"cari":cari},
				beforeSend:function(){	
					$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
					$('#paging').html('');
				},
				success:function(data){
						if((data.hslquery.length)>0){
						var table="";
						var no=data.mulai;
						$.each( data.hslquery, function(index, item){
							table = table+ "<tr id='row_"+item.id_unor+"'>";
							table = table+ "<td>"+no+"</td>";
							table = table+ "<td>"+item.kode_unor+"</td>";
							table = table+ "<td>"+item.nama_unor+"</td>";
							table = table+ "<td>"+item.nomenklatur_jabatan+"</td>";
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
        dataType:"json"});
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}

function kembali(){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/sett",
			data:{"hal": <?=$hal;?>,"cari":"<?=$cari;?>" },
			beforeSend:function(){	
				$("#page-wrapper").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				$('#page-wrapper').html(data);
			},
			dataType:"html"});
}
</script>
<style>
.modal-wide .modal-dialog {	width: 950px;	}
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>
