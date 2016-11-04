<?php require_once('../../../../Connections/PMS.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../../../../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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

$colname_Recordset_album = "-1";
if (isset($_GET['a_id'])) {
  $colname_Recordset_album = $_GET['a_id'];
}
mysql_select_db($database_PMS, $PMS);
$query_Recordset_album = sprintf("SELECT * FROM album WHERE a_id = %s", GetSQLValueString($colname_Recordset_album, "int"));
$Recordset_album = mysql_query($query_Recordset_album, $PMS) or die(mysql_error());
$row_Recordset_album = mysql_fetch_assoc($Recordset_album);
$totalRows_Recordset_album = mysql_num_rows($Recordset_album);
?>
<?
	$a_id = $_GET['a_id'];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>上傳圖片</title>

<link rel="stylesheet" href="../../js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />

<script src="../../../jquery.min.js"></script>

<!-- production -->
<script type="text/javascript" src="../../js/plupload.full.min.js"></script>
<script type="text/javascript" src="../../js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="../../js/zh_TW.js"></script>

<!-- debug 
<script type="text/javascript" src="../../js/moxie.js"></script>
<script type="text/javascript" src="../../js/plupload.dev.js"></script>
<script type="text/javascript" src="../../js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
-->


</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<form method="post" action="dump.php">	
	<h1 style="text-align:center">您正在為 <?php echo $row_Recordset_album['title']; ?>  相簿加入圖片!</h1>
	<h1 style="text-align:center">注意:請用心挑選相片再作上傳，謝謝！</h1>
  	<div id="uploader">
		<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
		<p>您的瀏覽不支援 , 請下載chrome再試.</p>
	</div>
	<!--input type="submit" value="Send" /-->
</form>

<script type="text/javascript">
$(function() {
	
	// Setup html5 version
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : '../upload4FCT.php?a_id=<?php echo $a_id?>&eventdate=<?php echo $eventdate?>&u_id=<?php echo $u_id?>',
		chunk_size: '2mb',
		unique_names : true,
		dragdrop: true,
		filters : {
			// Maximum file size
			max_file_size : '20mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,jpeg,JPG,JPEG"},
				{title : "Zip files", extensions : "zip"}
			]
		},

		// Resize images on clientside if we can
		resize : {width : 4500, height : 1777, quality : 90},//800w

		flash_swf_url : '../../js/Moxie.swf',
		silverlight_xap_url : '../../js/Moxie.xap'
	});

});
</script>

</body>
</html>
<?php
mysql_free_result($Recordset_album);
?>
