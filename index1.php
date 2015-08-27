<?php

# index.php file 

// access folder
require_once('init.inc.php');
require_once DIR_ROOT.'/controllers/header.inc.php';

echo DIR_WS_DEBUG_IMAGES;


#obtenemos todas las ciudades con sus caracteristicas 
$a = country_list();

$b = regions_by_country();

$c = user_login();
arbol($c);
//$a = city_by_region();
//1399
/*echo "<pre>";
print_r($a);
echo "</pre>";
*/
//var_dump($a);


$test = "<select name='pais'>";
for($i=0;$i<count($a);$i++)
{
	$test .= "<option value=".$a[$i]['CountryId'].">".$a[$i]['Title']."</option>";
}
$test .= "</select>";

$test2 = "<select name='regiones'>";
for($i=0;$i<count($b);$i++)
{
	$test2 .= "<option value=".$b[$i]['RegionId'].">".$b[$i]['Region']."</option>";
}
$test2 .= "</select>";

echo $test2;


echo DIR_FS_DOCUMENT_ROOT;
?>

