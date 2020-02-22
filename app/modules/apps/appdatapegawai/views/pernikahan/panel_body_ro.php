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
      <?php foreach($data as $row):?>
        <tr id="pernikahanform-<?=$row->id_peg_perkawinan;?>">
          <td>
            <div class="pull-left">
            
            </div>
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
