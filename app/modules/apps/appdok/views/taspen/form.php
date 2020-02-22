<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_taspen" action="<?=site_url();?>appbkpp/pegawai/taspen_<?=(isset($isi->id_taspen))?"edit":"input";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form Kartu TASPEN</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nomor Kartu TASPEN</label>
				<input name="taspen_nomor" id="taspen_nomor" type=text class="form-control" value="<?=(isset($isi->taspen_nomor))?$isi->taspen_nomor:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal Kartu TASPEN</label>
				<input name="taspen_tanggal" id="taspen_tanggal" type=text class="form-control" value="<?=(isset($isi->taspen_tanggal))?date("d-m-Y", strtotime($isi->taspen_tanggal)):"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pejabat penandatangan</label>
				<input name="taspen_pejabat" id="taspen_pejabat" type=text class="form-control" value="<?=(isset($isi->taspen_pejabat))?$isi->taspen_pejabat:"";?>">
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-6" style="padding-top:15px;">
					<?=form_hidden('id_pegawai',$id_pegawai);?>
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
