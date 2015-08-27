<?php

$values = parse_ini_file("bases.ini", true);

if(!$values){
	// redireccionamos a la instalacion 
	echo 'no existe el archivo.ini redireccionamos a la configuracion de los motores<br>';
}elseif($values){
	foreach ($values as $val => $info)
	{
		
		if($val == 'desarrollo mysql')
		{
			define('DB_MOTOR', $info['mysql']); 
			define('DB_MS_SERVER', $info['profile']); 
			define('DB_MS_SERVER_USERNAME', $info['usuario']);
			define('DB_MS_SERVER_PASSWORD', $info['clave']);
			define('DB_MS_DATABASE', $info['base']);
			define('DB_MS_DATABASE_PORT', $info['puerto']);
		}
	}
}



	/**********************/
	/* SERVER DIRECTORIES */
	/**********************/
	// FS = Filesystem (physical)
	// WS = Webserver (virtual)
	// Files location
	
	/*define('DIR_FS_DOCUMENT_ROOT', DIR_ROOT);
	define("DIR_WS_INCLUDES", DIR_WS_LIBDIR.DB_MOTOR.'/');

	define('DIR_WS_ROOT', DIR_FS_DOCUMENT_ROOT);
	define('DIR_WS_FUNCTIONS', DIR_WS_INCLUDES.'/functions/');
	define('DIR_WS_CLASSES', DIR_WS_INCLUDES.'/classes/');
	
	echo DIR_WS_INCLUDES;*/
	
	
?>