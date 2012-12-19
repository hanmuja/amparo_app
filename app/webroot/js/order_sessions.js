var edit_tip;
var add_tip;
var save_edit_tip;
var save_add_tip;
var select_tip;
var delete_tip;

function initialize_tips_labels(et, at, set, sat, st, dt){
	edit_tip= et;
	add_tip= at;
	save_edit_tip= set;
	save_add_tip= sat;
	select_tip= st;
	delete_tip= dt;
}

function add_qtips(){
	$(".crud_button.editos").qtip
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
	
	$(".crud_button.addos").qtip
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
	
	$(".crud_button.saveaddos").qtip
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
	
	$(".crud_button.saveeditos").qtip
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
	
	$(".crud_button.selectos").qtip
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
	
	$(".crud_button.deleteos").qtip
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


//Display the proper buttons in the problem type selection
function display_proper_buttons(select)
{
	
	var value= select.val();
	if(value=='')
	{
		select.parent().find(".editos").hide();
		select.parent().find(".deleteos").hide();
	}
	else
	{
		select.parent().find(".editos").show();
		select.parent().find(".deleteos").show();
	}
}

function load_addos_input(button)
{
	$("#AuxElmEditingOrderStatusId").val('0');
	
	var clon= $("#AuxElmAddOsName").parent().clone();
	clon.find("#AuxElmAddOsName").attr("name", "data[PartOrderComponent][order_status_name]");
	clon.find("#AuxElmAddOsName").attr("id", "PartOrderComponentOrderStatusName");
	$(button).parents(".input").html(clon.html());
	
	add_qtips();
}

function load_os_select(button, url_base, emosy_oosion)
{	
	$("#AuxElmEditingOrderStatusId").val('0');
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
				
				var clon= $("#AuxElmOrderStatusId").parent().clone();
				clon.find("#AuxElmOrderStatusId").attr("name", "data[PartOrderComponent][order_status_id]");
				clon.find("#AuxElmOrderStatusId").attr("id", "PartOrderComponentOrderStatusId");
				
				clon.find("select").html("");
				
				var o = new Option(emosy_oosion, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(emosy_oosion);
				clon.find("select").append(o);
				$.each
				(
					m,
					function (order_status_id, order_status_name)
					{
						var o = new Option(order_status_name, order_status_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(order_status_name);
						clon.find("select").append(o);
					}
				);
				$(button).parents(".input").html(clon.html());
				
				display_proper_buttons($("#PartOrderComponentOrderStatusId"));
				add_qtips();
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function save_os_input(button, url_base, emosy_oosion)
{
	var order_status_name= $("#PartOrderComponentOrderStatusName").val();
	var order_status_id= $("#AuxElmEditingOrderStatusId").val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+order_status_id+"/"+order_status_name,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				var clon= $("#AuxElmOrderStatusId").parent().clone();
				clon.find("#AuxElmOrderStatusId").attr("name", "data[PartOrderComponent][order_status_id]");
				clon.find("#AuxElmOrderStatusId").attr("id", "PartOrderComponentOrderStatusId");
				
				
				var current= m["current_os"];
				var oss= m["oss"];
				
				clon.find("select").html("");
				
				var o = new Option(emosy_oosion, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(emosy_oosion);
				clon.find("select").append(o);
				$.each
				(
					oss,
					function (os_id, os_name)
					{
						var o = new Option(os_name, os_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(os_name);
						clon.find("select").append(o);
					}
				);
				$(button).parents(".input").html(clon.html());
				$("#PartOrderComponentOrderStatusId").val(current);
				
				$("#AuxElmEditingOrderStatusId").val('0');
				add_qtips();
				
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

function load_editos_input(button, url_base)
{
	var order_status_id= $("#PartOrderComponentOrderStatusId").val();
	
	//Need to go to the server and get the game data
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+order_status_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				if(!$.isEmptyObject(m))
				{
					hide_loading();
					var os_name= m["name"];
	
					var clon= $("#AuxElmEditOsName").parent().clone();
					clon.find("#AuxElmEditOsName").attr("name", "data[PartOrderComponent][order_status_name]");
					clon.find("#AuxElmEditOsName").attr("id", "PartOrderComponentOrderStatusName");
					
					$(button).parents(".input").html(clon.html());
					$("#PartOrderComponentOrderStatusName").val(os_name);
					
					$("#AuxElmEditingOrderStatusId").val(m["id"]);
					add_qtips();
				}	
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function delete_os(button, confirm_message, url_base, emosy_oosion)
{	
	if(!confirm(confirm_message))
	return false;
	
	var order_status_id= $("#PartOrderComponentOrderStatusId").val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+order_status_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				$("#PartOrderComponentOrderStatusId").html("");
				
				var o = new Option(emosy_oosion, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(emosy_oosion);
				$("#PartOrderComponentOrderStatusId").append(o);
				
				var current= m["current_os"];
				var oss= m["oss"];
				$.each
				(
					oss,
					function (order_status_id, order_status_name)
					{
						var o = new Option(order_status_name, order_status_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(order_status_name);
						$("#PartOrderComponentOrderStatusId").append(o);
					}
				);
				
				$("#PartOrderComponentOrderStatusId").val(current);
				display_proper_buttons($("#PartOrderComponentOrderStatusId"));
				add_qtips();
				
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