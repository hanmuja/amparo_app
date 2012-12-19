<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php if(isset($ajax_redirect)):?>
			<?php echo $this->Js->request($ajax_redirect, array("update"=>"#".$id_update));?>
		<?php elseif(isset($message_otf)):?>
			display_bouncebox_message('<?php echo $message_otf["box_id"]?>', '<?php echo $message_otf["text"]?>', 10, 5000);
		<?php elseif(isset($new_href)):?>
			document.location.href="<?php echo $this->Html->url($new_href, true)?>";
		<?php elseif(isset($just_reload)):?>
			document.location.reload();
		<?php endif;?>
	</script>
	<?php exit;?>
<?php endif;?>