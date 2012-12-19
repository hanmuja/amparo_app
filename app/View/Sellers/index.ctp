<?php if(!$is_ajax):?>
    <?php echo $this->Dialog->headers() ?>
    <div id="<?php echo $controller?>">
<?php endif;?>

<?php 
    if($paginated || !$is_ajax)
    {
		$buttons= array();
		
		$table_actions= array();
		
		$dialog_options= array();
		$dialog_options["title"]= "'".__("Add")." ".$item."'";
		$dialog_options["width"]= 615;
		
		$options= array();
		$options["id"]= "button_add";
		$button= array();
		$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button["dialog_options"]= $dialog_options;
		$button["html_options"]= $options;
		$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"add");
		$button["label"]= $this->Html->image('crud/small/plus.png', array('align'=>'absmiddle'));
		$table_actions[]= $button;
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>__("Nombre"), "sortable"=> true, "filterable"=> true, "field"=>"$model.nombre");
		$ths[]= array("label"=>__("Primer Apellido"), "sortable"=> true, "filterable"=> true, "field"=>"$model.primer_apellido");
		$ths[]= array("label"=>__("Segundo Apellido"), "sortable"=> true, "filterable"=> true, "field"=>"$model.segundo_apellido");
    }
		
	$trs= array();
	foreach($all as $one)
	{
		$tr= array();
		
		//////////////
		$dialog_options= array();
		$dialog_options["title"]= "'".__("Edit")." ".$item."'";
		$dialog_options["width"]= 615;
		
		$options= array();
		$button_up= array();
		$button_up["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button_up["dialog_options"]= $dialog_options;
		$button_up["html_options"]= $options;
		$button_up["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"edit", $one[$model]["id"]);
		$button_up["label"]= $this->Html->image('crud/edit.gif', array('align'=>'absmiddle'));
		
		/////////////
		/**
		 * The "Delete" button
		 */
		$button_del= array();
		$button_del["class"]= "delete link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		
		/**
		 * In  most cases we just need to send the URL and the CustomTable helper will know if the button
		 * is to create a regular link or to launch a dialog.
		 * But sometimes we need the button contents to be something especific, something we know exactly.
		 * In such cases we use the inner_html option.
		 * For example, in this case we need a post link, so we send such post link as the inner_html and the helper
		 * will just put it inside the button.
		 */
		$options= array();
		$options["escape"]= false;
		$confirm= __('Are you sure you want to delete this %s from the database?', $item);
		$button_del["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>$controller, "action"=>"delete", $one[$model]["id"]), $options, $confirm);
        
		/**
		 * As we just see, we sent the inner_html to the button, so we don't sent any URL.
		 * In the regular cases, the helper decides if show or not show the button, according to the permissions
		 * the current user has over the sent URL. But in this case we have not URL.
		 * We need to send the permission URL explicit, so we send it in the next option.
		 * In this case, this button will be showed only if the current user has permissions to delete an EquipmentType
		 */
		$button_del["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"delete");
		
		$actions_buttons= $this->CustomTable->button_group(array($button_up, $button_del));
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"100px"));		
		
		$tr[]= $one[$model]["nombre"];
		$tr[]= $one[$model]["primer_apellido"];
		$tr[]= $one[$model]["segundo_apellido"];
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
				"message_empty"=>__("No item found."),
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
	
	$qtip_options['content']= __('Delete')." ".$item." ".__("from Database");
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.delete").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Add')." ".$item;
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.add").qtip('.json_encode($qtip_options).');');
?>

<?php if(!$is_ajax):?>
    </div>
<?php endif;?>