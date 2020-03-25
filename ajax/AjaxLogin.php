<?php
require_once "../core/configGeneral.php";
if ( isset($_POST['username']) ){
    require_once "../controladores/usuarioControlador.php";
    $insAdmin = new usuarioControlador();

    if( isset($_POST['username'])){
        echo $insAdmin->agregarUsuarioControlador(); 
    }


} else {
    session_start();
    session_destroy();
    echo '<script> window.location.href="'.SERVERURL.'"</script>';
}