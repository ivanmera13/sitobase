
function loadOperationsMotor()
{
	$('#selectMotor').css('display', 'none');
	$('#showMotor').css('display', 'block');
	$('#configsql').css('display', 'block');
	
	var motor = $('#selectMotorDB').val();
	
	var toLoadMotor = 'install_components_files/esp_motor.php?motor='+motor;
	$.post(toLoadMotor,function (responseText)
	{	$('#showMotor').html(responseText);	})
	
	$('#configsql').html('Loading...');
	
	var toLoad = 'install_components_files/loadconfigmotor.php?motor='+motor;
	$.post(toLoad,function (responseText){
							
	$('#configsql').html(responseText);
	
	});	
	
}

function chargerOptions()
{
	$('#configsql').css('display', 'none');
	$('#showConfig').css('display', 'block');
	$('#showConfig').html('Loading...');
		
	var check = $('#config').val();
	if(check == 'mysql')
	{
		var mmotor = $('#mmotor').val();
		var mserver = $('#mserver').val();
		var muser = $('#muser').val();
		var mpass = $('#mpass').val();
		var mdb = $('#mdatabase').val();
		var url = 'motor='+check+'&engine='+mmotor+'&server='+mserver+'&user='+muser+'&pass='+mpass+'&db='+mdb;
	}else{
		var pmotor = $('#pmotor').val();
		var pserver = $('#pserver').val();
		var puser = $('#puser').val();
		var ppass = $('#ppass').val();
		var pport = $('#pport').val();
		var pencoding = $('#pencoding').val();
		var pschema = $('#pschema').val();
		var pdb = $('#pdatabase').val();
		var url = 'motor='+check+'&engine='+pmotor+'&server='+pserver+'&user='+puser+'&pass='+ppass+'&db='+pdb+'&port='+pport+'&encoding='+pencoding+'&schema='+pschema;
	}
	
	var toLoad1 = 'install_components_files/loadmotor.php?'+url;
	$.post(toLoad1, function(responseText){	$('#showConfig').html(responseText);	});
}

function backConfig(valor, motor, arreglo)
{
	$('#configsql').css('display', 'block');
	$('#showConfig').css('display', 'none');
	$('#configsql').html('Loading...');
	
	var check = valor;
	var array = arreglo.split(",");
	var motor = array[0];
	
	//load variables old
	var server = array[2];
	var user = array[3];
	var pass = array[4];
	var port = array[5];
	var encoding = array[7];
	var schema = array[8];
	var db = array[6];
		
	var toLoad = 'install_components_files/loadconfigmotor.php?motor='+motor;
	$.post(toLoad,function (responseText){
								
	$('#configsql').html(responseText);
	switch (check)
	{
		case "server":
			if(motor == 'mysql'){
				$("#mserver").val(server);	
				$("#muser").val(user);	
				$("#mpass").val(pass);	
				$("#mdb").val(db);	
				$("#mserver").focus();	
			}
			else
			{	
				$("#pserver").val(server);	
				$("#puser").val(user);	
				$("#ppass").val(pass);	
				$("#pdb").val(db);	
				$("#pport").val(port);
				$("#pencoding").val(encoding);
				$("#pserver").focus();
			}
			break;
		case "user":
			if(motor == 'mysql'){	
				$("#muser").val(user);	
				$("#mserver").val(server);	
				$("#mpass").val(pass);	
				$("#mdb").val(db);	
				$("#muser").focus();	}
			else
			{	
				$("#pserver").val(server);	
				$("#puser").val(user);	
				$("#ppass").val(pass);	
				$("#pdb").val(db);	
				$("#pport").val(port);
				$("#pencoding").val(encoding);
				$("#puser").focus();	
			}
			break;
		case "pass":
			if(motor == 'mysql'){
				$("#mserver").val(server);	
				$("#muser").val(user);	
				$("#mpass").val(pass);	
				$("#mdb").val(db);	
				$("#mpass").focus();	
				}
			else
			{	
				$("#pserver").val(server);	
				$("#puser").val(user);	
				$("#ppass").val(pass);	
				$("#pdb").val(db);	
				$("#pport").val(port);
				$("#pencoding").val(encoding);
				$("#ppass").focus();
			}
			break;
		case "db":
			if(motor == 'mysql'){
				$("#mserver").val(server);	
				$("#muser").val(user);	
				$("#mpass").val(pass);	
				$("#mdb").val(db);	
				$("#mdb").focus();	
			}
			else
			{
				$("#pserver").val(server);	
				$("#puser").val(user);	
				$("#ppass").val(pass);	
				$("#pdb").val(db);	
				$("#pport").val(port);
				$("#pencoding").val(encoding);
				$('#pdb').focus();
			}
			break;
		case "port":
			$("#pserver").val(server);	
			$("#puser").val(user);	
			$("#ppass").val(pass);	
			$("#pdb").val(db);	
			$("#pport").val(port);
			$("#pencoding").val(encoding);
			$('#pport').focus();
			break;
		case "encoding":
			$("#pserver").val(server);	
			$("#puser").val(user);	
			$("#ppass").val(pass);	
			$("#pdb").val(db);	
			$("#pport").val(port);
			$("#pencoding").val(encoding);
			$('#pencoding').focus();
			break;
		default:
			break;
	}
	
	});	
	
}

function changeOption(valor)
{
	var check = valor;
	switch (check){
		case "motor":
			window.location = "motors.php";
			break;
		case "operation":
			break;
		case "subscription":
			/*$("#selectCountry").css("display", "none");
			$("#showCountry").css("display", "block");
			$("#selectOperation").css("display", "none");
			$("#showOperati").css("display", "block");
			$("#selectSubscription").css("display", "block");
			$("#showSubscri").css("display", "none");
			$("#setdate").css("display", "none");
			$("#SetPeriod").css("display", "none");
			$("#showReport").css("display", "none");*/
			break;
	}
}
function processOptions(valor)
{
	$("#displayLastMsj").css("display", "block");
	$('#showConfig').css('display', 'none');
	$('#selectMotor').css('display', 'none');
	$('#showMotor').css('display', 'none');
	$('#container').css('display', 'none');
	var motor = valor;
	
	if(motor == "mysql")
	{
		var mmotor = $('#mmotor').val();
		var mserver = $('#mserver').val();
		var muser = $('#muser').val();
		var mpass = $('#mpass').val();
		var mdb = $('#mdb').val();
		var url = 'motor='+motor+'&engine='+mmotor+'&server='+mserver+'&user='+muser+'&pass='+mpass+'&db='+mdb;
	}else{
		var pmotor = $('#pmotor').val();
		var pserver = $('#pserver').val();
		var puser = $('#puser').val();
		var ppass = $('#ppass').val();
		var pport = $('#pport').val();
		var pencoding = $('#pencoding').val();
		var pschema = $('#pschema').val();
		var pdb = $('#pdb').val();
		var url = 'motor='+motor+'&engine='+pmotor+'&server='+pserver+'&user='+puser+'&pass='+ppass+'&db='+pdb+'&port='+pport+'&encoding='+pencoding+'&schema='+pschema;
	}
	var toLoad1 = 'install_components_files/instal_motor.php?'+url;
	$.post(toLoad1, function(responseText){	$('#displayLastMsj').html(responseText);	});	
	
}

