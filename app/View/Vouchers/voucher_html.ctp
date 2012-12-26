<table style="width: 100%;" cellspacing="0" cellpadding="5">
	<tr>
		<td style="border-bottom: 4px solid black;">
			<?php echo $this->Html->image("http://amparo_app/img/logo_amparo_app.png", array('width' => '250px')) ?>
			<br />
			<?php echo $this->Html->link('ampa@prodigy.net.mx', 'mailto:ampa@prodigy.net.mx') ?>
			<br />
			<?php echo $this->Html->link('www.amparo.com.mx', 'http://www.amparo.com.mx')?>
		</td>
		<td style="border-bottom: 4px solid black;" valign="bottom">
			<table style="width: 100%;" cellspacing="0" cellpadding="5">
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						Monte Hermon 109
						<br />
						Col. Lomas de Chapultepec
						<br />
						11000 México, D.F.
						<br />
						Tels. (+52 55)5258-0311 Fax (+52 55)5258-0308
					</td>
				</tr>
			</table>
		</td>
		<td style="border-bottom: 4px solid black;">
			<table style="width: 100%;" cellspacing="0" cellpadding="5">
				<tr>
					<td style="border-top: 4px solid black; border-bottom: 4px solid black;">
						<b>Vendedor</b>
						<br />
						Issued by
					</td>
					<td style="border-top: 4px solid black; border-bottom: 4px solid black;">
						<?php echo $voucher['Seller']['nombre']." ".$voucher['Seller']['primer_apellido']." ".$voucher['Seller']['segundo_apellido'] ?>
					</td>
				</tr>
				<tr>
					<td><b>Voucher</b></td>
					<td><?php echo str_pad($voucher[$model]["id"], 4, 0, STR_PAD_LEFT); ?></td>
				</tr>
				<tr>
					<td style="border-bottom: 4px solid black;"><b>Date</b></td>
					<td style="border-bottom: 4px solid black;"><?php echo date('d-M-Y', $voucher[$model]['fecha']) ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="border-bottom: 4px solid black;">
			<b>Presentar a</b>
			<br />
			Please Present to
		</td>
		<td colspan="2" style="border-bottom: 4px solid black;">
			<?php echo $voucher['Provider']['nombre'] ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="border-bottom: 4px solid black;">
			<b>Direcci&oacute;n</b>
			<br />
			Address
		</td>
		<td valign="top" style="border-bottom: 4px solid black;">
			<?php echo $voucher['Provider']['direccion'] ?>
		</td>
		<td style="border-bottom: 4px solid black;">
			<table style="width: 100%;" cellspacing="0" cellpadding="5">
				<tr>
					<td><b>Tel&eacute;fonos</b></td>
					<td><?php echo $voucher['Provider']['telefono_principal'] ?></td>
				</tr>
				<tr>
					<td>Phone numbers</td>
					<td><?php echo $voucher['Provider']['telefono_secundario'] ?></td>
				</tr>
				<tr>
					<td>(emergencia)</td>
					<td><?php echo $voucher['Provider']['telefono_emergencia'] ?></td>
				</tr>
				<tr>
					<td>Fax</td>
					<td><?php echo $voucher['Provider']['fax'] ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top" style="border-bottom: 4px solid black;">
			<b>Pasajero</b>
			<br />
			In favor of
		</td>
		<td colspan="2" style="border-bottom: 4px solid black;">
			<?php echo $voucher[$model]['pasajero'] ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="border-bottom: 4px solid black;">
			<b>Servicios a proporcionar</b>
			<br />
			Please provide following services
		</td>
		<td valign="top" colspan="2" style="border-bottom: 4px solid black;">
			<?php echo $voucher[$model]['servicios'] ?>
			<br />
			<br />
			END OF SERVICES
		</td>
	</tr>
	<tr>
		<td colspan="3" style="border-bottom: 4px solid black;">
			<table style="width: 100%;" cellspacing="0" cellpadding="5">
				<tr>
					<td style="border-bottom: 4px solid black;">
						<b>Llegada</b>
						<br />
						Arrival
					</td>
					<td style="border-bottom: 4px solid black;"><?php echo date('d-M-Y', $voucher[$model]['dia_llegada']) ?></td>
					<td style="border-bottom: 4px solid black;">
						<b>Vuelo</b>
						<br />
						Flight
					</td>
					<td style="border-bottom: 4px solid black;"><?php echo $voucher[$model]['vuelo_llegada'] ?></td>
					<td style="border-bottom: 4px solid black;">
						<b>Ruta</b>
						<br />
						Route
					</td>
					<td style="border-bottom: 4px solid black;"><?php echo $voucher[$model]['ruta_llegada'] ?></td>
					<td style="border-bottom: 4px solid black;">
						<b>Hora</b>
						<br />
						Time
					</td>
					<td style="border-bottom: 4px solid black;"><?php echo date('H:i', $voucher[$model]['dia_llegada']) ?></td>
				</tr>
				<tr>
					<td>
						<b>Salida</b>
						<br />
						Departure
					</td>
					<td><?php echo date('d-M-Y', $voucher[$model]['dia_salida']) ?></td>
					<td>
						<b>Vuelo</b>
						<br />
						Flight
					</td>
					<td><?php echo $voucher[$model]['vuelo_salida'] ?></td>
					<td>
						<b>Ruta</b>
						<br />
						Route
					</td>
					<td><?php echo $voucher[$model]['ruta_salida'] ?></td>
					<td>
						<b>Hora</b>
						<br />
						Time
					</td>
					<td><?php echo date('H:i', $voucher[$model]['dia_salida']) ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>