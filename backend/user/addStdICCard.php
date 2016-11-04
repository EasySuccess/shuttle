<?php require_once('../Connections/cardsystem.php'); ?>
<?php include("../config.php"); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin,company,staff";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//該學生的IC卡總數
$colname_RecordsetICCard = "-1";
if (isset($_GET['StuCode'])) {
  $colname_RecordsetICCard = $_GET['StuCode'];
}
mysql_select_db($database_cardsystem, $cardsystem);
$query_RecordsetICCard = sprintf("SELECT * FROM tbcard WHERE StuCode = %s", GetSQLValueString($colname_RecordsetICCard, "int"));
$RecordsetICCard = mysql_query($query_RecordsetICCard, $cardsystem) or die(mysql_error());
$row_RecordsetICCard = mysql_fetch_assoc($RecordsetICCard);
$totalRows_RecordsetICCard = mysql_num_rows($RecordsetICCard);
$this_STD_IC_total = $totalRows_RecordsetICCard;




$colname_RecordsetStd = "-1";
if (isset($_GET['StuCode'])) {
  $colname_RecordsetStd = $_GET['StuCode'];
}
mysql_select_db($database_cardsystem, $cardsystem);
$query_RecordsetStd = sprintf("SELECT * FROM tbstudent WHERE StuCode = %s", GetSQLValueString($colname_RecordsetStd, "int"));
$RecordsetStd = mysql_query($query_RecordsetStd, $cardsystem) or die(mysql_error());
$row_RecordsetStd = mysql_fetch_assoc($RecordsetStd);
$totalRows_RecordsetStd = mysql_num_rows($RecordsetStd);


//檢查該IC卡是否重覆
$colname_RecordsetThisCardTotal = "-1";
if (isset($_POST['CardId'])) {
  $colname_RecordsetThisCardTotal = $_POST['CardId'];
}
mysql_select_db($database_cardsystem, $cardsystem);
$query_RecordsetThisCardTotal = sprintf("SELECT * FROM tbcard WHERE CardId = %s", GetSQLValueString($colname_RecordsetThisCardTotal, "text"));
$RecordsetThisCardTotal = mysql_query($query_RecordsetThisCardTotal, $cardsystem) or die(mysql_error());
$row_RecordsetThisCardTotal = mysql_fetch_assoc($RecordsetThisCardTotal);
$totalRows_RecordsetThisCardTotal = mysql_num_rows($RecordsetThisCardTotal);
$this_IC_total = $totalRows_RecordsetThisCardTotal;//該卡號的使用次數

//插入資料
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	//插入資料前要作檢查 , ic card 是否重覆
	if($this_IC_total==0){
		//插入資料
		  $insertSQL = sprintf("INSERT INTO tbcard (CardId, CoCode, StuCode) VALUES (%s, %s, %s)",
							   GetSQLValueString($_POST['CardId'], "text"),
							   GetSQLValueString($_POST['CoCode'], "int"),
							   GetSQLValueString($_POST['StuCode'], "int"));
		
		  mysql_select_db($database_cardsystem, $cardsystem);
		  $Result1 = mysql_query($insertSQL, $cardsystem) or die(mysql_error());
		
		  $insertGoTo = "addStdICCardOK.php";
		  if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		  }
		  header(sprintf("Location: %s", $insertGoTo));
  
	}//end of if
}//end of if

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

    <title>新增學生</title>

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
            <li class="active"><a href="menu.php">返回</a></li>
            
         </ul>

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
        <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">

        
         <fieldset>
            <!-- Form Name -->
            <legend>新增學生IC卡</legend>
            
            <?php if($this_IC_total>0){?>
            <div class="form-group">
				<div class="alert alert-danger" role="alert"><b>警告</b>:對不起 , 此卡號已有人使用!</div>
            </div>
            <?php }?>
            
            <?php if($this_STD_IC_total>= $STD_IC_CARD_TOTAL){?>
            <div class="form-group">
				<div class="alert alert-danger" role="alert"><b>警告</b>:每個學生只限<?php echo $STD_IC_CARD_TOTAL;?>張卡數，請刪除原來的卡片才能增加！</div>
            </div>
            <?php }?>
            
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="textinput">CoCode:</label>  
              <div class="col-md-4">
              <input id="textinput" name="CoCode" type="text" value="<?php echo $_SESSION['CoCode']; ?>" class="form-control input-md" readonly>
              </div>
            </div>
            
            <div class="form-group">
              <label class="col-md-4 control-label" for="textinput">StuCode:</label>  
              <div class="col-md-4">
              <input id="textinput" name="StuCode" type="text" value="<?php echo $row_RecordsetStd['StuCode']; ?>" class="form-control input-md" readonly>
              </div>
            </div>
            
           <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="textinput">學生姓名:</label>  
              <div class="col-md-4">
              <input id="textinput" name="StuName" type="text" value="<?php echo $row_RecordsetStd['StuName']; ?>" class="form-control input-md" readonly>
              </div>
            </div> 
            
            
            <?php if($this_STD_IC_total < $STD_IC_CARD_TOTAL){//該學生超出卡片數則不能增加?>
           <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="textinput">IC卡號:</label>  
              <div class="col-md-4">
              <input id="CardId" name="CardId" type="text" value=""  placeholder="請輸入IC卡號" class="form-control input-md">
              </div>
            </div>  
            
             <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="textinput"></label>  
              <div class="col-md-4">
              <input type="submit" class="btn btn-primary" value="新增">
              <a type="button"  class="btn btn-default" href="listAllStd.php">返回</a>
              </div>
            </div> 
            <?php }?>
        </fieldset>
         <input type="hidden" name="MM_insert" value="form1">
        </form>
        
        
        <div class="col-md-12">
        <fieldset>
            <!-- Form Name -->
            <legend>該學生已加入的IC卡記錄</legend>
          <table class="table table-striped">
            <tr>
                  <td>卡號</td>
                  <td>操作</td>
               </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_RecordsetICCard['CardId']; ?></td>
                <td>刪除</td>
              </tr>
              <?php } while ($row_RecordsetICCard = mysql_fetch_assoc($RecordsetICCard)); ?>
          </table>
             
        </fieldset>
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
mysql_free_result($RecordsetStd);

mysql_free_result($RecordsetThisCardTotal);

//mysql_free_result($RecordsetICCard);
?>

<script>
	$( document ).ready(function() {
	  $( "#CardId" ).focus();
	});
</script>
