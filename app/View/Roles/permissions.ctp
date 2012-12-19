<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		display_bouncebox_message("<?php echo $manual_flash_type?>", "<?php echo $manual_flash?>", 100, 4000);
	</script>
	<?php exit;?>
<?php endif;?>
<?php if(!$is_ajax):?>
    <?php echo $this->Html->script("acl")?>
<?php endif;?>

<div class="acl_box">
	<?php
 		$buttons= array();
		
		$confirmMessage = __('Are you sure you want to authorize all permissions to %s.', $one[$model]['name']);
		$options= array();
		$options['before'] = 'if(!confirm("'.$confirmMessage.'"))return false;show_loading();lock_dialog();';
		$options["success"]= "hide_loading();";
		$options["error"]= "handle_error(errorThrown);";
		$options["update"]= "#".$this->Dialog->id;
		$options["escape"]= false;
		
		$button= array();
		$button["permission_url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"authorizeAllRolePermissions");
		$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
		$button["inner_html"]= $this->Js->link(__("Authorize All"), array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"authorizeAllRolePermissions", $one[$model]["id"]), $options);
		$buttons[]= $button;
		
		$confirmMessage = __('Are you sure you want to block all permissions to %s.', $one[$model]['name']);
		$options['before'] = 'if(!confirm("'.$confirmMessage.'"))return false;show_loading();lock_dialog();';
		$button= array();
		$button["permission_url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"blockAllRolePermissions");
		$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";
		$button["inner_html"]= $this->Js->link(__("Block All"), array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"blockAllRolePermissions", $one[$model]["id"]), $options);
		$buttons[]= $button;
		
		$confirmMessage = __('Are you sure you want to remove the individual permissions for this role\'s users.');
		$options['before'] = 'if(!confirm("'.$confirmMessage.'"))return false;show_loading();lock_dialog();';
		$button= array();
		$button["permission_url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"resetRoleUsersPermissions");
		$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_burgundy";
		$button["inner_html"]= $this->Js->link(__("Remove Individual Permissions"), array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"resetRoleUsersPermissions", $one[$model]["id"]), $options);
		$buttons[]= $button;
		
		echo $this->CustomTable->buttons(array($buttons));
 	?>
 	<div id='fp_menu'>
 		<?php if ($permissionsMenu):?>
 			<?php foreach ($permissionsMenu as $section): ?>
 				<?php echo $this->element('FriendlyPermissions/menu_section', array('section'=>$section));?>
 			<?php endforeach;?>
 		<?php endif;?>
 	</div>
</div>