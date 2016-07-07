<?php require_once('config.php'); ?>

<?php	

echo $servername;
function openMySQLConnection($servername, $username, $password, $dbname)
{ 
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} else {
		return $conn; // <--- Here
	}

}  

function openAzureConnection()  
{  

	try  
	{  

		$serverName = "tcp:simplexserver.database.windows.net,1433";  
		$connectionOptions = array("Database"=>"SiRDb1", "Uid"=>"sradmin_est", "PWD"=>"EA"."$"."Yadmin");  
		$conn = sqlsrv_connect($serverName, $connectionOptions);  
		
		if($conn == false)  {
			die(FormatErrors(sqlsrv_errors()));
			echo "失敗";
		}else{
			//echo "連結成功";
		}
		
		return $conn; // <--- Here
		
	}	
	catch(Exception $e)  
	{  
		echo("Error!");  
	}  

}  
?>