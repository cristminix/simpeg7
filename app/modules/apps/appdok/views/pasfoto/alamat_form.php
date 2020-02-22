<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_pasfoto" action="<?=site_url();?>appbkpp/pegawai/alamat_edit_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form Alamat Pegawai</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-6">
				<label>Jalan</label>
				<input name="jalan" id="jalan" type=text class="form-control" value="<?=$isi->jalan;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>RT</label>
				<input name="rt" id="rt" type=text class="form-control" value="<?=$isi->rt;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>RW</label>
				<input name="rw" id="rw" type=text class="form-control" value="<?=$isi->rw;?>">
			</div>
			<!--//col-lg-3-->
		</div>
		<div class="row" style="padding-top:15px;">
			<div class="col-lg-3">
				<label>Kel./Desa</label>
				<input name="kel_desa" id="kel_desa" type=text class="form-control" value="<?=$isi->kel_desa;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Kecamatan</label>
				<input name="kecamatan" id="kecamatan" type=text class="form-control" value="<?=$isi->kecamatan;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Kab./Kota</label>
				<input name="kab_kota" id="kab_kota" type=text class="form-control" value="<?=$isi->kab_kota;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Propinsi</label>
				<input name="propinsi" id="propinsi" type=text class="form-control" value="<?=$isi->propinsi;?>">
			</div>
			<!--//col-lg-3-->
		</div>
		<div class="row" style="padding-top:15px;">
			<div class="col-lg-3">
				<label>Kode Pos</label>
				<input name="kode_pos" id="kode_pos" type=text class="form-control" value="<?=$isi->kode_pos;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
						<label>Jarak tempuh Rumah-Kantor</label>
					<div class="row"><div class="col-lg-12">
							<div style="float:left;"><?=form_input('jarak_meter',(!isset($isi->jarak_meter))?'':$isi->jarak_meter,'class="form-control row-fluid" style="width:50px;padding-left:5px;padding-right:5px;" id="jarak_meter"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;padding-right:10px;">km (atau)</div>

							<div style="float:left;"><?=form_input('jarak_menit',(!isset($isi->jarak_menit))?'':$isi->jarak_menit,'class="form-control row-fluid" style="width:50px;padding-left:15px;padding-right:5px;" id="jarak_menit"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;">menit</div>
					</div></div>
					<!--//row-->
			</div>
			<!--//col-lg-3-->
		</div>
		<div class="row" style="padding-top:15px;">
			<div class="col-lg-6">
					<?=form_hidden('id_pegawai',$isi->id_pegawai);?>
			        <button type="submit" class="btn btn-primary" onclick="simpan();return false;"><i class="fa fa-save fa-fw"></i> Simpan</button>
					<button class="btn btn-default" type="button" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i> Batal...</button>
			</div>
			<!--//col-lg-6-->
		</div>
		<!--//row-->


	</div>
	<!-- /.panel-body -->
</div>
<!-- /.panel -->
      </form>
