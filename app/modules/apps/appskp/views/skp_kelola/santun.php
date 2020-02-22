<br/><br/>
<div id="grid-data">
<div class="row">
	<div class="col-lg-12" style="padding-left:0px;padding-right:0px;">
		<div class="table-responsive">
<form id="content-form" method="post" action="<?=site_url("appskp/skp/form_aksi");?>" enctype="multipart/form-data">
<table width="100%" class="table info table-striped table-bordered table-hover">
<thead id=gridhead>
<tr height=20>
<th width=25>No.</th>
<th width=25>AKSI</th>
<th width=70>TAHUN</th>
<th width=250>PERIODE</th>
<th align=center>PEJABAT PENILAI</th>
<th width=110>STATUS</th>
</tr>
</thead>
<tbody>
<?php
$no=1;
$bulan = $this->dropdowns->bulan();
foreach($skp AS $key=>$val){
?>
<tr id='row_<?=$val->id_skp;?>'>
<td id='nomor_<?=$val->id_skp;?>'><?=$no;?></td>
<td id='aksi_<?=$val->id_skp;?>' align=center>
	<button class="btn beku btn-primary btn-xs" type="button" style="display:none;"><span class="caret"></span></button>
	<div class="dropdown"><button class="btn btn-primary dropdown-toggle btn-xs" type="button" id="dropdownMenu1" data-toggle="dropdown"><span class="caret"></span></button>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
			<li role="presentation"><a href="<?=site_url('appskp/skp/alih/'.$val->id_skp);?>" role="menuitem" tabindex="-1" style="cursor:pointer;"><i class="fa fa-binoculars fa-fw"></i>Lihat data</a></li>
			<li role="presentation" class="divider"></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('skp/form','<?=$val->id_skp;?>','<?=$no;?>');"><i class="fa fa-edit fa-fw"></i>Edit data</a></li>
			<li role="presentation"><a role="menuitem" tabindex="-1" style="cursor:pointer;" onClick="bsmShow('hapus','<?=$val->id_skp;?>','<?=$no;?>');"><i class="fa fa-trash fa-fw"></i>Hapus data</a></li>
		</ul>
	</div>
</td>
<td id='tahun_<?=$val->id_skp;?>'><?=$val->tahun;?></td>
<td id='periode_<?=$val->id_skp;?>'><?=$bulan[$val->bulan_mulai]." s.d. ".$bulan[$val->bulan_selesai];?></td>
<td id='penilai_<?=$val->id_skp;?>'>
								<div>
										<div style="float:left; width:110px;">Nama</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id='nama_penilai_<?=$val->id_skp;?>'><?=(trim($val->penilai_gelar_nonakademis) != '-')?trim($val->penilai_gelar_nonakademis).' ':'';?><?=(trim($val->penilai_gelar_depan) != '-')?trim($val->penilai_gelar_depan).' ':'';?><?=$val->penilai_nama_pegawai;?><?=(trim($val->penilai_gelar_belakang) != '-')?', '.trim($val->penilai_gelar_belakang):'';?></div>
								</div>
								<div style="clear:both"></div>
								<div>
										<div style="float:left; width:110px;">NIP</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id='nip_penilai_<?=$val->id_skp;?>'><?=$val->penilai_nip_baru;?></div>
								</div>
								<div style="clear:both"></div>
								<div>
										<div style="float:left; width:110px;">Pangkat/Gol.</div>
										<div style="float:left; width:10px;">:</div>
										<div style="float:left;" id='pangkat_penilai_<?=$val->id_skp;?>'><?=$val->penilai_nama_pangkat." / ".$val->penilai_nama_golongan;?></div>
								</div>
								<div style="clear:both"></div>
								<div>
										<div style="float:left; width:110px;">Jabatan</div>
										<div style="float:left; width:10px;">:</div>
										<span><div style="display:table;" id='jabatan_penilai_<?=$val->id_skp;?>'><?=$val->penilai_nomenklatur_jabatan;?></div></span>
								</div>
</td>
<td id='status_<?=$val->id_skp;?>'><?=$val->status;?></td>
</tr>
<?php
$no++;
}
?>
<tr id='row_xx'>
<td id='nomor_xx'><?=$no;?></td>
<td id='aksi_xx' align=center>...</td>
<td id='tahun_xx'>...</td>
<td id='periode_xx'>...</td>
<td id='penilai_xx'>...</td>
<td id='status_xx'><button class="btn tambah btn-primary btn-xs" type="button" data-nomor="<?=($no);?>" id='xx'>Buat SKP Baru</button></td>
</tr>
</table>
</form>
		</div>
		<!-- table-responsive --->
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
</div>
<!-- /.grid-data -->
<br/><br/>
		<!-- Modal -->
		<div class="modal fade modal-wide" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel">FORM HAPUS SKP</h4>
                                        </div>
                                        <div class="modal-body" id="isi_modal">
										  satu
                                        </div>
	                                    <!-- /.modal-body -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" onclick="javascript:void(0);hapus();">Hapus</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal...</button>
                                        </div>
	                                    <!-- /.modal-footer -->
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
		</div>
		<!-- /.modal -->
		<!-- SIMPAN -->
		<div id="simpan" style="display:none;"></div>
		<!-- /.SIMPAN -->

<script type="text/javascript">
$(document).on('click', '.btn.batal',function(){
	var ini = $(this).attr("id");
	var nomor = $(this).attr("data-nomor");
	var tt= $('#simpan').html();
	$('#row_'+ini+'').html(tt);
			$('.dropdown').show();
			$('.btn.beku').hide();
			$('.btn.btn-primary.dropdown-beku.btn-xs').removeClass("btn btn-primary dropdown-beku btn-xs").addClass("btn btn-primary dropdown-toggle btn-xs");
			$('#xx').addClass("tambah");
	$('#simpan').html('');
});
function bsmShow(tujuan,idd,no){
		if(tujuan=="skp/form"){
			$.ajax({
			type:"POST",
			url:"<?=site_url();?>appskp/"+tujuan+"/",
			data:{"idd": idd,"nomor":no },
			beforeSend:function(){	 },
			success:function(data){
				var ts = $('#row_'+idd+'').html();
				$('#simpan').html(ts);
				$('#row_'+idd+'').replaceWith(data);
				$('.dropdown').hide();
				$('.btn.beku').show();
				$('#xx').removeClass("tambah");
			},
			dataType:"html"});
		} else {  // hapus
			var data = "<div>Tahun :"+$('#tahun_'+idd+'').html()+"</div>";
			data = data + "<div>Periode :"+$('#periode_'+idd+'').html()+"</div>";
			data = data + "<div>Pejabat penilai :"+$('#nama_penilai_'+idd+'').html()+"</div>";
			data = data + "<div id='idhapus' style=\"display:none;\">"+idd+"</div>";
			$('#isi_modal').html(data);
			$('#myModal').modal('show');
		}
}


$(document).on('click', '.btn.tambah',function(){
	var nomor = $(this).attr("data-nomor");
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/skp/form",
		data:{"idd": "xx","nomor":nomor },
		beforeSend:function(){	 },
        success:function(data){
			var ts = $('#row_xx').html();
			$('#simpan').html(ts);
			$('#row_xx').replaceWith(data);
			$('.dropdown').hide();
			$('.btn.beku').show();
		},
        dataType:"html"});
});
$(document).on('click', '.btn.simpan',function(){
	var idd = $(this).attr('id');
	jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
		var tab="";
		if(data.aksi=="edit"){
			$('#tahun_'+idd+'').html(data.tahun);
			$('#periode_'+idd+'').html(data.bulan_mulai+" s.d. "+data.bulan_selesai);
			$('#nama_penilai_'+idd+'').html(data.nama_penilai);
			$('#nip_penilai_'+idd+'').html(data.penilai_nip_baru);
			$('#pangkat_penilai_'+idd+'').html(data.penilai_nama_pangkat+" / "+data.penilai_nama_golongan);
			$('#jabatan_penilai_'+idd+'').html(data.penilai_nomenklatur_jabatan);
		} else	{  // tambah
			var no = parseInt($('#nomor_xx').html());
			$('#nomor_xx').html(no+1);
			tab = "<tr id=row_"+data.id_skp+">";
			tab = tab + "<td id='nomor_"+data.id_skp+"'>"+no+"</td>";
			tab = tab + "<td id='aksi_"+data.id_skp+"' align='center'>";
			tab = tab + "<button class=\"btn beku btn-primary btn-xs\" type=\"button\" style=\"display:none;\"><span class=\"caret\"></span></button>";
			tab = tab + "<div class=\"dropdown\"><button class=\"btn btn-primary dropdown-toggle btn-xs\" type=\"button\" id=\"dropdownMenu1\" data-toggle=\"dropdown\"><span class=\"caret\"></span></button>";
			tab = tab + "<ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu1\">";
			tab = tab + "<li role=\"presentation\"><a href=\"<?=site_url('appskp/skp/alih');?>/"+data.id_skp+"\" role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\"><i class=\"fa fa-binoculars fa-fw\"></i>Lihat data</a></li>";
			tab = tab + "<li role=\"presentation\" class=\"divider\"></li>";
			tab = tab + "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('skp/form','"+data.id_skp+"','"+no+"');\"><i class=\"fa fa-edit fa-fw\"></i>Edit data</a></li>";
			tab = tab + "<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" style=\"cursor:pointer;\" onClick=\"bsmShow('hapus','"+data.id_skp+"','"+no+"');\"><i class=\"fa fa-trash fa-fw\"></i>Hapus data</a></li>";
			tab = tab + "</ul></div></td>";
			tab = tab + "<td id='tahun_"+data.id_skp+"'>"+data.tahun+"</td>";
			tab = tab + "<td id='periode_"+data.id_skp+"'>"+data.bulan_mulai+" s.d. "+data.bulan_selesai+"</td>";
			tab = tab + "<td id='penilai_"+data.id_skp+"'>";
			tab = tab + "<div><div style=\"float:left; width:110px;\">Nama</div><div style=\"float:left; width:10px;\">:</div><div style=\"float:left;\" id='nama_penilai_"+data.id_skp+"'>"+data.nama_penilai+"</div></div>";
			tab = tab + "<div style=\"clear:both\"></div><div><div style=\"float:left; width:110px;\">NIP</div><div style=\"float:left; width:10px;\">:</div><div style=\"float:left;\" id='nip_penilai_"+data.id_skp+"'>"+data.penilai_nip_baru+"</div></div>";
			tab = tab + "<div style=\"clear:both\"></div><div><div style=\"float:left; width:110px;\">Pangkat/Gol.</div><div style=\"float:left; width:10px;\">:</div><div style=\"float:left;\" id='pangkat_penilai_"+data.id_skp+"'>"+data.penilai_nama_pangkat+" / "+data.penilai_nama_golongan+"</div></div>";
			tab = tab + "<div style=\"clear:both\"></div><div><div style=\"float:left; width:110px;\">Jabatan</div><div style=\"float:left; width:10px;\">:</div><div style=\"float:left;\" id='jabatan_penilai_"+data.id_skp+"'>"+data.penilai_nomenklatur_jabatan+"</div></div>";
			tab = tab + "</td>";
			tab = tab + "<td id='status_"+data.id_skp+"'>"+data.status+"</td>";
			tab = tab + "</tr>";
			var ts = parseInt($('#xx').attr('data-nomor'));
			$('#xx').attr('data-nomor',(ts+1));
		}
		jQuery('.btn.batal').click();
		$(tab).insertBefore('#row_xx');
		$('#simpan').html('');
	},"json");
	return false;
});
function hapus(){
	var idd = $('#idhapus').html();
	var iii = 1;
		$.ajax({
        type:"POST",
		url:"<?=site_url();?>appskp/skp/hapus_skp",
		data:{"idd": idd },
		beforeSend:function(){	 },
        success:function(data){
			$('#row_'+idd+'').remove();
			$("[id^='nomor_']").each(function(key,val) {
				$(this).html(iii);
				iii++;
			});
				var ts = parseInt($('#xx').attr('data-nomor'));
				$('#xx').attr('data-nomor',(ts-1));
			$('#myModal').modal('hide');
		},
        dataType:"html"});
}
</script>
<style>
table th {	text-align:center; vertical-align:middle;	}
</style>