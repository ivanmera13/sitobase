<?php

//definimos las variables de acceso
/*define('DB_MOTOR', 'psql']); 
define('DB_PG_SERVER', $info['profile']); 
define('DB_PG_SERVER_USERNAME', $info['usuario']);
define('DB_PG_SERVER_PASSWORD', $info['clave']);
define('DB_PG_DATABASE', $info['base']);
define('DB_PG_DATABASE_PORT', $info['puerto']);
*/

//postgres
define('PGSQL_TIMEOUT_ERROR', 08004);
define('PGSQL_TIMEOUT_ERROR_2', 08003);
//mysql
define('MYSQL_TIMEOUT_ERROR', 2013);
define('MYSQL_TIMEOUT_ERROR_2', 2006);

//class to access install
class procinsta{

	protected $db_motor;
	protected $db_server;
	protected $db_username;
	protected $db_password;
	protected $db_database;
	protected $db_port;
	
	protected $db_link = false;
	protected $db_link_alt = false;
	protected $db_result = null;
	protected $queries = array();
	protected $db_conx;
	protected $db_conx_alternative;
	var $magic_quotes_gpc = false;
	var $debug_mode = false;
	var $debug_ip = array('127.0.0.1:8888');
	var $Error = false;
	var $Error_msg = null;
	var $lock_database = false;
	
	/*protected $;
	protected $;
	protected $;
	protected $;
	protected $;
	protected $;
	protected $;
	protected $;
	protected $;*/


	/**
	*	Funcion que nos permite verificar si el archivo contiene informacion
	*	
	*	@params
	*	$file: nombre del archivo que contiene las bases
	*
	*	@return 
	*/
	function procinstall($file){
		//verificamos que $file contenga algo
		if(isset($file) && $file != '')
		{
			//recorremos el archivo
			$values = parse_ini_file($file, true);
			if($values)
			{
				foreach ($values as $val => $info)
				{
					if($val == 'desarrollo postgres')
					{
						$this->db_motor = 'psql';
						$this->db_server = $info['profile']; 
						$this->db_username = $info['usuario'];
						$this->db_password = $info['clave'];
						$this->db_database = $info['base'];
						$this->db_port = $info['puerto'];
					}
					if($val == 'desarrollo mysql')
					{
						$this->db_motor = 'mysql';
						$this->db_server = $info['profile']; 
						$this->db_username = $info['usuario'];
						$this->db_password = $info['clave'];
						$this->db_database = $info['base'];
						$this->db_port = $info['puerto'];
					}
				}
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	
	/**
	*	Funcion para determinar que conexion usar 
	*/
	function configConn()
	{
		//conectamos al motor que este configurado
		if($this->db_motor == 'mysql')
		{
			return $this->mysqlConnect();
		}elseif($this->db_motor == 'psql')
		{
			return $this->psqlConnect();
		}else{
			return false;
		}
	}
	
	/**
	*	Funcion para conectar con el motro mysql 
	*/
	function mysqlConnect(){
		//hacemos la conexion 
		/*$this->db_link = @mysql_connect($this->db_server, $this->db_username, $this->db_password);
		if(!is_resource($this->db_link))
		{
			// cargar mensaje de error no conectado a la base de datos 
		}else{
			//seleccionamos la bases a usar
			$db = @mysql_select_db($this->db_database,$this->db_link);
			if(!is_resource($db))
			{
				//creamos la base de datos
			}
		}*/
		return 11;
	}
	
	/**
	*	Funcion para conectar con el motro psql
	*/
	function psqlConnect(){
		return 1;
	}
	
	/**
	*	funcion para determionar si es recursivo o no 
	*/
	function isRessource($ressource)
	{
		if(!is_resource($ressource))
		{
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
    *    Allows to execute a query on the current connection
    *    The result set is keep inside the object just inside fetch* to get then row by row
    *
    *    @access public
    *    @param string $query Query to execute on the database
	*    @return void
    */
	function query($query)
	{
		if($this->db_motor == 'mysql')
		{
			//hacemos la consulta
			$this->db_result = @mysql_query($query,$this->db_link);
			if(!$this->db_result)
			{
				//seteamos el error
				$error = mysql_error($this->db_link);
				if($error == MYSQL_TIMEOUT_ERROR || $error == MYSQL_TIMEOUT_ERROR_2)
				{
					//try to reconnect
					$this->db_link = 0;
					$this->mysqlConnect();
					$this->db_result = @mysql_query($query, $this->db_link);
					if(!$this->db_result)
					{
						$this->db_result = null;
						$this->show_error = '[Imposible execute] - Error try execute query';
						return $this->show_error;
					}
				}
			}else{
				$this->show_error = '[Imposible execute] - Error imposible execute query';
				return $this->show_error;
			}
		}
		if($this->db_motor == 'psql')
		{
			//hacemos la consulta
			$this->db_result = pg_query($this->db_link,$query);
			if(!$this->db_result)
			{
				//seteamos el error
				$error = pg_last_error($this->db_link);
				if($error == PGSQL_TIMEOUT_ERROR || $error == PGSQL_TIMEOUT_ERROR_2)
				{
					//try to reconnect
					$this->db_link = 0;
					$this->psqlConnect();
					$this->db_result = pg_query($this->db_link, $query);
					if(!$this->db_result)
					{
						$this->db_result = null;
						$this->show_error = '[Imposible execute] - Error try execute query';
						return $this->show_error;
					}
				}
			}else{
				$this->show_error = '[Imposible execute] - Error imposible execute query';
				return $this->show_error;
			}
		}
	}
	
	/**
	*	Funcion para cerrar conexion a la base de datos
	*/
	function close()
	{
		if ($this->isRessource($this->db_link))
		{
			if($this->db_motor == 'mysql')
			{
				$result = @mysql_close($this->db_link);
			}
			if($this->db_motor == 'psql')
			{
				$result = @pg_close($this->db_link);
			}
			$this->db_link = false;
		}
	}
	
	function fetchAssoc()
	{
		if($this->db_result != NULL)
		{
			if($this->db_motor == 'psql')
			{
				return pg_fetch_assoc($this->db_result);
			}
			if($this->db_motor == 'mysql')
			{
				return @mysql_fetch_assoc($this->db_result);
			}
		}else{
			return false; /// retorna el error de salida
		}
	}

	/**
	*/
	function escapeString($string)
	{
		if($this->isRessource($this->db_link))
		{
			if($this->db_motor == 'mysql')
			{
				return mysql_real_escape_string($string,$this->db_link);
			}
			if($this->db_motor == 'psql')
			{
				return pg_escape_string($this->db_link,$string);
			}
		}else{
			return false;
		}
	}
	
	function escapeStringLike($string)
	{
		if($this->isRessource($this->db_link))
		{
			if($this->db_motor == 'mysql')
			{
				return addcslashes(mysql_real_escape_string($string,$this->db_link), '%_');
			}
			if($this->db_motor == 'psql')
			{	
				return addcslashes(pg_escape_string($this->db_link, $string), '%_');
			}
		}
	}
	
	function numRows()
	{
		if($this->isResource($this->db_result))
		{
			if($this->db_motor == 'mysql')
			{
				return @mysql_num_rows($this->db_result);
			}
			if($this->db_motor == 'psql')
			{
				return pg_num_rows ($this->db_result);
			}
		}
	}
	
	function affectedRows()
	{
		if($this->db_result != null)
		{
			if($this->db_motor == 'mysql')
			{
				return @mysql_affected_rows($this->db_link);
			}
			if($this->db_motor == 'psql')
			{
				return pg_affected_rows($this->db_link);
			}
		}
	}
	
	function freeResult()
	{
		if($this->isRessource($this->db_result))
		{
			if($this->db_motor == 'mysql')
			{
				@mysql_free_result($this->db_result);
			}
			if($this->db_motor == 'psql')
			{
				pg_free_result($this->db_result);
			}
			$this->db_result = null;
		}
	}
	
	function fetchArray()
	{
		if($this->db_result != null)
		{
			if($this->db_motor == 'mysql')
			{
				return @mysql_fetch_array($this->db_result);
			}
			if($this->db_motor == 'psql')
			{
				return pg_fetch_array($this->db_result);
			}
		}
	}
	
	function fetchRow()
	{
		if($this->db_result != null)
		{
			if($this->db_motor == 'mysql')
			{
				return @mysql_fetch_row($this->db_result);
			}
			if($this->db_motor == 'psql')
			{
				return pg_fetch_row($this->db_result);
			}
		}
	}
	
	function failed ()
	{
		return $this->Error;
	}
	
	function setError($value = true)
	{
		$this->Error = $value;
		if($this->db_motor == 'mysql'){
			$this->Error_msg = @mysql_error($this->db_link);
		}
		if($this->db_motor == 'psql'){
			$this->Error_msg = pg_last_error($this->db_link);
		}
	}
	
	function resetError()
	{
		$this->Error = false;
	}
	
	function setLockDatabase($value)
	{
		$this->lock_database = $value;
	}
	
	/**
	*    getLockDatabase - Reset the failed flag to false
	*
	*    @access public
	*/
	function getLockDatabase()
	{
		return $this->lock_database;
	}
	
	function getQueryCount()
	{
		return $GLOBALS['query_count'];
	}
	
	function setDebugMode($status)
	{
		$this->debug_mode = (bool) $status;
	}
	
	/**
	*    Return an array with all the queries executed since the debug mode was set to TRUE;
    *
	*    @access public
    *    @param void
    *    @return string Queries to be debuged.
	*/
	function debugQueries()
	{
		if ($this->debug_mode == TRUE && (in_array($_SERVER['REMOTE_ADDR'],$this->debug_ip)))
		{
			ob_start();
			var_dump($this->queries);
			$queries = ob_get_contents();
			ob_end_clean();
			return $queries;
		}
	}
	
	/**
	* Return all tables of the DB where are onnected
	* @access public
	*/
	function getListOfTables()
	{
		$tables_return = array();
		$this->query("SHOW TABLES");//comparara si sirve para psql y mysql de la misma manera SELECT * FROM pg_catalog.pg_tables
		while($row = $this->fetchRow())
		{
			$tables_return[] = $row[0];
		}
		$this->freeResult();
		return $tables_return;
	}
	
	/**
	*	Do a query and return full result in array
	*	@access public
	*/
	function getAll($query){
		$data_return = array();
		$this->query($query);
		while($row = $this->fetchAssoc())
		{
			$data_return[] = $row;
		}
		$this->freeResult();
		return $data_return;
	}
	
	/**
	*	Do a query and return one result
	*	@access public
	*/
	function getOne($query)
	{
		$data_return = FALSE;
		$this->query($query);
		if($row = $this->fetchRow())
		{
			$data_return = $row[0];
		}
		$this->freeResult();
		return $data_return;
	}
	
	/**
	*	Same as tep_db_get_assoc(), only values are stored in an array
	*	for each key, allowing you to store several values
	*	for the same key.
	*	
	*	Optionally you can specify if values for each key are unique.
	*
	*	@param string Select SQL query
	*	@return array rows selected or empty array if no results found or error
	*
	*	@access public
	*	@see tep_db_get_assoc
	*/
	function getAssocMultiple($query, $unique=true)
	{
		$result = array();
		$this->query($query);
		while($row = $this->fetchAssoc())
		{
			$key = array_shift($row);
			if(empty($result[$key]))
			{
				$result[$key] = array();
			}
			if(count($row)>1)
			{
				$value = $row;
			}else{
				$value=current($row);
			}
			if(!$unique || !in_array($value, $result[$key]))
			{
				$result[$key][] = $value;
			}
		}
		$this->freeResult();
		return $result;
	}

	/**
	*    Check if their are un freed results and free them if possible
    *    and close the connection to mysql
	*
	*    @access public
    *    @param void
    *    @return void
	*/
	function __destruct()
	{
		if(!is_null($this->db_result))
		{
			$this->freeResult();
		}
	}

}


?>