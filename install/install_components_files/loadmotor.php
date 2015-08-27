<?php
if(isset($_GET))
{
	//load variables 
	$var = array();
	$var=$_GET;
	$union = implode(",", $var);
	if($var['motor'] == 'mysql')
	{?>
		<li><legend>Database access for MySQL</legend>
		<table>
		<tr><td><label>Motor:</label></td><td><?php echo $var['engine'];?></td><td>&nbsp;</td><tr>
		<tr><td><label>Server:</label></td><td><?php echo $var['server'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('server','mysql', '<?php echo $union; ?>');"></td><tr>
		<tr><td><label>User:</label></td><td><?php echo $var['user'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('user','mysql', '<?php echo $union; ?>');"></td><tr>
		<tr><td><label>Password:</label></td><td><?php echo $var['pass'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('pass','mysql', '<?php echo $union; ?>');"></td><tr>
		<tr><td><label>Database:</label></td><td><?php echo $var['db'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('db','mysql', '<?php echo $union; ?>');"></td><tr>
		</table></li>
		<input type="hidden" id="mmotor" value="<?php echo $var['engine'];?>" />
		<input type="hidden" id="mserver" value="<?php echo $var['server'];?>" />
		<input type="hidden" id="muser" value="<?php echo $var['user'];?>" />
		<input type="hidden" id="mpass" value="<?php echo $var['pass'];?>" />
		<input type="hidden" id="mdb" value="<?php echo $var['db'];?>" />
		<input style="border: #000 0px solid; color:#784016; font-weight:bold; background-color: #FFFFFF" value="Create Config" type="button" onclick="processOptions('mysql');">
	<?php }else{?>
	<li><legend>Database access for Postgres</legend>
	<table>
	<tr><td><label>Motor:</label></td><td><?php echo $var['engine'];?></td><td>&nbsp;</td><tr>
	<tr><td><label>Server:</label></td><td><?php echo $var['server'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('server','plsql', '<?php echo $union; ?>');"></td><tr>
	<tr><td><label>User:</label></td><td><?php echo $var['user'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('user','plsql', '<?php echo $union; ?>');"></td><tr>
	<tr><td><label>Password:</label></td><td><?php echo $var['pass'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('pass','plsql', '<?php echo $union; ?>');"></td><tr>
	<tr><td><label>Port:</label></td><td><?php echo $var['port'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('port','plsql', '<?php echo $union; ?>');"></td><tr>
	<tr><td><label>Encoding:</label></td><td><?php echo $var['encoding'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('encoding','plsql', '<?php echo $union; ?>');"></td><tr>
	<tr><td><label>Schema:</label></td><td><?php echo $var['schema'];?></td><td>&nbsp;</td><tr>
	<tr><td><label>Database:</label></td><td><?php echo $var['db'];?></td><td><input style="border: #000 0px solid; color:#ddd; background-color: #FFFFFF" value="Change" type="button" onclick="backConfig('db','plsql', '<?php echo $union; ?>');"></td><tr>
	</table></li>
	<input type="hidden" id="pmotor" value="<?php echo $var['engine'];?>" />
	<input type="hidden" id="pserver" value="<?php echo $var['server'];?>" />
	<input type="hidden" id="puser" value="<?php echo $var['user'];?>" />
	<input type="hidden" id="ppass" value="<?php echo $var['pass'];?>" />
	<input type="hidden" id="pport" value="<?php echo $var['port'];?>" />
	<input type="hidden" id="pencoding" value="<?php echo $var['encoding'];?>" />
	<input type="hidden" id="pschema" value="<?php echo $var['schema'];?>" />
	<input type="hidden" id="pdb" value="<?php echo $var['db'];?>" />
	<input style="border: #000 0px solid; color:#784016; font-weight:bold; background-color: #FFFFFF" value="Create Config" type="button" onclick="processOptions('plsql');">
	<?php }
}
?>