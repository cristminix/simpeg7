<?php
	date_default_timezone_set('UTC');
?>
<form role="form" id="form_sk_cpns" action="<?=site_url();?>appbkpp/pegawai/sk_cpns_edit_aksi">
<div class="panel panel-info">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form SK CPNS</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
				<label>Nomor SK CPNS</label>
				<input name="sk_cpns_nomor" id="sk_cpns_nomor" type=text class="form-control" value="<?=$isi->sk_cpns_nomor;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Tanggal SK CPNS</label>
				<input name="sk_cpns_tgl" id="sk_cpns_tgl" type=text class="form-control" value="<?=date("d-m-Y", strtotime($isi->sk_cpns_tgl));?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>Pejabat penandatangan SK</label>
				<input name="sk_cpns_pejabat" id="sk_cpns_pejabat" type=text class="form-control" value="<?=$isi->sk_cpns_pejabat;?>">
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
				<label>TMT CPNS</label>
				<input name="tmt_cpns" id="tmt_cpns" type=text class="form-control" value="<?=date("d-m-Y", strtotime($isi->tmt_cpns));?>">
			</div>
			<!--//col-lg-3-->
		</div>
		<div class="row" style="padding-top:15px;">
			<div class="col-lg-3">
						<label>Masa kerja</label>
					<div class="row"><div class="col-lg-12">
							<div style="float:left;"><?=form_input('mk_th',(!isset($isi->mk_th))?'':$isi->mk_th,'class="form-control row-fluid" style="width:50px;padding-left:5px;padding-right:5px;" id="mk_th"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;">tahun</div>

							<div style="float:left;"><?=form_input('mk_bl',(!isset($isi->mk_bl))?'':$isi->mk_bl,'class="form-control row-fluid" style="width:50px;padding-left:15px;padding-right:5px;" id="mk_bl"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;">bulan</div>
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
