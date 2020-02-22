            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header" style="padding-bottom:10px;margin-bottom:10px;"><?=$dua;?></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6 col-md-6">

						<div class="row">
						<div class="col-lg-12">
						<div class="panel panel-danger">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-12">
										<i class="fa fa-cubes fa-2x fa-fw"></i>  <span style="font-size:24px;">Status</span>
									</div>
								</div>
							</div>
                            <div class="panel-body" style="padding-right:5px;padding-left:5px;">
<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th style="text-align:center; vertical-align:middle">&nbsp;</th>
<th style="text-align:center; vertical-align:middle">L</th>
<th style="text-align:center; vertical-align:middle">P</th>
<th style="text-align:center; vertical-align:middle">J</th>
</tr>
</thead>
<tbody id=list>
<tr>
<td>PNS</td>
<td style="text-align:right;"><?=$j_pns_l;?></td>
<td style="text-align:right;"><?=$j_pns_p;?></td>
<td style="text-align:right;"><?=($j_pns_l+$j_pns_p);?></td>
</tr>
<tr>
<td>CPNS</td>
<td style="text-align:right;"><?=$j_cpns_l;?></td>
<td style="text-align:right;"><?=$j_cpns_p;?></td>
<td style="text-align:right;"><?=($j_cpns_l+$j_cpns_p);?></td>
</tr>
<tr style="background-color:#ccc;">
<td style="text-align:right;"><b>Total :</b></td>
<td style="text-align:right;"><b><?=($j_pns_l+$j_pns_p);?></b></td>
<td style="text-align:right;"><b><?=($j_cpns_l+$j_cpns_p);?></b></td>
<td style="text-align:right;"><b><?=($j_pns_l+$j_pns_p+$j_cpns_l+$j_cpns_p);?></b></td>
</tr>
</tbody>
</table>
		</div>
	</div>
</div>
							</div>
						</div>
						</div>
						</div>

					<div class="row">
					<div class="col-lg-12">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12">
                                    <i class="fa fa-signal fa-2x fa-fw"></i>  <span style="font-size:24px;">Pangkat</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-right:5px;padding-left:5px;">
<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th style="text-align:center; vertical-align:middle">&nbsp;</th>
<th style="text-align:center; vertical-align:middle">L</th>
<th style="text-align:center; vertical-align:middle">P</th>
<th style="text-align:center; vertical-align:middle">J</th>
</tr>
</thead>
<tbody id=list>
<?php
$j_l=0;
$j_p=0;
foreach($golongan as $key=>$val){
$j_l=$j_l+$val->l;
$j_p=$j_p+$val->p;
?>
<tr>
<td><?=$val->nama;?></td>
<td style="text-align:right;"><?=$val->l;?></td>
<td style="text-align:right;"><?=$val->p;?></td>
<td style="text-align:right;"><?=($val->l+$val->p);?></td>
</tr>
<?php
}
?>
<tr style="background-color:#eee;">
<td style="text-align:right;"><b>Total :</b></td>
<td style="text-align:right;"><b><?=$j_l;?></b></td>
<td style="text-align:right;"><b><?=$j_p;?></b></td>
<td style="text-align:right;"><b><?=($j_l+$j_l);?></b></td>
</tr>
</tbody>
</table>
		</div>
	</div>
</div>
                        </div>
                    </div>
					</div>
					</div>

					<div class="row">
					<div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12">
                                    <i class="fa fa-tasks fa-2x fa-fw"></i>  <span style="font-size:24px;">Jenis Jabatan</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-right:5px;padding-left:5px;">
<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th style="text-align:center; vertical-align:middle">&nbsp;</th>
<th style="text-align:center; vertical-align:middle">L</th>
<th style="text-align:center; vertical-align:middle">P</th>
<th style="text-align:center; vertical-align:middle">J</th>
</tr>
</thead>
<tbody id=list>
<?php
$j_l=0;
$j_p=0;
foreach($jabatan as $key=>$val){
$j_l=$j_l+$val->l;
$j_p=$j_p+$val->p;
?>
<tr>
<td><?=$val->nama;?></td>
<td style="text-align:right;"><?=$val->l;?></td>
<td style="text-align:right;"><?=$val->p;?></td>
<td style="text-align:right;"><?=($val->l+$val->p);?></td>
</tr>
<?php
}
?>
<tr style="background-color:#eee;">
<td style="text-align:right;"><b>Total :</b></td>
<td style="text-align:right;"><b><?=$j_l;?></b></td>
<td style="text-align:right;"><b><?=$j_p;?></b></td>
<td style="text-align:right;"><b><?=($j_l+$j_p);?></b></td>
</tr>
</tbody>
</table>
		</div>
	</div>
</div>
                        </div>
                    </div>
					</div>
					</div>


                </div>
                <div class="col-lg-6 col-md-6">

					<div class="row">
					<div class="col-lg-12">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12">
                                    <i class="fa fa-graduation-cap fa-2x fa-fw"></i>  <span style="font-size:24px;">Pendidikan</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-right:5px;padding-left:5px;">
<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th style="text-align:center; vertical-align:middle">&nbsp;</th>
<th style="text-align:center; vertical-align:middle">L</th>
<th style="text-align:center; vertical-align:middle">P</th>
<th style="text-align:center; vertical-align:middle">J</th>
</tr>
</thead>
<tbody id=list>
<?php
$j_l=0;
$j_p=0;
foreach($pendidikan as $key=>$val){
$j_l=$j_l+$val->l;
$j_p=$j_p+$val->p;
?>
<tr>
<td><?=$val->nama;?></td>
<td style="text-align:right;"><?=$val->l;?></td>
<td style="text-align:right;"><?=$val->p;?></td>
<td style="text-align:right;"><?=($val->l+$val->p);?></td>
</tr>
<?php
}
?>
<tr style="background-color:#eee;">
<td style="text-align:right;"><b>Total :</b></td>
<td style="text-align:right;"><b><?=$j_l;?></b></td>
<td style="text-align:right;"><b><?=$j_p;?></b></td>
<td style="text-align:right;"><b><?=($j_l+$j_p);?></b></td>
</tr>
</tbody>
</table>
		</div>
	</div>
</div>
                        </div>
                    </div>
					</div>
					</div>

					<div class="row">
					<div class="col-lg-12">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12">
                                    <i class="fa fa-graduation-cap fa-2x fa-fw"></i>  <span style="font-size:24px;">Status Perkawinan</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-right:5px;padding-left:5px;">
<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th style="text-align:center; vertical-align:middle">&nbsp;</th>
<th style="text-align:center; vertical-align:middle">L</th>
<th style="text-align:center; vertical-align:middle">P</th>
<th style="text-align:center; vertical-align:middle">J</th>
</tr>
</thead>
<tbody id=list>
<?php
$j_l=0;
$j_p=0;
foreach($perkawinan as $key=>$val){
$j_l=$j_l+$val->l;
$j_p=$j_p+$val->p;
?>
<tr>
<td><?=$val->nama;?></td>
<td style="text-align:right;"><?=$val->l;?></td>
<td style="text-align:right;"><?=$val->p;?></td>
<td style="text-align:right;"><?=($val->l+$val->p);?></td>
</tr>
<?php
}
?>
<tr style="background-color:#eee;">
<td style="text-align:right;"><b>Total :</b></td>
<td style="text-align:right;"><b><?=$j_l;?></b></td>
<td style="text-align:right;"><b><?=$j_p;?></b></td>
<td style="text-align:right;"><b><?=($j_l+$j_p);?></b></td>
</tr>
</tbody>
</table>
		</div>
	</div>
</div>
                        </div>
                    </div>
					</div>
					</div>

					<div class="row">
					<div class="col-lg-12">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-lg-12">
                                    <i class="fa fa-graduation-cap fa-2x fa-fw"></i>  <span style="font-size:24px;">Agama</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" style="padding-right:5px;padding-left:5px;">
<div class="row">
	<div class="col-lg-12 col-md-6">
		<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
<th style="text-align:center; vertical-align:middle">&nbsp;</th>
<th style="text-align:center; vertical-align:middle">L</th>
<th style="text-align:center; vertical-align:middle">P</th>
<th style="text-align:center; vertical-align:middle">J</th>
</tr>
</thead>
<tbody id=list>
<?php
$j_l=0;
$j_p=0;
foreach($agama as $key=>$val){
$j_l=$j_l+$val->l;
$j_p=$j_p+$val->p;
?>
<tr>
<td><?=$val->nama;?></td>
<td style="text-align:right;"><?=$val->l;?></td>
<td style="text-align:right;"><?=$val->p;?></td>
<td style="text-align:right;"><?=($val->l+$val->p);?></td>
</tr>
<?php
}
?>
<tr style="background-color:#eee;">
<td style="text-align:right;"><b>Total :</b></td>
<td style="text-align:right;"><b><?=$j_l;?></b></td>
<td style="text-align:right;"><b><?=$j_p;?></b></td>
<td style="text-align:right;"><b><?=($j_l+$j_p);?></b></td>
</tr>
</tbody>
</table>
		</div>
	</div>
</div>
                        </div>
                    </div>
					</div>
					</div>


                </div>
            </div>
            <!-- /.row -->