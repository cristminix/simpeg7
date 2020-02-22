<div class="row">
	<div class="col-lg-12" style="margin-bottom:25px;">
		<h3 class="page-header" style="margin-bottom:5px;">Setting Pengguna</h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<i class="fa fa-list fa-fw"></i> <?=$satu;?>
								</div>
								<div class="col-lg-6">
<div class="btn-group pull-right">
		<a href="<?=site_url('admin/module/appskp/sett');?>" class="btn btn-primary btn-xs"><i class="fa fa-fast-backward fa-fw"></i>Kembali...</a>
</div>
								</div>
						</div>
			</div>
			<div class="panel-body" style="padding-left:5px;padding-right:5px;">
<div class="row">
	<div class="col-lg-6" style="margin-bottom:5px;">
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
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
<th style="width:120px;text-align:center; vertical-align:middle">KODE</th>
<th style="width:320px;text-align:center; vertical-align:middle">NAMA UNIT ORGANISASI</th>
<th style="width:320px;text-align:center; vertical-align:middle">JABATAN STRUKTURAL</th>
<th style="text-align:center; vertical-align:middle">VERIFIKATUR<br/>USERNAME</th>
</tr>
</thead>
<tbody id=list>
</tbody>
</table>
			</div>
			<!-- table-responsive --->
	<div id=paging></div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
		<!-- Modal -->
		<div class="modal fade modal-wide" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close fa-fw"></i> Batal...</button>
                                        </div>
	                                    <!-- /.modal-footer -->
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
			</form>
		</div>
		<!-- /.modal -->

<div id='jj' style="display:none">0</div>
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
				url:"<?=site_url();?>appskp/sett/getakses/",
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
				table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.kode_unor+"</td>";
				table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.nama_unor+"</td>";
				table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.nomenklatur_jabatan+"</td>";
				table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.nama_pegawai+"<br/>"+item.username+"<div style='display:none' id='userid_"+item.id_unor+"'>"+item.user_id+"</div></td>";
				table = table+ "</tr>";
			no++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
			$('#paging').html("");
		} // end if
			$("#tb_pilih").replaceWith("<input type=checkbox onchange='pilih_semua();' id='tb_pilih'>");
		}, // end success
        dataType:"json"});
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
</script>
<style>
.modal-wide .modal-dialog {	width: 950px;	}
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>
