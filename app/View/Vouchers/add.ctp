<?php echo $this->Dialog->headers() ?>
<?php echo $this->Utils->datepicker_headers(true)?>
<?php echo $this->Html->script("ckeditor/ckeditor")?>
<?php echo $this->Html->script("ckfinder/ckfinder")?>
<?php echo $this->Html->script("voucher")?>

<?php echo $this->Js->buffer('$("#submit_voucher").bind("click", function (event) {get_ckeditor_values(["VoucherPasajero"]);return false;});');?>
<?php echo $this->Js->buffer('$("#submit_voucher").bind("click", function (event) {get_ckeditor_values(["VoucherServicios"]);return false;});');?>

<?php echo $this->Form->create($model, array('type' => 'file'));?>
	<?php echo $this->Form->input($model.".id")?>
	
	<?php echo $this->Utils->form_section("Principal") ?>
	<?php $last_id = str_pad($last_id, 4, 0, STR_PAD_LEFT); ?>
	<?php echo $this->Form->input($model.'.numero', array('size' => '50', 'value' => $last_id, 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.".fecha_s", array('label' => 'Fecha', 'type' => 'text', 'size' => '10', 'default' => date('d-m-Y'), "div"=>array("class"=>"input text two_column input_delete")))?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input($model.'.seller_id', array('label' => __("Vendedor"), 'div' => array('class' => 'input select two_column')));?>
	<?php echo $this->Form->input($model.'.clave', array('size' => '50', 'div' => array('class' => 'input text two_column')));?>
	
	<?php echo $this->Utils->form_section("Proveedor") ?>
	<?php echo $this->Form->input($model.'.provider_id', array('label' => __("Proveedor"), 'div' => array('class' => 'input select two_column')));?>
	<?php
	$buttons= array();
	
	$dialog_options= array();
	$dialog_options["title"]= "'".__("Buscar Proveedor")." ".$item."'";
	$dialog_options["width"]= 800;
			
	$button= array();
	$button["class"]= "list link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
	$button["dialog_options"]= $dialog_options;
	$button["url"]= array("plugin"=>null, "controller"=>"Providers", "action"=>"buscar");
	$button["label"]= __("Buscar Proveedor");
	$buttons[]= $button;
	echo $this->CustomTable->buttons(array($buttons), array('class' => 'two_column'));
	?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input('AuxElm.presentar', array('label' => __("Presentar a"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input('AuxElm.telefono_principal', array('label' => __("Tel&eacute;fono 1"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input('AuxElm.telefono_secundario', array('label' => __("Tel&eacute;fono 2"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input('AuxElm.telefono_emergencia', array('label' => __("Tel&eacute;fono Emergencia"), 'type' => 'text', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Utils->empty_div_row() ?>
	<?php echo $this->Form->input('AuxElm.direccion', array('label' => __("Direcci&oacute;n"), 'type' => 'textarea', 'size' => '50', 'disabled' => 'disabled', 'div' => array('class' => 'input textarea two_column')));?>
	
	<?php echo $this->Utils->form_section("Pasajero") ?>
	<?php echo $this->Form->input($model.'.pasajero', array('label' => false));?>
	
	<?php echo $this->Utils->form_section("Servicios a proporcionar / Please provide following services") ?>
	<?php echo $this->Form->input($model.'.servicios', array('label' => false));?>
	
	<?php echo $this->Utils->form_section("Llegada") ?>
	<?php echo $this->Form->input($model.'.dia_llegada_s', array('label' => 'Dia', 'type' => 'text', 'size' => '10', 'div' => array('class' => 'input text two_column input_delete')));?>
	<?php echo $this->Form->input($model.'.ruta_llegada', array('label' => 'Ruta', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.'.vuelo_llegada', array('label' => 'Vuelo', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.".hora_llegada_s", array("label"=>__("Hora"), 'size' => '8', "div"=>array("id" => "hora_llegada", "class"=>"input text two_column"))) ?>
	<?php echo $this->Form->input($model.".no_aplica_llegada", array("label"=>__('No Aplica Hora?'), 'type'=>'checkbox', "div"=>array("class"=>"input text two_column check_inline")));?>
	
	<?php echo $this->Utils->form_section("Salida") ?>
	<?php echo $this->Form->input($model.'.dia_salida_s', array('label' => 'Dia', 'type' => 'text', 'size' => '10', 'div' => array('class' => 'input text two_column input_delete')));?>
	<?php echo $this->Form->input($model.'.ruta_salida', array('label' => 'Ruta', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.'.vuelo_salida', array('label' => 'Vuelo', 'div' => array('class' => 'input text two_column')));?>
	<?php echo $this->Form->input($model.".hora_salida_s", array("label"=>__("Hora"), 'size' => '8', "div"=>array("id" => "hora_salida", "class"=>"input text two_column"))) ?>
	<?php echo $this->Form->input($model.".no_aplica_salida", array("label"=>__('No Aplica Hora?'), 'type'=>'checkbox', "div"=>array("class"=>"input text two_column check_inline")));?>
	
	<?php echo $this->Utils->form_separator();?>
	<?php if($is_ajax):?>
		<?php echo $this->Js->submit(__("Save"), array("id"=>"submit_voucher", "type"=>"POST", "class"=>"sc_button sc_button_green", "update"=>"#".$this->Dialog->id, "before"=>"show_loading();lock_dialog();", "success"=>"hide_loading();", "error"=>"handle_error(errorThrown);"));?>
		<?php echo $this->Form->end();?>
	<?php else:?>
		<?php
		
		if($edit)
		{
			$buttons= array();
		
			$dialog_options= array();
			$dialog_options["title"]= "'".__("Vista Previa")." ".$item."'";
			$dialog_options["width"]= 800;
			
			$button= array();
			$button["class"]= "list link crud_button sc_crud_top ".CRUD_THEME." sc_button_blue";
			$button["dialog_options"]= $dialog_options;
			$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"vistaPrevia", $this->data[$model]['id']);
			$button["label"]= __("Vista previa");
			$buttons[]= $button;
			if(!$this->data[$model]['impreso'])
			{
				$button= array();
				$button["class"]= "boton_imprimir list link crud_button sc_crud_top ".CRUD_THEME." sc_button_green";
				$button["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"imprimirVoucher", $this->data[$model]['id']);
				$button["label"]= __("Imprimir Voucher");
				$buttons[]= $button;
			}
			
			echo '<div style="float: right;">'.$this->CustomTable->buttons(array($buttons), array('class' => 'two_column')).'</div>';
		}
	?>
	<?php echo $this->Form->end(array("label"=>__("Save"), "class"=>"sc_button sc_button_green"));?>
	<?php endif;?>
	
	
<?php
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherFechaS")');
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherDiaLlegadaS")');
  $this->Js->buffer('initialize_basic_datepicker2("#VoucherDiaSalidaS")');
  $this->Js->buffer('initialize_input_delete()');
  
  $this->Js->buffer('initialize_basic_timepicker("#VoucherHoraLlegadaS", { showPeriodLabels: false, showLeadingZero: true, defaultTime: \'00:00\' })');
  $this->Js->buffer('initialize_change_minutes("#VoucherHoraLlegadaS")');
  
  $this->Js->buffer('initialize_basic_timepicker("#VoucherHoraSalidaS", { showPeriodLabels: false, showLeadingZero: true, defaultTime: \'00:00\' })');
  $this->Js->buffer('initialize_change_minutes("#VoucherHoraSalidaS")');
  
  $this->Js->buffer('$(".boton_imprimir").click(function(){ $(this).hide(); })');
?>

<?php echo $this->element("ckeditor_setup", array("editor_id"=>"VoucherPasajero"))?>
<?php echo $this->element("ckeditor_setup", array("editor_id"=>"VoucherServicios"))?>

<script>
	$(document).ready(function(){
		cargar_datos_proveedor();
		
		$("#VoucherProviderId").change(function(){
			cargar_datos_proveedor();
		});
	});
	
	function cargar_datos_proveedor()
	{
		var provider_id = $("#VoucherProviderId").val();
		
		$.post("<?php echo $this->Html->url(array('plugin' => null, 'controller' => $controller, 'action' => 'charge_provider')) ?>", { "provider_id": provider_id },
			function(data){
				var provider = data.Provider;
				$("#AuxElmPresentar").val(provider.nombre);
				$("#AuxElmTelefonoPrincipal").val(provider.telefono_principal);
				$("#AuxElmTelefonoSecundario").val(provider.telefono_secundario);
				$("#AuxElmTelefonoEmergencia").val(provider.telefono_emergencia);
				$("#AuxElmDireccion").val(provider.direccion);
			}, "json");
	}
</script>
	