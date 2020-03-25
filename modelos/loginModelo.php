<?php

require_once '../core/mainModelo.php';

class loginModelo extends mainModelo{


    protected function iniciarSesionModelo($datos){
        $sql=mainModelo::conectar()->prepare("select * from usuario where NombreUsuario = :Usuario AND ClaveUsuario = :Clave ");
        $sql->bindParam(":Usuario", $datos["Usuario"]);
        $sql->bindParam(":Clave", $datos["Clave"]);
        $sql->execute();
        return $sql;
       }
       protected function cerrarSesionModelo($datos){

        if ($datos['Usuario']!="" &&  $datos['Token_S']==$datos['Token'] ) {
            session_unset();
            session_destroy();
            $respuesta=1;

        }else {
           $respuesta ="mal token";
        }
        return $respuesta;
      }






} 