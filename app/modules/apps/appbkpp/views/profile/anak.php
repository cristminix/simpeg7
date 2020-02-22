<div class="row">
	<div class="col-lg-12"  id="form_anak">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					<i class="fa fa-child fa-fw"></i> Data Anak Pegawai
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
<?php $arGender = array(''=>'Silahkan Pilih','l'=>'Laki-laki','p'=>'Perempuan');?>
<?php $ketr_tunj = array(''=>'Silahkan Pilih','Dapat'=>'Dapat Tunjangan','Tidak'=>'Tidak Dapat Tunjangan');?>
<?php $status_anak = array(''=>'Silahkan Pilih','Anak kandung'=>'Anak kandung','Anak tiri'=>'Anak tiri','Anak angkat'=>'Anak angkat');?>
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Anak, TTL</th>
          <th>Jenis Kelamin</th>
          <th>Pendidikan - Pekerjaan</th>
          <th>Ketr. Tunjangan</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $no=0;
	  foreach($data as $row):
	  $no++;
	  ?>
        <tr>
          <td>
		  <?=$no;?>
          </td><td>
            <?php echo $row->nama_anak;?><br/>
            <?php echo $row->tempat_lahir_anak;?> ( <em><?php echo $row->tanggal_lahir_anak;?></em> )
          </td><td>
            <?php echo $row->gender_anak;?>
          </td><td>
            <?php echo $row->pendidikan_anak;?> - <em><?php echo $row->pekerjaan_anak;?></em>
          </td><td>
            <?php echo (isset($ketr_tunj[$row->keterangan_tunjangan]))?$ketr_tunj[$row->keterangan_tunjangan]:'Tidak ada keterangan tunjangan';?>
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
