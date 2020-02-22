<script type="text/javascript"> 
function loadForm(tujuan,idd,level,idparent){	
	var group_id=$("#group_pil").val();
	$("#formPost").html('');
	$("#gridPost").hide();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appbkpp/menu_pengguna/"+tujuan+"/",
				data:{"idd":idd,"level":level,"idparent":idparent,"id_setting":"<?=$id_setting;?>","id_setting_ref":"<?=$id_setting_ref;?>","group_id": group_id },
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

<div id="gridPost" style='margin-bottom:50px;'>
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambah_menu_pengguna','xx','0','0');">Tambah <?=$setting;?></button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Grup pengguna</div>
		<div style="float:left;width:5px;">:</div>
		<div id=daftar_gruppengguna style="float:left;"><img src="<?=base_url();?>assets/images/loading1.gif"/><input type=hidden id=group_pil value='xx'></div>
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
		<th class=gridhead width=65><b>AKSI</b></th>
		<th class=gridhead width=230><b>NAMA MENU</b></th>
		<th class=gridhead width=200><b>PATH MENU</b></th>
		<th class=gridhead><b>KETERANGAN</b></th>
		<th class=gridhead width=130><b>ICON MENU</b></th>
</tr>
</thead>
<tbody id=list>
<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tbody>
<tr height=20>
<td align=right colspan=8 class='gridcell left'>&nbsp;</td>
</tr>
		</div>
<!-- Grid::akhir --->
	</div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){
	getusergroup('daftar_gruppengguna');
});
////////////////////////////////////////////////////////////////////////////
function getusergroup(tujuan){
$.ajax({
        type:"POST",
        url:"<?=site_url();?>appbkpp/group/getusergroup/",
		data:{"hal": 1 },
        success:function(data){
			var daf="<select id='group_pil' onchange=\"loadIsiGrid(0,0);\"  style=\"width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;\">";
			var j=0;
			$.each( data, function(index, item){	
					if(j==0){daf = daf +"<option value='"+ item.group_id+"' id='gr_"+ item.group_id+"' selected>" + item.group_name +"</option>";} else {daf = daf +"<option value='"+ item.group_id+"' id='gr_"+ item.group_id+"'>" + item.group_name +"</option>";}	
					j++;
			});
			daf = daf + "</select>";
			$("#"+tujuan+"").html(daf);
			loadIsiGrid(0,0);
		},
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
function loadIsiGrid(idp,lvl){
var mulai=0;
var group_id = $('#group_pil').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appbkpp/menu_pengguna/getmenupengguna/",
				data:{"group_id": group_id,"idparent":idp,"level":lvl,"id_setting":"<?=$id_setting;?>","id_setting_ref":"<?=$id_setting_ref;?>"},
				success:function(data){
//		if((data.isi.length)>0){
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
				if(item.cek!="ada"){
					if(item.toggle != "tutup"){
						table = table+ "<div id='tombol_hapus_"+item.idchild+"' class=grid_icon onclick=\"loadForm('formhapus_menu_pengguna','"+item.idchild+"',"+(parseInt(lvl)+1)+",'"+item.id_parent+"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
					}
				}
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
//				$('#list').html(table);
		if(lvl == 0){
			$('#list').html("<tr id=isi class=gridrow><td colspan=7 align=center><b>TIDAK ADA DATA</b></td></tr>");
			if(j!=0){$('#list').html(table);}
		} else {
			$(table).insertAfter($("#row_"+idp+""));
			$("#"+idp).replaceWith("<div class='ui-icon treeclick ui-icon-triangle-1-s tree-minus treegrid-leaf' style='float: left; cursor: pointer;' id='"+idp+"'>minus</div>");
		}

//}  //tutup:: if data>0	
            }, //tutup::success
        dataType:"json"});
        return false;
}

////////////////////////////////////////////////////////////////////////////
$(document).on('click', '.fa.tree',function(){
	var lvl = $(this).attr("data-expand");
	var idp = $(this).attr("id");
	if(lvl=='yes'){
		$("[id^='rw_"+idp+"_']").hide();
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-right\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"no\"  id='"+idp+"'></span>");
	} else {
		$("[id^='"+idp+"_']").each(function(key,val) {
			var ini = $(this).attr("id");
			var status_ini = $(this).attr("data-expand");
			$("#rw_"+ini+"").show();
			if(status_ini == "yes"){	$(this).removeClass("fa tree fa-chevron-circle-down").addClass("fa tree fa-chevron-circle-right").attr("data-expand","no");	}
		});
		$("[id^='"+idp+"_']").each(function(key,val) {	var ini = $(this).attr("id");	$("[id^='rw_"+ini+"_']").hide();	});
		$("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-down\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"yes\"  id='"+idp+"'></span>");
	}
});
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
// $(document).on('click', '.treegrid-leaf',function(){
// $(document).on('click', '.fa.tree',function(){
	// var lvl = $(this).html();
	// var idp = $(this).attr("id");
	// if(lvl=='minus'){
		// $("[id^='row_"+idp+"_']").hide();
		// $("#"+idp).replaceWith("<span class=\"fa tree fa-chevron-circle-down fa-fw\" style=\"font-size:16px; cursor: pointer;\" data-expand=\"yes\"  id='"+idp+"'></span>");
		// $("#"+idp).replaceWith("<div class='ui-icon ui-icon-triangle-1-e tree-plus treeclick treegrid-leaf' style='float: left; cursor: pointer;' id='"+idp+"'>plus</div>");
		// $("#"+idp).replaceWith("<div class=\'fa tree fa-chevron-circle-down fa-fw\' style='float: left; cursor: pointer;' id='"+idp+"'>plus</div>");
	// } else {
		// $("[id^='"+idp+"_']").each(function(key,val) {
			// var ini = $(this).attr("id");
			// var status_ini = $(this).html();
			// $("#row_"+ini+"").show();
			// if(status_ini == "minus"){	$(this).removeClass("ui-icon ui-icon-triangle-1-s tree-minus treeclick treegrid-leaf").addClass("ui-icon ui-icon-triangle-1-e tree-plus treeclick treegrid-leaf").html("plus");	}
		// });
		// $("[id^='"+idp+"_']").each(function(key,val) {	var ini = $(this).attr("id");	$("[id^='row_"+ini+"_']").hide();	});
		// $("#"+idp).replaceWith("<div class='ui-icon treeclick ui-icon-triangle-1-s tree-minus treegrid-leaf' style='float: left; cursor: pointer;' id='"+idp+"'>minus</div>");
	// }
// });
//////////////////////////////////////////////////////////////////////////
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
