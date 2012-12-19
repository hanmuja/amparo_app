function define_show_hide_image_retired(value_comparator_separator, show_label, hide_label){
        var current= $("#FiltersEquipmentTypesEquipmentTypeRetired").val();
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

function show_hide_retired_equipment_type(button, parent_div, url_base, value_comparator_separator, show_label, hide_label)
{
        var current= $("#FiltersEquipmentTypesEquipmentTypeRetired").val();
        var qtip_content;
        var qtip_color;
        
        //is visible, so hide
        if(current=="" || current==("1"+value_comparator_separator+"equal")){
                $("#FiltersEquipmentTypesEquipmentTypeRetired").val("0"+value_comparator_separator+"equal"); 
                
                //change the image to show
                var current_src= $(button).find("img").attr("src");
                current_src= current_src.replace("hide", "show");
                $(button).find("img").attr("src", current_src);
                qtip_content= show_label;
                qtip_color= "green";
        }
        
        else{
                $("#FiltersEquipmentTypesEquipmentTypeRetired").val("");
                        
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
