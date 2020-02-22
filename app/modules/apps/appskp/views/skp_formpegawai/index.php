<div class="row">
	<div class="col-lg-12">
		 <h3 class="page-header">
			Penyusunan Target Sasaran Kerja Pegawai
		 </h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
					 <?php
					$bulan = $this->dropdowns->bulan();
					?>
<div class="row">
	<div class="col-lg-12">
		<div style="text-align:right;padding-bottom:5px;">
			 <a href="<?php echo site_url('admin/module/appskp/skp'); ?>" class="btn btn-primary btn-xl"><i class="fa fa-fast-backward fa-fw"></i> Kembali</a>
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">
			<span><b><?php echo $title;?></b></span>
			</div>
			<div class="panel-body">
					
				<div class="row">
					<div class="col-lg-12">
			<span><b>SKP TAHUN <?=$skp->tahun;?> Periode <?=$bulan[$skp->bulan_mulai]." s.d. ".$bulan[$skp->bulan_selesai];?></b></span>

								<div>
										<div style="float:left; width:95px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;"> <?php echo $nama_pegawai;?></div></span>
								</div>
								<div>
										<div style="float:left; width:95px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<span><?=$skp->nip_baru;?></span>
								</div>
					
					</div>
				</div>
				<!-- /.row -->				
				<div class="row">
				<div class="col-lg-12">
                <div class="panel panel-default">
                <div class="panel-body" style="padding:0px;">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist" id="myTab">
						<li class="active">
							<a href="#dropdown1" tabindex="-1" role="tab" data-toggle="tab">
							<i class="fa fa-signal fa-fw"></i> Kepangkatan</a>
						</li>
						<li>
							<a href="#dropdown2" tabindex="-1" role="tab" data-toggle="tab">
							<i class="fa fa-tasks fa-fw"></i> Jabatan</a>
						</li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content" style="padding:5px;">
						<div class="tab-pane fade in active" id="dropdown1">
							<!-- Tabel Riwayat Kepangkatan -->
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Pangkat Golongan</th>
											<th>TMT Pangkat</th>
											<th>Angka Kredit</th>
											<th>SK</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($datapangkat as $rowpkt):?>
										<tr>
											<td>
												<input type="checkbox" value="<?php echo $rowpkt->id_peg_golongan;?>" name="id_peg_golongan">
											</td>
											<td>
												<?php echo $rowpkt->nama_pangkat;?> - <?php echo $rowpkt->nama_golongan;?><br/>
												<em><?php echo $rowpkt->jenis_kp;?></em>
											</td>
											<td>
												<?php echo $rowpkt->tmt_golongan;?>
											</td>
											<td>
												<?php echo $rowpkt->kredit_utama;?>
											</td>
											<td>
												<?php echo $rowpkt->sk_nomor;?>  (<em><?php echo $rowpkt->sk_tanggal;?></em>)
											</td>
										</tr>
										<?php endforeach;?>
									</tbody>
								</table>
								<!-- / Tabel Riwayat Kepangkatan -->
							</div>
							<!-- /.table-responsive -->
						</div>
						<!-- /.tab-pane -->
						
						<div class="tab-pane fade" id="dropdown2">
							<!-- Tabel Riwayat Jabatan -->
							<div class="table-responsive">
								<?php $jenis_jabatan = $this->dropdowns->jenis_jabatan(true); ?>
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Nama Jabatan</th>
											<th>SKPD</th>
											<th>TMT Jabatan</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($datajabatan as $rowjab):?>
										<tr>
											<td>
												<input type="checkbox" value="<?php echo $rowjab->id_peg_jab;?>" name="id_peg_jab">
											</td>
											<td>
												<?php echo $rowjab->nama_jabatan;?><br/>
												<em><?php echo $jenis_jabatan[$rowjab->nama_jenis_jabatan];?></em>
											</td>
											<td>
												<?php echo $rowjab->nama_unor;?>
											</td>
											<td>
												<?php echo $rowjab->tmt_jabatan;?><br/>
												<?php echo $rowjab->sk_nomor;?>  (<em><?php echo $rowjab->sk_tanggal;?></em>)
											</td>
										</tr>
										<?php endforeach;?>
									</tbody>
								</table>
							<!-- / Tabel Riwayat Jabatan -->
							</div>
							<!-- /.table-responsive -->
						</div>
					<!-- /.tab-pane -->
					</div>
					<!-- /.tab-content -->
				</div>
				</div>
				</div>
				</div>
				<!-- /.row -->
				<div class=row>
					<div class="col-lg-12" style="text-align:right;">
						<button type="submit" class="btn btn-primary" onclick="save();return false"><i class="fa fa-save fa-fw"></i> Simpan</button>
						<button class="btn btn-default" type="button" onclick="cancel();return false"><i class="fa fa-close fa-fw"></i> Batal...</button>
					</div>
				</div>
				<!-- /.col-lg-6 -->				
			</div>
			<!-- /.panel body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<script type="text/javascript">
function cancel(){
	window.location = '<?php echo site_url('admin/module/appskp/skp');?>';
}
function save(){
	var data ={
		type 						: '<?php echo $type;?>',
		id_peg_golongan : $('input[name="id_peg_golongan"]:checked').val(),
		id_peg_jab 			: $('input[name="id_peg_jab"]:checked').val()
	};
	$.post('<?= site_url('appskp/skp_formpegawai/save'); ?>', data, function(result){
		console.log(result);
		if(result.success)
		{
			window.location = '<?php echo site_url('admin/module/appskp/skp');?>';
		}
		else
		{
			alert('Tidak berhasil menyimpan !');
		}
	},'json')
	.fail(function(jqXHR, textStatus, errorThrown){
		console.log(jqXHR);
		console.log(textStatus);
		console.log(errorThrown);
	});
}	
$(document).ready(function() {

	$('input[name="id_peg_golongan"]').prop('checked',false);
	$('input[name="id_peg_jab"]').prop('checked',false);
	

	$('input[name="id_peg_golongan"]').click(function(){
		;
		// check if already checked
		if( $(this).prop('checked') )
		{
			$('input[name="id_peg_golongan"]').prop('checked',false);
			$(this).prop('checked',true);
		}
	});
	
	$('input[name="id_peg_jab"]').click(function(){
		// check if already checked
		if( $(this).prop('checked') )
		{
			$('input[name="id_peg_jab"]').prop('checked',false);
			$(this).prop('checked',true);
		}
	});
});
</script>
<style>
.panel-default .panel-body .nav-tabs { background-color:#eee;  padding-top: 10px;padding-left: 10px;}
.panel-default .panel-body .nav-tabs li a { padding-right: 10px; padding-left: 5px; padding-top:7px; padding-bottom:7px; margin-left:0px;	}
</style>