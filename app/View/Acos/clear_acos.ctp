<div class="acl_box">
  	<h4 class="white"><?php echo __("Clear Actions ACOs")?></h4>
 	<div class="acl_box_container">
		<?php echo __("This Page allows you to clear all actions ACOs.")?>
		<br/>
		<br/>
		<strong><?php echo __("Clicking the button will destroy all existing actions ACOs and associated permissions!")?></strong>
		<br/>
		<br/>
		<?php 
			$button= array();
			$button["class"]= "add link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";
			$options= array();
			$options["onclick"]="if(!confirm('".__('Are you sure you want to destroy all existing actions ACOs?')."'))return false;";
			$button["inner_html"]= $this->Html->link(__('Clear'), array("plugin"=>null, "controller"=>"Acos", "action"=>"clear_acos", 1), $options);
			
			echo $this->CustomTable->button_group(array($button));
		?>
	</div>
</div>