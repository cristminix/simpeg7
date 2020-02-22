<div class="row">
	<form role="form" onsubmit="return false;">
		<div class="col-lg-10">
			<div class="form-group input-group">
				<input type="text" class="form-control" placeholder="Nama Unor" name="nomenklatur_cari" value="<?php echo $nomenklatur_cari;?>">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="button" id="pickercaribtn">Cari</button>
				</span>
			</div>
		</div>
		<!-- /col-lg-6 -->
	</form>
</div>
<!-- /row -->
<div class="row" id="resultareapicker">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Kode Unor</th>
						<th>Nama Jabatan</th>
						<th>Unit Kerja</th>
					</tr>
				</thead>
				<tbody>
				<?php if( isset($data )): ?>
				<?php foreach($data as $row):?>
					<tr>
						<td>
						<button class="btn btn-success btn-xs" type="button" 
							id="picker_ok"  
							data-id_unor="<?php echo $row->id_unor;?>"
							data-nama_ese="<?php echo $row->nama_ese;?>" 
							data-nomenklatur_cari="<?php echo $row->nomenklatur_cari;?>" 
							data-nomenklatur_jabatan="<?php echo $row->nomenklatur_jabatan;?>" 
							>
							<i class="fa fa-check fa-fw fa-lg" ></i> 
						</button>
							
						</td>
						<td>
							<?php echo $row->kode_unor;?>
						</td>
						<td>
							<?php echo $row->nomenklatur_jabatan;?>
						</td>
						<td>
							<?php echo $row->nomenklatur_cari;?>
						</td>
					</tr>
				<?php endforeach;?>
				<?php endif;?>
				</tbody>
			</table>
		</div>
		<!-- /.table-responsive -->
	</div>
	<!-- /.panel-body -->
</div>
<!-- /row -->

<script type="text/javascript">
$(document).ready(function() {
  $('#myModal_pickerjabatan #pickercaribtn').on('click', function (e) {
    var data = {
			nomenklatur_cari:$('#myModal_pickerjabatan input[name="nomenklatur_cari"]').val(),
		};
		if(data.nama_unor == ''  ){
			
			alert('Ketikkan nama unor yang akan dicari.');
			
      }else{
			$('#myModal_pickerjabatan .modal-body').html('<i class="fa fa-spinner fa-spin fa-2x"></i>');
			$.post("<?php echo site_url('appskp/skp/pickerjabatan');?>", data, function(result) {
				$('#myModal_pickerjabatan .modal-body').html(result);
			});
		}
  });
  $('#myModal_pickerjabatan #picker_ok').on('click', function (e) {
    var penilai_id_unor = $(this).data('id_unor');
    var penilai_nomenklatur_jabatan = $(this).data('nomenklatur_jabatan');
    var penilai_nomenklatur_pada = $(this).data('nomenklatur_cari');
    var penilai_nama_ese = $(this).data('nama_ese');

    $("form#form_editpenilai input[name='penilai_id_unor']").val(penilai_id_unor);
    $("form#form_editpenilai input[name='penilai_nomenklatur_jabatan']").val(penilai_nomenklatur_jabatan);
    $("form#form_editpenilai input[name='penilai_nomenklatur_pada']").val(penilai_nomenklatur_pada);
    $("form#form_editpenilai input[name='penilai_nama_ese']").val(penilai_nama_ese);
    $('#myModal_pickerjabatan').modal('hide');
		
  });
});
</script>

