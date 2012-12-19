<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
	</script>
	<?php exit;?>
<?php endif;?>
<?php if(!$is_ajax):?>
	<?php
		$buttons= array();
	
		$button= array();
		$button["class"]= "list link crud_button sc_crud_top ".CRUD_THEME." sc_button_gray";
		$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"index");
		$button["label"]= __("Back to List");
		
		$buttons[]= $button;
		
		echo $this->CustomTable->buttons(array($buttons));
	?>
<?php endif;?>

<?php echo $this->Form->create($model, array('type' => 'file'));?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input($model.'.nombre', array('size' => '50'));?>
	<?php echo $this->Form->input($model.'.primer_apellido', array('size' => '50'));?>
	<?php echo $this->Form->input($model.'.segundo_apellido', array('size' => '50'));?>
	
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(__("Save"), array("id"=>"submit_post", "type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Save"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>
	