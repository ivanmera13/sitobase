<?php
// load values to create .ini file
if(isset($_GET))
{
	$var = array();
	$var = $_GET;	
	if($var['motor'] == 'mysql')
	{
		$contenido = "
[desarrollo mysql]
motor = ".$var['engine']."
profile = ".$var['server']."
usuario = ".$var['user']."
clave = ".$var['pass']."
puerto = 3306
base = ".$var['db']."
		";
	}else{
		$contenido="
[desarrollo postgres]
motor = ".$var['engine']."
profile = ".$var['server']."
usuario = ".$var['user']."
clave = ".$var['pass']."
puerto = ".$var['port']."
encoding = ".$var['encoding']."
schema = ".$var['schema']."
base = ".$var['db']."";

	}
	$fp=fopen("../../control/bases.ini","x"); //ruta donde se creara el archivo
	$fp2=fopen("../files_install/bases.ini","x"); //ruta donde se creara el archivo
	fwrite($fp,$contenido);
	fwrite($fp2,$contenido);
	fclose($fp) ;
	fclose($fp2) ;
}

?>
<br><br>
<fieldset id="fieldset">
<legend id="legend">Finish Configuration</legend><br><br>
<h1>The configuration database was created successfully</h1>
<h2>Continue with system installation </h2><br><br>
</fieldset>

