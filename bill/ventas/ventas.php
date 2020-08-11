<?php
	include('clsVentas.php');
	$venta = new clsVentas;
	$accion = $_GET['parAccion'];
	if ($accion == 'lista_ventas') {
		echo $venta->lista_ventas();
	}elseif ($accion == 'buscar') {
		echo $venta->buscar($_GET['termino']);
	}elseif ($accion == 't_documento') {
		echo $venta->t_documento();
	}elseif ($accion == 'dni_cliente') {
		echo $venta->dni_cliente();
	}elseif ($accion == 'detalle') {
		echo $venta->detalle($_GET['id']);
	}elseif ($accion == 'guardar') {
		echo $venta->guardar($_GET['n_documento'], $_GET['t_documento'], $_GET['dni_cliente'], $_GET['subtotal'], $_GET['igv'], $_GET['total'], $_GET['ids'], $_GET['cantidades']);
	}elseif ($accion == 'detalle_venta') {
		echo $venta->detalle_venta($_GET['codigo_venta']);
	}elseif ($accion == 'detalles_costos') {
		echo $venta->detalles_costos($_GET['codigo_venta']);
	}
?>