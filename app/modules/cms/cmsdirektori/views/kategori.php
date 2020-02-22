<script type="text/javascript"> 
function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsdirektori/"+tujuan+"/",
				data:{"idd": idd },
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
</script>
<div class="head-content">
  <h3><a href=#><?=$jform;?></a></h3>
</div>
<div style="clear:both"></div>
<div id="formRubrikartikel" style="display:none">Ini Form</div>

<div id="gridRubrikartikel">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formtambahkategori','xx');">Tambah Kategori Direktori</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
<div style="clear:both"></div>
	<div  class="ui-jqgrid ui-widget ui-widget-content ui-corner-all"  style="box-shadow: 3px 3px 5px rgb(0,0,0);">
		<div style="padding:3px 5px 3px 5px" class="ui-jqgrid-titlebar ui-widget-header ui-corner-top ui-helper-clearfix">
			<span style="float:left">Daftar Kategori Direktori</span>
			<a href="" style="cursor:pointer"><span class="ui-icon ui-icon-circle-triangle-n" style="float:right"></span></a>
		</div>
<!--Grid::awal--->
		<div id="isiGrid">
<table width="100%" cellspacing=0 style="background-color:#CCCCCC; border-bottom: 1px dotted #3399CC;">
<thead>
<tr height=35>
<th class='gridhead left' width=65>No.</th>
<th class=gridhead width=103><b>AKSI</b></th>
<th class=gridhead width=300><b>NAMA KATEGORI DIREKTORI</b></th>
<th class=gridhead><b>KETERANGAN</b></th>
<th class=gridhead width=90><b>STATUS</b></th>
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
	gridpaging('end');
});
////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsartikel/getrubrikartikel/",
				data:{"hal": hal, "batas": 10, "komponen":"direktori" },
				beforeSend:function(){	loadDialogBuka(); },
				success:function(data){
if((data.hslquery.length)>0){
			var table="";
			var j=0;
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.id_kategori +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"saveStatus("+ item.id_kategori +");\" title='Rubah Status (Naikkan/Tarik Kembali)'><span class='ui-icon ui-icon-transferthick-e-w'></span></div>";
				table = table+ "<div class=grid_icon onclick=\"loadForm('formeditkategori','"+ item.id_kategori +"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
				if(item.cek=="kosong"){
						table = table+ "<div class=grid_icon onclick=\"loadForm('formhapuskategori','"+ item.id_kategori +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
				}
			if(j!=(data.hslquery.length-1)){
				var berik=data.hslquery[(j+1)].id_kategori;
				var urutan_berik=data.hslquery[(j+1)].urutan;
				table = table+ "<div id='tombol_turun_"+item.id_kategori+"' class=grid_icon onclick=\"turun('"+ item.id_kategori +"');\" title='Klik untuk menurunkan urutan'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
			} else {
				var berik="XX";
				var urutan_berik="XX";
				table = table+ "<div id='tombol_turun_"+item.id_kategori+"' class=grid_icon style=\"display:none\" onclick=\"turun('"+ item.id_kategori +"');\" title='Klik untuk menurunkan urutan'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
			}
			if(j!=0){
				table = table+ "<div id='tombol_naik_"+item.id_kategori+"' class=grid_icon onclick=\"naik('"+ item.id_kategori +"');\" title='Klik untuk menaikkan urutan'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
			} else {
				table = table+ "<div id='tombol_naik_"+item.id_kategori+"' class=grid_icon style=\"display:none\" onclick=\"naik('"+ item.id_kategori +"');\" title='Klik untuk menaikkan urutan'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
			}
//tombol aksi<--
				table = table+ "</td>";
//var treegrid-->
			if (j==0){var sebel="XX";}else{var sebel=data.hslquery[(j-1)].id_kategori;}
			table = table+ "<td style=\"display:none\"><div style=\"display:none\"><div id=idparent_"+ item.id_kategori +">" +item.id_kategori+"</div><div id=status_"+ item.id_kategori +">baru</div><div id=sebel_"+ item.id_kategori +">"+sebel+"</div><div id=ini_"+item.id_kategori+">"+item.id_kategori+"</div><div id=berik_"+ item.id_kategori +">"+berik+"</div><div id=urutan_ini_"+item.id_kategori+">"+item.urutan+"</div><div id=urutan_berik_"+ item.id_kategori +">"+urutan_berik+"</div><div id=level_"+ item.id_kategori +">"+item.level+"</div></div></td>";
//var treegrid<--
				table = table+ "<td class=gridcell align=left><div id='user_name_"+item.id_kategori+"'>" +item.nama_kategori+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='nm_pengguna_"+item.id_kategori+"'>" +item.keterangan+"</div></td>";
				table = table+ "<td class=gridcell align=left><div id='nm_pengguna_"+item.id_kategori+"'>" +item.status+"</div></td>";
				table = table+ "</tr>";       
			no++;
			j++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
		}
		loadDialogTutup();
		}, 
        dataType:"json"});
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
function saveStatus(idd){
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmsgaleri/rubah_status",
				data:{"idd": idd },
				success:function(data){
					 if(data=='sukses'){
						$("#list").html('');
						gopaging();
					} else {
						status.html('');
						status.removeClass('msg-box-true');
						status.addClass('msg-box-false');
						status.html('<ul><li>' + data + '</li></ul>');
					}
		}, 
        dataType:"html"});
}
function naik(idini){
	var id_ini=idini;
	var id_lawan=$("#sebel_"+idini+"").html();
	var urutan_ini=$("#urutan_ini_"+idini+"").html();
	var urutan_lawan=$("#urutan_ini_"+id_lawan+"").html();

	$.ajax({	type:"POST",	url:"<?=base_url();?>cmsgaleri/naik_aksi",	data:{"id_ini": idini,"id_lawan": id_lawan,"urutan_ini": urutan_ini,"urutan_lawan": urutan_lawan },
				success:function(data){	$("#list").html('');gopaging(); }, 
				dataType:"html"	});
};
function turun(idini){
	var id_ini=idini;
	var id_lawan=$("#berik_"+idini+"").html();
	var urutan_ini=$("#urutan_ini_"+idini+"").html();
	var urutan_lawan=$("#urutan_ini_"+id_lawan+"").html();

	$.ajax({	type:"POST",	url:"<?=base_url();?>cmsgaleri/naik_aksi",	data:{"id_ini": idini,"id_lawan": id_lawan,"urutan_ini": urutan_ini,"urutan_lawan": urutan_lawan },
				success:function(data){	$("#list").html('');gopaging(); }, 
				dataType:"html"	});
};
////////////////////////////////////////////////////////////////////////////
</script>