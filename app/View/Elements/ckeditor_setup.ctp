<?php

$id = $this->Session->read('Auth.User.id');

$folders = $this->Session->read('folders');

?>

<script>
	var instance = CKEDITOR.instances["<?php echo $editor_id?>"];
    if(instance){
        CKEDITOR.remove(instance);
    }
    <?php 
		$ckconnector = $this->Html->url("/", true);
		//$unipath = $this->Html->url("/", true).'js/ckeditor/filemanager/browser/default/browser.html?Connector='.$ckconnector.'js/ckeditor/filemanager/connectors/php/connector.php';
		//$quickupload = $ckconnector.'js/ckeditor/filemanager/connectors/php/upload.php';
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
    		filebrowserBrowseUrl: '<?php echo $ckconnector ?>Filemanager/index.php?id=<?php echo $id ?>&&folders=\'<?php echo json_encode($folders) ?>\'',
			on : { 'instanceReady' : configureHtmlOutput }
        }
	); 
</script>