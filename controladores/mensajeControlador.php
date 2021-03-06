<?php

require_once '../modelos/mensajeModelo.php';
@session_start();
    class mensajeControlador extends mensajeModelo{


        public function enviarMensajeControlador(){

            $mensaje=mainModelo::limpiarCadena($_POST["mensaje"]);
            $codigo=$_SESSION["nombre_EMP"];
            $nM=mensajeModelo::numeroMensajesModelo($_SESSION["nombre_EMP"]);

            if($nM->rowCount()==0){

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
                            "Respuesta" => "Sin registro",
                            "Fecha" => $fechaActual,
                            "Hora" => $horaActual,
                            "Estado" => "Pendiente"
                        ]; 
                        
                        $guardarCuenta=mensajeModelo::enviarMensajeModelo($dataCuenta);
                        
                        
                        if($guardarCuenta->rowCount()>=1){
                            $actUsuarioEstado=mainModelo::ejecutarConsultaSimple("update usuario set Estado = 'Inactivo' where CuentaUsuario = '$CodigoDestino';");
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

                        $consulta6=mainModelo::ejecutarConsultaSimple("  select * from usuario ORDER BY RAND(); ");
                        $numero = $consulta6->rowCount();
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
                            "Respuesta" => "Sin registro",
                            "Fecha" => $fechaActual,
                            "Hora" => $horaActual,
                            "Estado" => "Pendiente"
                        ]; 
                        
                        
                        $guardarCuenta=mensajeModelo::enviarMensajeModelo($dataCuenta);
                        if($guardarCuenta->rowCount()>=1){
                            $actUsuarioEstado=mainModelo::ejecutarConsultaSimple("update usuario set Estado = 'Inactivo' where CuentaUsuario = '$CodigoDestino';");
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
        }else{


            $alerta=[
                "Alerta" => "limpiar",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "Tienes una nueva notificación:D",
                "Tipo" => "info"
            ];




        }

            return mainModelo::sweetAlert($alerta);

        }//Fin enviar mensajeControlador


        public function recibirMensajeControlador(){
            $codigoSesion=$_SESSION['nombre_EMP'];
            
            $MensajesD=mensajeModelo::recibirMensajeModelo($codigoSesion);
            if($MensajesD->rowCount()>=1){
                $row=$MensajesD->fetch();
                $actUsuarioEstado=mainModelo::ejecutarConsultaSimple("update usuario set Estado = 'Activo' where CuentaUsuario = '$codigoSesion';");

                
                $alerta=[
                    "Alerta" => "respuesta",
                    "Titulo" => "Tienes un nuevo mensaje :D",
                    "Texto" => "Para publicar un nuevo mensaje necesitas responder",
                    "Tipo" => "info"
                ];

                

            }else{

            return "";

            }
            return mainModelo::sweetAlert($alerta); 

        }

        public function mostrarMensajeControlador(){

            $codigoSesion=$_SESSION['nombre_EMP'];
            $MensajesD=mensajeModelo::recibirMensajeModelo($codigoSesion);
            $m="";
            if($MensajesD->rowCount()>=1){
                $row=$MensajesD->fetch();
                $_SESSION["MSG"] = $row["CodigoMensaje"];
                $m.= '
                <div id="form" class="site-section bg-left-half" >
      <div  class="container " id="resp"> 
      <div class="col-lg-8">
              <h2 class="mb-5 text-primary font-weight-bold" >Mensaje anonimo</h2>
            </div> 
        <div class="row">
       
          <div class="col-lg-12 mb-5" >
            <form>      
              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="mensaje"  class="form-control" cols="30" rows="15" disabled>'.$row["CuerpoMensaje"].'</textarea>
                </div>
              </div>
              <div class="form-group row">
              <input  type="hidden" name="mc" value="'.$row["CodigoMensaje"].'">
                <div class="col-md-3 mr-auto">
                 <a href="#m" > <input type="button" class="btn btn-block btn-primary text-white py-3 px-5" value="Ir a respuesta"></a>
                </div>
              </div>
              
            </form>
          </div>
        </div>  
      </div>
    </div>
                ';
            }

            return $m;



        }


        public function  enviarRespuestaControlador(){

            $respuesta=mainModelo::limpiarCadena($_POST["respuesta"]);
            $mc=$_SESSION["MSG"];
            $codigo=$_SESSION["nombre_EMP"];

            if($respuesta!=""){

                $consulta5=mainModelo::ejecutarConsultaSimple("select * from mensaje where CodigoMensaje='$mc'; ");
                
                $numero=$consulta5->rowCount();
                if($numero>=1){
                    $row=$consulta5->fetch();

                    
                    $fechaActual=date("Y-m-d");
                    $horaActual=date("h:i:s a");
                    $dataCuenta=[
                            "Codigo" =>$mc ,
                            "Respuesta" => $respuesta,
                            "Fecha" => $fechaActual,
                            "Hora" => $horaActual,
                            "Estado" => "Leido"
                    ]; 

                    $guardarCuenta=mensajeModelo::actualizarMensajeModelo($dataCuenta);
                    
                

                    if($guardarCuenta->rowCount()>=1){
                        $actUsuarioEstado=mainModelo::ejecutarConsultaSimple("update usuario set Estado = 'Activo' where CuentaUsuario = '$codigo';");
                        
                        $alerta=[
                            "Alerta" => "limpiar3",
                            "Titulo" => "Respuesta enviada :)",
                            "Texto" => "Gracias por tomarte el tiempo para responder, alguien te lo agradecerá",
                            "Tipo" => "success"
                        ];




                    }else{

                        $alerta=[
                            "Alerta" => "simple",
                            "Titulo" => "Respuesta no enviada :(",
                            "Texto" => "Algo inesperado sucedió ):",
                            "Tipo" => "error"
                        ];

                    }

                }else{

                    $alerta=[
                        "Alerta" => "simple",
                        "Titulo" => "error inesperado ):",
                        "Texto" => "No hay mensajes para responder",
                        "Tipo" => "error"
                    ];


                }

            }else{

                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Que sucede? ):",
                    "Texto" => "Puedes responder luego, pero tu respuesta debe de contener algo ):",
                    "Tipo" => "error"
                ];


            }
            return mainModelo::sweetAlert($alerta); 







        }

        public function recibirConversacionControlador(){

            $codigoSesion=$_SESSION['nombre_EMP'];
            $MensajesD=mensajeModelo::recibirConversacionModelo($codigoSesion);
            $m="";
            if($MensajesD->rowCount()>=1){
                $row=$MensajesD->fetch();
                $_SESSION["MSG"] = $row["CodigoMensaje"];
                $m.= '

                
                <div id="form" class="site-section bg-left-half" >
      <div  class="container " id="resp"> 
      <div class="col-lg-8">
              <h2 class="mb-5 text-primary font-weight-bold" >Respuesta anonima</h2>
            </div> 
        <div class="row">
       
          <div class="col-lg-12 mb-5" >
            <form>      
              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="mensaje"  class="form-control" cols="30" rows="10" disabled>'.$row["CuerpoRespuesta"].'</textarea>
                </div>
              </div>
              <div class="form-group row">
              <input  type="hidden" name="mc" value="'.$row["CodigoMensaje"].'">
                <div class="col-md-3 mr-auto">
                </div>
              </div>
              
            </form>
          </div>
        </div>  
      </div>
    </div>

    <div  class="site-section bg-left-half">
      <div  class="container "> 
      <div class="col-lg-8">
              <h2  class="mb-5 text-primary font-weight-bold" >Respuesta a tu mensaje:</h2>
            </div> 
        <div class="row" id="m">
       
          <div class="col-lg-12 mb-5" >
            <form  class="FormularioAjax" data-form="read" action="http://localhost/empathy/EMP4THY/ajax/AjaxMensaje.php" method="post">      
              <div class="form-group row">
                <div class="col-md-12">
                  <textarea name="leido" id="" class="form-control" placeholder="Tomate tu tiempo ;)" disabled cols="30" rows="10">'.$row["CuerpoMensaje"].'</textarea>
                </div>
              </div>
              <div class="form-group row">
              <input  type="hidden" name="mc" value="'.$row["CodigoMensaje"].'">
                <div class="col-md-3 mr-auto">
                  <input type="submit" class="btn btn-block btn-primary text-white py-3 px-5" value="Marcar como leido :)">
                </div>
              </div>
              <div class="RespuestaAjax"></div>
            </form>
          </div>
        </div>  
      </div>
    </div>

    
                ';
            }

            return $m;



        }

        public function finalizarConversacionControlador(){
            
            $cM=$_POST["mc"];
            $resp=mensajeModelo::finalizarConversacionModelo($cM);
            if($resp->rowCount()>=0){

                $alerta=[
                    "Alerta" => "limpiar3",
                    "Titulo" => "Post enviado :)",
                    "Texto" => "Gracias por confiar, esperamos leerte pronto :)",
                    "Tipo" => "success"
                ];

            }else {
                
                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error inesperado",
                    "Texto" => "no se puede actualizar",
                    "Tipo" => "info"
                ];

            }

            return mainModelo::sweetAlert($alerta); 

        }




    }