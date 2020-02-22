<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama Pendidikan</th>
					<th>Jenjang</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($data as $row):?>
				<tr>
					<td>
          <button class="btn btn-success btn-xs" type="button" 
            id="picker_pendidikan_ok"  
            data-id_pendidikan="<?php echo $row->id_pendidikan;?>"
            data-nama_jenjang="<?php echo $row->nama_jenjang;?>"
            data-nama_pendidikan="<?php echo $row->nama_pendidikan;?>" >
            <i class="fa fa-check fa-fw fa-lg"></i> 
          </button>
						
					</td>
					<td>
						<?php echo $row->nama_pendidikan;?>
					</td>
					<td>
						<?php echo $row->nama_jenjang;?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
<script type="text/javascript">
$(document).ready(function() {
  $('#myModal #picker_pendidikan_ok').on('click', function (e) {
    var id_pendidikan = $(this).data('id_pendidikan');
    var nama_pendidikan = $(this).data('nama_pendidikan');
    var nama_jenjang = $(this).data('nama_jenjang');
    // console.log()
    $("#form_pendidikan input[name='id_pendidikan']").val(id_pendidikan);
    $("#form_pendidikan input[name='jurusan']").val(nama_pendidikan);
    $("#form_pendidikan input[name='nama_jenjang']").val(nama_jenjang);
    $('#myModal').modal('hide');
  });
});
</script>

