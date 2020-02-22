<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
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
			<div class="table-responsive">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead id=gridhead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead><b>UNIT ORGANISASI</b></th>
<th class=gridhead width=400><b>JABATAN<br/>TARIF DASAR TPP BULANAN</b> ( SKP BULANAN = 100% )<br/>( Rp.)</th>
</tr>
</thead>
<tr height=20>
<td align=right colspan=8 class='gridcell left' id=pg>&nbsp;</td>
</tr>
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
				url:"<?=site_url();?>appskp/tarif/getskpdutama/",
				data:{"hal": hal, "batas": 10, "level":level, "id_parent":id_parent},
//				beforeSend:function(){	 },
				success:function(data){

if((data.hslquery.length)>0){   // start klo ada ada
			if(id_parent==0){var ni="";} else{var ni=$("#nomer_"+id_parent+"").html()+".";}
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=25 class='gridrow "+seling+"' id=row_"+ item.idchild +">";
				table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.idchild+"'>"+ni+no+"</div></b></td>";
//tombol aksi-->
/*
				table = table+ "<td class=gridcell valign=top style=\"padding-top:10px;\" align=center>";
					table = table+ "<div class=\"dropdown\"><button class=\"btn btn-primary dropdown-toggle btn-xs\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\"><span class=\"caret\"></span></button>";
					table = table+ "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu1\">";
					table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('skpd/formtambah_utama','"+item.id_unor +"**"+item.idchild+"**"+(parseInt(level)+1)+"');\"><i class=\"fa fa-plus fa-fw\"></i>Sisipkan data</a></li>";
					table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('skpd/formedit_utama','"+item.id_unor +"**"+id_parent+"**"+level+"');\"><i class=\"fa fa-edit fa-fw\"></i>Edit data</a></li>";
					if(item.toggle == "buka"){ var disp=""; } else { var disp=" style=\"display:none\""; }
					table = table+ "<li role=\"presentation\" "+disp+" id=\"tbhapus_"+item.idchild+"\" ><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('skpd/formhapus_utama','"+item.id_unor +"**"+item.idchild+"**"+(parseInt(level)+1)+"**"+data.hslquery.length+"');\"><i class=\"fa fa-trash fa-fw\"></i>Hapus data</a></li>";
					table = table+ "</ul></div>";
				table = table+ "</td>";
*/
//tombol aksi<--
////////////////tombol treegrid && variabel kunci-->
				table = table+ "<td class=gridcell style='padding-left: "+ item.spare +"px;'>";
				if(item.toggle == "tutup"){
					table = table+ "<div style=\"float:left; padding:1px 5px 0px 0px;\"><span class=\"fa tree fa-chevron-circle-right\" style=\"font-size:16px; cursor: pointer;\" title=\"plus\"  id='"+item.idchild+"' onclick=\"gridpaging('"+hal+"','"+item.level+"','"+item.idchild+"');\"></span></div>";
				} else {
					table = table+ "<div style=\"float:left; padding:1px 5px 0px 0px;\"><span class=\"fa tree fa-file-o\" style=\"font-size:16px;\" title=\"plus\"  id='"+item.idchild+"'></span></div>";
				}
				table = table+ "<span style=\"display:table;\" id='nama_jenis_"+item.id_unor+"'><b>"+item.nama_unor+"</b></span>";
				table = table+ "</td>";
////////////////tombol treegrid && variabel kunci<--
				table = table+ "<td class=gridcell>";
				table = table+ "<div style=\"border-bottom:dotted 1px #000000;\"><div>Pejabat Struktural<br/><b>"+item.nama_ese+"</b></div><div style=\"text-align:right; font-size:14px;\">"+item.tarif_js+"</div></div>";
				$.each( item.tarif_jft, function(index, it2){
					table = table+ "<div style=\"border-bottom:dotted 1px #000000;\"><div>Fungsional Tertentu<br/><b>"+it2.nomenklatur_jabatan+"</b></div><div style=\"text-align:right; font-size:14px;\">"+it2.tarif+"</div></div>";
				});
				$.each( item.tarif_jfu, function(index, it3){
					table = table+ "<div style=\"border-bottom:dotted 1px #000000;\"><div>Fungsional umum<br/><b>"+it3.nomenklatur_jabatan+"</b></div><div style=\"text-align:right; font-size:14px;\">"+it3.tarif+"</div></div>";
				});
				table = table+ "</td>";
				table = table+ "</tr>"; 
			no++;
			}); //endeach
}  //tutup:: if data>0	

					if(level == 0){
						$("<tr id=isi class=gridrow><td colspan=6 align=center><b>TIDAK ADA DATA</b></td></tr>").insertAfter("#gridhead");
						if(data.hslquery.length>0){$('#isi').replaceWith(table); $('#pg').html(data.pager);}
					} else {
						$(table).insertAfter($("#row_"+id_parent+""));
						$("#"+id_parent).replaceWith("<span class=\"fa tree fa-chevron-circle-down\" style=\"font-size:16px; cursor: pointer;\" title=\"minus\"  id='"+id_parent+"'></span>");
					}
//					loadDialogTutup();
            }, //tutup::success
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.fa.tree',function(){
	var lvl = $(this).attr("title");
	var idp = $(this).attr("id");
	if(lvl=='minus'){
		$("[id^='row_"+idp+"_']").hide();
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-right\" style=\"font-size:16px; cursor: pointer;\" title=\"plus\"  id='"+idp+"'></span>");
	} else {
		$("[id^='"+idp+"_']").each(function(key,val) {
			var ini = $(this).attr("id");
			var status_ini = $(this).attr("title");
			$("#row_"+ini+"").show();
			if(status_ini == "minus"){	$(this).removeClass("fa tree fa-chevron-circle-down").addClass("fa tree fa-chevron-circle-right").attr("title","plus");	}
		});
		$("[id^='"+idp+"_']").each(function(key,val) {	var ini = $(this).attr("id");	$("[id^='row_"+ini+"_']").hide();	});
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-down\" style=\"font-size:16px; cursor: pointer;\" title=\"minus\"  id='"+idp+"'></span>");
	}
});
////////////////////////////////////////////////////////////////////////////
</script>
<style>
.modal-wide .modal-dialog {	width: 950px;	}

charset "utf-8";
tr.gridrow {BACKGROUND-COLOR:#ffffff;	}
tr.gridrow:hover {BACKGROUND-COLOR:#FFFF9B;}
.gridrow.odd { BACKGROUND-COLOR:#F2FDFF; }
.gridrow.even { BACKGROUND-COLOR:#F9F9F9; }
td.gridcell { color:#666666; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px;  FONT-SIZE: 13px; FONT-FAMILY: arial, verdana, helvetica, serif;}
td.gridcell.left {  color:#000000; background-color:#D3F3FE; border-left: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}

th.gridhead { background-color:#D3F3FE; border-top: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-bottom: 1px dotted #3399CC; FONT-WEIGHT: normal; FONT-SIZE: 13px; FONT-FAMILY: arial, verdana, helvetica, serif; text-align:center;}
th.gridhead.left { background-color:#D3F3FE; border: 1px dotted #3399CC; font-weight:bold;}

.page.gradient { color: #000066; BACKGROUND-COLOR:#FFFFFF; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px;}
.page.gradient:hover {color: #FF0000; BACKGROUND-COLOR: #FFFF00; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px; cursor: pointer;}
.page.active {color: #ffffff; BACKGROUND-COLOR: #0066FF; border: 1px solid #0066FF; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px}
.pagingframe {float: right;}

.ipt_text {	margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;	}
</style>
