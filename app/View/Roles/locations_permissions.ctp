<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
	</script>
	<?php exit;?>
<?php endif;?>

<?php if(!$is_ajax):?>
	<?php echo $this->Html->script("locations_checkbox")?>
	<?php
		$buttons= array();
	
		$button= array();
		$button["class"]= "list link crud_button sc_crud_top ".CRUD_THEME." sc_button_gray";
		$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"index");
		$button["label"]= __("Back to List");
		
		$buttons[]= $button;	
		if($edit)
		{
			$button_del= array();
			$options= array();
			$confirm= __('Are you sure you want to retire this %s?', $item);
			$button_del["class"]= "delete link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";;
			$button_del["inner_html"]= $this->Form->postLink(__("Retire"), array("plugin"=>null, "controller"=>$controller, "action"=>"retire", $this->request->data[$model]["id"]), $options, $confirm); 		
			$buttons[]= $button_del;
		}
		
		echo $this->CustomTable->buttons(array($buttons));
	?>
<?php endif;?>

<?php echo $this->Form->create($model);?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input('all', array("id" => "check_all", "label" => __("All"), "type" => "checkbox", "style"=>"display:inline;", "onchange"=>"click_all()")); ?>
	<?php echo $this->Utils->empty_div_row();?>
	<?php 
		foreach($grouped_locations as $route_id=>$locations)
		{
			$route_id= ($route_id)?$route_id:0;
			$route_label= ($route_id)?__("Route:")." ".$locations[0]["Route"]["name"]:__("Unassigned Locations (Locations with no Route)");
			
			$label = $this->Form->checkbox('AuxElm.Routes.'.$route_id, array("id"=>"route_".$route_id, "style"=>"display:inline;", "onchange"=>"reload_children(".$route_id.")"));
			$label .= $this->Form->label("AuxElm.Routes.".$route_id, $route_label, array("style"=>"display:inline; padding-left:10px;"));
			$label= array("label"=>$label, "options"=>array("class"=>"input route_cb_hd all"));
			
			//$cb= $this->Form->checkbox('AuxElm.Routes.'.$route_id, array("id"=>"route_".$route_id, "onchange"=>"reload_children(".$route_id.")"));
			//$cb= array("label"=>$cb, "options"=>array("class"=>"route_cb_hd"));	
			
			echo $this->Utils->div_row(array($label));
			echo $this->Utils->empty_div_row();
			
			foreach($locations as $location)
			{
				$order_only_label= $location["Location"]["order_only"]?__(" ( Order Only )"):"";
				
				$label= $this->Form->checkbox('AuxElm.Locations.'.$location["Location"]["id"], array("class"=>"route_".$route_id, "style"=>"display:inline;", "onchange"=>"reload_parent(".$route_id.")"));
				$label .= $this->Form->label("AuxElm.Locations.".$location["Location"]["id"], $location["Location"]["name"], array("style"=>"display:inline; padding-left:10px;")).$order_only_label;
				$label= array("label"=>$label, "options"=>array("class"=>"all"));
				
				//$cb= $this->Form->checkbox('AuxElm.Locations.'.$location["Location"]["id"], array("class"=>"route_".$route_id, "onchange"=>"reload_parent(".$route_id.")"));
				//$cb= array("label"=>$cb);	
				
				echo $this->Utils->div_row(array($label));
				echo $this->Utils->empty_div_row();
			}
			
			echo $this->Js->buffer("reload_parent(".$route_id.")");
		}
	?>
	<?php
		//Example of HABTM 
		//echo $this->Form->input("Location")
	?>
	<?php echo $this->Utils->form_separator();?>
	<?php echo $this->Utils->empty_div_row();?>
	<?php if($is_ajax):?>
		
<?php $this->Js->buffer('
	$("#submit_locations").click(function(e){
		var x = $(\'input[name="data[AuxElm][process]"]:checked\').val();
		if(x != 1){
			if(!confirm("You are about to overwrite the Locations Permissions for All users in this Role. Do you want to continue?")){
				e.stopImmediatePropagation();
				return false;
			}
		}
	});
')?>

		
		<?php echo $this->Js->submit(__("Update Permissions"), array("id"=>"submit_locations", "type"=>"POST", "div" => array("class" => "submit two_column"), "class"=>"sc_button sc_button_green", "update"=>"#full_permissions_inner", "before"=>"show_loading();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<div class="two_column" style="float: right;">
			<div class="two_column">
			    <?php echo $this->Form->input("AuxElm.process", array('type' => 'radio', 'options' => array('1'=>__('Set Initial Locations'), '2'=>__('Overwrite Affected Users'), '3'=>__('Both')), "legend"=>false, 'value'=>1, "div"=>array("class"=>"input two_column radio check_inline")))?>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Update Permissions"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>