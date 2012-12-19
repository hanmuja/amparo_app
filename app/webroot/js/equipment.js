//Display the proper buttons in the game selection
function display_proper_buttons(select)
{
	var value= select.val();
	
	if(value=='')
	{
		select.parent().find(".editgame").hide();
		select.parent().find(".deletegame").hide();
	}
	else
	{
		select.parent().find(".editgame").show();
		select.parent().find(".deletegame").show();
	}
}


function load_addgame_input(button, edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip)
{
	$("#AuxElmEditingGameId").val('0');
	
	var clon= $("#AuxElmAddGameName").parent().clone();
	clon.find("#AuxElmAddGameName").attr("name", "data[Equipment][game_name]");
	clon.find("#AuxElmAddGameName").attr("id", "EquipmentGameName");
	$(button).parents(".input").html(clon.html());
	
	add_qtips(edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip);
}

function load_editgame_input(button, url_base, edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip)
{
	var game_id= $("#EquipmentGameId").val();
	
	//Need to go to the server and get the game data
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+game_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				if(!$.isEmptyObject(m))
				{
					hide_loading();
					var game_name= m["name"];
	
					var clon= $("#AuxElmEditGameName").parent().clone();
					clon.find("#AuxElmEditGameName").attr("name", "data[Equipment][game_name]");
					clon.find("#AuxElmEditGameName").attr("id", "EquipmentGameName");
					
					$(button).parents(".input").html(clon.html());
					$("#EquipmentGameName").val(game_name);
					
					$("#AuxElmEditingGameId").val(m["id"]);
					add_qtips(edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip);
				}	
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function delete_game(button, confirm_message, url_base, empty_option, edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip)
{	
	if(!confirm(confirm_message))
	return false;
	
	var game_id= $("#EquipmentGameId").val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+game_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				$("#EquipmentGameId").html("");
				
				var o = new Option(empty_option, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(empty_option);
				$("#EquipmentGameId").append(o);
				
				var current= m["current_game"];
				var games= m["games"];
				$.each
				(
					games,
					function (game_id, game_name)
					{
						var o = new Option(game_name, game_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(game_name);
						$("#EquipmentGameId").append(o);
					}
				);
				
				$("#EquipmentGameId").val(current);
				display_proper_buttons($("#EquipmentGameId"));
				add_qtips(edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip);
				
				if(!$.isEmptyObject(m["message"]))
				{
					display_bouncebox_message(m["message"]["box_id"], m["message"]["text"], 100, 4000)
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}


function save_game_input(button, url_base, empty_option, edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip)
{
	var game_name= $("#EquipmentGameName").val();
	var game_id= $("#AuxElmEditingGameId").val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+game_id+"/"+game_name,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				var clon= $("#AuxElmGameId").parent().clone();
				clon.find("#AuxElmGameId").attr("name", "data[Equipment][game_id]");
				clon.find("#AuxElmGameId").attr("id", "EquipmentGameId");
				
				
				var current= m["current_game"];
				var games= m["games"];
				
				clon.find("select").html("");
				
				var o = new Option(empty_option, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(empty_option);
				clon.find("select").append(o);
				$.each
				(
					games,
					function (game_id, game_name)
					{
						var o = new Option(game_name, game_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(game_name);
						clon.find("select").append(o);
					}
				);
				$(button).parents(".input").html(clon.html());
				$("#EquipmentGameId").val(current);
				
				$("#AuxElmEditingGameId").val('0');
				add_qtips(edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip);
				
				if(!$.isEmptyObject(m["message"]))
				{
					display_bouncebox_message(m["message"]["box_id"], m["message"]["text"], 100, 4000)
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function load_game_select(button, url_base, empty_option, edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip)
{	
	$("#AuxElmEditingGameId").val('0');
	show_loading();
	$.ajax
	(
		{
			url: url_base,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				var clon= $("#AuxElmGameId").parent().clone();
				clon.find("#AuxElmGameId").attr("name", "data[Equipment][game_id]");
				clon.find("#AuxElmGameId").attr("id", "EquipmentGameId");
				
				clon.find("select").html("");
				
				var o = new Option(empty_option, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(empty_option);
				clon.find("select").append(o);
				$.each
				(
					m,
					function (game_id, game_name)
					{
						var o = new Option(game_name, game_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(game_name);
						clon.find("select").append(o);
					}
				);
				$(button).parents(".input").html(clon.html());
				
				display_proper_buttons($("#EquipmentGameId"));
				add_qtips(edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip);
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}


function add_qtips(edit_tip, add_tip, save_edit_tip, save_add_tip, select_tip, delete_tip)
{
	$(".crud_button.editgame").qtip
	(
		{
			content: edit_tip,
			position:
			{
				my: 'bottom center',
				at: 'top center'
			}
		}
	);
	
	$(".crud_button.addgame").qtip
	(
		{
			content: add_tip,
			position:
			{
				my: 'bottom center',
				at: 'top center'
			},
			style:
			{
				classes:'ui-tooltip-shadow ui-tooltip-green'
			}
		}
	);
	
	$(".crud_button.saveaddgame").qtip
	(
		{
			content: save_add_tip,
			position:
			{
				my: 'bottom center',
				at: 'top center'
			},
			style:
			{
				classes:'ui-tooltip-shadow ui-tooltip-green'
			}
		}
	);
	
	$(".crud_button.saveeditgame").qtip
	(
		{
			content: save_edit_tip,
			position:
			{
				my: 'bottom center',
				at: 'top center'
			},
			style:
			{
				classes:'ui-tooltip-shadow ui-tooltip-green'
			}
		}
	);
	
	$(".crud_button.selectgame").qtip
	(
		{
			content: select_tip,
			position:
			{
				my: 'bottom center',
				at: 'top center'
			},
			style:
			{
				classes:'ui-tooltip-shadow ui-tooltip-blue'
			}
		}
	);
	
	$(".crud_button.deletegame").qtip
	(
		{
			content: delete_tip,
			position:
			{
				my: 'bottom center',
				at: 'top center'
			},
			style:
			{
				classes:'ui-tooltip-shadow ui-tooltip-red'
			}
		}
	);
}

function define_show_hide_image(value_comparator_separator, show_label, hide_label){
	var current= $("#FiltersEquipmentEquipmentRetired").val();
	var qtip_content;
	var qtip_color;
	//is visible
	if(current=="" || current==("1"+value_comparator_separator+"equal")){
		var current_src= $("#showhide_button").find("img").attr("src");
		current_src= current_src.replace("REPLACEME", "hide");
		$("#showhide_button").find("img").attr("src", current_src);
		qtip_content= hide_label;
		qtip_color= "red";
	}
	else{	
		var current_src= $("#showhide_button").find("img").attr("src");
		current_src= current_src.replace("REPLACEME", "show");
		$("#showhide_button").find("img").attr("src", current_src);
		qtip_content= show_label;
		qtip_color= "green";
	}
	
	$("#showhide_button").qtip(
		{
			"content": qtip_content,
			"position":{
				"my":"bottom left",
				"at":"top center"
			},
			"style":{
				"classes":"ui-tooltip-shadow ui-tooltip-"+qtip_color
			}
		}
	);
}

function show_hide_retired_equipment(button, parent_div, url_base, value_comparator_separator, show_label, hide_label)
{
	var current= $("#FiltersEquipmentEquipmentRetired").val();
	var qtip_content;
	var qtip_color;
	//is visible, so hide
	if(current=="" || current==("1"+value_comparator_separator+"equal")){
		$("#FiltersEquipmentEquipmentRetired").val("0"+value_comparator_separator+"equal");
		
		//change the image to show
		var current_src= $(button).find("img").attr("src");
		current_src= current_src.replace("hide", "show");
		$(button).find("img").attr("src", current_src);
		qtip_content= show_label;
		qtip_color= "green";
	}
	else{
		$("#FiltersEquipmentEquipmentRetired").val("");	
		var current_src= $(button).find("img").attr("src");
		current_src= current_src.replace("show", "hide");
		$(button).find("img").attr("src", current_src);
		qtip_content= hide_label;
		qtip_color= "red";
	}
	
	$(button).qtip(
		{
			"content": qtip_content,
			"position":{
				"my":"bottom left",
				"at":"top center"
			},
			"style":{
				"classes":"ui-tooltip-shadow ui-tooltip-"+qtip_color
			}
		}
	);
	
	filtrar(parent_div, url_base);
}
