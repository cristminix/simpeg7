<script type="text/javascript">
function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
	var id_kanal = $("#id_kanal").val();
	var piltab = $("#piltab").html();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/kategori/"+tujuan+"/",
				data:{"idd": idd, "id_kanal":id_kanal },
				success:function(data){
					$("#formRubrikartikel").html(data);
					}, 
				dataType:"html"});
	$("#formRubrikartikel").show();
	return false;
}	
function batal(){
	$("#formRubrikartikel").hide();
	$("#gridRubrikartikel").show();
	return false;
}

$(document).ready(function(){
	gridpaging("end");
});

function urut(id_ini,urutan_ini,id_lawan,urutan_lawan){
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>cmssetting/kategori/urutitem/",
		beforeSend:function(){	loadDialogBuka(); },
		data:{"id_ini": id_ini, "urutan_ini": urutan_ini, "id_lawan": id_lawan, "urutan_lawan": urutan_lawan},
		success:function(data){	
			gopaging();	
			loadDialogTutup();
		}, 
	dataType:"html"});
}
////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
var id_kanal = $('#id_kanal').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/kategori/getkategori/",
				beforeSend:function(){	loadDialogBuka(); },
				data:{"hal": hal, "batas": 10, "id_kanal": id_kanal},
				success:function(data){
if(data.hslquery!=undefined){
			var table=""; var no =1;
			$.each( data.hslquery, function(index, item){
				if((item.urutan % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.urutan +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				if(item.hapus=="ya"){	table = table+ "<div class=grid_icon onclick=\"loadForm('formhapuskategori','"+item.id_kategori+"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";	}
				table = table+ "<div class=grid_icon onclick=\"loadForm('formeditkategori/"+item.hapus+"','"+item.id_kategori+"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
				if(item.naik=="ya"){	table = table+ "<div class=grid_icon onclick=\"urut('"+item.id_kategori+"','"+item.urutan+"','"+item.id_lawan_naik+"','"+item.urutan_lawan_naik+"');\" title='Klik untuk menaikkan urutan data'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";	}
				if(item.turun=="ya"){	table = table+ "<div class=grid_icon onclick=\"urut('"+item.id_kategori+"','"+item.urutan+"','"+item.id_lawan_turun+"','"+item.urutan_lawan_turun+"');\" title='Klik untuk menurunkan urutan data'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";	}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><br/><div><b>"+item.nama_kategori+"</b></div><div>"+item.komponen+"</div><br></td>";
				table = table+ "<td class=gridcell align=left><div>" +item.keterangan+"</div></td>";
				table = table+ "<td class=gridcell align=left><div>" +item.j_konten+"</div></td>";
				table = table+ "<td class=gridcell align=left><div>" +item.status+"</div></td>";
				table = table+ "</tr>";       
				no++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");
		}
			loadDialogTutup();
		}, 
        dataType:"json"});
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}


////////////////////////////////////////////////////////////////////////////
</script>
<div class="head-content">
  <h3><a href=#><?=$jform;?></a></h3>
</div>
<div style="clear:both"></div>
<div id="formRubrikartikel" style="display:none">Ini Form</div>

<div id="gridRubrikartikel"  style="margin-bottom:50px;">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambahkategori','xx');">Tambah Rubrik</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Kanal</div>
		<div style="float:left;width:5px;">:</div>
		<div id=daftar_rubrik style="float:left;"><select name="id_kanal" id="id_kanal" onchange="gridpaging('end')" class="selectbox" style="width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;"><?=$kanalall;?></select></div>
	</div>
<div style="clear:both;margin-bottom:2px;"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Rubrik</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=90><b>AKSI</b></th>
<th class=gridhead><b>NAMA RUBRIK</b><br/>KOMPONEN</th>
<th class=gridhead width=500><b>KETERANGAN</b></th>
<th class=gridhead width=100><b>BANYAKNYA<br/>ITEM KONTEN</b></th>
<th class=gridhead width=80><b>STATUS</b></th>
</tr>
</thead>
<tbody id=list>
<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tbody>
<tr height=20>
<td align=right colspan=8 class='gridcell left' id=paging></td>
</tr>
</table>
		</div>
<!-- Grid::akhir --->
	</div>
</div>
