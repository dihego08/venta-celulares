<?php
	class clsVentas{
		function lista_ventas(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT vc.*, d.doc, CONCAT(e.apellidos, ', ', e.nombres) as cliente FROM venta_cabecera as vc, docs as d, entidades as e WHERE vc.tipo_documento = d.id AND e.id = vc.id_entidad");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
		function buscar($termino){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT c.marca, m.* FROM celulares as c, modelo as m WHERE c.id = m.id_marca AND c.marca LIKE '%".$termino."%'");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
		function detalle($id){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT c.marca, m.* FROM celulares as c, modelo as m WHERE c.id = m.id_marca AND m.id = :id");
			$query->bindParam(':id', $id);
			$query->execute();
			$values = $query->fetch(PDO::FETCH_ASSOC);
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
		function t_documento(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM docs");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
		function dni_cliente(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM entidades");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
		function restar_stock($id_modelo, $cantidad){
			include('../env/env.php');
			$query = $mbd->prepare("UPDATE modelo SET stock = stock - :cantidad WHERE id = :id_modelo");
			$query->bindParam(':id_modelo', $id_modelo);
			$query->bindParam(':cantidad', $cantidad);
			$query->execute();
		}
		function guardar($n_documento, $t_documento, $dni_cliente, $subtotal, $igv, $total, $ids, $cantidades){
			$ss = new clsVentas();
			include('../env/env.php');
			$ids = explode(',', $ids);
			$cantidades = explode(',', $cantidades);
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();
				
				$query = $mbd->prepare("INSERT INTO venta_cabecera(codigo_venta, tipo_documento, total, igv, subtotal, id_entidad) VALUES(:codigo_venta, :tipo_documento, :total, :igv, :subtotal, :id_entidad)");
				$query->bindParam(':codigo_venta', $n_documento);
				$query->bindParam(':tipo_documento', $t_documento);
				$query->bindParam(':total', $total);
				$query->bindParam(':igv', $igv);
				$query->bindParam(':subtotal', $subtotal);
				$query->bindParam(':id_entidad', $dni_cliente);
				$query->execute();

				for ($i = 1; $i < count($ids); $i++) { 
					$query_d = $mbd->prepare("INSERT INTO venta_detalle(codigo_venta_cabecera, id_modelo, cantidad) VALUES(:codigo_venta_cabecera, :id_modelo, :cantidad)");
					$query_d->bindParam(':codigo_venta_cabecera', $n_documento);
					$query_d->bindParam(':id_modelo', $ids[$i]);
					$query_d->bindParam(':cantidad', $cantidades[$i]);
					$query_d->execute();

					$query_m = $mbd->prepare("UPDATE modelo SET stock = stock - :cantidad WHERE id = :id_modelo");
					$query_m->bindParam(':id_modelo', $ids[$i]);
					$query_m->bindParam(':cantidad', $cantidades[$i]);
					$query_m->execute();
					//$ss->restar_stock($ids[$i], $cantidades[$i]);
				}

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
		function detalle_venta($codigo_venta){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT vd.*, m.modelo FROM venta_detalle as vd, modelo as m WHERE m.id = vd.id_modelo AND vd.codigo_venta_cabecera = :codigo_venta");
			$query->bindParam(':codigo_venta', $codigo_venta);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
		function detalles_costos($codigo_venta){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM venta_cabecera WHERE codigo_venta = :codigo_venta");
			$query->bindParam(':codigo_venta', $codigo_venta);
			$query->execute();
			$values = $query->fetch(PDO::FETCH_ASSOC);
			$result = array('Result' => 'OK', 'Records' => $values);
			return json_encode($result);
		}
	}
?>