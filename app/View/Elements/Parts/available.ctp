<?php 
	//OVERWRITE THE $controller AND $model VARS
	$controller= "Parts";
	$model= "Part";
	$item= __("Part");
?>

<?php if(!$is_ajax || $render_div=="yes"):?>
    <div id="available_parts">
<?php endif;?>

<?php 
    if($available_paginated || !$is_ajax)
    {
		$buttons= array();
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>__("Part Number"), "sortable"=> true, "filterable"=> true, "field"=>$model.".part_number");
		$ths[]= array("label"=>__("Description"), "sortable"=> true, "filterable"=> true, "field"=>$model.".description");
		$ths[]= array("label"=>__("Manufacturer"), "sortable"=> true, "filterable"=> true, "field"=>$model.".manufacturer");
    }
		
	$trs= array();
	foreach($available_parts as $one)
	{
		$tr= array();
		
		$options= array();
		$options["before"]= "show_loading();";
		$options["success"]= "hide_loading();";
		$options["error"]= "handle_error(errorThrown);";
		$options["update"]= "#aux_div";
		$options["escape"]= false;
		
		$button_add= array();
		$button_add["class"]= "addpart link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button_add["permission_url"]= array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"addpart");
		$button_add["inner_html"]= $this->Js->link($this->Html->image("parts/part_plus.png", array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"addpart", $id, $one[$model]["id"]), $options);
        
			
		$actions_buttons= $this->CustomTable->button_group(array($button_add));
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30px"));		

		$tr[]= $one[$model]["part_number"];
		$tr[]= nl2br($one[$model]["description"]);
		$tr[]= $one[$model]["manufacturer"];
	
		$trs[]= $tr;
	}
	
    if($available_paginated || !$is_ajax)
    {
		echo $this->CustomTable->table
		(
			"AvailableParts", 
			array
			(
				"ths"=>$ths,
				"trs"=>$trs,
				"buttons"=>$buttons
			),
			array
			(
				"parent_div"=>"available_parts",
				"class_table"=>"promana-head-button",
				"message_empty"=>__("No item found."),
                "use_ajax"=>true,
                "clear_filters"=>true,
                "url_base"=> array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"parts", $id, "available", "no")
                //"images_paginator"=>images_paginator()
			)
		);
    }
    else
    {
        echo $this->CustomTable->table_filter
		(
			"AvailableParts",
            $trs,
			array
			(
				"parent_div"=>"available_parts",
				"url_base"=> array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"parts", $id, "available", "no"),
				"message_empty"=>__("No item found.")
				//"images_paginator"=>images_paginator()
			)
		);
    }
	
	//Setup the tooltips
    $qtip_options= array();
	$qtip_options['content']= __('Add %s to Equipment Type.', $item);
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.addpart").qtip('.json_encode($qtip_options).');');
?>

<?php if(!$is_ajax ||$render_div=="yes"):?>
    </div>
<?php endif;?>