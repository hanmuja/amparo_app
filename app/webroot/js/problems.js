var get_equipment_object;
var x;

function load_location_equipment(location_id, url_base, empty_label, not_empty_label, edit)
{
	if(location_id!="")
	{
		if(typeof get_equipment_object=="object")
			get_equipment_object.abort();
		
		show_loading();
		
		get_equipment_objet= $.ajax(
		{
			url: url_base+"/"+location_id+"/"+edit,
			type: "POST",
			cache: false,
			success: function(m)
			{
				$("#ProblemEquipmentId").find("option").detach();
				$("#ProblemEquipmentId").find("optgroup").detach();
				
				hide_loading();
				
				$("#ProblemEquipmentId").append(m);
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				hide_loading();
				handle_error(errorThrown);
			}
		}
		);
	}
	else
	{
		$("#ProblemEquipmentId").find("option").detach();
		var o = new Option(empty_label, '');            
		/// jquerify the DOM object 'o' so we can use the html method
		$(o).html(empty_label);
		$("#ProblemEquipmentId").append(o);     
	}
}

function load_location_equipment2(location_id, url_base, empty_label, not_empty_label)
{
	if(location_id!="")
	{
		if(typeof get_equipment_object=="object")
    	get_equipment_object.abort();
    	
    	show_loading();
    	get_equipment_objet= $.ajax
    	(
    		{
    			url: url_base+"/"+location_id,
    			dataType: "json",
	            type: "POST",
				cache: false,
	            success: function(m)
	            {
	            	$("#ProblemEquipmentId").find("option").detach();
	            	
	            	hide_loading();
	            	if(!$.isEmptyObject(m))
	            	{
	            		var o = new Option(not_empty_label, '');		
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(not_empty_label);
						$("#ProblemEquipmentId").append(o);
						
		                $.each
						(
							m,
							function (equipment_id, game_name)
							{
								var o = new Option(game_name, equipment_id);
								
								/// jquerify the DOM object 'o' so we can use the html method
								$(o).html(game_name);
								$("#ProblemEquipmentId").append(o);
							}
						);
					}
					else
					{
						var o = new Option(empty_label, '');		
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(empty_label);
						$("#ProblemEquipmentId").append(o);
					}
	            },
	            error: function(jqXHR, textStatus, errorThrown)
				{
					hide_loading();
					handle_error(errorThrown);
				}
    		}
    	);
	}
	else
	{
		$("#ProblemEquipmentId").find("option").detach();
        var o = new Option(empty_label, '');		
		/// jquerify the DOM object 'o' so we can use the html method
		$(o).html(empty_label);
		$("#ProblemEquipmentId").append(o);  	
	}
}

var edit_tip;
var add_tip;
var save_edit_tip;
var save_add_tip;
var select_tip;
var delete_tip;

function initialize_tips_labels(et, at, set, sat, st, dt)
{
	edit_tip= et;
	add_tip= at;
	save_edit_tip= set;
	save_add_tip= sat;
	select_tip= st;
	delete_tip= dt;
}

function add_qtips()
{
	$(".crud_button.editpt").qtip
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
	
	$(".crud_button.addpt").qtip
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
	
	$(".crud_button.saveaddpt").qtip
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
	
	$(".crud_button.saveeditpt").qtip
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
	
	$(".crud_button.selectpt").qtip
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
	
	$(".crud_button.deletept").qtip
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
		select.parent().find(".editpt").hide();
		select.parent().find(".deletept").hide();
	}
	else
	{
		select.parent().find(".editpt").show();
		select.parent().find(".deletept").show();
	}
}

function load_addpt_input(button)
{
	$("#AuxElmEditingProblemTypeId").val('0');
	
	var clon= $("#AuxElmAddPtName").parent().clone();
	clon.find("#AuxElmAddPtName").attr("name", "data[Problem][problem_type_name]");
	clon.find("#AuxElmAddPtName").attr("id", "ProblemProblemTypeName");
	$(button).parents(".input").html(clon.html());
	
	add_qtips();
}

function load_pt_select(button, url_base, empty_option)
{	
	$("#AuxElmEditingProblemTypeId").val('0');
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
				
				var clon= $("#AuxElmProblemTypeId").parent().clone();
				clon.find("#AuxElmProblemTypeId").attr("name", "data[Problem][problem_type_id]");
				clon.find("#AuxElmProblemTypeId").attr("id", "ProblemProblemTypeId");
				
				clon.find("select").html("");
				
				var o = new Option(empty_option, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(empty_option);
				clon.find("select").append(o);
				$.each
				(
					m,
					function (problem_type_id, problem_type_name)
					{
						var o = new Option(problem_type_name, problem_type_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(problem_type_name);
						clon.find("select").append(o);
					}
				);
				$(button).parents(".input").html(clon.html());
				
				display_proper_buttons($("#ProblemProblemTypeId"));
				add_qtips();
			},
			error: function(jqXHR, textStatus, errorThrown)
			{
				handle_error(errorThrown);
			}
		}
	);
}

function save_pt_input(button, url_base, empty_option)
{
	var problem_type_name= $("#ProblemProblemTypeName").val();
	var problem_type_id= $("#AuxElmEditingProblemTypeId").val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+problem_type_id+"/"+problem_type_name,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
                
				var clon= $("#AuxElmProblemTypeId").parent().clone();
				clon.find("#AuxElmProblemTypeId").attr("name", "data[Problem][problem_type_id]");
				clon.find("#AuxElmProblemTypeId").attr("id", "ProblemProblemTypeId");
				
				
				var current= m["current_pt"];
				var pts= m["pts"];
				
				clon.find("select").html("");
				
				var o = new Option(empty_option, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(empty_option);
				clon.find("select").append(o);
				$.each
				(
					pts,
					function (pt_id, pt_name)
					{
						var o = new Option(pt_name, pt_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(pt_name);
						clon.find("select").append(o);
					}
				);
				$(button).parents(".input").html(clon.html());
				$("#ProblemProblemTypeId").val(current);
                
				$("#AuxElmEditingProblemTypeId").val('0');
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

function load_editpt_input(button, url_base)
{
	var problem_type_id= $("#ProblemProblemTypeId").val();
	
	//Need to go to the server and get the game data
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+problem_type_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				if(!$.isEmptyObject(m))
				{
					hide_loading();
					var pt_name= m["name"];
                    
					var clon= $("#AuxElmEditPtName").parent().clone();
					clon.find("#AuxElmEditPtName").attr("name", "data[Problem][problem_type_name]");
					clon.find("#AuxElmEditPtName").attr("id", "ProblemProblemTypeName");
					
					$(button).parents(".input").html(clon.html());
					$("#ProblemProblemTypeName").val(pt_name);
					
					$("#AuxElmEditingProblemTypeId").val(m["id"]);
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

function delete_pt(button, confirm_message, url_base, empty_option)
{	
	if(!confirm(confirm_message))
	return false;
	
	var problem_type_id= $("#ProblemProblemTypeId").val();
	
	show_loading();
	$.ajax
	(
		{
			url: url_base+"/"+problem_type_id,
			dataType: 'json',
			cache: false,
			success: function(m)
			{
				hide_loading();
				
				$("#ProblemProblemTypeId").html("");
				
				var o = new Option(empty_option, '');
						
				/// jquerify the DOM object 'o' so we can use the html method
				$(o).html(empty_option);
				$("#ProblemProblemTypeId").append(o);
				
				var current= m["current_pt"];
				var pts= m["pts"];
				$.each
				(
					pts,
					function (problem_type_id, problem_type_name)
					{
						var o = new Option(problem_type_name, problem_type_id);
						
						/// jquerify the DOM object 'o' so we can use the html method
						$(o).html(problem_type_name);
						$("#ProblemProblemTypeId").append(o);
					}
				);
				
				$("#ProblemProblemTypeId").val(current);
				display_proper_buttons($("#ProblemProblemTypeId"));
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

function define_show_hide_image(value_comparator_separator, show_label, hide_label){
	var current= $("#FiltersProblemsProblemClosed").val();
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

function define_show_hide_image_retired(value_comparator_separator, show_label, hide_label){
        var current= $("#FiltersProblemsProblemRetired").val();
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


function show_hide_closed_problem(button, parent_div, url_base, value_comparator_separator, show_label, hide_label)
{
	var current= $("#FiltersProblemsProblemClosed").val();
	var qtip_content;
	var qtip_color;
	
	//is visible, so hide
	if(current=="" || current==("1"+value_comparator_separator+"equal")){
		$("#FiltersProblemsProblemClosed").val("0"+value_comparator_separator+"equal");	
		
		//change the image to show
		var current_src= $(button).find("img").attr("src");
		current_src= current_src.replace("hide", "show");
		$(button).find("img").attr("src", current_src);
		qtip_content= show_label;
		qtip_color= "green";
	}
	
	else{
		$("#FiltersProblemsProblemClosed").val("");
			
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

function show_hide_retired_problem(button, parent_div, url_base, value_comparator_separator, show_label, hide_label)
{
        var current= $("#FiltersProblemsProblemRetired").val();
        var qtip_content;
        var qtip_color;
        
        //is visible, so hide
        if(current=="" || current==("1"+value_comparator_separator+"equal")){
                $("#FiltersProblemsProblemRetired").val("0"+value_comparator_separator+"equal"); 
                
                //change the image to show
                var current_src= $(button).find("img").attr("src");
                current_src= current_src.replace("hide", "show");
                $(button).find("img").attr("src", current_src);
                qtip_content= show_label;
                qtip_color= "green";
        }
        
        else{
                $("#FiltersProblemsProblemRetired").val("");
                        
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
