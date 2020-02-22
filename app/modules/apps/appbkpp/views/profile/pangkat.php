<div class="row">
	<div class="col-lg-12"  id="form_kepangkatan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading row-fluid">
			<i class="fa fa-signal fa-fw"></i> Riwayat Kepangkatan Pegawai
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Pangkat Peringkat</th>
          <th>TMT Pangkat</th>
          <th>Angka Kredit</th>
          <th>SK</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $no=0;
	  foreach($pangkat as $key=>$row):
	  $no++;
	  ?>
        <tr>
			<td><?=$no;?></td>
		  <td>
            <?php echo $row->nama_pangkat;?> - <?php echo $row->nama_golongan;?><br/>
            <em><?php echo $row->jenis_kp;?></em>
          </td><td>
            <?php echo $row->tmt_golongan;?>
          </td><td>
            <?php echo $row->kredit_utama;?>
          </td><td>
            <?php echo $row->sk_nomor;?>  (<em><?php echo $row->sk_tanggal;?></em>)
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
<!-- Modal -->
<div class="modal fade" id="myModal_datalama_golongan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Riwayat Kepangkatan pada SIKDA Lama</h4>
      </div>
      <div class="modal-body">
			<?php echo $datalama;?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>