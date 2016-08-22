<?php
require_once('meekrodb.2.3.class.php'); 
require_once('config.php'); 

if (isset($_POST['action'])) {

	$param = $_POST['param'];
	
    switch ($_POST['action']) {
        case 'wait':
            updateWait($param);
            break;
        case 'immediate':
            updateImmed($param);
            break;
		case 'off':
			updateOff($param);
			break;
		case 'on':
			updateOn($param);
			break;
		case 'checkCardId':
			checkCard($param);
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
	  'stuStatus' => 'immediate',
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

function checkCard($cardId) {
	$results = DB::query('SELECT * 
	FROM tbCard INNER JOIN tbStudent ON tbCard.StuCode=tbStudent.StuCode INNER JOIN tbStuStatus ON tbStudent.StuCode=tbStuStatus.StuCode 
	WHERE tbStudent.CoCode=%s and tbCard.CardId=%s', DB::$coCode, $cardId);
	
	print json_encode($results); ;
}
?>