<?php
require_once('../init.inc.php');
require_once '../controllers/header.inc.php';
require_once '../controllers/classes/Accesslogin.class.php';
$admin = new Accesslogin();
$admin->authent();

$username = $admin->get_username();
$email = $admin->get_mailuserlogin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Administrator page</title>
    </head>
    <body>
        <fieldset>
            <legend>Welcome <?php echo $username[0]['name_user']; ?></legend>
                <p>
                    Here are some of the basic informations
                </p>
                <p>
                    Username: <?php echo $_SESSION['admin_login']; ?>
                </p>
                <p>
                    Email: <?php echo $email[0]['email_user']; ?>
                </p>
        </fieldset>
        <br><br><br>
         control de prueba <a href="carga.html">cargar algo </a>
        <br><br><br>
        <a href="logout.php?accion=logout&token=' . $_SESSION["token"] . '">Salir</a></p>
    </body>
</html>