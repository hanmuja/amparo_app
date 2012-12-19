<?php 
	$default_shortcuts= array();
	$button= array();
	$options= array();
	$options["onclick"]= 'add_shortcut_timestamp("'.$ckeditor_instance.'", "'.$this->Html->url(array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"timestamp")).'");';
	$button["allowed"]= true;
	$button["class"]= "link crud_button sc_crud_top ".CRUD_THEME." sc_button_gray sc_button_shortcut_default";
	$button["html_options"]= $options;
	$button["label"]= __("Timestamp");
	$default_shortcuts[]= $button;
	
	//If the element is called in the view of shortcuts/my_shortcuts the shortcuts are sent and also this flag
	if(!isset($dont_perform_request)){
		$shortcuts= $this->requestAction(array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"my_shortcuts", $ckeditor_name));	
	}
	
	$my_shortcuts= array();
	if($shortcuts){
        $my_shortcuts['html_options'] = array("id"=>'my_shortcuts_buttons_'.$ckeditor_instance, "class"=>"shortcuts_container");
		foreach($shortcuts as $sc){
			//This is not gonna be passed to the button, it will be saved on an attribute called "edit"
			$dialog_options= array();
			$dialog_options["title"]= "'".__("Edit Shortcut")."'";
			$dialog_options["width"]= 965;
			$dialog_options["modal"]= true;
			$dialog_id= SHORTCUTS_DIALOG_DIV;
			$url= array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"edit", $sc["Shortcut"]["id"], $ckeditor_name, $parent_div, $ckeditor_instance);
			$dialog_launch= $this->Dialog->create($dialog_options, SHORTCUTS_DIALOG_DIV);
			$dialog_load= $this->Dialog->load($url, SHORTCUTS_DIALOG_DIV);
			
			$button= array();
			$options= array();
			$options["edit"]= $dialog_launch.$dialog_load;
			$options["delete_url"]= $this->Html->url(array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"delete", $sc["Shortcut"]["id"], $ckeditor_name, $ckeditor_instance, $parent_div));
			$options["editor_instance"]= $ckeditor_instance;
			$options["onclick"]= "add_shortcut_text_ajax('".$sc["Shortcut"]["id"]."', '".$ckeditor_instance."', '".$this->Html->url(array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"get_text", $sc["Shortcut"]["id"]))."');";
			$options["id"]= "shortcut_".$sc["Shortcut"]["id"]."_".$ckeditor_instance;
			$button["allowed"]= true;
			$button["class"]= "link crud_button sc_crud_top ".CRUD_THEME." sc_button_gray sc_button_shortcut";
			$button["html_options"]= $options;
			$button["label"]= $sc["Shortcut"]["name"];
			
			$my_shortcuts[]= $button;
			echo $this->Js->buffer("initialize_shortcut_menu('shortcut_".$sc["Shortcut"]["id"]."_".$ckeditor_instance."', '".$parent_div."');");
		}
	}
	
	$actions= array();
	$button= array();
	$dialog_options= array();
	$dialog_options["title"]= "'".__("Add Shortcut")."'";
	$dialog_options["width"]= 965;
	$dialog_options["modal"]= true;
	$dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
	$options= array();
	$options["id"]= "add_".$ckeditor_instance;
	$button["class"]= "link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
	$button["url"]= array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"add", $ckeditor_name, $parent_div, $ckeditor_instance);
	$button["allowed"]= true;
	$button["dialog_options"]= $dialog_options;
	$button["label"]= __("+");	
	$button["html_options"]= $options;
	
	//Enviaré los botones agrupados
	$actions[]= $button;
	
	$button= array();
	$options= array();
	$options["id"]= "save_order_".$ckeditor_instance;
	$options["onclick"]= "save_shortcuts_order('".$ckeditor_instance."', '".$this->Html->url(array("plugin"=>null, "controller"=>"Shortcuts", "action"=>"save_order", $ckeditor_name))."');";
	$button["class"]= "link crud_button sc_crud_top ".CRUD_THEME." sc_button_green save_order";
	$button["allowed"]= true;
	$button["label"]= __("Save Order");	
	$button["html_options"]= $options;
	
	//Enviaré los botones agrupados
	$actions[]= $button;
	
	///////////////////////////////////////////////
	$buttons= array();
	$buttons[]= $default_shortcuts;
	if($my_shortcuts){
		$buttons[]= $my_shortcuts;
	}
	$buttons[]= $actions;
?>
<?php if(!isset($dont_perform_request)):?>
	<div id="<?php echo $parent_div?>">
<?php endif;?>
	<?php echo $this->CustomTable->buttons($buttons);?>
<?php if(!isset($dont_perform_request)):?>
	</div>
<?php endif;?>
<?php if(count($shortcuts)>1):?>
	<?php echo $this->Js->buffer("setup_sortable('".$ckeditor_instance."', '".$this->Html->url("/img/misc/sortable_x.png", true)."');"); ?>
<?php endif;?>