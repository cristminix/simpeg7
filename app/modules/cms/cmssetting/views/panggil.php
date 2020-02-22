<script type="text/javascript"> 
$(document).ready(function(){
	loadIsiGrid(0,0);
});

function loadIsiGrid(idp,lvl){
			$.ajax({
				type:"POST",
				url:"<?=site_url();?>cmssetting/getpanggil",
				data:{"idparent":idp,"level":lvl,"setting":"<?=$setting;?>"},
				success:function(data){

				if(data!=""){
					$("#panggil").html(data.isi)
				} //if data
		}, //success 
        dataType:"json"});
        return false;
}
</script>
<div id=panggil>Honda</div>