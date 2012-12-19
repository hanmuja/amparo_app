<?php echo $this->element('FriendlyPermissions/acos_list', array('allAcos'=>$matchAcos, 'related'=>$related))?>
<?php $this->Js->buffer('initializeDraggableAcos()');?>