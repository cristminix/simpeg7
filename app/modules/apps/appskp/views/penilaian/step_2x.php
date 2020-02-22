					<h4 class="page-header" id="xx">Tahap 2.a - Penilaian SKP (terinput dalam aplikasi)
<a href="#" class="btn btn-success btn-xl pull-right" title="Kembali ke Tahap 1" onclick="load_step_1();"><i class="fa fa-chevron-circle-left"> Kembali ke Tahap 1</i></a>

					</h4>
					<div class="col-lg-6">
						<form>
							<!-- Nama Pejabat Penilai -->
							<div class="form-group">
								<label >Nilai SKP Periode Ini:</label>
								<?php echo form_input('nilai_skp',$nomenklatur_nilai,'class="form-control" disabled');?>
							</div>
							
							<!-- Nama Atasan Pejabat Penilai -->
							<div class="form-group">
								<label >SKP sebelumnya :</label>
								<?php echo form_input('nilai_skp_lain','90;70','class="form-control"');?>
								Jika ada SKP sebelum periode ini, dimasukkan dalam text box diatas.
								
							</div>
						</form>					
						
					</div>
					<div class="col-lg-6">
						<!-- Nama Pegawai -->
						<div class="form-group">
							<label >Nilai Perilaku :</label>
							<?php echo form_input('perilaku',$nomenklatur_perilaku,'class="form-control" disabled');?>
						</div>
						<button type="submit" class="btn btn-primary btn-block" onclick="save();return false">Perbaharui Nilai SKP</button>
						<button class="btn btn-warning btn-block" type="button" onclick="cancel();return false">Unduh Lembar Penilaian</button>
						
					</div>
					<!-- /.col-lg-6 -->		
