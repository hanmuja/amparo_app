<?php if($available_parts_select):?>
	<?php
		$serial= 0;
		if(isset($this->data["PartOrderComponent"]) && $this->data["PartOrderComponent"]){
			foreach($this->data["PartOrderComponent"] as $i=>$component){
				if($i>$serial){
					$serial= $i;
				}
			}
		}
	?>	
	<div id="tr_base" style="display:none" serial="<?php echo $serial?>">
		<table>
			<?php
				$trs= array();
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
                                $dialog_options["title"]= "'".__("Select a Related Part")."'";
                                $dialog_options["width"]= 800;
                                $dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
                                $button["dialog_options"]= $dialog_options;
                                $button["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
                                $button["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"selectPartAvailable", $problem['Problem']['id'], "yes", 'REPLACEME');
                                $button["label"]= $this->Html->image("crud/edit.gif", array("align"=>"absmiddle"));
                                $actions[]= $button;
				
				$actions_buttons= $this->CustomTable->button_group($actions);
				$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"60"));
				$tr[]= $this->Form->input("PartOrderComponent.REPLACEME.part_id", array('type' => 'hidden')).$this->Form->input("PartOrderComponent.REPLACEME.part_desc", array("label"=>false, "class"=>"full_input", 'type' => 'text', 'readonly'=> 'readonly'));
				$tr[]= array($this->Form->input("PartOrderComponent.REPLACEME.units", array("type"=>'number',"label"=>false, "class"=>"full_input")), array("class"=>"units_col"));
				$tr[]= array($this->Form->input("AuxElm.REPLACEME.expected_arrival_date", array("label"=>false, "size"=>10, "div"=>array("class"=>"input text two_column input_delete"), "autocomplete"=>"off")), array("class"=>"date_needed_col"));
				
				$trs[]= $tr;
				
				echo $this->Html->tableCells($trs);
			?>
		</table>
	</div>
<?php endif;?>

<?php if($other_parts_select):?>
	<?php
		$serial= 0;
		if(isset($this->data["SuggestedExisting"]) && $this->data["SuggestedExisting"]){
			foreach($this->data["SuggestedExisting"] as $i=>$component){
				if($i>$serial){
					$serial= $i;
				}
			}
		}
	?>	
	<div id="others_base" style="display:none" serial="<?php echo $serial?>">
		<table>
			<?php
				$trs= array();
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
                                $button["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"selectPartOther", $problem['Problem']['id'], "yes", 'REPLACEME');
                                $button["label"]= $this->Html->image("crud/edit.gif", array("align"=>"absmiddle"));
                                $actions[]= $button;
				
				$actions_buttons= $this->CustomTable->button_group($actions);
				$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"60"));
				$tr[]= $this->Form->input("PartSuggestion.REPLACEME.part_id", array('type' => 'hidden')).$this->Form->input("PartSuggestion.REPLACEME.part_desc", array("label"=>false, "class"=>"full_input", 'type' => 'text', 'readonly'=> 'readonly'));
				$tr[]= array($this->Form->input("PartSuggestion.REPLACEME.units", array("type"=>'number',"label"=>false, "class"=>"full_input")), array("class"=>"units_col"));
				$tr[]= array($this->Form->input("AuxElm.PartSuggestion.REPLACEME.expected_arrival_date", array("label"=>false, "size"=>10, "div"=>array("class"=>"input text two_column input_delete"), "autocomplete"=>"off")), array("class"=>"date_needed_col"));
				
				$trs[]= $tr;
				echo $this->Html->tableCells($trs);
			?>
		</table>
	</div>
<?php endif;?>


<?php
	$serial= 0;
	if(isset($this->data["SuggestedNew"]) && $this->data["SuggestedNew"]){
		foreach($this->data["SuggestedNew"] as $i=>$component){
			if($i>$serial){
				$serial= $i;
			}
		}
	}
?>	
<div id="news_base" style="display:none" serial="<?php echo $serial?>">
	<table>
		<?php
			$trs= array();
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
			$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"30"));
			$tr[]= array($this->Form->input("AuxElm.SuggestedNew.REPLACEME.Part.description", array("label"=>false, "class"=>"full_input", "type"=>"textarea", "style"=>"height:15px;")), array("valign"=>"top"));
			$tr[]= array($this->Form->input("AuxElm.SuggestedNew.REPLACEME.units", array("type"=>'number',"label"=>false, "class"=>"full_input")), array("class"=>"units_col", "valign"=>"top"));
			$tr[]= array($this->Form->input("AuxElm.SuggestedNew.REPLACEME.expected_arrival_date", array("label"=>false, "size"=>10, "div"=>array("class"=>"input text two_column input_delete"), "autocomplete"=>"off")), array("class"=>"date_needed_col", "valign"=>"top"));
				
			$trs[]= $tr;
			echo $this->Html->tableCells($trs);
		?>
	</table>
</div>