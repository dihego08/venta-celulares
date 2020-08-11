<?php 
	date_default_timezone_set('America/Lima');
	class Usuario{
		function lista_usuarios(){
			include('../env/env_soft.php');
			$query = $mbd->prepare("SELECT * FROM entidades");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array(
				'Result' => 'OK',
				'Records' => $values
        	);
        	return json_encode($result);
		}
		function usuario_completo($nro_documento){
			include('../env/env_soft.php');
			$query = $mbd->prepare("SELECT * FROM entidades WHERE nro_documento = :nro_documento");
			$query->bindParam(':nro_documento', $nro_documento);
			$query->execute();
			$values = "";
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array(
				'Result' => 'OK',
				'Records' => $values
        	);
        	return json_encode($result);
		}
		function actualizar_usuario($nro_documento, $nombres, $apellidos, $direccion, $correo, $telefono, $fecha_nacimiento){
			include('../env/env.php');
			if ($razon_social == NULL) {
				$razon_social = "";
			}
			if ($nombres == NULL) {
				$nombres = "";
			}
			if ($apellidos == NULL) {
				$apellidos = "";
			}
			$fecha_modificacion = date("Y-m-d H:i:s");
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();
				
				$query = $mbd->prepare("UPDATE entidades SET nombres = :nombres, apellidos = :apellidos, direccion = :direccion, correo = :correo, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento, fecha_modificacion = :fecha_modificacion WHERE nro_documento = :nro_documento");
				$query->bindParam(':nro_documento', $nro_documento);
				$query->bindParam(':nombres', $nombres);
				$query->bindParam(':apellidos', $apellidos);
				$query->bindParam(':direccion', $direccion);
				$query->bindParam(':fecha_modificacion', $fecha_modificacion);
				$query->bindParam(':correo', $correo);
				$query->bindParam(':telefono', $telefono);
				$query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
				$query->execute();

				$mbd->commit();
				$result = array(
	            	'Result' => 'OK'
	            );
	            return json_encode($result);
			}catch (Exception $e) {
			  	$mbd->rollBack();
			  	$result = array(
	            	'Result' => $e->getMessage()
	            );
	            return json_encode($result);
			}
		}
		function insertar_usuario($nro_documento, $nombres, $apellidos, $direccion, $correo, $telefono, $fecha_nacimiento){
			include('../env/env.php');
			if ($fecha_nacimiento == "") {
				$fecha_nacimiento = NULL;
			}
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();

				$query = $mbd->prepare("INSERT INTO entidades(nro_documento, nombres, apellidos, direccion, correo, telefono, fecha_nacimiento) VALUES(:nro_documento, :nombres, :apellidos, :direccion, :correo, :telefono, :fecha_nacimiento)");
				$query->bindParam(':nro_documento', $nro_documento);
				$query->bindParam(':nombres', $nombres);
				$query->bindParam(':apellidos', $apellidos);
				$query->bindParam(':direccion', $direccion);
				$query->bindParam(':correo', $correo);
				$query->bindParam(':telefono', $telefono);
				$query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
				$query->execute();
				
				$mbd->commit();
				$result = array(
	            	'Result' => 'OK'
	            );
	            return json_encode($result);
			}catch (Exception $e) {
			  	$mbd->rollBack();
			  	$result = array(
	            	'Result' => $e->getMessage()
	            );
	            return json_encode($result);
			}
		}
		function eliminar_usuario($nro_documento){
			$fecha_eliminacion = date("Y-m-d H:i:s");
			include('../env/env_soft.php');
			$query = $mbd->prepare("DELETE FROM entidades WHERE nro_documento = :nro_documento");
			$query->bindParam(':nro_documento', $nro_documento);
			$query->execute();
			$cuenta = $query->rowCount();
        	if ($cuenta > 0) {
        		$result = array(
	            	'Result' => 'OK'
	            );
        	}else{
        		$result = array(
	            	'Result' => 'ERROR'
	            );
        	}
            return json_encode($result);
		}
	}
?>
