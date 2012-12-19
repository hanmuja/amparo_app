<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy(true, SHORTCUTS_DIALOG_DIV);?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$parent_div, "cache"=>false));?>
	</script>
	<?php exit;?>
<?php endif;?>

<?php if(!$is_ajax):?>
	<?php
		$buttons= array();
	
		if($edit){
			$button_del= array();
			$options= array();
			$confirm= __('Are you sure you want to delete this %s from the database?', $item);
			$button_del["class"]= "delete link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";;
			$button_del["inner_html"]= $this->Form->postLink(__("Delete"), array("plugin"=>null, "controller"=>$controller, "action"=>"delete", $this->request->data[$model]["id"]), $options, $confirm); 		
			$buttons[]= $button_del;
		}
		if($buttons){
			echo $this->CustomTable->buttons(array($buttons));	
		}
	?>
<?php else:?>
	<?php echo $this->Js->buffer('$("#submit_shortcut").bind("click", function (event) {get_ckeditor_values(["ShortcutMessage"]);return false;});');?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input($model.'.name', array("label"=>__("Caption")));?>
	<?php echo $this->Form->input($model.'.message', array("label"=>__("Message")));?>
	<?php //if(!$edit):?>
		<?php echo $this->Utils->form_section(__("Editors"));?>
		<?php echo $this->Form->input('all', array("id" => "check_all2", "label" => __("All"), "type" => "checkbox", "onchange"=>"click_all2('check_all2', 'all2')")); ?>
		<?php echo $this->Form->input("AuxElm.Modules", array("label"=>__("Select the editors where you want this shortcut to appear:"), "type"=>"select", "multiple"=>"checkbox", "options"=>ckeditors(), "default"=>$ckeditor_name, "class" => 'checkbox all2'))?>
		
		<?php echo $this->Js->buffer("$(\".all2 :checkbox\").attr(\"onchange\", \"reload_all2('check_all2', 'all2')\")"); ?>
		<?php echo $this->Js->buffer("reload_all2('check_all2', 'all2')"); ?>
		
	<?php //endif;?>
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(SAVE_LABEL, array("id"=>"submit_shortcut", "type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".SHORTCUTS_DIALOG_DIV, "before"=>"show_loading();lock_dialog('".SHORTCUTS_DIALOG_DIV."');", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>SAVE_LABEL, "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>
	
	<?php echo $this->element("ckeditor_setup", array("editor_id"=>"ShortcutMessage"))?>