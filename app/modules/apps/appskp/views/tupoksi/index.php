<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
		<!-- Modal -->
		<div class="modal fade modal-wide" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" id="myModal" aria-labelledby="myModalLabel" aria-hidden="true">
		</div>
		<!-- /.modal -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<button class="btn btn-primary btn-sm" type="button"  data-toggle="modal" data-target="#myModal" data-form="appskp/tupoksi/pilih_jabatan">Pilih unit organisasi...</button>
			</div>
			<div class="panel-body" id="jabatan">
								<div>
										<div style="float:left; width:150px;">Jenis jabatan</div>
										<div style="float:left; width:15px;">:</div>
										<div style="float:left;" id="jenis_jabatan">...</div>
								</div>
								<div style="clear:both"></div>
								<div>
										<div style="float:left; width:150px;">Jabatan</div>
										<div style="float:left; width:15px;">:</div>
										<div style="float:left;">...</div>
								</div>
								<div style="clear:both"></div>
								<div>
										<div style="float:left; width:150px;">Unit organisasi</div>
										<div style="float:left; width:15px;">:</div>
										<div style="float:left;">...</div>
								</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->



            <div class="row">
                <div class="col-lg-12">
                        <div class="panel-body" style="padding:10px 3px 0px 3px;">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tugas" data-toggle="tab">Tugas pokok</a>
                                </li>
                                <li><a href="#fungsi" data-toggle="tab">Fungsi</a>
                                </li>
                                <li><a href="#rincian" data-toggle="tab">Rincian tugas</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tugas" style="padding-top:5px;">
				<div class="table-responsive">
<table width="100%" cellspacing=0 style="border-bottom: 1px dotted #3399CC;" id=t_tugas>
<thead id=gridhead_tugas>
<tr height=35>
<th class='gridhead left' width=45>No.</th>
<th class=gridhead width=35>AKSI</th>
<th class=gridhead><b>URAIAN TUGAS POKOK</b></th>
</tr>
</thead>
</tr>
<tr height=20>
<td class='gridcell left' colspan=2>&nbsp;</td>
<td class='gridcell left' id="footer_tugas">&nbsp;</td>
</tr>
</table>
				</div>
                <!-- ./table-responsive -->
                                </div>
                                <div class="tab-pane fade" id="fungsi" style="padding-top:5px;">
				<div class="table-responsive">
<table width="100%" cellspacing=0 style="border-bottom: 1px dotted #3399CC;" id=t_fungsi>
<thead id=gridhead_fungsi>
<tr height=35>
<th class='gridhead left' width=45>No.</th>
<th class=gridhead width=35>AKSI</th>
<th class=gridhead><b>URAIAN FUNGSI</b></th>
</tr>
</thead>
<tr height=20>
<td class='gridcell left' colspan=2>&nbsp;</td>
<td class='gridcell left' id="footer_fungsi">&nbsp;</td>
</tr>
</table>
				</div>
                <!-- ./table-responsive -->
                                </div>
                                <div class="tab-pane fade" id="rincian" style="padding-top:5px;">
				<div class="table-responsive">
<table width="100%" cellspacing=0 style="border-bottom: 1px dotted #3399CC;" id=t_rincian>
<thead id=gridhead_rincian>
<tr height=35>
<th class='gridhead left' width=45>No.</th>
<th class=gridhead width=35>AKSI</th>
<th class=gridhead><b>URAIAN RINCIAN TUGAS</b></th>
</tr>
</thead>
<tr height=20>
<td class='gridcell left' colspan=2>&nbsp;</td>
<td class='gridcell left' id="footer_rincian">&nbsp;</td>
</tr>
</table>
				</div>
                <!-- ./table-responsive -->
                </div>
            </div>
            <!-- /.row -->
<br/><br/>
<script type="text/javascript"> 
function bsmShow(tujuan,tipe,idt){
	var idd = $("#idd").html();
	var idj = $("#idj").html();
	var jenis = $("#jenis_jabatan").val();
	$('#myModal').html('<div class=\"modal-dialog\"><div class=\"modal-content\"><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></div></div>');
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/"+tujuan+"/",
		data:{"idd": idd,"idj": idj,"tipe":tipe,"jenis":jenis,"idt":idt },
		beforeSend:function(){	$('#myModal').modal('show'); },
        success:function(data){
			$('#myModal').html(data);
		},
        dataType:"html"});
}


$('[data-toggle="modal"]').click(function(e) {
  e.preventDefault();
	var tujuan = $(this).attr("data-form");
  	var tg = $(this).attr("data-target");
	
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>"+tujuan+"/",
		data:{"hal": 1 },
		beforeSend:function(){	$('#myModal').html('<div class=\"modal-dialog\"><div class=\"modal-content\"><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></p></div></div>'); },
        success:function(data){
			$(tg).html(data);
		},
        dataType:"html"});
});

function iniJabatan(idUnor){
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appskp/tupoksi/detail_unor/",
		data:{"id_unor":idUnor},
		beforeSend:function(){	$("#jabatan").html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p>'); },
		success:function(data){
			$("#jabatan").html(data);
			$("[id^='row_']").remove();
			$('<tr height=20 class=\"tunggu\" style=\"display:none;\"><td colspan=8><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></td></tr>').insertAfter('#gridhead_tugas');
			$('<tr height=20 class=\"tunggu\" style=\"display:none;\"><td colspan=8><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></td></tr>').insertAfter('#gridhead_fungsi');
			$('<tr height=20 class=\"tunggu\" style=\"display:none;\"><td colspan=8><p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p></td></tr>').insertAfter('#gridhead_rincian');
			gettupoksi();
		}, //tutup::success
		dataType:"html"});
}
////////////////////////////////////////////////////////////////////////////
function gettupoksi(){
	$("[id^='row_']").remove();
	var jenis = $("#jenis_jabatan").val();
	var id_unor = $("#idd").html();
	var idj = $("#idj").html();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/tupoksi/gettupoksi/",
				data:{"id_unor":id_unor,"jenis":jenis,"idj":idj},
				beforeSend:function(){	$('.tunggu').show(); },
				success:function(data){

				var table="";
				var no=1;
				$.each( data.tugas, function(index, item){
					if((no % 2) == 1){var seling="odd";}else{var seling="even";}
					table = table+ "<tr height=50 class='gridrow "+seling+"' id=row_"+ item.id_tupoksi +">";
					table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.id_tupoksi+"'>"+no+"</div></b></td>";
						table = table+ "<td class=gridcell align=center>";//tombol aksi
							table = table+ "<div class=\"dropdown\"><button class=\"btn btn-primary dropdown-toggle btn-xs\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\"><span class=\"caret\"></span></button>";
							table = table+ "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu1\">";
							table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('tupoksi/edit','tugas','"+item.id_tupoksi+"');\"><i class=\"fa fa-edit fa-fw\"></i>Edit data</a></li>";
							table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('tupoksi/hapus','tugas','"+item.id_tupoksi+"');\"><i class=\"fa fa-trash fa-fw\"></i>Hapus data</a></li>";
							table = table+ "</ul></div>";
						table = table+ "<td class=gridcell>"+item.isi_tupoksi+"</td>";
				no++;
				}); //endeach tugas
				$(table).insertAfter('#gridhead_tugas');
				$('#footer_tugas').html("<button class=\"btn btn-primary btn-xs\" type=\"button\"   onClick=\"bsmShow('tupoksi/tambah','tugas','x');\">Tambah tugas pokok...</button>");

				var table="";
				var no=1;
				$.each( data.fungsi, function(index, item){
					if((no % 2) == 1){var seling="odd";}else{var seling="even";}
					table = table+ "<tr height=50 class='gridrow "+seling+"' id=row_"+ item.id_tupoksi +">";
					table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.id_tupoksi+"'>"+no+"</div></b></td>";
						table = table+ "<td class=gridcell align=center>";//tombol aksi
							table = table+ "<div class=\"dropdown\"><button class=\"btn btn-primary dropdown-toggle btn-xs\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\"><span class=\"caret\"></span></button>";
							table = table+ "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu1\">";
							table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('tupoksi/edit','fungsi','"+item.id_tupoksi+"');\"><i class=\"fa fa-edit fa-fw\"></i>Edit data</a></li>";
							table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('tupoksi/hapus','fungsi','"+item.id_tupoksi+"');\"><i class=\"fa fa-trash fa-fw\"></i>Hapus data</a></li>";
							table = table+ "</ul></div>";
						table = table+ "</td>";
					table = table+ "<td class=gridcell>"+item.isi_tupoksi+"</td>";
				no++;
				}); //endeach tugas
				$(table).insertAfter('#gridhead_fungsi');
				$('#footer_fungsi').html("<button class=\"btn btn-primary btn-xs\" type=\"button\"   onClick=\"bsmShow('tupoksi/tambah','fungsi','x');\">Tambah fungsi...</button>");

				var table="";
				var no=1;
				$.each( data.rincian, function(index, item){
					if((no % 2) == 1){var seling="odd";}else{var seling="even";}
					table = table+ "<tr height=50 class='gridrow "+seling+"' id=row_"+ item.id_tupoksi +">";
					table = table+ "<td class='gridcell left' align=left><b><div id='nomer_"+item.id_tupoksi+"'>"+no+"</div></b></td>";
					table = table+ "<td class=gridcell align=center>";//tombol aksi
							table = table+ "<div class=\"dropdown\"><button class=\"btn btn-primary dropdown-toggle btn-xs\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\"><span class=\"caret\"></span></button>";
							table = table+ "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu1\">";
							table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('tupoksi/edit','rincian','"+item.id_tupoksi+"');\"><i class=\"fa fa-edit fa-fw\"></i>Edit data</a></li>";
							table = table+ "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('tupoksi/hapus','rincian','"+item.id_tupoksi+"');\"><i class=\"fa fa-trash fa-fw\"></i>Hapus data</a></li>";
							table = table+ "</ul></div>";
					table = table+ "</td>";
					table = table+ "<td class=gridcell style=\"padding-left:10px;\"><span style=\"display:table;\">"+item.isi_tupoksi+"</span></td>";
				no++;
				}); //endeach tugas
				$(table).insertAfter('#gridhead_rincian');
				$('#footer_rincian').html("<button class=\"btn btn-primary btn-xs\" type=\"button\"   onClick=\"bsmShow('tupoksi/tambah','rincian','x');\">Tambah rincian tugas...</button>");

			var pilini=$("#pilini").html();
			$("#tt_"+pilini+"").show();
			$('.tunggu').remove();
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
