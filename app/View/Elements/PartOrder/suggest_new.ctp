<div id="suggest_new_<?php echo $order["PartOrder"]["id"]?>" class="components_div">
	<?php
		$buttons= array();
		
		$first_label= "";
		if(!$one[$model]["closed"] && !$one[$model]["retired"]){
			$table_actions= array();
			$button= array();
			$dialog_options= array();
			$dialog_options["title"]= "'".__("Request a New Part")."'";
			$dialog_options["width"]= 965;
			$options= array();
			$button["class"]= "add_component link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
			$button["url"]= array("plugin"=>null, "controller"=>"PartSuggestions", "action"=>"add_new", $order["PartOrder"]["id"]);
			$button["dialog_options"]= $dialog_options;
			$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));;	
			$button["html_options"]= $options;
			
			$table_actions[]= $button;
			
			$first_label= $this->CustomTable->button_group($table_actions, array("class"=>"order_actions_".$order["PartOrder"]["id"]));
		}
		
		$ths= array();
		$ths[]= array("label"=>$first_label);
		$ths[]= array("label"=>__("Details"));
		$ths[]= array("label"=>__("Units"));
		$ths[]= array("label"=>__("Date Needed"));
		$ths[]= array("label"=>__("Is Rejected"));
                $ths[]= array("label"=>__("Reason for Rejection"));
                $ths[]= array("label"=>__("Rejected By"));
		
		$trs= array();
		
		if($order["PartSuggestion"]){
			foreach($order["PartSuggestion"] as $suggestion){
				if($suggestion["Part"]["suggested"]){
					$tr= array();
					$actions_buttons="";
                                        $reject_class="";
					if(!$one[$model]["closed"] && !$one[$model]["retired"] && !$suggestion["rejected"]){
						$actions= array();
						
						$button= array();
						$dialog_options= array();
						$dialog_options["title"]= "'".__("Edit New Part Requested")."'";
						$dialog_options["width"]= 965;
						$button["dialog_options"]= $dialog_options;
						$button["class"]= "edit_order_component link crud_button ".CRUD_THEME." sc_button_gray session_action";
						$button["url"]= array("plugin"=>null, "controller"=>"PartSuggestions", "action"=>"edit_new", $suggestion["id"]);
						$button["label"]= $this->Html->image("crud/edit.gif", array('align'=>'absmiddle'));
						$actions[]= $button;
						
						$options_link= array();
						$options_link["escape"]= false;
						$confirm= __('Are you sure you want to delete this %s from the database?', "New Part Request");
						$button= array();
						$button["permission_url"]= array("plugin"=>null, "controller"=>"PartSuggestions", "action"=>"delete");
						$button["class"]= "delete_order_component link crud_button ".CRUD_THEME." sc_button_gray session_action";;
						$button["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>"PartSuggestions", "action"=>"delete", $suggestion["id"], $one["Problem"]["id"]), $options_link, $confirm);
						$actions[]= $button;
						
						$actions_buttons= $this->CustomTable->button_group($actions, array("class"=>"order_actions_".$order["PartOrder"]["id"]));
					}
					else
                                        {
                                          $actions_buttons="";
                                          $reject_class="rejected";
                                        }
                                        
                                        $tr[]= array($actions_buttons, array("class"=>"actions ".$reject_class, "width"=>"110px"));
                                        $tr[]= array(strip_tags($suggestion["Part"]["description"]), array("class"=>$reject_class));
                                        $tr[]= array($suggestion["units"], array("class"=>$reject_class));              
                                        $tr[]= array(($suggestion["expected_arrival_date"])?date("m-d-Y", $suggestion["expected_arrival_date"]):"", array("class"=>$reject_class));
                                        $tr[]= array(($suggestion["rejected"])?__("Yes"):__("No"), array("class"=>$reject_class));
                                        $tr[]= array(strip_tags($suggestion["reason_for_rejection"]), array("class"=>$reject_class));           
                                        $tr[]= array(($suggestion["Rejector"])?$suggestion["Rejector"]["first_name"]." ".$suggestion["Rejector"]["last_name"]:"", array("class"=>$reject_class));
					
					$trs[]= $tr;
				}
			}	
		}
	?>
	<?php echo $this->Utils->form_section(__("New Parts"));?>
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
					"parent_div"=>"suggested_new_".$order["PartOrder"]["id"],
					"class_table"=>"promana-head-button",
					"width"=>"100%",
					"message_empty"=>__("No item found."),
	                "use_ajax"=>true,
	                "clear_filters"=>false,
	                "include_paginator"=>false
				)
			);
		?>
	</div>
</div>