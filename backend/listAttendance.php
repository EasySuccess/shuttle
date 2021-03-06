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

$tableName = "tblog";
$currentPage = $_SERVER['PHP_SELF'];
$homeUrl = "../index.php";
$nextUrl = $homeUrl ;
$prevUrl = $homeUrl ;
if(isset($_GET['RefUrl'])){
	if($_GET['RefUrl']=="1"){
			$prevUrl = "listStudent.php" ;
	}
}
		

$maxRows_RecordsetStd = $MAX_ROWS_PAGES;
$pageNum_RecordsetStd = 0;
if (isset($_GET['pageNum_RecordsetStd'])) {
	$pageNum_RecordsetStd = $_GET['pageNum_RecordsetStd'];
}
$startRow_RecordsetStd = $pageNum_RecordsetStd * $maxRows_RecordsetStd;

if (((isset($_GET["MM_search"])) && ($_GET["MM_search"] == "form1")) ||  isset($_GET['StuCode'])){
	
	$query =  "SELECT tblog.LogId, tblog.StuStatus, tblog.Created, tbstudent.StuCode, tbstudent.StuName FROM $tableName INNER JOIN tbstudent ON tblog.StuCode=tbstudent.StuCode WHERE tblog.CoCode=%i_CoCode";
	
	$params=array();
	$params['CoCode'] = $_SESSION['MM_CoCode'];
	
	if(isset($_GET['StuCode'])){
		if( $_GET['StuCode'] != NULL){
			$query .= " AND tbstudent.StuCode=%s_StuCode";
			$params['StuCode'] = $_GET['StuCode'];
		}
	}
	if(isset($_GET['StuName'])){
		if($_GET['StuName'] != NULL){
			$query .= " AND tbstudent.StuName=%s_StuName";
			$params['StuName'] = $_GET['StuName'];
		}
	}
	if(isset($_GET['StuStatus'])){
		if($_GET['StuStatus'] != NULL){
			$query .= " AND tblog.StuStatus=%s_StuStatus";
			$params['StuStatus'] = $_GET['StuStatus'];
		}
	}
	if(isset($_GET['Created'])){
		if($_GET['Created'] != NULL){
			$next_date = date('Y-m-d', strtotime($_GET['Created']  .' +1 day'));
			$query .= " AND tblog.Created BETWEEN %t_date AND %t_nextDate";
			$params['date'] = $_GET['Created'];
			$params['nextDate'] = $next_date;
		}
	}

	$query .= " ORDER BY tblog.Created DESC";
	
	if (isset($_GET['totalRows_RecordsetStd'])) {
		$totalRows_RecordsetStd = $_GET['totalRows_RecordsetStd'];
	} else {
		$all_RecordsetStd = DB::query($query, $params);
		
		$totalRows_RecordsetStd = count($all_RecordsetStd);
	}
	$totalPages_RecordsetStd = ceil($totalRows_RecordsetStd / $maxRows_RecordsetStd) - 1;
	
	$query .= " LIMIT %d_startRow, %d_maxRows";
	$params['startRow'] = $startRow_RecordsetStd;
	$params['maxRows'] = $maxRows_RecordsetStd;
	
	$RecordsetStd  = DB::query($query, $params);

}else{		

	$query =  "SELECT tblog.LogId, tblog.StuStatus, tblog.Created, tbstudent.StuCode, tbstudent.StuName FROM $tableName INNER JOIN tbstudent ON tblog.StuCode=tbstudent.StuCode WHERE tblog.CoCode=%s  ORDER BY tblog.Created DESC";
	
	if (isset($_GET['totalRows_RecordsetStd'])) {
		$totalRows_RecordsetStd = $_GET['totalRows_RecordsetStd'];
	} else {
		$all_RecordsetStd = DB::query($query, $_SESSION['MM_CoCode']);
		
		$totalRows_RecordsetStd = count($all_RecordsetStd);
	}
	$totalPages_RecordsetStd = ceil($totalRows_RecordsetStd / $maxRows_RecordsetStd) - 1;
	
	$RecordsetStd  = DB::query($query." LIMIT %d, %d", $_SESSION['MM_CoCode'], $startRow_RecordsetStd, $maxRows_RecordsetStd);
	
}

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
				<legend>出席記錄</legend>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" name="form1" class="form-horizontal">
					<fieldset>
						<div class="form-group">
							<div class="col-md-2 hide">
								<input id="textinput" name="StuCode" type="text" placeholder="學生編號" value="<?php echo isset($_GET['StuCode'])? $_GET['StuCode']:""; ?>" class="form-control input-md" <?php echo  isset($_GET['RefUrl'])?(($_GET['RefUrl']=="1")?"readonly":""):"" ?>>
							</div>
							<div class="col-md-2">
								<input id="textinput" name="StuName" type="text" placeholder="學生姓名" value="<?php echo isset($_GET['StuName'])? $_GET['StuName']:""; ?>" class="form-control input-md" <?php echo  isset($_GET['RefUrl'])?(($_GET['RefUrl']=="1")?"readonly":""):"" ?>>
							</div>
							<div class="col-md-2">
								<select id="CardId" name="StuStatus" class="form-control input-md">
									<option></option>
									<option value="on" <?php if(isset($_GET['StuStatus'])){if (!(strcmp($_GET['StuStatus'], "on"))) {echo "SELECTED";}}  ?>>上課</option>
									<option value="leave" <?php if(isset($_GET['StuStatus'])){if (!(strcmp($_GET['StuStatus'], "leave"))) {echo "SELECTED";}}  ?>>離開</option>
									<option value="done"  <?php if(isset($_GET['StuStatus'])){if (!(strcmp($_GET['StuStatus'], "done"))) {echo "SELECTED";}}  ?>>完成作業</option>
									<option value="1" <?php if(isset($_GET['StuStatus'])){if (!(strcmp($_GET['StuStatus'], "1"))) {echo "SELECTED";}}  ?>>家長到達等候</option>
									<option value="99" <?php if(isset($_GET['StuStatus'])){if (!(strcmp($_GET['StuStatus'], "99"))) {echo "SELECTED";}}  ?>>家長要求立刻接走</option>
								</select>
							</div>
							<div class="col-md-2">
								<input id="textinput" name="Created" type="date" value="<?php if(isset($_GET['Created'])){echo $_GET['Created'];} ?>" class="form-control input-md">
							</div>
							<div class="col-md-2">
								<input type="submit" class="btn btn-primary" value="搜尋">
								<a type="button"  class="btn btn-default" href="listAttendance.php<?php 
									if(isset($_GET['RefUrl'])){
										if($_GET['RefUrl']=="1"){
											echo sprintf("?RefUrl=%s&StuCode=%d&StuName=%s", $_GET['RefUrl'], $_GET['StuCode'], $_GET['StuName']);
										}
									}
									?>">重置</a>
							</div>
						</div>	
					</fieldset>
					<input type="hidden" name="MM_search" value="form1">
					<input type="hidden" name="RefUrl" value="<?php echo  isset($_GET['RefUrl'])?$_GET['RefUrl']:"" ?>">
				</form>
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
							<!-- <td>記錄編號</td> -->
							<td>姓名</td>
							<td>狀態</td>
							<td>時間</td>
						</tr>
						<?php 
							foreach ($RecordsetStd as $row_RecordsetStd) {
							?>
						<tr>
							<!-- <td><?php echo $row_RecordsetStd['LogId']; ?></td> -->
							<td><?php echo $row_RecordsetStd['StuName']; ?></td>
							<td><?php 
									switch($row_RecordsetStd['StuStatus']){
										case "0":
											echo "未上課";
											break;
										case "1":
											echo "離開";
											break;
										case "10":
											echo "上課";
											break;
										case "99":
											echo "家長到";
											break;
										default:
											break;
									}
								?></td>
							<td><?php echo substr($row_RecordsetStd['Created'], 0, 10)." ".substr($row_RecordsetStd['Created'], 11, 15); ?>
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
		<script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
		<script src="../js/bootstrap/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="../js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>