<?php

require_once('init.inc.php');
require_once DIR_ROOT.'/controllers/functions/geoiploc.inc.php'; // Must include this

// ip must be of the form "192.168.1.100"
// you may load this from a database
// get ip
$ip = $_SERVER["REMOTE_ADDR"];
// ger info ip
$country = getCountryFromIP($ip);
$country_code = getCountryFromIP($ip, "code");
$country_abrev = getCountryFromIP($ip, "abbr");
$country_abrev = getCountryFromIP($ip, "name");

/* 
 * comparo la info con los datos que tengo en base de datos
 * buscamos por codigo y obtenemos el lenguaje del pais 
*/

$spanish = array('AR', 'BO', 'CL', 'CO', 'CR', 'CU', 
				 'EC', 'SV', 'ES', 'GT', 'GQ', 'HN', 
				 'MX', 'NI', 'PA', 'PY', 'PE', 'PR', 
				 'DO', 'UY', 'VE');

// for para recorrer
foreach($spanish as $value){
if($country_code === $value)
{
	header("Location: lang/es");
	die();
}else{
	header("Location: lang/en");
	die();
}
}
/*
if($country_code == 'es')
{
# redireccionamos a la carpeta en español
header("Location: http://mydomain.com/myOtherPage.php");
die();
}else{
#redireccionamos a la carpeta en ingles
header("Location: http://mydomain.com/myOtherPage.php");
die();
}*/




?>