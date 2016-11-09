<?php

require_once('../lib/config.php');

if (!isset($_SESSION)) {
    session_start();
}

$MM_authorizedUsers  = "admin,company,staff";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = "../noPermission.php";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

//該學生的IC卡總數
$colname_RecordsetICCard = "-1";
if (isset($_GET['StuCode'])) {
    $colname_RecordsetICCard = $_GET['StuCode'];
}
$row_RecordsetStdICCard  = DB::query("SELECT * FROM tbcard WHERE StuCode=%d and CoCode=%d", $colname_RecordsetICCard, $_SESSION['MM_CoCode']);
$this_STD_IC_total = count($row_RecordsetStdICCard);

//Get Student Details
$colname_RecordsetStd = "-1";
if (isset($_GET['StuCode'])) {
    $colname_RecordsetStd = $_GET['StuCode'];
}
$row_RecordsetStd = DB::queryFirstRow("SELECT * FROM tbstudent WHERE StuCode=%d and CoCode=%d", $colname_RecordsetStd, $_SESSION['MM_CoCode']);
$totalRows_RecordsetStd = count($row_RecordsetStd);

//Show available IC Card
$row_RecordsetICCard=DB::query("SELECT * FROM tbcard WHERE StuCode IS NULL AND CoCode=%d ORDER BY CardId", $_SESSION['MM_CoCode']);


//插入資料
if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == "form1")) {

	DB::update("tbcard", array(
		"StuCode" =>  $_POST['StuCode'],
	), "CardId=%s and CoCode=%d", $_POST['CardId'], $_POST['CoCode']);
	
	header("Location: ". $_SERVER['HTTP_REFERER']);	
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
		<title>分配IC卡</title>
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
					<a class="navbar-brand" href="#">補習社接送系統</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
						<li class="active"><a href="../index.php">主選單</a></li>
						<li><a href="../logout.php">登出</a></li>
					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<p class="lead"></p>
				<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="form-horizontal">
					<fieldset>
						<!-- Form Name -->
						<legend>分配IC卡</legend>
						<?php if($this_STD_IC_total>= $MAX_ASSIGNED_IC){?>
						<div class="form-group">
							<div class="alert alert-danger" role="alert"><b>警告</b>:每個學生只限<?php echo $MAX_ASSIGNED_IC;?>張卡數，請刪除原來的卡片才能增加！</div>
						</div>
						<?php }?>
						<!-- Text input-->
						<div class="form-group hidden">
							<label class="col-md-4 control-label" for="textinput">公司編號:</label>  
							<div class="col-md-4">
								<input id="textinput" name="CoCode" type="text" value="<?php echo $_SESSION['MM_CoCode']; ?>" class="form-control input-md" readonly>
							</div>
						</div>
						<div class="form-group hidden">
							<label class="col-md-4 control-label" for="textinput">學生編號:</label>  
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
						<?php if($this_STD_IC_total < $MAX_ASSIGNED_IC){//該學生超出卡片數則不能增加?>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">IC卡號:</label>  
							<div class="col-md-4">
								<select id="CardId" name="CardId">
									<?php foreach($row_RecordsetICCard as $row){ ?>
									<option value=<?php echo $row['CardId'] ?>><?php echo $row['CardId'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput"></label>  
							<div class="col-md-4">
								<input type="submit" class="btn btn-primary" value="新增">
								<a type="button"  class="btn btn-default" href="listStudent.php">返回</a>
							</div>
						</div>
						<?php }?>
					</fieldset>
					<input type="hidden" name="MM_insert" value="form1">
				</form>
				<div class="col-md-12">
					<fieldset>
						<!-- Form Name -->
						<legend>已分配的IC卡</legend>
						<table class="table table-striped">
							<tr>
								<td>卡號</td>
								<td>更新日期</td>
								<td>操作</td>
							</tr>
							<?php foreach($row_RecordsetStdICCard as $row) {?>
							<tr>
								<td><?php echo $row['CardId']; ?></td>
								<td><?php echo $row['Modified']; ?></td>
								<td>
									<a class="btn btn-danger" href="UnassignCard.php?CardId=<?php echo $row['CardId']; ?>">刪除</a>
								</td>
							</tr>
							<?php } ?>
						</table>
					</fieldset>
				</div>
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
<script>
	$( document ).ready(function() {
	  $( "#CardId" ).focus();
	});
</script>