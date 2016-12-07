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

$formAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $formAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$tableName = "tbstudent";
$currentPage = $_SERVER['PHP_SELF'];
$homeUrl = "../index.php";
$nextUrl = "listStudent.php";
$prevUrl = "listStudent.php";

//Check Student Details
$colname_RecordsetStuCode = "-1";
if (isset($_GET['StuCode'])) {
    $colname_RecordsetStuCode = $_GET['StuCode'];
}
$row_RecordsetStd  = DB::queryFirstRow("SELECT tbstudent.StuName, tbstudent.StuCode, tbstudent.GroupId, tbgroup.GroupName FROM $tableName INNER JOIN tbgroup ON tbstudent.GroupId=tbgroup.GroupId WHERE tbstudent.StuCode=%d and tbstudent.CoCode=%d", $colname_RecordsetStuCode, $_SESSION['MM_CoCode']);
if($row_RecordsetStd['GroupId'] != 1){
	$group_assigned = true;
}else{
	$group_assigned = false;
}

//Show available group
$row_RecordsetGroup=DB::query("SELECT * FROM tbgroup WHERE CoCode=%d ORDER BY GroupId", $_SESSION['MM_CoCode']);


if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == "form1")) {

	DB::update($tableName, array(
		"GroupId" =>  $_POST['GroupId'],
	), "StuCode=%s and CoCode=%d", $_POST['StuCode'], $_POST['CoCode']);
	
	header("Location: ". $_SERVER['HTTP_REFERER']);	
	
	exit;
}

if ((isset($_POST['action'])) && ($_POST['action'] != "")) {

	if($_POST['action'] == "unassignGroup"){
		DB::update($tableName, array(
		"GroupId" =>  1,
		), "StuCode=%s and CoCode=%d", $_POST['param'], $_SESSION['MM_CoCode']);
	}
	
	exit;
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
		<title>補習社接送系統</title>
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
						<li><a href="<?php echo $prevUrl;?>">返回</a></li>
						<li><a href="../logout.php">登出</a></li>
					</ul>
				</div>
				<!--/.nav-collapse -->
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<p class="lead"></p>
				<form action="<?php echo $formAction; ?>" method="POST" name="form1" class="form-horizontal">
					<fieldset>
						<!-- Form Name -->
						<legend>分配群組</legend>
						<?php if($group_assigned){?>
						<div class="form-group">
							<div class="alert alert-danger" role="alert"><b>警告</b>:該學生已分配群組，請先移離原來的群組才能分配！</div>
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
						<?php if(!$group_assigned){?>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">群組名稱:</label>  
							<div class="col-md-4">
								<select id="GroupId" name="GroupId">
									<?php foreach($row_RecordsetGroup as $row){ ?>
									<option value=<?php echo $row['GroupId'] ?>><?php echo $row['GroupName'] ?></option>
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
						<legend>已分配的群組</legend>
						<table class="table table-striped">
							<tr>
								<td>群組</td>
								<td>操作</td>
							</tr>
							<?php if($group_assigned){?>
							<tr>
								<td><?php echo $row_RecordsetStd['GroupName']; ?></td>
								<td>
									<button type="submit" class="btn btn-danger" name="unassignGroup" value="<?php echo $row_RecordsetStd['StuCode']; ?>">刪除</button>
								</td>
							</tr>
							<?php }?>
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
		<script>
			$(document).ready(function() {
				$("button[type='submit']").click(function(){
						var ajaxurl = "<?php echo $currentPage; ?>";
						var data =  {"action": $(this).attr("name"), "param": $(this).val()};
						$.ajaxSetup({async: false});
						$.post(ajaxurl, data, function (data,status) {
							console.log(data);
						}).always(function(){
							location.reload();
						});
					});
				});
		</script>
	</body>
</html>