<?php
    include('clsUtilitarios.php');
    $accion = $_GET['parAccion'];
    $utilitarios = new Utilitarios;
    if($accion == 'iniciarSesion'){
        echo $utilitarios->iniciar_sesion($_GET['usuario'], $_GET['pass']);
    }
?>