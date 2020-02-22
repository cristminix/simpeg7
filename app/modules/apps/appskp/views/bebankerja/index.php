<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
		<!-- Modal -->
		<div class="modal fade modal-wide" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		</div>
		<!-- /.modal -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<button class="btn btn-primary btn-sm" type="button">Pilih unit organisasi...</button>
			</div>
			<div class="panel-body" id="jabatan">
					<div style="float:left; width:150px;">Unit Organisasi</div>
					<div style="float:left; width:15px;">:</div>
					<div style="float:left;">
						<select id="id_unor" onchange="gettupoksi();" style="width:500px; padding-top:5px; padding-bottom:5px;" class="ipt_text">
						</select>
					</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div id="gridRubrikartikel">
	<div class="row">
		<div class="col-lg-12">
			<div class="table-responsive">
<table width="100%" cellspacing=0 style="border-bottom: 1px dotted #3399CC;" id=t_tupoksi>
<thead id=gridhead_tupoksi>
<tr height=35>
<th class='gridhead left' width=45>No.</th>
<th class=gridhead width=35>AKSI</th>
<th class=gridhead><b>URAIAN BEBAN KERJA</b></th>
<th class=gridhead width=200><b>PENGEMBAN</b></th>
<th class=gridhead width=100><b>JENIS<br/>PEKERJAAN</b></th>
</tr>
</thead>
<tr height=20>
<td align=right colspan=8 class='gridcell left'>&nbsp;</td>
</tr>
</table>
			</div>
			<!-- table-responsive --->
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>


<br/><br/>
<script type="text/javascript">
$(document).ready(function(){
	gridpaging(1,0,0);
});
////////////////////////////////////////////////////////////////////////////
function gridpaging(hal,level,id_parent){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/skpd/getskpdutama/",
				data:{"hal": hal, "batas": 10, "level":level, "id_parent":id_parent},
//				beforeSend:function(){	loadDialogBuka(); },
				success:function(data){

if((data.hslquery.length)>0){   // start klo ada ada
			if(id_parent==0){var ni="";} else{var ni=$("#nomer_"+id_parent+"").html()+".";}
			var table="";
			var no=1;
			$.each( data.hslquery, function(index, item){
				if(no == 1){var seling="selected";}else{var seling="";}
				table = table+ "<option value='"+item.id_unor+"' "+seling+">";
				table = table+ item.nama_unor;
				table = table+ "</option>"; 
			no++;
			}); //endeach
}  //tutup:: if data>0	

					if(data.hslquery.length>0){	$('#id_unor').html(table); }
					gettupoksi();
            }, //tutup::success
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
function gettupoksi(){
	$("[id^='row_']").remove();
	var jenis = "js";
	var id_unor = $("#id_unor").val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/bebankerja/gettupoksi/",
				data:{"id_unor":id_unor,"jenis":jenis},
//				beforeSend:function(){	loadDialogBuka(); },
				success:function(data){

				var pp = data.pengemban[0];
				var table="";
				var no=1;
				$.each( data.rincian, function(index, item){
					if((no % 2) == 1){var seling="odd";}else{var seling="even";}
					table = table+ "<tr class='gridrow "+seling+"' id=row_"+ item.id_tupoksi +" height=80>";
					table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.id_tupoksi+"'>"+no+"</div></b></td>";
						table = table+ "<td class=gridcell>";//tombol aksi
						table = table+ "<div class=grid_icon onclick=\"loadFormB('tupoksi/edit','rincian','"+item.id_tupoksi+"');\" title='Klik untuk mengedit data'><span class='ui-icon ui-icon-pencil'></span></div>";
						var disp="";
						table = table+ "<div class=grid_icon onclick=\"loadFormB('tupoksi/hapus','rincian','"+item.id_tupoksi+"');\" "+disp+" id=\"tbhapus_"+item.id_tupoksi+"\" title='Klik untuk menghapus data'><span class='ui-icon ui-icon-trash'></span></div>";
						table = table+ "</td>";
					table = table+ "<td class=gridcell>";
					table = table+ "<span><div class='ui-icon ui-icon-document-b tree-leaf treeclick' style='float: left; cursor: pointer;'></div></span>";
					table = table+ "<div style=\"display:table;\">"+item.isi_tupoksi+"</div></td>";
					table = table+ "<td class=gridcell>"+pp.nomenklatur_jabatan+"</td>";
					table = table+ "<td class=gridcell>Tupoksi</td>";
				no++;
				}); //endeach tugas
				$(table).insertAfter('#gridhead_tupoksi');

			var pilini=$("#pilini").html();
			$("#tt_"+pilini+"").show();
            }, //tutup::success
        dataType:"json"});
}

</script>
<style>
.modal-wide .modal-dialog {	width: 950px;	}

charset "utf-8";
tr.gridrow {BACKGROUND-COLOR:#ffffff;	}
tr.gridrow:hover {BACKGROUND-COLOR:#FFFF9B;}
.gridrow.odd { BACKGROUND-COLOR:#F2FDFF; }
.gridrow.even { BACKGROUND-COLOR:#F9F9F9; }
td.gridcell { color:#666666; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px;  FONT-SIZE: 13px; FONT-FAMILY: arial, verdana, helvetica, serif;}
td.gridcell.left {  color:#000000; background-color:#D3F3FE; border-left: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-top: 1px dotted #3399CC; padding-left: 3px; padding-right: 3px}

th.gridhead { background-color:#D3F3FE; border-top: 1px dotted #3399CC; border-right: 1px dotted #3399CC; border-bottom: 1px dotted #3399CC; FONT-WEIGHT: normal; FONT-SIZE: 13px; FONT-FAMILY: arial, verdana, helvetica, serif; text-align:center;}
th.gridhead.left { background-color:#D3F3FE; border: 1px dotted #3399CC; font-weight:bold;}

.page.gradient { color: #000066; BACKGROUND-COLOR:#FFFFFF; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px;}
.page.gradient:hover {color: #FF0000; BACKGROUND-COLOR: #FFFF00; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px; cursor: pointer;}
.page.active {color: #ffffff; BACKGROUND-COLOR: #0066FF; border: 1px solid #0066FF; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px}
.pagingframe {float: right;}

.ipt_text {	margin-top:1px; BACKGROUND-COLOR:#FFFF9B; padding: 2px 3px 2px 1px; border:1px groove #3399CC;	}
</style>
