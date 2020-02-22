<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


if (!isset($detail)) {
    printf('<h4>%s</h4>', lang('Empty record'));
    return;
}

?>
<div>
    <table class="table table-bordered table-condensed table-striped">
        <thead>
        </thead>
        <tbody>
            <tr>
                <td width="100"><?php echo lang('Year');?></td>
                <td><?php echo $detail->tahun;?></td>
            </tr>
            <tr>
                <td><?php echo lang('Grade');?></td>
                <td><?php echo $detail->kode_golongan;?> - <?php echo $detail->nama_pangkat;?></td>
            </tr>
            <tr>
                <td><?php echo lang('Length of Service');?></td>
                <td><?php echo $detail->mk_peringkat;?> <?php echo lang('year');?></td>
            </tr>
            
            <tr>
                <td><?php echo lang('Base Salary');?></td>
                <td><?php echo lang('#CURRENCY_SYMBOL') . " " . number_format($detail->gaji_pokok, 2, ",", ".");?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    
                    <?php
                    if($detail->locked):
                        ?><a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
                    <span class="fa fa-lock fa-2x fa-border fa-fw text-danger"></span>
                            <?php
                    endif;
                    if(!$detail->locked):
                        ?>
                    <form class="form-inline" method="post">
                        <?php
                        $ymd = date('ymd');
                        ?>
                        <input type="hidden" name="<?php echo md5('del_id'.$ymd);?>" value="<?php echo $detail->id_gaji_pokok;?>">
                        <input type="hidden" name="<?php echo md5('del_id_hash'.$ymd);?>" value="<?php echo md5($detail->id_gaji_pokok.$ymd);?>">
  <div class="form-group">
      <div class="form-group">
    <a class="btn" href="<?php echo $back_url; ?>"><span class="fa fa-arrow-left"></span> <?php echo lang('cancel'); ?></a>
  </div>
      <button type="submit" name="<?php echo md5('do_delete'.$ymd);?>" class="btn btn-danger"><span class="fa fa-trash-o"></span> <?php echo lang('Confirm Delete');?></button>
</form>
                            <?php
                    endif;
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<?php debug($detail);?>
