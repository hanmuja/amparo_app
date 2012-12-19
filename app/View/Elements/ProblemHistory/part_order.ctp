<div class="session_div <?php echo ($first)?"":"session_collapsed"?>" id="order_div_<?php echo $order["PartOrder"]["id"]?>" style="<?php echo ($first)?"":"height: 50px"?>">
	<table id="order_<?php echo $order["PartOrder"]["id"]?>" cellspacing="0" cellpadding="0" class="session_table problem_history_table">
		<tr>
			<td valign="top">
				<div class="problem_history_description">
					<div class="session_problem_history_description">
						<span class="session_creator_name" id="order_creator_<?php echo $order["PartOrder"]["id"]?>">
							<?php echo $order["Creator"]["first_name"]?>
						</span>
						<?php
							$qtip_options= array();
							$qtip_options['content']= $order["Creator"]["first_name"]." ".$order["Creator"]["last_name"]." ( ".$order["Creator"]["username"]." | ".$order["Creator"]["email"]." )";
							$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top left');
							$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
							$this->Js->buffer('$("#order_creator_'.$order["PartOrder"]["id"].'").qtip('.json_encode($qtip_options).');');
						?>
						<span id="order_created_<?php echo $order["PartOrder"]["id"]?>" class="session_created">
							<?php
								$created= $order["PartOrder"]["created"]; 
								$date= date('m-d-Y \a\t g:i a', $created)?>
							<?php echo __("Ordered on")." ".$date;?>
							<?php
								$qtip_options= array();
								$qtip_options['content']= date('l, F j, Y \a\t g:i a', $created);
								$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
								$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
								$this->Js->buffer('$("#order_created_'.$order["PartOrder"]["id"].'").qtip('.json_encode($qtip_options).');');
							?>
						</span>
						<?php $modified= $order["PartOrder"]["modified"];?>
						<?php if($modified!=$created):?>
							<span class="burgundy">|</span> <span id="order_modified_<?php echo $order["PartOrder"]["id"]?>" class="session_modified">
								<?php
									$date= date('m-d-Y \a\t g:i a', $modified)?>
								<?php echo __("Last updated on")." ".$date;?>
								<?php
									$qtip_options= array();
									$qtip_options['content']= date('l, F j, Y \a\t g:i a', $modified);
									$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
									$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
									$this->Js->buffer('$("#order_modified_'.$order["PartOrder"]["id"].'").qtip('.json_encode($qtip_options).');');
								?>
							</span>
						<?php endif;?>
						<div class="session_actions">
							<?php
								$actions= array();
								if(!$one[$model]["closed"] && !$one[$model]["retired"] && !$order['PartOrder']['closed'] && !$order['PartOrder']['in_process']){
									//FIRST_VERSION: For now any user can edit any part order
									//if($order["PartOrder"]["created_by"]==$this->Session->read("Auth.User.id")){
										$button= array();
										$html_options= array();
										$html_options["onclick"]= 'check_order_editable('.$order["PartOrder"]["id"].', "'.$this->Html->url(array("plugin"=>null, "controller"=>"PartOrders", "action"=>"check_editable", $order["PartOrder"]["id"])).'", true);';
										$button["html_options"]= $html_options;
										$button["class"]= "check_edit_order link crud_button ".CRUD_THEME." sc_button_gray session_action "."check_order_editable_".$order["PartOrder"]["id"];;
										$button["permission_url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"check_editable");
										$button["label"]= $this->Html->image("misc/pencil_field.png", array('align'=>'absmiddle'));
										$actions[]= $button;
									
									if($order["PartOrder"]["created_by"]==$this->Session->read("Auth.User.id") || $this->Utils->has_permission(array("plugin"=>null, "controller"=>"PartOrders", "action"=>"edit_all"))){
										$button= array();
										$dialog_options= array();
										$dialog_options["title"]= "'".__("Edit")." ".__("Order for Parts")."'";
										$dialog_options["width"]= 965;
										$button["dialog_options"]= $dialog_options;
										$button["class"]= "edit_order link crud_button ".CRUD_THEME." sc_button_gray session_action order_actions_".$order["PartOrder"]["id"];
										$button["url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"edit", $order["PartOrder"]["id"]);
										$button["label"]= $this->Html->image("crud/edit.gif", array('align'=>'absmiddle'));
										$actions[]= $button;
									}
									
									if($order["PartOrder"]["created_by"]==$this->Session->read("Auth.User.id") || $this->Utils->has_permission(array("plugin"=>null, "controller"=>"PartOrders", "action"=>"delete_all"))){	
										$options_link= array();
										$options_link["escape"]= false;
										$confirm= __('Are you sure you want to delete this %s from the database?', "Part Order");
										$button= array();
										$button["permission_url"]= array("plugin"=>null, "controller"=>"PartOrders", "action"=>"delete");
										$button["class"]= "delete_order link crud_button ".CRUD_THEME." sc_button_gray session_action order_actions_".$order["PartOrder"]["id"];
										$button["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>"PartOrders", "action"=>"delete", $order["PartOrder"]["id"], $one[$model]["id"]), $options_link, $confirm);
										$actions[]= $button;
									}
								}
								else
								{
									echo '<span id="part_order_msg">';
									if($one[$model]["retired"])
										echo "Trouble Ticket is Retired";
									elseif($one[$model]["closed"])
										echo "Trouble Ticket is Closed";
									elseif($order['PartOrder']['closed'])
										echo "Part Order is Closed";
									else
										echo "Part Order is In Process";
									echo '</span>';
								}

								$button= array();
								$html_options= array();
								$html_options["onclick"]= 'toggle_order_box(this, '.$order["PartOrder"]["id"].');';
								$button["html_options"]= $html_options;
								$button["class"]= "expand link crud_button ".CRUD_THEME." sc_button_gray session_action";
								$button["allowed"]= true;
								$button["label"]= $this->Html->image("problem_sessions/expand.png", array('align'=>'absmiddle'));
								$actions[]= $button;
								
								echo $this->CustomTable->button_group($actions);
							?>
						</div>
					</div>
					<div>
                    	<h4><?php echo __("Order Comments:")?></h4>
						<?php echo $order["PartOrder"]["description"]?>	
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<?php echo $this->element("PartOrder/available", array("order"=>$order))?>
				<?php echo $this->element("PartOrder/suggest_existing", array("order"=>$order))?>
				<?php echo $this->element("PartOrder/suggest_new", array("order"=>$order))?>
			</td>
		</tr>
	</table>
	<div class="scissor_div">
		<?php echo $this->Html->image("problem_sessions/scissors.png", array('align'=>'absmiddle'));?>
	</div>
</div>
<script>
	$(".order_actions_<?php echo $order["PartOrder"]["id"]?>").hide();
</script>
