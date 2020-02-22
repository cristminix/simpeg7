<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_sertifikat_prajab" action="<?=site_url();?>appbkpp/pegawai/sertifikat_prajab_<?=(isset($isi->id_peg_diklat_struk))?"edit":"input";?>_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form Sertifikat Prajab</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nama DIKLAT</label>
				<input name="nama_diklat" id="nama_diklat" type=text class="form-control" value="<?=(isset($isi->nama_diklat))?$isi->nama_diklat:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tempat Diklat</label>
				<input name="tempat_diklat" id="tempat_diklat" type=text class="form-control" value="<?=(isset($isi->tempat_diklat))?$isi->tempat_diklat:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Penyelenggara</label>
				<input name="penyelenggara" id="penyelenggara" type=text class="form-control" value="<?=(isset($isi->penyelenggara))?$isi->penyelenggara:"";?>">
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
				<label>Tanggal mulai Diklat</label>
				<input name="tmt_diklat" id="tmt_diklat" type=text class="form-control" value="<?=(isset($isi->tmt_diklat))?date("d-m-Y", strtotime($isi->tmt_diklat)):"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal akhir Diklat</label>
				<input name="tst_diklat" id="tst_diklat" type=text class="form-control" value="<?=(isset($isi->tst_diklat))?date("d-m-Y", strtotime($isi->tst_diklat)):"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
						<label>Durasi Diklat</label>
					<div class="row"><div class="col-lg-12">
							<div style="float:left;"><?=form_input('jam',(!isset($isi->jam))?'':$isi->jam,'class="form-control row-fluid" style="width:100px;padding-left:5px;padding-right:5px;" id="mk_th"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;">jam</div>
					</div></div>
					<!--//row-->
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
				<label>Tahun</label>
				<input name="tahun" id="tahun" type=text class="form-control" value="<?=(isset($isi->tahun))?$isi->tahun:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Angkatan</label>
				<input name="angkatan" id="angkatan" type=text class="form-control" value="<?=(isset($isi->angkatan))?$isi->angkatan:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Nomor STTPL</label>
				<input name="nomor_sttpl" id="nomor_sttpl" type=text class="form-control" value="<?=(isset($isi->nomor_sttpl))?$isi->nomor_sttpl:"";?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal STTPL</label>
				<input name="tanggal_sttpl" id="tanggal_sttpl" type=text class="form-control" value="<?=(isset($isi->tanggal_sttpl))?date("d-m-Y", strtotime($isi->tanggal_sttpl)):"";?>">
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
