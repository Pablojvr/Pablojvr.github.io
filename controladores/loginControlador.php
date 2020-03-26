<?php
    require_once '../modelos/loginModelo.php';
    require_once '../core/configGeneral.php';

    class loginControlador extends loginModelo{

        public function iniciarSesionControlador(){

            if(isset($_POST["username"]) && isset($_POST["pass"])){

                $usuario=mainModelo::limpiarCadena($_POST["username"]);
                $clave=mainModelo::limpiarCadena($_POST["pass"]);
                $clave=mainmodelo::encryption($clave);

                $datosLogin=[
                    "Usuario" => $usuario,
                    "Clave" => $clave
                ];

                $datosCuenta=loginModelo::iniciarSesionModelo($datosLogin);
                if($datosCuenta->rowCount()>=1){
                    $row=$datosCuenta->fetch();
                    session_start(['name' => 'EMP']);
                    $_SESSION['usuario_EMP']=$row["NombreUsuario"];
                    $_SESSION['nombre_EMP']=$row["CuentaUsuario"];
                    $_SESSION['token_EMP']=md5(uniqid(mt_rand(),true));
                    $_SESSION['estado_EMP']=$row["Estado"];
                    return $urlLocation = '<script>  location.reload(); </script>';

                }else{
                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error",
                    "Texto" => "Los datos no coinciden con ninguna cuenta registrada ):",
                    "Tipo" => "error"
                ];

                return mainModelo::sweetAlert($alerta);


            }

            }else{

                $alerta=[
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrio un error",
                    "Texto" => "Ingrese datos validos para iniciar sesión",
                    "Tipo" => "error"
                ];

                return mainModelo::sweetAlert($alerta);


            }



        }//Fin funcion IniciarSesionControlador

        public function cerrarSesionControlador(){
        $token=$_GET['Token'];
        $hora=date("h:i:s a");
        $datos=[
            "Usuario" => $_SESSION['usuario_EMP'],
            "Token_S" => $_SESSION['token_EMP'],
            "Token" => $token,
        ];

        return loginModelo::cerrarSesionModelo($datos);



        }




    }