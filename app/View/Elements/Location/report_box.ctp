<div id="problem_main_div" style="height: 130px; margin-bottom: 10px; float: none;">
	<table id="problem_table" class="problem_history_table" cellspacing="0" cellpadding="0">
		<tr>
			<td valign="top" id="td_problem_description" colspan="2">
				<div class="problem_history_description">
					<div class="top_problem_history_description">
                        <span id="problem_title">
							<?php echo __("Location Report") ?> <?php echo $this->Utils->getTitleByDateRange($this->data['Problem']['from'], $this->data['Problem']['to']) ?>
								<?php //echo $one["Creator"]["fullname"]?>
							</span>
						<div class="problem_actions">
							<?php
							/*if($one['Week']['finalized']) {
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
								
								//echo $this->CustomTable->button_group($actions);
							}*/
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
                      <h2><?php echo $one[$model]['name'] ?></h2>
                    </div>
                    <div style="float:right; margin: 0 30px;">
                      <p style="font-size:110%">
                      <?php
                      echo $this->Html->tag('span', __("Total Downtime:"), array('style' => 'font-weight:bold;'))." ".$this->Utils->seconds_to_string($totals)."<br />";
                      $array_ids = out_of_order_ids();
					  foreach($array_ids as $id => $name):
						  $text = isset($totals_by_location['totals_by_problem_id'][$id]) ?  $this->Utils->seconds_to_string($totals_by_location['totals_by_problem_id'][$id]) : "0";
						  echo $this->Html->tag('span', __("Total ".$name.":"), array('style' => 'font-weight:bold;'))." ".$text."<br />";
					  endforeach;
					  echo $this->Html->tag('span', __("Total in Parts:"), array('style' => 'font-weight:bold;'))." ".$this->Number->currency($total_parts, 'USD');
                      ?><br />
                      </p>
                    </div>
                  </div>
			</td>
			<td id="td_problem_overview" valign="top" class="td_overview">
               <div class="div_overview">
				<p>
                    <?php echo $this->Html->tag('span', __("Route:"), array('style' => 'font-weight:bold;'))." ".$one['Route']['name']; ?><br />
				</p>
             </div>
			</td>
		</tr>
	</table>
</div>