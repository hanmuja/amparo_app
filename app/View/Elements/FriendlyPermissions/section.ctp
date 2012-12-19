<table class='fp_section' cellpadding='0' cellspacing='0'>
	<tbody>
		<tr>
			<td valign='top' colspan='100%' class='fp_section_name'>
				<span class='title'><?php echo $section['FriendlyPermissionsItem']['name']?></span>
				<div class="section_actions">
					<?php
						$actions = array();
						
						$expandImage = 'expand';
						if ($this->Session->check('PathsOpenState.'.$section['FriendlyPermissionsItem']['id'])) {
							if ($this->Session->read('PathsOpenState.'.$section['FriendlyPermissionsItem']['id']) == 'open') {
								$expandImage = 'collapse';
							} else {
								$this->Js->buffer('$("#paths_box_'.$section['FriendlyPermissionsItem']['id'].'").click();');
							}
						} else {
							$this->Js->buffer('$("#paths_box_'.$section['FriendlyPermissionsItem']['id'].'").click();');
						}
						
						$urlState = $this->Html->url(array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'savePathsOpenState', $section['FriendlyPermissionsItem']['id']));
						$actions = array();
						$button = array();
						$html_options = array();
						$html_options['id'] = 'paths_box_'.$section['FriendlyPermissionsItem']['id'];
						$html_options['onclick'] = 'togglePathsBox(this, '.$section['FriendlyPermissionsItem']['id'].', "'.$urlState.'");';
						$button['html_options'] = $html_options;
						$button['class'] = 'expand link crud_button '.CRUD_THEME.' sc_button_image_16 sc_button_gray';
						$button['allowed'] = true;
						$button['label'] = $this->Html->image('crud/small/'.$expandImage.'.png', array('align'=>'absmiddle'));
						$actions[] = $button;
						
						$button = array();
						$dialog_options= array();
						$dialog_options["title"] = "'".__("Edit Section")."'";
						$dialog_options["width"]= 500;
						$button["dialog_options"]= $dialog_options;
						$button["class"]= "edit_section link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
						$button["url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"edit", $section['FriendlyPermissionsItem']["id"]);
						$button["label"]= $this->Html->image("crud/small/edit.gif", array('align'=>'absmiddle'));
						$actions[]= $button;
						
						$dialog_options= array();
						$dialog_options['title']= "'".__('Add Subsection to %s', $section['FriendlyPermissionsItem']['name'])."'";
						$dialog_options['width']= 500;
						
						$options= array();
						$button= array();
						$button['class']= 'add_subsection link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_16';
						$button['dialog_options']= $dialog_options;
						$button['html_options']= $options;
						$button['url']= array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'add', $id, $section['FriendlyPermissionsItem']['id']);
						$button['label']= $this->Html->image('crud/small/plus.png', array('align'=>'absmiddle'));
						$actions[]= $button;	 
							
						$options_link= array();
						$options_link["escape"]= false;
						$confirm= __('Are you sure you want to delete this section from the database?');
						$button= array();
						$button["permission_url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"delete");
						$button["class"]= "delete_section link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";;
						$button["inner_html"]= $this->Form->postLink($this->Html->image(SMALL_DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"delete", $section['FriendlyPermissionsItem']["id"]), $options_link, $confirm);
						$actions[]= $button;
						
						echo $this->CustomTable->button_group($actions);
					?>
				</div>
			</td>
		</tr>
		<?php if ($section['children']):?>
			<?php foreach($section['children'] as $subsection_1):?>
				<tr class='fp_subsection_1'>
					<td valign='top' class='fp_subsection_1_name' width='20%'>
						<?php
							$actions = array();
							
							$button = array();
							$dialog_options= array();
							$dialog_options["title"] = "'".__("Edit Subsection")."'";
							$dialog_options["width"]= 500;
							$button["dialog_options"]= $dialog_options;
							$button["class"]= "edit_subsection link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
							$button["url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"edit", $subsection_1['FriendlyPermissionsItem']["id"]);
							$button["label"]= $this->Html->image("crud/small/edit.gif", array('align'=>'absmiddle'));
							$actions[]= $button;
							
							$dialog_options= array();
							$dialog_options['title']= "'".__('Add Subsection to %s', $subsection_1['FriendlyPermissionsItem']['name'])."'";
							$dialog_options['width']= 500;
							
							$options= array();
							$button= array();
							$button['class']= 'add_subsection link crud_button '.CRUD_THEME.' sc_button_gray sc_button_image_16';
							$button['dialog_options']= $dialog_options;
							$button['html_options']= $options;
							$button['url']= array('plugin'=>null, 'controller'=>'FriendlyPermissionsItems', 'action'=>'add', $id, $subsection_1['FriendlyPermissionsItem']['id']);
							$button['label']= $this->Html->image('crud/small/plus.png', array('align'=>'absmiddle'));
							$actions[] = $button;
							
							$options_link= array();
							$options_link["escape"]= false;
							$confirm= __('Are you sure you want to delete this subsection from the database?');
							$button= array();
							$button["permission_url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"delete");
							$button["class"]= "delete_subsection link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";;
							$button["inner_html"]= $this->Form->postLink($this->Html->image(SMALL_DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"delete", $subsection_1['FriendlyPermissionsItem']["id"]), $options_link, $confirm);
							$actions[]= $button;
							 
							echo $this->CustomTable->button_group($actions);
						?>
						<?php echo $subsection_1['FriendlyPermissionsItem']['name']?>
					</td>
					<td valign='top' class='fp_subsection_1_subsections' width='55%'>
						<table class='fp_subsections' id='table_subsections_<?php echo $subsection_1['FriendlyPermissionsItem']['id']?>'>
							<?php if ($subsection_1['children']): ?>
								<?php foreach($subsection_1['children'] as $subsection_2): ?>
									<tr>
										<td valign='top' class='fp_subsection_2_name' width='50%'>
											<?php
												$actions = array();
												
												$button = array();
												$dialog_options= array();
												$dialog_options["title"] = "'".__("Edit Subsection")."'";
												$dialog_options["width"]= 500;
												$button["dialog_options"]= $dialog_options;
												$button["class"]= "edit_subsection link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";
												$button["url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"edit", $subsection_2['FriendlyPermissionsItem']["id"]);
												$button["label"]= $this->Html->image("crud/small/edit.gif", array('align'=>'absmiddle'));
												$actions[]= $button;
												
												$options_link= array();
												$options_link["escape"]= false;
												$confirm= __('Are you sure you want to delete this subsection from the database?');
												$button= array();
												$button["permission_url"]= array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"delete");
												$button["class"]= "delete_subsection link crud_button ".CRUD_THEME." sc_button_gray sc_button_image_16";;
												$button["inner_html"]= $this->Form->postLink($this->Html->image(SMALL_DELETE_IMAGE, array("align"=>"absmiddle")), array("plugin"=>null, "controller"=>'FriendlyPermissionsItems', "action"=>"delete", $subsection_2['FriendlyPermissionsItem']["id"]), $options_link, $confirm);
												$actions[]= $button;
												 
												echo $this->CustomTable->button_group($actions);
											?>
											<?php echo $subsection_2['FriendlyPermissionsItem']['name']?>
										</td>
										<td valign='top' id='permissions_box_<?php echo $subsection_2['FriendlyPermissionsItem']['id']?>' record_id='<?php echo $subsection_2['FriendlyPermissionsItem']['id']?>' class='fp_subsection_2_permissions permissions_box' width='50%'>
											<?php if($subsection_2['FriendlyPermissionsItemsAco']):?>
												<?php foreach($subsection_2['FriendlyPermissionsItemsAco'] as $aco):?>
													<?php echo $this->element('FriendlyPermissions/assigned_path', array('itemAco'=>$aco, 'friendly_permissions_table_id'=>$id))?>
												<?php endforeach;?>
											<?php endif;?>
										</td>
									</tr>
								<?php endforeach;?>
							<?php else:?>
								<tr>
									<td valign='top'><?php echo $this->Utils->infobox(__('No subsections added'))?></td>
								</tr>
							<?php endif;?>
						</table>
					</td>
					<td valign='top' id='permissions_box_<?php echo $subsection_1['FriendlyPermissionsItem']['id']?>' record_id='<?php echo $subsection_1['FriendlyPermissionsItem']['id']?>' class='fp_subsection_1_permissions permissions_box'>
						<?php if($subsection_1['FriendlyPermissionsItemsAco']):?>
							<?php foreach($subsection_1['FriendlyPermissionsItemsAco'] as $aco):?>
								<?php echo $this->element('FriendlyPermissions/assigned_path', array('itemAco'=>$aco, 'friendly_permissions_table_id'=>$id))?>
							<?php endforeach;?>
						<?php endif;?>
					</td>
				</tr>
			<?php endforeach;?>
		<?php else:?>
			<tr>
				<td valign='top'>
					<?php $this->Utils->infobox(__('No items added'))?>
				</td>
			</tr>
		<?php endif;?>
	</tbody>
</table>