<?php
	include_once("../env/env_soft.php");
 	$query = $mbd->prepare("SELECT m.* FROM menus as m inner join menu_entidad as me on me.id_menu = m.id inner join usuarios as u on me.dni_usuario = u.dni AND u.dni = :dni_entidad");
  $dni = $_GET['dni_usuario'];
  $query->bindParam(':dni_entidad', $dni);
  $query->execute();

  $array = array();
  $i = 0;
  while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
    //$r = ($res['padre'] == '0') ? '#' : $res['padre'];
    $query2 = $mbd->prepare("SELECT m.id, m.texto, m.nivel, m.parent_id, m.link, m.orden, m.icono FROM menus as m, menu_entidad as me, usuarios as e WHERE me.id_menu = m.id AND m.parent_id = :id_padre AND me.dni_usuario = e.dni and e.dni = :dni_entidad ORDER BY id;");
    $dni = $_GET['dni_usuario'];
    $query2->bindParam(':dni_entidad', $dni);
    $query2->bindParam(':id_padre', $res['id']);
    $query2->execute();
    $hijos = array();
    while ($res2 = $query2->fetch(PDO::FETCH_ASSOC)) {
      $hijos[] = $res2;
    }
    $values[] = array(
      'id' => $res['id'],
      'parent'=>$r,
      'text' => $res['texto'],
      'icon' => $res['icono'],
      'hijos' => $hijos //array('value' => $res['link'])
    );  
  }
  $JSON = json_encode($values);
  echo $JSON;
?>
