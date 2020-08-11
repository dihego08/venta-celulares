<?php 
	include('clsPanel.php');
	$accion = $_GET['parAccion'];
	$panel = new Panel;
	if ($accion == 'getComboSedes') {
		echo $panel->comboSedes();
	}elseif ($accion == 'getStock') {
		echo $panel->listarStock($_GET['sede']);
	}
?>