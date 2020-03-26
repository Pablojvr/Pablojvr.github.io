<?php

require_once '../modelos/mensajeModelo.php';
session_start();

    class mensajeControlador extends mensajeModelo{


        public function enviarMensajeControlador(){

            $mensaje=mainModelo::limpiarCadena($_POST["mensaje"]);
            $codigo=$_SESSION["nombre_EMP"];
            
            if($mensaje != ""){

                $consulta4=mainModelo::ejecutarConsultaSimple(" select id from usuario ");
                $numero=$consulta4->rowCount();
                if($numero>0){

                    $consulta5=mainModelo::ejecutarConsultaSimple("  select * from usuario where Estado = 'Activo' AND CuentaUsuario != '$codigo' ORDER BY RAND(); ");
                    $numero = $consulta5->rowCount();
                    if($consulta5->rowCount()>=1){

                        $row=$consulta5->fetch();
                        $codigoMensaje=mainModelo::generarCodigoAleatorio("MSJ","8",$numero);
                        $CodigoDestino=$row["CuentaUsuario"];
                        $fechaActual=date("Y-m-d");
                        $horaActual=date("h:i:s a");
                        $dataCuenta=[
                            "Codigo" => $codigoMensaje ,
                            "CuentaU" => $codigo,
                            "CuentaD" => $CodigoDestino,
                            "Mensaje" => $mensaje,
                            "Fecha" => $fechaActual,
                            "Hora" => $horaActual,
                            "Estado" => "Pendiente"
                        ]; 
                        
                        $guardarCuenta=mensajeModelo::enviarMensajeModelo($dataCuenta);
                        $consulta7=mainModelo::ejecutarConsultaSimple("update usuario set Estado = 'Inactivo' where CuentaUsuario = '$CodigoDestino';");
                        
                        if($consulta7->rowCount()>=1){
                        $alerta=[
                            "Alerta" => "limpiar",
                            "Titulo" => "Post enviado :)",
                            "Texto" => "Gracias por confiar, alguien en algún lugar del mundo respondera pronto, paciencia :)",
                            "Tipo" => "success"
                        ];
                    }else{

                        $alerta=[
                            "Alerta" => "simple",
                            "Titulo" => "Post no enviado :(",
                            "Texto" => $CodigoDestino,
                            "Tipo" => "error"
                        ];

                    }
                
                    }else{

                        $consulta6=mainModelo::ejecutarConsultaSimple("select CuentaUsuario from usuario ORDER BY RAND(); ");
                        $row=$consulta6->fetch();
                        $codigoMensaje=mainModelo::generarCodigoAleatorio("MSJ","8",$numero);
                        $CodigoDestino=$row["CuentaUsuario"];
                        $fechaActual=date("Y-m-d");
                        $horaActual=date("h:i:s a");
                        $dataCuenta=[
                            "Codigo" => $codigoMensaje ,
                            "CuentaU" => $codigo,
                            "CuentaD" => $CodigoDestino,
                            "Mensaje" => $mensaje,
                            "Fecha" => $fechaActual,
                            "Hora" => $horaActual,
                            "Estado" => "Pendiente"
                        ]; 
                        
                        $guardarCuenta=mensajeModelo::enviarMensajeModelo($dataCuenta);
                        $alerta=[
                            "Alerta" => "limpiar",
                            "Titulo" => "Post enviado :)",
                            "Texto" => $CodigoDestino,
                            "Tipo" => "success"
                        ];

                    }


                }else{

                    $alerta=[
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio un error",
                        "Texto" => "No hay usuarios registrados ):",
                        "Tipo" => "error"
                    ];

                }




            }else{

                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Que sucede? ):",
                    "Texto" => "Puedes escribir luego, pero tu mensaje debe de contener algo ):",
                    "Tipo" => "error"
                ];


            }

            return mainModelo::sweetAlert($alerta);

        }




    }