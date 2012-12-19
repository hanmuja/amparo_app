<div id="components_<?php echo $order["PartOrder"]["id"]?>" class="components_div">
	<?php
		$buttons= array();
		
		$first_label= "";
		if(!$one[$model]["closed"] && !$one[$model]["retired"]){
			$table_actions= array();
			$button= array();
			$dialog_options= array();
			$dialog_options["title"]= "'".__("Add a part available for the equipment type")."'";
			$dialog_options["width"]= 500;
			$options= array();
			$button["class"]= "add_component link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
			$button["url"]= array("plugin"=>null, "controller"=>"PartOrderComponents", "action"=>"add", $order["PartOrder"]["id"]);
			$button["dialog_options"]= $dialog_options;
			$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));;	
			$button["html_options"]= $options;
			
			$table_actions[]= $button;
			
			$first_label= $this->CustomTable->button_group($table_actions, array("class"=>"order_actions_".$order["PartOrder"]["id"]));
		}
		
		$ths= array();
		$ths[]= array("label"=>$first_label);
		$ths[]= array("label"=>__("Part Number"));
		$ths[]= array("label"=>__("Description"));
		$ths[]= array("label"=>__("Manufacturer"));
		$ths[]= array("label"=>__("Units"));
		$ths[]= array("label"=>__("Date Needed"));
		$ths[]= array("label"=>__("Status"));
		$ths[]= array("label"=>__("Comments"));
		if($this->Utils->has_permission(array("plugin"=>null, "controller"=>"Problems", "action"=>"show_cost"))) $ths[]= array("label"=>__("Cost")); 
		
		$trs= array();
		
		if($order["PartOrderComponent"]){
			foreach($order["PartOrderComponent"] as $component){
				$tr= array();
				$actions_buttons="";
                                $reject_class="";
				if(!$one[$model]["closed"] && !$one[$model]["retired"]){
					$actions= array();
					
					$button= array();
					$dialog_options= array();
					$dialog_options["title"]= "'".__("Edit Related Part Ordered")."'";
					$dialog_options["width"]= 350;
					$button["dialog_options"]= $dialog_options;
					$button["class"]= "edit_order_component link crud_button ".CRUD_THEME." sc_button_gray session_action";
					$button["url"]= array("plugin"=>null, "controller"=>"PartOrderComponents", "action"=>"edit", $component["id"]);
					$button["label"]= $this->Html->image("crud/edit.gif", array('align'=>'absmiddle'));
					$actions[]= $button;
					
					$options_link= array();
					$options_link["escape"]= false;
					$confirm= __('Are you sure you want to delete this %s from the database?', "Related Part Order");
					$button= array();
					$button["permission_url"]= array("plugin"=>null, "controller"=>"PartOrderComponents", "action"=>"delete");
					$button["class"]= "delete_order_component link crud_button ".CRUD_THEME." sc_button_gray session_action";;
					$button["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>"PartOrderComponents", "action"=>"delete", $component["id"], $one["Problem"]["id"]), $options_link, $confirm);
					$actions[]= $button;
					
					$actions_buttons= $this->CustomTable->button_group($actions, array("class"=>"order_actions_".$order["PartOrder"]["id"]));
				}
				
				if($component['closed'])
                                {
                                  $actions_buttons = "";
                                  if(!$component['successful'])
                                  {
                                    $reject_class="rejected";
                                  }
                                }
				
				$tr[]= array($actions_buttons, array("class"=>"actions ".$reject_class, "width"=>"80px"));
				$tr[]= array($component["Part"]["part_number"], array('class'=>$reject_class));
				$tr[]= array(strip_tags($component["Part"]["description"]), array('class'=>$reject_class));
				$tr[]= array($component["Part"]["manufacturer"], array('class'=>$reject_class));
				$tr[]= array($component["units"], array('class'=>$reject_class));
				$tr[]= array(($component["expected_arrival_date"])?date("m-d-Y", $component["expected_arrival_date"]):"", array('class'=>$reject_class));
				$tr[]= array($reject_class == 'rejected' ? "Canceled" : $component["OrderStatus"]["name"], array('class'=>$reject_class));
				$tr[]= array(strip_tags($component["comment"]), array('class'=>$reject_class));
				if($this->Utils->has_permission(array("plugin"=>null, "controller"=>"Problems", "action"=>"show_cost"))) $tr[]= $this->Number->currency($component["cost"], "USD", array('before'=>'$', 'after'=>false));
				
				$trs[]= $tr;
			}	
		}
	?>
	<?php echo $this->Utils->form_section(__("Related Parts"));?>
	<div class="form_section_body">
		<?php
			echo $this->CustomTable->table
			(
				$controller, 
				array
				(
					"ths"=>$ths,
					"trs"=>$trs,
					"buttons"=>$buttons
				),
				array
				(
					"parent_div"=>"components_".$order["PartOrder"]["id"],
					"class_table"=>"promana-head-button",
					"width"=>"100%",
					"message_empty"=>__("Not item found."),
	                "use_ajax"=>true,
	                "clear_filters"=>false,
	                "include_paginator"=>false
				)
			);
		?>
	</div>
</div>