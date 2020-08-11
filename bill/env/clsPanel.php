<?php 
	date_default_timezone_set('America/Lima');
	class Panel{
		function comboSedes(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * from sedes");
			$query->execute();
			while($res = $query->fetch(PDO::FETCH_ASSOC)){
		   		$values[] = array(
		   			'value' => $res['id'],
		   			'text'=> $res['sede']
		   		);  
		   	}
		   	$JSON = json_encode($values);
		   	echo $JSON;
		}
		function listarStock($sede){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT m.codigo, m.material, (SUM(em.cantidad)) as cantidad, s.sede FROM sedes as s, materiales as m, entradaMaterial as em WHERE em.idSede = s.id AND m.codigo = em.idMaterial AND s.id = :sede GROUP BY m.codigo, m.material, s.sede HAVING cantidad <= 10");
			$query->bindParam(':sede', $sede);
			$query->execute();
			$materiales = "";
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$materiales[] = array(
					'codigo' => $res['codigo'],
					'material' => $res['material'],
					'cantidad' => $res['cantidad'],
					'sede' => $res['sede']
				);
			}
			$query2 = $mbd->prepare("SELECT p.id, p.inv_description, (count(pd.id)) as cantidad, s.sede FROM productos as p, productosDetalle as pd, sedes as s WHERE p.id = pd.idProducto AND pd.idSede = s.id AND s.id = :sede AND pd.fechaSalida = '0000-00-00 00:00:00' GROUP BY p.id, p.inv_description HAVING cantidad <= 10");
			$query2->bindParam(':sede', $sede);
			$query2->execute();
			$productos = "";
			while ($res = $query2->fetch(PDO::FETCH_ASSOC)) {
				$productos[] = array(
					'id' => $res['id'],
					'producto' => $res['inv_description'],
					'cantidad' => $res['cantidad'],
					'sede' => $res['sede']
				);
			}
			$result = array(
				'Result' => 'OK',
            	'materiales' => $materiales,
            	'productos' => $productos
            );
        	return json_encode($result);
		}
	}
?>