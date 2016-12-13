<?php

require_once('../lib/config.php');

if (!isset($_SESSION)) {
	session_start();
}
$MM_authorizedUsers  = "admin,company,staff";
$MM_donotCheckaccess = "false";

$MM_restrictGoTo     = "../noPermission.php";
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

$tableName = "tbstudent";
$currentPage = $_SERVER['PHP_SELF'];
$homeUrl = "../index.php";
$nextUrl = "listStudent.php";
$prevUrl = $homeUrl;

$maxRows_RecordsetStd = $MAX_ROWS_PAGES;
$pageNum_RecordsetStd = 0;
if (isset($_GET['pageNum_RecordsetStd'])) {
	$pageNum_RecordsetStd = $_GET['pageNum_RecordsetStd'];
}
$startRow_RecordsetStd = $pageNum_RecordsetStd * $maxRows_RecordsetStd;

$colname_RecordsetStd = "-1";
if (isset($_SESSION['MM_CoCode'])) {
	$colname_RecordsetStd = $_SESSION['MM_CoCode'];
}

$query_RecordsetStd = sprintf("SELECT tbstudent.StuCode, tbstudent.StuName, tbstudent.Created, tbstudent.Modified, tbgroup.GroupName FROM $tableName INNER JOIN tbgroup ON tbstudent.GroupId=tbgroup.GroupId WHERE tbstudent.CoCode = %s ORDER BY StuName", $colname_RecordsetStd);
$query_limit_RecordsetStd = sprintf("%s LIMIT %d, %d", $query_RecordsetStd, $startRow_RecordsetStd, $maxRows_RecordsetStd);
$RecordsetStd  = DB::query($query_limit_RecordsetStd);


if (isset($_GET['totalRows_RecordsetStd'])) {
	$totalRows_RecordsetStd = $_GET['totalRows_RecordsetStd'];
} else {
	$all_RecordsetStd = DB::query($query_RecordsetStd);
	
	$totalRows_RecordsetStd = count($all_RecordsetStd);
}
$totalPages_RecordsetStd = ceil($totalRows_RecordsetStd / $maxRows_RecordsetStd) - 1;

$queryString_RecordsetStd = "";
if (!empty($_SERVER['QUERY_STRING'])) {
	$params    = explode("&", $_SERVER['QUERY_STRING']);
	$newParams = array();
	foreach ($params as $param) {
		if (stristr($param, "pageNum_RecordsetStd") == false && stristr($param, "totalRows_RecordsetStd") == false) {
			array_push($newParams, $param);
		}
	}
	if (count($newParams) != 0) {
		$queryString_RecordsetStd = "&" . htmlentities(implode("&", $newParams));
	}
}
$queryString_RecordsetStd = sprintf("&totalRows_RecordsetStd=%d%s", $totalRows_RecordsetStd, $queryString_RecordsetStd);

if ((isset($_POST['action'])) && ($_POST['action'] != "")) {

	if($_POST['action'] == "delStudent"){
		DB::update("tbcard", array(
			"StuCode" =>  NULL
		), "StuCode=%s and CoCode=%s", $_POST['param'], $_SESSION['MM_CoCode']);
		
		DB::delete("tbstustatus", "StuCode=%s and CoCode=%s", $_POST['param'], $_SESSION['MM_CoCode']);
		DB::delete($tableName, "StuCode=%s and CoCode=%s", $_POST['param'], $_SESSION['MM_CoCode']);
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
				<h1>學生列表</h1>
				<p class="lead"></p>
			</div>
			<div class="row">
				<!-- <ul class="nav nav-tabs">
					<li role="presentation" class="active"><a href="#">home</a></li>
					<li role="presentation"><a href="#">Profile</a></li>
					<li role="presentation"><a href="#">Messages</a></li>
				</ul> -->
				<div class="col-md-12">
					<?php 
						if ($totalRows_RecordsetStd > 0) {
						?>
					<table class="table table-striped">
						<tr>
							<!-- <td>學生編號</td> -->
							<td>姓名</td>
							<td>群組</td>
							<!-- <td>建立日期</td> -->
							<!-- <td>更新日期</td> -->
							<td>操作</td>
						</tr>
						<?php 
							foreach ($RecordsetStd as $row) {
							?>
						<tr>
							<!-- <td><?php echo $row['StuCode']; ?></td> -->
							<td><?php echo $row['StuName']; ?></td>
							<td><?php echo $row['GroupName']; ?></td>
							<!-- <td><?php echo substr($row['Created'], 0, 10); ?><br>
								<?php echo substr($row['Created'], 11, 15); ?>
							</td>
							<td>
								<?php echo substr($row['Modified'], 0, 10); ?><br>
								<?php echo substr($row['Modified'], 11, 15); ?>
							</td> -->
							<td>
								<a class="btn btn-default" href="assignCard.php?StuCode=<?php echo $row['StuCode']; ?>">分配IC卡</a>
								<a class="btn btn-success" href="assignGroup.php?StuCode=<?php echo $row['StuCode']; ?>">分配群組</a>
								<a class="btn btn-primary" href="listAttendance.php?RefUrl=1&StuCode=<?php echo $row['StuCode']; ?>&StuName=<?php echo $row['StuName']; ?>">出席記錄</a>
								<a class="btn btn-info" href="editStudent.php?StuCode=<?php echo $row['StuCode']; ?>">修改資料</a>
								<button type="submit" class="btn btn-danger" name="delStudent" value="<?php echo $row['StuCode']; ?>">刪除</button>
							</td>
						</tr>
						<?php
							} 
							?>
					</table>
					<?php
						} 
						?>
				</div>
				<div align="center">
					記錄 <?php
						echo ($startRow_RecordsetStd + 1);
						?> 到 <?php
						echo min($startRow_RecordsetStd + $maxRows_RecordsetStd, $totalRows_RecordsetStd);
						?> 共 <?php
						echo $totalRows_RecordsetStd;
						?>筆
				</div>
				<table border="0" align="center">
					<tr>
						<td><?php
							if ($pageNum_RecordsetStd > 0) { // Show if not first page 
							?>
							<a href="<?php
								printf("%s?pageNum_RecordsetStd=%d%s", $currentPage, 0, $queryString_RecordsetStd);
								?>">第一頁　</a>
							<?php
								} // Show if not first page 
								?>
						</td>
						<td><?php
							if ($pageNum_RecordsetStd > 0) { // Show if not first page 
							?>
							<a href="<?php
								printf("%s?pageNum_RecordsetStd=%d%s", $currentPage, max(0, $pageNum_RecordsetStd - 1), $queryString_RecordsetStd);
								?>">上一頁　</a>
							<?php
								} // Show if not first page 
								?>
						</td>
						<td><?php
							if ($pageNum_RecordsetStd < $totalPages_RecordsetStd) { // Show if not last page 
							?>
							<a href="<?php
								printf("%s?pageNum_RecordsetStd=%d%s", $currentPage, min($totalPages_RecordsetStd, $pageNum_RecordsetStd + 1), $queryString_RecordsetStd);
								?>">下一頁　</a>
							<?php
								} // Show if not last page 
								?>
						</td>
						<td><?php
							if ($pageNum_RecordsetStd < $totalPages_RecordsetStd) { // Show if not last page 
							?>
							<a href="<?php
								printf("%s?pageNum_RecordsetStd=%d%s", $currentPage, $totalPages_RecordsetStd, $queryString_RecordsetStd);
								?>">最後一頁　</a>
							<?php
								} // Show if not last page 
								?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<!-- /.container -->
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootbox.min.js"></script>
		<script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
		<script src="../js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="../js/ie10-viewport-bug-workaround.js"></script>
		<script>
			$(document).ready(function() {
			
				bootbox.setLocale("zh_TW");
				
				$("button[type='submit']").click(function(){
						var action = $(this).attr("name");
						var param = $(this).val();
						
						var ajaxurl = "<?php echo $currentPage; ?>";
						var data =  {"action": action, "param": param};
						$.ajaxSetup({async: false});
						
						if(action.indexOf("del") !== -1){
							bootbox.confirm("確認刪除？", function(result){
								if(result){
									$.post(ajaxurl, data, function (data,status) {
										location.reload()
									});
								}
							});
						}else{
							$.post(ajaxurl, data, function (data,status) {});
						}
					});
				});
		</script>
	</body>
</html>