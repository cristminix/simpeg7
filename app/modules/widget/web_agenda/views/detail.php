<div class="main-page" style="margin-top:10px;">
        <!--content-->
        <div class="content">
	        <ol class="breadcrumb">
              <?=$jkanal;?>
            </ol>

       	  	<div class="article-detail">
				<div class='widget-title'><?=strtoupper(@$isi[0]->nama_kategori);?></div>
            	 <h2><?=@$isi[0]->judul;?></h2>
                 <small><?php echo @$isi[0]->hari_mulai.", ".@$isi[0]->tgl_mulai." s/d ".@$isi[0]->hari_selesai.", ".@$isi[0]->tgl_selesai;	?></small>
				 <div><div style='width:110px;float:left'>Topik</div><div style='width:15px; float:left;'>:</div><div style='display:table'><?=@$isi[0]->isi_artikel;?></div></div>
				<div><div style='width:110px;float:left'>Tempat</div><div style='width:15px; float:left;'>:</div><div><?=@$isi[0]->sub_judul;?></div></div>
<?php
$jfoto=0;
foreach($foto as $key=>$val){
	echo "<div id='tb".$val->id_foto."' onclick='getfoto(".$val->id_foto.")' style='cursor:pointer; float:left; padding:1px; border: 1px solid #0066FF; margin-right:2px;'><img src='".base_url()."assets/media/file/agenda/".@$isi[0]->id_konten."/".$val->foto_thumbs."' height='60px'></div>";
$jfoto++;
}
if($jfoto>0){	echo "<div id='tpfoto'><div id='inifoto' style='display:none'>99</div></div><div style='clear:both; height:20px;'></div>"; }
?>
       	  	</div>
	</div>
	<div class='sidebar'>
		<div id=rubrik style='display:none'><?=@$isi[0]->id_kategori;?></div>
          <div class="wrapper">
              <div class="widget-sidebox">
                  <h4>Arsip <?=@$isi[0]->nama_kategori;?></h4>
                  <div id='lainnya_<?=@$isi[0]->id_kategori;?>'></div>
				  <div class="clearfix"></div>
                   <div id='pager' class='bbb'></div>
              </div>
          </div>
          <div class="clearfix"></div>
<?php
echo Modules::run("web_detail_samping",@$isi[0]->id_kanal,"agenda",@$isi[0]->id_kategori);
?>
	</div>
</div>


<style type="text/css" media="all">
#kmn ul {list-style: none; padding: 0px; margin-top: 10px;}
#kmn li {float: left; border: 1px solid #0033ff; border-bottom-width: 0; margin-right: 0px; margin-left: 10px;}
#kmn a {text-decoration: none;display: block; background-color:#3ea0c8; color:#fff; padding: 0.24em 0.24em; width: 8em;	text-align: center;}
#kmn a:hover {background: #fff; color:#000;}
#kmn .selected {border-color: #0033ff;}
#kmn .selected a { position: relative; top: 1px; background-color:#ffffff; color: black; }
.cnta {border: 1px solid #0033ff; clear: both; padding: 10px 10px 10px 10px; background-color:#ffffff;  width:auto;}
.tombol_aksi {color: #ffffff; BACKGROUND-COLOR: #0066FF; float:left; border: 1px solid #0000FF; padding:3px 5px 2px 5px; font-size:12px; margin:0px 5px 3px 0px; cursor:pointer; border-radius: 4px; box-shadow: 1px 1px 2px rgb(0,0,0);}
.tombol_aksi:hover {color:#0000FF; background-color:#CCCCCC; float:left; border: 1px solid #0000FF; padding:3px 5px 2px 5px; font-size:12px; margin:0px 5px 3px 0px; cursor:pointer; border-radius: 4px; box-shadow: -1px -1px 2px rgb(0,0,0);}
</style>


<script type="text/javascript">
$(document).ready(function(){
	gridagenda(<?=$hal;?>);
});
////////////////////////////////////////////////////////////////////////////
function getfoto(idd){
	var ini = $("#inifoto").html();
	if(ini!=idd){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>web_agenda/getfoto/",
				data:{"idd": idd},
				success:function(data){
					var table = "<div id=tpfoto><div id=inifoto style='display:none'>"+data[0].id_foto+"</div>";
					table = table+"<div style='margin-bottom:10px; clear:both;'></div>";
					table = table+"<div style='padding:1px; border: 1px solid #0066FF; float:left;'><img src='<?=base_url();?>assets/media/file/agenda/"+data[0].id_konten+"/"+data[0].foto+"' width='640px'></div>";
					table = table+"</div>";
					$("#tpfoto").replaceWith(table);
				}, 
        dataType:"json"});
	} else {
					var table = "<div id=tpfoto><div id=inifoto style='display:none'>99</div>";
					table = table+"</div>";
					$("#tpfoto").replaceWith(table);
	}
}

function gridagenda(hal){
var rubrik = $("#rubrik").html();
$('#lainnya_'+rubrik+'').html("<img src='<?=base_url();?>assets/images/loading1.gif'>");
if(hal=="end"){var hali="end";} else {var hali=hal;}
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>web_agenda/getagenda/",
				data:{"hal": hali, "batas": <?=$batas;?>, "rubrik": rubrik},
				success:function(data){
if((data.hslquery.length)>0){
			var table=""; var nomor=0;
			$.each( data.hslquery, function(index, item){
					if(nomor%2==0){ var bgc="even";}else{ var bgc="odd";}

					if(item.id_konten == <?=@$isi[0]->id_konten;?>){
						table = table+ "<div class='widget-sidebox item "+bgc+"'>";
					} else {
						table = table+ "<a href=\"<?=site_url();?>read/agenda/"+item.id_konten+"/"+item.kat_seo+"/"+item.seo+"\"><div class='widget-sidebox item ada "+bgc+"'>";
					}
					table = table+item.judul;
					table = table+ "<br />";
					table = table+ "<small>"+ item.hari_mulai+", "+ item.tgl_mulai+" s/d "+item.hari_selesai+", "+item.tgl_selesai+"</small>";
					if(item.id_konten == <?=@$isi[0]->id_konten;?>){
						table = table+ "</div>";
					} else {
						table = table+ "</div></a>";
					}
				nomor++;
			}); //endeach
//			table = table+data.pager;
				$('#lainnya_'+rubrik+'').html(table);
				$('#pager').html(data.pager);
				$('#status_'+rubrik+'').html("lama");
		} else {
			$('#lainnya_'+rubrik+'').html("");
		}
}, 
        dataType:"json"});
}
////////////////////////////////////////////////////////////////////////////
function validasi_pengikut(){
	var data="";
	var dati="";
			var nama = $.trim($("#nama_komentator").val());
			var mail = $.trim($("#email_komentator").val());
			var komn = $.trim($("#isi_komentar").val());
			data=data+""+nama+"";
			if( nama ==""){	dati=dati+"NAMA tidak boleh kosong\n";	}
			if( mail ==""){	dati=dati+"EMAIL tidak boleh kosong\n";	}
			if( komn ==""){	dati=dati+"ISI KOMENTAR tidak boleh kosong\n";	}
	if( dati !=""){
		alert(dati);
		return false;
	} else {return data;}
}
////////////////////////////////////////////////////////////////////////////
function simpan(){
	var hasil=validasi_pengikut();
	if (hasil!=false) {
            jQuery.post($("#content-form").attr('action'),$("#content-form").serialize(),function(data){
				var arr_result = data.split("#");
                if(arr_result[0]=='sukses'){
					rShow(1);gridkomen('end');$("#isi_komentar").val("");$("#nama_komentator").val("");$("#email_komentator").val("");
                } else {
                }
            });
			return false;
	} //endif Hasil
}
</script>
