<?php echo $this->element("dialog_close")?>

        <?php echo $this->Html->div('confirm_delete_pending', __("Are you sure to delete this User?")); ?>
        
        <?php echo $this->Form->create($model);?>
        <?php echo $this->Form->input($model.".id", array('type' => 'hidden'));?>
	<?php echo $this->Form->input($model.".send_notification", array('label' => __('Send Notification'), 'type' => 'checkbox'));?>
	
	<?php echo $this->Utils->form_separator();?>
        <?php echo $this->Js->submit(__("Delete"), array("id"=>"submit_delete_pending", "type"=>"POST", "class"=>"sc_button sc_button_red", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>

	<?php echo $this->Form->end();?>