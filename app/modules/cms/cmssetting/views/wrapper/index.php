<script type="text/javascript"> 
function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
	var id_widget = $("#id_widget").val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/wrapper/"+tujuan+"/",
				data:{"idd": idd, "id_widget": id_widget },
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


////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
var id_widget = $('#id_widget').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/wrapper/getwrapper/",
				data:{"hal": hal, "batas": 10, "id_widget": id_widget},
				success:function(data){
if(data.hslquery!=undefined){
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.id_item +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formedit_wrapper','"+ item.id_item +"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
				if(item.kanal==""){
					table = table+ "<div class=grid_icon onclick=\"loadForm('formhapus_wrapper','"+ item.id_item +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
				}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><br><div><b>" +item.nama_wrapper+"</b></div><div>" +item.pengisi+"</div><br></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.id_item+"'>" +item.keterangan+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.id_item+"'>" +item.kanal+"</div></td>";
				table = table+ "</tr>";       
			no++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");
		}
				$('#posisi').html(data.posisi);
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

<div id="gridRubrikartikel">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambah_wrapper','xx');">Tambah Wrapper</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Widget</div>
		<div style="float:left;width:5px;">:</div>
		<div id=daftar_rubrik style="float:left;"><select name="id_widget" id="id_widget" onchange="gridpaging('end')" class="selectbox" style="width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;"><?=$widget;?></select></div>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Posisi widget</div>
		<div style="float:left;width:5px;">:</div>
		<div id=posisi></div>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Wrapper</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=60><b>AKSI</b></th>
<th class=gridhead width=300><b>NAMA WRAPPER</b><br>Rubrik Pengisi</th>
<th class=gridhead><b>KETERANGAN</b></th>
<th class=gridhead width=380><b>KANAL PEMAKAI</b></th>
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
<br><br>
