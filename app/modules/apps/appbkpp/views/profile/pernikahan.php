<div class="row">
	<div class="col-lg-12"  id="form_pernikahan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					<i class="fa fa-institution fa-fw"></i> Data Pernikahan Pegawai
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Suami/Istri</th>
          <th>Tanggal Menikah</th>
          <th>Pendidikan - Pekerjaan</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $no=0;
	  foreach($data as $row):
	  $no++;
	  ?>
        <tr id="pernikahanform-<?=$row->id_peg_perkawinan;?>">
          <td><?=$no;?>
          </td><td>
            <?php echo $row->nama_suris;?><br/>
            <?php echo $row->tempat_lahir_suris;?> ( <em><?php echo $row->tanggal_lahir_suris;?></em> )
          </td><td>
            <?php echo $row->tanggal_menikah;?>
          </td><td>
            <?php echo $row->pendidikan_suris;?> - <em><?php echo $row->pekerjaan_suris;?></em>
          </td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->