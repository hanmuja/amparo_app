function define_show_hide_image_retired(value_comparator_separator, show_label, hide_label){
        var current= $("#FiltersUsersUserRetired").val();
        var qtip_content;
        var qtip_color;
        //is visible
        if(current=="" || current==("1"+value_comparator_separator+"equal")){
                var current_src= $("#showhide_button1").find("img").attr("src");
                current_src= current_src.replace("REPLACEME", "hide");
                $("#showhide_button1").find("img").attr("src", current_src);
                qtip_content= hide_label;
                qtip_color= "red";
        }
        else{   
                var current_src= $("#showhide_button1").find("img").attr("src");
                current_src= current_src.replace("REPLACEME", "show");
                $("#showhide_button1").find("img").attr("src", current_src);
                qtip_content= show_label;
                qtip_color= "green";
        }
        
        $("#showhide_button1").qtip(
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

function show_hide_retired_users(button, parent_div, url_base, value_comparator_separator, show_label, hide_label)
{
        var current= $("#FiltersUsersUserRetired").val();
        var qtip_content;
        var qtip_color;
        
        //is visible, so hide
        if(current=="" || current==("1"+value_comparator_separator+"equal")){
                $("#FiltersUsersUserRetired").val("0"+value_comparator_separator+"equal"); 
                
                //change the image to show
                var current_src= $(button).find("img").attr("src");
                current_src= current_src.replace("hide", "show");
                $(button).find("img").attr("src", current_src);
                qtip_content= show_label;
                qtip_color= "green";
        }
        
        else{
                $("#FiltersUsersUserRetired").val("");
                        
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


function add_folder_row(remove_label, table_id, base_id, value, dialog_id, i){
	
	var noexist = true;
	
	var j = 0;
	
	var count_inputs = $('input[type=hidden][name*="id"]');
	
	while($("#User" + j + "FoldersFolder").size() > 0 || j<(count_inputs*2))
	{
		if($("#User" + j + "FoldersFolder").val() == value)
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
			
			$("#User" + serial + "FoldersFolder").val(value);
			
			$("#User" + serial + "FoldersFolder_label").append(value);
			
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
			$("#User" + i + "FoldersFolder").val(value);
			$("#User" + i + "FoldersFolder_label").html("");
			$("#User" + i + "FoldersFolder_label").append(value);
		}
		
		$("#"+dialog_id).dialog("close");
	}
}

function edit_folder_row(table_id, base_id, parent_path, oldv, newv, dialog_id){
	
	var j = 0;
	
	var count_inputs = $('input[type=hidden][name*="id"]');
	
	while($("#User" + j + "FoldersFolder").size() > 0 || j<(count_inputs*2))
	{
		var str = $("#User" + j + "FoldersFolder").val();
		
		var oldp = parent_path + '/' + oldv;
		var newp = parent_path + '/' + newv;
		
		if(str.indexOf(oldp) >= 0)
		{
			var result = str.replace(oldp, newp);
			$("#User" + j + "FoldersFolder").val(result);
			$("#User" + j + "FoldersFolder_label").html("");
			$("#User" + j + "FoldersFolder_label").append(result);
		}
		
		j++;
	}
}

function remove_folder_row(path){
	
	var j = 0;
	
	var count_inputs = $('input[type=hidden][name*="id"]');
	
	while($("#User" + j + "FoldersFolder").size() > 0 || j<(count_inputs*2))
	{
		var str = $("#User" + j + "FoldersFolder").val();
		if(str.indexOf(path) >= 0)
		{
			var button = $("#User" + j + "FoldersFolder").parent().parent().find(".remove").find(".crud_button_inner");
			
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

  // File Picker modification for FCK Editor v2.0 - www.fckeditor.net
 // by: Pete Forde <pete@unspace.ca> @ Unspace Interactive
 var urlobj;

 function BrowseServer(obj)
 {
      urlobj = obj;
      OpenServerBrowser(
      '/Filemanager/index.html',
      screen.width * 0.7,
      screen.height * 0.7 ) ;
 }

 function OpenServerBrowser( url, width, height )
 {
      var iLeft = (screen.width - width) / 2 ;
      var iTop = (screen.height - height) / 2 ;
      var sOptions = "toolbar=no,status=no,resizable=yes,dependent=yes" ;
      sOptions += ",width=" + width ;
      sOptions += ",height=" + height ;
      sOptions += ",left=" + iLeft ;
      sOptions += ",top=" + iTop ;
      var oWindow = window.open( url, "BrowseWindow", sOptions ) ;
 }

 function SetUrl( url, width, height, alt )
 {
      document.getElementById(urlobj).value = url ;
      oWindow = null;
 }
