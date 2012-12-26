<?php if(!$is_ajax || $render_div=="yes"):?>
	<div id="aux_div"></div>
    <div id="buscar_provider">
<?php endif;?>

<?php 
    if($paginated || !$is_ajax)
    {
		$buttons= array();
		
		$table_actions= array();
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>__("Clave"), "sortable"=> true, "filterable"=> true, "field"=>"$model.clave");
		$ths[]= array("label"=>__("Nombre"), "sortable"=> true, "filterable"=> true, "field"=>"$model.nombre");
		$ths[]= array("label"=>__("Telefono Principal"), "sortable"=> true, "filterable"=> true, "field"=>"$model.telefono_principal");
		$ths[]= array("label"=>__("Fax"), "sortable"=> true, "filterable"=> true, "field"=>"$model.fax");
    }
		
	$trs= array();
	foreach($all as $one)
	{
		$tr= array();
		
		//////////////
		
		$options= array();
		$options["before"]= "show_loading();";
		$options["success"]= "hide_loading();";
		$options["error"]= "handle_error(errorThrown);";
		$options["update"]= "#aux_div";
		$options["escape"]= false;
                
		$button= array();
		$options= array();
		$options["onclick"]= "select_provider(".json_encode($one[$model]).")";
		$button["allowed"]= true;
		$button["class"]= "select link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button["html_options"]= $options;
		$button["label"]= $this->Html->image("crud/check.png", array("align"=>"absmiddle"));
		
		/////////////
		
		$actions_buttons= $this->CustomTable->button_group(array($button));
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30px"));		
		
		$tr[]= $one[$model]["clave"];
		$tr[]= $one[$model]["nombre"];
		$tr[]= $one[$model]["telefono_principal"];
		$tr[]= $one[$model]["fax"];
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
				"parent_div"=>"buscar_provider",
				"class_table"=>"promana-head-button",
				"message_empty"=>__("No item found."),
                "use_ajax"=>true,
                "clear_filters"=>true,
                "url_base"=> array("plugin"=>null, "controller"=>$controller, "action"=>"buscar", "no")
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
				"parent_div"=>"buscar_provider",
				"url_base"=> array("plugin"=>null, "controller"=>$controller, "action"=>"buscar", "no")
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

<?php if(!$is_ajax ||$render_div=="yes"):?>
    </div>
<?php endif;?>