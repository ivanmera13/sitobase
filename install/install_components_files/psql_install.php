<?php
echo "hola";
#install postgres content
$msj_install = array();
$msj_install_error = array();
$user = DB_PG_SERVER_USERNAME;
$passwd = DB_PG_SERVER_PASSWORD;
$db2 = 'postgres';
$db = DB_PG_DATABASE;
$port = DB_PG_DATABASE_PORT;
$host = DB_PG_SERVER;

#make a conecction with database
$strcon = "host=$host port=$port dbname=$db user=$user password=$passwd";
$conx = pg_connect($strcon);
echo "conexion exitosa";
if(!$conx){
	echo "error al conectar no existe la base";
	$msj_install_error[] = "Database ".$db." don't exist... try to install";
	$msj_install[] = "Create Database ".$db."....";
	#try connect to postgres make a alternative connection
	$strcon_aux = "host=$host port=$port dbname='postgres' user=$user password=$passwd";
	$conx_aux = pg_connect($strcon_aux);
	if($conx_aux)
	{
		echo "conexion auxiliar exitosa";
		#Create Database
		$sql = "CREATE DATABASE ".$db."
				WITH OWNER = postgres
				ENCODING = 'UTF8'
				TABLESPACE = pg_default
				LC_COLLATE = 'Spanish_Argentina.1252'
				LC_CTYPE = 'Spanish_Argentina.1252'
				CONNECTION LIMIT = -1;";

		$result = pg_query($conx_aux, $sql);
		if (!$result) {
			$msj_install_error[] = "Database ".$db." Imposible to install";
		}else{
			echo "base creada";
			pg_close($conx_aux);
			$conx_aux = "";
			#Try again to connect to Database
			//$conx = pg_connect($strcon);
		}
	}
}else {	#if exist connection
	echo "conectado";
	
	/**
	*	CREATE SCHEMAS
	*
	*	public is not necesary
	*	logs for check errors and control of system
	*	templates for new version or graphic entorne
	*	auditory for a backup of sistem
	*/

	#Array query of schemas
	$sql_sch = array();
	$sql_sch[] = "CREATE SCHEMA auditory";
	$sql_sch[] = "CREATE SCHEMA templates";
	$sql_sch[] = "CREATE SCHEMA logs";
	//$sql_sch[] = "CREATE SCHEMA auditory";

	#shot a cicle for create schemas
	for ($i=0; $i < count($sql_sch) ; $i++) { 
		#
		$result_fr[$i] = pg_query($conx, $sql_sch[$i]);
		if (!$result_fr[$i]) {
			#save log
			$msj_install_error[] = "Error created schema ".$sql_sch[$i];
		}else}{
			echo "schemas creados";
		}
	}
}


?>