<script type="text/javascript">
function rTab(tujuan,pilihan){
	$("[id^='nTab']").each(function() {	$(this).removeClass();	});
	$("#nTab_"+pilihan+"").addClass("tab-nav-active");
	$("#piltab").html(tujuan);
	gridpaging("end");
}
function loadForm(tujuan,idd){	
	$("#formRubrikartikel").html('');
	$("#gridRubrikartikel").hide();
	var id_kanal = $("#id_kanal").val();
	var piltab = $("#piltab").html();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/wrapper_kanal/"+tujuan+"/",
				data:{"idd": idd, "id_kanal": id_kanal, "piltab": piltab },
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

function urutan(idini,idlawan){
	var id_kanal = $('#id_kanal').val();
	var vtarget = $("#target").html();
	var jumlah = $("#jumlah").html()*1;
	var vdini = $("#asli_"+idini+"").html();
	var vlawan = $("#asli_"+idlawan+"").html();

	$("#asli_"+idini+"").html(vlawan);
	$("#asli_"+idlawan+"").html(vdini);

	var ini = "[";
	for(i=1;i<jumlah;i++){
		var jj = $("#asli_"+i+"").html();
		if(i==1){ini = ini + jj;}else{ini = ini +", "+jj;}
	}
	ini = ini+"]";
	
	$.ajax({	type:"POST",	url:"<?=site_url();?>cmssetting/wrapper_kanal/edit_wrapper_aksi",	data:{"id_kanal": id_kanal,"ini": ini,"posisi":vtarget },
				success:function(data){	gridpaging("end"); }, 
				dataType:"html"	});
}


$(document).ready(function(){
	gridpaging("end");
});


////////////////////////////////////////////////////////////////////////////
function gridpaging(hal){
var id_kanal = $('#id_kanal').val();
var lokasi = $('#piltab').html();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/wrapper_kanal/getkanalwrapper/",
				data:{"hal": hal, "batas": 10, "id_kanal": id_kanal,"lokasi":lokasi},
				success:function(data){
if(data.hslquery!=""){
			var table="";
			var no=1;
			var j=0;
//////////////////////////////			
// Coba
var isi_asli="";
/////////////////////////////
			$.each( data.hslquery, function(index, item){
				if((no % 2) == 1){var seling="odd";}else{var seling="even";}
				table = table+ "<tr height=23 class='gridrow "+seling+"' id=row_"+ item.id_item +">";
				table = table+ "<td class='gridcell left' align=left><b>"+no+"</b></td>";
				table = table+ "<td class=gridcell>";
//tombol aksi-->
				table = table+ "<div class=grid_icon onclick=\"loadForm('formhapuswrapper','"+ item.id_wrapper +"');\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";


			if(j!=(data.hslquery.length-1)){
				var berik=data.hslquery[(j+1)].id_wrapper;
				var urutan_berik=data.hslquery[(j+1)].urutan;
				table = table+ "<div id='tombol_turun_"+item.id_kanal_wrapper+"' class=grid_icon onclick=\"urutan('"+no+"','"+(no+1)+"');\" title='Klik untuk menurunkan urutan'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
			} else {
				var berik="XX";
				var urutan_berik="XX";
				table = table+ "<div id='tombol_turun_"+item.id_kanal_wrapper+"' class=grid_icon style=\"display:none\" onclick=\"urutan('"+no+"','"+(no+1)+"');\" title='Klik untuk menurunkan urutan'><span class='ui-icon ui-icon-arrowthick-1-s'></span></div>";
			}

			if(j!=0){
				table = table+ "<div id='tombol_naik_"+item.id_kanal_wrapper+"' class=grid_icon onclick=\"urutan('"+no+"','"+(no-1)+"');\" title='Klik untuk menaikkan urutan'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
			} else {
				table = table+ "<div id='tombol_naik_"+item.id_kanal_wrapper+"' class=grid_icon style=\"display:none\" onclick=\"urutan('"+no+"','"+(no-1)+"');\" title='Klik untuk menaikkan urutan'><span class='ui-icon ui-icon-arrowthick-1-n'></span></div>";
			}

//tombol aksi<--
				table = table+ "</td>";
				table = table+ "<td class=gridcell align=left><br /><div><b>" +item.nama_wrapper+"</b></div><div>"+item.pengisi+"</div><br/></td>";
				table = table+ "<td class=gridcell align=left><br><div><b>" +item.widget+"</b></div><div>"+item.komponen+"</div><br/></td>";
				table = table+ "<td class=gridcell align=left><div id='group_name_"+item.id_item+"'>"+item.keterangan+"</div></td>";
				table = table+ "</tr>";       
//////////////////////////////			
// Coba
isi_asli=isi_asli+"<div class='asli' id='asli_"+no+"'>"+item.asli+"</div>";
/////////////////////////////
			no++;
			j++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);

				$('#asli').html(isi_asli);
				$('#target').html(data.lokasi);
				$('#jumlah').html(no);


		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");


				$('#asli').html("");
				$('#target').html("");
				$('#jumlah').html("");


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
<div style="display:none;">
<div id=target></div>
<div id=asli></div>
<div id=jumlah></div>
</div>

<div id="formRubrikartikel" style="display:none">Ini Form</div>

<div id="gridRubrikartikel">
	<div id="rubrik-picker" class="toolbar">
		<button id="bt-add" class="tombol_aksi" onclick="loadForm('formcontentwrapper/0','xx');">Tambah Wrapper Kanal</button>
		<button class="tombol_aksi">Ekspor ke Excel</button>
	</div>
	<div class="toolbar">
		<div style="float:left;width:150px;">Kanal</div>
		<div style="float:left;width:5px;">:</div>
		<div id=daftar_rubrik style="float:left;"><select name="id_kanal" id="id_kanal" onchange="gridpaging('end')" class="selectbox" style="width:200px; margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;"><?=$kanalall;?></select></div>
	</div>

<div id=piltab style="display:none">topbar</div>
	<div class="tab-nav" style="float:left">
		<ul>
			<li id='hTab_4'><a href="javascript:void(0)" onclick="rTab('footbar',4);" id='nTab_4'>FOOTBAR</a></li>
			<li id='hTab_3'><a href="javascript:void(0)" onclick="rTab('sidebar',3);" id='nTab_3'>SIDEBAR</a></li>
			<li id='hTab_2'><a href="javascript:void(0)" onclick="rTab('mainbar',2);" id='nTab_2'>MAINBAR</a></li>
			<li id='hTab_1' style='margin-left:15px'><a href="javascript:void(0)" onclick="rTab('topbar',1);" id='nTab_1' class="tab-nav-active">TOPBAR</a></li>
		</ul>
	</div>
<div style="clear:both;margin-bottom:2px;"></div>
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
<th class='gridhead left' width=45>No.</th>
<th class=gridhead width=65><b>AKSI</b></th>
<th class=gridhead width=450><b>NAMA WRAPPER</b><br>Rubrik Pengisi</th>
<th class=gridhead width=120><b>WIDGET</b><br/>Komponen</th>
<th class=gridhead><b>KETERANGAN</b></th>
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