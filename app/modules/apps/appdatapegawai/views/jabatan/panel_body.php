<?php $jenis_jabatan = $this->dropdowns->jenis_jabatan(true); ?>
<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Nama Jabatan</th>
					<th>SKPD</th>
					<th>TMT Jabatan</th>
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
<!--
            <div class="pull-left">
              <div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">
                  <i class="fa fa-gears fa-fw"></i> Aksi
                  <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu pull-right">
                  <?php $jenis = ($row->nama_jenis_jabatan == 'js')?'js':'jf'; ?>
                  <li><a href="#" 
                    onclick="loadForm('<?php echo $id_pegawai;?>',<?php echo $row->id_peg_jab;?>, 'jabatan', 'form_<?php echo $jenis;?>', 'form_jabatan'); return false">
                    <i class="fa fa-edit fa-fw"></i> Ubah Data</a>
                  </li>
                  <li class="divider"></li>
                  <li><a href="#" onclick="delPegJabatan(<?php echo $row->id_peg_jab;?>);">
                    <i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
                  </li>
                </ul>
              </div>
            </div>
-->            </td><td>
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
