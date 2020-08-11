<?php 
	include('clsClientes.php');
	$accion = $_GET['parAccion'];
	$usuario = new Usuario;
	if ($accion == 'lista_usuarios') {
		echo $usuario->lista_usuarios();
	}elseif ($accion == 'detalle_usuario') {
		echo $usuario->detalle_usuario($_GET['dni']);
	}elseif ($accion == 'actualizar_detalle') {
		echo $usuario->actualizar_detalle($_GET['dni'], $_GET['direccion'], $_GET['fecha_nacimiento'], $_GET['estado_civil'], $_GET['grado_academico']);
	}elseif ($accion == 'combo_grado_academico') {
		echo $usuario->combo_grado_academico();
	}elseif ($accion == 'combo_estado_civil') {
		echo $usuario->combo_estado_civil();
	}elseif ($accion == 'usuario_completo') {
		echo $usuario->usuario_completo($_GET['dni']);
	}elseif ($accion == 'combo_cargo') {
		echo $usuario->combo_cargo();
	}elseif ($accion == 'combo_sede') {
		echo $usuario->combo_sede();
	}elseif ($accion == 'actualizar_usuario') {
		foreach ($_GET as $clave=>$valor){
			if (empty($valor)) {
				$_GET[$clave] = NULL;
			}else{
			}
		}
		echo $usuario->actualizar_usuario($_GET['dni'], $_GET['nombres'], $_GET['apellidos'], $_GET['direccion'], $_GET['correo'], $_GET['telefono'], $_GET['fecha_nacimiento']);
	}elseif ($accion == 'insertar_usuario') {
		echo $usuario->insertar_usuario($_GET['dni'], $_GET['nombres'], $_GET['apellidos'], $_GET['direccion'], $_GET['correo'], $_GET['telefono'], $_GET['fecha_nacimiento']);
	}elseif ($accion == 'eliminar_usuario') {
		echo $usuario->eliminar_usuario($_GET['dni']);
	}
?>