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
		if($edit)
		{
			$button_del= array();
			$options= array();
			$confirm= __('Are you sure you want to delete this %s from the database?', $item);
			$button_del["class"]= "delete link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";;
			$button_del["inner_html"]= $this->Form->postLink(__("Delete"), array("plugin"=>null, "controller"=>$controller, "action"=>"delete", $this->request->data[$model]["id"]), $options, $confirm); 		
			$buttons[]= $button_del;
		}
		
		echo $this->CustomTable->buttons(array($buttons));
	?>
<?php else:?>
	<?php echo $this->Js->buffer('$("#submit_role").bind("click", function (event) {get_ckeditor_values(["RoleDescription"]);return false;});');?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input($model.'.name', array("label"=>$item, "class"=>"full_input"));?>
	<?php echo $this->Form->input($model.'.image_domain', array("label"=>__("Image Domain ( http://domain.com )"), 'size' => '50'));?>
	<?php echo $this->Form->input($model.'.path_domain', array("label"=>__("Path Domain ( /files/folder )"), 'size' => '50', 'div' => array('class' => 'input text two_column')));?>
	<?php
	
	$buttons= array();
		
	$button= array();
	$dialog_options= array();
	$dialog_options["title"]= "'".__("Pick a Folder")."'";
	$dialog_options["width"]= 665;
	$dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
	$button["dialog_options"]= $dialog_options;
	$button["class"]= "list link crud_button sc_crud_top ".CRUD_THEME." sc_button_blue";
	$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"path_domain");
	$button["label"]= __("Pick a Folder");
	$buttons[]= $button;	
	
	echo $this->CustomTable->buttons(array($buttons), array("class"=>"two_column"));
	
	?>
	<?php echo $this->Form->input("Language", array("label"=>__("Languages"), "empty"=>false, "options"=>$languages, 'multiple' => 'checkbox'))?>
	<?php echo $this->Form->input($model.'.description', array("label"=>__("Description")));?>
	<?php 
		$label= array("label"=>"", "options"=>array("class"=>"input"));
		$value= $this->element("Shortcuts/shortcuts", array("ckeditor_name"=>"ROLE_DESCRIPTION", "ckeditor_instance"=>"RoleDescription", "parent_div"=>"role_description_shortcuts"));
		$value= array("label"=>$value);	
		echo $this->Utils->div_row(array($label, $value));
	?>
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(__("Save"), array("id"=>"submit_role", "type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Save"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>
	<?php echo $this->element("ckeditor_setup", array("editor_id"=>"RoleDescription"))?>
	
<script>
	
	function pickFolder()
	{
		
	}
	
</script>
