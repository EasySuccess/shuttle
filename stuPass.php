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
				<div class="col-xs-4 col-sm-2">
					<a class="brand" href="index.html">
						<!--<img src="img/identity.png" alt="logo-image" />-->
						<!-- <h1>logo</h1> -->
					</a>
				</div>
				<div class="col-xs-8 col-sm-10">
				</div>
				<nav>
					<ul>
						<li class="current-menu-item"><a href="index.php">首頁</a></li>
						<li><a href="#">聯絡方法</a></li>
					</ul>
				</nav>
		</header>
		<!-- Main Content -->
		<!-- Main Content -->
		<div class="content-wrapper">
		<!-- Hero Section -->
		<section class="section-hero">
		<div class="hero-content pi-page">
		<div class="container">
		<h1 class="heading">學生拍卡介面</h1>
		</div>
		</div>
		</section>
		<!-- 404 Section -->
		<section class="section-404">
		<div class="container">
		<input type="text" class="form-control" id="checkInID" autofocus>
		<div class="button-wrapper">
		<a href="#" data-toggle="modal" data-target="#checkInModal" id="checkInBtn" class="btn theme-btn-3">Get in touch</a>
		<!--<button id="checkInBtn" class="btn theme-btn-3">Get in touch</button>-->
		</div>
		</div>
		</section>
		</div>
		<!-- Footer -->
		<footer class="">
		<div class="container">
		<div class="footer-wrapper">
		<div class="main-area">
		<!-- <div class="menu">
		<ul>
		<li><a href="#">首頁</a></li>
		<li><a href="#">聯絡我們</a></li>
		</ul>
		</div> -->
		</div>
		<div class="copyrights">
		<p>Copyright 2016. Designed by <a href="#" target="blank">EasySuccess team</a></p>
		</div>
		</div>
		</div>
		</footer>
		</div>
		<!--checkInModal-->
		<div class="modal fade" id="checkInModal" tabindex="-1" role="dialog">
			<div class="modal-dialog big" role="document" style="margin-top: 100px;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="section-header">
							<h1></h1>
						</div>
					</div>
					<div class="blackout"></div>
					<form role="form" data-toggle="validator" class="RegisterLogin" id="loginForm">
						<div class="modal-body">
							<div class="form-group">
								<div class="onclass-from">
									<div class="onclass" id="">
										<p><span>學生狀況：<span class="sum" id="status"></span></span></p>
										<!-- <p id="onTime" class"hide"><span>上課時間：<span class="sum"></span></span></p>
										<p id="leaveTime" class="hide"><span>下課時間：<span class="sum"></span></span></p> -->
										<p><span>備註：<span class="sum" id="remark"></span></span></p>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer  form-group">
							<button id="actionBtn" type="submit" class="btn theme-btn-2 cricle" value="on">上課</button>
							<button id="actionBtn2" type="submit" class="btn theme-btn-2 cricle" value="leave">下課</button>
							<button type="close" class="btn theme-btn-2 cricle" data-dismiss="modal">返回</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--[end]checkInModal-->
	</body>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap/bootstrap.min.js"></script>
	<script src="js/velocity.js"></script>
	<script src="js/custom.js"></script>
	<script>
		$(document).ready(function() {
		
			$("#checkInID").keydown(function(event) {
				if (event.keyCode == 13) {
					$("#checkInBtn").click();
					return false;
				 }
			});
			
			$("#checkInBtn").click(function (e) {
			
				$.ajaxSetup({async: false});
				data =  {"action": "checkCardId","cocode":<?php echo $_SESSION['MM_CoCode']; ?>, "param": $("#checkInID").val()};
				$.post("lib/ajax.php", data, function (response,status) {
					var row = $.parseJSON(response);
					
					if (row == null){
						alert("找不到學生");
						location.reload();
					}else{
						console.log(row);
						$("#checkInModal h1").html(row['StuName']);
						$("#checkInModal h1").attr("value", row['StuCode']);
						
						// var d = new Date(row['Created']);
						// $("#onTime .sum").html(d.getHours() + ":" + d.getMinutes());
						// $("#leaveTime .sum").html(d.getHours() + ":" + d.getMinutes());
						
						switch(row['StuPickupStatus']){
							case "99":
								$("#remark").html("家長要求立即接走");
								break;
							case "1":
								$("#remark").html("家長等候中");
								break;
							default:
								break;
						}
						
						switch(row['StuStatus']){
							case "on":
								$("#status").html("上課中");
								$("#actionBtn").attr("value", "done");
								$("#actionBtn").html("完成作業");
								$("#actionBtn").removeClass("hide");
								$("#actionBtn2").removeClass("hide");
								// $("#onTime").removeClass("hide");
								// $("#leaveTime").addClass("hide");
								break;
							case "done":
								$("#status").html("已完成作業");
								$("#actionBtn").addClass("hide");
								$("#actionBtn2").removeClass("hide");
								// $("#onTime").removeClass("hide");
								// $("#leaveTime").addClass("hide");
								break;
							case "leave":
								$("#status").html("已下課");
								$("#actionBtn").addClass("hide");
								$("#actionBtn2").addClass("hide");
								// $("#onTime").addClass("hide");
								// $("#leaveTime").removeClass("hide");
								break;
							case "off":
								$("#status").html("未上課");
								$("#actionBtn").attr("value", "on");
								$("#actionBtn").html("上課");
								$("#actionBtn").removeClass("hide");
								$("#actionBtn2").addClass("hide");
								// $("#onTime").addClass("hide");
								// $("#leaveTime").addClass("hide");
								break;
							default:
								$("#status").html("請聯絡職員");
								break;
						}
					}
				});
			});
			
			$("button[type='submit']").click(function(){
				var ajaxurl = "lib/ajax.php";
				var data =  {"action": $(this).val(), "cocode":<?php echo $_SESSION['MM_CoCode']; ?>, "param": $("#checkInModal h1").attr("value")};
				$.ajaxSetup({async: false});
				$.post(ajaxurl, data, function (data,status) {});
			});
			
			$("button[type='close']").click(function(){
					location.reload();
			});
		
		});
	</script>
</html>