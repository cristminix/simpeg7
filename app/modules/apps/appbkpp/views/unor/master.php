<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="content-wrapper" style="padding-bottom:30px;">
<div class="row">
		<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-tasks fa-fw"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuT">
											<li role="presentation"><a href="<?=site_url('admin/module/appbkpp/unor');?>" role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-list fa-fw"></i> Daftar Struktur Organisasi & Struktur Jabatan per due-Date</a></li>
											<li role="presentation"><a href="<?=site_url('admin/module/appbkpp/unor/tree');?>" role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-sitemap fa-fw"></i> Tampilan hirarki</a></li>
											<li role="presentation" class="divider">
											<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;"><div class="btn btn-primary btn-xs"><i class="fa fa-tasks fa-fw"></i></div> Daftar Struktur Organisasi & Struktur Jabatan Master</a></li>
										</ul>
										Daftar Struktur Organisasi & Struktur Jabatan Master
									</div>
								</div>
								<div class="col-lg-6">
									<div class="btn btn-primary btn-xs" style="float:right;" onClick="setForm('tambah','xx');"><i class="fa fa-plus fa-fw"></i> Tambah Struktur Organisasi & Struktur Jabatan</div>
								</div>
						</div>
		</div>
		<div class="panel-body" style="padding-left:5px;padding-right:5px;">

<div class="row">
	<div class="col-lg-6" style="margin-bottom:5px;">
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
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
<table class="table table-striped table-bordered table-hover" style="width:1024px;">
<thead>
<tr>
<th style="width:55px;text-align:center; vertical-align:middle">No.</th>
<th style="width:30px;text-align:center; padding:20px 0px 17px 0px;">
		<div class="dropdown" id="btMenu">
			<button class="btn btn-info dropdown-toggle btn-xs" type="button" id="ddMenu" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenu">
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="set_berlaku();"><i class="fa fa-edit fa-fw"></i>Set Masa Berlaku</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="pilih_semua(); return false;"><i class="fa fa-check fa-fw"></i>Pilih Semua</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="batal_semua();"><i class="fa fa-undo fa-fw"></i>Batal semua</a></li>
			</ul>
		</div>
</th>
<th style="width:40px;text-align:center; vertical-align:middle;padding:0px;">AKSI</th>
<th style="width:105px;text-align:center; vertical-align:middle">KODE</th>
<th style="width:250px;text-align:center; vertical-align:middle">NAMA STRUKTUR ORGANISASI</th>
<th style="width:390px;text-align:center; vertical-align:middle"><b>JABATAN STRUKTURAL</b></th>
<th style="width:110px;text-align:center; vertical-align:middle">MASA BERLAKU</b></th>
</tr>
</thead>
<tbody id=list>
</tbody>
</table>
			</div>
			<!-- table-responsive --->
	<div id=paging></div>
		</div>
	</div>
		</div>
		<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id='jj' style="display:none">0</div>
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
		url:"<?=site_url();?>appbkpp/unor/getdata",
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
					table = table+ "<td onclick='pilih_satu("+item.id_unor+");' style='padding:3px;'>"+no+"</td>";
					table = table+ "<td style='padding:3px 0px 0px 0px;text-align:center;'><input type=checkbox data-aksi='check' id='check_"+item.id_unor+"' value='"+item.id_unor+"' onclick='pilih_satu("+item.id_unor+");'></td>";
	//tombol aksi-->
					table = table+ "<td valign=top style='padding:3px 0px 0px 0px;' align=center>";
						table = table+ '<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
						table = table+ '<ul class="dropdown-menu" role="menu">';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'edit\',\''+item.id_unor +'\');"><i class="fa fa-edit fa-fw"></i> Edit data</a></li>';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'copy\',\''+item.id_unor +'\');"><i class="fa fa-copy fa-fw"></i> Copy data / Save as</a></li>';
						table = table+ '<li role="presentation" class="divider"></li>';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'hapus\',\''+item.id_unor +'\');"><i class="fa fa-trash fa-fw"></i> Hapus data</a></li>';
						table = table+ "</ul></div>";
					table = table+ "</td>";
	//tombol aksi<--
					table = table+ "<td onclick='pilih_satu("+item.id_unor+");' style='padding:3px;'>"+item.kode_unor+"</td>";
					table = table+ "<td onclick='pilih_satu("+item.id_unor+");' style='padding:3px;'>"+item.nama_unor+"</td>";
					table = table+ "<td onclick='pilih_satu("+item.id_unor+");' style='padding:3px;'><div id='kol_2_"+item.id_unor+"'><b>"+item.nomenklatur_jabatan+"</b><br /><u>pada</u><br />"+item.nomenklatur_pada+"</div></td>";
					table = table+ "<td onclick='pilih_satu("+item.id_unor+");' style='padding:3px;text-align:center'>"+item.tmt_berlaku+"</br>s.d.</br>"+item.tst_berlaku+"</td>";
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
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
var hal=$("#inputpaging").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/unor/form"+aksi,
		data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd},
		beforeSend:function(){	
			$('#content-wrapper').hide();
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>').show();
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
////////////////////////////////////////////////////////////////////////////
function set_berlaku(){
	var njj = $('#jj').html();
	if(njj!=0){
			var wr = "{";
			var nn =0;
			$("[id^='check_']").each(function(key,val) {
				var ival =	$(this).val(); 
				var ini = $(this).attr('data-aksi');
				if(ini=="uncheck"){	
					if(nn==0){	wr = wr+ival;	} else {	wr = wr+","+ival;	}
					nn++;
				}
			});
			wr = wr + "}";

			setForm('setberlaku',wr);

	}
}

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
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>