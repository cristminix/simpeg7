<div class="row">
	<div class="col-lg-12"  id="form_mutasi">
		<!-- Form Content Goes Here -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		 <h1 class="page-header">Mutasi Pegawai  <small id="subtext-pegawai"></small></h1>
	</div>
</div>
<!-- /.row -->
<div class="row"  >
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
        <div class="row">
          <form role="form" id="form_anak" class="form-horizontal">
            <div class="col-lg-6">
              
              <div class="form-group">
                <label class="col-sm-3 control-label">NIP Baru</label>
                <div class="col-sm-9">
                  <div class="input-group">
                  <?=form_input('nip_baru',(!isset($row->nip_baru))?'':$row->nip_baru,'class="form-control"');?>
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="button" onclick="cari()">Cari!</button>
                    </span>
                  </div><!-- /input-group -->
                </div> 
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Nama Pegawai</label>
                <div class="col-sm-9">
                  <?=form_input('nama_pegawai',(!isset($row->nama_pegawai))?'':$row->nama_pegawai,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Gol. / Pangkat</label>
                <div class="col-sm-9">
                  <?=form_input('nama_golongan',(!isset($row->nama_golongan))?'':$row->nama_golongan.' / '.$row->nama_pangkat,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <label class="col-sm-3 control-label">TMT Pangkat</label>
                <div class="col-sm-9">
                  <?=form_input('tmt_pangkat',(!isset($row->tmt_pangkat))?'':$row->tmt_pangkat,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              <? if(isset($id_pegawai) && $id_pegawai): ?>
              <button class="btn btn-success btn-block" type="button" onclick="formjs();">Mutasikan sebagai Jabatan Struktural</button>
              <button class="btn btn-primary btn-block" type="button" onclick="formjf();">Mutasikan sebagai Jabatan Fungsional Umum / Tertentu</button>
              <? endif; ?>
            </div>
            <!-- /.col-lg-6 (nested) -->
            <div class="col-lg-6">
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Jenis Jabatan</label>
                <div class="col-sm-9">
                  <?=form_dropdown('jab_type',$this->dropdowns->jenis_jabatan(),(!isset($row->jab_type))?'':$row->jab_type,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Nama Jabatan</label>
                <div class="col-sm-9">
                  <?=form_input('nomenklatur_jabatan',(!isset($row->nomenklatur_jabatan))?'':$row->nomenklatur_jabatan,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <label class="col-sm-3 control-label">TMT Jabatan</label>
                <div class="col-sm-9">
                  <?=form_input('tmt_jabatan',(!isset($row->tmt_jabatan))?'':$row->tmt_jabatan ,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              
              <div class="form-group">
                <label class="col-sm-3 control-label">Kode Unor</label>
                <div class="col-sm-9">
                  <?=form_input('kode_unor',(!isset($row->kode_unor))?'':$row->kode_unor,'class="form-control" disabled');?>
                </div> 
              </div>
              <!-- /.form-group -->
              
              <!-- Textarea -->
              <div class="form-group">
                <label  class="col-sm-3 control-label">SKPD</label>
                <div class="col-sm-9">
                  <?php echo form_textarea(
                    array(
                    'name'         => 'nomenklatur_pada',
                    'id'           => 'nomenklatur_pada',                       
                    'class'        => 'form-control ',
                    'disabled'     => 'disabled',
                    'rows'         => 3
                    ),
                    set_value('nomenklatur_pada',(!isset($row->nomenklatur_pada))?'':$row->nomenklatur_pada)
                  );?>
                </div> 
              </div>
              <!-- /.form-group -->
              
            </div>
            <!-- /.col-lg-6 (nested) -->
          </form>
          <!-- /form -->
        </div>
        <!-- /.row (nested) -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- Modal -->
<div class="modal fade" id="myModal_pickerunor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pencarian UNOR</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal_pickerjabatan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Pencarian Jabatan Fungsional</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function cancelForm(targetID){
    $('#'+targetID).html('');
  }
  function cari(){
	var data = {
    'nip_baru': $('input[name="nip_baru"]').val()
  };
  $.post("<?php echo site_url('appdatapegawai/mutasi/cari');?>", data, 
    function(result){
      $("#page-wrapper").html(result);
    }
  );
}
<?php if(isset($id_pegawai) && $id_pegawai): ?>
function formjs(){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai ?>'
  };
  $.post("<?php echo site_url('appdatapegawai/mutasi/form_js');?>", data, 
    function(result){
      $("#form_mutasi").html(result);
    }
  );
}
function formjf(){
	var data = {
    'id_pegawai': '<?php echo $id_pegawai ?>'
  };
  $.post("<?php echo site_url('appdatapegawai/mutasi/form_jf');?>", data, 
    function(result){
      $("#form_mutasi").html(result);
    }
  );
}
<?php endif; ?>
$(document).ready(function() {
  $('#myModal_pickerunor').on('show.bs.modal', function (e) {
    $('#myModal_pickerunor .modal-body').css('overflow-y', 'auto'); 
    $('#myModal_pickerunor .modal-body').css('height', $(window).height() * 0.7);        
    $('#myModal_pickerunor .modal-dialog').css('width', $(window).width() * 0.7);        
    var data = {
      name:'id_unor',
      m:'jabatan',
      f:'pickerunor'
    };
    $.post("<?php echo site_url('datapegawai/picker');?>", data, function(result) {
      $('#myModal_pickerunor .modal-body').html(result);
    });
  });
  $('#myModal_pickerjabatan').on('show.bs.modal', function (e) {
    $('#myModal_pickerjabatan .modal-body').css('overflow-y', 'auto'); 
    $('#myModal_pickerjabatan .modal-body').css('height', $(window).height() * 0.7);        
    $('#myModal_pickerjabatan .modal-dialog').css('width', $(window).width() * 0.7);        
    var data = {
      name:'id_jabatan',
      m:'jabatan',
      f:'pickerjabatan'
    };
    $.post("<?php echo site_url('datapegawai/picker');?>", data, function(result) {
      $('#myModal_pickerjabatan .modal-body').html(result);
    });
  });
  $(".alert").delay(4000).slideUp(200, function() {
    $(this).alert('close');
  });
});
</script>