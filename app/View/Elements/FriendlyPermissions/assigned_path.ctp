<div class='fp_assigned_path sc_button' id='fp_path_<?php echo $itemAco['id']?>'>
	<?php
		$urlRemove = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsItemsAcos', 'action'=>'delete', $itemAco['id'], $friendly_permissions_table_id));
	
		$options = array();
		$options['onclick'] = 'removePathFromItem("'.$urlRemove.'");';
		$button = array();
		$button['permission_url'] = array('plugin'=>null, 'controller'=>'FriendlyPermissionsItemsAcos', 'action'=>'delete');
		$button['class'] = 'remove_path link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_16';
		$button['html_options'] = $options;
		$button['label']= $this->Html->image('crud/small/cross.png', array('align'=>'absmiddle'));
		
		echo $this->CustomTable->button_group(array($button));
	?>
	<?php $truncatedPath = $this->Text->truncate($itemAco['aco_path'], 22); ?>
	<?php echo $truncatedPath?>
</div>
<?php
	//Setup the tooltips
    $qtip_options= array();
	$qtip_options['content']= __('Delete');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$("#fp_path_'.$itemAco['id'].' .crud_button.remove_path").qtip('.json_encode($qtip_options).');');
?>
<?php
	if ($truncatedPath != $itemAco['aco_path']) {
		//Setup the tooltips
	    $qtip_options= array();
		$qtip_options['content']= $itemAco['aco_path'];
		$qtip_options['position']= array('my'=>'left center', 'at'=>'right center');
		$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-yellow');
		$this->Js->buffer('$("#fp_path_'.$itemAco['id'].'").qtip('.json_encode($qtip_options).');');
	}
?>