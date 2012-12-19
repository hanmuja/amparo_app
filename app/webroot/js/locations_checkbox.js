function reload_children(route_id)
{
	var parent_name= "route_"+route_id;
	
	//The parent
	var parent= $("#"+parent_name);
	
	//The children
	var children= $("."+parent_name);
	
	//All the children must end with the same checked state than its parent.
	var checked_state= parent.is(":checked"); 
	
	children.each
	(
		function()
		{
			$(this).attr("checked", checked_state);
		}
	);
        
        reload_all();
}

function reload_parent(route_id)
{
	var parent_name= "route_"+route_id;
	
	//The parent
	var parent= $("#"+parent_name);
	
	//The children
	var children= $("."+parent_name);
	
	//If all children are checked, check the parent, if not not :P
	var checked_state= true;
	children.each
	(
		function()
		{
			if(!$(this).is(":checked"))
			{
				checked_state= false;
			}
		}
	);
	
	parent.attr("checked", checked_state);
        
        reload_all();
}