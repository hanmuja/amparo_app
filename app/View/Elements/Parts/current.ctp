<?php 
	//OVERWRITE THE $controller AND $model VARS
	$controller= "Parts";
	$model= "Part";
	$item= __("Part");
?>

<?php if(!$is_ajax || $render_div=="yes"):?>
    <div id="current_parts">
<?php endif;?>

<?php 
    if($current_paginated || !$is_ajax)
	{
		$buttons= array();
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>__("Part Number"), "sortable"=> true, "filterable"=> true, "field"=>$model.".part_number");
		$ths[]= array("label"=>__("Description"), "sortable"=> true, "filterable"=> true, "field"=>$model.".description");
		$ths[]= array("label"=>__("Manufacturer"), "sortable"=> true, "filterable"=> true, "field"=>$model.".manufacturer");
    }
		
	$trs= array();
	foreach($current_parts as $one)
	{
		$tr= array();
		$actions= array();
		
		$options= array();
		$options["before"]= "show_loading();";
		$options["success"]= "hide_loading();";
		$options["error"]= "handle_error(errorThrown);";
		$options["update"]= "#aux_div";
		$options["escape"]= false;
		
		$button_rem= array();
		$button_rem["permission_url"]= array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"removepart");
		$button_rem["class"]= "removepart link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button_rem["inner_html"]= $this->Js->link($this->Html->image("parts/part_minus.png", array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"removepart", $id, $one[$model]["id"]), $options);
		$actions[]= $button_rem;
		if($one[$model]["retired"])
		{
			$button_retired= array();
			$button_retired["allowed"]= true;
			$button_retired["class"]= "retired crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
			$button_retired["inner_html"]= $this->Html->image("crud/flag_exclamation.png", array("align"=>"absmiddle"));
			$actions[]= $button_retired;	
		}
		
        	
		$actions_buttons= $this->CustomTable->button_group($actions);
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"70px"));		

		$tr[]= $one[$model]["part_number"];
		$tr[]= nl2br($one[$model]["description"]);
		$tr[]= $one[$model]["manufacturer"];
	
		$trs[]= $tr;
	}
	
    if($current_paginated || !$is_ajax)
    {
		echo $this->CustomTable->table
		(
			"CurrentParts", 
			array
			(
				"ths"=>$ths,
				"trs"=>$trs,
				"buttons"=>$buttons
			),
			array
			(
				"parent_div"=>"current_parts",
				"class_table"=>"promana-head-button",
				"message_empty"=>__("No item found."),
                "use_ajax"=>true,
                "clear_filters"=>true,
                "url_base"=> array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"parts", $id, "current", "no")
                //"images_paginator"=>images_paginator()
			)
		);
    }
    else
    {
        echo $this->CustomTable->table_filter
		(
			"CurrentParts",
            $trs,
			array
			(
				"parent_div"=>"current_parts",
				"url_base"=> array("plugin"=>null, "controller"=>"EquipmentTypes", "action"=>"parts", $id, "current", "no"),
				"message_empty"=>__("No item found.")
				//"images_paginator"=>images_paginator()
			)
		);
    }
	
	//Setup the tooltips
    $qtip_options= array();
	$qtip_options['content']= __('Remove')." ".$item." ".__("from Equipment Type.");
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.removepart").qtip('.json_encode($qtip_options).');');
	
	$qtip_options= array();
	$qtip_options['content']= __('Warning: This')." ".$item." ".__("has been retired.");
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top left');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.retired").qtip('.json_encode($qtip_options).');');
?>

<?php if(!$is_ajax ||$render_div=="yes"):?>
    </div>
<?php endif;?>