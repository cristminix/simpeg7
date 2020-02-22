<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_sk_pns" action="<?=site_url();?>appbkpp/pegawai/sk_pns_edit_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form SK PNS</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nomor SK PNS</label>
				<input name="sk_pns_nomor" id="sk_pns_nomor" type=text class="form-control" value="<?=$isi->sk_pns_nomor;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal SK PNS</label>
				<input name="sk_pns_tanggal" id="sk_pns_tanggal" type=text class="form-control" value="<?=date("d-m-Y", strtotime($isi->sk_pns_tanggal));?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pejabat penandatangan SK</label>
				<input name="sk_pns_pejabat" id="sk_pns_pejabat" type=text class="form-control" value="<?=$isi->sk_pns_pejabat;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>TMT PNS</label>
				<input name="tmt_pns" id="tmt_pns" type=text class="form-control" value="<?=date("d-m-Y", strtotime($isi->tmt_pns));?>">
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-6" style="padding-top:15px;">
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
