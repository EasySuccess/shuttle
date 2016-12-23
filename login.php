<?php

require_once('lib/config.php');

if (!isset($_SESSION)) {
	session_start();
}
$formAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
	$_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
if (isset($_POST['username'])) {
	$loginUsername = $_POST['username'];
	$password = $_POST['pwd'];
	
	$MM_redirectLoginSuccess = "index.php";
	$MM_redirectLoginFailed  = "loginFailed.php";
	$MM_redirectLoginNoPermission  = "noPermission.php";
	$MM_redirecttoReferrer   = false;
	
	$loginRS = DB::queryFirstRow("SELECT UserId, UserName, UserPw, UserRole, CoCode FROM tbuser WHERE UserName=%s", $loginUsername);
	
	if ($loginRS != NULL) {
		$t_hasher = new PasswordHash(8, FALSE);
		if($t_hasher->CheckPassword($password, $loginRS['UserPw'])){
			$loginStrGroup = $loginRS['UserRole'];
			$loginCoCode = $loginRS['CoCode'];
			
			// Redirect to Index for Admin or User with company 
			if( (strcmp($loginStrGroup,"admin") == 0) || (($loginCoCode != NULL) && ($loginCoCode != "")) ){
							
				if (PHP_VERSION >= 5.1) {
					session_regenerate_id(true);
				} else {
					session_regenerate_id();
				}
				//declare session variables and assign them
				$_SESSION['MM_UserId']  = $loginRS['UserId'];
				$_SESSION['MM_Username']  = $loginUsername;
				$_SESSION['MM_UserGroup'] = $loginStrGroup;
				$_SESSION['MM_CoCode'] = $loginCoCode;
							
				if (isset($_SESSION['PrevUrl']) && $MM_redirecttoReferrer) {
					$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
				}
				header("Location: " . $MM_redirectLoginSuccess);
				
			} else {header("Location: " . $MM_redirectLoginNoPermission);}
		} else {echo "密碼不正確";}
	} else {echo "找不到用戶名稱";}
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
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<p class="lead"></p>
				<form action="<?php echo $formAction;?>" name="formLogin" method="POST" class="form-horizontal">
					<fieldset>
						<!-- Form Name -->
						<legend>請輸入登入資訊</legend>
						<!-- Text input-->
						<div class="form-group">
							<div class="col-md-4">
								<input type="text" class="form-control" id="username" name="username" placeholder="登入名稱">
							</div>
						</div>
						<!-- Text input-->
						<div class="form-group">
							<div class="col-md-4">
								<input type="password" class="form-control" id="pwd" name="pwd" placeholder="密碼">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-4">
								 <button type="submit" class="btn btn-primary btn-block btn-flat">登入</button>
							</div>
						</div>
					</fieldset>
				</form>
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