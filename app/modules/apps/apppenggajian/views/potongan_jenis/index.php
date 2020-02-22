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
									<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-list fa-fw"></span></button>
										
										<span id="judul">Master Potongan Jenis</span>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="btn btn-primary btn-xs" style="float:right;" onClick="setForm('tambah','xx');"><i class="fa fa-plus fa-fw"></i> Tambah Master Potongan Jenis</div>
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
<table class="table table-striped table-bordered table-hover" style="width:955px;">
<thead>
<tr>
<th style="width:10px;text-align:center; vertical-align:middle">No.</th>
<th style="width:40px;text-align:center; vertical-align:middle;padding:0px;">AKSI</th>
<th style="width:55px;text-align:center; vertical-align:middle">POTONGAN JENIS</th>
<th style="width:55px;text-align:center; vertical-align:middle">KETERANGAN</th>
<th style="width:55px;text-align:center; vertical-align:middle">STATUS</th>
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
</div>
<!-- /.content -->

<div id="form-wrapper" style="padding-bottom:30px; display:none;"></div>
<div id="tipe" style="display:none;"><?=$tipe;?></div>

<script type="text/javascript">


$(document).ready(function(){
	gridpaging(<?=$hal;?>);
});

function pilTipe(tipe){
$('#caripaging').val('');
$('#item_length').val(10);
$('#tipe').html(tipe);
gridpaging(1);
}
function formatNumber(number) {

    var decimalSeparator = ",";
    var thousandSeparator = ".";

    var result = String(number);

    // split the number in the integer and decimals, if any
    var parts = result.split(decimalSeparator);
    result = parts[0].split("").reverse().join("");
    result = result.replace(/(\d{3}(?!$))/g, "$1" + thousandSeparator);
    parts[0] = result.split("").reverse().join("");
    return parts.join(decimalSeparator);
}
function gridpaging(hal){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
var tipe = $('#tipe').html();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>apppenggajian/potongan_jenis/getdata",
		data:{"hal": hal, "batas": batas,"tipe":tipe,"cari":cari},
		beforeSend:function(){	
			$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
			$('#paging').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					table = table+ "<tr id='row_"+item.id_potongan_jenis+"'>";
					table = table+ "<td style='padding:3px;' align='center'>"+no+"</td>";
	//tombol aksi-->
					table = table+ "<td valign=top style='padding:3px 0px 0px 0px;' align=center>";
						table = table+ '<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
						table = table+ '<ul class="dropdown-menu" role="menu">';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'edit\',\''+item.id_potongan_jenis+'\');"><i class="fa fa-edit fa-fw"></i> Edit data</a></li>';
						table = table+ '<li role="presentation" class="divider"></li>';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'hapus\',\''+item.id_potongan_jenis+'\');"><i class="fa fa-trash fa-fw"></i> Hapus data</a></li>';
						table = table+ "</ul></div>";
					table = table+ "</td>";
	//tombol aksi<--
					table = table+ "<td style='padding:3px;' align='center'>"+item.potongan_jenis+"</td>";
					table = table+ "<td style='padding:3px;' align='center'>"+item.keterangan+"</td>";
					table = table+ "<td style='padding:3px;' align='center'>"+item.status+"</td>";
					table = table+ "</tr>";
					no++;
				}); //endeach
					$('#list').html(table);
					$('#paging').html(data.pager);
					$('#judul').html(data.judul);
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
var tipe = $('#tipe').html();
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
var hal=$("#inputpaging").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>apppenggajian/potongan_jenis/form"+aksi,
		data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd,"tipe":tipe},
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
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>