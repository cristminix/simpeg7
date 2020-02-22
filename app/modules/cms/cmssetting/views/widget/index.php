<script type="text/javascript"> 
function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
	var rubrik = $("#rubrik").val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/"+tujuan+"/",
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

$(document).ready(function(){
	gridpaging("end");
});


////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
var rubrik = $('#rubrik').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/widget/getwidget/",
				data:{"hal": hal, "batas": 10, "rubrik": rubrik},
				success:function(data){
if((data.hslquery.length)>0){
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.id_item +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				<!--table = table+ "<a class=grid_icon href='<?=base_url();?>kelurahan_lahir/pdftandabukti/"+item.BAYI_NO+"' target=_blank title='Klik untuk mencetak laporan'><span class='ui-icon ui-icon-pencil'></span></a>";-->
				table = table+ "<div class=grid_icon onclick=\"SaveStatusComArtikel('<?=site_url();?>cmsartikel/savestatus', {id_konten: "+ item.id_item +"});\" title='Rubah Status (Naik/Tarik Kembali)'><span class='ui-icon ui-icon-transferthick-e-w'></span></div>";
				table = table+ "<div class=grid_icon onclick=\"loadForm('formcontent_widget/"+ item.id_item +"','xx');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
//				if(item.group_id==8){
					if(item.cek=="kosong"){
						table = table+ "<div class=grid_icon onclick=\"loadForm('formhapus_widget','"+ item.id_item +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
					}
//				}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><div id='user_name_"+item.id_item+"'>" +item.nama_item+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.id_item+"'>" +item.keterangan+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.id_item+"'>" +item.komponen+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.id_item+"'>" +item.lokasi_widget+"</div></td>";
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
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formcontent_widget/0','xx');">Tambah Master Widget</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Widget</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=90><b>AKSI</b></th>
<th class=gridhead width=150><b>NAMA WIDGET</b></th>
<th class=gridhead><b>KETERANGAN</b></th>
<th class=gridhead width=150><b>KOMPONEN</b></th>
<th class=gridhead width=100><b>POSISI WIDGET</b></th>
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
