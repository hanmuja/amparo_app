<div class='fp_menu_subsection_1 fp_menu_section_box'>
	<div class='header'>
		<span class='title'><?php echo $subsection_1['label']?></span>
		<div class='fp_menu_buttons'>
			<?php echo $this->element('FriendlyPermissions/menu_buttons', array('section'=>$subsection_1, 'red_expand'=>($subsection_1['paths'])))?>
		</div>
	</div>
	<div class='children'>
		<?php if ($subsection_1['children']): ?>
			<?php foreach($subsection_1['children'] as $subsection_2):?>
				<div class='fp_menu_subsection_2 fp_menu_section_box'>
					<div class='header'>
						<span class='title'><?php echo $subsection_2['label']?></span>
						<div class='fp_menu_buttons'>
							<?php echo $this->element('FriendlyPermissions/menu_buttons', array('section'=>$subsection_2, 'red_expand'=>true))?>
						</div>
					</div>
					<div class='children'>
						<?php if ($subsection_2['paths']): ?>
							<?php echo $this->element('FriendlyPermissions/menu_paths', array('paths'=>$subsection_2['paths']))?>
						<?php endif;?>
					</div>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		<?php if ($subsection_1['paths']): ?>
			<?php echo $this->element('FriendlyPermissions/menu_paths', array('paths'=>$subsection_1['paths']))?>
		<?php endif;?>
	</div>
</div>