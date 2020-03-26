
<?php

require_once "../core/configGeneral.php";


//mensaje
if ( isset($_POST['mensaje']) ){
    echo '<script>alert("ola");</script>';
    require_once "../controladores/MensajeControlador.php";
    $insAdmin = new mensajeControlador();

    if( isset($_POST['mensaje'])){
        echo $insAdmin->enviarMensajeControlador();
    }


} else {
    if ( isset($_POST['respuesta']) ){
        require_once "../controladores/MensajeControlador.php";
        $insAdmin = new mensajeControlador();
    
        if( isset($_POST['respuesta'])){
            echo $insAdmin->enviarRespuestaControlador();
        }
    
    
    } else {
        echo ' no enviado ): ';
    }
}

//Respuesta
