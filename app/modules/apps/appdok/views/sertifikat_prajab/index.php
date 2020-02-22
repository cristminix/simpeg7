<?php
	date_default_timezone_set('UTC');
?>
<div  class="panel-body" id="isiDok_<?=$komponen;?>">
	<div class="row">

<div class="col-md-5" style="padding-top: 5px;padding-bottom: 15px;">
	<div class="panel panel-info">
		<div class="panel-heading">
			<div class="row">
				<div class="col-lg-10">
					<b><?=(isset($isi->id_peg_diklat_struk))?$isi->penyelenggara:"...";?></b>
				</div>
				<div class="col-lg-2">
					<div class="btn btn-primary btn-xs  pull-right" onclick="viewForm('<?=$komponen;?>','edit','<?=(isset($isi->id_peg_diklat_struk))?$isi->id_peg_diklat_struk:"";?>');return false;"><i class="fa fa-edit fa-fw"></i> Edit</div>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="row">
							<div class="col-md-4" style="padding:5px;">
								<div class="thumbnail">
								<?php if(isset($isi->id_peg_diklat_struk)){ ?>
									<div class="caption" style="text-align:center;">
										<p>
										<a href="" class="label label-info" onclick="viewUppl('<?=$komponen;?>','<?=$isi->id_peg_diklat_struk;?>');return false;"><i class="fa fa-upload fa-fw"></i> Atur Dokumen</a>
										<a href="" class="label label-default" onclick="zoom_dok('<?=$komponen;?>','<?=$isi->id_peg_diklat_struk;?>');return false;"><i class="fa fa-search fa-fw"></i> Zoom</a>
										</p>
									</div>
								<?php } ?>
									<img src="<?=base_url();?><?=$thumb;?>">
								</div>
							</div>
							<div class="col-md-8" style="padding:5px;">
								<?php if(isset($isi->id_peg_diklat_struk)){ ?>
								<div><b>Tahun:</b></div>
								<div><input type=text class="form-control" value="<?=$isi->tahun;?>" disabled></div>
								<div><b>Tanggal STTPL:</b></div>
								<div><input type=text class="form-control" value="<?=date("d-m-Y", strtotime($isi->tanggal_sttpl));?>" disabled></div>
								<?php } ?>
							</div>
			</div>
		</div>
	</div>
</div>

	</div>
	<!-- /.row -->
</div>


<div  class="panel-body" id="formDok_<?=$komponen;?>" style="display:none;">
	<div class="row">
		<div class="col-md-3">
			<div class="thumbnail" id="wrapDok_<?=$komponen;?>"></div>
		</div>
		<!-- /.col-md-3 -->
	</div>
	<!-- /.row -->

	<div class="row">
		<div class="col-lg-12">
				<div id='iddDok_<?=$komponen;?>' style="display:none;"></div>
			 <div class="btn btn-danger btn-sm" onclick="okHapus_<?=$komponen;?>();"><i class="fa fa-trash"></i> Hapus</div>
			 <div class="btn btn-primary btn-sm" onclick="batalDok_<?=$komponen;?>();">Batal...</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
</div>

<script type="text/javascript">
    $('.thumbnail').hover(
        function(){
            $(this).find('.caption').slideDown(250); //.fadeIn(250)
        },
        function(){
            $(this).find('.caption').slideUp(250); //.fadeOut(205)
        }
    ); 
</script>
