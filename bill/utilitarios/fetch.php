<?php
include('../env/env.php');
  if(isset($_POST['view'])){

    if($_POST["view"] != ''){
        $queryU = $mbd->prepare("UPDATE alertas SET status = 1 WHERE status = 0");
        $queryU->execute();
    }
    $query = $mbd->prepare("SELECT a.*, e.apellidos as entidad FROM alertas as a, entidades as e WHERE e.dni = a.entidad ORDER BY a.id DESC LIMIT 5");
    $query->execute();
    $cuenta = $query->rowCount();
    $output = array();
    if($cuenta > 0){
      while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $output[] = $row;
      }
    }else{
      $output = array(
        'Result' => 'NADA'
      );
    }

    $status_query = $mbd->prepare("SELECT * FROM alertas WHERE status = 0");
    $status_query->execute();
    $count = $status_query->rowCount();
    $data = array(
        'notification' => $output,
        'unseen_notification'  => $count
    );
    echo json_encode($data);
  }

?>