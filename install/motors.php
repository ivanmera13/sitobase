<?xml version="1.0" encoding="ISO-8859-1"?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<script src="../js/jquery.js" type="text/javascript"></script>   
		<script src="../js/controls.js" type="text/javascript"></script>   
		<?php include_once('install_components_files/base-head.php'); ?>
    </head>
    <body>
        <h1>Configure Database System</h1>
		<h2>Database Tool<h2>
		<div align="left" id="container">
			<fieldset id="fieldset">
				<legend id="legend">Enter Report Criteria</legend>
				<ol>
					<li id="selectMotor">
						<label>Configure Database Motor</label>
						<select name="motor" id="selectMotorDB" onchange="loadOperationsMotor();" />
							<option value="null">Choose Motor Database</option>
							<option value="mysql">Mysql Database</option>
							<!--option value="plsql">Postgres Database</option-->
						</select>						
					</li>
					<div id="showMotor" style="display:none;">
						<!--display Motor database-->
					</div>
				<!--Config sql Motor start-->
					<div id="configsql" style="display:none;">
					</div>
					<div id="showConfig" style="display:none;">
						<!--display Config database-->
					</div>
				</ol>
			</fieldset>	
		</div>
		<div id="displayLastMsj" style="display:none;">
			<!--display Config database-->
		</div>
		<div><br></div>
		<div id="footer">
			For tool support, please refer to 
			<a href="mailto:">Research &amp; Development Team </a>
		</div>
    </body>
</html>
