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
										<div style="float:left; width:110px;">Nama</div>
										<span> : </span>
										<span><?=(trim($verifikatur->gelar_depan) != '-')?trim($verifikatur->gelar_depan).' ':'';?><?=(trim($verifikatur->gelar_nonakademis) != '-')?trim($verifikatur->gelar_nonakademis).' ':'';?><?=$verifikatur->nama_pegawai;?><?=(trim($verifikatur->gelar_belakang) != '-')?', '.trim($verifikatur->gelar_belakang):'';?></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:110px;">NIP</div>
										<span> : </span>
										<span><?=$verifikatur->nip_baru;?></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:110px;">Pangkat/Gol.</div>
										<span> : </span>
										<span><?=$verifikatur->nama_pangkat;?> / <?=$verifikatur->nama_golongan;?></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:110px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"><?=$verifikatur->nomenklatur_jabatan;?></div></span>
								</div>
								<div style="clear:both;">
										<div style="float:left; width:110px;">Unit kerja</div>
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
//	gridpaging(1);
});
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.page.gradient { color: #000066; BACKGROUND-COLOR:#FFFFFF; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px;}
.page.gradient:hover {color: #FF0000; BACKGROUND-COLOR: #FFFF00; border: 1px solid #3399CC; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px; cursor: pointer;}
.page.active {color: #ffffff; BACKGROUND-COLOR: #0066FF; border: 1px solid #0066FF; float: left; margin:1px; padding: 0px 5px 0px 5px; border-radius: 2px}
.pagingframe {float: right;}
</style>