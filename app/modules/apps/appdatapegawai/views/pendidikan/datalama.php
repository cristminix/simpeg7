<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Jenjang <br/> Jurusan</th>
					<th>Nama Sekolah<br/> Lokasi Sekolah</th>
					<th>No. Ijazah <br/> Tanggal Lulus</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($data as $row):?>
				<tr>
					<td>
						<?php echo $row->pend_nama;?><br/>
						<?php echo $row->jurusan;?>
					</td>
					<td>
						<?php echo $row->nama_sekolah;?><br/>
						<?php echo $row->tempat_sekolah;?>
					</td>
					<td>
						<?php echo $row->nomor_sttb;?><br/>
						<?php echo $row->tanggal_sttb;?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
