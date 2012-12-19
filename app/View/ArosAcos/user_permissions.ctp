<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		display_bouncebox_message("<?php echo $manual_flash_type?>", "<?php echo $manual_flash?>", 100, 4000);
	</script>
	<?php exit;?>
<?php endif;?>
<?php if(!$is_ajax):?>
    <?php echo $this->Html->script("acl")?>
<?php endif;?>

<div class="acl_box">
  	<h4><?php echo $user["User"]["fullname"]?> <?php echo __("Permissions")?></h4>
 	<div class="acl_box_container">
		<?php if(isset($actions["app"]) && $actions["app"]):?>
			<table class="promana-head-button" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Action</th>
						<th style="text-align:center">Permission</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($actions["app"] as $controller_name=>$controller_actions):?>
						<?php foreach ($controller_actions as $aco_id=>$action):?>
							<?php 
								$permission= $action["permission"];
								$box_id= "permission_".$aco_id."_".$user_id;
								$display_path= str_replace(ACL_ACO_PATH_SEPARATOR, "->", $action["aco_path"]);
							?>
							<tr>
								<td><?php echo str_replace(ACL_ACO_PATH_SEPARATOR, "->", $action["aco_path"])?></td>
								<td style="text-align:center;">
									<span id="<?php echo $box_id?>" onclick="toggle_user_permission(<?php echo $aco_id?>, <?php echo $user_id?>, '<?php echo $action["aco_path"]?>', '<?php echo $this->Html->url("/")?>')">
										<?php 
											$image= ($permission)?PERMISSION_AUTHORIZED_IMAGE:PERMISSION_BLOCKED_IMAGE;
											$alt= ($permission)?__('Authorized', true):__("Blocked", true);
										
											$button= array();
											$button["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"toggle_user_permission");
											$button["class"]= "link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
											$button["label"]= $this->Html->image($image, array("align"=>"absmiddle", "alt"=>$alt));
											
											echo $this->CustomTable->button_group(array($button));
											
											$color= ($permission)?"red":"green";
											$text= ($permission)?__("Block"):__("Authorize");
										
											//Setup the tooltips
										    $qtip_options= array();
											$qtip_options['content']= $text." ".$display_path;
											$qtip_options['position']= array('my'=>'bottom right', 'at'=>'top center');
											$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-'.$color);
											$this->Js->buffer('$("#'.$box_id.' img").qtip('.json_encode($qtip_options).');');
										?>
									</span>
								</td>		
							</tr>
						<?php endforeach;?>
					<?php endforeach;?>
				</tbody>
			</table>
		<?php endif;?>
	</div>
</div>