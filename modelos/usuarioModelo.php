<?php

    require_once '../core/mainModelo.php';
    require_once "../core/configGeneral.php";
   

class usuarioModelo extends mainModelo {

    

    protected function agregarUsuarioModelo($datos){
        $sql=mainModelo::conectar()->prepare("Insert into usuario(CuentaUsuario,NombreUsuario,ClaveUsuario,Estado) 
        values(:Cuenta,:Nombre,:Clave,:Estado)");
        
        $sql->bindParam(":Nombre",$datos['Nombre']);
        $sql->bindParam(":Cuenta",$datos['Cuenta']);
        $sql->bindParam(":Clave",$datos['Clave']);
        $sql->bindParam(":Estado",$datos['Estado']);
        $sql->execute();
        return $sql;
        
        
    }









}