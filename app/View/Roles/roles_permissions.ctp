<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
	</script>
	<?php exit;?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input('all', array("id" => "check_all", "label" => __("All"), "type" => "checkbox", "style"=>"display:inline;", "onchange"=>"click_all()")); ?>
	<?php echo $this->Utils->empty_div_row();?>
	<?php 
		foreach($roles as $role_id=>$role)
		{
                        $label= $this->Form->checkbox('AuxElm.InitialRole.'.$role_id, array("style"=>"display:inline;", "onchange"=>"reload_all()"));
                        $label .= $this->Form->label("AuxElm.InitialRole.".$role_id, $role, array("style"=>"display:inline; padding-left:10px;"));
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
	<?php if($is_ajax):?>
		
<?php $this->Js->buffer('
	$("#submit_roles").click(function(e){
		var x = $(\'input[name="data[AuxElm][process]"]:checked\').val();
		if(x != 1){
			if(!confirm("You are about to overwrite the Visible Roles Permissions for All users in this Role. Do you want to continue?")){
				e.stopImmediatePropagation();
				return false;
			}
		}
	});
')?>
		
		<?php echo $this->Js->submit(__("Update Permissions"), array("id" => "submit_roles", "type"=>"POST", "div" => array("class" => "submit two_column"), "class"=>"sc_button sc_button_green", "update"=>"#full_permissions_inner", "before"=>"show_loading();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<div class="two_column" style="float: right;">
			<div class="two_column">
			    <?php echo $this->Form->input("AuxElm.process", array('type' => 'radio', 'options' => array('1'=>__('Set Initial Locations'), '2'=>__('Overwrite Affected Users'), '3'=>__('Both')), "legend"=>false, 'value'=>1, "div"=>array("class"=>"input two_column radio check_inline")))?>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Update Permissions"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>