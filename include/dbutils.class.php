<?php
	/**
	 * esta clase se usa para operaciones de base de datos
	 */
	 
	 /**
	  * 
	  */ 
	
	class dbutils  {
		function __construct() {		
		}
		
		

		public function conecta() {
	    /***esta funcion establece la conexion a sql***/
		/***variables de conexion ***/
		$mysql_hostname = "localhost";
		$mysql_user = "root";
		$mysql_password = "";
		$mysql_database = "competencia";


		$mysqli = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
		if($mysqli->connect_errno > 0){
		    die('No se establecio conexion a la base de datos [' . $mysqli->connect_error . ']');
			return -1;
		}else{
				if(!$mysqli->set_charset("utf8")) {
    				die("Error cargando el conjunto de caracteres utf8: ". $mysqli->error);
				}else{
					return $mysqli;
				}
		
			}
    
	   }

		
        	
	}/*** fin de la clase ***/
	
