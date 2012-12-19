<?php if($permissions):?>
	<script>
		<?php foreach($permissions as $box_id=> $permission):?>
			<?php $image= ($permission)?PERMISSION_AUTHORIZED_IMAGE:PERMISSION_BLOCKED_IMAGE;?>
			<?php $alt= ($permission)?__('Authorized', true):__("Blocked", true);?>
			<?php
				$button= array();
				$button["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"toggle_role_permission");
				$button["class"]= "link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
				$button["label"]= $this->Html->image($image, array("align"=>"absmiddle", "alt"=>$alt));
				
				$new_html= $this->CustomTable->button_group(array($button));
			?>		
							
			$("#<?php echo $box_id?>").html('<?php echo $new_html?>');
			
			<?php
				$display_path= str_replace(ACL_ACO_PATH_SEPARATOR, "->", $aco_path);
				$color= ($permission)?"red":"green";
				$text= ($permission)?__("Block"):__("Authorize");
			
				//Setup the tooltips
			    $qtip_options= array();
				$qtip_options['content']= $text." ".$display_path." ".__("for")." ".$role["Role"]["name"];
				$qtip_options['position']= array('my'=>'bottom right', 'at'=>'top center');
				$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-'.$color);
			?>
			$("#<?php echo $box_id?> img").qtip(<?php echo json_encode($qtip_options)?>);
		<?php endforeach;?>
	</script>
<?php endif;?>