<?php if(!$is_ajax):?>
	<?php echo $this->Dialog->headers()?>
	<?php echo $this->Html->css('friendly_permissions')?>
	<?php echo $this->Html->script('ui/minified/jquery.ui.draggable.min')?>
	<?php echo $this->Html->script('ui/minified/jquery.ui.droppable.min')?>
	<?php echo $this->Html->script('friendly_permissions')?>
	<?php echo $this->Html->script('ui/minified/jquery.ui.sortable.min')?>
	<?php echo $this->Html->css('tinyscrollbar')?>
	<?php echo $this->Html->script('jquery.tinyscrollbar.min')?>


	<?php
		$dialog_options= array();
		$dialog_options['title']= "'".__('Add Section')."'";
		$dialog_options['width']= 500;
		
		$options= array();
		$button= array();
		$button['class']= 'add_section link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_22';
		$button['dialog_options']= $dialog_options;
		$button['html_options']= $options;
		$button['url']= array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'add', $id);
		$button['label']= $this->Html->image('crud/plus.png', array('align'=>'absmiddle'));
		 
		echo $this->CustomTable->buttons(array(array($button)));
	?>
	<div class='fp_sections' id='fp_sections'>
<?php endif;?>

	<?php if ($sections):?>
		<?php foreach($sections as $section):?>
			<?php echo $this->element('FriendlyPermissions/section', array('section'=>$section))?>
		<?php endforeach;?>
	<?php endif;?>
<?php if(!$is_ajax):?>
	</div>
	<div id='fp_acos' class='fp_acos'>
		<div id='fp_acos_filters'>
			<h3><?php echo __('Drag and drop the paths into the permissions table')?></h3>
			<?php 
				$urlFilter = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsTables', 'action'=>'filter', $id), true);
			?>
			<?php echo $this->Form->input($model.'.alias', array('label'=>__('Type to filter:'), 'onkeyup'=>'filterPaths(this, "'.$urlFilter.'")'))?>
		</div>
		<div id='fp_acos_list'>
			<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
			<div class="viewport">
				<div class="overview" id='fp_inner_acos_list'>
					<?php
						//Extract $related and $allAcos
						extract($acosInfo);
					?>
					<?php echo $this->element('FriendlyPermissions/acos_list', array('allAcos' => $allAcos, 'related' => $related))?>
				</div>
			</div>
		</div>
	</div>
<?php endif;?>
<?php
	$this->Js->buffer('initializeDraggableAcos();');
	$url = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsItemsAcos', 'action'=>'add'), true); 
	$this->Js->buffer('initializeDroppableBoxes("'.$url.'")');
	$this->Js->buffer('initializeDragglableAssignedBoxes();');

	//Setup the tooltips
	$qtip_options= array();
	$qtip_options['content']= __('Edit Section');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.edit_section").qtip('.json_encode($qtip_options).');');
	
	$qtip_options= array();
	$qtip_options['content']= __('Edit Section');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.edit_subsection").qtip('.json_encode($qtip_options).');');
	
    $qtip_options= array();
	$qtip_options['content']= __('Add Subsection');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.add_subsection").qtip('.json_encode($qtip_options).');');
	
    $qtip_options= array();
	$qtip_options['content']= __('Add Section');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.add_section").qtip('.json_encode($qtip_options).');');
	
	$qtip_options= array();
	$qtip_options['content']= __('Delete Section');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.delete_section").qtip('.json_encode($qtip_options).');');
	
	$qtip_options= array();
	$qtip_options['content']= __('Delete Subsection');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.delete_subsection").qtip('.json_encode($qtip_options).');');
?>