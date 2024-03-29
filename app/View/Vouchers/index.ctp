<?php if(!$is_ajax):?>
    <?php echo $this->Dialog->headers() ?>
    <?php echo $this->Utils->datepicker_headers(true)?>
    <?php echo $this->Html->script("ckeditor/ckeditor")?>
    <?php echo $this->Html->script("ckfinder/ckfinder")?>
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
		//$table_actions[]= $button;
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>__("Numero Voucher"), "sortable"=> true, "filterable"=> true, "field"=>"$model.id");
		$ths[]= array("label"=>__("Clave Reservacion"), "sortable"=> true, "filterable"=> true, "field"=>"$model.clave");
		$ths[]= array("label"=>__("Vendedor"), "sortable"=> true, "filterable"=> true, "field"=>"Seller.nombre");
		$ths[]= array("label"=>__("Fecha"), "sortable"=> true, "filterable"=> false, "field"=>"$model.fecha");
		$ths[]= array("label"=>__("Proveedor"), "sortable"=> true, "filterable"=> true, "field"=>"Provider.nombre");
		$ths[]= array("label"=>__("Dia Llegada"), "sortable"=> true, "filterable"=> false, "field"=>"$model.dia_llegada");
		$ths[]= array("label"=>__("Dia Salida"), "sortable"=> true, "filterable"=> false, "field"=>"$model.dia_salida");
		$ths[]= array("label"=>__("Ruta Llegada"), "sortable"=> true, "filterable"=> true, "field"=>"$model.ruta_llegada");
		$ths[]= array("label"=>__("Ruta Salida"), "sortable"=> true, "filterable"=> true, "field"=>"$model.ruta_salida");
		$ths[]= array("label"=>__("Vuelo Llegada"), "sortable"=> true, "filterable"=> true, "field"=>"$model.vuelo_llegada");
		$ths[]= array("label"=>__("Vuelo Salida"), "sortable"=> true, "filterable"=> true, "field"=>"$model.vuelo_salida");
		$ths[]= array("label"=>__("Impreso?"), "sortable"=> true, "filterable"=> false, "field"=>"$model.vuelo_salida");
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
		$options["escape"]= false;
		$button_up= array();
		$button_up["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		//$button_up["dialog_options"]= $dialog_options;
		$button_up["html_options"]= $options;
		$button_up["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"edit", $one[$model]["id"]);
		$button_up["label"]= $this->Html->image('crud/edit.gif', array('align'=>'absmiddle'));
		
		$button_edit= array();
		$button_edit["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$options= array();
		$options["escape"]= false;
		$button_edit["inner_html"]= $this->Form->postLink($this->Html->image('crud/edit.gif', array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>$controller, "action"=>"edit", $one[$model]["id"]), $options);
		$button_edit["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"edit");
		
		$button_del= array();
		$button_del["class"]= "delete link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$options= array();
		$options["escape"]= false;
		$confirm= __('Are you sure you want to delete this %s from the database?', $item);
		$button_del["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>$controller, "action"=>"delete", $one[$model]["id"]), $options, $confirm);
		$button_del["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"delete");
		
		$actions_buttons= $this->CustomTable->button_group(array($button_up, $button_del));
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"100px"));		
		
		$tr[]= str_pad($one[$model]["id"], 4, 0, STR_PAD_LEFT);
		$tr[]= $one[$model]["clave"];
		$tr[]= $one["Seller"]["nombre"];
		$tr[]= date('Y-m-d', $one[$model]["fecha"]);
		$tr[]= $one["Provider"]["nombre"];
		$tr[]= date('Y-m-d H:i', $one[$model]["dia_llegada"]);
		$tr[]= date('Y-m-d H:i', $one[$model]["dia_salida"]);
		$tr[]= $one[$model]["ruta_llegada"];
		$tr[]= $one[$model]["ruta_salida"];
		$tr[]= $one[$model]["vuelo_llegada"];
		$tr[]= $one[$model]["vuelo_salida"];
		$tr[]= $one[$model]["impreso"] ? "Si" : "No";
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