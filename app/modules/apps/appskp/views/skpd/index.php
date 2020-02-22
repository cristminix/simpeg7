<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><i class="fa fa-sitemap fa-fw"></i> <?=$satu;?><?=$id_skp;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
		<!-- Modal -->
		<div class="modal fade modal-wide" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		</div>
		<!-- /.modal -->

<div id="gridRubrikartikel">
	<div class="row">
		<div class="col-lg-12">
<button class="btn btn-warning btn-xs" type="button"   onClick="bsmShow('skpd/formtambah_utama','0**X**0');">Tambah Master SKPD</button>	
			<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="width:1045px;">
<thead>
<tr>
<th style="width:85px;vertical-align:middle;">No.</th>
<th style="width:40px;vertical-align:middle;padding:0px;">AKSI</th>
<th style="width:450px;">KODE<br /><b>NAMA UNIT ORGANISASI</b><br />KUNCI PENCARIAN</th>
<th style="width:450px;">ESELON<br /><b>JABATAN STRUKTURAL</b></th>
<th style="width:45px;vertical-align:middle;"><b>id_unor</b></th>
</tr>
</thead>
<tbody>
<tr height=5 id=gridhead>
<td align=right colspan=8 id=pg style='padding:0px;'>&nbsp;</td>
</tr>
</tbody>
</table>
			</div>
			<!-- table-responsive --->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>
<br/><br/>
<script type="text/javascript">
$(document).ready(function(){
	gridpaging(1,0,0);
//	$('.navbar-inverse').removeClass('navbar-inverse').addClass('navbar-default');
//	$('.navbar-default.sidebar').attr('style','width:120px;');
//	$('#page-wrapper').attr('style','margin:50px 0 0 120px;');
});
////////////////////////////////////////////////////////////////////////////
function bsmShow(tujuan,idd){
	$('#myModal').html("");
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/"+tujuan+"/",
		data:{"idd": idd },
        success:function(data){
			$('#myModal').html(data);
		},
        dataType:"html"});

	$('#myModal').modal('show');
}

function gridpaging(hal,level,id_parent){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/skpd/getskpdutama/",
				data:{"hal": hal, "batas": 10, "level":level, "id_parent":id_parent},
//				beforeSend:function(){	 },
				success:function(data){

if((data.hslquery.length)>0){   // start klo ada ada
			if(id_parent==0){var ni="";} else{var ni=$("#nomer_"+id_parent+"").html()+".";}
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				table = table+ "<tr height=25 id=row_"+ item.idchild +">";
				table = table+ "<td align=left style='padding:3px;'><div id='nomer_"+item.idchild+"'>"+ni+no+"</div></td>";
//tombol aksi-->
				table = table+ '<td valign=top style="padding:5px 0px 0px 0px;" align=center>';
					table = table+ '<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
					table = table+ '<ul class="dropdown-menu" role="menu">';
					table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow(\'skpd/formtambah_utama\',\''+item.id_unor +'**'+item.idchild+'**'+(parseInt(level)+1)+'\');"><i class="fa fa-plus fa-fw"></i> Sisipkan data</a></li>';
					table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow(\'skpd/formedit_utama\',\''+item.id_unor +'**'+id_parent+"**"+level+'\');"><i class="fa fa-edit fa-fw"></i> Edit data</a></li>';
					if(item.toggle == 'buka'){ var disp=''; } else { var disp=' style="display:none"'; }
					table = table+ '<li role="presentation" '+disp+' id="tbhapus_'+item.idchild+'" ><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow(\'skpd/formhapus_utama\',\''+item.id_unor +'**'+item.idchild+'**'+(parseInt(level)+1)+'**'+data.hslquery.length+'\');"><i class="fa fa-trash fa-fw"></i> Hapus data</a></li>';
					table = table+ '</ul></div>';
				table = table+ '</td>';
//tombol aksi<--
////////////////tombol treegrid && variabel kunci-->
				table = table+ "<td style='padding: 3px 3px 3px "+item.spare +"px;'>";
				if(item.toggle == "tutup"){
					table = table+ "<div style=\"float:left; padding:1px 5px 0px 0px;\"><i class=\"fa tree fa-chevron-circle-right fa-fw\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"no\"  id='"+item.idchild+"' onclick=\"gridpaging('"+hal+"','"+item.level+"','"+item.idchild+"');\"></i></div>";
				} else {
					table = table+ "<div style=\"float:left; padding:1px 5px 0px 0px;\"><i class=\"fa tree fa-file-o fa-fw\" style=\"font-size:16px;\" data-expand=\"no\"  id='"+item.idchild+"'></i></div>";
				}
				table = table+ "<span style=\"display:table;\" id='nama_jenis_"+item.id_unor+"'>"+item.kode_unor+"<br /><b>"+item.nama_unor+ "</b><br />"+item.nomenklatur_cari+"</span>";
				table = table+ "</td>";
////////////////tombol treegrid && variabel kunci<--
				table = table+ "<td align=left style='padding:3px;'><div id='kol_2_"+item.id_unor+"'>" +item.nama_ese+"<br /><b>"+item.nomenklatur_jabatan+"</b><br /><u>pada</u><br />"+item.nomenklatur_pada+"</div></td>";
				table = table+ "<td align=left style='padding:3px;'><div id='id_unor_"+item.id_unor+"'>"+item.id_unor+"</div></td>";
				table = table+ "</tr>"; 
			no++;
			}); //endeach
}  //tutup:: if data>0	

					if(level == 0){
						$("<tr id=isi><td colspan=6 align=center><b>TIDAK ADA DATA</b></td></tr>").insertAfter("#gridhead");
						if(data.hslquery.length>0){$('#isi').replaceWith(table); $('#pg').html(data.pager);}
					} else {
						$(table).insertAfter($("#row_"+id_parent+""));
						$("#"+id_parent).replaceWith("<span class=\"fa tree fa-chevron-circle-down fa-fw\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"yes\"  id='"+id_parent+"'></span>");
					}
//					loadDialogTutup();
//				zebra();
            }, //tutup::success
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.fa.tree',function(){
	var lvl = $(this).attr("data-expand");
	var idp = $(this).attr("id");
	if(lvl=='yes'){
		$("[id^='row_"+idp+"_']").hide();
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-right fa-fw\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"no\"  id='"+idp+"'></span>");
	} else {
		$("[id^='"+idp+"_']").each(function(key,val) {
			var ini = $(this).attr("id");
			var status_ini = $(this).attr("data-expand");
			$("#row_"+ini+"").show();
			if(status_ini == "yes"){	$(this).removeClass("fa tree fa-chevron-circle-down fa-fw").addClass("fa tree fa-chevron-circle-right fa-fw").attr("data-expand","no");	}
		});
		$("[id^='"+idp+"_']").each(function(key,val) {	var ini = $(this).attr("id");	$("[id^='row_"+ini+"_']").hide();	});
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-down fa-fw\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"yes\"  id='"+idp+"'></span>");
	}
//	zebra();
});

function zebra(){
	var ii=1;
	$("[id^='row_']").each(function(key,val) {
		if($(this).is(":visible")){
//			$(this);
			if((ii % 2) == 1){$(this).removeClass('odd').removeClass('even').addClass('odd');} else {$(this).removeClass('odd').removeClass('even').addClass('even');}
			ii++;
		}
	});
}

////////////////////////////////////////////////////////////////////////////
</script>
<style>
.modal-wide .modal-dialog {	width: 950px;	}
table th {	text-align:center; vertical-align:middle;	}
.gridcell {	padding:0px;	}
.pagingframe {float: right;}

.ipt_text {	margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;	}
</style>
