
<?php

class mainModelo{


    protected function conectar(){

        try {
            $enlace = new PDO(DSN, USER, PASS);
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
        }


        return $enlace;
    }

    protected function ejecutar_consulta_simple($consulta){
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
    
    protected function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    
    protected function generarCodigoAleatorio($letra, $longitud, $num){
        for($i=1;$i<=$longitud;$i++){
            $numero=rand(0,9);
            $letra.=$numero; 
        }
        return $letra.$num;
    }

    protected function limpiarCadena($cadena){
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

    protected function sweetAlert($datos){
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



        }
        return $alerta;
    }


 }