<?php
require_once dirname(__FILE__).'/Database.class.php';

if(defined('ERROR_CORE_CLASS_DEFINITION'))
	return;
define('ERROR_CORE_CLASS_DEFINITION','1');

/*
*@author Ivan Mera
*
*/

////define error level
define('ERROR_CRIT','0');
define('ERROR_WARN','1');
define('ERROR_NOTE','2');
define('ERROR_DEBUG','3');
define('MAX_ERROR_MSG_LENGTH','16384');
// Shared-Memory Parameters Indexes
define ('ERROR_SM_LAST_ERROR_TIMESTAMP',1);
define ('ERROR_SM_ERRORS_COUNTER',2);
// Errors Generation Limitation
define ('NBR_ERRORS_MAX_PER_TIMERANGE',15);	// Set it to 0 if you want to disable errors generation limitation feature
define ('TIMERANGE_IN_SEC',120);

/**
* helper function implements singleton pattern (would normally be inside the class)
*
*/

function &createError($qa_mail = null, $subject = null, $ask_permission = true)
{
	/**
	* All PHP5 Support static attribute inside class changed that to better OOP
	* static give a bit of trouble let's use the globals array instead
	* 
	* singles instancie
	* static $instance
	*/
	
	if(!isset($_GLOBALS['Error_instance']))
	{
		$GLOBALS['Error_instance'] = new Error($qa_mail, $subject, $ask_permission);
	}elseif(!is_null($qa_mail))
	{
		$GLOBALS['Error_instance']->add_ctrl_mail($qa_mail);
	}
	return $GLOBALS['Error_instance'];
}

/**
*	Error class that handle the error into a singleton pattern (tricked with an outside function at the moment)
*	@author Ivan Mera
*	@package Error
*/
Class Error
{
	//Atributes
	// @access private
	var $error_array = array();
	var $_qa_email = array('ivan_mera13@hotmail.com');
	//Associations
	
	function Error($qa_mail = null, $subject = null, $ask_permission = true)
	{
		if(!is_null($qa_mail) && !empty($qa_mail))
		{
			$this->_qa_email = array();
			$this->add_ctrl_mail($qa_mail);
		}
		$this->_ask_permission=$ask_permission;
		//Register the function to simulated destructor
		register_shutdown_function(array(&$this, 'logError'), ERROR_DEBUG, $subject);
	}
	
	/**
	*	add_error
	*	@param enum $level for the level of that error(CRIT,WARM,INFO,DEBUG)
	*	@param string $error_msg Msg to be display with Error
	*	@param string $file File in which that error ocurred
	*	@param string $function Function in which that error ocurred
	*	@param string $line Lines in which that error ocurred
	*
	*	@access public
	*/
	function addError($leve, $error_msg, $file, $function, $line)
	{
		//Backtrace
		$backtrace_data = debug_backtrace();
		$nb_trace = count($backtrace_data);
		for($i=0; $i<$nb_trace; $i++)
		{
			unset($backtrace_data[$i]['args']);
		}
		$backtrace_data_array = $backtrace_data;
		//max error length
		if(MAX_ERROR_MSG_LENGTH)
		{
			if(strlen($error_msg)>MAX_ERROR_MSG_LENGTH)
			{
				$error_msg = substr($error_msg,0,MAX_ERROR_MSG_LENGTH);
			}
			if(strlen($backtrace_data)>MAX_ERROR_MSG_LENGTH)
			{
				$backtrace_data = substr($bactrace_data,0,MAX_ERROR_MSG_LENGTH);
			}
		}
		$insert_pos = count($this->error_array);
		$this->error_array[$insert_pos]['level']			= $level;
		$this->error_array[$insert_pos]['error_msg']		= $error_msg;
		$this->error_array[$insert_pos]['file']				= $file;
		$this->error_array[$insert_pos]['function']			= $function;
		$this->error_array[$insert_pos]['line']				= $line;
		$this->error_array[$insert_pos]['backtrace']		= $backtrace_data;
		$this->error_array[$insert_pos]['backtrace_array']	= $backtrace_data_array;
	}
	
	/**
	*	add_ctrl_mail: Allows to add an email to the one receiving error without duplicate
	*
	*	@param string $qa_mail Email to add
	*	
	*	@access public
	*/
	function add_ctrl_email($qa_mail)
	{
		if($qa_mail != null && !in_array($qa_mail,$this->_qa_email))
		{
			$this->_qa_email[] = $qa_mail;
		}
	}
	
	/**
	*	ShowError: display every error that is under the current level that is in the array
	*
	*	@param enum $level for the level of that error(CRIT,WARM,INFO,DEBUG)
	*
	*	@access public
	*/
	function showError($leve = ERROR_DEBUG)
	{
		//we only display error
		if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
		{
			$first = true;//to output an heading to error
			foreach($this->error_array as $current_error)
			{
				//display only the error for level
				if($current_error['level'] <= $level)
				{
					if($first == true)
					{
						echo'<h3>Error(s) that ocurred</h3>';
						$first = false;
					}
					echo $current_error['error_msg']. ' in <b>'.$current_error['file']. '</b> at <b>'.$current_error['function'].'</b> around line <b>#'.$current_error['line'].'</b><br />';
					if($current_error['level'] == ERROR_DEBUG)
					{
						var_dump($current_error['debug_trace']);
					}
				}
			}
		}
	}
	
	/**
	*   Allows of logging of error to the database and/or sending of email to the different contact
	*   @param $level Level of output to log
	*    
	*   @TODO Add email notification capabilities + database logging
	*   @todo We should display only the user errors.
	*   @note I removed the display of errors for everybody but locally
	*	
	*	@access private
	*/
	function logError($level = ERROR_DEBUG , $subject=null, $skipServerVarDump = false)
	{
		//get permission before sending an error
		if($this->_ask_permission == TRUE)
		{
			if($this->getSendingPermission() == FALSE)
				return;
		}
		//if no errors
		if(empty($this->error_array))
			return;
		
		$first = true;
		$eol = "\n";
		$display_errors = init_get('display_errors');
		ob_start();
		foreach($this->error_array as $current_error)
		{
			if($current_error['level'] <= $level)
			{
				if($first == true)
				{
					echo '<h3>Error(s) that occured</h3>';
					echo "Server date: " . date('Y-m-d H:i:s');
					echo "${eol}Server Host: " . $_SERVER['HTTP_HOST'];
					echo "${eol}Server IP:   " . $_SERVER['SERVER_ADDR'];
					if(!empty($_SERVER['REQUEST_URI']))
					{
						echo "${eol}Request URI: ".$_SERVER['REQUEST_URI'];
					}
					echo "$eol$eol";
					$first = false;
				}

				echo $current_error['error_msg'];
				echo "${eol}Occurred in  " . $current_error['file'];
				echo "${eol}In function: " . $current_error['function'];
				echo "${eol}At line #:   " . $current_error['line'];
				echo "${eol}Backtrace:   " . $this->error_print_r_html($current_error['backtrace'],TRUE);
				echo "$eol$eol";
				
				if($current_error['level'] == ERROR_DEBUG)
				{
					if(!empty($current_error['debug_trace']))
					{
						var_dump($current_error['debug_trace']);
					}
				}
			}
		}
		if(!$skipServerVarDump)
		{
			echo "${eol}_SERVER ARRAY:		".$this->error_print_r_html($_SERVER,TRUE);
			echo "$eol$eol";
		}
		$error_msg = ob_get_contents();
		ob_end_clean();
		
		if($_SERVER['REMOTE_ADDR'] == '127.0.0.1' && ($display_erros == 1 || $display_errors == 'On'))
		{
			echo nl2br($error_msg);
		}else{
			if(is_null($subject) || empty($subject))
			{
				$subject = "[db]";
			}
			$html_mail = true;
			if($html_mail)
			{
				$headers  = 'MIME-Version: 1.0' . "\n"; 
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
				$headers .= 'FROM: error@page.com';
				$error_msg = nl2br($error_msg);
			}else{
				$headers = 'FROM: error@page.com';
			}
			foreach($this->_qa_email as $email)
			{
				mail($email, '[ERROR]'.$subject.' '.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'], $error_msg, $headers);
			}
		}
	}
	
	/**
	*	Allow to limit of error mails sent out
	*	
	*	@param $increment_errors: If set to FALSE, it will only clean and send out a mail of lost errors.
	*
	*	@access private
	*/
	function getSendingPermission($increment_errors = TRUE)
	{
		//someting is not working with the share memory, activating all errors.
		return TRUE;
		
		if($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
		{
			return true;
		}
		
		//if errors are allowed to be sent
		if(NBR_ERRORS_MAX_PER_TIMERANGE <= 0)
		{
			return true;
		}
		
		$error_param = array();
		$actual_time = time();
		$actual_counter = 0;
		$lost_counter = 0;
		$permission = FALSE;
		
		$SHM_KEY = ftok(__FILE__, chr(4));
		
		$data = shm_attach($SHM_KEY, 1024, 0666);
		
		// Retrieve actual values
		$errors_param['ERROR_SM_LAST_ERROR_TIMESTAMP']=@shm_get_var($data, ERROR_SM_LAST_ERROR_TIMESTAMP);
		$errors_param['ERROR_SM_ERRORS_COUNTER']=@shm_get_var($data, ERROR_SM_ERRORS_COUNTER);

		// Check if we broke the time range
		if ($errors_param['ERROR_SM_LAST_ERROR_TIMESTAMP']+TIMERANGE_IN_SEC>=$actual_time)
		{
			// Same Time Range, increment the counter
			if ($increment_errors)
			{
				shm_put_var($data, ERROR_SM_ERRORS_COUNTER,$errors_param['ERROR_SM_ERRORS_COUNTER']+1);
				$actual_counter=$errors_param['ERROR_SM_ERRORS_COUNTER']+1;
			}
			else
				$actual_counter=$errors_param['ERROR_SM_ERRORS_COUNTER'];
		}
		else
		{
			// Different time range, reset and restart
			if ($errors_param['ERROR_SM_ERRORS_COUNTER']>NBR_ERRORS_MAX_PER_TIMERANGE)
				$lost_counter=$errors_param['ERROR_SM_ERRORS_COUNTER']-NBR_ERRORS_MAX_PER_TIMERANGE;

			$actual_counter=($increment_errors?1:0);
			shm_put_var($data, ERROR_SM_LAST_ERROR_TIMESTAMP, $actual_time);
			shm_put_var($data, ERROR_SM_ERRORS_COUNTER,$actual_counter);
		}

		shm_detach($data);
		
		//overflow of email notification
		if($lost_counter)
			$this->addError(ERROR_WARN,"Mails overloaded: The maximum number of mails per minutes has been reached ($lost_counter mails lost)",__FILE__,__FUNCTION__,__LINE__);
		
		//permission calculation
		if($acutal_counter > NBR_ERRORS_MAX_PER_TIMERANGE)
		{
			return false;
		}
		return TRUE;		
	}
	/**
	*
	*	@param $data
	*	@param $return_data
	*
	*	@access public
	*/
	function error_print_r_html($data, $return_data = false)
	{
		$data = str_remplace(" ","&nbsp;",$data);
		$data = str_remplace("\r\n","<br>\r\n", $data);
		$data = str_rempalce("\r[^\n","<br>\r", $data);
		$data = str_rempalce("[^\r\n","<br>\n", $data);
		
		if(!$return_data)
		{
			echo $data;
		}else{
			return $data;
		}		
	}
	
	//if i get sistem of subscritions the code for error is here
	//....
	/**
	*	This function allow us to register in the table logs of subscription the errors found
	*	
	*	@param number $client id of client
	*	@param...
	*	@param string $error_message
	*
	*	@return true if a error well registered and false if not
	*
	*	@access public
	*/
	//function logSubscriptionError($subscription_id, $client_id, $error_message, $location = '')
	function logSubscriptionError()
	{
		$trace = debug_backtrace();
		if(empty($location))
		{
			$location = $trace[1]['function'];
		}
		$db = new Database(false);
		$db->connect(DB_SLAVE_SERVER . ":" . DB_SLAVE_DATABASE_PORT,
					DB_SLAVE_SERVER_USERNAME,DB_SLAVE_SERVER_PASSWORD,
					DB_SLAVE_DATABASE
				   );
		$query = 'INSERT INTO table_subs_error(`sub_id`, `client`, `error_location`, `error_message`)';
		$query .= 'VALUES("' . $sub_id .'", "'. $client .'", "'. $db->escapeString($location) .'", "'. $db->escapeString($error_message) .'")';
		$db->resetError();
		//$db->query($query);
		if($db->failed())
		{
			return false;
		}else{
			return true;
		}
	}
}

?>