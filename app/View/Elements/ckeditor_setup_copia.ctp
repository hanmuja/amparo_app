<script>
	var instance = CKEDITOR.instances["<?php echo $editor_id?>"];
    if(instance){
        CKEDITOR.remove(instance);
    }
    <?php 
		$ckconnector = $this->Html->url("/", true);
		$unipath = $this->Html->url("/", true).'js/ckeditor/filemanager/browser/default/browser.html?Connector='.$ckconnector.'js/ckeditor/filemanager/connectors/php/connector.php';
		$quickupload = $ckconnector.'js/ckeditor/filemanager/connectors/php/upload.php';
	?>
	var session_editor= CKEDITOR.replace
	( 
		'<?php echo $editor_id?>',
		{
			<?php if(isset($uiColor)):?>
    			uiColor : '<?php echo $uiColor?>',
    		<?php endif;?>
			height : "80",
			extraPlugins : 'autogrow',
    		filebrowserBrowseUrl : "<?php echo $this->Html->url($unipath, true)?>",
    		filebrowserImageBrowseUrl : "<?php echo $this->Html->url($unipath, true)?>",
    		filebrowserFlashBrowseUrl : "<?php echo $this->Html->url($unipath, true)?>",
			filebrowserUploadUrl : "<?php echo $this->Html->url($quickupload, true)?>",
    		filebrowserImageUploadUrl : "<?php echo $this->Html->url($quickupload, true)?>",
    		filebrowserFlashUploadUrl : "<?php echo $this->Html->url($quickupload, true)?>",
			on : { 'instanceReady' : configureHtmlOutput }
        }
	); 
</script>