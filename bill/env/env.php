<?php 
	try{
		$mbd = new PDO('mysql:host=localhost;dbname=celulares', 'root', 'root',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES  'UTF8'"));
		//session_start();
	}catch(PDOException $e){
		echo "Fallo en la conexion ".$e->getMessage();
	}
?>