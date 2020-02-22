<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header">Cetak Lembar Penilaian Prestasi Kerja PNS</h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row" id="pageForm" style="display:none;">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading">
				<span id="kopForm"></span>
				<button class="btn btn-info btn-xs pull-right" onclick="tutupForm();"><i class="fa fa-close fa-fw"></i></button>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body" style="padding-top:15px; padding-bottom:5px; padding-right:5px; padding-left:5px;">
			<form id="pageFormTo" method="post" action="" enctype="multipart/form-data">
				<div id="isiForm"></div>
				<div id="tbForm" style="text-align:right;">
					<button id="btAct"></button>
					<button type=button class="btn btn-default" onClick='tutupForm();'><i class="fa fa-fast-backward fa-fw"></i> Batal...</button>
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

<div class="row" id="pageKonten">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
					<div style="float:left;">
						<div class="btn btn-primary dropdown-toggle btn-xs"  onClick="setForm('arsip','1','1'); return false;"><span class="fa fa-book fa-fw"></span></div>
					</div>
					<span style="margin-left:5px;"><b>SKP TAHUN <?=$tahun;?> Periode <?=$bulan[$skp->bulan_mulai]." s.d. ".$bulan[$skp->bulan_selesai];?></b></span>
			</div>
			<div class="panel-body">
				
				<div class="row">
					<div class="col-lg-6">
						<form>
							<!-- Nama Pejabat Penilai -->
							<div class="form-group">
								<label >Nama Pejabat Penilai</label> : <br/>
								<?php echo form_input('penilai_nama_pegawai',$skp->penilai_nama_pegawai.' / '.$skp->penilai_nip_baru,'class="form-control" disabled');?>
							</div>
							
							<!-- Nama Atasan Pejabat Penilai -->
							<div class="form-group">
								<label >Nama Atasan Pejabat Penilai :</label>
								<?php $id_penilai_atasan = isset($atasan->id_pegawai)?$atasan->id_pegawai:false;?>
								<?php $penilai_atasan = isset($atasan->id_pegawai)?$atasan->nama_pegawai.' / '.$atasan->nip_baru:'';?>
								<?php echo form_hidden('id_penilai_atasan',$id_penilai_atasan);?>

								<?php echo form_input('penilai_atasan',$penilai_atasan,'class="form-control" disabled');?>
							</div>
						</form>					
						
					</div>
					<div class="col-lg-6">
						<!-- Nama Pegawai -->
						<div class="form-group">
							<label >Nama Pegawai</label> : <br/>
							<?php echo form_input('nama_pegawai',$skp->nama_pegawai.' / '.$skp->nip_baru,'class="form-control" disabled');?>
						</div>
					</div>
					<!-- /.col-lg-6 -->		
				</div>
				<!-- /.row -->	

				<div class="row" id="step_area">
					<?php echo $step_content;?>
				</div>
				<!-- /.row -->
				
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->


	
<script type="text/javascript">
function buka_hitung(){
	$('#hasil').hide();
	$('#hitung').show();
	$('#bt_hitung').attr('title','Tutup Perhitungan').attr('onclick','tutup_hitung();return false;').html('<i class="fa fa-chevron-circle-up fa-fw"> Tutup Perhitungan</i>');
	bukaHitung();
}
function tutup_hitung(){
	$('#hasil').show();
	$('#hitung').hide();
	$('#bt_hitung').attr('title','Lihat Perhitungan').attr('onclick','buka_hitung();return false;').html('<i class="fa fa-chevron-circle-down fa-fw"> Lihat Perhitungan</i>');
}

function tutupForm(){
	$('#pageForm').hide();
	$('#pageKonten').show();
}

function bukaHitung(){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/penilaian/buka_hitung",
			beforeSend:function(){	
				$("#hitung").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
			},
			success:function(data){
				$('#hitung').html(data);
			},
			dataType:"html"});
}

function setForm(tujuan,idd,no){
	var kop = []; 
	kop['arsip'] = "DAFTAR ARSIP SKP"; 
	var act = []; 
	act['arsip'] = ""; 
	var btt = []; 
	btt['arsip'] = "<div id='btAct'></div>"; 
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/penilaian/"+tujuan,
			data:{"idd": idd },
			beforeSend:function(){	
				$("#pageKonten").hide();
				$('#kopForm').html(kop[tujuan]);
				$('#btAct').replaceWith('<div id="btAct"></div>');
				$('#pageFormTo').attr('action',act[tujuan]);
				$("#isiForm").html('<p class="text-center"><i class="fa fa-spinner fa-spin fa-5x"></i><p>');
				$("#pageForm").show();
			},
			success:function(data){
				$('#btAct').replaceWith(btt[tujuan]);
				$('#isiForm').html(data);
			},
			dataType:"html"});
}
	function cetak_hitung(){
			window.open( "<?php echo site_url('appskp/xls_skp_hitung');?>",'_blank');
	}
</script>

<script type="text/javascript">
	function cetak_skp(){
			window.open( "<?php echo site_url('appskp/penilaian/download');?>",'_blank');
	}
	function load_step_1(){
		$.post(
			'<?= site_url('appskp/penilaian/load_step_1'); ?>', 
			{}, 
			function(result){
				if(result.success)
				{
					$('#step_area').html(result.step_content);
				}
				else
				{
					alert(result.message);
				}
		},
		'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
		// console.log('huya');
	}
	function step_1(id_skp_penilai,id_penilai_atasan){
		// console.log(id_skp_penilai);
		$.post('<?= site_url('appskp/penilaian/load_step_2'); ?>', {id_skp_penilai:id_skp_penilai}, function(result){
			// console.log(result);
			if(result.success)
			{
				$('input[name="id_penilai_atasan"]').val(id_penilai_atasan);
				$('input[name="penilai_atasan"]').val(result.message);
				$('#step_area').html(result.step_content);
			}
			else
			{
				alert(result.message);
			}
		},'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
		
	}
	function hapus_skp_luar(id){
		$.post('<?= site_url('appskp/penilaian/hapus_skp_luar'); ?>', {id:id}, function(result){
			if(result.success)
			{
				reload_step_2();
			}
			else
			{
				alert(result.message);
			}
		},'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
	}
	function tambah_skp_luar(){
		var data = {
			bulan_mulai : $('select[name="bulan_mulai"]').val(),
			bulan_selesai : $('select[name="bulan_selesai"]').val(),
			jumlah : $('input[name="skp_luar_jumlah"]').val(),
			pembagi : $('input[name="skp_luar_pembagi"]').val()
		};
		if(data.bulan_mulai == "" || data.bulan_selesai == "" || data.jumlah == "" || data.pembagi == "" ) 
		{
			alert('Silahkan lengkapi isian anda terlebih dahulu.');
			return false;
		}
		$.post('<?= site_url('appskp/penilaian/tambah_skp_luar'); ?>', data, function(result){
			if(result.success)
			{
				reload_step_2();
			}
			else
			{
				alert(result.message);
			}
		},'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
	}
	function reload_step_2(){
		$.post('<?= site_url('appskp/penilaian/reload_step_2'); ?>', {}, function(result){
			if(result.success)
			{
				$('#step_area').html(result.step_content);
			}
			else
			{
				alert(result.message);
			}
		},'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
	}
	function step_2(){
		$.post('<?= site_url('appskp/penilaian/load_step_2'); ?>', {}, function(result){
			if(result.success)
			{
				$('#step_area').html(result.step_content);
			}
			else
			{
				alert(result.message);
			}
		},'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
		
	}
	function step_2b(){
		$.post('<?= site_url('appskp/penilaian/load_step_2b'); ?>', {}, function(result){
			if(result.success)
			{
				$('#step_area').html(result.step_content);
			}
			else
			{
				alert(result.message);
			}
		},'json')
		.fail(function(jqXHR, textStatus, errorThrown){
			alert('Gagal mengirim data ke server.');
		});
		
	}
	$(document).ready(function() {
	});
</script>
