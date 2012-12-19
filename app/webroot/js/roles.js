function add_folder_row(remove_label, table_id, base_id, value, dialog_id, i){
	
	var noexist = true;
	
	var j = 0;
	
	var count_inputs = $('input[type=hidden][name*="id"]');
	
	while($("#Role" + j + "DefaultFoldersFolder").size() > 0 || j<(count_inputs*2))
	{
		if($("#Role" + j + "DefaultFoldersFolder").val() == value)
		{
			noexist = false;
			break;
		}
		
		j++;
	}
	
	if(!noexist)
		alert('The folder is already selected');
	else
	{
		if(i === false)
		{	
			$("#"+table_id).find("td.no_item_td").parent().hide();
			$("#"+table_id).find("td.no_item_td").parent().addClass("no_item_tr");
			
			var number_of_rows= $("#"+table_id+" tbody tr:not(.no_item_tr)").size();
			
			var tr_base= $("#"+base_id+" tbody").html();
			var serial= $("#"+base_id).attr("serial");
			
			serial++;
			$("#"+base_id).attr("serial", serial);
			
			tr_base= tr_base.split("REPLACEME").join(serial);
			
			$("#"+table_id+" tbody").append(tr_base);
			
			$("#Role" + serial + "DefaultFoldersFolder").val(value);
			
			$("#Role" + serial + "DefaultFoldersFolder_label").append(value);
			
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
		else
		{
			$("#Role" + i + "DefaultFoldersFolder").val(value);
			$("#Role" + i + "DefaultFoldersFolder_label").html("");
			$("#Role" + i + "DefaultFoldersFolder_label").append(value);
		}
		
		$("#"+dialog_id).dialog("close");
	}
}

function edit_folder_row(table_id, base_id, parent_path, oldv, newv, dialog_id){
	
	var j = 0;
	
	var count_inputs = $('input[type=hidden][name*="id"]');
	
	while($("#Role" + j + "DefaultFoldersFolder").size() > 0 || j<(count_inputs*2))
	{
		var str = $("#Role" + j + "DefaultFoldersFolder").val();
		
		var oldp = parent_path + '/' + oldv;
		var newp = parent_path + '/' + newv;
		
		if(str.indexOf(oldp) >= 0)
		{
			var result = str.replace(oldp, newp);
			$("#Role" + j + "DefaultFoldersFolder").val(result);
			$("#Role" + j + "DefaultFoldersFolder_label").html("");
			$("#Role" + j + "DefaultFoldersFolder_label").append(result);
		}
		
		j++;
	}
}

function remove_folder_row(path){
	
	var j = 0;
	
	var count_inputs = $('input[type=hidden][name*="id"]');
	
	while($("#Role" + j + "DefaultFoldersFolder").size() > 0 || j<(count_inputs*2))
	{
		var str = $("#Role" + j + "DefaultFoldersFolder").val();
		if(str.indexOf(path) >= 0)
		{
			var button = $("#Role" + j + "DefaultFoldersFolder").parent().parent().find(".remove").find(".crud_button_inner");
			
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
		
		j++;
	}
}