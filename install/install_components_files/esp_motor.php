<?php
$motor= $_GET['motor'];
if($motor == 'mysql'){	$dmotor = "Mysql Database";	}else{	$dmotor = "Postgres Database";	}
echo '<li>Database Motor: ';
echo '<label>'.$dmotor.'</label>';
?><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="changeOption('motor');"> </li>
