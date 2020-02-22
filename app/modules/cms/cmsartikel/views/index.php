<script type="text/javascript"> 
$(document).ready(function(){
	tinyMCE.execCommand('mceRemoveControl',false,'catatan');
	gridpaging(1);
});

function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
	var rubrik = $("#rubrik").val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmsartikel/"+tujuan+"/",
				data:{"idd": idd, "rubrik": rubrik, "komponen":"artikel" },
				beforeSend:function(){	loadDialogBuka(); },
				success:function(data){
					$("#formRubrikartikel").html(data);
					loadDialogTutup();
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
var rubrik = $('#rubrik').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmsartikel/getkonten/",
				data:{"hal": hal, "batas": 10, "rubrik": rubrik, "komponen":"artikel"},
				beforeSend:function(){	loadDialogBuka(); },
				success:function(data){
if((data.hslquery.length)>0){
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=45 class='gridrow "+seling+"' id=row_"+ item.id_konten +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"SaveStatusComArtikel('<?=base_url();?>cmsartikel/savestatus', {id_konten: "+ item.id_konten +"});\" title='Rubah Status (Naik/Tarik Kembali)'><span class='ui-icon ui-icon-transferthick-e-w'></span></div>";
				table = table+ "<div class=grid_icon onclick=\"loadForm('formcontent/"+ item.id_konten +"','xx');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
				if(item.cek=="kosong" && item.cek2=="kosong"){
					table = table+ "<div class=grid_icon onclick=\"loadForm('formhapus','"+ item.id_konten +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
				}
//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><div id='user_name_"+item.id_konten+"'>" +item.judul+"</div></td>";
				if(item.cek=="ada"){
					table = table+ "<td class=gridcell align=center><div id='group_name_"+item.id_konten+"' onclick=\"loadForm('formfoto','"+ item.id_konten +"');\" style='cursor:pointer' title='Klik untuk mengatur gambar artikel'><img src='assets/media/file/artikel/"+item.id_konten+"/" +item.thumb+"' height=40 border=0></div></td>";
				} else {
					table = table+ "<td class=gridcell align=center><div id='group_name_"+item.id_konten+"' onclick=\"loadForm('formfoto','"+ item.id_konten +"');\" style='cursor:pointer' title='Klik untuk mengatur gambar artikel'><img src='assets/media/file/artikel/default/no_image.gif' height=40 border=0></div></td>";
				}
				if(item.cek2=="ada"){
					table = table+ "<td class=gridcell align=center><div id='group_name_"+item.id_konten+"' onclick=\"loadForm('formslider','"+ item.id_konten +"');\" style='cursor:pointer' title='Klik untuk mengatur slider artikel'><img src='assets/media/file/slider/"+item.id_konten+"/" +item.slider+"' height=40 border=0></div></td>";
				} else {
					table = table+ "<td class=gridcell align=center><div id='group_name_"+item.id_konten+"' onclick=\"loadForm('formslider','"+ item.id_konten +"');\" style='cursor:pointer' title='Klik untuk mengatur slider artikel'><img src='assets/media/file/slider/default/no_slider.gif' height=40 border=0></div></td>";
				}
				table = table+ "<td class=gridcell align=center><div id='nm_pengguna_"+item.id_konten+"'>" +item.status+"</div></td>";
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

<div id="gridRubrikartikel" style="margin-bottom:50px;">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formcontent/0','xx');">Tambah Artikel</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Rubrik</div>
		<div style="float:left;width:5px;">:</div>
		<div id=daftar_gruppengguna style="float:left;"><select name="rubrik" id="rubrik" onchange="gridpaging('end')" class="selectbox" style="width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;"><option value="xx">Semua rubrik</option><?=$rubrik_options;?></select></div>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Artikel</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=80><b>AKSI</b></th>
<th class=gridhead><b>JUDUL ARTIKEL</b></th>
<th class=gridhead width=120><b>GAMBAR</b></th>
<th class=gridhead width=120><b>SLIDER</b></th>
<th class=gridhead width=50><b>STATUS</b></th>
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
