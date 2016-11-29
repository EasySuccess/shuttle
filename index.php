<?php

require_once('lib/config.php');

if (!isset($_SESSION)) {
	session_start();
}
$MM_authorizedUsers  = "admin,company,staff";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "login.php";

if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
	$MM_qsChar   = "?";
	$MM_referrer = $_SERVER['PHP_SELF'];
	if (strpos($MM_restrictGoTo, "?"))
		$MM_qsChar = "&";
	if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
		$MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
	$MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	header("Location: " . $MM_restrictGoTo);
	exit;
}

$recordSet = DB::queryFirstRow("SELECT CoName FROM tbco WHERE CoCode = %d", $_SESSION['MM_CoCode']);
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
		<title>補習社接送系統</title>
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="css/starter-template.css" rel="stylesheet">
		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="js/ie-emulation-modes-warning.js"></script>
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
					<a class="navbar-brand" href="#">補習社接送系統</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="index.php">主選單</a></li>
						<li><a href="logout.php">登出</a></li>
					</ul>
				</div>
				<!--/.nav-collapse --> 	
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<h1>主選單</h1>
				<p class="lead"></p>
			</div>
			<div class="col-md-8">
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
								操作介面
							</h3>
						</div>
						<div class="panel-body">
							<a type="button" class="btn btn-md" aria-label="Left Align" href="monitor.php" >實時學生狀態介面</a>
							<a type="button" class="btn btn-md" aria-label="Left Align" href="stuPass.php" >學生拍卡介面</a><br>
							<a type="button" class="btn btn-md" aria-label="Left Align" href="parPass.php" >家長拍卡介面</a><br>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
								學生管理
							</h3>
						</div>
						<div class="panel-body">
							<a type="button" class="btn btn-md" aria-label="Left Align" href="backend/listStudent.php" >學生列表</a>
							<a type="button" class="btn btn-md" aria-label="Left Align" href="backend/addStudent.php" >新增學生</a><br>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
								IC卡管理
							</h3>
						</div>
						<div class="panel-body">
							<a type="button" class="btn btn-md" aria-label="Left Align" href="backend/listCard.php" >IC卡列表</a>
							<a type="button" class="btn btn-md" aria-label="Left Align" href="backend/addCard.php" >新增IC卡</a><br>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
								記錄管理
							</h3>
						</div>
						<div class="panel-body">
							<a type="button" class="btn btn-md" aria-label="Left Align" href="backend/listAttendance.php" >出席記錄</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
							帳號資訊
						</h3>
					</div>
					<div class="panel-body">
						<b>帳號</b>:<?php echo $_SESSION['MM_Username'] ;?><br>
						<b>公司</b>:<?php echo $recordSet['CoName'] ;?><br>
					</div>
				</div>
			</div>
			<div class="col-md-4 <?php echo (strcmp($_SESSION['MM_UserGroup'],"admin")==0)?"":"hidden" ?>">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title">
							<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
							超級管理
						</h3>
					</div>
					<div class="panel-body">
						<a type="button" class="btn btn-md" aria-label="Left Align" href="admin/listUser.php" >用戶管理</a>
						<a type="button" class="btn btn-md" aria-label="Left Align" href="admin/addUser.php" >新增用戶</a>
						<a type="button" class="btn btn-md" aria-label="Left Align" href="admin/listCompany.php" >公司管理</a>
						<a type="button" class="btn btn-md" aria-label="Left Align" href="admin/addCompany.php" >新增公司</a>
					</div>
				</div>
			</div>
		</div>
		<!-- /.container -->
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="js/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
		<script src="js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>