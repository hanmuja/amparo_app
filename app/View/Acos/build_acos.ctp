<?php if($run):?>
	<?php if($log):?>
		<ul>
			<?php foreach($log as $l):?>
				<li><?php echo $l?></li>
			<?php endforeach;?>
		</ul>
	<?php else:?>
		There are no new actions ACOs to create.
	<?php endif;?>
<?php else:?>
	This page allows you to build missing actions ACOs if any.
	<br/>
	<br/>
	<strong>Clicking the button will not destroy existing actions ACOs!</strong>
	<br/>
	<br/>
	<?php 
		$button= array();
		$button["class"]= "add link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
		$button["url"]= array("plugin"=>null, "controller"=>"acos", "action"=>"build_acos", 1);
		$button["label"]= __("Build");
		
		echo $this->CustomTable->button_group(array($button));
	?>
<?php endif;?>