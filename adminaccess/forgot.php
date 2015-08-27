<?php

if(isset($_GET['error']) && $_GET['error'] == 'yes'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="badmail();">';
}elseif(isset($_GET['error']) && $_GET['error'] == 'yes2'){
	$html = '<script src="js/controladmin.js"></script>
	</head>	
	<body onload="badreset();">';
}else{
	$html = '</head>
	<body>';
}

if(isset($_GET['vf']) && $_GET['vf'] == 'yes'){
	$print = '<form class="form-horizontal" method="post" id="reset" >
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label" id="labeluser">Password</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="inputPassword3" id="inputPassword3" placeholder="Enter new password" >
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				      <input type="password" class="form-control" name="inputPassword32" id="inputPassword32" placeholder="Re-type Password" >
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button id="resetPass_bttn" class="btn btn-lg btn-primary btn-block" type="button">Reset Password</button>
				    </div>
				  </div>
			</form>';
}else{
	$print = '<form class="form-horizontal" method="post" id="checkmail" >
				  <div class="form-group">
				    <label for="inputemail" class="col-sm-2 control-label" id="labeluser">EMail</label>
				    <div class="col-sm-10">
				      <input type="mail" class="form-control" name="inputUsermail" id="inputUsermail" placeholder="Email" >
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <button id="checkmail_bttn" class="btn btn-lg btn-primary btn-block" type="button">Verify Email</button>
				    </div>
				  </div>
			</form-->';
}



?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    
    <title>{forgot}</title>

    <!--jquery-->
    <script src="../js/jquery.min.js"></script>
    <script src="js/sweet-alert.min.js"></script>
    
    <!--bootsrap-->
    <link href="css/bootstrap.css" rel="stylesheet">
     <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
    <link href="css/sweet-alert.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    
  <?php echo $html; ?>
  
  	<div id="ionic-header"> <!--Just released! Check out--> </div>
	<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="inner cover">
            <h2>{forgot}</h2>
          	<div class="cover-center">
      
			<?php echo $print;?>
		
			</div>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p>Reset Password</p>
            </div>
          </div>

        </div>

      </div>

    </div>
	<script src="js/functions.js"></script>
</body>