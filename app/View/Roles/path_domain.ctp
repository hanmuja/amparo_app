<?php echo $this->Form->input('folder', array('type' => 'hidden', 'default' => '/')); ?>

<?php
	$buttons= array();

	$options= array();
	/*$options["before"]= "show_loading();lock_dialog();";
	$options["success"]= "hide_loading();";
	$options["error"]= "handle_error(errorThrown);";
	$options["update"]= "#".$this->Dialog->id;*/
	$options["escape"]= false;
	
	$button= array();
	$button["permission_url"]= array("plugin"=>null, "controller"=>"Folders", "action"=>"create_folder");
	$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_burgundy";
	$button["inner_html"]= $this->Js->link(__("Create"), "#", array('id' => 'add'));
	$buttons[]= $button;
	
	$button= array();
	$button["permission_url"]= array("plugin"=>null, "controller"=>"Folders", "action"=>"rename_folder");
	$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_blue";
	$button["inner_html"]= $this->Js->link(__("Rename"), "#", array('id' => 'rename'));
	$buttons[]= $button;
	
	$button= array();
	$button["permission_url"]= array("plugin"=>null, "controller"=>"Folders", "action"=>"remove_folder");
	$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_red";
	$button["inner_html"]= $this->Js->link(__("Delete"), "#", array('id' => 'remove'));
	$buttons[]= $button;
	
	$button= array();
	$button["permission_url"]= array("plugin"=>null, "controller"=>"Folders", "action"=>"select_folder");
	$button["class"]= "select link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
	$button["inner_html"]= $this->Js->link(__("Select"), "#", array('id' => 'select'));
	$buttons[]= $button;
	
	echo $this->CustomTable->buttons(array($buttons));
?>

<br />

<?php echo $this->Html->div('marg_bottom20', null, array('id' => 'folders')); ?>

<script>
$(function () {
	$("#folders").jstree({ 
		"json_data" : {
			"data" : <?php echo json_encode($x) ?>,
			"progressive_render" : true
		},
		"plugins" : [ "themes", "json_data", "ui", "contextmenu", "crrm" ],
		"contextmenu" : {
			"items" : {
				"ccp" : false,
				<?php if(!$this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'create_folder'))): ?>
				"create" : false,
				<?php
				endif;
				if(!$this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'rename_folder'))):
				?>
				"rename" : false,
				<?php
				endif;
				if(!$this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'remove_folder'))):
				?>
				"remove" : false,
				<?php
				endif;
				if($this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'select_folder'))):
				?>
				"send" : {
					"label" : "Select",
					"action" : function(obj) { select_folder() },
					"separator_before" : true,
				}
				<?php endif; ?>
			}
			
		}
	})
	.bind("create.jstree", function (e, data) {
		$.post(
			"<?php echo $this->Html->url(array('plugin' => null, 'controller' => 'Folders', 'action' => 'create_folder')) ?>", 
			{
				"id" : data.rslt.parent.attr("id"),
				"parent_path": data.rslt.parent.attr("path"), 
				"position" : data.rslt.position,
				"title" : data.rslt.name,
			}, 
			function (r) {
				if(r.status) {
					$(data.rslt.obj).attr("id", r.id);
					$(data.rslt.obj).attr("path", r.path);
				}
				else {
					alert("Error to create folder.");
					$.jstree.rollback(data.rlbk);
				}
			},
			"json"
		);
	})
	.bind("rename.jstree", function(e, data){
		$.post(
			"<?php echo $this->Html->url(array('plugin' => null, 'controller' => 'Folders', 'action' => 'rename_folder')) ?>", 
			{
				"id" : data.rslt.obj.attr("id"),
				"path": data.rslt.obj.attr("path"), 
				"new_name" : data.rslt.new_name,
				"parent_path" : data.rslt.obj.parent().parent().attr("path"),
			}, 
			function (r) {
				if(r.status) {
					$(data.rslt.obj).attr("id", r.id);
					$(data.rslt.obj).attr("path", r.path);
					edit_folder_row('new_folder_table', 'tr_base_folder', data.rslt.obj.parent().parent().attr('path'), data.rslt.old_name,data.rslt.new_name, '<?php echo SHORTCUTS_DIALOG_DIV ?>');
				}
				else {
					alert("Error to rename folder.");
					$.jstree.rollback(data.rlbk);
				}
			},
			"json"
		);
	})
	.bind("remove.jstree", function(e, data){
		if(confirm('Are you sure?'))
		{
			$.post(
				"<?php echo $this->Html->url(array('plugin' => null, 'controller' => 'Folders', 'action' => 'remove_folder')) ?>", 
				{
					"id" : data.rslt.obj.attr("id"),
					"path" : data.rslt.obj.attr("path"),
				}, 
				function (r) {
					if(r.status) {
						remove_folder_row(data.rslt.obj.attr("path"));
					}
					else {
						alert("Error to delete folder.");
						$.jstree.rollback(data.rlbk);
					}
				},
				"json"
			);
		}
		else
			$.jstree.rollback(data.rlbk);
	})
	.bind("select_node.jstree", function (e, data){
		
		$('#folder').val(data.rslt.obj.attr('path'));
		
	})
	;
});

<?php if($this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'create_folder'))): ?>

$(function () { 
	$("#add").click(function () {
		$("#folders").jstree("create");
	});
});

<?php
endif;
if($this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'rename_folder'))):
?>

$(function () { 
	$("#rename").click(function () {
		$("#folders").jstree("rename");
	});
});

<?php
endif;
if($this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'remove_folder'))):
?>

$(function () { 
	$("#remove").click(function () {
		$("#folders").jstree("remove");
	});
});

<?php
endif;
if($this->Utils->has_permission(array('plugin' => null, 'controller' => 'Folders', 'action' => 'select_folder'))):
?>

$(function () { 
	$("#select").click(function () {
		select_folder();
	});
});

<?php endif; ?>

setTimeout(function() { $("#folders").jstree("set_focus"); }, 200);

setTimeout(function() { $("#folders").jstree("open_all"); }, 500);

setTimeout(function() { $.jstree._focused().select_node("#_"); }, 800);

function select_folder()
{
	var value = $('#folder').val();
	$("#RolePathDomain").val(value);
	$("#<?php echo SHORTCUTS_DIALOG_DIV ?>").dialog("close");
}

</script>