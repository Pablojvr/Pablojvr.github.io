
<?php

require_once "../core/configGeneral.php";


//mensaje
if ( isset($_POST['mensaje']) ){
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
        if ( isset($_POST['mc']) ){
            require_once "../controladores/MensajeControlador.php";
            $insAdmin = new mensajeControlador();
            echo $insAdmin->finalizarConversacionControlador();
            
        
        
        }else{

            echo 'no enviado ):';


        }
    }
}

//Respuesta
