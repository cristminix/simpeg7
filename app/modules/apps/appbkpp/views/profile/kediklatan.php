<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Tgl Mulai - Tgl Selesai</th>
          <th>Nama Diklat</th>
          <th>Tempat</th>
          <th>SK</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $no=0;
	  foreach($diklat as $row):
	  $no++;
	  ?>
        <tr>
			<td><?=$no;?></td>
		  <td>
            <?php echo $row->tanggal_mulai;?> s.d <?php echo $row->tanggal_selesai;?><br/>
            <em><?php echo '';?></em>
          </td><td>
            <?php echo $row->nama_diklat;?>
          </td><td>
            <?php echo $row->tempat_diklat;?>
          </td><td>
            <?php echo $row->nomor_sk;?>  (<em><?php echo $row->tanggal_sk;?></em>)
          </td>
        </tr>
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
