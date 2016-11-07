<?php
require_once('lib/config.php');

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
	session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
	$_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
	$loginUsername           = $_POST['username'];
	$password                = $_POST['pwd'];
	$MM_fldUserAuthorization = "UserRole";
	$MM_redirectLoginSuccess = "menu.php";
	$MM_redirectLoginFailed  = "loginFailed.php";
	$MM_redirecttoReferrer   = false;
	
	$LoginRS = DB::queryFirstRow("SELECT UserName, UserPw, UserRole, CoCode FROM tbuser WHERE UserName=%s AND UserPw=%s", GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text"));
	$loginFoundUser = count($LoginRS);
		
	if ($loginFoundUser) {
		
		$loginStrGroup = $LoginRS['UserRole'];
		$loginCoCode = $LoginRS['CoCode'];
		
		echo $loginCoCode;
				
		if (PHP_VERSION >= 5.1) {
			session_regenerate_id(true);
		} else {
			session_regenerate_id();
		}
		//declare session variables and assign them
		$_SESSION['MM_Username']  = $loginUsername;
		$_SESSION['MM_UserGroup'] = $loginStrGroup;
		$_SESSION['MM_CoCode'] = $loginCoCode;
		
		if (isset($_SESSION['PrevUrl']) && false) {
			$MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
		}
		header("Location: " . $MM_redirectLoginSuccess);
	} else {
		header("Location: " . $MM_redirectLoginFailed);
	}
}
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>AdminLTE 2 | Log in</title>
      <!-- Tell the browser to be responsive to screen width -->
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- Bootstrap 3.3.6 -->
      <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
      <!-- iCheck -->
      <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body class="hold-transition login-page">
      <div class="login-box">
         <div class="login-logo">
            <a href="index2.html"><b>Admin</b>BE</a>
         </div>
         <!-- /.login-logo -->
         <div class="login-box-body">
            <p class="login-box-msg">請輸入登入資訊</p>
            <form ACTION="<?php echo $loginFormAction;?>" name="formLogin" method="POST">
               <div class="form-group has-feedback">
                  <input type="text" class="form-control" id="username" name="username" placeholder="username">
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
               </div>
               <div class="form-group has-feedback">
                  <input type="password" class="form-control" id="pwd" name="pwd" placeholder="password">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
               </div>
               <div class="row">
                  <div class="col-xs-8">
                     <div class="checkbox icheck">
                        <label>
                        <input type="checkbox"> 記住
                        </label>
                     </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-4">
                     <button type="submit" class="btn btn-primary btn-block btn-flat">登入</button>
                  </div>
                  <!-- /.col -->
               </div>
            </form>
            <!--div class="social-auth-links text-center">
               <p>- OR -</p>
               <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
                 Facebook</a>
               <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
                 Google+</a>
               </div-->
            <!-- /.social-auth-links -->
            <a href="#">忘記密碼</a><br>
            <a href="register.html" class="text-center">註冊</a>
         </div>
         <!-- /.login-box-body -->
      </div>
      <!-- /.login-box -->
      <!-- jQuery 2.2.3 -->
      <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
      <!-- Bootstrap 3.3.6 -->
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <!-- iCheck -->
      <script src="plugins/iCheck/icheck.min.js"></script>
      <script>
         $(function () {
           $('input').iCheck({
             checkboxClass: 'icheckbox_square-blue',
             radioClass: 'iradio_square-blue',
             increaseArea: '20%' // optional
           });
         });
      </script>
   </body>
</html>