<?php	
require_once('lib/meekrodb.2.3.class.php'); 
require_once('lib/config.php'); 



?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Pi page</title>
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
				</div>
				<nav>
					<ul>
						<li class="current-menu-item"><a href="index.html">首頁</a></li>
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
		<h1 class="heading">智能補習中心－下環街分店</h1>
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
										<p><span>上課時間：<span class="sum" id="inTime"></span></span></p>
										<!-- <p><span>現在時間：<span class="sum" id="pickUpTime"></span></span></p> -->
										<p><span>狀況:<span class="sum" id="status"></span></span></p>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer  form-group">
							<button id="pickWait" type="submit" class="btn theme-btn-2 cricle hide" value="wait">等一下</button>
							<button id="pickNow" type="submit" class="btn theme-btn-2 cricle hide" value="immediate">立即接走</button>
							<button type="close" class="btn theme-btn-2 cricle">返回</button>
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
			
			$('#checkInBtn').click(function (e) {
			
				$.ajaxSetup({async: false});
				data =  {'action': 'checkCardId','param': $("#checkInID").val()};
				$.post('lib/ajax.php', data, function (response,status) {
					var rows = $.parseJSON(response);
					
					if(rows.length > 1){
						//handle the error
					}else{
						var row = rows[0];
						console.log(row);
						$("#checkInModal h1").html(row["StuName"]);
						$("#checkInModal h1").attr("value", row["StuCode"]);
						$("#inTime").html(row["StuArriveTime"]);
						switch(row["StuStatus"]){
							case "done":
								$("#status").html("已完成作業");
								$("#pickNow").removeClass("hide");
								break;
							case "wait":
								$("#status").html("家長等候中");
								break;
							case "immediate":
								$("#status").html("家長要求立即接走學生");
								break;
							case "on":
								$("#status").html("上課中");
								$("#pickWait").removeClass("hide");
								$("#pickNow").removeClass("hide");
								break;
							case "off":
								$("#status").html("已下課");
								break;
							default:
								$("#status").html("請聯絡職員");
								break;
						}
					}
				});
			});
			
			$('button[type="submit"]').click(function(){
				var action = $(this).val();
				var stuCode = $("#checkInModal h1").attr("value");
				var ajaxurl = 'lib/ajax.php',
				data =  {'action': action,'param': stuCode};
				$.ajaxSetup({async: false});
				$.post(ajaxurl, data, function (data,status) {
				}).always(function(){
				});
			});
			
			
		});
	</script>
</html>
