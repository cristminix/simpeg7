<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_dp3" action="<?=site_url();?>appbkpp/pegawai/formdp3_<?=(isset($isi->id_dp3))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form DP3</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Tahun</label>
				<input name="tahun" id="tahun" type=text class="form-control" value="<?=(isset($isi->tahun))?$isi->tahun:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Nama Pejabat Penilai</label>
				<input name="penilai_nama_pegawai" id="penilai_nama_pegawai" type=text class="form-control" value="<?=(isset($isi->penilai_nama_pegawai))?$isi->penilai_nama_pegawai:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>NIP Pejabat Penilai</label>
				<input name="penilai_nip_baru" id="penilai_nip_baru" type=text class="form-control" value="<?=(isset($isi->penilai_nip_baru))?$isi->penilai_nip_baru:"";?>" <?=(isset($hapus))?"disabled":"";?>>
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-6" style="padding-top:15px;">
					<?=form_hidden('id_pegawai',$id_pegawai);?>
					<input name="id_dp3" id="id_dp3" type=hidden class="form-control" value="<?=(isset($isi->id_dp3))?$isi->id_dp3:"";?>">
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
