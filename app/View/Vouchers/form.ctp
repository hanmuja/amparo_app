<?php if(isset($close)):?>
	<script>
		<?php echo $this->Dialog->destroy();?>
		<?php echo $this->Js->request($url_redirect, array("update"=>"#".$controller));?>
	</script>
	<?php exit;?>
<?php endif;?>
<?php if(!$is_ajax):?>
	<?php
		$buttons= array();
	
		$button= array();
		$button["class"]= "list link crud_button sc_crud_top ".CRUD_THEME." sc_button_gray";
		$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"index");
		$button["label"]= __("Back to List");
		
		$buttons[]= $button;
		
		echo $this->CustomTable->buttons(array($buttons));
	?>
<?php endif;?>

<?php echo $this->Js->buffer('$("#submit_voucher").bind("click", function (event) {get_ckeditor_values(["VoucherPasajero"]);return false;});');?>
<?php echo $this->Js->buffer('$("#submit_voucher").bind("click", function (event) {get_ckeditor_values(["VoucherServicios"]);return false;});');?>

<?php echo $this->Form->create($model, array('type' => 'file'));?>
	<?php echo $this->Form->input($model.".id")?>
	<?php echo $this->Form->input($model.'.numero', array('size' => '50', 'value' => $last_id, 'disabled' => 'disabled'));?>
	<?php echo $this->Form->input($model.'.seller_id', array('label' => __("Vendedor")));?>
	<?php echo $this->Form->input($model.".fecha", array('size' => '10', "div"=>array("class"=>"input text two_column input_delete")))?>
	<?php echo $this->Form->input($model.'.clave', array('size' => '50'));?>
	<?php echo $this->Form->input($model.'.provider_id', array('label' => __("Proveedor")));?>
	<?php echo $this->Form->input($model.'.pasajero');?>
	<?php echo $this->Form->input($model.'.servicios');?>
	<?php echo $this->Form->input($model.'.dia_llegada');?>
	<?php echo $this->Form->input($model.'.ruta_llegada');?>
	<?php echo $this->Form->input($model.'.vuelo_llegada');?>
	<?php echo $this->Form->input($model.'.dia_salida');?>
	<?php echo $this->Form->input($model.'.ruta_salida');?>
	<?php echo $this->Form->input($model.'.vuelo_salida');?>
	
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(__("Save"), array("id"=>"submit_voucher", "type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Save"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>
	
	
<?php
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherFecha")');
  $this->Js->buffer('initialize_input_delete()');
?>

<?php echo $this->element("ckeditor_setup", array("editor_id"=>"VoucherPasajero"))?>
<?php echo $this->element("ckeditor_setup", array("editor_id"=>"VoucherServicios"))?>
	