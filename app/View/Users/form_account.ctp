<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
	</script>
	<?php exit;?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input($model.".first_name", array("label"=>__("First Name"), "class"=>"set_size_input"))?>
	<?php echo $this->Form->input($model.".last_name", array("label"=>__("Last Name"), "class"=>"set_size_input"))?>
	<?php echo $this->Form->input($model.".email", array("label"=>__("Email"), "class"=>"set_size_input"))?>
	<?php echo $this->Form->input($model.".phone", array("label"=>__("Phone"), "class"=>"set_size_input"))?>
	<?php echo $this->Form->input($model.".email_list", array("label"=>__("Email List"), "after"=>"<br><span>".__("Comma separated email addresses")."</span>", "class"=>"set_size_input"))?>
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(SAVE_LABEL, array("type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>SAVE_LABEL." ".$item, "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>