<?php
# Defines the rutas 
# preguntamos si la ruta es localhost o si es del servidor de cualquier manera este archivo tomara valores desde un xml con las rutas 
# Carga un archivo XML

$road = new SimpleXMLElement('C:\Program Files (x86)\Apache Software Foundation\Apache2.2\htdocs\test_sitios\sitobase\xmls/road.xml', null, true);

#definimos las rutas 
foreach( $road->load as $data ) {
	if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1')
	{
		if($data->title == 'localhost')
		{
			define('DIR_FILESYSTEM_DOCUMENT_ROOT', $data->url );
		}
	}else{
		// define access to server 
		define('DIR_FILESYSTEM_DOCUMENT_ROOT', $data->url);
	}
	
}

define("DIR_ROOT", DIR_FILESYSTEM_DOCUMENT_ROOT);




?>