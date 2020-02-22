<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$flash_message = $this->session->userdata('flash_message');
$this->session->unset_userdata('flash_message');
/**
 * $flash_message['error']['msg'];
 * $flash_message['warning']['msg'];
 * $flash_message['success']['msg'];
 */
if (!$flash_message)
    return;
?>
<div class="row">
    <?php
    foreach ($flash_message as $key => $msg):

        switch ($key):
            case ('error'):
                $alert_class = "alert-danger";
                $icon = '<span class="fa fa-exclamation-triangle"></span>';
                break;
            case ('success'):
                $alert_class = "alert-success";
                $icon = '<span class="fa fa-check-square-o"></span>';
                break;
            case ('warning'):
                $alert_class = "alert-warning";
                $icon = '<span class="fa fa-exclamation-triangle"></span>';
                break;
            default :
                $alert_class = "";
                $icon = "";
                break;
        endswitch;
        ?><div class="alert <?php echo $alert_class; ?>">
        <?php echo $icon; ?>
        <?php echo $msg; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <?php
    endforeach;
    ?>
</div>
<?php

/* End of file flash_message.php */
/* Location: ./application/views/elements/flash_message.php */