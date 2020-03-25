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






} 