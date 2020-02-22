<div  class="panel-body">
	<div class="row">
			<div class="col-md-2">
				<div class="thumbnail">
					<div class="caption">
						<p>
						<a href="" class="label label-info" onclick="viewUppl('pasfoto','xx');return false;"><i class="fa fa-upload fa-fw"></i> Atur Dokumen</a>
						<a href="" class="label label-default" onclick="zoom_dok('pasfoto','0');return false;"><i class="fa fa-search fa-fw"></i> Zoom</a>
						</p>
					</div>
					<img src="<?=base_url();?><?=$pasfoto;?>" id="pasfotoIni">
				</div>
			</div>
			<!--col-md-3--//pasfoto-->
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-10"><b>Biodata</b></div>
							<div class="col-lg-2">
								<div class="btn btn-primary btn-xs  pull-right" onclick="viewForm('pasfoto','edit','biodata');return false;"><i class="fa fa-edit fa-fw"></i> Edit</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div><b>NIP lama:</b></div>
								<div><input type=text class="form-control" value="<?=$pegawai->nip;?>" disabled></div>
							</div>
							<div class="col-lg-6">
								<div><b>Nip baru:</b></div>
								<div><input type=text class="form-control" value="<?=$pegawai->nip_baru;?>" disabled></div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div><b>Tempat lahir:</b></div>
								<div><input type=text class="form-control" value="<?=$pegawai->tempat_lahir;?>" disabled></div>
							</div>
							<div class="col-lg-6">
								<div><b>Tanggal lahir:</b></div>
								<div><input type=text class="form-control" value="<?=$pegawai->tanggal_lahir;?>" disabled></div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div><b>Jenis kelamin:</b></div>
								<div><?=form_dropdown('gend',$this->dropdowns->gender(),(!isset($pegawai->gender))?'':$pegawai->gender,'class="form-control" style="padding:1px 0px 0px 5px;" disabled');?></div>
							</div>
							<div class="col-lg-6">
								<div><b>Agama:</b></div>
								<div><input type=text class="form-control" value="<?=$pegawai->agama;?>" disabled></div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div><b>Status perkawinan:</b></div>
								<div><?=form_dropdown('status_perkawin',$this->dropdowns->status_perkawinan(),(!isset($pegawai->status_perkawinan))?'':$pegawai->status_perkawinan,'class="form-control" style="padding:1px 0px 0px 5px;" disabled');?></div>
							</div>
							<div class="col-lg-6">
								<div><b>Nomor telepon:</b></div>
								<div><input type=text class="form-control" value="<?=$pegawai->nomor_telepon;?>" disabled></div>
							</div>
						</div>
					</div>
					<!--panel-body-->
				</div>
			</div>
			<!--col-md-3--//Biodata-->
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="row">
							<div class="col-lg-10"><b>Alamat</b></div>
							<div class="col-lg-2">
								<div class="btn btn-primary btn-xs  pull-right" onclick="viewForm('pasfoto','edit','alamat');return false;"><i class="fa fa-edit fa-fw"></i> Edit</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<?=$alamat->jalan;?><br>
						RT: <?=$alamat->rt;?> / RW:<?=$alamat->rw;?><br>
						<?=$alamat->kel_desa;?> - <?=$alamat->kecamatan;?><br>
						<?=$alamat->kab_kota;?><br>
						<?=$alamat->propinsi;?> - <?=$alamat->kode_pos;?>
					</div>
				</div>
			</div>
			<!--col-md-3--//Biodata-->
	</div>
	<!-- /.row -->
</div>

<script type="text/javascript">
    $("[rel='tooltip']").tooltip();    
    $('.thumbnail').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    ); 
</script>
