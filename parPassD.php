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
		<h1 class="heading">家長拍卡介面</h1>
		</div>
		</div>
		</section>
		<!-- 404 Section -->
		<section class="section-404">
		<div class="container">
		<input type="text" class="form-control" id="checkInID" autofocus>
		<div class="button-wrapper">
		<a href="#" data-toggle="modal" id="checkInBtn" class="btn theme-btn-3">Touch it</a>
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
		<!--<div class="menu">
		<ul>
		<li><a href="#">首頁</a></li>
		<li><a href="#">聯絡我們</a></li>
		</ul>
		</div>-->
		</div>
		<div class="copyrights">
		<p>Copyright 2016. Designed by <a href="#" target="blank">EasySuccess team</a></p>
		</div>
		</div>
		</div>
		</footer>
		</div>
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
						var ajaxurl = "lib/ajax.php";
						var data =  {"action": "99", "cocode":<?php echo $_SESSION['MM_CoCode']; ?>, "param": row['StuCode']};
						$.ajaxSetup({async: false});
						$.post(ajaxurl, data, function (data,status) {});
						location.reload();
					}
				});
			});
		});
	</script>
</html>