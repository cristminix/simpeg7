<script type="text/javascript"> 
function loadForm(tujuan,idd){	
	$("#formUser").html('');
	$("#gridUser").hide();
	var grup = $("#group_pil").val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appbkpp/user/"+tujuan+"/",
				data:{"user_id": idd, "grup":grup },
				success:function(data){
					$("#formUser").html(data);
					}, 
				dataType:"html"});
	$("#formUser").show();
	return false;
}	
function batal(){
	$("#formUser").hide();
	$("#gridUser").show();
	return false;
}
</script>
<div class="head-content">
  <h3><a href=#><?=$jform;?></a></h3>
</div>
<div style="clear:both"></div>
<div id="formUser" style="display:none">Ini Form</div>

<div id="gridUser">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambah','xx');">Tambah Pengguna</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Group pengguna</div>
		<div style="float:left;width:5px;">:</div>
		<div id=daftar_gruppengguna style="float:left;"><img src="<?=base_url();?>assets/images/loading1.gif"/><input type=hidden id=group_pil value='xx'></div>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Pengguna</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=73><b>AKSI</b></th>
<th class=gridhead width=130><b>USER_NAME</b></th>
<th class=gridhead><b>NAMA PENGGUNA</b></th>
<th class=gridhead width=90><b>GRUP PENGGUNA</b></th>
<th class=gridhead width=70><b>STATUS</b></th>
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
			var daf="<select id='group_pil' onchange=\"gridpaging('end');\"  style=\"width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;\"><option value=\"xx\">Seluruh Grup Pengguna</option>";
			$.each( data, function(index, item){	
				daf = daf +"<option value='"+ item.group_id+"'>" + item.group_name +"</option>";	
			});
			daf = daf + "</select>";
			$("#"+tujuan+"").html(daf);
			gridpaging("end");
		},
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
var grup = $('#group_pil').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appbkpp/user/getuser/",
				data:{"hal": hal, "batas": 10, "grup": grup},
				success:function(data){

			var table="";
			var j=0;
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.user_id +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formedit','"+ item.user_id +"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
//				if(item.group_id==8){
					if(item.cek=="kosong"){
						table = table+ "<div class=grid_icon onclick=\"loadForm('formhapus','"+ item.user_id +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
					}
//				}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><div id='user_name_"+item.user_id+"'>" +item.username+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='nm_pengguna_"+item.user_id+"'>" +item.nama_user+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.user_id+"'>" +item.group_name+"</div></td>";
					if(item.STATUS==1){
						table = table+ "<td class=gridcell align=left>Belum</td>";
					} else {
						table = table+ "<td class=gridcell align=left>Sudah</td>";
					}
				table = table+ "</tr>";       
			no++;
			j++;
			}); //endeach

			$('#list').html("<tr id=isi class=gridrow><td colspan=7 align=center><b>TIDAK ADA DATA</b></td></tr>");
			$('#paging').html("");
			if(j!=0){$('#list').html(table);$('#paging').html(data.pager);}

            }, //tutup::success
        dataType:"json"});
        return false;
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
</script>