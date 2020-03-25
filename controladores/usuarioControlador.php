<?php

    require_once '../modelos/usuarioModelo.php';


    class usuarioControlador extends usuarioModelo{

        public function agregarUsuarioControlador(){
            $nombre=mainModelo::limpiarCadena($_POST["username"]);
            $clave=mainModelo::limpiarCadena($_POST["pass"]);
            
            if($nombre != "" && $clave != ""){
               
            $consulta1=mainModelo::ejecutarConsultaSimple("select NombreUsuario from usuario where NombreUsuario = '$nombre'");
            if ($consulta1->rowCount()>=1) {
                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error",
                    "Texto" => "El Nombre que está tratatando de ingresar ya se encuentra registrado ):",
                    "Tipo" => "error"
                ];
            
            }else{
                
                $consulta4=mainModelo::ejecutarConsultaSimple(" select id from usuario ");
                $numero=($consulta4->rowCount())+1;
                $codigoCuenta=mainModelo::generarCodigoAleatorio("AC","8",$numero);
                $EncPass=mainModelo::encryption($clave);

                $dataCuenta=[
                    "Nombre" => $nombre,
                    "Cuenta" => $codigoCuenta,
                    "Clave" => $EncPass,
                    "Estado" => "Activo"
                ]; 

                $guardarCuenta=usuarioModelo::agregarUsuarioModelo($dataCuenta);

                if($guardarCuenta->rowCount()>=1){

                    $alerta=[
                        "Alerta" => "limpiar2",
                        "Titulo" => "Cuenta agregada",
                        "Texto" => "Ya puedes iniciar sesión",
                        "Tipo" => "success"
                    ];
                    


                }else{

                    $alerta=[
                        "Alerta" => "simple",
                        "Titulo" => "Ocurrio un error",
                        "Texto" => "La cuenta no pudo ser agregada",
                        "Tipo" => "error"
                    ];

                }

            }
        }else{

            $alerta=[
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error",
                "Texto" => "Ingrese valores correctos para los campos",
                "Tipo" => "error"
            ];

        }

            return mainModelo::sweetAlert($alerta);


        }//Fin Funcion agregarAdministradorControlador








    }
