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

/*

StuStatus
1 - on
2 - done
3 - leave
4 - off

StuPickupStatus
1 - immediate
2 - wait
other - 99

*/



function resetStuStatus(){
	DB::update('tbStuStatus', array(
	  'stuStatus' => 4,
	  'stuArriveTime' => NULL,
	  'stuPickupStatus' => 99,
	  'stuPickupArriveTime' => NULL,
	  'stuLeaveTime' => NULL
	  ), "coCode=%s", DB::$coCode);
	exit;
}

function updateOn($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 1,
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateDone($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 2,
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateLeave($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuStatus' => 3,
	  'stuLeaveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateImmed($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuPickupStatus' => 1,
	  'stuPickupArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateWait($stuCode) {
    DB::update('tbStuStatus', array(
	  'stuPickupStatus' => 2,
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