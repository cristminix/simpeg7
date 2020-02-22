<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header">Laporan Pengalaman Pegawai</h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">										
								<button type="button"  style=" float:left; padding-top:3px;padding-left:5px;" class="btn btn-primary" onclick="cetak_excel(jQuery('#iptHal1').val(),jQuery('#iptHal2').val(),jQuery('#iptTanggal').val(),jQuery('#iptTanggal2').val());return false;"><i class="fa fa-print fa-fw"></i> Cetak</button>								
								<div style="float:left; padding-top:3px;padding-left:5px;"> </div>
								<input id="iptHal1" name="iptHal1" class="form-control" type="text"  style="float:left; width:50px; padding:3px;  height:26px;">
								<div style="float:left; padding-top:3px;padding-left:5px;">s.d.  </div>
								<input id="iptHal2" name="iptHal2" class="form-control" type="text"  style="float:left; width:50px; padding:3px;  height:26px;">
								
								<div style="float:left; padding-top:3px;padding-left:5px;"> </div>
								<div style="float:left; padding-top:3px;padding-left:5px;"> </div>
								<div style="float:left; padding-top:3px;padding-left:5px;">Tgl Akhir : </div>
								<div class="container">
								
								<input id="iptTanggal" name="iptTanggal" onchange="gridpaging(1);" value="" class="form-control" type="text"  style="float:left; width:100px; padding:3px; background-color:#FFFF99; height:26px;">
								  <div style="float:left; padding-top:3px;padding-left:5px;">s.d.  </div>
								<input id="iptTanggal2" name="iptTanggal2" onchange="gridpaging(1);" value="" class="form-control" type="text"  style="float:left; width:100px; padding:3px; background-color:#FFFF99; height:26px;">
								
								</div>
								<script type="text/javascript">
								  $(function() {

									$('#iptTanggal').datetimepicker({
										format: 'YYYY-MM-DD',
										pickTime: false
									});
									$('#iptTanggal2').datetimepicker({
										format: 'YYYY-MM-DD',
										pickTime: false
									});
								  });
								</script>

								</div>
								</div>
								
						</div>

						

			</div>
			<div class="panel-body" style="padding-left:5px;padding-right:5px;">
<div class="row">
	<div class="col-lg-6" style="margin-bottom:5px;">
<div style="clear:both;"></div>
<div style="float:left;">
<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
<option value="10" <?=($batas==10)?"selected":"";?>>10</option>
<option value="25" <?=($batas==25)?"selected":"";?>>25</option>
<option value="50" <?=($batas==50)?"selected":"";?>>50</option>
<option value="100" <?=($batas==100)?"selected":"";?>>100</option>
</select>
</div>
<div style="float:left;padding-left:5px;margin-top:6px;">item per halaman</div>
	</div>
	<!-- /.col-lg-6 -->
	<div class="col-lg-6" style="margin-bottom:5px;">
                            <div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
                                <input id="caripaging" onchange="gridpaging(1)" type="text" class="form-control" value="<?=$cari;?>" placeholder="Masukkan kata kunci...">
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
<table class="table table-striped table-bordered table-hover" style="margin-bottom:5px;">
<thead id=gridhead>
	<tr height=20>
		<th style="width:50px;" align=center>No.</th>
		<th style="width:200px;" align=center>NAMA PEGAWAI</th>
		<th style="width:80px;" align=center>NIP</th>
		<th style="width:150px;" align=center>PERUSAHAAN</th>
		<th style="width:150px;" align=center>PEKERJAAN</th>
		<th style="width:80px;" align=center>TGL AWAL</th>
		<th style="width:80px;" align=center>TGL AKHIR</th>
		<th style="width:250px;" align=center>JABATAN</th>
	</tr>
</thead>
<tbody id=list>
	<tr id=isi class=gridrow><td colspan=8 align=center><b>Isi Records</b></td></tr>
</tbody>
</table>
		</div>
		<!-- table-responsive --->
	<div id=paging></div>
	
	<div id="paging_print" style="display:none;"></div>

	
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.grid-data -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<br/><br/>
<script type="text/javascript">
$(document).ready(function(){
	gridpaging('end');
});
function gridpaging(hal){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
var tahun = $('#tahun').val();
var tanggal = $('#iptTanggal').val();
var tanggal2 = $('#iptTanggal2').val();
var kode_unor = $('#kode_unor').val();
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>laporan/sett/get_pengalaman/",
				data:{"hal": hal, "batas": batas,"cari":cari,"tahun":tahun,"kode_unor":kode_unor,"tanggal":tanggal,"tanggal2":tanggal2},
				beforeSend:function(){	
					$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
					$('#paging').html('');
				},
				success:function(data){
if((data.hslquery.length)>0){
			var table="";
			var no=data.mulai;
			$.each( data.hslquery, function(index, item){
				table = table+ "<tr><td align=center>"+no+"</td>";
			
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<span><div style="display:table;">'+item.nama_pegawai+'</div></span>';
				table = table+ '</div>';
				table = table+ '</div></td>';
				table = table+ '<td>';
				table = table+ '<div align=center>';
				table = table+ '<span>'+item.nip_baru+'</span>';
				table = table+ '</td>';
				table = table+ '</div>';
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<span><div style="display:table;">'+item.perusahaan+'</div></span>';
				table = table+ '</div></td>';
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<span><div style="display:table;">'+item.pekerjaan+'</div></span>';
				table = table+ '</div></td>';
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<span><div style="display:table;">'+item.tanggal_awal+'</div></span>';
				table = table+ '</div></td>';
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<span><div style="display:table;">'+item.tanggal_akhir+'</div></span>';
				table = table+ '</div></td>';
				table = table+ '<td>';
				table = table+ '<div>';
				table = table+ '<span><div style="display:table;">'+item.jabatan+'</div></span>';
				table = table+ '</div></td>';
								
				table = table+ '</td>';
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

function gettree(){
var tahun=$("#tahun").val();
$('#kop_tahun').html(tahun);
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>laporan/sett/gettree/",
				data:{"tahun":tahun},
				beforeSend:function(){	
					$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
					$('#paging').html('');
					$('#kode_unor').html('<option value="" selected>Semua...</option>');
				},
				success:function(data){	
					$('#kode_unor').html(data);
					gridpaging('end');
				}, // end success
	        dataType:"html"});
}

function buka_div_opsi(){
	$('#bt_opsi').html('<i class="fa fa-caret-up fa-fw"></i>').attr('onclick','tutup_div_opsi();');
	$('#div_opsi').show();
}

function tutup_div_opsi(){
	$('#bt_opsi').html('<i class="fa fa-caret-down fa-fw"></i>').attr('onclick','buka_div_opsi();');
	$('#div_opsi').hide();
}

function cetak_excel(iptHal1,iptHal2,tgl1,tgl2){
			if ((iptHal1 == '') && (iptHal2!='')){
				alert('cek no cetak');
			}else if (iptHal1>iptHal2){
				alert('cek no cetak');
			}else if ((iptHal1 == '') && (iptHal2=='')){
				var val1='0';
				var val2='0';
				window.open("<?=site_url();?>laporan/xls_pengalaman/index/"+val1+"/"+val2+"/"+tgl1+"/"+tgl2,"_blank");
			}else{
				var val1=iptHal1;
				var val2=iptHal2;
				window.open("<?=site_url();?>laporan/xls_pengalaman/index/"+val1+"/"+val2+"/"+tgl1+"/"+tgl2,"_blank");
			}
			
	}

</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>