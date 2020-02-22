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
		<div class="panel panel-default" id='id_petugas'>
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>PENGELOLA KEPEGAWAIAN</b></div>
			<div class="panel-body">
								<div>
										<div style="float:left; width:110px;">Nama pengelola</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$pengelola->nama_user;?></div></span>
								</div>
								<div style="clear:both">
										<div style="float:left; width:110px;">Username</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$pengelola->username;?></div></span>
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
<th style="width:30px;text-align:center; padding:20px 0px 17px 0px;">
		<div class="dropdown" id="btMenu">
			<button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenu" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu">
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="set_pengelola();"><i class="fa fa-edit fa-fw"></i>Set Pengelola</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="pilih_semua(); return false;"><i class="fa fa-sitemap fa-fw"></i>Pilih Semua</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="batal_semua();"><i class="fa fa-trash fa-fw"></i>Batal semua</a></li>
			</ul>
		</div>
</th>
<th style="width:120px;text-align:center; vertical-align:middle">KODE</th>
<th style="width:380px;text-align:center; vertical-align:middle">NAMA UNIT ORGANISASI</th>
<th style="width:380px;text-align:center; vertical-align:middle">JABATAN STRUKTURAL</th>
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
		<!-- Modal -->
		<div class="modal fade modal-wide" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<form id="modal-form" method="post" action="<?=site_url('appskp/sett/setup_pengelola_aksi');?>" enctype="multipart/form-data">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">FORM SET-UP PENGELOLA KEPEGAWAIAN</h4>
                                        </div>
                                        <div class="modal-body" id="isi_modal">
											<div class="row"><div class="col-lg-12"><div class="panel panel-default" id='id_petugas_modal'></div></div></div>
                                        </div>
	                                    <!-- /.modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="modalButtonAksi" onclick="set_pengelola_aksi();"><i class="fa fa-save fa-fw"></i> Simpan</button>
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
		url:"<?=site_url();?>appskp/sett/getakses_pengelola/",
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
						var pengelola = "";
						$.each( item.pengelola, function(index, item2){
							pengelola = pengelola+item2.nama_user+"; ";
						});

						if(pengelola==""){var isi=""; var tools="";}else{var isi=" class='danger'"; var tools="  data-container='body' data-placement='bottom' data-toggle='tooltip' data-original-title='"+pengelola+"'"}
						table = table+ "<tr id='row_"+item.id_unor+"'"+tools+">";
						table = table+ "<td style='padding:7px 0px 0px 0px;text-align:center;'"+isi+"><input type=checkbox data-aksi='check' id='check_"+item.id_unor+"' value='"+item.id_unor+"' onclick='pilih_satu("+item.id_unor+");'></td>";
						table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.kode_unor+"</td>";
						table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.nama_unor+"</td>";
						table = table+ "<td onclick='pilih_satu("+item.id_unor+");'>"+item.nomenklatur_jabatan+"<br/><u>pada</u><br/>"+item.nomenklatur_pada+"</td>";
						table = table+ "</tr>";
						no++;
					}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
				$("[data-toggle='tooltip']").tooltip();
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
////////////////////////////////////////////////////////////////////////////
function pilih_satu(idd){
	var aksi = $('#check_'+idd).attr('data-aksi');
	var njj = parseInt($('#jj').html());
	if(aksi=="check"){
		$('#check_'+idd).replaceWith("<input type=checkbox data-aksi='uncheck' id='check_"+idd+"' name=id_unor[] value='"+idd+"' onclick='pilih_satu("+idd+");' checked>");
		$('#row_'+idd).addClass('info');
		njj = njj + 1;
		$('#jj').html(njj);
	} else {
		$('#check_'+idd).replaceWith("<input type=checkbox data-aksi='check' id='check_"+idd+"' value='"+idd+"' onclick='pilih_satu("+idd+");'>");
		$('#row_'+idd).removeClass('info');
		njj = njj - 1;
		$('#jj').html(njj);
	}
}
function pilih_semua(){
	$("[id^='check_']").each(function(key,val) {	
		var ini = $(this).val();
		$(this).replaceWith("<input type=checkbox data-aksi='uncheck' id='check_"+ini+"' name=id_unor[] value='"+ini+"' onclick='pilih_satu("+ini+");' checked>");
		$('#row_'+ini).addClass('info');
	});
	$("#tb_pilih").replaceWith("<input type=checkbox onchange='batal_semua();' id='tb_pilih' checked>");
	var batas = $('#item_length').val();
	$('#jj').html(batas);
}
function batal_semua(){
	$("[id^='check_']").each(function(key,val) {	
		var ini = $(this).val();
		$(this).replaceWith("<input type=checkbox data-aksi='check' id='check_"+ini+"' value='"+ini+"' onclick='pilih_satu("+ini+");'>");
		$('#row_'+ini).removeClass('info');
	});
	$("#tb_pilih").replaceWith("<input type=checkbox onchange='pilih_semua();' id='tb_pilih'>");
	$('#jj').html("0");
}
function set_pengelola(){
	var njj = $('#jj').html();
	if(njj!=0){
			var wr = "{";
			var wu = "{";
			var nn =0;
			$("[id^='check_']").each(function(key,val) {
				var ival =	$(this).val(); 
				var ini = $(this).attr('data-aksi');
				var uu = $('#userid_'+ival).html();
				if(ini=="uncheck"){	
					if(nn==0){	wu = wu+uu;wr = wr+ival;	} else {	wu = wu+","+uu;wr = wr+","+ival;	}
					nn++;
				}
			});
			wr = wr + "}";
			wu = wu + "}";

				$('#unor_pil').remove();
				$('#user_id').remove();
				$('#batal').remove();
				var id_petugas = $('#id_petugas').html();
				$('#id_petugas_modal').html(id_petugas)
				$('<div id=batal style="display:none;">diam</div><input type=hidden id=user_id name=user_id value="<?=$pengelola->user_id;?>"><input type=hidden id=unor_pil name=unor_pil value="'+wr+'">').insertBefore('#modalButtonAksi');
				$('#myModal').modal('show');
	}
}
function set_pengelola_aksi(){
			$.ajax({
			type:"POST",
			url:	$("#modal-form").attr('action'),
			data:$("#modal-form").serialize(),
			beforeSend:function(){	
				$('#modalButtonAksi').hide();
				$('#isi_modal').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				$('#myModal').modal('hide');
				$("#batal").html("kembali");
			},
			dataType:"html"});
}
$('#myModal').on('hidden.bs.modal', function () {
	var aksi = $('#batal').html();
	if(aksi=="kembali"){	kembali();	}
})
function kembali(){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/sett/pengelola",
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
.tooltip-inner{
    max-width:500px;
    padding:12px 28px;
    color:#fff;
    text-align:center;
    text-decoration:none;
    background-color:#000;
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    border-radius:4px
}
</style>
