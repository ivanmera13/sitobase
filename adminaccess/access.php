<?php
// preparamos el llamdo dependiendo si es desde el login 
require_once('../init.inc.php');
require_once '../controllers/header.inc.php';
require_once '../controllers/classes/Accesslogin.class.php';

$admin = new Accesslogin();

if(isset($admin->post['inputUsermail']) && $admin->post['inputUsermail'] != ''){
	$admin->checkmail();
}else if((isset($admin->post['inputPassword3']) && $admin->post['inputPassword3'] != '') 
		&&(isset($admin->post['inputPassword32']) && $admin->post['inputPassword32'] != '')){
	$admin->resetPass();
}else{
	$admin->loginaction();
// si es logueo	
}


?>