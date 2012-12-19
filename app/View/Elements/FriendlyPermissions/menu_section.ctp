<div class='fp_menu_section fp_menu_section_box'>
	<div class='header'>
		<span class='title'><?php echo $section['label']?></span>
		<div class='fp_menu_buttons'>
			<?php echo $this->element('FriendlyPermissions/menu_buttons', array('section'=>$section))?>
		</div>
	</div>
	<div class='children'>
		<?php if ($section['children']): ?>
			<?php foreach($section['children'] as $subsection):?>
				<?php echo $this->element('FriendlyPermissions/menu_subsection_1', array('subsection_1'=>$subsection))?>
			<?php endforeach;?>
		<?php endif;?>
	</div>
</div>