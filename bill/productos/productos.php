<?php 
	include('clsProductos.php');
	$accion = $_GET['parAccion'];
	$producto = new Producto;
	if($accion == 'list'){
		echo $producto->listarProductos();
	}elseif ($accion == 'create') {
		foreach ($_POST as $clave=>$valor){
			if (empty($valor)) {
				$_POST[$clave] = NULL;
			}else{
			}
		}
		echo $producto->insertarProductos($_POST['xi_tecnologia'], $_POST['inv_description'], $_POST['xi_modelo'], $_POST['invtype_label'], $_POST['xi_codigosap'], $_POST['quantity']);
	}elseif ($accion == 'update') {
		foreach ($_POST as $clave=>$valor){
			if (empty($valor)) {
				$_POST[$clave] = NULL;
			}else{
			}
		}
		echo $producto->editarProductos($_POST['id'], $_POST['xi_tecnologia'], $_POST['inv_description'], $_POST['xi_modelo'], $_POST['invtype_label'], $_POST['xi_codigosap']);
	}elseif ($accion == 'delete') {
		echo $producto->eliminarProductos($_GET['serie']);
	}elseif ($accion == 'comboAula') {
		echo $producto->comboAula();
	}elseif ($accion == 'comboEntidades') {
		echo $producto->comboEntidades();
	}elseif ($accion == 'comboAlumnos') {
		echo $producto->comboAlumnos();
	}elseif ($accion == 'delProducto') {
		echo $producto->delProducto($_GET['idProducto']);
	}elseif ($accion == 'productoAutoComplete') {
		echo $producto->productoAutoComplete($_GET['term']);
	}elseif ($accion == 'productoUnidad') {
		echo $producto->productoUnidad($_GET['serie']);
	}elseif ($accion == 'extraerPrecio') {
		echo $producto->extraerPrecio($_GET['serie'], $_GET['unidad']);
	}elseif ($accion == 'lista_unidades') {
		echo $producto->lista_unidades();
	}elseif ($accion == 'editar_producto') {
		echo $producto->editar_producto($_GET['id']);
	}elseif ($accion == 'lista_unidades_producto') {
		echo $producto->lista_unidades_producto($_GET['serie']);
	}elseif ($accion == 'stock_productos') {
		echo $producto->stock_productos($_GET['serie']);
	}elseif ($accion == 'actualizar_producto') {
		echo $producto->actualizar_producto($_GET['equipo'], $_GET['id']);
	}elseif ($accion == 'guardar_producto') {
		echo $producto->guardar_producto($_GET['equipo']);
	}elseif ($accion == 'combo_categorias') {
		echo $producto->combo_categorias();
	}elseif ($accion == 'combo_marca') {
		echo $producto->listarProductos();
	}elseif ($accion == 'guardar_modelo') {
		echo $producto->guardar_modelo($_GET['modelo'], $_GET['marca'], $_GET['stock'], $_GET['precio']);
	}
?>