	<div class="col-lg-12">
	<div class="panel panel-info">
	<div class="panel-heading">
					<span id="xx">Pilih Atasan Pejabat Penilai</span>
	</div>
	<div class="panel-body">
						<!-- Tabel  -->
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th>#</th>
										<th>Nama / NIP Baru Atasan Pejabat Penilai</th>
										<th>Jabatan</th>
										<th>Unit Organisasi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($data as $row):?>
									<tr>
										<td>
											<a class="btn btn-default btn-xs dtaction" href="#" role="button" onclick="step_1(<?php echo $row->id_skp;?>,<?php echo $row->id_penilai;?>);return false;" data-id_skp="<?php echo $row->id_skp;?>"><i class="fa fa-check"></i></a>
										</td>
										<td>
											<?php echo $row->penilai_nama_pegawai;?> 
											(<?php echo $row->penilai_nama_pangkat.', '.$row->penilai_nama_golongan;?>)<br/>
											<?php echo $row->penilai_nip_baru;?>
										</td>
										<td>
											<?php echo $row->penilai_nomenklatur_jabatan;?>
										</td>
										<td>
											<?php echo $row->penilai_nomenklatur_pada;?>
										</td>
									</tr>
									<?php endforeach;?>
								</tbody>
							</table>
							<!-- / Tabel  -->
	</div>
	</div>
	</div>
