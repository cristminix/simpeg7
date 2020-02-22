<script type="text/javascript"> 
function loadForm(tujuan,id_grup){	
	$("#formUsergroup").html('');
	$("#gridUsergroup").hide();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/group/"+tujuan+"/",
				data:{"group_id": id_grup },
				success:function(data){
					$("#formUsergroup").html(data);
					}, 
				dataType:"html"});
	$("#formUsergroup").show();
	return false;
}	
function batal(){
	$("#formUsergroup").hide();
	$("#gridUsergroup").show();
	return false;
}
</script>
<div class="head-content">
  <h3><a href="#">Pengaturan Grup Pengguna</a></h3>
</div>


<div style="clear:both"></div>
<div id="formUsergroup" style="display:none">Ini Form</div>

<div id="gridUsergroup">
	<div id="rubrik-picker" class="toolbar">
		<button class="tombol_aksi" onclick="loadForm('formtambahgroup','xx');">Tambah Grup Pengguna</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Grup Pengguna</span>
			<span class="ui-icon ui-icon-circle-triangle-n" style="float:right; cursor:pointer" id="bt_table">n</span>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th width=65 class='gridhead left'>No.</th>
<th class=gridhead width=73><b>AKSI</b></th>
<th class=gridhead width=150><b>NAMA GRUP PENGGUNA</b></th>
<th class=gridhead width=120><b>THEME</b></th>
<th class=gridhead width=120><b>BACK OFFICE (Controller)</b></th>
<th class=gridhead><b>KETERANGAN</b></th>
<th class=gridhead width=70><b>STATUS</b></th>
</tr>
</thead>
<tbody id=list>
<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tbody>
<tr height=20>
<td align=right colspan=8 class='gridcell left'>&nbsp;</td>
</tr>
</table>
		</div>
<!-- Grid::akhir --->
	</div>
</div>
<br><br>
<script type="text/javascript"> 
$("#bt_table").click(function() {
	$("#isiGrid").toggle( "slow" );
	if($(this).html()=="s"){
		$(this).removeClass("ui-icon-circle-triangle-s").addClass("ui-icon-circle-triangle-n").html("n");
	} else {
		$(this).removeClass("ui-icon-circle-triangle-n").addClass("ui-icon-circle-triangle-s").html("s");
	}
});

$(document).ready(function(){
	loadIsiGrid();
});
function loadIsiGrid(){
var mulai=0;
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/group/getusergroup/",
				data:{"hal": "hal" },
				success:function(data){
		if((data.length)>0){
			var table="";
			var no=(mulai*1)+1;
			$.each( data, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.group_id +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formeditgroup','"+ item.group_id +"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
				if(item.cek=="kosong"){
					table = table+ "<div class=grid_icon onclick=\"loadForm('formhapusgroup','"+ item.group_id +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
				}
				if(item.STATUS==1){
					table = table+ "<div class=grid_icon onclick=\"loadDetail('kecamatan_lahir/com/edit_lahir','"+ item.BAYI_NO +"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-trash'></span></div>";
				}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><div id=gr_name_"+ item.group_id +">"+item.group_name+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id=sc_name_"+ item.group_id +">" +item.section_name+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id=back_office_"+ item.group_id +">" +item.back_office+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id=keterangan_"+ item.group_id +">" +item.keterangan+"</div></td>";
					if(item.status==1){
						table = table+ "<td class=gridcell align=left>Belum</td>";
					} else {
						table = table+ "<td class=gridcell align=left>Sudah</td>";
					}
				table = table+ "</tr>";       
			no++;
			}); //endeach
				$('#list').html(table);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
		}
		}, 

        dataType:"json"});
}
</script>