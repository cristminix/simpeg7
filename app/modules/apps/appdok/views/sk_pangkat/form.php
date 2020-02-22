<form role="form" id="form_sk_pangkat" action="<?=site_url();?>appbkpp/pegawai/formpangkat_<?=(isset($row->id_peg_golongan))?((isset($hapus))?"hapus":"edit"):"tambah";?>_aksi">
<div class="panel panel-<?=(isset($hapus))?"warning":"info";?>"">
	<div class="panel-heading">
		<i class="fa fa-edit fa-fw"></i> <b>Form SK Kepangkatan</b>
		<div class="btn btn-default btn-xs pull-right" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i></div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-3">
					<div class="form-group">
						<label>TMT Pangkat</label>
						<input type="text" name="tmt_golongan" id="tmt_golongan" value="<?=(!isset($row->tmt_golongan))?'':$row->tmt_golongan;?>" class="form-control" <?=(isset($hapus))?"disabled":"";?>>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
					<div class="form-group">
						<label>Pangkat / Golongan</label>
						<?=form_dropdown('kode_golongan',$this->dropdowns->kode_golongan_pangkat(),(!isset($row->kode_golongan))?'':$row->kode_golongan,(isset($hapus))?'class="form-control" style="padding-left:2px; padding-right:2px; float:left;" disabled':'class="form-control" style="padding-left:2px; padding-right:2px; float:left;"');?>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
						<label>Masa kerja</label>
					<div class="row"><div class="col-lg-12">
							<div style="float:left;"><?=form_input('mk_gol_tahun',(!isset($row->mk_gol_tahun))?'':$row->mk_gol_tahun,(isset($hapus))?'class="form-control" style="width:50px;padding-left:5px;padding-right:5px;" disabled':'class="form-control row-fluid" style="width:50px;padding-left:5px;padding-right:5px;" id="mk_gol_tahun"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;">tahun</div>

							<div style="float:left;"><?=form_input('mk_gol_bulan',(!isset($row->mk_gol_bulan))?'':$row->mk_gol_bulan,(isset($hapus))?'class="form-control" style="width:50px;padding-left:5px;padding-right:5px;" disabled':'class="form-control row-fluid" style="width:50px;padding-left:5px;padding-right:5px;" id="mk_gol_bulan"');?></div>
							<div style="float:left;padding-top:8px;padding-left:5px;">bulan</div>
					</div></div>
					<!--//row-->
			</div>
			<!--//col-lg-3-->
					<div class="col-lg-3">
							<b>Angka kredit</b>
							<div class="row"><div class="col-lg-12">
									<div style="float:left;padding-top:8px;padding-left:5px;">Utama: </div>
									<div style="float:left;"><?=form_input('kredit_utama',(!isset($row->kredit_utama))?'':$row->kredit_utama,(isset($hapus))?'class="form-control" style="width:80px;padding-left:5px;padding-right:5px;" disabled':'class="form-control row-fluid" style="width:80px;padding-left:5px;padding-right:5px;"');?></div>
		
									<div style="float:left;padding-top:8px;padding-left:5px;">Tambahan: </div>
									<div style="float:left;"><?=form_input('kredit_tambahan',(!isset($row->kredit_tambahan))?'':$row->kredit_tambahan,(isset($hapus))?'class="form-control" style="width:80px;padding-left:5px;padding-right:5px;" disabled':'class="form-control row-fluid" style="width:80px;padding-left:5px;padding-right:5px;"');?></div>
							</div></div>
							<!--//row-->
					</div>
		</div>
		<!--//row-->
		<div class="row">
			<div class="col-lg-3">
					<div class="form-group">
						<label>Nomor SK</label>
						<input type="text" name="sk_nomor" id="sk_nomor" value="<?=(!isset($row->sk_nomor))?'':$row->sk_nomor;?>" class="form-control" <?=(isset($hapus))?"disabled":"";?>>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
					<div class="form-group">
						<label>Tanggal SK</label>
						<input type="text" name="sk_tanggal" id="sk_tanggal" value="<?=(!isset($row->sk_tanggal))?'':$row->sk_tanggal;?>" class="form-control" <?=(isset($hapus))?"disabled":"";?>>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
					<div class="form-group">
						<label>Jenis kenaikan pangkat</label>
						<?=form_dropdown('kode_jenis_kp',$this->dropdowns->kode_jenis_kp(),(!isset($row->kode_jenis_kp))?'':$row->kode_jenis_kp,(isset($hapus))?'class="form-control" style="padding:1px 0px 0px 5px;" disabled':'class="form-control" style="padding:1px 0px 0px 5px;"');?>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
		</div>
		<div class="row">
			<div class="col-lg-3">
					<div class="form-group">
						<label>Nomor Nota BKN</label>
						<input type="text" name="bkn_nomor" id="bkn_nomor" value="<?=(!isset($row->bkn_nomor))?'':$row->bkn_nomor;?>" class="form-control" <?=(isset($hapus))?"disabled":"";?>>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
			<div class="col-lg-3">
					<div class="form-group">
						<label>Tanggal Nota BKN</label>
						<input type="text" name="bkn_tanggal" id="bkn_tanggal" value="<?=(!isset($row->bkn_tanggal))?'':$row->bkn_tanggal;?>" class="form-control" <?=(isset($hapus))?"disabled":"";?>>
					</div>
					<!--//form-group-->
			</div>
			<!--//col-lg-3-->
		</div>
		<!--//row-->
<?php if(isset($row->id_peg_golongan)){	?>
			<input type=hidden name="id_peg_golongan" id="id_peg_golongan" value="<?=$row->id_peg_golongan;?>">
<?php	}	?>
				<?=form_hidden('id_pegawai',$id_pegawai);?>
			        <button type="submit" class="btn btn-<?=(isset($hapus))?"danger":"primary";?>" onclick="simpan();return false;"><i class="fa fa-save fa-fw"></i> <?=(isset($hapus))?"Hapus":"Simpan";?></button>
					<button class="btn btn-default" type="button" onclick="kembali();return false;"><i class="fa fa-close fa-fw"></i> Batal...</button>

	</div>
	<!-- /.panel-body -->
</div>
<!-- /.panel -->
      </form>
