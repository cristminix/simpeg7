<?php 		date_default_timezone_set('UTC'); ?>
<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="content-wrapper" style="padding-bottom:30px;">
<div class="row target">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
	<div style="float:left;">
		<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-refresh fa-fw"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuT">
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('baru','xx','1');"><i class="fa fa-star fa-fw"></i> Buat Rancangan Mutasi Baru</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('edit','<?=$rancangan->id_rancangan;?>','1');"><i class="fa fa-edit fa-fw"></i> Edit Rancangan Mutasi</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('hapus','<?=$rancangan->id_rancangan;?>','1');"><i class="fa fa-trash fa-fw"></i> Hapus Rancangan Mutasi</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('ajukan','<?=$rancangan->id_rancangan;?>','1');"><i class="fa fa-upload fa-fw"></i> Ajukan kepada BAPERJAKAT</a></li>
				<li role="presentation" class="divider"></li>
				<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setForm('arsip','1','1');"><i class="fa fa-binoculars fa-fw"></i> Lihat Arsip Rancangan Mutasi</a></li>
			</ul>
		</div>
	</div>
			<span style="margin-left:5px;" id=judul_skp><b><?=$rancangan->nama_rancangan;?></b></span>
			</div>
			<div class="panel-body" style="padding-top:5px; padding-bottom:5px;">
								<div class="row">
									<div class="col-lg-12">
										<div style="float:left; width:95px;">Tahun</div>
										<div style="float:left; width:10px;"> : </div>
										<span><div style="display:table;"><?=$rancangan->tahun;?></div></span>
									</div>
								</div>
								<div class="row" id=status_skp>
									<div class="col-lg-12">
										<div style="float:left; width:95px;">Periode</div>
										<div style="float:left; width:10px;"> : </div>
										<span><div style="display:table;" id="tg_jab"><?=$rancangan->periode;?></div></span>
									</div>
								</div>
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
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
									<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="ddMenuT" data-toggle="dropdown"><span class="fa fa-recycle fa-fw"></span></button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="ddMenuT">
											<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-list fa-fw"></i> Rancangan Daftar Pemangku Jabatan Struktural</a></li>
											<li role="presentation"><a href="<?=site_url('admin/module/appbkpp/mutasi/rancangan_hasil');?>" role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-toggle-off fa-fw"></i> Daftar Mutasi Hasil Rancangan</a></li>
											<li role="presentation"><a href="<?=site_url('admin/module/appbkpp/mutasi/rancangan_kosong');?>" role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-toggle-off fa-fw"></i> Daftar Jabatan Kosong</a></li>
											<li role="presentation"><a href="<?=site_url('admin/module/appbkpp/mutasi/rancangan_rangkap');?>" role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-toggle-on fa-fw"></i> Daftar Jabatan Rangkap</a></li>
										</ul>
			<span style="margin-left:5px;" id=judul_skp><b>Rancangan Daftar Pemangku Jabatan Struktural</b></span>
									</div>
								</div>
								<div class="col-lg-6" style="display:none;">
									<input id="iptTanggal" class="form-control" type="text" onchange="gridpaging(1);" value="<?=date("d-m-Y");?>" style="float:right; width:100px; padding:3px; background-color:#FFFF99; height:26px;">
									<div style="float:right; padding-top:3px;padding-right:5px;">due-Date: </div>
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
                                <input id="caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="<?=$cari;?>">
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
			<form id="form_sub" method="post" action="" enctype="multipart/form-data">
<table class="table table-striped table-bordered table-hover" style="width:1024px;">
<thead>
<tr>
<th style="width:55px;text-align:center; vertical-align:middle">No.</th>
<th style="width:400px;text-align:center; vertical-align:middle">JABATAN STRUKTURAL<br /><b> UNIT KERJA</b></th>
<th style="width:545px;text-align:center; vertical-align:middle">PEMANGKU JABATAN</th>
</tr>
</thead>
<tbody id=list></tbody>
</table>
			</form>
			</div>
			<!-- table-responsive --->
	<div id=paging></div>
		</div>
	</div>
		</div>
		<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.content -->


<div class="row" id="form-wrapper" style="padding-bottom:30px; display:none;">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<span id="kopForm"></span>
				<button class="btn btn-info btn-xs pull-right" onclick="batal('cc','xx');"><i class="fa fa-close fa-fw"></i></button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body" style="padding-top:15px; padding-bottom:5px; padding-right:5px; padding-left:5px;">
			<form id="pageFormTo" method="post" action="" enctype="multipart/form-data">
				<div id="isiForm"></div>
				<div id="tbForm" style="text-align:right;">
					<button id="btAct"></button>
					<button type=button class="btn btn-default" onClick="batal('cc','xx');"><i class="fa fa-fast-backward fa-fw"></i> Batal...</button>
				</div>
			</form>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel-default -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.pageForm -->








<script type="text/javascript">
$(document).ready(function(){
	gridpaging(<?=$hal;?>);
});
function gridpaging(hal){
var cari = $('#caripaging').val();
var batas = $('#item_length').val();
var tanggal = $('#iptTanggal').val();
	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/mutasi/getdata",
		data:{"hal": hal, "batas": batas,"tanggal":tanggal,"cari":cari},
		beforeSend:function(){	
			$('#list').html('<tr><td colspan=6><p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p></td></tr>');
			$('#paging').html('');
		},
		success:function(data){
			if((data.hslquery.length)>0){
				var table="";
				var no=data.mulai;
				$.each( data.hslquery, function(index, item){

					var pemangku="";

					if(item.pejabat){
							var no2 = 1;
							$.each( item.pejabat, function(index, item2){
								pemangku = pemangku+'<div style="clear:both;padding-bottom:10px;">';
									pemangku = pemangku+'<div>';
										pemangku = pemangku+'<div style="float:left;padding-right:5px;">';
											pemangku = pemangku+'<div class="dropdown"><button class="btn btn-default dropdown-toggle btn-xs" type="button" data-toggle="dropdown"><i class="fa fa-caret-down fa-fw"></i></button>';
											pemangku = pemangku+'<ul class="dropdown-menu" role="menu">';
											pemangku = pemangku+'<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSub(\'lihat\',\''+item2.id_pegawai +'\',\''+item.id_unor +'\');"><i class="fa fa-binoculars fa-fw"></i> Lihat rincian data pegawai</a></li>';
											pemangku = pemangku+'<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="setSub(\'kembali\',\''+item2.id_pegawai +'\',\''+item.id_unor +'\');"><i class="fa fa-fast-backward fa-fw"></i> Kembalikan ke jabatan semula</a></li>';
											pemangku = pemangku+'</ul>';
											pemangku = pemangku+'</div>';
										pemangku = pemangku+'</div>';
										pemangku = pemangku+'<span><div style="display:table;">'+item2.nama_pegawai+'</div></span>';
									pemangku = pemangku+'</div>';
									pemangku = pemangku+'<div style="clear:both;">';
										pemangku = pemangku+'<div style="width:105px;float:left;">NIP / Pangkat</div>';
										pemangku = pemangku+'<div style="width:10px;float:left;">:</div>';
										pemangku = pemangku+'<span><div style="display:table">'+item2.nip_baru+' / '+item2.nama_pangkat+" - "+item2.nama_golongan+'</div></span>';
									pemangku = pemangku+'</div>';
									pemangku = pemangku+'<div>';
										pemangku = pemangku+'<div style="width:105px;float:left;">TMT Pkt/Jab</div>';
										pemangku = pemangku+'<div style="width:10px;float:left;">:</div>';
										pemangku = pemangku+'<span><div style="display:table">'+item2.tmt_pangkat+' /  '+item2.tmt_jabatan+' </div></span>';
									pemangku = pemangku+'</div>';
								pemangku = pemangku+'</div>';
								no2++;
							});
					}
								pemangku = pemangku+'<div style="clear:both;float:right;margin-bottom:0px;">';
								pemangku = pemangku+'<div class="form-group input-group" style="float:left;width:230px;">';
								pemangku = pemangku+'<input id="nip_baru_'+item.id_unor+'" class="form-control row-fluid" type="text" style="padding-left:5px;padding-right:5px;" placeholder="Masukkan NIP kandidat..." value="" name="nip_baru">';
								pemangku = pemangku+'<span class="input-group-btn">';
								pemangku = pemangku+'<button class="btn btn-default" type="button" onclick="cari_nip('+item.id_unor+');"><i class="fa fa-search"></i></button>';
								pemangku = pemangku+'</span>';
								pemangku = pemangku+'</div>';
								pemangku = pemangku+'</div>';
					table = table+ "<tr id='row_"+item.id_unor+"'>";
					table = table+ "<td style='padding:3px;'>"+no+"</td>";
					table = table+ "<td style='padding:3px;'><div id='kol_2_"+item.id_unor+"'>"+item.kode_unor+"<br /><b>"+item.nomenklatur_jabatan+"</b><br />"+item.nama_ese+" - <u>pada</u> :<br />"+item.nomenklatur_pada+"</div></td>";
					table = table+ "<td style='padding:3px;'>"+pemangku+"</td>";
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
	dataType:"json"}); // end ajax
}
function gopaging(){
	var gohal=$("#inputpaging").val();
	gridpaging(gohal);
}

function setForm(tujuan,idd,no){
	var kop = []; 
	kop['baru'] = "FORM RANCANGAN MUTASI BARU"; 
	kop['edit'] = "FORM EDIT RANCANGAN MUTASI"; 
	kop['hapus'] = "FORM HAPUS RANCANGAN MUTASI"; 
	kop['ajukan'] = "FORM PENGAJUAN RANCANGAN MUTASI"; 
	kop['arsip'] = "DAFTAR ARSIP RANCANGAN MUTASI"; 
	var act = []; 
	act['baru'] = "<?=site_url();?>appbkpp/mutasi/baru_aksi"; 
	act['edit'] = "<?=site_url();?>appbkpp/mutasi/edit_aksi"; 
	act['hapus'] = "<?=site_url();?>appbkpp/mutasi/hapus_aksi"; 
	kop['ajukan'] = "<?=site_url();?>appbkpp/mutasi/ajukan_aksi"; 
	act['arsip'] = ""; 
	var btt = []; 
	btt['baru'] = "<button id='btAct' type=button class='btn btn-primary' onclick='simpan(); return false;'><i class='fa fa-save fa-fw'></i> Simpan</button>"; 
	btt['edit'] = "<button id='btAct' type=button class='btn btn-primary' onclick='simpan(); return false;'><i class='fa fa-save fa-fw'></i> Simpan</button>"; 
	btt['hapus'] = "<button id='btAct' type=button class='btn btn-danger' onclick='simpan(); return false;'><i class='fa fa-trash fa-fw'></i> Hapus</button>"; 
	btt['ajukan'] = "<button id='btAct' type=button class='btn btn-primary' onclick='simpan(); return false;'><i class='fa fa-upload fa-fw'></i> Ajukan</button>"; 
	btt['arsip'] = "<div id='btAct'></div>"; 

			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appbkpp/mutasi/"+tujuan,
			data:{"idd": idd },
			beforeSend:function(){	
				$("#content-wrapper").hide();
				$('#kopForm').html(kop[tujuan]);
				$('#btAct').replaceWith('<div id="btAct"></div>');
				$('#pageFormTo').attr('action',act[tujuan]);
				$("#isiForm").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
				$("#form-wrapper").show();
			},
			success:function(data){
				$('#btAct').replaceWith(btt[tujuan]);
				$('#isiForm').html(data);
			},
			dataType:"html"});
}

function batal(aksi,idd){
	$('#content-wrapper').show();
	$('#form-wrapper').hide();
}

function simpan(){
	$.ajax({
		type:"POST",
		url: $("#pageFormTo").attr('action'),
		data: $("#pageFormTo").serialize(),
		beforeSend:function(){	
			$('#form-wrapper').html('<p class=\"text-center\"><i class=\"fa fa-spinner fa-spin fa-5x\"></i><p>');
		},
		success:function(data){
			location.href = '<?=site_url();?>'+'admin/module/appbkpp/mutasi/rancangan';
		},
		dataType:"html"}); // end ajax
}


function cari_nip(idd){
	var tmt_jabatan = $('#tg_jab').html();
	var nip = $('#nip_baru_'+idd).val();

	$.ajax({
		type:"POST",
		url:"<?=site_url();?>appbkpp/mutasi/cari_nip_kandidat",
		data: {"nip":nip, "tmt_jabatan":tmt_jabatan, "id_unor":idd},
		beforeSend:function(){	
//			$('#ipt_nip').hide();
//			$('#ipt_spin').show();
		},
		success:function(data){
			if(data.id_pegawai){
				gopaging();
			} else {
				alert("Pegawai dengan NIP tersebut TIDAK DITEMUKAN... Masukkan NIP Lain!!");
			}
		}, // end success
	dataType:"json"}); // end ajax
}

function setSub(aksi,idd,no){
	$('.btn.batal').click();
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appbkpp/mutasi/formsub_"+aksi,
		data:{"sub":aksi,"idd": idd,"nomor":no },
		beforeSend:function(){
			$('#row_'+no).addClass('success');
			$('<tr id="row_tt" class="success"><td colspan=10><p class="text-center"><i class="fa fa-spinner fa-spin fa-2x"></i><p></td></tr>').insertAfter('#row_'+no);
		},
        success:function(data){
			$('#form_sub').attr('action','<?=site_url("appbkpp/mutasi/formsub_");?>'+aksi+'_aksi');
			$('#row_tt').html('<td colspan=10>'+data+'</td>');
		},
        dataType:"html"});
}

$(document).on('click', '.btn.batal',function(){
	$("[id='row_tt']").each(function(key,val) {	$(this).remove();	});
	$("[id^='row_']").removeClass().show();
});

</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
.pagingframe {	float:right;	}
.pagingframe div {	padding-left:7px;padding-right:7px;	}
</style>