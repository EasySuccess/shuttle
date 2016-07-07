<?php
require_once('meekrodb.2.3.class.php'); 
require_once('config.php'); 
date_default_timezone_set("Asia/Hong_Kong");

if (isset($_POST['action'])) {

	$stuCode = $_POST['stuCode'];
	
    switch ($_POST['action']) {
        case 'wait':
            updateWait($stuCode);
            break;
        case 'immediate':
            updateImmed($stuCode);
            break;
		case 'off':
			updateOff($stuCode);
			break;
		case 'on':
			updateOn($stuCode);
			break;
    }
}

function updateWait($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'pending',
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateImmed($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'pending',
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateOff($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'off',
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateOn($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'on',
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}
?>