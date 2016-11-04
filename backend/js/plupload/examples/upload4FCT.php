<?php
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

#!! IMPORTANT: 
#!! this file is just an example, it doesn't incorporate any security checks and 
#!! is not recommended to be used in production environment as it is. Be sure to 
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('resize.php');
require_once('RandKey.php');
require_once('../../../Connections/PMS.php');//連接DB
/* 
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";

//設定資料夾名
$album_id = $_GET['a_id'];//相簿ID
$eventdate = $_GET['eventdate'];;//活動日期

$file_dir = $eventdate."_".$album_id ;//資料夾名稱

$targetDirL = "../../../uploads/L/".$file_dir;
$targetDirS = "../../../uploads/S/".$file_dir;
$targetDir = $targetDirL;

$rand = RandKey(6);
$fileName = $_GET['a_id']."_".$rand.".jpg";

$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDirL)) {
	@mkdir($targetDirL);
}

// Create target dir
if (!file_exists($targetDirS)) {
	@mkdir($targetDirS);
}

// Get a file name
/*
if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}
*/

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files	
if ($cleanupTargetDir) {
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// If temp file is current file proceed to the next
		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}	


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
} else {	
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
}

while ($buff = fread($in, 4096)) {//4096)) {
	fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
	// Strip the temp .part suffix off 
	rename("{$filePath}.part", $filePath);
	
	$photo_L_url = $targetDirL."/".$fileName ;
	$photo_S_url = $targetDirS."/".$fileName ;
	
	//將檔案名插入在資料庫中
	$a_id = $_GET['a_id'];
	$file_name = $fileName;
	$u_id = $_GET['u_id'];

	//function
	if (!function_exists("GetSQLValueString")) {
		function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
		{
		  if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		  }

		  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

		  switch ($theType) {
				case "text":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;    
				case "long":
				case "int":
				  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
				  break;
				case "double":
				  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				  break;
				case "date":
				  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				  break;
				case "defined":
				  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				  break;
		  }
		  return $theValue;
		}
	}

	$insertSQL = sprintf("INSERT INTO picture ( a_id, file_name , u_id ) VALUES ( %s, %s, %s)",
					   GetSQLValueString($a_id, "int"),
					   GetSQLValueString($file_name, "text"),
					   GetSQLValueString($u_id, "int"));
	echo $insertSQL;
	mysql_select_db($database_PMS, $PMS);
	$Result_Picture = mysql_query($insertSQL, $PMS) or die(mysql_error());
	//[結束]寫入資料庫
	
	//縮圖
	ImageResize( $photo_L_url , $photo_S_url , 320 , 320);
	
	sleep(2);
	
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

mysql_free_result($Result_Picture);//clear the db