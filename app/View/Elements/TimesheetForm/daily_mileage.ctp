	<?php echo $this->Utils->form_section(__("Daily Mileage"));?>
	<?php 
		$remove_label= __("Remove Row");
	
		$buttons= array();
		
		$available_parts_select = array();
		$table_actions= array();
		$button= array();
		$options= array();
        $options["onclick"]= "add_daily_time_row('".$remove_label."', -1, '".__("No more locations available, you cannot add anymore rows.", 0)."', 'new_daily_mileage_table', 'tr_base_mileage', 'SuggestedNew')";
		$button["allowed"]= true;
		$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button["html_options"]= $options;
		$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));
		$table_actions[]= $button;
		$first_label= $this->CustomTable->button_group($table_actions);
	
		$ths= array();
		$ths[]= array("label"=>$first_label);
		$ths[]= array("label"=>__("From Location"));
		$ths[]= array("label"=>__("To Location"));
		$ths[]= array("label"=>__("Round Trip"));
		
		$trs= array();
		if(isset($this->data["DailyMileage"]) && $this->data["DailyMileage"]){
			foreach($this->data["DailyMileage"] as $i=>$component){
				$tr= array();
				
				$actions= array();
                                $options= array();
                                if(isset($component['id']))
                                  $options["onclick"]= "if(confirm('Are you sure from delete this Mileage?')){ remove_row_mileage(this, '".$component['id']."');}";
                                else
                                  $options["onclick"]= "remove_row(this)";
                                $button= array();
                                $button["allowed"]= true;
                                $button["class"]= "remove link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
                                $button["html_options"]= $options;
                                $button["label"]= $this->Html->image("crud/remove.gif", array("align"=>"absmiddle"));
                                $actions[]= $button;
				
				$actions_buttons= $this->CustomTable->button_group($actions);
				$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30px"));
				$tr[]= $this->Form->input("DailyMileage.$i.id").$this->Form->input("DailyMileage.".$i.".from_location_id", array("label"=>false, "options"=>$locations, "empty"=>EMPTY_OPTION));
				$tr[]= $this->Form->input("DailyMileage.".$i.".to_location_id", array("label"=>false, "options"=>$locations, "empty"=>EMPTY_OPTION));
				$tr[]= $this->Form->input("DailyMileage.".$i.".round_trip", array("type"=>'checkbox',"label"=>false));
				
				$trs[]= $tr;
			}
		}
	?>
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
					"id"=>"new_daily_mileage_table",
					"parent_div"=>"purchase",
					"class_table"=>"promana-head-button",
					"message_empty"=>__("No item added."),
		            "use_ajax"=>true,
					"width"=>"100%",
		            "include_paginator"=>false
				)
			); 
		?>
	</div>