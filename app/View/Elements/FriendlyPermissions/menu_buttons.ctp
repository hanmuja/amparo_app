<?php 
	if (!isset($red_expand)) {
		$red_expand = false;
	}
	
	$expandIconAppend = ($red_expand)?'_red':'';
	$permission= $section['permission'];
	$span_id= 'permission_'.$section['id'];
	
	//button
	$image = ($permission)? SMALL_PERMISSION_AUTHORIZED_IMAGE:SMALL_PERMISSION_BLOCKED_IMAGE;
	
	//qtip
	$color = 'red';
	$alt = __('Blocked');
	$image = SMALL_PERMISSION_BLOCKED_IMAGE;
	if ($permission == 'granted') {
		$color = 'green';
		$alt = __('Authorized');
		$image = SMALL_PERMISSION_AUTHORIZED_IMAGE;
	} elseif ($permission == 'mixed') {
		$alt = __('Mixed');
		$image = SMALL_PERMISSION_MIXED_IMAGE;
	}
	$text = ($permission == 'granted')? __('Block'): __('Authorize');
?>
<?php
	if ($section['children'] || $section['paths']) {
		$expandImage = 'expand'.(($red_expand)?'_red':'');
		if ($this->Session->check('OpenState.'.$section['id'])) {
			if ($this->Session->read('OpenState.'.$section['id']) == 'open') {
				$expandImage = 'collapse'.(($red_expand)?'_red':'');
			} else {
				$this->Js->buffer('$("#permission_box_'.$section['id'].'").click();');
			}
		} else {
			$this->Js->buffer('$("#permission_box_'.$section['id'].'").click();');
		}
		
		$urlState = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'saveOpenState', $section['id']));
		$actions = array();
		$button = array();
		$html_options = array();
		$html_options['id'] = 'permission_box_'.$section['id'];
		$html_options['onclick'] = 'togglePermissionBox(this, '.$section['id'].', "'.$urlState.'");';
		$button['html_options'] = $html_options;
		$button['class'] = 'expand link crud_button '.CRUD_THEME.' sc_button_image_16';
		$button['allowed'] = true;
		$button['label'] = $this->Html->image('crud/small/'.$expandImage.'.png', array('align'=>'absmiddle'));
		$actions[] = $button;
		echo $this->CustomTable->button_group($actions);
	}
?>
<?php $urlToggle = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'toggle'.$model.'Permissions', $section['id'], $one[$model]['id'], $permission), true)?>
<span id='<?php echo $span_id;?>' onclick="toggleFriendlyPermission('<?php echo $urlToggle?>')">
	<?php
		$actions = array();
		$button = array();
		$button['class'] = 'link crud_button '.CRUD_THEME.' sc_button_image_16';
		$button['permission_url'] = array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'toggle'.$model.'Permissions');
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