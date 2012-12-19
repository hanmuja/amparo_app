<?php if(!$is_ajax):?>
    <?php echo $this->Html->css('friendly_permissions')?>
	<?php echo $this->Dialog->headers()?>
    <?php echo $this->Html->script("acl")?>
    <?php echo $this->Html->script("users")?>
    <?php echo $this->Html->script("locations_checkbox")?>
    <?php echo $this->Html->script("ui/minified/jquery.ui.tabs.min");?>
    <?php echo $this->Html->script("jstree/jquery.cookie");?>
    <?php echo $this->Html->script("jstree/jquery.hotkeys");?>
    <?php echo $this->Html->script("jstree/jquery.jstree");?>
    <?php echo $this->Html->script("friendly_permissions")?>
    <div id="<?php echo $controller?>">    
<?php endif;?>

<?php 
    if($paginated || !$is_ajax)
    {
    	$buttons= array();
		
		$table_actions= array();
		
		$ths= array();
		$ths[]= array("label"=>ACTIONS_LABEL);
		$ths[]= array("label"=>$item, "sortable"=> true, "filterable"=> true, "field"=>$model.".fullname");
		$ths[]= array("label"=>__("Email"), "sortable"=> true, "filterable"=> true, "field"=>$model.".email");
		$ths[]= array("label"=>__("Username"), "sortable"=> true, "filterable"=> true, "field"=>$model.".username");
		$ths[]= array("label"=>__("Comment"), "sortable"=> false, "filterable"=> false);
    }
		
	$trs= array();
	foreach($all as $one)
	{
		$tr= array();
		
		$actions= array();
		
		$dialog_options= array();
		$dialog_options["title"]= "'".__("Accept Pending")." ".$item."'";
		$dialog_options["width"]= 500;
		
		$options= array();
		$options["id"]= "button_edit_".$one[$model]["id"];
		$button_up= array();
		$button_up["class"]= "accept link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button_up["dialog_options"]= $dialog_options;
		$button_up["html_options"]= $options;
		$button_up["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"accept", $one[$model]["id"]);
		$button_up["label"]= $this->Html->image('crud/check.png', array('align'=>'absmiddle'));
		$actions[]= $button_up;
		
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
		$button_del["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>$controller, "action"=>"delete_pending", $one[$model]["id"]), $options, $confirm);
        
		/**
		 * As we just see, we sent the inner_html to the button, so we don't sent any URL.
		 * In the regular cases, the helper decides if show or not show the button, according to the permissions
		 * the current user has over the sent URL. But in this case we have not URL.
		 * We need to send the permission URL explicit, so we send it in the next option.
		 * In this case, this button will be showed only if the current user has permissions to delete an EquipmentType
		 */
		$button_del["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"delete_pending");
		
		//$actions[]= $button_del;
                
                $dialog_options= array();
                $dialog_options["title"]= "'".__("Confirm Delete User")."'";
                $dialog_options["width"]= 400;
                $button["dialog_options"]= $dialog_options;
                $button["class"]= "delete link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
                $button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"delete_pending", $one[$model]["id"]);
                $button["label"]= $this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle"));
                
                $actions[]= $button;
		
		$actions_buttons= $this->CustomTable->button_group($actions);
		
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"100px"));		

		$tr[]= $one[$model]["fullname"];
		$tr[]= $one[$model]["email"];
		$tr[]= $one[$model]["username"];
        $tr[]= $one[$model]["pending_comment"];
		
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
                "clear_filters"=>true,
                "url_base"=> array("plugin"=>null, "controller"=>$controller, "action"=>"pending")
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
	$qtip_options['content']= __('Accept')." ".$item;
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.accept").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Delete')." ".$item." ".__("from Database");
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.delete").qtip('.json_encode($qtip_options).');');
?>

<?php if(!$is_ajax):?>
    </div>
<?php endif;?>