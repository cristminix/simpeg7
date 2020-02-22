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
      <?php foreach($data as $row):?>
        <tr>
          <td>
            <div class="pull-left">
              <div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">
                  <i class="fa fa-gears fa-fw"></i> Aksi
                  <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu pull-right">
									<li><a href="#" 
										onclick="loadForm('<?php echo $id_pegawai;?>','<?php echo $row->id_peg_orangtua;?>','orangtua','form','form_orangtua');return false"">
										<i class="fa fa-edit fa-fw"></i> Ubah Data</a>
									</li>
									<li class="divider"></li>
									<li><a href="#" onclick="delPegOrangtua(<?php echo $row->id_peg_orangtua;?>);">
										<i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
									</li>
                </ul>
              </div>
            </div>
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
