<script type="text/javascript"> 
function loadForm(tujuan,idparent,root,level){	
	$("#formMenu").html('');
	$("#gridMenu").hide();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/kanal/"+tujuan+"/",
				data:{"hal": "hal","idparent":idparent,"root":root,"level":level },
				success:function(data){
					$("#formMenu").html(data);
					}, 
				dataType:"html"});
	$("#formMenu").show();
	return false;
}	
function batal(){
	$("#formMenu").hide();
	$("#gridMenu").show();
	return false;
}
</script>
<div class="head-content">
  <h3><a href="#"><?=$jform;?></a></h3>
</div>
<div style="clear:both"></div>
<div id="formMenu" style="display:none">Ini Form</div>

<div id="gridMenu" style="margin-bottom:50px;">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambah',0,'',0);">Tambah Kanal</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Menu</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead id=gridhead>
<tr height=35>
<th width=65 class='gridhead left'>No.</th>
<th class=gridhead width=103><b>AKSI</b></th>
<th class=gridhead><b>NAMA KANAL</b><br>THEME KANAL</th>
<th class=gridhead width=280><b>SETTING</b></th>
<th class=gridhead width=350><b>PENGISI</b></th>
<th class=gridhead width=50><b>STATUS</b></th>
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

function loadIsiGrid(idp,lvl){
var mulai=0;
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/kanal/getkanal/",
				data:{"idparent":idp,"level":lvl},
				success:function(data){
		if((data.length)>0){
			if(idp==0){var ni="";} else{var ni=$("#nomer_"+idp+"").html()+".";}
			var table="";
			var j=0;
			var no=(mulai*1)+1;
			$.each( data, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id='row_"+item.idchild+"'>";
				table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.idchild+"'>"+ni+no+"</div></b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formtambah',"+item.id_kanal+",'"+item.idchild+"','"+(lvl*1+1)+"');\" title='Klik untuk menyisipkan data'><span class='ui-icon ui-icon-plusthick'></span></div>";
				if(item.cek=="kosong"){
						table = table+ "<div id='tombol_hapus_"+item.idchild+"' class=grid_icon onclick=\"loadForm('formhapus',"+item.id_kanal+",'"+item.idchild+"','"+(lvl*1+1)+"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
					} else {
						table = table+ "<div id='tombol_hapus_"+item.idchild+"' class=grid_icon onclick=\"loadForm('formhapus',"+item.id_kanal+",'"+item.idchild+"','"+(lvl*1+1)+"');\" title='Klik untuk menghapus data' style=\"display:none;\"><span class='ui-icon ui-icon-trash'></span></div>";
					}
					table = table+ "<div class=grid_icon onclick=\"loadForm('formedit',"+item.id_kanal+",'"+idp+"','"+lvl+"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
			if(j!=(data.length-1)){
				var berik=data[(j+1)].idchild;
				var urutan_berik=data[(j+1)].urutan;
				table = table+ "<div class=grid_icon onclick=\"urut('"+item.id_kanal+"','"+item.urutan+"','"+data[(j+1)].id_kanal+"','"+data[(j+1)].urutan+"','"+idp+"','"+lvl+"');\" title='Klik untuk menurunkan urutan data'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
			} else {
				var berik="XX";
				var urutan_berik="XX";
				table = table+ "<div id='tombol_turun_"+item.idchild+"' class=grid_icon style=\"display:none\" onclick=\"turun('"+ item.idchild +"');\" title='Klik untuk menurunkan urutan'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
			}
			if(j!=0){
				table = table+ "<div class=grid_icon onclick=\"urut('"+item.id_kanal+"','"+item.urutan+"','"+data[(j-1)].id_kanal+"','"+data[(j-1)].urutan+"','"+idp+"','"+lvl+"');\" title='Klik untuk menaikkan urutan data'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
			} else {
				table = table+ "<div id='tombol_naik_"+item.idchild+"' class=grid_icon style=\"display:none\" onclick=\"naik('"+ item.idchild +"');\" title='Klik untuk menaikkan urutan'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
			}
//tombol aksi<--
				table = table+ "</td>";
////////////////tombol treegrid && variabel kunci-->
			if(item.toggle == "tutup"){
				table = table+ "<td class=gridcell style='padding-left: "+ item.spare +"px;'><div class='ui-icon ui-icon-triangle-1-e tree-plus treeclick' style='float: left; cursor: pointer;'  id='"+item.idchild+"' onclick=\"loadIsiGrid('"+item.idchild+"','"+item.level+"');\">baru</div><div><b>"+item.nama_kanal+"</b><br/>"+item.template+"</div><br/></td>";
			} else {
				table = table+ "<td class=gridcell style='padding-left: "+ item.spare +"px;'><div  id='"+item.idchild+"' class='ui-icon ui-icon-document-b tree-leaf treeclick' style='float: left;'>baru</div><div><b>"+item.nama_kanal+"</b><br/>"+item.template+"</div><br/></td>";
			}
////////////////tombol treegrid && variabel kunci<--
				table = table+ "<td class='gridcell' align=left><br/><div><b>Judul Header</b>:"+item.judul_header+"</div><div><b>Sub Judul</b>:"+item.sub_judul+"</div><br/>"+item.proses+"<br/></td>";
				table = table+ "<td class='gridcell' align=left><br/><div><b><u>Rubrik</u></b>:<br>"+item.rubrik+"</div><div><b><u>Wrapper</u></b>:<br>"+item.wrapper+"</div><br/></td>";
//var treegrid-->
			if (j==0){var sebel="XX";}else{var sebel=data[(j-1)].idchild;}
			table = table+ "<td style=\"display:none\"><div style=\"display:none\"><div id=idparent_"+ item.idparent +">" +item.idchild+"</div><div id=status_"+ item.idchild +">baru</div><div id=sebel_"+ item.idchild +">"+sebel+"</div><div id=ini_"+item.idchild+">"+item.idchild+"</div><div id=berik_"+ item.idchild +">"+berik+"</div><div id=urutan_ini_"+item.idchild+">"+item.urutan+"</div><div id=urutan_berik_"+ item.idchild +">"+urutan_berik+"</div><div id=level_"+ item.idchild +">"+item.level+"</div></div></td>";
//var treegrid<--
					if(item.status=="on"){
						table = table+ "<td class=gridcell align=left>Sudah</td>";
					} else {
						table = table+ "<td class=gridcell align=left>Belum</td>";
					}
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
			$("#status_"+idp+"").html("minus");
		}
		}//tutup:: if data>0
            }, //tutup::success
        dataType:"json"});
        return false;
}
////////////////////////////////////////////////////////////////////////////
function urut(id_ini,urutan_ini,id_lawan,urutan_lawan,idp,lvl){
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>cmssetting/kategori/urutitem/",
		beforeSend:function(){	loadDialogBuka(); },
		data:{"id_ini": id_ini, "urutan_ini": urutan_ini, "id_lawan": id_lawan, "urutan_lawan": urutan_lawan},
		success:function(data){	
			if(lvl!=0){	$("[id^='row_"+idp+"_']").remove();	} else {	$("[id^='row_']").remove();	}
			loadIsiGrid(idp,lvl);
			loadDialogTutup();
		}, 
	dataType:"html"});
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
</script>