<?php 
	date_default_timezone_set('America/Lima');
	class Producto{
		function listarProductos(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM celulares");
			$query->execute();
			$values = "";
            while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            	$values[] = $res;
            }
            $result = array('Result' => 'OK',
            'Records' => $values);
        	return json_encode($result);
		}
		function eliminarProductos($marca){
			include('../env/env.php');
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();
				
				$query_u = $mbd->prepare("DELETE FROM modelo WHERE id_marca = :marca");
				$query_u->bindParam(':marca', $marca);
				$query_u->execute();
				
				$query = $mbd->prepare("DELETE FROM celulares WHERE id = :marca");
				$query->bindParam(':marca', $marca);
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
		function productoAutoComplete($term){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT p.serie, p.producto from productos as p WHERE producto LIKE '%".$term."%'");
			//$query->bindParam(':term', $term);
			$query->execute();
			$values = "";
            while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            	$values[] = array(
            		'id' => $res['serie'],
            		'value' => $res['producto']
            	);
            }
        	return json_encode($values);
		}
		function productoUnidad($serie){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT u.*, pu.*  FROM unidades as u, producto_unidad as pu WHERE u.codigo = pu.codigoUnidad AND pu.serieProducto = :serie");
			$query->bindParam(':serie', $serie);
			$query->execute();
			$values = "";
			while($res = $query->fetch(PDO::FETCH_ASSOC)){
		   		$values[] = array(
		   			'value' => $res['codigo'],
					'text'=> $res['unidad'],
					'precio' => $res['precio']   
		   		);  
		   	}
		   	$JSON = json_encode($values);
		   	echo $JSON;
		}
		function extraerPrecio($serie, $unidad){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT pu.* from producto_unidad as pu WHERE pu.codigoUnidad = :unidad AND pu.serieProducto = :serie");
			$query->bindParam(':serie', $serie);
			$query->bindParam(':unidad', $unidad);
			$query->execute();
			$values = "";
            while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
            	$values[] = array(
            		'precio' => $res['precio']
            	);
            }
        	return json_encode($values);
		}
		function lista_unidades(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM unidades");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK',
            'Records' => $values);
        	return json_encode($result);
		}
		function lista_unidades_producto($serie){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM unidades");
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$query2 = $mbd->prepare("SELECT u.*, pu.precio FROM unidades as u, producto_unidad as pu WHERE pu.codigo_unidad = u.codigo AND pu.serie_producto = :serie");
			$query2->bindParam(':serie', $serie);
			$query2->execute();
			$values2 = array();
			$devolver = array();
			while ($res2 = $query2->fetch(PDO::FETCH_ASSOC)) {
				$values2[] = $res2;
			}
			$val = "";
			$precio = "";
			foreach ($values as $key => $value) {
				foreach ($values2 as $key2 => $value2) {
					if ($value['codigo'] == $value2['codigo']) {
						$val = 'true';
						$precio = $value2['precio'];
						break;
					}else{
						$val = 'false';
						continue;
					}
				}
				$devolver[] = array(
					'codigo' => $value['codigo'],
					'unidad' => $value['unidad'],
					'precio' => $precio,
					'estado' => $val
				);
			}
			$result = array(
				'Result' => 'OK',
            	'Records' => $devolver
            );
        	return json_encode($result);
		}
		function editar_producto($id){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM celulares WHERE id = :id");
			$query->bindParam(':id', $id);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK',
            'Records' => $values);
        	return json_encode($result);
		}
		function stock_productos($serie){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM modelo WHERE id_marca = :serie");
			$query->bindParam(':serie', $serie);
			$query->execute();
			$values = array();
			while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
				$values[] = $res;
			}
			$result = array('Result' => 'OK',
            'Records' => $values);
        	return json_encode($result);
		}
		function actualizar_producto($marca, $id){
			include('../env/env.php');
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();
				$query = $mbd->prepare("UPDATE celulares SET marca = :marca WHERE id = :id");
				$query->bindParam(':marca', $marca);
				$query->bindParam(':id', $id);
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
		function guardar_producto($marca){
			include('../env/env.php');
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();
				$query = $mbd->prepare("INSERT INTO celulares(marca) VALUES(:marca)");
				$query->bindParam(':marca', $marca);
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
		function guardar_modelo($modelo, $id_marca, $stock, $precio){
			include('../env/env.php');
			try {  
				$mbd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			  	$mbd->beginTransaction();
				$query = $mbd->prepare("INSERT INTO modelo(modelo, id_marca, precio, stock) VALUES(:modelo, :id_marca, :precio, :stock)");
				$query->bindParam(':modelo', $modelo);
				$query->bindParam(':id_marca', $id_marca);
				$query->bindParam(':precio', $precio);
				$query->bindParam(':stock', $stock);
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
		function combo_categorias(){
			include('../env/env.php');
			$query = $mbd->prepare("SELECT * FROM categorias");
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
	}
?>
