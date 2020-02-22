			<tr>
				<td>
					<div class="dropdown">
					  <button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown">
						<i class="fa fa-gears fa-fw"></i> Aksi
						<span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
						<li role="presentation">
							<a role="menuitem" tabindex="-1" href="#" 
							onclick="viewDetailPegawai(<?php echo $row->id_pegawai;?>);return false;"><i class="fa fa-binoculars fa-fw"></i> Lihat Data</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation">
							<a role="menuitem" tabindex="-1" href="<?php echo site_url('appdatapegawai/cetak/index/'.$row->id_pegawai);?>" target="_blank"><i class="fa fa-file-pdf-o fa-fw"></i> Cetak CV</a></li>
					  </ul>
					</div>				  
				</td><td>
					<?php echo $row->nama_pegawai;?><br/>
					<?php echo $row->tempat_lahir.', '.$row->tanggal_lahir;?><br/>
					<?php echo $row->nip_baru;?>
				</td><td>
					<?php echo $row->nama_pangkat.' / '.$row->nama_golongan;?><br/>
					<?php echo $row->tmt_pangkat;?><br/>
					<?php echo $row->mk_gol_tahun.' tahun '.$row->mk_gol_bulan.' bulan';?>
				</td><td class="center">
					<?php echo $row->nomenklatur_jabatan;?><br/>
					<?php echo $row->tmt_jabatan;?>
				</td>
				<td class="center"><?php echo $row->nomenklatur_pada;?></td>
			</tr>
