<div id="problem_main_div" style="height: 130px; margin-bottom: 10px; float: none;">
	<table id="problem_table" class="problem_history_table" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" id="td_problem_description" colspan="2">
				<div class="problem_history_description">
					<div class="top_problem_history_description">
                        <span id="problem_title">
							<?php echo __("Week")." ".$one['Week']['week_number'] ?> <span class="yellow">|</span> <?php echo date('F d, Y', $one['Week']['initial_date'])." ".__("to")." ".date('F d, Y', $one['Week']['final_date']); ?>
                        	<span class="yellow">|</span>
								<?php echo $one["User"]["fullname"]?>
							</span>
						<div class="problem_actions">
							<?php
							if($one['Week']['finalized']) {
								$actions= array();
								
								$button= array();
								$html_options= array();
								$html_options["onclick"]= "return confirm('Are you sure you want to Un-Finalize this week?');";
								$html_options["escape"]= false;
								$button["html_options"]= $html_options;
								$button["permission_url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"unfinalize");
								$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"unfinalize", $one['Week']['id']);
								$button["class"]= "unfinalize link crud_button ".CRUD_THEME." sc_button_gray session_action";
								$button["allowed"]= false;
								$button["label"]= $this->Html->image("crud/undo.png", array('align'=>'absmiddle'));
								$actions[]= $button;
								
								echo $this->CustomTable->button_group($actions);
							}
							?>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="td_description" valign="top">
				<div id="problem_description">
					<div style="float:left; margin: 10px 30px 0 30px;">
                      <h2>JFH Technologies <?php echo __("Time Sheet") ?></h2>
                    </div>
                    <div style="float:right; margin: 0 30px;">
                      <p style="font-size:110%">
                      <?php echo $this->Html->tag('span', __("Total Hours:"), array('style' => 'font-weight:bold;'))." ".$totals['hours']['total']; ?><br />
                      <?php echo $this->Html->tag('span', __("Total Miles:"), array('style' => 'font-weight:bold;'))." ".$totals['mileages']['total']; ?><br />
                      <?php echo $this->Html->tag('span', __("Total Tolls:"), array('style' => 'font-weight:bold;'))." ".$this->Number->currency($totals['tolls']['total'], 'USD'); ?><br />
                      </p>
                    </div>
                  </div>
			</td>
			<td id="td_problem_overview" valign="top" class="td_overview">
               <div class="div_overview">
				<p>
                    <?php echo $this->Html->tag('span', __("Name:"), array('style' => 'font-weight:bold;'))." ".$one['User']['first_name']." ".$one['User']['last_name']; ?><br />
                    <?php echo $this->Html->tag('span', __("Employee Number:"), array('style' => 'font-weight:bold;'))." ".$one['User']['employee_number']; ?><br />
                    <?php echo $this->Html->tag('span', __("Username:"), array('style' => 'font-weight:bold;'))." ".$one['User']['username']; ?><br />
                    <?php echo $this->Html->tag('span', __("Phone Number:"), array('style' => 'font-weight:bold;'))." ".$one['User']['phone']; ?><br />
                    <?php echo $this->Html->tag('span', __("Email:"), array('style' => 'font-weight:bold;'))." ".$one['User']['email']; ?>
				</p>
             </div>
			</td>
		</tr>
	</table>
</div>