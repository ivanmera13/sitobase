<?php
$control = $_GET['motor'];
if($control == 'mysql')
{
?>
<legend>Configure the database access for MySQL</legend>
<table>
<tr><td><label>Motor:</label></td><td><input type="text" id="mmotor" name="nmotor" disabled="disabled" value="mysql" /></td><tr>
<tr><td><label>Server:</label></td><td><input type="text" id="mserver" name="mserver" /></td><tr>
<tr><td><label>User:</label></td><td><input type="text" id="muser" name="muser" /></td><tr>
<tr><td><label>Password:</label></td><td><input type="text" id="mpass" name="mpass" /></td><tr>
<tr><td><label>Database:</label></td><td><input type="text" id="mdatabase" name="mdatabase" value="shop" /></td><tr>
</table>
<input type="hidden" id="config" value="mysql" />
<input style="border: #000 0px solid; color:#784016; font-weight:bold; background-color: #FFFFFF" value="Confirm" type="button" onclick="chargerOptions()">
<?php }else{?>
<legend>Configure the database access for Postgres</legend>
<table>
<tr><td><label>Motor:</label></td><td><input type="text" id="pmotor" name="pmotor" disabled="disabled" value="postgres7" /></td><tr>
<tr><td><label>Server:</label></td><td><input type="text" id="pserver" name="pserver" /></td><tr>
<tr><td><label>User:</label></td><td><input type="text" id="puser" name="puser" /></td><tr>
<tr><td><label>Password:</label></td><td><input type="text" id="ppass" name="ppass" /></td><tr>
<tr><td><label>Port:</label></td><td><input type="text" id="pport" name="pport" /></td><tr>
<tr><td><label>Encoding:</label></td><td><input type="text" id="pencoding" name="pencoding" value="UTF8" /></td><tr>
<tr><td><label>Schema:</label></td><td><input type="text" id="pschema" name="pschema" disabled="disabled" value="public"/></td><tr>
<tr><td><label>Database:</label></td><td><input type="text" id="pdatabase" name="pdatabase" value="shop" /></td><tr>
</table>
<input type="hidden" id="config" value="postgres" />
<input style="border: #000 0px solid; color:#784016; font-weight:bold; background-color: #FFFFFF" value="Confirm" type="button" onclick="chargerOptions()">
<?php }?>
