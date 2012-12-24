<?php echo $this->Utils->datepicker_headers(true)?>
<?php echo $this->Html->script("ckeditor/ckeditor")?>
<?php echo $this->Html->script("ckfinder/ckfinder")?>
<?php echo $this->Html->script("voucher")?>

<?php echo $this->Js->buffer('$("#submit_voucher").bind("click", function (event) {get_ckeditor_values(["VoucherPasajero"]);return false;});');?>
<?php echo $this->Js->buffer('$("#submit_voucher").bind("click", function (event) {get_ckeditor_values(["VoucherServicios"]);return false;});');?>

<?php echo $this->Form->create($model, array('type' => 'file'));?>
	<?php echo $this->Form->input($model.".id")?>
	
	<?php echo $this->Utils->form_section("Principal") ?>
	<?php echo $this->Form->input($model.'.numero', array('size' => '50', 'value' => $last_id, 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.".fecha", array('type' => 'text', 'size' => '10', 'default' => date('d-m-Y'), "div"=>array("class"=>"input text two_column input_delete")))?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input($model.'.seller_id', array('label' => __("Vendedor"), 'div' => array('class' => 'input select two_column')));?>
	<?php echo $this->Form->input($model.'.clave', array('size' => '50', 'div' => array('class' => 'input text two_column')));?>
	
	<?php echo $this->Utils->form_section("Proveedor") ?>
	<?php echo $this->Form->input($model.'.provider_id', array('label' => __("Proveedor")));?>
	<?php echo $this->Form->input('AuxElm.presentar', array('label' => __("Presentar a"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input('AuxElm.telefono_principal', array('label' => __("Tel&eacute;fono 1"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input('AuxElm.telefono_secundario', array('label' => __("Tel&eacute;fono 2"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input('AuxElm.telefono_emergencia', array('label' => __("Tel&eacute;fono Emergencia"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input('AuxElm.direccion', array('label' => __("Direcci&oacute;n"), 'type' => 'textarea', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input textarea two_column')));?>
	
	<?php echo $this->Utils->form_section("Pasajero") ?>
	<?php echo $this->Form->input($model.'.pasajero', array('label' => false));?>
	
	<?php echo $this->Utils->form_section("Servicios") ?>
	<?php echo $this->Form->input($model.'.servicios', array('label' => false));?>
	
	<?php echo $this->Utils->form_section("Llegada") ?>
	<?php echo $this->Form->input($model.'.dia_llegada', array('label' => 'Dia', 'type' => 'text', 'size' => '10', 'div' => array('class' => 'input text two_column input_delete')));?>
	<?php echo $this->Form->input($model.'.ruta_llegada', array('label' => 'Ruta', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.'.vuelo_llegada', array('label' => 'Vuelo', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.".hora_llegada", array("label"=>__("Hora"), 'size' => '8', "div"=>array("id" => "hora_llegada", "class"=>"input text two_column"))) ?>
	<?php echo $this->Form->input($model.".no_aplica_llegada", array("label"=>__('No Aplica Hora?'), 'type'=>'checkbox', "div"=>array("class"=>"input text two_column check_inline")));?>
	
	<?php echo $this->Utils->form_section("Salida") ?>
	<?php echo $this->Form->input($model.'.dia_salida', array('label' => 'Dia', 'type' => 'text', 'size' => '10', 'div' => array('class' => 'input text two_column input_delete')));?>
	<?php echo $this->Form->input($model.'.ruta_salida', array('label' => 'Ruta', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.'.vuelo_salida', array('label' => 'Vuelo', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.".hora_salida", array("label"=>__("Hora"), 'size' => '8', "div"=>array("id" => "hora_salida", "class"=>"input text two_column"))) ?>
	<?php echo $this->Form->input($model.".no_aplica_salida", array("label"=>__('No Aplica Hora?'), 'type'=>'checkbox', "div"=>array("class"=>"input text two_column check_inline")));?>
	
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(__("Save"), array("id"=>"submit_voucher", "type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php echo $this->Form->end(array("label"=>__("Save"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>
	
	
<?php
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherFecha")');
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherDiaLlegada")');
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherDiaSalida")');
  $this->Js->buffer('initialize_input_delete()');
  
  $this->Js->buffer('initialize_basic_timepicker("#VoucherHoraLlegada", { showPeriod: true, showLeadingZero: true, defaultTime: \'00:00\' })');
  $this->Js->buffer('initialize_change_minutes("#VoucherHoraLlegada")');
  
  $this->Js->buffer('initialize_basic_timepicker("#VoucherHoraSalida", { showPeriod: true, showLeadingZero: true, defaultTime: \'00:00\' })');
  $this->Js->buffer('initialize_change_minutes("#VoucherHoraSalida")');
?>

<?php echo $this->element("ckeditor_setup", array("editor_id"=>"VoucherPasajero"))?>
<?php echo $this->element("ckeditor_setup", array("editor_id"=>"VoucherServicios"))?>
	