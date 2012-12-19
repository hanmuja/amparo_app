function toggle_role_permission(aco_id, role_id, aco_path, app_root_url)
{
	var url = app_root_url + "ArosAcos/toggle_role_permission/" + role_id + "/" + aco_path + "/"+aco_id;
	var box_id= 'permission_'+aco_id+'_'+role_id;
	
	show_loading();
	$.ajax
	(
		{	
			url: url,
			dataType: "html", 
			cache: false,
			success: function (data, textStatus) 
			{
				hide_loading();
				$("#" + box_id).html(data);
			},
			complete: function()
			{
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}
	
function toggle_user_permission(aco_id, user_id, aco_path, app_root_url)
{
	var url = app_root_url + "ArosAcos/toggle_user_permission/" + user_id + "/" + aco_path + "/"+aco_id;
	var box_id= 'permission_'+aco_id+'_'+user_id;
	
	show_loading();
	$.ajax
	(
		{	
			url: url,
			dataType: "html", 
			cache: false,
			success: function (data, textStatus) 
			{
				hide_loading();
				$("#" + box_id).html(data);
			},
			complete: function()
			{
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function toggle_friendly_role_permission(box_role_name, box_id, role_id, app_root_url)
{
	var url = app_root_url + "Roles/toggle_role_friendly_permission/" + role_id + "/" + box_role_name + "/"+box_id;
	var span_id= 'permission_'+box_role_name+'_'+box_id+'_'+role_id;
	
	show_loading();
	$.ajax
	(
		{	
			url: url,
			dataType: "html", 
			cache: false,
			success: function (data, textStatus) 
			{
				hide_loading();
				$("#" + span_id).html(data);
			},
			complete: function()
			{
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function toggle_friendly_user_permission(box_role_name, box_id, user_id, app_root_url)
{
	var url = app_root_url + "Users/toggle_user_friendly_permission/" + user_id + "/" + box_role_name + "/"+box_id;
	var span_id= 'permission_'+box_role_name+'_'+box_id+'_'+user_id;
	
	show_loading();
	$.ajax
	(
		{	
			url: url,
			dataType: "html", 
			cache: false,
			success: function (data, textStatus) 
			{
				hide_loading();
				$("#" + span_id).html(data);
			},
			complete: function()
			{
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}
