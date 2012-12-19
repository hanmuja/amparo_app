<?php if(!$is_ajax):?>
	<?php echo $this->Html->script("acl")?>
	<?php echo $this->Html->script("locations_checkbox")?>
	<?php echo $this->Html->script("ui/minified/jquery.ui.tabs.min");?>
<?php endif;?>
<div id="full_permissions">
	<ul>
		<?php foreach($tabs_data as $i=>$data):?>
			<?php 
				extract($data);
				$url[]= "tab_".$i;
			?>
			<?php if ($this->Utils->has_permission($url)): ?>
				<li><?php echo $this->Html->link($label, $url, array("title"=>"full_permissions_inner"));?></li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>

<script>
	<?php $selected= ($this->Session->check("TabPermissions"))?"selected: ".$this->Session->read("TabPermissions").",":"";?>
	
	$("#full_permissions").tabs({
			<?php echo $selected?>
		}
	);
</script>