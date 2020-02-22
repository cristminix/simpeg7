<div class="row">
	<div class="col-lg-12"  id="form_jabatan">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-success">
			<div class="panel-heading row-fluid">
				<i class="fa fa-tasks fa-fw"></i> Riwayat Jabatan Pegawai
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
<?php $jenis_jabatan = $this->dropdowns->jenis_jabatan(true); ?>
<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama Jabatan</th>
					<th>unit kerja</th>
					<th>TMT Jabatan</th>
				</tr>
			</thead>
			<tbody>
        <?php
		$no=0;
		foreach($jabatan as $key=>$row):
		$no++;
		?>
        <tr>
          <td>
		  <?=$no;?>
           </td><td>
            <?php echo $row->nama_jabatan;?><br/>
            <em><?php echo $jenis_jabatan[$row->nama_jenis_jabatan];?></em>
            </td><td>
            <?php echo $row->nama_unor;?>
            </td><td>
            <?php echo $row->tmt_jabatan;?><br/>
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
