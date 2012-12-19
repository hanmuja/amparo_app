<?php $main_menu= $this->Utils->get_top_menu();?>
<ul id="MenuBar1" class="MenuBarHorizontal">
	<?php if(isset($main_menu["children"]) && $main_menu["children"]):?>
		<?php foreach($main_menu["children"] as $menu):?>
			<?php
				$selected_class= "";
				if($this->Utils->is_here($menu))
				{
					if($menu["children"] && $menu["valid_children"]){
						$selected_class= "SelectedPageSubmenu";
					}
					else{
						$selected_class= "SelectedPage";
					}
				}
			?>
			<?php $menu_class= ($menu["children"] && $menu["valid_children"])?"MenuBarItemSubmenu":""?>
			<?php $menu_class.= " ".$selected_class ?>
			<?php 
				$menu_html_options= array();
				if(isset($menu["html_options"])){
					$menu_html_options= $menu["html_options"];
				}
				
				if(isset($menu_html_options["class"])){
					$menu_html_options["class"].= " ".$menu_class;
				}else{
					$menu_html_options["class"]= $menu_class;
				}
			?>
			<li>
				<?php echo $this->Html->link($menu["label"], $menu["url"], $menu_html_options)?>
				<?php if($menu["children"] && $menu["valid_children"]):?>
					<ul>
						<?php foreach($menu["children"] as $child):?>
							<?php if(!isset($child["virtual"])):?>
								<?php $submenu_class= ($child["children"] && $child["valid_children"])?"MenuBarItemSubmenu":""?>
								<li><?php echo $this->Html->link($child["label"], $child["url"], array("class"=>$submenu_class))?>
									<?php if($child["children"] && $child["valid_children"]):?>
										<ul>
											<?php foreach($child["children"] as $subchild):?>
												<?php if(!isset($subchild["virtual"])):?>
													<li><?php echo $this->Html->link($subchild["label"], $subchild["url"])?></li>
												<?php endif;?>
											<?php endforeach;?>
										</ul>
									<?php endif;?>
								</li>
							<?php endif;?>
						<?php endforeach;?>
					</ul>
				<?php endif;?>
			</li>
		<?php endforeach;?>
	<?php endif;?>	
</ul>	

