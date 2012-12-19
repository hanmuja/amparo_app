<?php if(isset($close)):?>
	<script>
		<?php if(isset($permissions)): ?>
			<?php //echo $this->Dialog->destroy();?>
			<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
			<?php echo $this->Dialog->set_option("width", 600);?>
			<?php echo $this->Dialog->set_option("title", "'".__("Edit User Permissions")."'");?>
			<?php echo $this->Dialog->load($url_load);?>
		<?php else: ?>
			<?php echo $this->Dialog->destroy();?>
			<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
		<?php endif; ?>
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
		if($edit)
		{
			$button_del= array();
			$options= array();
			$confirm= __('Are you sure you want to retire this %s?', $item);
			$button_del["class"]= "delete link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";
			$button_del["inner_html"]= $this->Form->postLink(__("Retire"), array("plugin"=>null, "controller"=>$controller, "action"=>"retire", $this->request->data[$model]["id"]), $options, $confirm); 		
			$buttons[]= $button_del;
		}
		
		echo $this->CustomTable->buttons(array($buttons));
	?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input($model.".first_name", array("label"=>__("First Name"), "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.".last_name", array("label"=>__("Last Name"), "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.".username", array("label"=>__("Username"), "class"=>"full_input"))?>
    <?php echo $this->Form->input($model.".email", array("label"=>__("Email"), "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.".employee_number", array("label"=>__("Employee Number"), "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.".last_four", array("label"=>__("Last 4 Social"), "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.".phone", array("label"=>__("Phone"), "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.".email_list", array("label"=>__("Additional Emails"), "after"=>"<br><span>".__("Comma separated email addresses")."</span>", "class"=>"full_input"))?>
	<?php echo $this->Form->input($model.'.role_id', array("label"=>__("Role"), "class"=>"full_input", "empty"=>EMPTY_OPTION));?>
	<?php echo $this->Form->input($model.".can_see_confidential", array("type"=>'checkbox',"label"=>__('View Confidential Information'))); ?>
	
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(SAVE_LABEL, array("type"=>"POST", "div" => array('class' => 'submit two_column'), "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php if($this->Utils->has_permission(array("plugin"=>null, "controller"=>"Users", "action"=>"permissions"))): ?>
	      	<?php echo $this->Js->buffer('$("#submit_permissions").click(function(){ $("#ExtraOrder").val(1) });', true); ?>
	      	<?php echo $this->Form->input('Extra.order', array('type' => 'hidden', 'default' => 0)) ?>
	      	<?php echo $this->Js->submit(__("Save & Edit Permissions"), array("id"=>"submit_permissions", "type"=>"POST", "div" => array('class' => 'submit two_column'), "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
        <?php endif; ?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>SAVE_LABEL." ".$item, "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>