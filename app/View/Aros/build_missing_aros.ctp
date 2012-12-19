<?php if(!$missing_aros["roles"] && !$missing_aros["users"]):?>
	<?php echo $this->Utils->infobox(__("There are no missing AROs"))?>
<?php else:?>
	<?php if($missing_aros["roles"]):?>
		<h2>Roles without corresponding ARO:</h2>
		<ul>
			<?php foreach($missing_aros["roles"] as $role_id=>$role):?>
				<li><?php echo $role?></li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>		
	<?php if($missing_aros["users"]):?>
		<h2>Users without corresponding ARO:</h2>
		<ul>
			<?php foreach($missing_aros["users"] as $user_id=>$user):?>
				<li><?php echo $user?></li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
	<br/>
	<br/>
	<?php 
		$button= array();
		$button["class"]= "add link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
		$button["url"]= array("plugin"=>null, "controller"=>"aros", "action"=>"build_missing_aros", 1);
		$button["label"]= __("Build");
		
		echo $this->CustomTable->button_group(array($button));
	?>
<?php endif;?>