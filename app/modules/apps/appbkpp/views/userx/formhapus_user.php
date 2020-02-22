<div style="float:left;width:80%;">
    <form id="content-form" method="post" action="" enctype="multipart/form-data">
    <div style="statussave"></div>
    <table width="100%" cellspacing="0" cellpadding="0" class="table-form-flat">
        <tr>
          <th colspan="4" style="border:none">FORM HAPUS PENGGUNA</th>
        </tr>
        <tr>
          <td width="20%">Nama Pengguna</td>
          <td colspan="3"><div class=ipt_text style="width:250px;"><b><?=$hslquery[0]->nm_pengguna;?></b></div></td>
        </tr>
        <tr>
          <td>Username</td>
          <td colspan="3"><div class=ipt_text style="width:250px;"><b><?=$hslquery[0]->user_name;?></b></div></td>
        </tr>
        <tr>
          <td>Grup Pengguna</td>
          <td colspan="3"><div class=ipt_text style="width:250px;"><b>
			<?php
			foreach($hslqueryb as $key=>$val){
				if($val->group_id==$hslquery[0]->group_id){
					echo "$val->group_name";
				}
			}
			?>  
		  </b></div></td>
        </tr>
       <tr >
          <td>&nbsp;</td>
          <td colspan="3">
				<input type="hidden" name='user_id' id='user_id' value='<?=$user_id;?>'>
		  <input type="button" onclick="simpan();" value="Hapus" class='tombol_aksi' />
            <input type="button" name="cancel" value="Batal..." onclick="javascript:batal();" class='tombol_aksi' />
		</td>
        </tr>
      </table>
	</form>
</div>
<script type="text/javascript">
	function simpan(){
			var user_id = $("#user_id").val();
			$.ajax({
				type:"POST",
				url:"<?=base_url();?>cmssetting/user/hapus_aksi/",
				data:{	"user_id":user_id	},
				success:function(data){
			gridpaging("end");
			batal();
				},//tutup::success
				dataType:"html"
			});//tutup ajax
	} //tutup::simpan
</script>
