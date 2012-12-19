<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
	</script>
	<?php exit;?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id") ?>
	<?php echo $this->Form->input($model.'.all_roles', array("id" => "all_roles", "label" => __("View all Roles"), "type" => "checkbox", "style"=>"display:inline;", "onchange"=>"hidden_down_div('all_roles', 'roles_div')")); ?>
	<?php echo $this->Utils->form_separator();?>
	<?php echo $this->Utils->empty_div_row(); ?>
	
	<div id="roles_div">
	
	<?php echo $this->Form->input('all', array("id" => "check_all", "label" => __("All"), "type" => "checkbox", "onchange"=>"click_all()")); ?>
	<?php 
		foreach($roles as $role_id=>$role)
		{
                        $label= $this->Form->checkbox('AuxElm.RoleCanSee.'.$role_id, array("style"=>"display:inline;", "onchange"=>"reload_all()"));
                        $label .= $this->Form->label("AuxElm.RoleCanSee.".$role_id, $role, array("style"=>"display:inline; padding-left:10px;"));
                        $label= array("label"=>$label, "options"=>array("class"=>"all"));
                        
                        echo $this->Utils->div_row(array($label));
                        echo $this->Utils->empty_div_row();
		}
		
		echo $this->Js->buffer("reload_all()");
	?>
	<?php
		//Example of HABTM 
		//echo $this->Form->input("Role")
	?>
	
	<?php echo $this->Utils->form_separator();?>
	<?php echo $this->Utils->empty_div_row();?>
	</div>
	
	<?php $this->Js->buffer("hidden_down_div('all_roles', 'roles_div')") ?>
	
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(__("Update Permissions"), array("type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#full_permissions_inner", "before"=>"show_loading();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Update Permissions"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>