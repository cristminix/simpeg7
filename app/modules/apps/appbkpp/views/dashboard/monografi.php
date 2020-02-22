<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Dashboard Monografi Kepegawaian</h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-8 col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-12">
                        <i class="fa fa-cubes fa-2x fa-fw"></i>  <span style="font-size:24px;">Unit Kerja - Status</span>
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
                                        <th style="width:55px;text-align:center; vertical-align:middle">No.</th>
                                        <th style="width:350px;text-align:center; vertical-align:middle">UNIT KERJA</b></th>
                                        <th style="width:80px;text-align:center; vertical-align:middle">KONTRAK</th>
                                        <th style="width:80px;text-align:center; vertical-align:middle">CAPEG</th>
                                        <th style="width:80px;text-align:center; vertical-align:middle">TETAP</th>
                                        <th style="width:80px;text-align:center; vertical-align:middle">KHUSUS</th>
                                        <th style="width:80px;text-align:center; vertical-align:middle">JUMLAH</th>
                                    </tr>
                                </thead>
                                <tbody id=list>
                                    <?php
                                    $no = 0;
                                    $j_kontrak = 0;
                                    $j_capeg = 0;
                                    $j_tetap = 0;
                                    $j_khusus = 0;
                                    foreach ($unor AS $key => $val) {
                                        $no++;
                                        $j_kontrak = $j_kontrak + $val->j_kontrak;
                                        $j_capeg = $j_capeg + $val->j_capeg;
                                        $j_tetap = $j_tetap + $val->j_tetap;
                                        $j_khusus = $j_khusus + $val->j_khusus;
                                        $j_all = $j_tetap + $val->j_all;
                                        ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= isset($val->nama_unor)?$val->nama_unor:'-'; ?></td>
                                            <td style="text-align:right;"><?= $val->j_kontrak; ?></td>
                                            <td style="text-align:right;"><?= $val->j_capeg; ?></td>
                                            <td style="text-align:right;"><?= $val->j_tetap; ?></td>
                                            <td style="text-align:right;"><?= $val->j_khusus; ?></td>
                                            <td style="text-align:right;"><?= $val->j_all; ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr style="background-color:#eee;">
                                        <td colspan=2 style="text-align:right;"><b>Total :</b></td>
                                        <td style="text-align:right;"><b><?= $j_kontrak; ?></b></td>
                                        <td style="text-align:right;"><b><?= $j_capeg; ?></b></td>
                                        <td style="text-align:right;"><b><?= $j_tetap; ?></b></td>
                                        <td style="text-align:right;"><b><?= $j_khusus; ?></b></td>
                                        <td style="text-align:right;"><b><?= ($j_kontrak + $j_capeg + $j_tetap); ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!--- +++++++++++++++++++++++++++++++++++++++++  -->
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
                                            $j_l = 0;
                                            $j_p = 0;
                                            foreach ($pendidikan as $key => $val) {
                                                $j_l = $j_l + $val->l;
                                                $j_p = $j_p + $val->p;
                                                ?>
                                                <tr>
                                                    <td><?= $val->nama; ?></td>
                                                    <td style="text-align:right;"><?= $val->l; ?></td>
                                                    <td style="text-align:right;"><?= $val->p; ?></td>
                                                    <td style="text-align:right;"><?= ($val->l + $val->p); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr style="background-color:#eee;">
                                                <td style="text-align:right;"><b>Total :</b></td>
                                                <td style="text-align:right;"><b><?= $j_l; ?></b></td>
                                                <td style="text-align:right;"><b><?= $j_p; ?></b></td>
                                                <td style="text-align:right;"><b><?= ($j_l + $j_p); ?></b></td>
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



        <!--  ----------------------------------------------------------------------------- -->
        <!-- --------------------------------------------------------------------------------- add  ----------------------------------------------------------------------------------------------------- -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="fa fa-tasks fa-2x fa-fw"></i>  <span style="font-size:24px;">Jenis Kelamin</span>
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
                                                <th style="text-align:center; vertical-align:middle"></th>

                                            </tr>
                                        </thead>
                                        <tbody id=list>
                                            <?php
                                            $j_l = 0;
                                            $j_p = 0;
                                            foreach ($gender as $key => $val) {
                                                $j_l = $j_l + $val->l;
                                                $j_p = $j_p + $val->p;
                                                ?>
                                                <tr>
                                                    <td><?= $val->nama; ?></td> 
                                                    <td style="text-align:right;"><?= $val->l; ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr style="background-color:#eee;">
                                                <td style="text-align:right;"><b>Total :</b></td>
                                                <td style="text-align:right;"><b><?= $j_l; ?></b></td>

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
        <!--  ----------------------------------------------------------------------------------------------------------------------------------------------------  -->

    </div>




    <div class="col-lg-4 col-md-6">

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
                                            $j_l = 0;
                                            $j_p = 0;
                                            foreach ($golongan as $key => $val) {
                                                $j_l = $j_l + $val->l;
                                                $j_p = $j_p + $val->p;
                                                ?>
                                                <tr>
                                                    <td><?= $val->nama; ?></td>
                                                    <td style="text-align:right;"><?= $val->l; ?></td>
                                                    <td style="text-align:right;"><?= $val->p; ?></td>
                                                    <td style="text-align:right;"><?= ($val->l + $val->p); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr style="background-color:#eee;">
                                                <td style="text-align:right;"><b>Total :</b></td>
                                                <td style="text-align:right;"><b><?= $j_l; ?></b></td>
                                                <td style="text-align:right;"><b><?= $j_p; ?></b></td>
                                                <td style="text-align:right;"><b><?= ($j_l + $j_p); ?></b></td>
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
                <div class="panel panel-red">
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
                                            $j_l = 0;
                                            $j_p = 0;
                                            foreach ($jabatan as $key => $val) {
                                                $j_l = $j_l + $val->l;
                                                $j_p = $j_p + $val->p;
                                                ?>
                                                <tr>
                                                    <td><?= $val->nama; ?></td>
                                                    <td style="text-align:right;"><?= $val->l; ?></td>
                                                    <td style="text-align:right;"><?= $val->p; ?></td>
                                                    <td style="text-align:right;"><?= ($val->l + $val->p); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr style="background-color:#eee;">
                                                <td style="text-align:right;"><b>Total :</b></td>
                                                <td style="text-align:right;"><b><?= $j_l; ?></b></td>
                                                <td style="text-align:right;"><b><?= $j_p; ?></b></td>
                                                <td style="text-align:right;"><b><?= ($j_l + $j_p); ?></b></td>
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



        <!-- --------------------------------------------------------------------------------- add  ----------------------------------------------------------------------------------------------------- -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-12">
                                <i class="fa fa-tasks fa-2x fa-fw"></i>  <span style="font-size:24px;">Status Perkawinan</span>
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
                                            $j_l = 0;
                                            $j_p = 0;
                                            foreach ($kawin as $key => $val) {
                                                $j_l = $j_l + $val->l;
                                                $j_p = $j_p + $val->p;
                                                ?>
                                                <tr>
                                                    <td><?= $val->nama; ?></td> 

                                                    <td style="text-align:right;"><?= $val->l; ?></td>
                                                    <td style="text-align:right;"><?= $val->p; ?></td>
                                                    <td style="text-align:right;"><?= ($val->l + $val->p); ?></td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <tr style="background-color:#eee;">
                                                <td style="text-align:right;"><b>Total :</b></td>
                                                <td style="text-align:right;"><b><?= $j_l; ?></b></td>
                                                <td style="text-align:right;"><b><?= $j_p; ?></b></td>
                                                <td style="text-align:right;"><b><?= ($j_l + $j_p); ?></b></td>
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
        <!--  ----------------------------------------------------------------------------------------------------------------------------------------------------  -->






    </div>



</div>
<!-- /.row -->
