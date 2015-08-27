<?php
require_once('../init.inc.php');
require_once '../controllers/header.inc.php';
require_once '../controllers/classes/Accesslogin.class.php';
$admin = new Accesslogin();
$admin->logoutaction();
?>