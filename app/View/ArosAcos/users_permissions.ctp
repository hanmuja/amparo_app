<?php
	$controller= "Users";
	$model= "User";
	$item= __("User");
?>

<?php if(!$is_ajax):?>
    <?php echo $this->Dialog->headers()?>
    <?php echo $this->Html->script("acl")?>
    <div id="<?php echo $controller?>">
<?php endif;?>

<?php 
    if($paginated || !$is_ajax)
    {
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>$item, "sortable"=> true, "filterable"=> true, "field"=>$model.".fullname");
		$ths[]= array("label"=>__("Email"), "sortable"=> true, "filterable"=> true, "field"=>$model.".email");
		$ths[]= array("label"=>__("Phone"), "sortable"=> true, "filterable"=> true, "field"=>$model.".phone");
		$ths[]= array("label"=>__("Role"), "sortable"=> true, "filterable"=> true, "field"=>"Role.name");
    }
		
	$trs= array();
	foreach($all as $one)
	{
		$tr= array();
		
		$actions= array();
		
		$dialog_options= array();
		$dialog_options["title"]= "'".__("Edit")." ".$item." ".__("Permissions")."'";
		$dialog_options["width"]= 600;
		$button_per= array();
		$button_per["class"]= "permissions link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button_per["dialog_options"]= $dialog_options;
		$button_per["url"]= array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"user_permissions", $one[$model]["id"]);
		$button_per["label"]= $this->Html->image('crud/lock_pencil.png', array('align'=>'absmiddle'));
		$actions[]= $button_per;
		
		if($one[$model]["retired"])
		{
			$button_retired= array();
			$button["allowed"]= true;
			$button_retired["class"]= "retired crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
			$button_retired["inner_html"]= $this->Html->image("crud/flag_exclamation.png", array("align"=>"absmiddle"));
			$actions[]= $button_retired;	
		}
		
		$actions_buttons= $this->CustomTable->button_group($actions);
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"70px"));		

		$tr[]= $one[$model]["fullname"];
		$tr[]= $one[$model]["email"];
		$tr[]= $one[$model]["phone"];
		$tr[]= $one["Role"]["name"];
		
		$trs[]= $tr;
	}
	
    if($paginated || !$is_ajax){
		echo $this->CustomTable->table
		(
			"Users", 
			array
			(
				"ths"=>$ths,
				"trs"=>$trs
			),
			array
			(
				"parent_div"=>$controller,
				"class_table"=>"promana-head-button",
				"message_empty"=>__("Not item found."),
                "use_ajax"=>true,
                "clear_filters"=>true,
                "url_base"=> array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"users_permissions")
                //"images_paginator"=>images_paginator()
			)
		);
    }
    else{
        echo $this->CustomTable->table_filter
		(
			"Users",
            $trs,
			array
			(
				"parent_div"=>$controller,
				"url_base"=> array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"users_permissions")
				//"images_paginator"=>images_paginator()
			)
		);
    }
	
	//Setup the tooltips
    $qtip_options= array();
	$qtip_options['content']= __('This')." ".$item." ".__("is retired.");
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.retired").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Edit')." ".$item." ".__("Permissions.");
	$this->Js->buffer('$(".crud_button.permissions").qtip('.json_encode($qtip_options).');');
?>
<?php if(!$is_ajax):?>
    </div>
<?php endif;?>