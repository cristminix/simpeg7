<script type="text/javascript"> 
function loadForm(tujuan,idd,level,idparent){	
	$("#formPost").html('');
	$("#gridPost").hide();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/"+tujuan+"/",
				data:{	"idd":idd },
				success:function(data){
					$("#formPost").html(data);
					}, 
				dataType:"html"});
	$("#formPost").show();
	return false;
}	
function batal(){
	$("#formPost").hide();
	$("#gridPost").show();
	return false;
}
</script>
<div class="head-content">
  <h3><a href="#">Pengaturan  <?=$setting;?></a></h3>
</div>


<div style="clear:both"></div>
<div id="formPost" style="display:none">Ini Form</div>

<div id="gridPost">

<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Setting Utama</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead id=gridhead>
<tr height=35>
		<th width=65 class='gridhead left'><b>NO.</b></th>
		<th class=gridhead width=105><b>AKSI</b></th>
		<th class=gridhead width=200><b>SETTING UTAMA</b></th>
		<th class=gridhead><b>KETERANGAN</b></th>
</tr>
</thead>
<tbody id=list>
<tr height=20>
<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tr>
</tbody>
<tr height=20>
<td align=right colspan=8 class='gridcell left' id=pager></td>
</tr>
</table>
		</div>
<!-- Grid::akhir --->
	</div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){
	gridpaging("end");
});

////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/getsetting/",
				data:{"hal":hal, "batas": <?=$batas;?>},
				beforeSend:function(){	loadDialogBuka(); },
				success:function(data){
		if((data.isi.length)>0){
			var table="";
			var j=0;
			var no=(data.mulai*1);
			$.each( data.isi, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id='row_"+item.idchild+"'>";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";



				table = table+ "<td class='gridcell' align=left><div>";
				table = table+ "<div class=grid_icon onclick=\"loadForm('formeditmain','"+item.id_setting+"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
				table = table+ "</div></td>";
				table = table+ "<td class='gridcell' align=left><div>"+item.nama_setting+"</div></td>";
				table = table+ "<td class='gridcell' align=left><div>"+item.keterangan+"</div></td>";
				table = table+ "</tr>";       
			no++;
			j++;
			}); //endeach
				$('#list').html(table);
				$('#pager').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
			$('#paging').html("");
		}
					loadDialogTutup();
            }, //tutup::success
        dataType:"json"});
        return false;
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
////////////////////////////////////////////////////////////////////////////
function urutan( idini,idp,lvl,urutanini,idlawan,urutanlawan,opt){
	if(lvl!=0){	$("[id^='row_"+idp+"_']").remove();	} else {	$("[id^='row_']").remove();	}
	if(opt=="naik"){
		var id_ini = idini;
		var urutan_ini = urutanini;
		var id_lawan = idlawan;
		var urutan_lawan = urutanlawan;
	} else {
		var id_lawan = idini;
		var urutan_lawan = urutanini;
		var id_ini = idlawan;
		var urutan_ini = urutanlawan;
	}
	$.ajax({	type:"POST",	url:"<?=site_url();?>cmssetting/naik_aksi",	data:{"setting":"<?=$setting;?>","id_ini": id_ini,"id_lawan": id_lawan,"urutan_ini": urutan_ini,"urutan_lawan": urutan_lawan },
				success:function(data){	loadIsiGrid(idp,lvl); }, 
				dataType:"html"	});
}
////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.treegrid-leaf',function(){
	var lvl = $(this).html();
	var idp = $(this).attr("id");
	if(lvl=='minus'){
		$("[id^='row_"+idp+"_']").hide();
		$("#"+idp).replaceWith("<div class='ui-icon ui-icon-triangle-1-e tree-plus treeclick treegrid-leaf' style='float: left; cursor: pointer;' id='"+idp+"'>plus</div>");
	} else {
		$("[id^='"+idp+"_']").each(function(key,val) {
			var ini = $(this).attr("id");
			var status_ini = $(this).html();
			$("#row_"+ini+"").show();
			if(status_ini == "minus"){	$(this).removeClass("ui-icon ui-icon-triangle-1-s tree-minus treeclick treegrid-leaf").addClass("ui-icon ui-icon-triangle-1-e tree-plus treeclick treegrid-leaf").html("plus");	}
		});
		$("[id^='"+idp+"_']").each(function(key,val) {	var ini = $(this).attr("id");	$("[id^='row_"+ini+"_']").hide();	});
		$("#"+idp).replaceWith("<div class='ui-icon treeclick ui-icon-triangle-1-s tree-minus treegrid-leaf' style='float: left; cursor: pointer;' id='"+idp+"'>minus</div>");
	}
});
////////////////////////////////////////////////////////////////////////////
</script>