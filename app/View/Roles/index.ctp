<?php if(!$is_ajax):?>
	<?php echo $this->Html->css('friendly_permissions')?>
    <?php echo $this->Dialog->headers()?>
    <?php echo $this->Html->script("roles")?>
    <?php echo $this->Html->script("ckeditor/ckeditor")?>
	<?php echo $this->Html->script("ckfinder/ckfinder")?>
	<?php echo $this->Html->script("locations_checkbox")?>
	<?php echo $this->Html->script("ui/minified/jquery.ui.tabs.min");?>
	<?php echo $this->Html->script("jstree/jquery.cookie");?>
    <?php echo $this->Html->script("jstree/jquery.hotkeys");?>
    <?php echo $this->Html->script("jstree/jquery.jstree");?>
    <?php echo $this->Html->script("acl")?>
    <?php echo $this->Html->script("friendly_permissions")?>
    <div id="<?php echo $controller?>">
<?php endif;?>

<?php 
    if ($paginated || !$is_ajax) {
		$buttons= array();
		
		$table_actions= array();
		
		$dialog_options= array();
		$dialog_options["title"]= "'".__("Add")." ".$item."'";
		$dialog_options["width"]= 965;
		
		$button= array();
		$options= array();
		$options["id"]= "button_add";
		$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button["dialog_options"]= $dialog_options;
		$button["html_options"]= $options;
		$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"add");
		$button["label"]= $this->Html->image('crud/small/plus.png', array('align'=>'absmiddle'));
		$table_actions[]= $button;
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>__("ID"), "sortable"=> true, "filterable"=> true, "field"=>$model.".id");
		$ths[]= array("label"=>$item, "sortable"=> true, "filterable"=> true, "field"=>$model.".name");
		$ths[]= array("label"=>__("Image Domain"), "sortable"=> true, "filterable"=> true, "field"=>$model.".image_domain");
		$ths[]= array("label"=>__("Description"), "sortable"=> true, "filterable"=> true, "field"=>$model.".description");
		$ths[]= array("label"=>__("# Users"));
    }
		
	$trs= array();
	foreach ($all as $one) {
		$tr= array();
		
		if ($one[$model]["editable"]) {
			$dialog_options= array();
			$dialog_options["title"]= "'".__("Edit %s", $item)."'";
			$dialog_options["width"]= 965;
			
			$options= array();
			$button_up= array();
			$button_up["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
			$button_up["dialog_options"]= $dialog_options;
			$button_up["html_options"]= $options;
			$button_up["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"edit", $one[$model]["id"]);
			$button_up["label"]= $this->Html->image('crud/edit.gif', array('align'=>'absmiddle'));
			
			$options= array();
			$options["escape"]= false;
			$confirm= __('Are you sure you want to delete this %s from the database?', $item);
			$button_del= array();
			$button_del["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"delete");
			$button_del["class"]= "delete link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";;
			$button_del["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>$controller, "action"=>"delete", $one[$model]["id"]), $options, $confirm);
			
			$dialog_options= array();
			$dialog_options["title"]= "'".__('Permissions for Role: %s', $one[$model]['name'])."'";
			$dialog_options["width"]= 600;
			$button_per= array();
			$button_per["class"]= "permissions link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
			$button_per["dialog_options"]= $dialog_options;
			$button_per["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"full_permissions", $one[$model]["id"]);
			$button_per["label"]= $this->Html->image('crud/lock_pencil.png', array('align'=>'absmiddle'));
	        
			$actions_buttons= $this->CustomTable->button_group(array($button_up, $button_del, $button_per));
			
			$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"100px"));
		}
		else		
		$tr[]= " ";
		
		$tr[]= array($one[$model]["id"], array("width"=>"25px"));
		$tr[]= array($one[$model]["name"], array("width"=>"200px"));
		$tr[]= array($one[$model]["image_domain"], array("width"=>"200px"));
		$tr[]= strip_tags($one[$model]["description"]);
		$tr[]= array(count($one["User"]), array("width"=>"50px"));
		
		$trs[]= $tr;
	}
    
    if($paginated || !$is_ajax)
    {
		echo $this->CustomTable->table
		(
			$controller, 
			array
			(
				"ths"=>$ths,
				"trs"=>$trs,
				"buttons"=>$buttons,
				"table_actions"=> $table_actions
			),
			array
			(
				"parent_div"=>$controller,
				"class_table"=>"promana-head-button",
				"message_empty"=>__("No item found.", true),
                "use_ajax"=>true,
                "clear_filters"=>true
                //"images_paginator"=>images_paginator()
			)
		);
    }
    else
    {
        echo $this->CustomTable->table_filter
		(
			$controller,
            $trs,
			array
			(
				"parent_div"=>$controller
				//"images_paginator"=>images_paginator()
			)
		);
    }
	
	//Setup the tooltips
    $qtip_options= array();
	$qtip_options['content']= __('Edit')." ".$item;
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.edit").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Edit')." ".$item." ".__("Permissions.");
	$this->Js->buffer('$(".crud_button.permissions").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Delete')." ".$item." ".__("from the Database");
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.delete").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Add')." ".$item;
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.add").qtip('.json_encode($qtip_options).');');
?>

<?php if(!$is_ajax):?>
    </div>
<?php endif;?>