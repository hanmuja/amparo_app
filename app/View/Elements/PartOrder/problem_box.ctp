<?php
	$model= "Problem";
?>
<div id="problem_main_div" class="problem_collapsed" style="height: 90px;">
	<table id="problem_table" class="problem_history_table" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" id="td_problem_description" colspan="2">
				<div class="problem_history_description">
					<div class="top_problem_history_description">
                        <span id="problem_title">
							<?php echo $one[$model]["name"]?>
						</span>
                        <span class="yellow">|</span>
                        <?php echo __("By")." ";?>
						<span class="problem_creator_name" id="problem_creator">
								<?php echo $one["Creator"]["first_name"]?>
							</span>
							<?php
								$qtip_options= array();
								$qtip_options['content']= $one["Creator"]["first_name"]." ".$one["Creator"]["last_name"]." ( ".$one["Creator"]["username"]." | ".$one["Creator"]["email"]." )";
								$qtip_options['position']= array('my'=>'bottom left', 'at'=>'top left');
								$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-dark');
								$this->Js->buffer('$("#problem_creator").qtip('.json_encode($qtip_options).');');
							?>
						<span id="problem_created">
							<?php
								$created= $one[$model]["created"]; 
								$date= date('m-d-Y \a\t g:i a', $created)?>
							<?php echo __("on")." ".$date;?>
							<?php
								$qtip_options= array();
								$qtip_options['content']= date('l, F j, Y \a\t g:i a', $created);
								$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
								$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-yellow');
								$this->Js->buffer('$("#problem_created").qtip('.json_encode($qtip_options).');');
							?>
						</span>
						<?php $modified= $one[$model]["modified"];?>
						<?php if($modified!=$created):?>
							<span class="yellow">|</span> <span id="problem_modified">
								<?php
									$date= date('m-d-Y \a\t g:i a', $modified)?>
								<?php echo __("Last modified on")." ".$date;?>
								<?php
									$qtip_options= array();
									$qtip_options['content']= date('l, F j, Y \a\t g:i a', $modified);
									$qtip_options['position']= array('my'=>'bottom center', 'at'=>'top center');
									$qtip_options['style']= array('classes'=>'ui-tooltip-shadow ui-tooltip-yellow');
									$this->Js->buffer('$("#problem_modified").qtip('.json_encode($qtip_options).');');
								?>
							</span>
						<?php endif;?>
						<span class="yellow">|</span> <?php echo __("Current Problem Type:")?>
						<span id="problem_type">
							<?php echo ($one["ProblemType"])?$one["ProblemType"]["name"]:""?>
						</span>
						<div class="problem_actions">
							<?php
								$actions= array();
								
								$button= array();
								$html_options= array();
								$html_options["onclick"]= 'toggle_problem_box(this);';
								$button["html_options"]= $html_options;
								$button["class"]= "expand link crud_button ".CRUD_THEME." sc_button_gray session_action";
								$button["allowed"]= true;
								$button["label"]= $this->Html->image("problem_sessions/expand.png", array('align'=>'absmiddle'));
								$actions[]= $button;
								
								echo $this->CustomTable->button_group($actions);
							?>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="td_description" valign="top">
				<div id="problem_description" class="description">
					<h3><?php echo __("Problem Description:")?></h3>
					<?php echo $one[$model]["description"]?>	
				</div>
				<?php if($this->Session->read("Auth.User.can_see_confidential") && !empty($one[$model]["confidential_description"])):?>
                    <div id="confidential_description" class="confidential">
                        <div class="description">
                            <h3><?php echo __("Confidential Description:")?></h3>
                            <?php echo $one[$model]["confidential_description"]?>	
                        </div>
                    </div>
				<?php endif;?>
			</td>
			<td id="td_problem_overview" valign="top" class="td_overview">
				<?php echo $this->element("ProblemHistory/problem_overview", array("one"=>$problem, "model"=>$model));?>
			</td>
		</tr>
	</table>
	<div class="scissor_div">
		<?php echo $this->Html->image("problem_sessions/scissors.png", array('align'=>'absmiddle'));?>
	</div>
</div>