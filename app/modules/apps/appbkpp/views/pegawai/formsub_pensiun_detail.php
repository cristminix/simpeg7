<?php $arGender = $this->dropdowns->gender();?>
<?php $arAgama = $this->dropdowns->agama();?>
<?php $arStatusPegawai = $this->dropdowns->status_pegawai();?>
<?php $arKelompokPegawai = $this->dropdowns->kelompok_pegawai();?>
<?php $arMarital = $this->dropdowns->status_perkawinan();?>

<tr id="brow_tt" class="success prinsip">
	<td><?=$nomor;?></td>
	<td colspan="4">
	<style>
		div.dl-wide>dl.dl-horizontal>dt {
			width: 220px;
			text-align: left;
			border-right: #ccc 2px dashed;
		}

		div.dl-wide>dl.dl-horizontal>dd {
			margin-left: 230px;
		}
		</style>
		<div class="panel panel-default">
			<div class="panel-heading">
				<button class="btn batal btn-primary btn-xs pull-right" type="button"><i class="fa fa-close fa-fw"></i> Tutup </button>
				<i class="fa fa-user fa-fw"></i> Data Pegawai Pensiun
			<!-- .panel-heading -->
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col col-lg-3">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php
								if($fotoSrc) :
								?>
									<img src="<?php echo $fotoSrc;?>" alt="Foto Pegawai" class="img-responsive img-thumbnail fa-4x">
								<?php else : ?>
									<i class="fa fa-user fa-fw fa-4x img-responsive img-thumbnail"></i>
								<?php endif;?>
								</div>
						</div>
					<!--.col-lg-3-->
					</div>
					<div class="col col-lg-9  dl-wide">
						<dl class="dl-horizontal ">
							<dt>NIP</dt>
							<dd><?php echo $val->nip_baru;?></dd>
						</dl>
						<dl class="dl-horizontal">
				  			<dt>Nama Lengkap</dt>
				  			<dd><?php echo $val->nama_pegawai;?></dd>
						</dl>
						<dl class="dl-horizontal">
				  			<dt>Usia Ketika Pensiun</dt>
				  			<dd><?php echo $val->usia_pensiun;?></dd>
						</dl>	
						<dl class="dl-horizontal">
							<dt>Peringkat Terakhir</dt>
							<dd><?php echo $val->nama_pangkat." / ".$val->nama_golongan;?></dd>
						</dl>
						<dl class="dl-horizontal">
				  			<dt>Jenis Kelamin</dt>
				  				<dd><?php echo $arGender[$val->gender];?></dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Gelar Non Akademis</dt>
							<dd><?php echo $val->gelar_nonakademis;?></dd>
						</dl>			
						<dl class="dl-horizontal">
							<dt>Gelar Depan</dt>
							<dd><?php echo $val->gelar_depan;?></dd>
						</dl>			
						<dl class="dl-horizontal">
							<dt>Gelar Belakang</dt>
							<dd><?php echo $val->gelar_belakang;?></dd>
						</dl>	

					<!--.col-lg-9-->
					</div>
				<!--.row-->
				</div>
			<!-- .panel-body -->
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-lg-6 dl-wide">
						<dl class="dl-horizontal">
							<dt>Jabatan Terakhir</dt>
							<dd><?php echo $val->nomenklatur_jabatan;?></dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Unit Kerja Terakhir</dt>
							<dd><?php echo $val->nomenklatur_pada;?></dd>
						</dl>
						<dl class="dl-horizontal">
							<dt>Tanggal pensiun</dt>
							<dd><?php echo $val->tanggal_pensiun;?></dd>
						</dl>	
						<dl class="dl-horizontal">
							<dt>No. SK Pensiun</dt>
							<dd><?php echo $val->no_sk;?></dd>
						</dl>	
						<dl class="dl-horizontal">
							<dt>Tanggal SK Pensiun</dt>
							<dd><?php echo $val->tanggal_sk;?></dd>
						</dl>	
						<dl class="dl-horizontal">
							<dt>Jenis pensiun</dt>
							<dd><?php echo $val->jenis_pensiun;?></dd>
						</dl>
					<!--.col-lg-6-->
					</div>
					<div class="col-lg-6  dl-wide">
						<dl class="dl-horizontal">
							<dt>Tempat Lahir</dt>
							<dd><?php echo $val->tempat_lahir;?></dd>
						</dl>			
						<dl class="dl-horizontal">
							<dt>Tanggal Lahir</dt>
							<dd><?php echo $val->tanggal_lahir;?></dd>
						</dl>			
						<dl class="dl-horizontal">
							<dt>Agama</dt>
							<dd><?php echo $arAgama[$val->agama];?></dd>
						</dl>	
						<dl class="dl-horizontal">
							<dt>Status Terakhir Pegawai</dt>
							<dd><?php echo $arStatusPegawai[$val->status_pegawai];?></dd>
						</dl>	
						<dl class="dl-horizontal">
							<dt>Kelompok Pegawai</dt>
							<dd><?php echo $arKelompokPegawai[$val->kelompok_pegawai];?></dd>
						</dl>					
						<dl class="dl-horizontal">
							<dt>Status Perkawinan Terakhir</dt>
							<dd><?php echo $arMarital[$val->status_perkawinan];?></dd>
						</dl>
					<!--.col-lg-6-->
					</div>
				<!--.row-->
				</div>
				
							
				
			<!--.panel-footer-->
			</div>
		<!-- .panel -->
		</div>
	<!-- td colspan4 -->
	</td>
</tr>

<tr id="brow_tt" class="success bt_simpan">
	<td>&nbsp;</td>
	<td colspan="4">
		<button class="btn batal btn-default" type="button"><i class="fa fa-close fa-fw"></i> Tutup...</button>
	</td>
</tr>
