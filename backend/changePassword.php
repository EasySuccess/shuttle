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

$tableName = "tbuser";
$homeUrl = "../index.php";
$nextUrl = "../index.php";
$prevUrl = "../index.php";

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	$t_hasher = new PasswordHash(8, FALSE);
	
	DB::update($tableName, array(
		"UserPw" =>  $t_hasher->HashPassword($_POST['UserPw']),
	), "UserId=%s", $_SESSION['MM_UserId']);
	
    header("Location: $nextUrl");
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
		<title>干策钡癳╰参</title>
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
					<a class="navbar-brand" href="#">干策钡癳╰参</a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
					<ul class="nav navbar-nav">
					  <li class="active"><a href="../index.php">匡虫</a></li>
					  <li><a href="<?php echo $prevUrl; ?>"></a></li>
					  <li><a href="../logout.php">祅</a></li>
				   </ul>
				</div>
				<!--/.nav-collapse -->
			</div>
		</nav>
		<div class="container">
			<div class="starter-template">
				<p class="lead"></p>
				<form method="post" name="form1" action="<?php echo $formAction; ?>" class="form-horizontal">
					<fieldset>
						<!-- Form Name -->
						<legend>э盞絏</legend>
						<!-- Text input-->
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">穝盞絏:</label>  
							<div class="col-md-4">
								<input id="textinput" name="UserPw"  type="password" placeholder="" class="form-control input-md" autofocus required>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput">近穝盞絏:</label>  
							<div class="col-md-4">
								<input id="textinput" name="UserPw2" type="password" placeholder="" class="form-control input-md" required>
								 <div id="pw-message" class="help-block hide" style="color:#db6b6b;">盞絏ぃ璓</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="textinput"></label>  
							<div class="col-md-4">
								<input type="submit" class="btn btn-primary" value="絋粄">
								<a type="button"  class="btn btn-default" href="<?php echo $prevUrl; ?>"></a>
							</div>
						</div>
					</fieldset>
					<input type="hidden" name="MM_insert" value="form1">
				</form>
			</div>
		</div>
		<!-- /.container -->
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="../js/jquery.min.js"></script>
		<script src="../js/bootstrap/bootstrapValidator.min.js"></script>
		<script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
		<script src="../js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="../js/ie10-viewport-bug-workaround.js"></script>
		<script>
			$(document).ready(function() {
				$("input[type='submit']").click(function(e){
					if ( $("input[name='UserPw']").val() !=  $("input[name='UserPw2']").val() ){
						$("#pw-message").removeClass("hide");
						e.preventDefault();
					}
				});
			});
		</script>
	</body>
</html>