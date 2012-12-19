function add_daily_time_row(remove_label, available_parts, not_available_message, table_id, base_id, aux_name){	
	$("#"+table_id).find("td.no_item_td").parent().hide();
	$("#"+table_id).find("td.no_item_td").parent().addClass("no_item_tr");
	
	if(available_parts!=-1){
		//get the number of available parts for the equipment type related to the problem
		var number_of_parts= $(available_parts).size();
		
		//get the number of rows for the current order
		var number_of_rows= $("#"+table_id+" tbody tr:not(.no_item_tr)").size();
		
		if(number_of_rows>=number_of_parts){
			display_bouncebox_message("error_box", not_available_message, 0, 4000);
			return false;
		}	
	}
	
	var tr_base= $("#"+base_id+" tbody").html();
	var serial= $("#"+base_id).attr("serial");
	
	var value_location = 0;
	
	if(base_id == "tr_base_mileage")
	{
	  if(serial > 0)
	  {
	    if($("#DailyMileage"+serial+"RoundTrip").is(":checked"))
	    {
	      var value_location = $("#DailyMileage"+serial+"FromLocationId").val();
	    }
	    else
	    {
	      var value_location = $("#DailyMileage"+serial+"ToLocationId").val();
	    }
	  }
	}
	
	serial++;
	$("#"+base_id).attr("serial", serial);
	
	tr_base= tr_base.split("REPLACEME").join(serial);
	
	$("#"+table_id+" tbody").append(tr_base);
	
	if(value_location != 0)
	  $("#DailyMileage"+serial+"FromLocationId").val(value_location);
	
        
        initialize_basic_timepicker("#DailyTime"+serial+"HoursAll", { showPeriodLabels: false });
        
        initialize_change_minutes("#DailyTime"+serial+"HoursAll");
        
	/*$("#DailyTime"+serial+"HoursAll").timepicker({ 
			showPeriodLabels: false
		}
	);*/
	
	$(".crud_button.remove").qtip
	(
		{
			content: remove_label,
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

function toggle_order_box(button, order_id)
{
	if($("#order_div_"+order_id).hasClass("session_collapsed"))
	{
		//get the table outerHeight
		var new_height= $("#order_"+order_id).outerHeight();
		
		$("#order_div_"+order_id).stop().animate({height:new_height},{easing:'easeOutBounce'});
		$("#order_div_"+order_id).removeClass("session_collapsed");
		
		var img_src= $(button).find("img").attr("src");
		img_src= img_src.replace("expand", "collapse");
		$(button).find("img").attr("src", img_src);
	}
	else
	{
		$("#order_div_"+order_id).stop().animate({height:50},{easing:'easeOutBounce'});
		$("#order_div_"+order_id).addClass("session_collapsed");
		
		var img_src= $(button).find("img").attr("src");
		img_src= img_src.replace("collapse", "expand");
		$(button).find("img").attr("src", img_src);
	}
}

var check_timeouts= new Array();
function check_order_editable(part_order_id, url, display_message){
	if(display_message){
		show_loading();
	}
	$.ajax
	(
		{
			url: url,
			dataType: "json",
			success: function(m)
			{
				if(display_message){
					hide_loading();
				}
				if(m["status"]==-1)
				{
					$(".order_actions_"+part_order_id).hide();
					$(".check_order_editable_"+part_order_id).hide();
					
					if(!$.isEmptyObject(m["message"]) && display_message)
					{
						display_bouncebox_message(m["message"]["box_id"], m["message"]["text"], 10, 5000);
					}
					if(typeof check_timeouts[part_order_id]=="number"){
						clearTimeout(check_timeouts[part_order_id]);	
					}
				}
				else if(m["status"]==1)
				{
					$(".order_actions_"+part_order_id).show();
					$(".check_order_editable_"+part_order_id).hide();
					if(typeof check_timeouts[part_order_id]=="number"){
						clearTimeout(check_timeouts[part_order_id]);	
					}
					check_timeouts[part_order_id]= setTimeout("check_order_editable("+part_order_id+", '"+url+"', false)", 10000);
				}
				else
				{
					$(".order_actions_"+part_order_id).hide();
					$(".check_order_editable_"+part_order_id).show();
					
					if(!$.isEmptyObject(m["message"]) && display_message)
					{
						display_bouncebox_message(m["message"]["box_id"], m["message"]["text"], 10, 5000);
					}
					if(typeof check_timeouts[part_order_id]=="number"){
						clearTimeout(check_timeouts[part_order_id]);	
					}
				}
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				if(display_message){
					hide_loading();
				}
				handle_error(errorThrown);
			}
		}
	);
}

function remove_row_time(button, id)
{
  
  $.post('Timesheets/remove_daily_time', { id: id });
  
        $(".crud_button.remove").qtip("hide");
        
        //Need to find the parent table
        var parent_table= $(button).parents("table").first();
        
        //Remove the row
        $(button).parents("tr").first().detach();
        
        //Need to mark the class of the tr with the td.no_item_td
        parent_table.find("td.no_item_td").parent().addClass("no_item_tr");
        
        //Need to find the tr without the class no_item_tr
        if(parent_table.find("tbody tr:not(.no_item_tr)").size()==0){
                
                parent_table.find("tr.no_item_tr").show();
        }
}

function remove_row_mileage(button, id)
{
  
  $.post('Timesheets/remove_daily_mileage', { id: id });
  
        $(".crud_button.remove").qtip("hide");
        
        //Need to find the parent table
        var parent_table= $(button).parents("table").first();
        
        //Remove the row
        $(button).parents("tr").first().detach();
        
        //Need to mark the class of the tr with the td.no_item_td
        parent_table.find("td.no_item_td").parent().addClass("no_item_tr");
        
        //Need to find the tr without the class no_item_tr
        if(parent_table.find("tbody tr:not(.no_item_tr)").size()==0){
                
                parent_table.find("tr.no_item_tr").show();
        }
}

function load_location_by_route(route_id, url_base)
{
	if(typeof get_equipment_object=="object")
		get_equipment_object.abort();
    
	show_loading();
	get_equipment_objet= $.ajax
	(
		{
			url: url_base+"/"+route_id,
			type: "POST",
			cache: false,
			success: function(m)
			{
				$("#LocationId").find("option").detach();
				hide_loading();
				$("#LocationId").append(m);
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				hide_loading();
				handle_error(errorThrown);
			}
		}
	);
}