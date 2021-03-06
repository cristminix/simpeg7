	<div class="col-lg-12">
	<div class="panel panel-info">
	<div class="panel-heading">
					<span id="xx">Penilaian
<span class="pull-right" style="padding-left:5px;"><a href="#" class="btn btn-success btn-xs" title="Kembali ke Tahap 1" onclick="step_1();return false;"><i class="fa fa-chevron-circle-left fa=fw"> Kembali Pilih Atasan Penilai</i></a></span>
<span class="pull-right" style="padding-left:5px;"><a href="#" class="btn btn-success btn-xs" title="Cetak Lembar Perhitungan" onclick="cetak_hitung();return false;"><i class="fa fa-print fa=fw"> Cetak Perhitungan</i></a></span>
<span class="pull-right" style="padding-left:5px;"><a href="#" class="btn btn-success btn-xs" title="Lihat Hasil Perhitungan" onclick="buka_hitung();return false;" id="bt_hitung"><i class="fa fa-chevron-circle-down fa=fw"> Lihat Perhitungan</i></a></span>
<?php //dump($skp);?>
<?php $total_nilai = array();?>
					</span>
	</div>
	<div class="panel-body">
						<div class="table-responsive" id="hitung" style="display:none;">
							Ini perhitungannya...
						</div>

						<!-- Tabel  -->
						<div class="table-responsive" id="hasil">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Tahun</th>
										<th>Periode</th>
										<th>Jumlah</th>
										<th>Pembagi</th>
										<th>Nilai</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="6"  align="right">
											<strong>Penilaian SKP yang telah terinput dalam aplikasi</strong>
										</td>
									</tr>
									<?php foreach($skp as $id_skp => $row):?>
									<?php $tahun = $row->tahun;?>									
									<tr>
										<td>
											<?php echo $row->tahun;?>
										</td>
										<td>
										<?=$bulan[$row->bulan_mulai]." s.d. ".$bulan[$row->bulan_selesai];?>
										</td>
										<td>
											<?php echo $row->jumlah;?>
										</td>
										<td>
											<?php echo $row->pembagi;?>
										</td>
										<td>
											<?php echo $row->nilai;?>
											<?php $total_nilai[] = $row->nilai;?>
										</td>
										<td>
											-
										</td>
									</tr>
									<?php endforeach;?>
									<tr>
										<td colspan="6"  align="right">
											<strong>Penilaian SKP diluar aplikasi (<em>khusus untuk skp di luar kota Tangerang</em>)</strong>
										</td>
									</tr>
									<?php if(count($skp_tambahan) > 0):?>
									<?php foreach($skp_tambahan as $k => $row_2):?>
									<tr>
										<td>
											<?php echo $row_2->tahun;?>
										</td>
										<td>
											<?=$bulan[$row_2->bulan_mulai]." s.d. ".$bulan[$row_2->bulan_selesai];?>
										</td>
										<td>
											<?php echo $row_2->jumlah;?>
										</td>
										<td>
											<?php echo $row_2->pembagi;?>
										</td>
										<td>
											<?php echo $row_2->nilai;?>
											<?php $total_nilai[] = $row_2->nilai;?>
										</td>
										<td>
											<button type="button" class="btn  btn-danger btn-xs" onclick="hapus_skp_luar(<?php echo $k;?>)"><i class="fa fa-trash fa-fw"></i> Hapus...</button>
										</td>
									</tr>
									<?php endforeach;?>
									<?php endif;?>
									<tr>
										<td>
											<?php echo $tahun;?>
										</td>
										<td>
											<?=form_dropdown('bulan_mulai',$this->dropdowns->bulan(),(!isset($isi->bulan_mulai))?'':$isi->bulan_mulai,'class="form-control" style="width:100px; padding-left:2px; padding-right:2px; float:left;"');?>
											<div style="float:left; padding-top:5px; margin:0px 2px 0px 2px;">s.d.</div>
											<?=form_dropdown('bulan_selesai',$this->dropdowns->bulan(),(!isset($isi->bulan_selesai))?'':$isi->bulan_selesai,'class="form-control" style="width:100px; padding-left:2px; padding-right:2px; float:left;"');?>
										</td>
										<td>
											<?php echo form_input('skp_luar_jumlah');?>
										</td>
										<td>
											<?php echo form_input('skp_luar_pembagi');?>
										</td>
										<td>
											-
										</td>
										<td>
											<button type="button" class="btn  btn-primary btn-xs" onclick="tambah_skp_luar()"><i class="fa fa-plus fa-fw"></i> Tambah...</button>
										</td>
									</tr>
									<?php $jn = 0;?>
									<?php foreach($total_nilai as $tk):?>
									<?php $jn += $tk;?>
									<?php endforeach;?>
									<tr>
										<td colspan="2" align="right">
											<strong>Tugas Tambahan</strong>
										</td>
										<td colspan="2" align="center">
											<?php //dump($perhitungan);?>
											<?php if( isset($perhitungan['tugas_tambahan']) ):?>
												<?php if(is_array($perhitungan['tugas_tambahan'])) :?>
													<?php foreach($perhitungan['tugas_tambahan'] as $tt):?>
														<?php echo $tt;?>
													<?php endforeach; ?>
													<?php echo implode('<br/>',$perhitungan['tugas_tambahan']);?>
												<?php endif;?>
											<?php endif;?>
										</td>
										<td>
											<h4></h4>
										</td>
										<td>
											<?php echo $skp_akhir->skp_tugas_tambahan;?>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<strong>Kreatifitas</strong>
										</td>
										<td colspan="2" align="center">
										</td>
										<td>
											<h4></h4>
										</td>
										<td>
											<?php echo $skp_akhir->kreatifitas;?>
										</td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<h4>Nilai SKP Akhir</h4>
										</td>
										<td colspan="2" align="center">
											<h4><?php echo "( ( ".implode(' + ', $total_nilai )." ) / ".count($total_nilai).' ) + '.$skp_akhir->skp_tugas_tambahan.' + '.$skp_akhir->kreatifitas;?></h4>
										</td>
										<td>
											<h4><?php echo ($jn/count($total_nilai));?></h4>
										</td>
										<td>
											-
										</td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											<h4>Nilai Perilaku</h4>
										</td>
										<td colspan="2" align="center">
											<h4><?php if($perilaku) {echo $perilaku->jumlah." / ".$perilaku->pembagi;}?></h4>
										</td>
										<td>
											<h4><?php if($perilaku) {echo $perilaku->rata_rata;}?></h4>
										</td>
										<td>
											-
										</td>
									</tr>
									<tr>
										<td colspan="2" align="right">
											
											<h4>
												Penilaian Prestasi Kerja PNS
											</h4>
										</td>
										<td colspan="2" align="right">
											<h4>
												<?php if($perilaku):?>
												<?php echo '( '.( ($jn/count($total_nilai))).' x 60% ) + ('.($perilaku->rata_rata).' x 40% ) =';?><br/>
												<?php echo ($perilaku->rata_rata*0.4).' + '.( ($jn/count($total_nilai)) * 0.6 ).' =';?>
											<?php else:?>
											Penilaian Perilaku belum dilakukan. 
											
											<?php endif;?>
											</h4>
										</td>
										<td>
											<h4>
												<?php if($perilaku):?>
													<?php echo ($perilaku->rata_rata*0.4) + ( ($jn/count($total_nilai)) * 0.6 );?>
												<?php else:?>
													Penilaian Perilaku belum dilakukan. 
												
												<?php endif;?>
											</h4>
										</td>
										<td>
											<?php if($perilaku):?>
											<button type="button" class="btn  btn-success btn-xl" onclick="cetak_skp()"><i class="fa fa-print fa-fw"></i> Cetak</button>
											<?php endif;?>
										</td>
									</tr>

								</tbody>
							</table>
							<!-- / Tabel -->
						</div>
	</div>
	</div>
	</div>
