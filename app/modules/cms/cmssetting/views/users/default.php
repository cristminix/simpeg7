<div class="row">
	<div class="col-lg-12">
		 <h1 class="page-header">Data Pegawai   <small id="subtext-pegawai"></small></h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div class="row"  id="daftarpegawai">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
        DATA PEGAWAI
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="example">
						<thead>
							<tr>
                <th>Aksi</th>
                <th>Pegawai</th>
                <th>Kepangkatan</th>
                <th>Jabatan</th>
							</tr>
						</thead>
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
<script type="text/javascript">
$(document).ready(function() {
  var table = $('#example').dataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "<?=site_url('appbkpp/dafpeg/data') ?>",
      "type": "POST"
    },
    "order": [[ 1, "asc" ]],
    "pagingType": "full_numbers",
    "columns": [
        { "data": "aksi", "searchable": false , "orderable": false }, 
        { "data": "nama_pegawai" },        
        { "data": "nama_pangkat" },        
        { "data": "nomenklatur_jabatan" },  
        { "data": "nomenklatur_pada","visible": false },           
        { "data": "nip_baru","visible": false },
        { "data": "nama_golongan","visible": false }
    ],
    "columnDefs": [ 
    {
      "targets":1,
      "data": null,
      "render": function ( data, type, row ) {
        var str = row.nama_pegawai+'<br/>'+row.tempat_lahir+', '+row.tanggal_lahir+'<br/>'+row.nip_baru;
        return str;
      }
    },
    {
      "targets":2,
      "data": null,
      "render": function ( data, type, row ) {
        var str = row.nama_pangkat+' / '+row.nama_golongan+'<br/>'+row.tmt_pangkat;
        return str;
      }
    },
    {
      "targets":3,
      "width": "50%",
      "data": null,
      "render": function ( data, type, row ) {
        var str = row.nomenklatur_jabatan+'<br/>'+row.nomenklatur_pada+'<br/>'+row.tmt_jabatan;
        return str;
      }
    },
    {
      "targets":0,
      "width": "60px",
      "data": null,
      "render": function ( data, type, row ) {
        var btn = ''+
        '<div class="pull-left">'+
        '<div class="btn-group">'+
        '<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">'+
        '<i class="fa fa-gears fa-fw"></i> Aksi'+
        '<span class="caret"></span>'+
        '</button>'+
        '<ul role="menu" class="dropdown-menu pull-right">'+
        '<li><a href="#" onclick="viewDetailPegawai('+row.id_pegawai+');return false;">'+
        '<i class="fa fa-binoculars fa-fw"></i> Lihat Data</a>'+
        '</li>'+
        '<li role="presentation" class="divider"></li>'+
        '<li><a href="<?php echo site_url('appdatapegawai/cetak/index');?>/'+row.id_pegawai+'" target="_blank">'+
        '<i class="fa fa-file-pdf-o fa-fw"></i> Cetak CV</a>'+
        '</li>'+
        '</ul>'+
        '</div>'+
        '</div>'+
        '';
        return btn;
      }
    } ],
    "language": {
      "url": "<?php echo base_url('assets/js/plugins/dataTables/i18n/Indonesian.json');?>"
    }     
  });
  
  
}
);
</script> 	
