<?php
    class Utilitarios{
        function iniciar_sesion($usuario, $contrasena){
            include('../env/env.php');
            $_SESSION["usuario"] = "";
			$query = $mbd->prepare("SELECT COUNT(*) as cant FROM usuarios where usuario = :usuario AND contrasena = :pass");
			$query->bindParam(':usuario', $usuario);
			$query->bindParam(':pass', $contrasena);
			$query->execute();
			$canti = 0;
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$canti = $res['cant'];
			}
			if($canti == 0){
				$result = array(
	            	'Result' => 'ERROR'
	            );
			}else{
				$query2 = $mbd->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND contrasena = :pass");
				$query2->bindParam(':usuario', $usuario);
				$query2->bindParam(':pass', $contrasena);
				$query2->execute();
				while ($res = $query2->fetch(PDO::FETCH_ASSOC)) {
					$_SESSION["usuario"] = $res['dni'];
					$_SESSION["rol"] = $res['rol'];
					$_SESSION["nombres"] = $res['nombres'];
					$_SESSION["ruc_empresa"] = $res['ruc_empresa'];
				}
				$values = array(
					'logeo' => 'OK',
					'usuario' => $_SESSION["usuario"],
					'nombres' => $_SESSION["nombres"],
					'rol' => $_SESSION["rol"],
					'ruc_empresa' => $_SESSION['ruc_empresa']
				);
				$result = array(
	            	'Result' => 'OK',
	            	'Values' => $values
	            );
			}
			return json_encode($result);
        }
    }
?>