<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Kode Unor</th>
					<th>Nama Unor</th>
					<th>Lengkap</th>
				</tr>
			</thead>
			<tbody>
			<? foreach($data as $row):?>
				<tr>
					<td>
          <button class="btn btn-success btn-xs" type="button" 
            id="picker_ok"  
            data-id_unor="<?php echo $row->id_unor;?>"
            data-kode_unor="<?php echo $row->kode_unor;?>"
            data-nama_unor="<?php echo $row->nama_unor;?>" 
            data-nama_ese="<?php echo $row->nama_ese;?>" 
            data-kode_ese="<?php echo $row->kode_ese;?>" 
            data-nomenklatur_jabatan="<?php echo $row->nomenklatur_jabatan;?>" 
            >
            <i class="fa fa-check fa-fw fa-lg" ></i> 
          </button>
						
					</td>
					<td>
						<?php echo $row->kode_unor;?>
					</td>
					<td>
						<?php echo $row->nama_unor;?>
					</td>
					<td>
						<?php echo $row->nomenklatur_cari;?>
					</td>
				</tr>
			<? endforeach;?>
			</tbody>
		</table>
	</div>
	<!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
<script type="text/javascript">
$(document).ready(function() {
  $('#myModal_pickerunor #picker_ok').on('click', function (e) {
    var id_unor = $(this).data('id_unor');
    var nama_unor = $(this).data('nama_unor');
    var kode_unor = $(this).data('kode_unor');
    var nama_ese = $(this).data('nama_ese');
    var kode_ese = $(this).data('kode_ese');
    console.log(nama_ese);
    var nomenklatur_jabatan = $(this).data('nomenklatur_jabatan');
    // console.log()
    $("form#form_jabatan input[name='id_unor']").val(id_unor);
    $("form#form_jabatan input[name='kode_unor']").val(kode_unor);
    $("form#form_jabatan input[name='nama_unor']").val(nama_unor);
    $("form#form_jabatan input[name='nama_ese']").val(nama_ese);
    $("form#form_jabatan input[name='kode_ese']").val(kode_ese);
    $("form#form_jabatan input[name='nama_jabatan_js']").val(nomenklatur_jabatan);
    $('#myModal_pickerunor').modal('hide');
  });
});
</script>

