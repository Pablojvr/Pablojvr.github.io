<?php 
	class vistasModelo{
		protected function obtener_vistas_modelo($vistas){
			$listaBlanca=["contact","about","main","register"];
			if(in_array($vistas, $listaBlanca)){
				if(is_file("./vistas/".$vistas.".php")){
					$contenido="./vistas/".$vistas.".php";
				}else{
					$contenido="login";
				}
			}elseif($vistas=="login"){
				$contenido="login";
			}elseif($vistas=="index"){
				$contenido="login";
			}else{
				$contenido="404";
			}
			return $contenido;
		}
	}