<?php

require_once("../lib/config.php");

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

if ((isset($_GET['UserId'])) && ($_GET['UserId'] != "")) {

	DB::update("tbuser", array(
		"CoCode" =>  NULL
	), "UserId=%d", $_GET['UserId']);
		
    header(sprintf("Location: %s", $_SERVER['HTTP_REFERER']));
}
?>