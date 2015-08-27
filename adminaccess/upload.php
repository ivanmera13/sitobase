<?php
#	This page control the calls to upLoad.class.php 

require_once('../init.inc.php');
require_once '../controllers/header.inc.php';
require_once '../controllers/classes/UpLoad.class.php';


$up = new upload();
$test = $up->registerPostNews();

echo "<pre>"; print_r($test); echo "</pre>";

?>