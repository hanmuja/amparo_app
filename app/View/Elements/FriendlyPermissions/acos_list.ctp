<?php if($allAcos):?>
	<?php foreach($allAcos as $path):?>
		<?php if($path):?>
			<?php
				$class = 'aco_box';
				$class .= in_array($path, $related)?' related':' unrelated';
			?>
			<div class='<?php echo $class?>' id='path_<?php echo str_replace('/', '-', $path);?>'><?php echo $path?></div>
		<?php endif;?>
	<?php endforeach;?>
<?php else:?>
	<?php echo $this->Utils->infobox(__('Not acos found.'))?>
<?php endif;?>
<?php $this->Js->buffer('$("#fp_acos_list").tinyscrollbar();')?>