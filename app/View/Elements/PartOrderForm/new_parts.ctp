<?php echo $this->Utils->form_section(__("New Parts"));?>
<?php 
	$remove_label= __("Remove Row");

	$buttons= array();
	
	$table_actions= array();
	$button= array();
	$options= array();
	$options["onclick"]= "add_part_order_row('".$remove_label."', -1, '".__("No more parts available, you cannot add anymore rows.")."', 'new_parts_table', 'news_base', 'SuggestedNew')";
	$button["allowed"]= true;
	$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
	$button["html_options"]= $options;
	$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));
	$table_actions[]= $button;
	$first_label= $this->CustomTable->button_group($table_actions);
	
	$ths= array();
	
	$ths[]= array("label"=>$first_label);
	$ths[]= array("label"=>__("New Part Request Details"));
	$ths[]= array("label"=>__("Units"));
	$ths[]= array("label"=>__("Date Needed"));
	
	$trs= array();
	if(isset($this->data["AuxElm"]["SuggestedNew"]) && $this->data["AuxElm"]["SuggestedNew"]){
		foreach($this->data["AuxElm"]["SuggestedNew"] as $i=>$component){
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
			
			$actions_buttons= $this->CustomTable->button_group($actions);
			$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30px"));
			$tr[]= array($this->Form->input("AuxElm.SuggestedNew.".$i.".Part.description", array("label"=>false, "class"=>"full_input", "type"=>"textarea", "style"=>"height:15px;")), array("valign"=>"top"));
			$tr[]= array($this->Form->input("AuxElm.SuggestedNew.".$i.".units", array("type"=>'number',"label"=>false, "class"=>"full_input")), array("class"=>"units_col", "valign"=>"top"));
			$tr[]= array($this->Form->input("AuxElm.SuggestedNew.".$i.".expected_arrival_date", array("label"=>false, "size"=>10, "div"=>array("class"=>"input text two_column input_delete"), "autocomplete"=>"off")), array("class"=>"date_needed_col", "valign"=>"top"));
			 
			$trs[]= $tr;
			$this->Js->buffer('initialize_basic_datepicker("#AuxElmSuggestedNew'.$i.'ExpectedArrivalDate")');
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
				"id"=>"new_parts_table",
				"parent_div"=>"purchase",
				"class_table"=>"promana-head-button",
				"width"=>"100%",
				"message_empty"=>__("No item added."),
	            "use_ajax"=>true,
	            "include_paginator"=>false
			)
		);
	?>
</div>