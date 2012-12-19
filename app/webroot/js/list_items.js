function create_sortable(){
	$("#items").sortable
	(
		{
			items: "div.item_box",
			axis: "y",
			containment: "parent",
			cursor: "move",
			stop: function (e, u)
			{
				show_loading();
				$.ajax
				(
					{
						data:$("#items_order_form").serialize(), 
						dataType:"html", 
						error:function (XMLHttpRequest, textStatus, errorThrown) 
						{
							handle_error(errorThrown);
						}, 
						success:function (data, textStatus) 
						{
							hide_loading();
						}, 
						type:"post", 
						url:$("#items_order_form").attr("action")
					}
				);
			}
		}
	);
}

var edit_tip;
var save_tip;
var delete_tip;
function initialize_items_tips_labels(et, st, dt)
{
	edit_tip= et;
	save_tip= st;
	delete_tip= dt;
}

function add_qtips()
{
	$(".crud_button.edit_item").qtip
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
	
	$(".crud_button.save_item").qtip
	(
		{
			content: save_tip,
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
	
	$(".crud_button.delete_item").qtip
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


function load_edit_item_input(button, url_base)
{
	var list_item_id= $(button).parents(".item_buttons").first().attr("item_id");
	
	//Need to go to the server and get the game data
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+list_item_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				if(!$.isEmptyObject(m))
				{
					hide_loading();
					var item_name= m["name"];
	
					var clon= $("#AuxElmName").clone();
					clon.attr("style", "");
					clon.val(item_name);
					clon.attr("id", "ListItemName"+list_item_id);
					
					$("#item_label_"+list_item_id).html(clon);
					
					var clon_buttons= $("#buttons2").clone();
					$("#item_buttons_"+list_item_id).html(clon_buttons.html());
					
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

function delete_item(button, confirm_message, url_base)
{	
	if(!confirm(confirm_message))
	return false;
	
	var list_item_id= $(button).parents(".item_buttons").first().attr("item_id");
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+list_item_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				if(m["status"]==1)
				{
					var div_detach= "item_box_"+m["list_item_id"];
					$("#"+div_detach).detach();
				}
				
				if(!$.isEmptyObject(m["message"]))
				{
					display_bouncebox_message(m["message"]["box_id"], m["message"]["text"], 100, 4000);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function save_item_input(button, url_base)
{
	var list_item_id= $(button).parents(".item_buttons").first().attr("item_id");
	var name= $("#ListItemName"+list_item_id).val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+list_item_id+"/"+name,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				if(m["status"]==1)
				{
					var label= m["label"];
					$("#item_label_"+list_item_id).html(label);
					
					var clon_buttons= $("#buttons1").clone();
					$("#item_buttons_"+list_item_id).html(clon_buttons.html());
					
					add_qtips();
				}
				
				if(!$.isEmptyObject(m["message"]))
				{
					display_bouncebox_message(m["message"]["box_id"], m["message"]["text"], 100, 4000);
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function check_submit(input, key){
	//If enter pressed
	if(key==13){
		var box= $(input).parents(".item_box").first();
		box.find("div.save_item").find("img").click();
		return false;
	}
}
