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
										onclick="loadForm('<?php echo $id_pegawai;?>','<?php echo $row->id_peg_anak;?>','anak','form','form_anak');return false"">
										<i class="fa fa-edit fa-fw"></i> Ubah Data</a>
									</li>
									<li class="divider"></li>
									<li><a href="#" onclick="delPegAnak(<?php echo $row->id_peg_anak;?>);">
										<i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
									</li>
                </ul>
              </div>
            </div>
          </td><td>
            <?php echo $row->nama_anak;?><br/>
            <?php echo $row->tempat_lahir_anak;?> ( <em><?php echo $row->tanggal_lahir_anak;?></em> )
          </td><td>
            <?php echo sikda_gender($row->gender_anak);?>
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
