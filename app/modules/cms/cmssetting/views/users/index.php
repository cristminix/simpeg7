<div class="row">
	<div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
		 <h3 class="page-header"><?=$satu;?></h3>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div id="grid-data">
<div class="row">
	<div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
		<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="example">
						<thead>
							<tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>TAHUN / PERIODE</th>
                <th>PEGAWAI</th>
                <th>PEJABAT PENILAI</th>
							</tr>
						</thead>
					</table>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.grid-data -->
<script type="text/javascript">
$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
  {
    return {
      "iStart":         oSettings._iDisplayStart,
      "iEnd":           oSettings.fnDisplayEnd(),
      "iLength":        oSettings._iDisplayLength,
      "iTotal":         oSettings.fnRecordsTotal(),
      "iFilteredTotal": oSettings.fnRecordsDisplay(),
      "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
      "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
    };
  };
$(document).ready(function() {
  var table = $('#example').dataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "<?=site_url('appskp/realisasi_verifikasi/data') ?>",
      "type": "POST"
    },
    "order": [[ 2, "asc" ]],
    "pagingType": "full_numbers",
    "columns": [
        { "data": "no", "searchable": false , "orderable": false }, 
        { "data": "aksi", "searchable": false , "orderable": false }, 
        { "data": "tahun" },        
        { "data": "nama_pegawai" },        
        { "data": "penilai_nama_pegawai" },  
        { "data": "penilai_nomenklatur_jabatan","visible": false },  
        { "data": "penilai_nama_pangkat","visible": false },           
        { "data": "nip_baru","visible": false },
        { "data": "penilai_nip_baru","visible": false },
        { "data": "nama_golongan","visible": false }
    ],
		"fnDrawCallback": function ( oSettings ) {
			/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered )
			{
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					var x = this.dataTable().fnPagingInfo().iStart;
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( x+i+1 );
				}
			}
		},
    "columnDefs": [ 
    {
      "targets":0,
      "data": null,
      "render": function ( data, type, row ) {
        //var x = $('#example').dataTable();
		//console.log(x.page);
		var str = row.nama_golongan;
        return str;
      }
    },
    {
      "targets":2,
      "data": null,
      "render": function ( data, type, row ) {
//        var str = row.nama_pegawai+'<br/>'+row.tempat_lahir+', '+row.tanggal_lahir+'<br/>'+row.nip_baru;
        var str = row.tahun+'<br/>'+row.bulan_mulai+' s.d. '+row.bulan_selesai;
        return str;
      }
    },
    {
      "targets":3,
      "data": null,
      "render": function ( data, type, row ) {
//        var str = row.nama_pangkat+' / '+row.nama_golongan+'<br/>'+row.tmt_pangkat;
        var str = row.nama_pegawai+'<br/>'+row.nip_baru+'<br/>'+row.nama_pangkat+' / '+row.nama_golongan+'<br/>'+row.nomenklatur_jabatan;
        return str;
      }
    },
    {
      "targets":4,
      "width": "350px",
      "data": null,
      "render": function ( data, type, row ) {
//        var str = row.nomenklatur_jabatan+'<br/>'+row.nomenklatur_pada+'<br/>'+row.tmt_jabatan;
        var str = row.penilai_nama_pegawai+'<br/>'+row.penilai_nip_baru+'<br/>'+row.penilai_nama_pangkat+' / '+row.penilai_nama_golongan+'<br/>'+row.penilai_nomenklatur_jabatan;
        return str;
      }
    },
    {
      "targets":1,
      "width": "60px",
      "data": null,
      "render": function ( data, type, row ) {
        var btn = ''+
        '<button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle" type="button">'+
        '<span class="caret"></span>'+
        '</button>'+
/*
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
*/
        '';
        return btn;
      }
    } ]
//	,
//    "language": {
//      "url": "<?php echo base_url('assets/js/plugins/dataTables/i18n/Indonesian.json');?>"
//    }     




  });
  

  
});
</script> 	
