<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_konversi_nip" action="<?=site_url();?>appbkpp/pegawai/konversi_nip_<?=(isset($isi->id_konversi_nip))?"edit":"input";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form SK Konversi NIP</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nomor SK Konversi NIP</label>
				<input name="konversi_nip_nomor" id="konversi_nip_nomor" type=text class="form-control" value="<?=(isset($isi->konversi_nip_nomor))?$isi->konversi_nip_nomor:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal SK</label>
				<input name="konversi_nip_tanggal" id="konversi_nip_tanggal" type=text class="form-control" value="<?=(isset($isi->konversi_nip_tanggal))?date("d-m-Y", strtotime($isi->konversi_nip_tanggal)):"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pejabat penandatangan</label>
				<input name="konversi_nip_pejabat" id="konversi_nip_pejabat" type=text class="form-control" value="<?=(isset($isi->konversi_nip_pejabat))?$isi->konversi_nip_pejabat:"";?>">
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
