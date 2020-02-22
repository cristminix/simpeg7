<div class="panel-body">
  <div class="table-responsive">
  <input type="hidden" id="span_id_pegawai" value="<?php printf('%s', $id_pegawai);?>" />
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Suami/Istri</th>
          <th>Tanggal Menikah</th>
          <th>Pendidikan - Pekerjaan</th>
          <th>Status Aktif</th>

        </tr>
      </thead>
      <tbody>
      <?php 
      
      foreach($data as $row):
        $_class = $row->status_aktif === '1' ? 'success' : 'warning';
        ?>
        <tr id="pernikahanform-<?php echo $row->id_peg_perkawinan;?>">
          <td>
            <div class="pull-left">
              <div class="btn-group">
								<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">
                  <i class="fa fa-gears fa-fw"></i> Aksi
                  <span class="caret"></span>
                </button>
                <ul role="menu" class="dropdown-menu pull-right">
									<li><a href="#" 
										onclick="loadForm('<?php echo $id_pegawai;?>','<?php echo $row->id_peg_perkawinan;?>','pernikahan','form','form_pernikahan');return false"">
										<i class="fa fa-edit fa-fw"></i> Ubah Data</a>
									</li>
									<li class="divider"></li>
									<li><a href="#" onclick="delPegPernikahan(<?php echo $row->id_peg_perkawinan;?>);">
										<i class="fa fa-trash-o fa-fw"></i> Hapus Data</a>
									</li>
                </ul>
                </div>
            </div>
          </td><td>
            <?php echo $row->nama_suris;?><br/>
            <?php echo $row->tempat_lahir_suris;?> ( <em><?php echo $row->tanggal_lahir_suris;?></em> )
          </td><td>
            <?php echo $row->tanggal_menikah;?>
          </td><td>
            <?php echo $row->pendidikan_suris;?> - <em><?php echo $row->pekerjaan_suris;?></em>
            <a name="<?php printf('focus_form%s',$row->id_peg_perkawinan);?>">
            </td>
            <td>
            <?php 
            $since = $row->status_aktif && intval($row->tanggal_aktif) ? ' sejak ' . date('d-m-Y', strtotime($row->tanggal_aktif)) : '';
            printf('(%s) %s%s', $row->status_aktif, dkpg_stat($row->status_aktif), $since);
            printf('<p>Ket: %s</p>', $row->keterangan);
            ?>

          </td>
        </tr>
        <!-- Riwayat Tunjangan -->
        <!-- Riwayat Tunjangan form-->
        <tr>
          <td colspan="5" id="<?php printf('form_pernikahan_tunjangan%s',$row->id_peg_perkawinan);?>">
          </td>
        </tr>
        <!-- ./Riwayat Tunjangan form-->
        <tr>
          <td colspan="5">
            <?php echo (!isset(${'notif' . $row->id_peg_perkawinan}))?'': ${'notif' . $row->id_peg_perkawinan};?>
            <div class="panel <?php printf('panel-%s', $_class);?>">

              <div class="panel-heading row-fluid">
                <?php if($row->status_aktif === '1') :?>
                <button data-toggle="dropdown" 
                  class="btn btn-success btn-xs" type="button" title="Tambah Riwayat Tunjangan Pernikahan"
                  onclick="loadForm('<?php echo $row->id_peg_perkawinan;?>','add','pernikahan','form_sub','<?php printf('form_pernikahan_tunjangan%s',$row->id_peg_perkawinan);?>');jumptoform('<?php printf('focus_form%s',$row->id_peg_perkawinan);?>');return false">
                  <i class="fa fa-plus-square fa-fw fa-lg"></i>
                </button>
                <?php endif;?>
              Riwayat Status Tunjangan Pernikahan
                
              </div>
              <!-- /.panel-heading -->
              <?php if($row->list_tunjangan): ?>
              <div class="panel-body">
                              
                  <div class="table-responsive">
                    
                    <table class="table table-striped table-bordered table-hover table-condensed">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Status Tunjangan</th>
                          <th>Tanggal Efektif</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php foreach($row->list_tunjangan as $rowtunj):?>
                      <tr id="pernikahantunjform-<?php echo $rowtunj->id;?>">
                        <td>
                          <div class="pull-left">
                          <?php if($row->status_aktif === '1') :?>
                          <div class="btn-group">
                              
                              <button data-toggle="dropdown" class="btn <?php printf('btn-%s', $_class);?> btn-xs dropdown-toggle" type="button">
                                <i class="fa fa-gears fa-fw"></i> Aksi
                                <span class="caret"></span>
                              </button>
                              
                              <ul role="menu" class="dropdown-menu pull-right">
                                <li><a href="#<?php printf('focus_form%s',$row->id_peg_perkawinan);?>" 
                                onclick="loadForm('<?php echo $row->id_peg_perkawinan;?>','<?php printf('%s', $rowtunj->id);?>','pernikahan','form_sub','<?php printf('form_pernikahan_tunjangan%s',$row->id_peg_perkawinan);?>');return false"">
                                  <i class="fa fa-edit fa-fw"></i> Ubah Data</a>
                                </li>
                              </ul>
                              </div>

                          </div>
                          <?php endif;?>
                          <div class="pull-right">
                            <?php printf('#%s', $rowtunj->id);?>
                          </div>
                        </td>
                        <td><?php printf('%s', dkpg_alw_mar_stat($rowtunj->status_tunjangan));?></td>
                        <td><?php 
                          $thisdate = intval($rowtunj->tgl_efektif) ? date('d-m-Y', strtotime($rowtunj->tgl_efektif)) : '';
                          printf('%s', $thisdate ? $thisdate : 'Belum di set');?>
                        </td>
                        <td><?php printf('%s', $rowtunj->keterangan);?></td>
                      </tr>
                      <?php endforeach;?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <?php endif; ?> 
            </div>   
          </td>
        </tr>
        <!-- ./Riwayat Tunjangan -->
      <?php endforeach;?>
      </tbody>
    </table>
  </div>
  <!-- /.table-responsive -->
</div>
<!-- /.panel-body -->
