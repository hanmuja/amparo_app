<?php if(!$is_ajax):?>
    <?php echo $this->Dialog->headers()?>
    <div id='<?php echo $controller?>'>
<?php endif;?>

<?php 
    if ($paginated || !$is_ajax) {
		$buttons = array();
		
		$table_actions = array();
		
		$dialog_options = array();
		$dialog_options['title'] = '"'.__('Add %s', $item).'"';
		$dialog_options['width'] = 500;
		
		$button = array();
		$options = array();
		$options['id'] = 'button_add';
		$button['class'] = 'add link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_16';
		$button['dialog_options'] = $dialog_options;
		$button['html_options'] = $options;
		$button['url'] = array('plugin'=>null, 'controller'=>$controller, 'action'=>'add');
		$button['label'] = $this->Html->image('crud/small/plus.png', array('align'=>'absmiddle'));
		$table_actions[] = $button;
		
		$button= array();
		$button['class']= "import link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button['permission_url']= array('plugin'=>null, 'controller'=>$controller, 'action'=>'import');
		$options= array();
		$options['escape']= false;
		$confirm= __('Are you sure you want to import friendly permissions tables, this delete all your permissions?', $item);
		$button['inner_html']= $this->Form->postLink($this->Html->image('crud/dbimport.png', array('align'=>'absmiddle')), array('plugin'=>null, 'controller'=>$controller, 'action'=>'import'), $options, $confirm);
		$table_actions[]= $button;
		
		$button= array();
		$button['class']= "export link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
		$button['permission_url']= array('plugin'=>null, 'controller'=>$controller, 'action'=>'export');
		$options= array();
		$options['escape']= false;
		$confirm= __('Are you sure you want to export friendly permissions tables, this delete all permissions in server?', $item);
		$button['inner_html']= $this->Form->postLink($this->Html->image('crud/dbexport.png', array('align'=>'absmiddle')), array('plugin'=>null, 'controller'=>$controller, 'action'=>'export'), $options, $confirm);
		$table_actions[]= $button;
		
		$ths= array();
		$ths[]= array('label'=>ACTIONS_LABEL);
		$ths[]= array('label'=>$item, 'sortable'=> true, 'filterable'=> true, 'field'=>$model.'.name');
		$ths[]= array('label'=>__('Active'), 'sortable'=> true, 'field'=>$model.'.active');
    }
		
	$trs= array();
	foreach ($all as $one) {
		$tr= array();
		
		$actions= array();
		
		$button= array();
		$options= array();
		$options['escape']= false;
		$button['html_options']= $options;
		$button['class']= "paths link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button['url']= array('plugin' => null, 'controller' => $controller, 'action' => 'paths', $one[$model]['id']);
		$button['label']= $this->Html->image('crud/edit_list.png', array('align'=>'absmiddle'));
		$actions[]= $button;
		
		$dialog_options= array();
		$dialog_options["title"]= "'".__('Edit %s', $item)."'";
		$dialog_options["width"]= 500;
		
		$options = array();
		$button = array();
		$button['class'] = 'edit link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_22';
		$button['dialog_options'] = $dialog_options;
		$button['html_options'] = $options;
		$button['url'] = array('plugin' => null, 'controller' => $controller, 'action' => 'edit', $one[$model]['id']);
		$button['label'] = $this->Html->image('crud/edit.gif', array('align'=>'absmiddle'));
		$actions[]= $button;
		
		$dialog_options= array();
		$dialog_options["title"]= "'".__('Copy %s', $item)."'";
		$dialog_options["width"]= 500;
		
		$options = array();
		$button = array();
		$button['class'] = 'copy link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_22';
		$button['dialog_options'] = $dialog_options;
		$button['html_options'] = $options;
		$button['url'] = array('plugin' => null, 'controller' => $controller, 'action' => 'copy', $one[$model]['id']);
		$button['label'] = $this->Html->image('crud/copy.png', array('align'=>'absmiddle'));
		$actions[]= $button;
		
		$button = array();
		if ($one[$model]['active']) {
			
			$options= array();
			$options['escape']= false;
			$confirm= __('Are you sure you want to inactivate this %s?', $item);
			$button['class']= "active link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
			$button['permission_url']= array('plugin'=>null, 'controller'=>$controller, 'action'=>'inactivate');
			$button['inner_html']= $this->Form->postLink($this->Html->image('crud/active.png', array('align'=>'absmiddle')), array('plugin'=>null, 'controller'=>$controller, 'action'=>'inactivate', $one[$model]['id']), $options, $confirm);
		} else {
			$options= array();
			$options['escape']= false;
			$confirm= __('Are you sure you want to activate this %s and deactivate the current one?', $item);
			$button['class']= "inactive link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
			$button['permission_url']= array('plugin'=>null, 'controller'=>$controller, 'action'=>'activate');
			$button['inner_html']= $this->Form->postLink($this->Html->image('crud/inactive.png', array('align'=>'absmiddle')), array('plugin'=>null, 'controller'=>$controller, 'action'=>'activate', $one[$model]['id']), $options, $confirm);
		}
		$actions[]= $button;
		
		$button= array();
		$button['class']= "delete link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button['permission_url']= array('plugin'=>null, 'controller'=>$controller, 'action'=>'delete');
		
		$options= array();
		$options['escape']= false;
		$confirm= __('Are you sure you want to delete this %s from the database?', $item);
		$button['inner_html']= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array('align'=>'absmiddle')), array('plugin'=>null, 'controller'=>$controller, 'action'=>'delete', $one[$model]['id']), $options, $confirm);
        $actions[]= $button;
				
		$actions_buttons= $this->CustomTable->button_group($actions);
		
		$tr[]= array($actions_buttons, array('class'=>'actions', 'width'=>'125px'));		
		$tr[]= $one[$model]['name'];
		$tr[]= array(($one[$model]['active'])?__('Yes'):__('No'), array('width'=>'50px'));
		
		$trs[]= $tr;
	}
	
    if($paginated || !$is_ajax) {
		echo $this->CustomTable->table (
			$controller, 
			array (
				'ths'=>$ths,
				'trs'=>$trs,
				'buttons'=>$buttons,
				'table_actions'=> $table_actions
			),
			array (
				'parent_div'=>$controller,
				'class_table'=>"promana-head-button",
				'message_empty'=>__("No item found."),
                'use_ajax'=>true,
                'clear_filters'=>true
                //'images_paginator'=>images_paginator()
			)
		);
    } else {
        echo $this->CustomTable->table_filter (
			$controller,
            $trs,
			array (
				'parent_div'=>$controller
				//'images_paginator'=>images_paginator()
			)
		);
    }
	
	//Setup the tooltips
    $qtip_options= array();
	$qtip_options['content']= __('Edit %s', $item);
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.edit").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Edit Paths');
	$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top center');
	$this->Js->buffer('$(".crud_button.paths").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Inactivate %s', $item);
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.active").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Activate %s', $item);
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.inactive").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Delete')." ".$item." ".__("from Database");
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-red');
	$this->Js->buffer('$(".crud_button.delete").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Add')." ".$item;
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-green');
	$this->Js->buffer('$(".crud_button.add").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Import Databases Friendly Permissions');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-yellow');
	$this->Js->buffer('$(".crud_button.import").qtip('.json_encode($qtip_options).');');
	
	$qtip_options['content']= __('Export Databases Friendly Permissions');
	$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-yellow');
	$this->Js->buffer('$(".crud_button.export").qtip('.json_encode($qtip_options).');');
?>

<?php if(!$is_ajax):?>
    </div>
<?php endif;?>