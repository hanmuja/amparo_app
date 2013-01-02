$(document).ready(function(){
	check_horas_llegada("#VoucherNoAplicaLlegada");
	check_horas_salida("#VoucherNoAplicaSalida");
	$("#VoucherNoAplicaLlegada").change(function(){
		check_horas_llegada(this);
	});
	
	$("#VoucherNoAplicaSalida").change(function(){
		check_horas_salida(this);
	});
});

function check_horas_llegada(objeto)
{
	if($(objeto).is(":checked"))
	{
		$("#VoucherHoraLlegadaS").val("00:00");
		$("#hora_llegada").hide();
	}
	else
	{
		$("#hora_llegada").show();
	}
}

function check_horas_salida(objeto)
{
	if($(objeto).is(":checked"))
	{
		$("#VoucherHoraSalidaS").val("00:00");
		$("#hora_salida").hide();
	}
	else
	{
		$("#hora_salida").show();
	}
}

function select_provider(provider)
{
	$("#VoucherProviderId").val(provider.id);
	$("#AuxElmPresentar").val(provider.nombre);
	$("#AuxElmTelefonoPrincipal").val(provider.telefono_principal);
	$("#AuxElmTelefonoSecundario").val(provider.telefono_secundario);
	$("#AuxElmTelefonoEmergencia").val(provider.telefono_emergencia);
	$("#AuxElmFax").val(provider.fax);
	
	$("#my_dialog").dialog("close");
}
