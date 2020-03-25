
<?php

require_once "configAPP.php";
class mainModelo{


    protected function conectar(){

        try {
            $enlace = new PDO(DSN, USER, PASS);
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }


        return $enlace;
    }

    protected function ejecutarConsultaSimple($consulta){
        $respuesta=self::conectar()->prepare($consulta);
        $respuesta->execute();
        return $respuesta;
    }

    public function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }
    
    public function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    
    public function generarCodigoAleatorio($letra, $longitud, $num){
        for($i=1;$i<=$longitud;$i++){
            $numero=rand(0,9);
            $letra.=$numero; 
        }
        return $letra.$num;
    }

    public function limpiarCadena($cadena){
        $cadena=trim($cadena);
        $cadena=stripslashes($cadena);
        $cadena=str_ireplace("<script>","", $cadena);
        $cadena=str_ireplace("'","", $cadena);
        $cadena=str_ireplace("</script>","", $cadena);
        $cadena=str_ireplace("<script src","", $cadena);
        $cadena=str_ireplace("<script type=","", $cadena);
        $cadena=str_ireplace("SELECT * FROM","", $cadena);
        $cadena=str_ireplace("DELETE FROM","", $cadena);
        $cadena=str_ireplace("INSERT INTO","", $cadena);
        $cadena=str_ireplace("--","", $cadena);
        $cadena=str_ireplace("^","", $cadena);
        return $cadena;
    }

    public function sweetAlert($datos){
        if($datos['Alerta']=="simple"){
            $alerta="<script>swal(
                '".$datos['Titulo']."',
                '".$datos['Texto']."',
                '".$datos['Tipo']."'
              ) </script>";
        }elseif ($datos['Alerta']=="recargar") {
                        $alerta="<script>swal({
                            title: '".$datos['Titulo']."',
                            text: '".$datos['Texto']."',
                            icon: '".$datos['Tipo']."',
                            confirmButtonText: 'Aceptar'
                        }).then( function () {
                            location.reload();
                        
                        })</script>";
        }elseif ($datos['Alerta']=="limpiar"){
            $alerta="<script>swal({
                title: '".$datos['Titulo']."',
                text: '".$datos['Texto']."',
                icon: '".$datos['Tipo']."',
                confirmButtonText: 'Aceptar'
            }).then( function () {
                $('.FormularioAjax')[0].reset();
                location.reload();
            })</script>";



        }elseif ($datos['Alerta']=="limpiar2"){
            $alerta="<script>swal({
                title: '".$datos['Titulo']."',
                text: '".$datos['Texto']."',
                icon: '".$datos['Tipo']."',
                confirmButtonText: 'Iniciar sesión',
            }).then( function () {
                $('.FormularioAjax')[0].reset();
                window.location='contact.php';
            })</script>";



        }
        
        return $alerta;
    }


 }//Fin clase mainModelo