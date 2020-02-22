<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_ujian_dinas" action="<?=site_url();?>appbkpp/pegawai/formujian_dinas_<?=(isset($isi->id_peg_ujian_dinas))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form Ujian Dinas</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nama Ujian Dinas</label>
				<input name="nama_ujian_dinas" id="nama_ujian_dinas" type=text class="form-control" value="<?=(isset($isi->nama_ujian_dinas))?$isi->nama_ujian_dinas:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal Ujian Dinas</label>
				<input name="tanggal_ujian_dinas" id="tanggal_ujian_dinas" type=text class="form-control" value="<?=(isset($isi->tanggal_ujian_dinas))?date("d-m-Y", strtotime($isi->tanggal_ujian_dinas)):"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tempat Ujian Dinas</label>
				<input name="tempat_ujian_dinas" id="tempat_ujian_dinas" type=text class="form-control" value="<?=(isset($isi->tempat_ujian_dinas))?$isi->tempat_ujian_dinas:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
				<label>Nomor Sertifikat</label>
				<input name="nomor_sertifikat" id="nomor_sertifikat" type=text class="form-control" value="<?=(isset($isi->nomor_sertifikat))?$isi->nomor_sertifikat:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal Sertifikat</label>
				<input name="tanggal_sertifikat" id="tanggal_sertifikat" type=text class="form-control" value="<?=(isset($isi->tanggal_sertifikat))?date("d-m-Y", strtotime($isi->tanggal_sertifikat)):"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-6" style="padding-top:15px;">
					<?=form_hidden('id_pegawai',$id_pegawai);?>
					<input name="id_peg_ujian_dinas" id="id_peg_ujian_dinas" type=hidden class="form-control" value="<?=(isset($isi->id_peg_ujian_dinas))?$isi->id_peg_ujian_dinas:"";?>">
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
