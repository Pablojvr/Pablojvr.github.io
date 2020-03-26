
<?php

require_once "../core/configGeneral.php";


if ( isset($_POST['mensaje']) ){
    require_once "../controladores/MensajeControlador.php";
    $insAdmin = new mensajeControlador();

    if( isset($_POST['mensaje'])){
        echo $insAdmin->enviarMensajeControlador();
    }


} else {
    echo 'Mensaje no enviado ): ';
}