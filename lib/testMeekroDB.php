<?php 
	
	require_once('meekrodb.2.3.class.php'); 
	require_once('config.php'); 

	$results = DB::query("SHOW TABLES");
	foreach ($results as $row) {
	  echo $row["Tables_in_education"] . "\n";
	}
	
?>