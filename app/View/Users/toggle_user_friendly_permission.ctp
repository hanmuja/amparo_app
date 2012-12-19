<script>
	<?php 
		$permission= $box["permission"];
		$span_id= "permission_".$bg_name."_".$box_id."_".$id;
		$display_path= $box["label"];
		
		//button
		$image= ($permission)?PERMISSION_AUTHORIZED_IMAGE:PERMISSION_BLOCKED_IMAGE;
		$alt= ($permission)?__('Authorized', true):__("Blocked", true);
		
		//qtip
		$color= ($permission)?"red":"green";
		$text= ($permission)?__("Block"):__("Authorize");
		
		$button= array();
		$button["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"toggle_user_friendly_permission");
		$button["class"]= "link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
		$button["label"]= $this->Html->image($image, array("align"=>"absmiddle", "alt"=>$alt));
		
		$new_html= $this->CustomTable->button_group(array($button));
	?>
	$("#<?php echo $span_id?>").html('<?php echo $new_html?>');
	
	<?php
		//Setup the tooltips
	    $qtip_options= array();
		$qtip_options['content']= $text." '".$display_path."'";
		$qtip_options['position']= array('my'=>'bottom right', 'at'=>'top center');
		$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-'.$color);
	?>
	
	$("#<?php echo $span_id?> img").qtip(<?php echo json_encode($qtip_options)?>);
</script>