<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_anak" action="<?=site_url();?>appbkpp/pegawai/anak_<?=(isset($isi->id_peg_anak))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form Anak Pegawai</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nama anak</label>
				<input name="nama_anak" id="nama_anak" type=text class="form-control" value="<?=(isset($isi->nama_anak))?$isi->nama_anak:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tempat lahir anak</label>
				<input name="tempat_lahir_anak" id="tempat_lahir_anak" type=text class="form-control" value="<?=(isset($isi->tempat_lahir_anak))?$isi->tempat_lahir_anak:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal lahir anak</label>
				<input name="tanggal_lahir_anak" id="tanggal_lahir_anak" type=text class="form-control" value="<?=(isset($isi->tanggal_lahir_anak))?date("d-m-Y", strtotime($isi->tanggal_lahir_anak)):"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Jenis kelamin anak</label>
				<?=form_dropdown('gender_anak',$this->dropdowns->gender(),(!isset($isi->gender_anak))?'':$isi->gender_anak,(isset($hapus))?'class="form-control" style="padding:1px 0px 0px 5px;" disabled':'class="form-control" style="padding:1px 0px 0px 5px;"');?>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
				<label>Status anak</label>
				<?=form_dropdown('status_anak',$this->dropdowns->status_anak(),(!isset($isi->status_anak))?'':$isi->status_anak,(isset($hapus))?'class="form-control" style="padding:1px 0px 0px 5px;" disabled':'class="form-control" style="padding:1px 0px 0px 5px;"');?>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pendidikan anak</label>
				<input name="pendidikan_anak" id="pendidikan_anak" type=text class="form-control" value="<?=(isset($isi->pendidikan_anak))?$isi->pendidikan_anak:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pekerjaan anak</label>
				<input name="pekerjaan_anak" id="pekerjaan_anak" type=text class="form-control" value="<?=(isset($isi->pekerjaan_anak))?$isi->pekerjaan_anak:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
				<label>Keterangan tunjangan</label>
				<?=form_dropdown('keterangan_tunjangan',$this->dropdowns->keterangan_tunjangan(),(!isset($isi->keterangan_tunjangan))?'':$isi->keterangan_tunjangan,(isset($hapus))?'class="form-control" style="padding:1px 0px 0px 5px;" disabled':'class="form-control" style="padding:1px 0px 0px 5px;"');?>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-6" style="padding-top:15px;">
					<?=form_hidden('id_pegawai',$id_pegawai);?>
					<input name="id_peg_anak" id="id_peg_anak" type=hidden class="form-control" value="<?=(isset($isi->id_peg_anak))?$isi->id_peg_anak:"";?>">
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
