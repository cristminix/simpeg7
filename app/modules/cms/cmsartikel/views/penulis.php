<script type="text/javascript"> 
$(document).ready(function(){
	gridpaging("end");
});

function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
	var rubrik = $("#rubrik").val();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsartikel/"+tujuan+"/",
				data:{"idd": idd, "rubrik": rubrik },
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


////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsartikel/getpenulis/",
				data:{"hal": hal, "batas": 10 },
				success:function(data){
if((data.hslquery.length)>0){
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.id_konten +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				<!--table = table+ "<a class=grid_icon href='<?=base_url();?>kelurahan_lahir/pdftandabukti/"+item.BAYI_NO+"' target=_blank title='Klik untuk mencetak laporan'><span class='ui-icon ui-icon-pencil'></span></a>";-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formpenulisedit','"+ item.id_penulis +"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
//				if(item.group_id==8){
					if(item.cek=="kosong"){
						table = table+ "<div class=grid_icon onclick=\"loadForm('formhapus','"+ item.id_konten +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
					}
//				}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left>" +item.nama_penulis+"</td>";
				table = table+ "</tr>";       
			no++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
		}
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
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formpenulistambah/0','xx');">Tambah Penulis</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Penulis</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=150><b>AKSI</b></th>
<th class=gridhead><b>NAMA PENULIS</b></th>
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
