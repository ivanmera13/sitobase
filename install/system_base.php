<style type="text/css">
/*body{background-color: #000000;}*/
/*p {color: #FFFFFF;}*/
</style>
<?php


#install system base load information for install sistem
require_once('files_install/process.class.php');
$inst = new procinsta();
$test = $inst->procinstall('bases.ini');
$test1 = $inst->configConn(); // devuelve el link de la conexion para ejecutar las consultas

// here start process isntall down
var_dump($test1);

?>