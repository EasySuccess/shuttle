<?php

	require_once('../../lib/config.php'); 
	
	if (!isset($_SESSION)) {
	  session_start();
	}
	$MM_authorizedUsers = "admin,company,staff";
	$MM_donotCheckaccess = "false";
	
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
	
	$editFormAction = $_SERVER['PHP_SELF'];
	if (isset($_SERVER['QUERY_STRING'])) {
	  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
	}
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	  $insertSQL = sprintf("INSERT INTO tbstudent (StuCode, CoCode, StuName, StuSex, StuBirth, StuAddress, StuFather, StuFatherTel, StuMum, StuMumTel, StuContact, StuContactTel, StuRemark, StuGrad, StuPic, updateTime) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	                       GetSQLValueString($_POST['StuCode'], "text"),
	                       GetSQLValueString($_POST['CoCode'], "text"),
	                       GetSQLValueString($_POST['StuName'], "text"),
	                       GetSQLValueString($_POST['StuSex'], "text"),
	                       GetSQLValueString($_POST['StuBirth'], "date"),
	                       GetSQLValueString($_POST['StuAddress'], "text"),
	                       GetSQLValueString($_POST['StuFather'], "text"),
	                       GetSQLValueString($_POST['StuFatherTel'], "text"),
	                       GetSQLValueString($_POST['StuMum'], "text"),
	                       GetSQLValueString($_POST['StuMumTel'], "text"),
	                       GetSQLValueString($_POST['StuContact'], "text"),
	                       GetSQLValueString($_POST['StuContactTel'], "text"),
	                       GetSQLValueString($_POST['StuRemark'], "text"),
	                       GetSQLValueString($_POST['StuGrad'], "text"),
	                       GetSQLValueString($_POST['StuPic'], "text"),
	                       GetSQLValueString($_POST['updateTime'], "date"));
	
	  mysql_select_db($database, $connection);
	  $Result1 = mysql_query($insertSQL, $connection) or die(mysql_error());
	
	  $insertGoTo = "addStdOK.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
	    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	    $insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  header(sprintf("Location: %s", $insertGoTo));
	}
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
					<a class="navbar-brand" href="#">補習社後台登入</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="menu.php">返回</a></li>
					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<p class="lead"></p>
				<form method="post" name="form1" action="<?php echo $editFormAction; ?>" class="form-horizontal">
					<fieldset>
						<!-- Form Name -->
						<legend>新增學生</legend>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">CoCode:</label>  
							<div class="col-md-4">
								<input id="textinput" name="CoCode" type="text" value="<?php echo $_SESSION['MM_CoCode']; ?>" class="form-control input-md" readonly>
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">學生姓名:</label>  
							<div class="col-md-4">
								<input id="textinput" name="StuName" type="text" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">性別:</label>  
							<div class="col-md-4">
								<select name="StuSex">
									<option value="男" <?php if (!(strcmp("男", "男"))) {echo "SELECTED";} ?>>男</option>
									<option value="女" <?php if (!(strcmp("女", "男"))) {echo "SELECTED";} ?>>女</option>
								</select>
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">出生日期:</label>  
							<div class="col-md-4">
								<input id="textinput" name="StuBirth" type="text" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">地址:</label>  
							<div class="col-md-4">
								<input id="textinput" name="StuAddress" type="text" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">父親名字:</label>  
							<div class="col-md-2">
								<input id="textinput" name="StuFather" type="text" value="" class="form-control input-md">
							</div>
							<div class="col-md-2">
								<input id="textinput" name="StuFatherTel" type="text"  placeholder="聯絡電話" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">母親名字:</label>  
							<div class="col-md-2">
								<input id="textinput" name="StuMum" type="text" value="" class="form-control input-md">
							</div>
							<div class="col-md-2">
								<input id="textinput" name="StuMumTel" type="text"  placeholder="聯絡電話" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">緊急聯絡人:</label>  
							<div class="col-md-2">
								<input id="textinput" name="StuContact" type="text" value="" class="form-control input-md">
							</div>
							<div class="col-md-2">
								<input id="textinput" name="StuContactTel" type="text"  placeholder="聯絡電話" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">備註:</label>  
							<div class="col-md-4">
								<input id="textinput" name="StuRemark" type="text" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">年級:</label>  
							<div class="col-md-4">
								<input id="textinput" name="StuGrad" type="text" value="" class="form-control input-md">
							</div>
						</div>
						<!-- Text input-->
						<!-- <div class="form-group">
							<label class="col-md-4 control-label" for="textinput">圖片:</label>  
							<div class="col-md-4">
								<input id="textinput" name="StuPic" type="text" value="" class="form-control input-md">
							</div>
						</div> -->
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput"></label>  
							<div class="col-md-4">
								<input type="submit" class="btn btn-primary" value="插入記錄">
								<a type="button"  class="btn btn-default" href="menu.php">返回</a>
							</div>
						</div>
					</fieldset>
					<input type="hidden" name="StuCode" value="" size="32" />
					<input type="hidden" name="updateTime" value="">
					<input type="hidden" name="MM_insert" value="form1">
				</form>
			</div>
		</div>
		<!-- /.container -->
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