<?php if($other_parts_select):?>
	<?php echo $this->Utils->form_section(__("Non-Related Parts"));?>
	<?php 
		$remove_label= __("Remove Row");
	
		$buttons= array();
		
		/*$table_actions= array();
		$button= array();
		$options= array();
		$options["onclick"]= "add_part_order_row('".$remove_label."', ".json_encode(array_keys($other_parts_select)).", '".__("There is/are %s part(s) available, you can not add more than that rows.", count($other_parts_select))."', 'other_parts_table', 'others_base', 'PartSuggestion')";
		$button["allowed"]= true;
		$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button["html_options"]= $options;
		$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));
		$table_actions[]= $button;
		$first_label= $this->CustomTable->button_group($table_actions);*/
                
                $table_actions= array();
                $button= array();
                $dialog_options= array();
                $dialog_options["title"]= "'".__("Select a Non-Related Part")."'";
                $dialog_options["width"]= 800;
                $dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
                $button["dialog_options"]= $dialog_options;
                $button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
                $button["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"selectPartOther", $problem['Problem']['id']);
                $button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));
                $table_actions[]= $button;
                $first_label= $this->CustomTable->button_group($table_actions);
	
		$ths= array();
		
		$ths[]= array("label"=>$first_label);
		$ths[]= array("label"=>__("Non-Related Parts to Order"));
		$ths[]= array("label"=>__("Units"));
		$ths[]= array("label"=>__("Date Needed"));
		
		$trs= array();
		if(isset($this->data["PartSuggestion"]) && $this->data["PartSuggestion"]){
			foreach($this->data["PartSuggestion"] as $i=>$component){
				$tr= array();
				
				$actions= array();
				$options= array();
				$options["onclick"]= "remove_row(this)";
				$button= array();
				$button["allowed"]= true;
				$button["class"]= "remove link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
				$button["html_options"]= $options;
				$button["label"]= $this->Html->image("crud/remove.gif", array("align"=>"absmiddle"));
				$actions[]= $button;
                                
                                $button= array();
                                $dialog_options= array();
                                $dialog_options["title"]= "'".__("Select a Non-Related Part")."'";
                                $dialog_options["width"]= 800;
                                $dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
                                $button["dialog_options"]= $dialog_options;
                                $button["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
                                $button["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"selectPartOther", $problem['Problem']['id'], "yes", $i);
                                $button["label"]= $this->Html->image("crud/edit.gif", array("align"=>"absmiddle"));
                                $actions[]= $button;
				
				$actions_buttons= $this->CustomTable->button_group($actions);
				$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"60px"));
				$tr[]= $this->Form->input("PartSuggestion.$i.part_id", array('type' => 'hidden')).$this->Form->input("PartSuggestion.$i.part_desc", array("label"=>false, "class"=>"full_input", 'type' => 'text', 'readonly'=> 'readonly'));
				$tr[]= array($this->Form->input("PartSuggestion.".$i.".units", array("type"=>'number',"label"=>false, "class"=>"full_input")), array("class"=>"units_col"));
				$tr[]= array($this->Form->input("AuxElm.PartSuggestion.".$i.".expected_arrival_date", array("type"=>'text', "label"=>false, "size"=>10, "div"=>array("class"=>"input text two_column input_delete"), "autocomplete"=>"off")), array("class"=>"date_needed_col"));
				
				$trs[]= $tr;
				$this->Js->buffer('initialize_basic_datepicker("#AuxElmPartSuggestion'.$i.'ExpectedArrivalDate")');
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
					"id"=>"other_parts_table",
					"parent_div"=>"purchase",
					"class_table"=>"promana-head-button",
					"width"=>"100%",
					"message_empty"=>__("Not item added."),
		            "use_ajax"=>true,
		            "include_paginator"=>false
				)
			);
		?>
	</div>
<?php endif;?>