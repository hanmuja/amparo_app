	<?php echo $this->Utils->form_section(__("Daily Time"));?>
	<?php 
		$remove_label= __("Remove Row");
	
		$buttons= array();
		
		$available_parts_select = array();
		$table_actions= array();
		$button= array();
		$options= array();
                $options["onclick"]= "add_daily_time_row('".$remove_label."', -1, '".__("No more locations available, you cannot add anymore rows.", 0)."', 'new_daily_time_table', 'tr_base_time', 'SuggestedNew')";
		$button["allowed"]= true;
		$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button["html_options"]= $options;
		$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));
		$table_actions[]= $button;
		$first_label= $this->CustomTable->button_group($table_actions);
	
		$ths= array();
		$ths[]= array("label"=>$first_label);
		$ths[]= array("label"=>__("Location"));
		$ths[]= array("label"=>__("Hours"));
		//$ths[]= array("label"=>__("Minutes"));
		
		$trs= array();
		if(isset($this->data["DailyTime"]) && $this->data["DailyTime"]){
			foreach($this->data["DailyTime"] as $i=>$component){
				$tr= array();
				
				$actions= array();
				$options= array();
				if(isset($component['id']))
                                  $options["onclick"]= "if(confirm('Are you sure you want to delete this Time?')){ remove_row_time(this, '".$component['id']."');}";
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
				$tr[]= $this->Form->input("DailyTime.$i.id").$this->Form->input("DailyTime.".$i.".location_id", array("label"=>false, "options"=>$locations, "empty"=>EMPTY_OPTION));
				$hours = $component['hours'].":".$component['minutes'];
                                $tr[]= $this->Form->input("DailyTime.$i.hours_all", array("type"=>'text',"label"=>false, 'size' => '3', 'value' => $hours, 'autocomplete' => 'off'));
				
				$trs[]= $tr;
                                
                $this->Js->buffer('initialize_basic_timepicker("#DailyTime'.$i.'HoursAll", { showPeriodLabels: false })');
				$this->Js->buffer('initialize_change_minutes("#DailyTime'.$i.'HoursAll")');
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
					"id"=>"new_daily_time_table",
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