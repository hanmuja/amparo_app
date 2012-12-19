<div class="session_div <?php echo ($first)?"":"session_collapsed"?> <?php echo ($session["ProblemSession"]["is_confidential"])?"confidential":"";?>" id="session_div_<?php echo $session["ProblemSession"]["id"]?>" style="<?php echo ($first)?"":"height: 50px"?>">
	<table id="session_<?php echo $session["ProblemSession"]["id"]?>" cellspacing="0" cellpadding="0" class="session_table problem_history_table">
		<tr>
			<td valign="top">
				<div class="problem_history_description">
					<div class="session_problem_history_description">
						<span class="session_creator_name" id="session_creator_<?php echo $session["ProblemSession"]["id"]?>">
							<?php echo $session["Creator"]["first_name"]?>
						</span>
						<?php
							$qtip_options= array();
							$qtip_options['content']= $session["Creator"]["first_name"]." ".$session["Creator"]["last_name"]." ( ".$session["Creator"]["username"]." | ".$session["Creator"]["email"]." )";
							$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top left');
							$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
							$this->Js->buffer('$("#session_creator_'.$session["ProblemSession"]["id"].'").qtip('.json_encode($qtip_options).');');
						?>
						<span id="session_created_<?php echo $session["ProblemSession"]["id"]?>" class="session_created">
							<?php
								$created= $session["ProblemSession"]["created"]; 
								$date= date('m-d-Y \a\t g:i a', $created)?>
							<?php echo __("posted this update on")." ".$date;?>
							<?php
								$qtip_options= array();
								$qtip_options['content']= date('l, F j, Y \a\t g:i a', $created);
								$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
								$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
								$this->Js->buffer('$("#session_created_'.$session["ProblemSession"]["id"].'").qtip('.json_encode($qtip_options).');');
							?>
						</span>
						<?php $modified= $session["ProblemSession"]["modified"];?>
						<?php if($modified!=$created):?>
							<span class="burgundy">|</span> <span id="session_modified_<?php echo $session["ProblemSession"]["id"]?>" class="session_modified">
								<?php
									$date= date('m-d-Y \a\t g:i a', $modified)?>
								<?php echo __("Last modified on")." ".$date;?>
								<?php
									$qtip_options= array();
									$qtip_options['content']= date('l, F j, Y \a\t g:i a', $modified);
									$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
									$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
									$this->Js->buffer('$("#session_modified_'.$session["ProblemSession"]["id"].'").qtip('.json_encode($qtip_options).');');
								?>
							</span>
						<?php endif;?>
						<span class="burgundy">|</span> <?php echo __("Problem Type:")?>
						<span class="session_problem_type">
							<?php echo ucwords(($session["ProblemType"])?$session["ProblemType"]["name"]:"")?>
						</span>
						<div class="session_actions">
							<?php
								$actions= array();
								if(!$one[$model]["closed"] && !$one[$model]["retired"]){
									
									//FIRST_VERSION: For now any user can edit any session
									if($session["ProblemSession"]["created_by"]==$this->Session->read("Auth.User.id") || $this->Utils->has_permission(array("plugin"=>null, "controller"=>"ProblemSessions", "action"=>"edit_all"))){	
										$button= array();
										$dialog_options= array();
										$dialog_options["title"]= "'".__("Edit")." ".__("Session")."'";
										$dialog_options["width"]= 965;
										$button["dialog_options"]= $dialog_options;
										$button["class"]= "edit_session link crud_button ".CRUD_THEME." sc_button_gray session_action";
										$button["url"]= array("plugin"=>null, "controller"=>"ProblemSessions", "action"=>"edit", $session["ProblemSession"]["id"]);
										$button["label"]= $this->Html->image("crud/edit.gif", array('align'=>'absmiddle'));
										$actions[]= $button;
									}
									if($session["ProblemSession"]["created_by"]==$this->Session->read("Auth.User.id") || $this->Utils->has_permission(array("plugin"=>null, "controller"=>"ProblemSessions", "action"=>"delete_all"))){
										
										$options_link= array();
										$options_link["escape"]= false;
										$confirm= __('Are you sure you want to delete this %s from the database?', "Session");
										$button= array();
										$button["permission_url"]= array("plugin"=>null, "controller"=>"ProblemSessions", "action"=>"delete");
										$button["class"]= "delete_session link crud_button ".CRUD_THEME." sc_button_gray session_action";;
										$button["inner_html"]= $this->Form->postLink($this->Html->image(DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>"ProblemSessions", "action"=>"delete", $session["ProblemSession"]["id"]), $options_link, $confirm);
										$actions[]= $button;
									}
								}
								$button= array();
								$html_options= array();
								$html_options["onclick"]= 'toggle_session_box(this, '.$session["ProblemSession"]["id"].');';
								$button["html_options"]= $html_options;
								$button["class"]= "expand link crud_button ".CRUD_THEME." sc_button_gray session_action";
								$button["allowed"]= true;
								$button["label"]= $this->Html->image("problem_sessions/expand.png", array('align'=>'absmiddle'));
								$actions[]= $button;

								$button= array();
								$button["class"]= "plane crud_button ".CRUD_THEME." sc_button_plane session_action_white";
								$button["allowed"]= true;
								$button["label"]= __("#")." ".$session_number;
								$actions[]= $button;
								
								echo $this->CustomTable->button_group($actions);
							?>
						</div>
					</div>
					<div class="session_problem_history_description_content">
						<?php echo $session["ProblemSession"]["description"]?>	
					</div>
				</div>
			</td>
		</tr>
	</table>
	<div class="scissor_div">
		<?php echo $this->Html->image("problem_sessions/scissors.png", array('align'=>'absmiddle'));?>
	</div>
</div>