<div class="panel-body">
  <div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Pangkat Golongan</th>
          <th>TMT Pangkat</th>
          <th>SK</th>
        </tr>
      </thead>
      <tbody>
      <?php
	  $no=0;
	  foreach($data as $row):
	  $no++;
	  ?>
        <tr>
			<td><?=$no;?></td>
<!--
          <td>
            <div class="pull-left">
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">
                  <i class="fa fa-gears fa-fw"></i> Aksi
                  <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu pull-right">
                  <li><a href="#" 
                    onclick="loadForm('<?php echo $id_pegawai;?>',<?php echo $row->id_peg_golongan;?>, 'kepangkatan', 'form', 'form_kepangkatan'); return false">
                    <i class="fa fa-edit fa-fw"></i> Ubah Data</a>
                  </li>
                  <li class="divider"></li>
                  <li><a href="#" onclick="delPegKepangkatan(<?php echo $row->id_peg_golongan;?>);">
                    <i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
                  </li>
                </ul>
              </div>
            </div>
          </td>
-->
		  <td>
            <?php echo $row->nama_pangkat;?> - <?php echo $row->nama_golongan;?><br/>
            <em><?php echo $row->jenis_kp;?></em>
          </td><td>
            <?php echo $row->tmt_golongan;?>
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
