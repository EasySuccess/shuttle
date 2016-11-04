<?php require_once('../Connections/cardsystem.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin,company";
$MM_donotCheckaccess = "false";
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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../noPermission.php";
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

mysql_select_db($database_cardsystem, $cardsystem);
$query_RecordsetUserLoginData = "SELECT tbuser.UserId, tbuser.UserName, tbco.CoFullName ,tbuser.CoCode FROM tbuser, tbco WHERE tbuser.UserName = '{$_SESSION['MM_Username']}'";
$RecordsetUserLoginData = mysql_query($query_RecordsetUserLoginData, $cardsystem) or die(mysql_error());
$row_RecordsetUserLoginData = mysql_fetch_assoc($RecordsetUserLoginData);
$totalRows_RecordsetUserLoginData = mysql_num_rows($RecordsetUserLoginData);

$_SESSION['CoCode'] = $row_RecordsetUserLoginData['CoCode'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../../favicon.ico">

    <title>FCT內部系統</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Card System</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="">帳號:</a></li>
            <li><a href="login.php">登出</a></li>
         </ul>

        </div><!--/.nav-collapse --> 	
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <h1>後台</h1>
        <p class="lead"></p>
      </div>
	  
        <div class="col-md-8">
            <div class="col-md-4">
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
							學生管理</h3>	
					  </div>
					  <div class="panel-body">
								<a type="button" class="btn btn-md" aria-label="Left Align" href="addStd.php" >新增學生</a><br>
								<a type="button" class="btn btn-md" aria-label="Left Align" href="listAllStd.php" >學生列表</a>
						</div>
					</div>
            </div>
                
                
             
             <div class="col-md-4">
					<div class="panel panel-default">
					  <div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
							IC卡管理</h3>	
					  </div>
					  <div class="panel-body">
                            <a type="button" class="btn btn-md" aria-label="Left Align" href=".php" >查詢IC卡</a><br>
                            <a type="button" class="btn btn-md" aria-label="Left Align" href=".php" >IC卡列表</a>
					  </div>
					</div>
            </div>
        </div>
        
        <div class="col-md-4">
				<div class="panel panel-default">
					  <div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
							帳號資訊</h3>	
					  </div>
					  <div class="panel-body">
								<b>帳號</b>:<?php echo $row_RecordsetUserLoginData['UserName']; ?><br>
								<b>公司</b>:<?php echo $row_RecordsetUserLoginData['CoFullName']; ?><br>
						</div>
					</div>
        </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
<?php
mysql_free_result($RecordsetUserLoginData);
?>
