<?php	

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup)
{
	// For security, start by assuming the visitor is NOT authorized. 
	$isValid = False;
	
	// When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
	// Therefore, we know that a user is NOT logged in if that Session variable is blank. 
	if (!empty($UserName)) {
		// Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
		// Parse the strings into arrays. 
		$arrUsers  = Explode(",", $strUsers);
		$arrGroups = Explode(",", $strGroups);
		if (in_array($UserName, $arrUsers)) {
			$isValid = true;
		}
		// Or, you may restrict access to only certain users based on their username. 
		if (in_array($UserGroup, $arrGroups)) {
			$isValid = true;
		}
		if (($strUsers == "") && false) {
			$isValid = true;
		}

	}
	return $isValid;
}

// MeekroDb have taken the following in consideration
// function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
// {
	// if (PHP_VERSION < 6) {
		// $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	// }
	
	// // $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	// $theValue = mysql_real_escape_string($theValue);
	
	// switch ($theType) {
		// case "text":
			// $theValue = ($theValue != "") ? $theValue : "NULL";
			// break;
		// case "long":
		// case "int":
			// $theValue = ($theValue != "") ? intval($theValue) : "NULL";
			// break;
		// case "double":
			// $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
			// break;
		// case "date":
			// $theValue = ($theValue != "") ? $theValue : "NULL";
			// break;
		// case "defined":
			// $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
			// break;
	// }
	// return $theValue;
// }