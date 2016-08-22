<?php
require_once('meekrodb.2.3.class.php'); 
require_once('config.php'); 

if (isset($_POST['action'])) {

	$param = $_POST['param'];
	
    switch ($_POST['action']) {
		case 'reset':
			resetStuStatus();
			break;
        case 'wait':
            updateWait($param);
            break;
		case 'immediate':
            updateImmed($param);
            break;
		case 'on':
			updateOn($param);
			break;
		case 'done':
            updateDone($param);
            break;
		case 'leave':
			updateLeave($param);
			break;
		case 'off':
			updateOff($param);
			break;
		case 'checkCardId':
			checkCard($param);
			break;
    }
}

function resetStuStatus(){
	DB::update('tbStuStatus', array(
	  'stuStatus' => 'off',
	  'stuArriveTime' => NULL,
	  'stuPickupStatus' => NULL,
	  'stuPickupArriveTime' => NULL,
	  'stuLeaveTime' => NULL
	  ), "coCode=%s", DB::$coCode);
	exit;
}

function updateOn($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'on',
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateDone($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'done'
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateLeave($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 'leave',
	  'stuLeaveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

// function updateOff($stuCode) {
    // DB::update('tbStuStatus', array(
	  // 'stuStatus' => 'off',
	  // 'stuArriveTime' => date("Y-m-d H:i:s")
	  // ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    // exit;
// }

function updateWait($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuPickupStatus' => 'wait',
	  'stuPickupArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateImmed($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuPickupStatus' => 'immediate',
	  'stuPickupArriveTime' => date("Y-m-d H:i:s")
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