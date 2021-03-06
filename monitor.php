<?php	
require_once("lib/config.php"); 
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

$colname_RecordsetGroups = "-1";
if (isset($_SESSION['MM_CoCode'])) {
	$colname_RecordsetGroups = $_SESSION['MM_CoCode'];
}

$query_group = sprintf("SELECT GroupId, GroupName FROM tbgroup WHERE CoCode = %s ORDER BY GroupName", $colname_RecordsetGroups);
$RecordsetGroups  = DB::query($query_group);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>補習社接送系統</title>
		<meta name="description" content="補習社接送系統" />
		<meta name="author" content="補習社接送系統" />
		<link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		<!-- Style CSS -->
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/icomoon.css" />
		<link rel="stylesheet" href="css/screen.css" />
		<link rel="stylesheet" href="css/style.css" />
	</head>
	<body>
		<!-- Page Wrapper -->
		<div id="page">
			<!-- Header -->
			<header>
				<div class="container">
					<div class="row">
						<!--<div class="col-xs-4 col-sm-2">
							<a class="brand" href="monitor.php">
								<!--<img src="img/identity.png" alt="logo-image" />--*>
								<h1>logo</h1>
								<button class="btn btn theme-btn-2" type="submit" value="reset">重設</button>
							</a>
						</div>-->
						<!--<div class="col-xs-8 col-sm-10">
							<div class="action-bar" id="frontend-action-bar">
								<span class="menu-toggle no-select">Menu
								<span class="hamburger"><span class="menui top-menu"></span><span class="menui mid-menu"></span><span class="menui bottom-menu"></span></span>
								</span>
								<!--<span class="menu-toggleList" data-toggle="modal" data-target="#registerModal" id="actionBarSignUpBtn">註冊</span>
									<span class="menu-toggleList" data-toggle="modal" data-target="#loginModal" id="actionBarLogInBtn">登入</span>
									<a href="javascript:logOut()" class="menu-toggleList" id="actionBarLogOutBtn">登出</a>--*>
							</div>
						</div>-->
					</div>
				</div>
				<!-- <nav>
					<ul>
						<li class="current-menu-item"><a href="index.html">首頁</a></li>
						<li><a id="demoData" href="lib/initialDemoData.php">Demo Data</a></li>
						<li><a href="#">聯絡方法</a></li>
					</ul>
				</nav> -->
			</header>
			<!-- Main Content -->
			<div class="content-wrapper">
				<!-- Hero Section -->
				<section class="section-hero">
					<div class="hero-content courses-list">
						<div class="container">
							<h1 class="heading" id="heading-type">補習社接送系統</h1>
						</div>
					</div>
				</section>
				<!-- Links Box -->
				<div class="links-wrapper" style="margin: 20px;">
					<div class="container">
						<div class="row">
							<div class="col-sm-4 col-md-4">
								<div class="links-box">
									<h3 class="caption green"><?php 
										$groupNo=0;
										echo isset($RecordsetGroups[$groupNo])?$RecordsetGroups[$groupNo]['GroupName']:""; 
									?></h3>
									<ul class="links">
										<?php if( isset($RecordsetGroups[$groupNo]) ) { 
											$recordSetStudent = DB::query("SELECT * 
												FROM tbstudent INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
												WHERE tbstudent.CoCode=%d and tbstudent.GroupId=%d ORDER BY tbstustatus.StuStatus DESC, tbstudent.StuName ",  $_SESSION['MM_CoCode'], $RecordsetGroups[$groupNo]['GroupId']);
												foreach ($recordSetStudent as $row) {
										?>
										<li>
											<a data-toggle="modal" data-target="#onClassModal" id="<?php
														switch($row['StuStatus']){
															case "10":
																echo "onModal";
																break;
															case "99":
																echo "onModal";
																break;
															default:
																echo "leaveModal";
																break;
														}
													?>">
												<span class="title">
													<span class="title-main <?php
														switch($row['StuStatus']){
															case "10":
																echo "green";
																break;
															case "99":
																echo "red";
																break;
															case "0":
																echo "red";
																break;
															default:
																break;
														}
													?>" id="<?php echo $row['StuCode']?>"><?php echo $row['StuName']?></span>
												</span>
											</a>
										</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="links-box">
									<h3 class="caption red">
									<?php 
										$groupNo=1;
										echo isset($RecordsetGroups[$groupNo])?$RecordsetGroups[$groupNo]['GroupName']:"N/A"; 
									?>
									</h3>
									<ul class="links">
										<?php if( isset($RecordsetGroups[$groupNo]) ) { 
											$recordSetStudent = DB::query("SELECT * 
												FROM tbstudent INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
												WHERE tbstudent.CoCode=%d and tbstudent.GroupId=%d ORDER BY tbstustatus.StuStatus DESC, tbstudent.StuName ",  $_SESSION['MM_CoCode'], $RecordsetGroups[$groupNo]['GroupId']);
												foreach ($recordSetStudent as $row) {
										?>
										<li>
											<a data-toggle="modal" data-target="#onClassModal" id="<?php
														switch($row['StuStatus']){
															case "10":
																echo "onModal";
																break;
															case "99":
																echo "onModal";
																break;
															default:
																echo "leaveModal";
																break;
														}
													?>">
												<span class="title">
													<span class="title-main <?php
														switch($row['StuStatus']){
															case "10":
																echo "green";
																break;
															case "99":
																echo "red";
																break;
															case "0":
																echo "red";
																break;
															default:
																break;
														}
													?>" id="<?php echo $row['StuCode']?>"><?php echo $row['StuName']?></span>
											</a>
										</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="links-box">
									<h3 class="caption yellow">
									<?php 
										$groupNo=2;
										echo isset($RecordsetGroups[$groupNo])?$RecordsetGroups[$groupNo]['GroupName']:"N/A"; 
									?>
									</h3>
									<ul class="links">
										<?php if( isset($RecordsetGroups[$groupNo]) ) { 
											$recordSetStudent = DB::query("SELECT * 
												FROM tbstudent INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
												WHERE tbstudent.CoCode=%d and tbstudent.GroupId=%d ORDER BY tbstustatus.StuStatus DESC, tbstudent.StuName ",  $_SESSION['MM_CoCode'], $RecordsetGroups[$groupNo]['GroupId']);
												foreach ($recordSetStudent as $row) {
										?>
										<li>
											<a data-toggle="modal" data-target="#onClassModal" id="<?php
														switch($row['StuStatus']){
															case "10":
																echo "onModal";
																break;
															case "99":
																echo "onModal";
																break;
															default:
																echo "leaveModal";
																break;
														}
													?>">
												<span class="title">
													<span class="title-main <?php
														switch($row['StuStatus']){
															case "10":
																echo "green";
																break;
															case "99":
																echo "red";
																break;
															case "0":
																echo "red";
																break;
															default:
																break;
														}
													?>" id="<?php echo $row['StuCode']?>"><?php echo $row['StuName']?></span>
												</span>
											</a>
										</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-md-4">
								<div class="links-box">
									<h3 class="caption green">
									<?php 
										$groupNo=3;
										echo isset($RecordsetGroups[$groupNo])?$RecordsetGroups[$groupNo]['GroupName']:"N/A"; 
									?>
									</h3>
									<ul class="links">
										<?php if( isset($RecordsetGroups[$groupNo]) ) { 
											$recordSetStudent = DB::query("SELECT * 
												FROM tbstudent INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
												WHERE tbstudent.CoCode=%d and tbstudent.GroupId=%d ORDER BY tbstustatus.StuStatus DESC, tbstudent.StuName ",  $_SESSION['MM_CoCode'], $RecordsetGroups[$groupNo]['GroupId']);
												foreach ($recordSetStudent as $row) {
										?>
										<li>
											<a data-toggle="modal" data-target="#onClassModal" id="<?php
														switch($row['StuStatus']){
															case "10":
																echo "onModal";
																break;
															case "99":
																echo "onModal";
																break;
															default:
																echo "leaveModal";
																break;
														}
													?>">
												<span class="title">
													<span class="title-main <?php
														switch($row['StuStatus']){
															case "10":
																echo "green";
																break;
															case "99":
																echo "red";
																break;
															case "0":
																echo "red";
																break;
															default:
																break;
														}
													?>" id="<?php echo $row['StuCode']?>"><?php echo $row['StuName']?></span>
												</span>
											</a>
										</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="links-box">
									<h3 class="caption red">
									<?php 
										$groupNo=4;
										echo isset($RecordsetGroups[$groupNo])?$RecordsetGroups[$groupNo]['GroupName']:"N/A"; 
									?>
									</h3>
									<ul class="links">
										<?php if( isset($RecordsetGroups[$groupNo]) ) { 
											$recordSetStudent = DB::query("SELECT * 
												FROM tbstudent INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
												WHERE tbstudent.CoCode=%d and tbstudent.GroupId=%d ORDER BY tbstustatus.StuStatus DESC, tbstudent.StuName ",  $_SESSION['MM_CoCode'], $RecordsetGroups[$groupNo]['GroupId']);
												foreach ($recordSetStudent as $row) {
										?>
										<li>
											<a data-toggle="modal" data-target="#onClassModal" id="<?php
														switch($row['StuStatus']){
															case "10":
																echo "onModal";
																break;
															case "99":
																echo "onModal";
																break;
															default:
																echo "leaveModal";
																break;
														}
													?>">
												<span class="title">
													<span class="title-main <?php
														switch($row['StuStatus']){
															case "10":
																echo "green";
																break;
															case "99":
																echo "red";
																break;
															case "0":
																echo "red";
																break;
															default:
																break;
														}
													?>" id="<?php echo $row['StuCode']?>"><?php echo $row['StuName']?></span>
												</span>
											</a>
										</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							</div>
							<div class="col-sm-4 col-md-4">
								<div class="links-box">
									<h3 class="caption yellow">
									<?php 
										$groupNo=5;
										echo isset($RecordsetGroups[$groupNo])?$RecordsetGroups[$groupNo]['GroupName']:"N/A"; 
									?>
									</h3>
									<ul class="links">
										<?php if( isset($RecordsetGroups[$groupNo]) ) { 
											$recordSetStudent = DB::query("SELECT * 
												FROM tbstudent INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
												WHERE tbstudent.CoCode=%d and tbstudent.GroupId=%d ORDER BY tbstustatus.StuStatus DESC, tbstudent.StuName ",  $_SESSION['MM_CoCode'], $RecordsetGroups[$groupNo]['GroupId']);
												foreach ($recordSetStudent as $row) {
										?>
										<li>
											<a data-toggle="modal" data-target="#onClassModal" id="<?php
														switch($row['StuStatus']){
															case "10":
																echo "onModal";
																break;
															case "99":
																echo "onModal";
																break;
															default:
																echo "leaveModal";
																break;
														}
													?>">
												<span class="title">
													<span class="title-main <?php
														switch($row['StuStatus']){
															case "10":
																echo "green";
																break;
															case "99":
																echo "red";
																break;
															case "0":
																echo "red";
																break;
															default:
																break;
														}
													?>" id="<?php echo $row['StuCode']?>"><?php echo $row['StuName']?></span>
												</span>
											</a>
										</li>
											<?php }?>
										<?php }?>
									</ul>
								</div>
							</div>
						</div><!-- row -->
					</div>
				</div>
			</div>
			<!-- Footer -->
			<footer class="">
				<div class="container">
					<div class="footer-wrapper">
						<div class="main-area">
							<span class="title-main green">上課中</span>
							<span class="title-main red">家長到</span>
							<span class="title-main">已離開</span>
							<button type="reset" class="btn btn-default" aria-label="Left Align">
								<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
							</button>
						</div>
						<div class="copyrights">
							<p>Copyright 2016. Designed by <a href="#" target="blank">EasySuccess team</a></p>
						</div>
					</div>
				</div>
			</footer>
		</div>
		<!--onClassModal-->
		<div class="modal fade" id="onClassModal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="section-header">
							<h1>Header</h1>
						</div>
					</div>
					<div class="blackout"></div>
					<form role="form" data-toggle="validator" class="RegisterLogin" id="loginForm">
						<div class="modal-body">
							<div class="form-group">
								<div class="onclass-from">
									<div class="onclass" id="">
										<p class=""><span><span class="sum" id="modalStuName" value="">Student</span></span></p>
										<p class="hide"><span>上課時間：<span class="sum" id="cart-balance">2016-10-10 10:00</span></span></p>
										<p class="hide"><span>現在時間：<span class="sum" id="cart-balance-after">2016-10-10 10:00</span></span></p>
									</div>
								</div>
								<!-- <label for="desc" class="control-label">備註:</label>
								<input type="text" class="form-control" id="" name=""> -->
							</div>
						</div>
						<div class="modal-footer form-group">
							<button type="submit" class="btn theme-btn-2 model"></button>
							<button type="submit" class="btn theme-btn-2 hide model"></button>
							<button type="close" class="btn theme-btn-2 model" data-dismiss="modal">取消</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--[end]onClassModal-->
	</body>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.js"></script>
	<script src="js/velocity.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/bootstrap/bootbox.min.js"></script>
	<script>
		$(document).ready(function() {
			bootbox.setLocale("zh_TW");
			$("a[data-toggle='modal'], button[data-toggle='modal']").click(function () {
				var stuName = $(this).find(".title-main").html();
				var stuCode = $(this).find(".title-main").attr("id");
				$("#modalStuName").html(stuName);
				$("#modalStuName").attr("value", stuCode);				
				switch($(this).attr("id")){
					case "onModal":
						$(".modal-header h1").html("確定要接走學生嗎？");
						$(".modal-footer button[type='submit']:eq(0)").attr("value", "done");
						$(".modal-footer button[type='submit']:eq(0)").html("已完成作業");
						$(".modal-footer button[type='submit']:eq(1)").attr("value", "1");
						$(".modal-footer button[type='submit']:eq(1)").html("下課");
						$(".modal-footer button[type='submit']:eq(0)").addClass("hide");
						$(".modal-footer button[type='submit']:eq(1)").removeClass("hide");
						break;
					case "doneModal":
						$(".modal-header h1").html("學生下課嗎？");
						$(".modal-footer button[type='submit']:eq(0)").attr("value", "1");
						$(".modal-footer button[type='submit']:eq(0)").html("下課");
						$(".modal-footer button[type='submit']:eq(0)").removeClass("hide");
						$(".modal-footer button[type='submit']:eq(1)").addClass("hide");
						break;
					case "leaveModal":
						$(".modal-header h1").html("學生已下課");
						$(".modal-footer button[type='submit']:eq(0)").addClass("hide");
						$(".modal-footer button[type='submit']:eq(1)").addClass("hide");
						break;
					case "offModal":
						$(".modal-header h1").html("學生上課嗎？");
						$(".modal-footer button[type='submit']:eq(0)").attr("value", "10");
						$(".modal-footer button[type='submit']:eq(0)").html("上課");
						$(".modal-footer button[type='submit']:eq(0)").removeClass("hide");
						$(".modal-footer button[type='submit']:eq(1)").addClass("hide");
						break;
				};
			});
			
			$("button[type='submit']").click(function(){
				var action = $(this).val();
				var param = $("#modalStuName").attr("value");
				var ajaxurl = "lib/ajax.php";
				var data =  {"action": action, "cocode":<?php echo $_SESSION['MM_CoCode']; ?>, "param": param};
				$.ajaxSetup({async: false});
				$.post(ajaxurl, data, function (response,status) {});
			});
			
			$("button[type='reset']").click(function(){
				var action = "reset"
				var param = "<?php echo $DEFAULT_STUDENT_STATUS; ?>";
				var ajaxurl = "lib/ajax.php";
				var data =  {"action": action, "cocode":<?php echo $_SESSION['MM_CoCode']; ?>, "param": param};
				$.ajaxSetup({async: false});
				bootbox.confirm("確認重設所有學生狀態？", function(result){
					if(result){
						$.post(ajaxurl, data, function (response,status) {location.reload()});
					}
				});
			});
			// Setup autorefresh every 10s
			setTimeout(function() { window.location=window.location;},10000);
		});
	</script>
</html>