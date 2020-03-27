<?php

require_once '../core/mainModelo.php';
require_once "../core/configGeneral.php";

    class mensajeModelo extends mainModelo{

        
        protected function enviarMensajeModelo($datos){ 
        $sql=mainModelo::conectar()->prepare("Insert into mensaje(CodigoMensaje,CuentaUsuario,CuentaDestino,CuerpoMensaje,CuerpoRespuesta,FechaEnvio,HoraEnvio,Estado) 
        values(:Codigo,:CuentaU,:CuentaD,:Mensaje, :Respuesta ,:Fecha,:Hora,:Estado)");
        
        $sql->bindParam(":Codigo",$datos['Codigo']);
        $sql->bindParam(":CuentaU",$datos['CuentaU']);
        $sql->bindParam(":CuentaD",$datos['CuentaD']);
        $sql->bindParam(":Mensaje",$datos['Mensaje']);
        $sql->bindParam(":Respuesta",$datos['Respuesta']);
        $sql->bindParam(":Fecha",$datos['Fecha']);
        $sql->bindParam(":Hora",$datos['Hora']);
        $sql->bindParam(":Estado",$datos['Estado']);
        $sql->execute();
        return $sql;




        }

        protected function recibirMensajeModelo($codigoSesion){
            $sql=mainModelo::conectar()->prepare(" select * from mensaje where CuentaDestino = :Codigo and Estado = 'Pendiente';");
            $sql->bindParam(":Codigo",$codigoSesion);
            $sql->execute();
            return $sql;
        }

        protected function respuestaMensajeModelo($codigoSesion){
            $sql=mainModelo::conectar()->prepare(" select * from mensaje where CuentaDestino = :Codigo and Estado = 'Pendiente';");
            $sql->bindParam(":Codigo",$codigoSesion);
            $sql->execute();
            return $sql;
        }

        protected function actualizarMensajeModelo($datos){ 
            $sql=mainModelo::conectar()->prepare("update mensaje set 
            CuerpoRespuesta = :Respuesta,
            FechaRespuesta = :Fecha,
            HoraRespuesta = :Hora,
            Estado = :Estado where CodigoMensaje = :Codigo
            ");
            
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Respuesta",$datos['Respuesta']);
            $sql->bindParam(":Fecha",$datos['Fecha']);
            $sql->bindParam(":Hora",$datos['Hora']);
            $sql->bindParam(":Estado",$datos['Estado']);
            $sql->execute();
            return $sql;
    
    
    
    
            }

        public function numeroMensajesModelo($destino){
            $sql=mainModelo::conectar()->prepare("select idMensaje from mensaje where CuentaDestino = :Destino and Estado = 'Pendiente'" );
            $sql->bindParam(":Destino",$destino);
            $sql->execute();
            return $sql;
        }

        protected function recibirConversacionModelo($codigoSesion){
            $sql=mainModelo::conectar()->prepare(" select  * from mensaje where CuentaUsuario = :Codigo and Estado = 'Leido' order by idMensaje desc limit 1;");
            $sql->bindParam(":Codigo",$codigoSesion);
            $sql->execute();
            return $sql;
        }

        public function numeroConversacionesModelo($destino){
            $sql=mainModelo::conectar()->prepare("select idMensaje from mensaje where CuentaUsuario = :Destino and Estado = 'Leido'" );
            $sql->bindParam(":Destino",$destino);
            $sql->execute();
            return $sql;
        }

        protected function finalizarConversacionModelo($codigo){

            $sql=mainModelo::conectar()->prepare("update mensaje set Estado = 'Exito' where CodigoMensaje = :Codigo");
            $sql->bindParam(":Codigo",$codigo);
            $sql->execute();
            return $sql;
        }







    }