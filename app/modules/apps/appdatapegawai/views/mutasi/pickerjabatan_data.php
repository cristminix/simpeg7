<?php $jenis_jabatan = $this->dropdowns->jenis_jabatan(true);?>
<?php unset($jenis_jabatan['js']);?>
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
            id="picker_ok"  
            data-id_jabatan="<?php echo $row->id_jabatan;?>"
            data-nama_jabatan="<?php echo $row->nama_jabatan;?>"
            data-jab_type="<?php echo $row->jab_type;?>">
            <i class="fa fa-check fa-fw fa-lg"></i> 
          </button>
						
					</td>
					<td>
						<?php echo $row->nama_jabatan;?>
					</td>
					<td>
						<?php echo $jenis_jabatan[$row->jab_type];?>
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
  $('#myModal_pickerjabatan #picker_ok').on('click', function (e) {
    var id_jabatan = $(this).data('id_jabatan');
    var nama_jabatan = $(this).data('nama_jabatan');
    var jab_type = $(this).data('jab_type');
    // console.log()
    $("#form_jabatan input[name='id_jabatan']").val(id_jabatan);
    $("#form_jabatan input[name='nama_jabatan_jf']").val(nama_jabatan);
    $("#form_jabatan select[name='nama_jenis_jabatan']").val(jab_type);
    $('#myModal_pickerjabatan').modal('hide');
  });
});
</script>

