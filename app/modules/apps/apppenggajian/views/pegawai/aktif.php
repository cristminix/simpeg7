<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="content-wrapper" style="padding-bottom:30px;">
<div class="row">
		<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
						<div class="row">
								<div class="col-lg-6">
									<div class="dropdown"> Daftar Pegawai Aktif </div>
								</div>
								<div class="col-lg-6">
									<div class="btn-group pull-right" style="padding-left:5px;">
										<button class="btn btn-primary btn-xs" type="button" id="bt_opsi" onclick="buka_div_opsi();"><i class="fa fa-caret-down fa-fw"></i></button>
									</div>
								</div>
						</div>

						<div class="row" id="div_opsi" style="display:none; padding-top:20px;">
			


								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Unit kerja:</label>
													<select id="a_kode_unor" name="a_kode_unor" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<?php
															foreach($unor as $key=>$val){
																echo '<option value="'.$val->kode_unor.'">'.$val->nama_unor.'</option>';															
															}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Status kepegawaian:</label>
													<select id="a_pns" name="a_pns" class="form-control" onchange="gridpaging('end');">
														<option value="all" selected>Semua...</option>
														<option value="kontrak">KONTRAK</option>
														<option value="capeg">CAPEG</option>
														<option value="tetap">TETAP</option>
													</select>
											</div>
											<div class="form-group">
												<label>Pangkat / golongan:</label>
													<select id="a_pangkat" name="a_pangkat" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<?php
															foreach($pkt as $key=>$val){
																if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}
															}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Jenis jabatan:</label>
													<select id="a_jabatan" name="a_jabatan" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<?php
															foreach($jbt as $key=>$val){
																if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}
															}
														?>
													</select>
											</div>
										
										
										</div>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Gender:</label>
													<select id="a_gender" name="a_gender" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<option value="l">Laki-laki</option>
														<option value="p">Perempuan</option>
													</select>
											</div>
											<div class="form-group">
												<label>Agama:</label>
													<select id="a_agama" name="a_agama" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<?php
															foreach($agama as $key=>$val){	if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}	}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Status perkawinan:</label>
													<select id="a_status" name="a_status" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<?php
															foreach($status as $key=>$val){	if($key!=""){	echo '<option value="'.$key.'">'.$val.'</option>';	}	}
														?>
													</select>
											</div>
											<div class="form-group">
												<label>Jenjang pendidikan:</label>
													<select id="a_jenjang" name="a_jenjang" class="form-control" onchange="gridpaging('end');">
														<option value="" selected>Semua...</option>
														<?php
															foreach($jenjang as $key=>$val){	if($key!=""){	echo '<option value="'.$val.'">'.$val.'</option>';	}	}
														?>
													</select>
											</div>
										</div>
									</div>
								</div>
						</div>
		</div>
		<div class="panel-body" style="padding-left:5px;padding-right:5px;">

<div class="row">
	<div class="col-lg-6" style="margin-bottom:5px;">
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
                                <input id="a_caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="<?=$cari;?>">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
<div style="float:right; margin:7px 0px 0px 0px;">Cari:</div>
	</div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->



			<div class="table-responsive">
<table class="table table-striped table-bordered table-hover" style="width:1024px;">
<thead>
<tr>
<th style="width:35px;text-align:center; vertical-align:middle">No.</th>
<th style="width:30px;text-align:center; vertical-align:middle;padding:0px;">AKSI</th>
<th style="width:250px;text-align:center; vertical-align:middle">NAMA PEGAWAI ( GENDER )<br />TEMPAT, TANGGAL LAHIR<br />NIP</th>
<th style="width:160px;text-align:center; vertical-align:middle">PANGKAT (Gol.)<br />TMT PANGKAT<br /> STS PEGAWAI</th>
<th style="width:250px;text-align:center; vertical-align:middle">JABATAN<br/>UNIT KERJA<br/>TMT JABATAN</th>
</tr>
</thead>
<tbody id=list>
</tbody>
</table>
			</div>
			<!-- table-responsive --->
	<div id=paging></div>

											<div id="paging_print" style="display:none;"></div>


		</div>
	</div>
		</div>
		<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.content -->
<div id="form-wrapper" style="padding-bottom:30px; display:none;"></div>

 <div class="row" id="detailpegawai" style="display:none;">
	<div class="col-lg-12">
     <div class="panel panel-default">
     <div class="panel-body" style="padding:0px;">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist" id="myTab">
			<li class="active"><a href="#dropdown0" role="tab" data-toggle="tab">
				<i class="fa fa-user fa-fw"></i> Profil</a></li>
			<li class="dropdown">
				<a href="#" id="myTabDrop1" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-book fa-fw"></i> Biodata <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a href="#dropdown11" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('utama','dropdown11');return false;">
						<i class="fa fa-briefcase fa-fw"></i> Data Utama</a></li>
					<li><a href="#dropdown16" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('foto','dropdown16');return false;">
						<i class="fa fa-file-picture-o fa-fw"></i> Foto</a></li>
					<li><a href="#dropdown12" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('alamat','dropdown12');return false;">
						<i class="fa fa-home fa-fw"></i> Alamat</a></li>
					<li><a href="#dropdown13" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('pernikahan','dropdown13');return false;">
						<i class="fa fa-institution fa-fw"></i> Pernikahan</a></li>
					<li><a href="#dropdown14" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('anak','dropdown14');return false;">
						<i class="fa fa-child fa-fw"></i> Anak</a></li>
						
					<li><a href="#dropdown151" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('orangtua','dropdown151');return false;">
						<i class="fa fa-user fa-fw"></i> Orang Tua</a></li>
					
					<li><a href="#dropdown15" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('pendidikan','dropdown15');return false;">
						<i class="fa fa-graduation-cap fa-fw"></i> Pendidikan</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" id="myTabDrop2" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-list-alt fa-fw"></i> Data Kepegawaian<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="myTabDrop1">
					<li><a href="#dropdown21" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('kontrak','dropdown21');return false;">
						<i class="fa fa-star-half-o fa-fw"></i> KONTRAK</a></li>
					<li><a href="#dropdown22" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('capeg','dropdown22');return false;">
						<i class="fa fa-star fa-fw"></i> CAPEG</a></li>
					<li><a href="#dropdown222" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('tetap','dropdown222');return false;">
						<i class="fa fa-star fa-fw"></i> TETAP</a></li>
					<li><a href="#dropdown23" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('kepangkatan','dropdown23');return false;">
						<i class="fa fa-signal fa-fw"></i> Kepangkatan</a></li>
					<li><a href="#dropdown24" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('jabatan','dropdown24');return false;">
						<i class="fa fa-tasks fa-fw"></i> Jabatan</a></li>
					<li><a href="#dropdown25" tabindex="-1" role="tab" data-toggle="tab" 
					onclick="viewTabPegawai('kediklatan','dropdown25');return false;">
						<i class="fa fa-graduation-cap fa-fw"></i> Kediklatan</a></li>
				</ul>
			<li><a href="#dropdown99" role="tab" data-toggle="tab" onclick="viewDaftarPegawai();return false;">
				<i class="fa fa-chevron-circle-left fa-fw"></i> Kembali ke Daftar Pegawai</a></li>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content" style="padding:5px;">
		  <div class="tab-pane fade in active" id="dropdown0">...</div>
		  <div class="tab-pane fade" id="dropdown11">Data Utama</div>
		  <div class="tab-pane fade" id="dropdown12">12</div>
		  <div class="tab-pane fade" id="dropdown16">16</div>
		  <div class="tab-pane fade" id="dropdown13">13</div>
		  <div class="tab-pane fade" id="dropdown14">14</div>
		  <div class="tab-pane fade" id="dropdown151">151</div>
		  <div class="tab-pane fade" id="dropdown15">15</div>
		  <div class="tab-pane fade" id="dropdown21">21</div>
		  <div class="tab-pane fade" id="dropdown22">22</div>
		  <div class="tab-pane fade" id="dropdown222">222</div>
		  <div class="tab-pane fade" id="dropdown23">23</div>
		  <div class="tab-pane fade" id="dropdown24">24</div>
		  <div class="tab-pane fade" id="dropdown25">25</div>
		  <div class="tab-pane fade" id="dropdown3">3</div>
		</div>
	</div>
	<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
  </div>
<!-- /.row -->





<script type="text/javascript">
function viewDetailPegawai(id_pegawai){
  $("div.tab-content div.tab-pane").html('');
	$("#dropdown0").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i></p>');
  loadDetailPegawai(id_pegawai);
  $('#myTab a:first').tab('show');
	$("#detailpegawai").toggle();
	$("#content-wrapper").toggle();
}
function loadDetailPegawai(id_pegawai){
	$.ajax({
        url: '<?php echo site_url('datapegawai/getprofile_ro');?>',
        data: {id_pegawai:id_pegawai},
        type: 'post',
        dataType: 'html',
        success: function(response) {
          $("#dropdown0").html(response);
        },
        error: function(response) {
           alert('Gagal koneksi ke server'); 
        }
    });
}
function viewTabPegawai(section,targetArea){
	$("#"+targetArea).html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></p>');
	var id_pegawai = false;
	id_pegawai = $("#dropdown0 #id_pegawai").val();
	if(!id_pegawai){
		alert('kesalahan.reload kembali');
		return false;
	}
	$.ajax({
        url: '<?php echo site_url('datapegawai/gettab_ro');?>',
        data: {id_pegawai:id_pegawai,m:section,f:'view'},
        type: 'post',
        dataType: 'html',
        success: function(response) {
			$("#"+targetArea).html(response);
        },
        error: function(response) {
           alert('Gagal koneksi ke server'); 
        }
    });
}
function viewDaftarPegawai(){
//	$("#subtext-pegawai").html('');
	$("#detailpegawai").toggle();
	$("#content-wrapper").toggle();
}

function loadForm(id_pegawai,ID,m,f,targetID){
	$('#'+targetID).html('');
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('datapegawai/getform');?>",
		cache: false,
		data: { id_pegawai: id_pegawai ,ID: ID, m: m, f: f}
		}).done(function( html ) {
			$('#'+targetID).html(html);
	});
}
function cancelForm(targetID){
	$('#'+targetID).html('');
}
function submitForm(id_pegawai,ID,m,f,targetID){
	$('#'+targetID).html('');
	$.ajax({
		type: "POST",
		url: "<?php echo site_url('datapegawai/getform');?>",
		cache: false,
		data: { id_pegawai: id_pegawai ,ID: ID, m: m, f: f}
		}).done(function( html ) {
			$('#'+targetID).html(html);
	});
}


$(document).ready(function(){
	gridpaging(<?=$hal;?>);
});
function gridpaging(hal){
var cari = $('#a_caripaging').val();
var batas = $('#item_length').val();
var kode = $('#a_kode_unor').val();
var pns = $('#a_pns').val();
var pkt = $('#a_pangkat').val();
var jbt = $('#a_jabatan').val();
var ese = $('#a_ese').val();
var tugas = $('#a_tugas').val();
var gender = $('#a_gender').val();
var agama = $('#a_agama').val();
var status = $('#a_status').val();
var jenjang = $('#a_jenjang').val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>apppenggajian/pegawai/getaktif",
		data:{"hal": hal, "batas": batas,"cari":cari,"pns":pns,"kode":kode,"pkt":pkt,"jbt":jbt,"ese":ese,"tugas":tugas,"gender":gender,"agama":agama,"status":status,"jenjang":jenjang},
		beforeSend:function(){	
			$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
			$('#paging').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){
					table = table+ "<tr id='row_"+item.id_unor+"'>";
					table = table+ "<td style='padding:3px;'>"+no+"</td>";
	//tombol aksi-->
					table = table+ "<td valign=top style='padding:3px 0px 0px 0px;' align=center>";
						table = table+ '<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
						table = table+ '<ul class="dropdown-menu" role="menu">';
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'pangkat\',\''+item.id_pegawai +'\');"><i class="fa fa-signal fa-fw"></i> Update Kepangkatan</a></li>';
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'jabatan\',\''+item.id_pegawai +'\');"><i class="fa fa-tasks fa-fw"></i> Update Jabatan</a></li>';
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'sanksi\',\''+item.id_pegawai +'\');"><i class="fa fa-exclamation fa-fw"></i> Update Sanksi</a></li>';
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'penghargaan\',\''+item.id_pegawai +'\');"><i class="fa fa-tags fa-fw"></i> Update Penghargaan</a></li>';
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'kesehatan\',\''+item.id_pegawai +'\');"><i class="fa fa-stethoscope fa-fw"></i> Update Riwayat Kesehatan</a></li>';
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'psikotes\',\''+item.id_pegawai +'\');"><i class="fa fa-ticket  fa-fw"></i> Update Riwayat Psikotes</a></li>';
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'pengalaman\',\''+item.id_pegawai +'\');"><i class="fa fa-list-alt  fa-fw"></i> Update Pengalaman</a></li>';
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'diklat\',\''+item.id_pegawai +'\');"><i class="fa fa-graduation-cap  fa-fw"></i> Update Riwayat Diklat</a></li>';
						
						// table = table+ '<li role="presentation" class="divider">';
						table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onclick="viewDetailPegawai('+item.id_pegawai+');return false;"><i class="fa fa-binoculars fa-fw"></i> Lihat Rincian Data Pegawai</a></li>';
			
						
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onclick="ppost('+item.id_pegawai+',\'admin/module/appdok/edok\');"><i class="fa fa-file-o fa-fw"></i> Dokumen Elektronik</a></li>';
						// table = table+ '<li role="presentation"><a href="<?=site_url();?>appdok/cetak/index/'+item.id_pegawai+'" role="menuitem" tabindex="-1" target="_blank" style="cursor:pointer;"><i class="fa fa-file-pdf-o fa-fw"></i> Cetak CV</a></li>';
						
						// table = table+ '<li role="presentation" class="divider">';
						// table = table+ '<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm(\'userskp\',\''+item.id_pegawai +'\');"><i class="fa fa-plug fa-fw"></i> Setup User SKP</a></li>';
						table = table+ "</ul>";
						table = table+ "</div>";
					table = table+ "</td>";
	//tombol aksi<--
					table = table+ "<td style='padding:3px;'><b>"+item.nama_pegawai+"</b> ("+item.gender+")<br/>"+item.tempat_lahir+", "+item.tanggal_lahir+"<br/>"+item.nip_baru+"</td>";
					table = table+ "<td style='padding:3px;'>" +item.nama_pangkat+" ("+item.nama_golongan+")<br />"+item.tmt_pangkat+"<br />"+item.status_pegawai+"</td>";
					if(item.tugas_tambahan=='xx' || item.tugas_tambahan=='') {
						table = table+ "<td style='padding:3px;'>" +item.nomenklatur_jabatan+"<br/><u>pada</u><br/>"+item.nomenklatur_pada+"<br/><u>sejak</u>: "+item.tmt_jabatan+"</td>";
					} else {
						table = table+ "<td style='padding:3px;'>" +item.nomenklatur_jabatan+" ("+item.tugas_tambahan+") <br/><u>pada</u><br/>"+item.nomenklatur_pada+"<br/><u>sejak</u>: "+item.tmt_jabatan+"</td>";
					}
					table = table+ "</tr>";
					no++;
				}); //endeach
					$('#list').html(table);
					$('#paging').html(data.pager);
var ini="";
for(i=0;i<data.seg_print;i++){
	var jj = (i*data.bat_print)+1;
	var kk = (i+1)*data.bat_print;
	ini = ini + '<div onclick="cetak('+(i+1)+');"  class="btn btn-success btn-xs" style="margin-right:10px;margin-top:5px;">Hal. '+(i+1)+' (item no.'+jj+' - '+kk+')</div><br/>';
}
					$('#paging_print').html(ini);

			} else {
				$('#list').html("<tr id=isi class=gridrow><td colspan=8 align=center><b>Tidak ada data</b></td></tr>");
				$('#paging').html("");
			} // end if
		}, // end success
	dataType:"json"}); // end ajax
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}
function setForm(aksi,idd){
var cari = $('#a_caripaging').val();
var batas = $('#item_length').val();
var hal=$("#inputpaging").val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>apppenggajian/pegawai/form"+aksi,
		data:{"hal": hal, "batas": batas,"cari":cari,"idd":idd},
		beforeSend:function(){	
			$('#content-wrapper').hide();
			$('#form-wrapper').html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>').show();
		},
		success:function(data){
			$('#form-wrapper').html(data);
		}, // end success
	dataType:"html"}); // end ajax
}
function batal(aksi,idd){
	$('#content-wrapper').show();
	$('#form-wrapper').hide();
}

function buka_div_opsi(){
	$('#bt_opsi').html('<i class="fa fa-caret-up fa-fw"></i>').attr('onclick','tutup_div_opsi();');
	$('#div_opsi').show();
}

function tutup_div_opsi(){
	$('#bt_opsi').html('<i class="fa fa-caret-down fa-fw"></i>').attr('onclick','buka_div_opsi();');
	$('#div_opsi').hide();
}
// function cetak_excel(){
// 	var ini = $('#paging_print').html();
// 	ini = ini + '<div onclick="batal(1,2);" class="btn btn-primary" style="margin-top:25px;"><i class="fa fa-fast-backward fa-fw"></i> Kembali</div>';
// 			$('#content-wrapper').hide();
// 			$('#form-wrapper').html(ini).show();
// }
// function cetak(hal){
// 	window.open("<?=site_url();?>apppenggajian/cetak/index/"+hal,"_blank");
// }



</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}

.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px; padding-left: 10px;}
</style>
