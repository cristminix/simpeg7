<script>
	$( document ).ready(function() {
		$(".tile").height($("#tile0").parent().width());
		$(".carousel").height($("#tile0").parent().width());
		$(".item").height($("#tile0").parent().width());
		$(window).resize(function() {
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function() {
			$(this).trigger('resizeEnd');
		}, 10);
		});
		
		$(window).bind('resizeEnd', function() {
			$(".tile").height($("#tile0").parent().width());
			$(".carousel").height($("#tile0").parent().width());
			$(".item").height($("#tile0").parent().width());
		});

	});
</script>
<div class="row">
    <!-- <div class="col-lg-12">
        <h3 class="page-header">Dashboard Notifikasi Kepegawaian (alerting system)</h3>
    </div>
	-->
    <!-- /.col-lg-12 -->
</div>
<?php echo modules::run('dashboard/getPanel');?>
<?php
$c=0;
$n=4;
?> <div class="row"><?php
foreach ($dash_list as $key=> $val) {
    $jj = json_decode($val->meta_value);
    $explode_icon=explode(":",$jj->icon_menu,2);
    $paneltheme=$explode_icon[0];
    $panelicon=$explode_icon[1];
    if($c%$n===0 && $c!==0) {
        echo "</div><div class='row'>";
    }
    //print_r($explode_icon);
    ?>
   
        <div class="col-lg-3 col-md-6">
            <div class="panel <?php echo $paneltheme;?>">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa <?php echo $panelicon;?> fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">26</div>
                            <div><?php echo $val->nama_item;?></div>
                        </div>
                    </div>
                </div>
                <a href="<?php echo site_url()."admin/".@$jj->path_menu;?>">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
   <?php
    
    $c++;
}
?> </div>
