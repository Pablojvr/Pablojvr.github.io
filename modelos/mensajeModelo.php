<?php

require_once '../core/mainModelo.php';
require_once "../core/configGeneral.php";

    class mensajeModelo extends mainModelo{

        
        protected function enviarMensajeModelo($datos){

            
        $sql=mainModelo::conectar()->prepare("Insert into mensaje(CodigoMensaje,CuentaUsuario,CuentaDestino,CuerpoMensaje,FechaEnvio,HoraEnvio,Estado) 
        values(:Codigo,:CuentaU,:CuentaD,:Mensaje,:Fecha,:Hora,:Estado)");
        
        $sql->bindParam(":Codigo",$datos['Codigo']);
        $sql->bindParam(":CuentaU",$datos['CuentaU']);
        $sql->bindParam(":CuentaD",$datos['CuentaD']);
        $sql->bindParam(":Mensaje",$datos['Mensaje']);
        $sql->bindParam(":Fecha",$datos['Fecha']);
        $sql->bindParam(":Hora",$datos['Hora']);
        $sql->bindParam(":Estado",$datos['Estado']);
        $sql->execute();
        return $sql;




        }




    }