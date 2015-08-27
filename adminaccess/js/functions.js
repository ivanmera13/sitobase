$('#login_bttn').click(function() {
	//Se verifica que el valor del campo este vacio
    //Se eliminan espacios en blanco con trim()
    if ($('#inputUsername3').val().trim() === '') {
        //alert('El campo esta vacio');
		swal("Oops...", "Field Username is empty!", "error");    
        $('#inputUsername3').focus();
        $('#inputUsername3').css({'background-color' : '#FFCFCF'});
    }else if ($('#inputPassword3').val().trim() === '') {
     	   //alert('El campo esta vacio');
     	   swal("Oops...", "Field Password is empty!", "error");
       		 $('#inputPassword3').focus();
       		 $('#inputPassword3').css({'background-color' : '#FFCFCF'});
    }else{
		$('#formlogin').attr("action", 'access.php');  
    	$('#formlogin').submit();
    }
});


// verificamos que sea escrito bien el mail
$('#checkmail_bttn').click(function() {
	//Se verifica que el valor del campo este vacio
    //Se eliminan espacios en blanco con trim()
    if ($('#inputUsermail').val().trim() === '') {
        //alert('El campo esta vacio'); 
        swal("Oops...", "Field Email is empty!", "error");       
        $('#inputUsermail').focus();
        $('#inputUsermail').css({'background-color' : '#FFCFCF'});
    }else if($("#inputUsermail").val().indexOf('@', 0) == -1 || $("#inputUsermail").val().indexOf('.', 0) == -1){
    	 	//alert('Email no valido');
    	 	swal("Oops...", "The Email is not valid!", "error");
    	 	$('#inputUsermail').focus();
        	$('#inputUsermail').css({'background-color' : '#FFCFCF'});
    }else{
    	$('#checkmail').attr("action", 'access.php');
    	$('#checkmail').submit();
    }
});

// verificamos que sea escrito bien el password
$('#resetPass_bttn').click(function() {
	//Se verifica que el valor del campo este vacio
    //Se eliminan espacios en blanco con trim()
     if ($('#inputPassword3').val().trim() === '') {
        //alert('El campo esta vacio');
        swal("Oops...", "Field Password is empty!", "error");        
        $('#inputPassword3').focus();
        $('#inputPassword3').css({'background-color' : '#FFCFCF'});
    }else if ($('#inputPassword32').val().trim() === '') {
     	   //alert('El campo esta vacio');
     	   swal("Oops...", "Field Re-type Password is empty!", "error");
       		 $('#inputPassword32').focus();
       		 $('#inputPassword32').css({'background-color' : '#FFCFCF'});
    }else{
    	if($('#inputPassword3').val() == $('#inputPassword32').val()){
    		$('#reset').attr("action", 'access.php');  
    		$('#reset').submit();
    	}else{
    		//alert('El Password no son iguales');
    		swal("Oops...", "Passwords are not the same!", "error");
    	}
		
    }
});
