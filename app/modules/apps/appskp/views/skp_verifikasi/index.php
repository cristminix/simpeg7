<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><i class="fa fa-user fa-fw"></i><b>Verifikatur</b></div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=(trim($verifikatur->gelar_depan) != '-')?trim($verifikatur->gelar_depan).' ':'';?><?=(trim($verifikatur->gelar_nonakademis) != '-')?trim($verifikatur->gelar_nonakademis).' ':'';?><?=$verifikatur->nama_pegawai;?><?=(trim($verifikatur->gelar_belakang) != '-')?', '.trim($verifikatur->gelar_belakang):'';?></div></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$verifikatur->nip_baru;?></div></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:95px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$verifikatur->nama_pangkat;?> / <?=$verifikatur->nama_golongan;?></div></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:95px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$verifikatur->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:95px;">Unit kerja</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$verifikatur->nomenklatur_pada;?></div></span>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-6" style="margin-bottom:5px;">
<div style="clear:both;"></div>
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="margin-bottom:5px;">
                            <div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
                                <input id="caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
<div style="float:right; margin:7px 5px 0px 0px;">Cari:</div>
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div id="grid-data">
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
<table width class="table info table-striped table-bordered table-hover" style="margin-bottom:5px;">
<thead id=gridhead>
	<tr height=20>
		<th style="padding:0px; width:50px;">No.</th>
		<th style="padding:0px; width:50px;">AKSI</th>
		<th style="width:300px;">TAHUN / PERIODE / STATUS</th>
		<th style="width:350px;" align=center>PEJABAT PENILAI</th>
		<th style="width:350px;" align=center>PEGAWAI</th>
	</tr>
</thead>
<tbody id=list>
	<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tbody>
</table>
		</div>
		<!-- table-responsive --->
	<div id=paging></div>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.grid-data -->
<br/><br/>
<script type="text/javascript">
$(document).ready(function(){
	gridpaging(1);
});
function gridpaging(hal){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/skp_verifikasi/getdata/",
				data:{"hal": hal, "batas": batas,"cari":cari},
				beforeSend:function(){	
					$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
					$('#paging').html('');
				},
				success:function(data){
if((data.hslquery.length)>0){
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				table = table+ "<tr><td>"+no+"</td>";
				table = table+ "<td align=center><a href='#' onclick='alih("+item.id_skp+"); return false;' style='cursor:pointer;'><button class='btn btn-primary btn-xs'><i class='fa fa-binoculars fa-fw'></i></button></a></td>";
				table = table+ "<td>"+item.tahun+"<br/>"+item.bulan_mulai+" s.d. "+item.bulan_selesai+"<br/>"+item.status+"</td>";
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<div style="float:left; width:65px;">Nama</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span><div style="display:table;">'+item.penilai_nama_pegawai+'</div></span>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">NIP</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span>'+item.penilai_nip_baru+'</span>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">Pkt/Gol.</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span>'+item.penilai_nama_pangkat+' / '+item.penilai_nama_golongan+'</span>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">Jabatan</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span><div style="display:table;">'+item.penilai_nomenklatur_jabatan+'</div><span>';
				table = table+ '</div>';
				table = table+ '<div style="float:left; width:65px;">Unit kerja</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span><div style="display:table;">'+item.penilai_nomenklatur_pada+'</div><span>';
				table = table+ '</div></td>';
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<div style="float:left; width:65px;">Nama</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<div style="float:left;"><b>'+item.nama_pegawai+'</b></div>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">NIP</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span>'+item.nip_baru+'</span>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">Pkt/Gol.</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span>'+item.nama_pangkat+' / '+item.nama_golongan+'</span>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">Jabatan</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span><div style="display:table;">'+item.nomenklatur_jabatan+'</span></div>';
				table = table+ '</div>';
				table = table+ '<div style="clear:both">';
				table = table+ '<div style="float:left; width:65px;">Unit kerja</div>';
				table = table+ '<div style="float:left; width:10px;">:</div>';
				table = table+ '<span><div style="display:table;">'+item.nomenklatur_pada+'</div><span>';
				table = table+ '</div></td>';
				table = table+ "</tr>";
			no++;
			}); //endeach
				$('#list').html(table);
				$('#paging').html(data.pager);
		} else {
			$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
			$('#paging').html("");
		} // end if
		}, // end success
        dataType:"json"});
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
function alih(idd){
	$.ajax({	type:"POST",	url:"<?=site_url();?>appskp/skp/alih_skp",	data:{"idd": idd},	success:function(data){	pindah();	}, dataType:"html"});
}
function pindah(){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>appskp/skp_verifikasi/target/",
				beforeSend:function(){	$('#page-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');	},
				success:function(data){	$('#page-wrapper').html(data);	}, // end success
	        dataType:"html"});
}
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.page.gradient { color: #000066; BACKGROUND-COLOR:#FFFFFF; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px;}
.page.gradient:hover {color: #FF0000; BACKGROUND-COLOR: #FFFF00; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px; cursor: pointer;}
.page.active {color: #ffffff; BACKGROUND-COLOR: #0066FF; border: 1px solid #0066FF; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px}
.pagingframe {float: right;}
</style>