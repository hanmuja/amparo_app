<?php 
	$permission = $path['permission'];
	$span_id = 'permission_path_'.$path['id'];
	
	//button
	$image = ($permission)? SMALL_PERMISSION_AUTHORIZED_IMAGE:SMALL_PERMISSION_BLOCKED_IMAGE;
	
	//qtip
	$color = 'red';
	$alt = __('Blocked');
	$image = SMALL_PERMISSION_BLOCKED_IMAGE;
	if ($permission) {
		$color = 'green';
		$alt = __('Authorized');
		$image = SMALL_PERMISSION_AUTHORIZED_IMAGE;
	}
	$text = ($permission)? __('Block'): __('Authorize');
?>
<?php
	$urlToggle = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'toggle'.$model.'PathPermission', $one[$model]['id'], $permission), true);
?>
<span id='<?php echo $span_id;?>' onclick="toggleFriendlyPathPermission('<?php echo $urlToggle?>', '<?php echo $path['path']?>')">
	<?php
		$actions = array();
		$button = array();
		$button['class'] = 'link crud_button '.CRUD_THEME.' sc_button_image_16';
		$button['permission_url'] = array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'toggle'.$model.'PathPermission');
		$button['label'] = $this->Html->image($image, array('align'=>'absmiddle', 'alt'=>$alt, 'class'=>'permission'));
		$actions[] = $button;
		
		echo $this->CustomTable->button_group($actions);
	
		//Setup the tooltips
	    $qtip_options= array();
		$qtip_options['content']= $text;
		$qtip_options['position']= array('my'=>'bottom right', 'at'=>'top center');
		$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-'.$color);
		$this->Js->buffer('$("#'.$span_id.' img.permission").qtip('.json_encode($qtip_options).');');
	?>
</span>