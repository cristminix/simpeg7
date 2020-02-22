<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Tgl Mulai<br/>Tgl Selesai</th>
					<th>Nama Diklat</th>
					<th>Tempat</th>
					<th>Diklat</th>
				</tr>
			</thead>
			<tbody>
			<? foreach($data as $row):?>
				<tr>
					<td>
						<?php echo $row->tanggal_mulai;?><br/>
						<?php echo $row->tanggal_selesai;?>
					</td>
					<td>
						<?php echo $row->nama_diklat;?>
					</td>
					<td>
						<?php echo $row->tempat_diklat;?>
					</td>
					<td>
						<?php echo $row->nomor_sk;?><br/>
						<?php echo $row->tanggal_sk;?>
					</td>
				</tr>
			<? endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
