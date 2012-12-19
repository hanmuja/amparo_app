<?php foreach ($paths as $path): ?>
	<div class='fp_menu_subsection_2'>
		<div class='header'>
			<span class='title'><?php echo $path['path']?></span>
			<div class='fp_menu_buttons'>
				<?php echo $this->element('FriendlyPermissions/menu_path_buttons', array('path'=>$path))?>
			</div>
		</div>
	</div>
<?php endforeach;?>