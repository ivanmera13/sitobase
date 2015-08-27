<?php
require_once '../../init.inc.php';
require_once DIR_ROOT.'/controllers/header.inc.php';

/*
 * al Pasar como parametro Prueba, 
 * asumimos que en la carpeta 
 * templates existe un archivo de nombre index
 */
$Contenido=new template("index");
$Contenido->asigna_variables(array(
				"titulo" => "pagina espanolete "
				));
/*
 * $ContenidoString contiene nuestra plantilla, ya con las variables asignadas, f�cil no?
 */				
$ContenidoString = $Contenido->muestra();
echo $ContenidoString;
?>