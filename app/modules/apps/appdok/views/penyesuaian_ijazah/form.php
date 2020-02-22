<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_penyesuaian_ijazah" action="<?=site_url();?>appbkpp/pegawai/formpenyesuaian_ijazah_<?=(isset($isi->id_peg_penyesuaian_ijazah))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form Penyesuaian Ijazah</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nama Penyesuaian Ijazah</label>
				<input name="nama_penyesuaian_ijazah" id="nama_penyesuaian_ijazah" type=text class="form-control" value="<?=(isset($isi->nama_penyesuaian_ijazah))?$isi->nama_penyesuaian_ijazah:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal Penyesuaian Ijazah</label>
				<input name="tanggal_penyesuaian_ijazah" id="tanggal_penyesuaian_ijazah" type=text class="form-control" value="<?=(isset($isi->tanggal_penyesuaian_ijazah))?date("d-m-Y", strtotime($isi->tanggal_penyesuaian_ijazah)):"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tempat Penyesuaian Ijazah</label>
				<input name="tempat_penyesuaian_ijazah" id="tempat_penyesuaian_ijazah" type=text class="form-control" value="<?=(isset($isi->tempat_penyesuaian_ijazah))?$isi->tempat_penyesuaian_ijazah:"";?>" <?=(isset($hapus))?"disabled":"";?>>
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
					<input name="id_peg_penyesuaian_ijazah" id="id_peg_penyesuaian_ijazah" type=hidden class="form-control" value="<?=(isset($isi->id_peg_penyesuaian_ijazah))?$isi->id_peg_penyesuaian_ijazah:"";?>">
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
