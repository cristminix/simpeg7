<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_karis_karsu" action="<?=site_url();?>appbkpp/pegawai/formkaris_karsu_<?=(isset($isi->id_peg_perkawinan))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form KARIS / KARSU</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nama Istri / Suami</label>
				<input name="nama_suris" id="nama_suris" type=text class="form-control" value="<?=(isset($isi->nama_suris))?$isi->nama_suris:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tempat lahir Istri / Suami</label>
				<input name="tempat_lahir_suris" id="tempat_lahir_suris" type=text class="form-control" value="<?=(isset($isi->tempat_lahir_suris))?$isi->tempat_lahir_suris:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal lahir Istri / Suami</label>
				<input name="tanggal_lahir_suris" id="tanggal_lahir_suris" type=text class="form-control" value="<?=(isset($isi->tanggal_lahir_suris))?date("d-m-Y", strtotime($isi->tanggal_lahir_suris)):"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pekerjaan Istri / Suami</label>
				<input name="pekerjaan_suris" id="pekerjaan_suris" type=text class="form-control" value="<?=(isset($isi->pekerjaan_suris))?$isi->pekerjaan_suris:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
				<label>Pendidikan Istri / Suami</label>
				<input name="pendidikan_suris" id="pendidikan_suris" type=text class="form-control" value="<?=(isset($isi->pendidikan_suris))?$isi->pendidikan_suris:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal menikah</label>
				<input name="tanggal_menikah" id="tanggal_menikah" type=text class="form-control" value="<?=(isset($isi->tanggal_menikah))?date("d-m-Y", strtotime($isi->tanggal_menikah)):"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-6" style="padding-top:15px;">
					<?=form_hidden('id_pegawai',$id_pegawai);?>
					<input name="id_peg_perkawinan" id="id_peg_perkawinan" type=hidden class="form-control" value="<?=(isset($isi->id_peg_perkawinan))?$isi->id_peg_perkawinan:"";?>">
			        <button type="submit" class="btn btn-<?=(isset($hapus))?"danger":"primary";?>" onclick="simpan();return false;"><i class="fa fa-save fa-fw"></i> <?=(isset($hapus))?"Hapus":"Simpan";?></button>
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
