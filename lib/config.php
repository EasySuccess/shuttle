<?php	
		
	require_once('meekrodb.2.3.class.php'); 
	require_once('function.php');
	
	// Frontend Parameters
	DB::$user = "sqluser";
	DB::$password = "sqluser";
	DB::$dbName = "education";
	DB::$host = "localhost";
	date_default_timezone_set("Asia/Hong_Kong");
	
	// Backend Parameters
	$STD_IC_CARD_TOTAL = 2;  //Maximum IC Cards per student

	// // Backend Parameters
	// $hostname = "localhost";
	// $database = "kingipmo";
	// $username = "kingipmo";
	// $password = "e8R0ruVx";

	// $database = "education";
	// $local_username = "sqluser";
	// $local_password = "sqluser";

	// // $connection = mysql_pconnect($hostname, $username, $password) or trigger_error(mysql_error(),E_USER_ERROR); 
	// $connection = mysql_pconnect($hostname, $local_username, $local_password) or trigger_error(mysql_error(),E_USER_ERROR); 
	// mysql_set_charset('utf8',$connection);
?>