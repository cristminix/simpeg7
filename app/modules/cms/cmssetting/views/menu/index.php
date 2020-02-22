<script type="text/javascript"> 
function loadForm(tujuan,idd,level,idparent){	
	$("#formPost").html('');
	$("#gridPost").hide();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/menu/"+tujuan+"/",
				data:{"idd":idd,"level":level,"idparent":idparent,"setting":"<?=$setting;?>" },
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
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambah_menu','xx','0','0');">Tambah <?=$setting;?></button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar <?=$setting;?></span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead id=gridhead>
<tr height=35>
		<th width=65 class='gridhead left'><b>NO.</b></th>
		<th class=gridhead width=105><b>AKSI</b></th>
		<th class=gridhead width=230><b>NAMA MENU</b></th>
		<th class=gridhead width=200><b>PATH MENU</b></th>
		<th class=gridhead><b>KETERANGAN</b></th>
		<th class=gridhead width=130><b>ICON MENU</b></th>
</tr>
</thead>
<tbody>
<tr height=20>
<td align=right colspan=8 class='gridcell left'>&nbsp;</td>
</tr>
</tbody>
</table>
		</div>
<!-- Grid::akhir --->
	</div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){
	loadIsiGrid(0,0);
});

////////////////////////////////////////////////////////////////////////////
function loadIsiGrid(idp,lvl){
var mulai=0;
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/menu/getmenu/",
				data:{"idparent":idp,"level":lvl,"setting":"<?=$setting;?>"},
				success:function(data){
		if((data.isi.length)>0){
			if(idp==0){var ni="";} else{var ni=$("#nomer_"+idp+"").html()+".";}
			var table="";
			var j=0;
			var no=(mulai*1)+1;
			$.each( data.isi, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id='row_"+item.idchild+"'>";
				table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.idchild+"'>"+ni+no+"</div></b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formtambah_menu',"+item.id_item+",'"+item.level+"','"+item.idchild+"');\" title='Klik untuk menyisipkan data'><span class='ui-icon ui-icon-plusthick'></span></div>";
				if(item.cek!="ada"){
					if(item.toggle != "tutup"){
						table = table+ "<div id='tombol_hapus_"+item.idchild+"' class=grid_icon onclick=\"loadForm('formhapus_menu','"+item.idchild+"',"+(parseInt(lvl)+1)+",'"+item.id_parent+"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
					}
				}
					table = table+ "<div class=grid_icon onclick=\"loadForm('formedit_menu','"+item.id_item+"','"+lvl+"','"+idp+"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
			if(j==(data.isi.length-1)){ var tombol_turun="style=\"display:none\""; idlawan="XX"; urutanlawan="XX";	} else {	var tanda=""; idlawan=data.isi[(j+1)].idchild; urutanlawan=data.isi[(j+1)].urutan;	}
			table = table+ "<div id='tombol_turun_"+item.idchild+"' class='grid_icon' title='Klik untuk menurunkan urutan' "+tombol_turun+"><span class='ui-icon ui-icon-arrowthick-1-s' onClick=\"urutan('"+ item.idchild +"','"+ idp +"','"+lvl+"','"+item.urutan+"','"+idlawan+"','"+urutanlawan+"','turun');\"></span></div>";
			if(j==0){	var tombol_naik="style=\"display:none\"";  idlawan="XX"; urutanlawan="XX";	} else {	var tombol_naik=""; idlawan=data.isi[(j-1)].idchild;  urutanlawan=data.isi[(j-1)].urutan;	}
			table = table+ "<div id='tombol_naik_"+item.idchild+"' class='grid_icon' title='Klik untuk menaikkan urutan' "+tombol_naik+"><span class='ui-icon ui-icon-arrowthick-1-n' onClick=\"urutan('"+ item.idchild +"','"+ idp +"','"+lvl+"','"+item.urutan+"','"+idlawan+"','"+urutanlawan+"','naik');\"></span></div>";
//tombol aksi<--
				table = table+ "</td>";
////////////////tombol treegrid && variabel kunci-->
			if(item.toggle == "tutup"){
				table = table+ "<td class=gridcell style='padding-left: "+ item.spare +"px;'><div class='ui-icon ui-icon-triangle-1-e tree-plus treeclick' style='float: left; cursor: pointer;'  id='"+item.idchild+"' onclick=\"loadIsiGrid('"+item.idchild+"','"+item.level+"');\">baru</div><div>"+item.nama_item+ "</div></td>";
			} else {
				table = table+ "<td class=gridcell style='padding-left: "+ item.spare +"px;'><div  id='"+item.idchild+"' class='ui-icon ui-icon-document-b tree-leaf treeclick' style='float: left;'>baru</div><div>"+item.nama_item+ "</div></td>";
			}
////////////////tombol treegrid && variabel kunci<--
				table = table+ "<td class='gridcell' align=left><div>"+item.path_menu+"</div></td>";
				table = table+ "<td class='gridcell' align=left><div>"+item.keterangan+"</div></td>";
				table = table+ "<td class='gridcell' align=left><div>"+item.icon_menu+"</div></td>";
				table = table+ "</tr>";       
			no++;
			j++;
			}); //endeach

		if(lvl == 0){
			$("<tr id=isi class=gridrow><td colspan=6 align=center><b>TIDAK ADA DATA</b></td></tr>").insertAfter("#gridhead");
			if(j!=0){$('#isi').replaceWith(table);}
		} else {
			$(table).insertAfter($("#row_"+idp+""));
			$("#"+idp).replaceWith("<div class='ui-icon treeclick ui-icon-triangle-1-s tree-minus treegrid-leaf' style='float: left; cursor: pointer;' id='"+idp+"'>minus</div>");
		}

}  //tutup:: if data>0	
            }, //tutup::success
        dataType:"json"});
        return false;
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
	$.ajax({	type:"POST",	url:"<?=site_url();?>cmssetting/kanal/naik_aksi",	data:{"setting":"<?=$setting;?>","id_ini": id_ini,"id_lawan": id_lawan,"urutan_ini": urutan_ini,"urutan_lawan": urutan_lawan },
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