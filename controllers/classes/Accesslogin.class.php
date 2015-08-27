<?php

/*
*	Main Class to control de access login 
*/
class Accesslogin{
	# script directory
	static $path_dir;
	
	# Storage the value of post variables 
	var $post = array();
	
	# Storage and decoded value of get variables
	var $get = array();
	
	# Variable to control key
	var $controlkey = null;
	
	# Variable to control key
	var $ivkey = null;
		
	# Variable to control mail reset
	var $email = null;
	
	# Construct
	function Accesslogin(){
		
		$this->controlkey = md5(sha1('Work is 1% inspiration plus 99% transpiration. A.E.'));
				
		session_start();
		
		// Initialize the directory no
		//self::
		
		// Initialize the post variable
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$this->post = $_POST;
			if(get_magic_quotes_gpc()){
				// Get rid of magic quotes and slashes if presente
				array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
			}
		}
		
		// Initialize the get variable
		$this->get = $_GET;
		
		// Decode the URl 
		array_walk_recursive($this->get, array($this, 'urldecode'));
		
	}	
	
	/*
	*	Function to return the name of currently logged in admin
	*	Return:
	*			$username (String): with the name the user
	*/
	
	function get_username(){
		$user_login = $_SESSION['admin_login'];
		$username = user_login_only($user_login);
		if($username){
			return $username;	
		}else{
			return FALSE;
		}
		
	}
	
	/*
	*	Function to return the email of currently logged user
	*	Return.
	*			$emailuser (String): with the name the user
	*/
	
	function get_mailuserlogin(){
		$user_login = $_SESSION['admin_login'];
		$emailuser = mail_login_only($user_login);
		return $emailuser;
	}
	
	/*
	*
	*/
	
	
	function encrdata($data){
		$data = serialize($data);
		$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
		$key = pack('H*',$this->controlkey);
		$mac = hash_hmac('sha256', $data, substr(bin2hex($key), -32));
		$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data.$mac, MCRYPT_MODE_CBC,$iv);
		$encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    	return $encoded;
	}
	
	function decrdata($data_encrypt){
		$data_encrypt = explode('|', $data_encrypt.'|');
		$decoded = base64_decode($data_encrypt[0]);
		$iv = base64_decode($data_encrypt[1]);
		if(strlen($iv) !== mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){
			 return false; 
		}
		$key = pack('H*',$this->controlkey);
		$decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
		$mac = substr($decrypted, -64);
		$decrypted = substr($decrypted, 0, -64);
		$calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
	    if($calcmac!==$mac){
	    	return false; 
		}
	    $decrypted = unserialize($decrypted);
	    return $decrypted;
	}
	
	function encrdata_copy($data){
		
		$algorithm = MCRYPT_BLOWFISH;
		$mode = MCRYPT_MODE_CBC;
		$iv = mcrypt_create_iv(mcrypt_get_iv_size($algorithm, $mode), MCRYPT_DEV_URANDOM);
		$this->ivkey = $iv;
		$encrypted_data = mcrypt_encrypt($algorithm, $this->controlkey, $data, $mode, $iv);
		$plain_text_encoded = base64_encode($encrypted_data);
		return $plain_text_encoded; 
		
	}
	
	function decrdata_copy($data_encrypt, $key){
		$algorithm = MCRYPT_BLOWFISH;
		$mode = MCRYPT_MODE_CBC;
		$iv = $key;
		$encrypted_data = base64_decode($data_encrypt);
		$decoded_text = mcrypt_decrypt($algorithm, $this->controlkey, $encrypted_data, $mode, $iv);
		return $decoded_text;
	}
	
	/*
	*	Check whether the user is authenticated to access or not
	*	Redirect to the login.php page if not authenticates otherwhise continue in the page
	* 	Return:
	*			(void)
	*/
	
	function authent(){
		$username_crypt = $this->crypcookie($_SESSION['admin_login']);
		$password_crypt = $this->crypcookie($_SESSION['admin_login'].'password');
		$remember_crypt = $this->crypcookie('issetremember');
		# First check whether session is set or not
		
		if(isset($_SESSION['admin_login'])){
			$lastaccess = $_SESSION["last_access"];
			$nowtime = date("Y-n-j H:i:s");
			$timelapse = (strtotime($nowtime)-strtotime($lastaccess));
			
			if($timelapse >= 7200){// if is more than 60 secs
				// destroy the session
				session_destroy();
				// if have any cookie
				if(isset($_COOKIE[$username_crypt]) && isset($_COOKIE[$password_crypt])){
					setcookie($username_crypt,'', time() - 7200 );
					setcookie($password_crypt,'', time() - 7200 );
				}
				header("location: login.php");
			}else{
				$_SESSION["last_access"] = $nowtime;
			}
			// return to any admin page
			
		}else if(isset($_COOKIE[$remember_crypt]) && $_COOKIE[$remember_crypt] != ''){
			if(isset($_COOKIE[$username_crypt]) && isset($_COOKIE[$password_crypt])){ # Check the cookie
				# decrypt 
				$username_by_cookie = $this->decrdata($_COOKIE[$username_crypt]);
				$password_by_cookie = $this->decrdata($_COOKIE[$password_crypt]);
				# Cookie found, is it really check
				if(verify_user($username_by_cookie, $password_by_cookie)){
					$_SESSION['admin_login'] = $username_by_cookie;
					$_SESSION["last_access"] = date("Y-n-j H:i:s");
					# Get username 
					$_SESSION['user_auth'] = $this->get_username();
					#redirect
					header("location: index.php");
					die();
				}else{
					header("location: login.php");
					die();
				}
			}else{
				header("location: login.php");
				die();
			}
		}else{
			header("location: login.php");
			die();
		}
	}
	
	function crypcookie($value){
		$data = md5($value);
		return $data;
	}
	
	/*
	*	Check For login in action file
	*	Return:
	*			(Void)
	*/
	
	function loginaction(){
		
		# Insuficient data Provided
		if(!isset($this->post['inputUsername3']) || $this->post['inputUsername3'] == ''
		|| !isset($this->post['inputPassword3']) || $this->post['inputPassword3'] == ''){
			header("location: login.php?errorusuario=si");
		}
				
		# Get the Username and Password
		$username = $this->post['inputUsername3'];
		$password = md5(sha1($this->post['inputPassword3']));
		
		/*
		* control to set cookies encripteds
		*/
		$username_cookie = $this->encrdata($username);
		$password_cookie = $this->encrdata($password);
		$setcookieRemb = $this->encrdata($username.'-'.$this->post['inputPassword3']);
		
		# Check into database for user
		$checkuser = verify_user($username,$password);
		
		if($checkuser){
			# ok ready to login 
			$_SESSION['admin_login'] = $username;
			$_SESSION['token'] = md5(uniqid(mt_rand(), true));
			$_SESSION["last_access"] = date("Y-n-j H:i:s");
			
			$username_crypt = $this->crypcookie($_SESSION['admin_login']);
			$password_crypt = $this->crypcookie($_SESSION['admin_login'].'password');
			$remember_crypt = $this->crypcookie('issetremember');
			
			# Check to see if remeber, ie if cookie
			if(isset($this->post['inputRemember'])){
				# Set the cookie for 2 hours, ie 7200 = 2 hours
				setcookie($username_crypt,$username_cookie, time() + 7200 );
				setcookie($password_crypt,$password_cookie, time() + 7200 );
				setcookie($remember_crypt,$setcookieRemb, time() + 86400 );
				
				# Put data in table
				
			}else{
				# destroy any previously set cookie
				setcookie($username_crypt,'', time() - 7200 );
				setcookie($password_crypt,'', time() - 7200 );
			}
			header("location: index.php");
		}else{
			header("location: login.php?errorusuario=si");
		}
		die();
	}

	/*
	*	Check For logout in action file
	*	Return:
	*			(Void)
	*/
	
	function logoutaction(){
		$_SESSION = array();
		setcookie($username_crypt,'', time() - 7200 );
		setcookie($password_crypt,'', time() - 7200 );
		session_destroy();
		header("location: login.php");
	}
	
	
	/*
	*	Check For login in action file
	*	Return:
	*			(Void)
	*/
	
	function checkmail(){
		if(!isset($this->post['inputUsermail']) || $this->post['inputUsermail'] == ''){
			header("location: forgot.php?error=yes");
		}
		$email = $this->post['inputUsermail'];
		if(isset($_SESSION['token'])){
			$token = $_SESSION['token'];
		}else{
			$token = md5(uniqid(mt_rand(), true));
		}
		
		# Verify email
		$checkmail = verify_mail($email);
		if($checkmail){
			$var = $this->encrdata($email);
			$_SESSION['reset_mail'] = $email;
			header("location: forgot.php?ct=".$token."&vf=yes&tr=".$var);
		}else{
			unset($_POST['inputUsermail']);
			unset($this->post['inputUsermail']);
			unset($this->email);
			header("location: forgot.php?error=yes");
		}
	}
	
	
	/*
	*	Check For reset password in action file
	*	Return:
	*			(Void)
	*/
	
	function resetPass(){
		if(!isset($this->post['inputPassword3']) || $this->post['inputPassword3'] == ''
		|| !isset($this->post['inputPassword32']) || $this->post['inputPassword32'] == ''){
			header("location: location: forgot.php?error=yes2");
		}
		$email = $_SESSION['reset_mail'];
		$this->sendInfoMail(); //die();
		$password = $this->post['inputPassword3'];
		$password2 = $this->post['inputPassword32'];
		if($password === $password2){
			
			$password_new = $password = md5(sha1($password));
			$reset = reset_pass($email, $password_new);
			if($reset){
				#mensaje de ok y redirect, mail de confirmacion
				
				$this->destroy_sess();
				header("location: login.php?reset=ok");
				die();
			}
		}
	}
	
	/**/
	function sendInfoMail(){
	# cargamos los datos que vamos a enviar el mail 
	
		$mail = array();
		$mail['addressUser'] = $_SESSION['reset_mail'];
		$mail['addressSend'] = 'info@algo.com';
		$mail['subject'] = '';
		$mail['body'] = '';
		//$mail['msjHtml'] = 'content.html';
		$mail['atach'] = array('images/phpmailer.gif','images/phpmailer_mini.gif');
		
		resetpassmail($mail);
		
	}
	
	
	/**/
	function destroy_sess(){
		session_destroy();
	}

	/*
	*	stripslash gpc
	*/
	
	protected function stripslash_gpc(&$value){
		$value = stripslashes($value);
	}
	
	/*
	 *	htmlspecialcarfy 
	 */
	 protected function htmlspecialcarfy(&$value){
		$value = htmlspecialchars($value);
	}

	/*
	 *	URL Decode 
	 */
	 protected function urldecode(&$value){
		$value = urldecode($value);
	}
}
?>