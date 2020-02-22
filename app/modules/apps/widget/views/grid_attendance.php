<h3 class='text-center'><?php echo $title;?></h3>
<div class="row">	
	<div class="col-md-12">		
		<div style="float:left; padding-top:3px;padding-left:5px;">Periode:</div>
		<input id="iptTanggal" name="iptTanggal" onchange="gridpaging(1);" value="" class="form-control" type="text"  style="float:left; width:100px; padding:3px; background-color:#FFFF99; height:26px;">
		  <div style="float:left; padding-top:3px;padding-left:5px;">s.d.</div>
		<input id="iptTanggal2" name="iptTanggal2" onchange="gridpaging(1);" value="" class="form-control" type="text"  style="float:left; width:100px; padding:3px; background-color:#FFFF99; height:26px;">
	</div>
	<div class="col-md-12">	
	<br>
	<button class="btn btn-info" onClick="cetak_excel()"><i class="fa fa-file-excel-o"></i> Export</button>
	</div>
</div>
<hr>
<script type="text/javascript">
var nowTemp = new Date();
var now = nowTemp.toISOString().substring(0, 10);
  $(function() {
	$('#iptTanggal').datetimepicker({
		format: 'YYYY-MM-DD',
		pickTime: false
	}).val(now);
	$('#iptTanggal2').datetimepicker({
		format: 'YYYY-MM-DD',
		pickTime: false
	}).val(now);
  });
  
</script>

</div>


<div class="col-lg-12" id="form-wrapper"></div>
	<!-- /.col-lg-6 -->
</div>
<!-- /.row -->
<div class="row" id="main-wrapper">
	<div class="col-lg-6" style="margin-bottom:5px;">
	<div style="float:left;">
	<select class="form-control input-sm" id="item_length" style="width:70px;" onchange="gridpaging(1)">
	<option value="10" <?=($limit==10)?"selected":"";?>>10</option>
	<option value="25" <?=($limit==25)?"selected":"";?>>25</option>
	<option value="50" <?=($limit==50)?"selected":"";?>>50</option>
	<option value="100" <?=($limit==100)?"selected":"";?>>100</option>
	</select>
	</div>
	<div style="float:left;padding-left:5px;margin-top:6px;mrgin-right:20px;">item per halaman</div>
		</div>
		<!-- /.col-lg-6 -->
		<div class="col-lg-6" style="margin-bottom:5px;">
								<div class="input-group" style="width:240px; float:right; padding:0px 2px 0px 2px;">
									<input id="a_caripaging" onchange="gridpaging(1)" type="text" class="form-control" placeholder="Masukkan kata kunci..." value="">
									<span class="input-group-btn">
									<button class="btn btn-default" type="button">
										<i class="fa fa-search"></i>
									</button>
								</span>
								</div>
	<div style="float:right; margin:7px 0px 0px 0px;">Cari:</div>
	
	<?php 
	$colsEx="";
	foreach($columns as $index=>$val){
		if($val!="no"){
			$colsEx[]=$val.":".$index;
		}
	}	
	?>
	
	<input type="hidden" name="cols" id="cols" value="<?php echo implode(",",$colsEx); ?>"></input>
	</div>
	<div class="col-md-12">
		<div class="table-responsive" data-ref="<?php echo $ref;?>" id="mainTable">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<?php foreach($columns as $index=>$val){
							echo '<th id="'.$val.'">'.strtoupper($index).'</th>';
						} ?>
					</tr>
				</thead>
				<tbody id="grid-data">
				
				</tbody>
			</table>
		</div>
		<div id="paging" >
		</div>
	</div>
</div>


<div id="paging_print" style="display:none;">
</div>