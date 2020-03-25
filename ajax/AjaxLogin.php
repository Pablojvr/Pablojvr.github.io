<?php
require_once "../core/configGeneral.php";

if(isset($_GET['Token'])){
    echo '<script>alert("llego hasta cerrarsesion Controlador")</script>;';
    require_once "../controladores/loginControlador.php";
    $Lc=new loginControlador();
    echo $Lc->cerrarSesionControlador();


}

if ( isset($_POST['username']) ){
    require_once "../controladores/usuarioControlador.php";
    $insAdmin = new usuarioControlador();

    if( isset($_POST['username'])){
        session_start();
        echo $insAdmin->agregarUsuarioControlador();
    }


} else {
    session_start();
    session_destroy();
}