<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Golongan / Pangkat</th>
					<th>TMT Pangkat</th>
					<th>Nomor dan Tanggal SK</th>
				</tr>
			</thead>
			<tbody>
			<? foreach($data as $row):?>
				<tr>
					<td>
						<?php echo $row->nama_golongan;?><br/>
						<?php echo $row->nama_pangkat;?>
					</td>
					<td>
						<?php echo $row->tmt_pangkat;?>
					</td>
					<td>
						<?php echo $row->sk_nomor;?><br/>
						<?php echo $row->sk_tgl;?>
					</td>
				</tr>
			<? endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
