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
			<?php foreach($data as $row):?>
				<tr>
					<td>
						<div class="pull-left">
							<div class="btn-group">
								
							</div>
						</div>
					</td>
					<td>
						<?php echo $row->nama_jenjang;?>/<?=$row->jurusan?><br/>
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
