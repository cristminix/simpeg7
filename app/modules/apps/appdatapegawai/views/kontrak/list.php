<div class="row">
	<div class="col-lg-12">
		
		<div class="panel panel-success">
			<div class="panel-heading row-fluid">
				<i class="fa fa-signal fa-fw"></i> Riwayat Kontrak Pegawai
				
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th rowspan="2">#</th>
								<th rowspan="2">TMT Kontrak</th>
								<th colspan="2">Masa Kerja Pengangkatan</th>
								<th colspan="3">Surat Keputusan</th>
							</tr>
							<tr>
								<th>Tahun</th>
								<th>Bulan</th>
								<th>Nomor SK</th>
								<th>Tanggal SK</th>
								<th>Pejabat Penetap</th>
							</tr>
						</thead>
						<tbody>
						<?php
					$no=0;
					foreach($data as $row):
					$no++;
					?>
							<tr>
						<td><?=$no;?></td>
			
						<td>
									<?php echo $row->tmt_kontrak;?>
								</td>
								<td>
									<?php echo $row->mk_th;?>
								</td>
								<td>
									<?php echo $row->mk_bl;?>
								</td>
								<td>
									<?php echo $row->sk_nomor;?>
								</td>
								<td>
									<?php echo $row->sk_tanggal;?>
								</td>
								<td>
									<?php echo $row->sk_pejabat;?>
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
