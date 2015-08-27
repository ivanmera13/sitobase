<?php

//ini_set('memory_limit', "10M");
if(isset($_GET['debug']) && $_GET['debug'] == 1)
{
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
}

# Set start microtime
$service_microtime = microtime();
$service_time = time();

# Load config file
require DIR_ROOT.'/control/config.php';

# Load necesary failes conecctions
require DIR_WS_CLASSES.'Database.class.php';
//require DIR_WS_CLASSES.'db.class.php';
# Load templates config
require DIR_WS_CLASSES.'template.class.php';
require DIR_WS_CLASSES.'phpmailer.class.php';
require DIR_WS_CLASSES.'smtp.class.php';
require DIR_WS_CLASSES.'pop3.class.php';
require DIR_WS_FUNCTIONS.'consults.inc.php';
require DIR_WS_INCLUDES.'functions.inc.php';

# if is photographer page
$photograp = FALSE;
if($photograp){
	require DIR_WS_CLASSES.'Watimage.class.php';
}

$db = new Database();
# if sistem is dashboard call config stats

# Load querys DIR_WS_FUNCTIONS





?>