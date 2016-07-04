<?php	
require_once('lib/meekrodb.2.3.class.php'); 
require_once('lib/config.php'); 
	
function showOnline(){
	$results = DB::query("SHOW TABLES");
	foreach ($results as $row) {
		echo $row["Tables_in_education"] . "\n";
	} 
}

function showPending(){
	$results = DB::query("SHOW TABLES");
	foreach ($results as $row) {
		echo $row["Tables_in_education"] . "\n";
	} 
}

function showOffline(){
	$results = DB::query('SELECT * FROM tbStudent WHERE CoCode=%s', DB::$coCode);
	foreach ($results as $row) {
		echo '<li>' .
			'<a data-toggle="modal" data-target="#onClassModal" id="actionBarSignUpBtn">' .
			'<span class="">' .
			'<img src="img/circle_img.svg" alt="img" class="img-circle">' .
			'<span class="circle_in_blue"></span>' .
			'</span>' .
			'<span class="title-1"><span class="title-main">姓名：</span><span class="title-sub">'.$row["StuName"].'</span></span>' .
			'<span class="title-2"><span class="title-main">上課時間：</span><span class="title-sub">2016-07-03  18:30</span></span>' .
			'<span class="title-3"><span class="title-main">備註：</span><span class="title-sub">遲到10分鐘</span></span>' .
			'</a>' .
		'</li>';
	} 
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>shuttle</title>
		<meta name="description" content="接送系統" />
		<meta name="author" content="接送系統" />
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
								<h1>logo</h1>
							</a>
						</div>
						<div class="col-xs-8 col-sm-10">
							<div class="action-bar" id="frontend-action-bar">
								<span class="menu-toggle no-select">Menu
								<span class="hamburger"><span class="menui top-menu"></span><span class="menui mid-menu"></span><span class="menui bottom-menu"></span></span>
								</span>
								<!--<span class="menu-toggleList" data-toggle="modal" data-target="#registerModal" id="actionBarSignUpBtn">註冊</span>
									<span class="menu-toggleList" data-toggle="modal" data-target="#loginModal" id="actionBarLogInBtn">登入</span>
									<a href="javascript:logOut()" class="menu-toggleList" id="actionBarLogOutBtn">登出</a>-->
							</div>
						</div>
					</div>
				</div>
				<nav>
					<ul>
						<li class="current-menu-item"><a href="index.html">首頁</a></li>
						<li><a href="#">聯絡方法</a></li>
					</ul>
				</nav>
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
							<div class="col-sm-6 col-md-4">
								<div class="links-box">
									<h3 class="caption green">上課中學生</h3>
									<ul class="links">
										<?php showOnline(); ?>
										<li class="hide">
											<a data-toggle="modal" data-target="#onClassModal" id="actionBarSignUpBtn">
											<span class="">
											<img src="img/circle_img.svg" alt="img" class="img-circle">
											<span class="circle_in_green"></span>
											</span>
											<span class="title-1"><span class="title-main">姓名：</span><span class="title-sub">黎小明</span></span>
											<span class="title-2"><span class="title-main">上課時間：</span><span class="title-sub">2016-07-03 18:30</span></span>
											<span class="title-3"><span class="title-main">備註：</span><span class="title-sub">遲到10分鐘</span></span>
											</a>
										</li>
										<!--[end]li-->
									</ul>
								</div>
							</div>
							<!--[end]上課中學生-->	
							<div class="col-sm-6 col-md-4" >
								<div class="links-box" >
									<h3 class="caption yellow">需要落課學生</h3>
									<ul class="links">
										<?php showPending(); ?>
										<li class="hide">
											<a data-toggle="modal" data-target="#onClassModal" id="actionBarSignUpBtn">
											<span class="">
											<img src="img/circle_img.svg" alt="img" class="img-circle">
											<span class="circle_in_yellow"></span>
											</span>
											<span class="title-1"><span class="title-main">姓名：</span><span class="title-sub">黎小明</span></span>
											<span class="title-2"><span class="title-main">上課時間：</span><span class="title-sub">2016-07-03 18:30</span></span>
											<span class="title-3"><span class="title-main">備註：</span><span class="title-sub">遲到10分鐘</span></span>
											</a>
										</li>
										<!--[end]li-->
									</ul>
								</div>
							</div>
							<!--[end]需要落課學生-->
							<div class="col-sm-6 col-md-4">
								<div class="links-box">
									<h3 class="caption blue">未上課學生</h3>
									<ul class="links">
										<?php showOffline(); ?>
										<li class="hide">
											<a data-toggle="modal" data-target="#onClassModal" id="actionBarSignUpBtn">
											<span class="">
											<img src="img/circle_img.svg" alt="img" class="img-circle">
											<span class="circle_in_blue"></span>
											</span>
											<span class="title-1"><span class="title-main">姓名：</span><span class="title-sub">黎小明</span></span>
											<span class="title-2"><span class="title-main">上課時間：</span><span class="title-sub">2016-07-03 18:30</span></span>
											<span class="title-3"><span class="title-main">備註：</span><span class="title-sub">遲到10分鐘</span></span>
											</a>
										</li>
										<!--[end]li-->
									</ul>
								</div>
							</div>
							<!--[end]未上課學生-->	
						</div>
					</div>
				</div>
			</div>
			<!-- Footer -->
			<footer class="">
				<div class="container">
					<div class="footer-wrapper">
						<div class="main-area">
							<div class="menu">
								<ul>
									<li><a href="index.html">首頁</a></li>
									<li><a href="#">聯絡我們</a></li>
								</ul>
							</div>
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
							<h1>黎小明</h1>
						</div>
					</div>
					<div class="blackout"></div>
					<form role="form" data-toggle="validator" class="RegisterLogin" id="loginForm">
						<div class="modal-body">
							<div class="form-group">
								<div class="onclass-from">
									<div class="onclass" id="">
										<p><span>上課時間：<span class="sum" id="cart-balance">2016-10-10 10:00</span></span></p>
										<p><span>現在時間：<span class="sum" id="cart-balance-after">2016-10-10 10:00</span></span></p>
									</div>
								</div>
								<label for="username" class="control-label">備註:</label>
								<input type="text" class="form-control" id="username" name="" required>
							</div>
						</div>
						<div class="modal-footer  form-group">
							<button type="submit" class="btn theme-btn-2">確定</button>
							<button type="close" class="btn theme-btn-2" data-dismiss="modal">取消</button>
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
</html>