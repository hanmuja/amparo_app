<?php echo $this->Html->script("acl")?>
<div class="acl_box">
  	<h4><?php echo __("Roles")?>: <?php echo  __('Set Permissions for all actions on each role'); ?></h4>
 	<div class="acl_box_container">
		<table class="promana-head-button no_header" cellspacing="0" width="100%">
			<tbody>
				<?php foreach ($roles as $role_id=>$role):?>
					<tr>
						<td><?php echo $role?></td>
						<td>
							<?php
								$button= array();
								$button["class"]= "add link crud_button sc_crud_top ".CRUD_THEME." sc_button_green sc_button_image_22";
								$button["url"]= array("plugin"=>null, "controller"=>"aros_acos", "action"=>"role_authorize_all", $role_id);
								$button["label"]= __("Authorize all actions"); 
								
								echo $this->CustomTable->button_group(array($button));
							?>
						</td>
						<td>
							<?php
								$button= array();
								$button["class"]= "add link crud_button sc_crud_top ".CRUD_THEME." sc_button_red sc_button_image_22";
								$button["url"]= array("plugin"=>null, "controller"=>"aros_acos", "action"=>"role_block_all", $role_id);
								$button["label"]= __("Block all actions"); 
								
								echo $this->CustomTable->button_group(array($button));
							?>
						</td>
					</tr>
				<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>

<div class="acl_box">
  	<h4><?php echo __("Roles")?>: <?php echo  __('Set Permissions for individual actions on each role'); ?></h4>
 	<div class="acl_box_container">
		<?php if(isset($actions["app"]) && $actions["app"]):?>
			<table class="promana-head-button" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Action</th>
						<?php foreach($roles as $role_id=>$role):?>
							<th style="text-align:center"><?php echo $role?></th>
						<?php endforeach;?>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($actions["app"] as $controller_name=>$controller_actions):?>
						<?php foreach ($controller_actions as $aco_id=>$action):?>
							<?php
								$display_path= str_replace(ACL_ACO_PATH_SEPARATOR, "->", $action["aco_path"]);
							?>
							<tr>
								<td><?php echo $display_path ?></td>
								<?php foreach ($roles as $role_id=>$role):?>
									<?php 
										$permission= $action["permissions"][$role];
										$box_id= "permission_".$aco_id."_".$role_id;
									?>
									<td style="text-align:center;">
										<span id="<?php echo $box_id?>" onclick="toggle_role_permission(<?php echo $aco_id?>, <?php echo $role_id?>, '<?php echo $action["aco_path"]?>', '<?php echo $this->Html->url("/")?>')">
											<?php 
												$image= ($permission)?PERMISSION_AUTHORIZED_IMAGE:PERMISSION_BLOCKED_IMAGE;
												$alt= ($permission)?__('Authorized', true):__("Blocked", true);
											
												$button= array();
												$button["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"toggle_role_permission");
												$button["class"]= "link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_22";
												$button["label"]= $this->Html->image($image, array("align"=>"absmiddle", "alt"=>$alt));
												
												echo $this->CustomTable->button_group(array($button));
												
												$color= ($permission)?"red":"green";
												$text= ($permission)?__("Block"):__("Authorize");
											
												//Setup the tooltips
											    $qtip_options= array();
												$qtip_options['content']= $text." ".$display_path." ".__("for")." ".$role;
												$qtip_options['position']= array('my'=>'bottom right', 'at'=>'top center');
												$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-'.$color);
												$this->Js->buffer('$("#'.$box_id.' img").qtip('.json_encode($qtip_options).');');
											?>
										</span>
									</td>
								<?php endforeach;?>		
							</tr>
						<?php endforeach;?>
					<?php endforeach;?>
				</tbody>
			</table>
		<?php endif;?>
	</div>
</div>