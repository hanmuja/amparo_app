<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php if(isset($url_redirect)):?>
			<?php echo $this->Js->request($url_redirect, array("update"=>"#$controller"));?>
		<?php else:?>
			<?php if(isset($message_otf)):?>
				display_bouncebox_message('<?php echo $message_otf["box_id"]?>', '<?php echo $message_otf["text"]?>', 10, 5000);
			<?php endif;?>
		<?php endif;?>
	</script>
	<?php exit;?>
<?php endif;?>


<?php echo $this->Utils->form_section(__("Folders"));?>

<?php $this->Js->buffer('
$("#submit_folders").click(function(e){
	var x = $(\'input[name="data[AuxElm][process]"]:checked\').val();
	if(x != 1){
		if(!confirm("You are about to overwrite the Visible Folders Permissions for All users in this Role. Do you want to continue?")){
			e.stopImmediatePropagation();
		}
	}
});
')?>

<?php echo $this->Form->create($model);?>
<?php
$table_actions= array();

$remove_label= __("Remove Row");

$buttons= array();

$table_actions= array();
$button= array();
$dialog_options= array();
$dialog_options["title"]= "'".__("Select a Folder")."'";
$dialog_options["width"]= 600;
$dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
$button["dialog_options"]= $dialog_options;
$button["class"]= "add link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"select_folder");
$button["label"]= $this->Html->image("crud/small/plus.png", array("align"=>"absmiddle"));
$table_actions[]= $button;
$first_label= $this->CustomTable->button_group($table_actions);


$ths= array();
$ths[]= array("label"=>$first_label);
$ths[]= array("label"=>__("Folder"));

$trs= array();
if(count($folders > 0)){
	foreach($folders as $i=>$folder){
		$tr= array();
		
		$actions= array();
		
		$button= array();
		$dialog_options= array();
		$dialog_options["title"]= "'".__("Select a Folder")."'";
		$dialog_options["width"]= 600;
		$dialog_options["dialog_id"]= SHORTCUTS_DIALOG_DIV;
		$button["dialog_options"]= $dialog_options;
		$button["class"]= "edit link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"select_folder", $i);
		$button["label"]= $this->Html->image("crud/edit.gif", array("align"=>"absmiddle"));
		$actions[] = $button;
		
		$options= array();
		$options["onclick"]= "remove_row(this)";
		$button= array();
		$button["allowed"]= true;
		$button["class"]= "remove link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button["html_options"]= $options;
		$button["label"]= $this->Html->image("crud/remove.gif", array("align"=>"absmiddle"));
		$actions[]= $button;
		
		$actions_buttons= $this->CustomTable->button_group($actions);
		$tr[]= array($actions_buttons, array("class"=>"actions", "width"=>"60px"));
		$tr[]= $this->Form->input("$i.DefaultFolders.id").
			$this->Form->input("$i.DefaultFolders.folder", array("label"=>false, "type"=>'hidden', 'div' => array('class' => 'input text two_column'))).
			$this->Form->label("$i.DefaultFolders.folder", $this->data[$model][$i]['DefaultFolders']['folder'], array("id" => "Role".$i."DefaultFoldersFolder_label"));
		$trs[]= $tr;
	}
}

?>

<div class="form_section_body">
	<?php
	echo $this->CustomTable->table
	(
		$controller, 
		array
		(
			"ths"=>$ths,
			"trs"=>$trs,
			"buttons"=>$buttons
		),
		array
		(
			"id"=>"new_folder_table",
			"parent_div"=>"Roles",
			"class_table"=>"promana-head-button",
			"message_empty"=>__("No item found."),
            "use_ajax"=>true,
			"width"=>"100%",
            "include_paginator"=>false
		)
	); 
	?>
</div>

<?php echo $this->Js->submit(__("Update Permissions"), array("id"=>"submit_folders", "type"=>"POST", "class"=>"sc_button sc_button_green", "div" => array("class" => "submit two_column"), "update"=>"#full_permissions_inner", "before"=>"show_loading();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
<div class="two_column" style="float: right;">
  <div class="two_column">
    <?php echo $this->Form->input("AuxElm.process", array('type' => 'radio', 'options' => array('1'=>__('Set Initial Folders'), '2'=>__('Overwrite Affected Users'), '3'=>__('Both')), "legend"=>false, 'value'=>1, "div"=>array("class"=>"input two_column radio check_inline")))?>
  </div>
</div>
<?php echo $this->Form->end();?>

<?php echo $this->element("Role/bases")?>

<script>
	$("#submit_folders").click(function(event){
		//alert("antes");
		event.preventDefault();
	});
</script>