<div class="row">
	<div class="col-lg-12"  id="form_pendidikan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
    <?php echo (!isset($notif))?'':$notif;?>
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					<i class="fa fa-graduation-cap fa-fw"></i> Data Pendidikan Pegawai
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
			<?php $arJenisPend = array(''=>'Silahkan Pilih','umum'=>'Umum','teknik'=>'Teknik');?>
<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Jenjang / Jurusan</th>
					<th>Nama dan Lokasi Sekolah</th>
					<th>Tahun Lulus</th>
				</tr>
			</thead>
			<tbody>
			<?php
			$no=0; 
			foreach($data as $row):
			$no++;
			?>
				<tr>
					<td><?=$no;?>
					</td>
					<td>
						<?php echo $row->nama_jenjang;?><br/>
						<?php echo $row->nama_pendidikan;?>
					</td>
					<td>
						<?php echo $row->nama_sekolah;?><br/>
						<?php echo $row->lokasi_sekolah;?>
					</td>
					<td>
						<?php echo $row->tahun_lulus;?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
