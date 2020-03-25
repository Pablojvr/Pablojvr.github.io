
<?php


  require_once "./controladores/vistasControlador.php";

		$vt = new vistasControlador();
		$vistasR=$vt->obtener_vistas_controlador();

    if($vistasR=="login" || $vistasR=="404"):
			if($vistasR=="login"){
        require_once "./vistas/main.php";
			}
			else{
				require_once "./vistas/404.php";		
			}
			
		else: 

      require_once $vistasR;

    endif;
?>
