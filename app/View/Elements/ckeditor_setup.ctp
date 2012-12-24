<script>
	var instance = CKEDITOR.instances["<?php echo $editor_id?>"];
    if(instance){
        CKEDITOR.remove(instance);
    }
    
	var session_editor= CKEDITOR.replace
	( 
		'<?php echo $editor_id?>',
		{
			<?php if(isset($uiColor)):?>
    			uiColor : '<?php echo $uiColor?>',
    		<?php endif;?>
			height : "80",
			extraPlugins : 'autogrow',
			on : { 'instanceReady' : configureHtmlOutput }
        }
	); 
</script>