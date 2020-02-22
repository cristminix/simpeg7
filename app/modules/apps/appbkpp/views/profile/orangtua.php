<div class="row">
	<div class="col-lg-12"  id="form_orangtua">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-info">
			<div class="panel-heading row-fluid">
					<i class="fa fa-child fa-fw"></i> Data Orang Tua Pegawai
			</div>
			<!-- /.panel-heading -->
			<!-- Tabel Content Goes Here -->
<?php $arGender = array(''=>'Silahkan Pilih','l'=>'Laki-laki','p'=>'Perempuan');?>
<?php $ketr_tunj = array(''=>'Silahkan Pilih','Dapat'=>'Dapat Tunjangan','Tidak'=>'Tidak Dapat Tunjangan');?>
<?php $ketr= array(''=>'Silahkan Pilih','Masih Hidup'=>'Masih Hidup','Sudah Meninggal'=>'Sudah Meninggal');?>
<?php $status_orangtua= array(''=>'Silahkan Pilih','Orang Tua Kandung'=>'Orang Tua Kandung','Orang Tua Angkat'=>'Orang Tua Angkat','Orang Tua Tiri'=>'Orang Tua Tiri');?>
<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nama Orang Tua, TTL</th>
          <th>Jenis Kelamin</th>
          <th>Status Orang Tua</th>
          <th>Ketr. Tunjangan</th>
          <th>Keterangan</th>
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
            <?php echo $row->nama_orangtua;?><br/>
            <?php echo $row->tempat_lahir_orangtua;?> ( <em><?php echo $row->tanggal_lahir_orangtua;?></em> )
          </td><td>
            <?php echo sikda_gender($row->gender_orangtua);?>
          </td><td>
            <?php echo $row->status_orangtua;?> 
          </td><td>
            <?php echo (isset($ketr_tunj[$row->keterangan_tunjangan]))?$ketr_tunj[$row->keterangan_tunjangan]:'Tidak ada keterangan tunjangan';?>
          </td><td>
            <?php echo (isset($ketr[$row->keterangan]))?$ketr[$row->keterangan]:'Tidak ada keterangan';?>
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
