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
	DB::update('tbstustatus', array(
	  'stuStatus' => 'off',
	  'stuArriveTime' => NULL,
	  'stuPickupStatus' => NULL,
	  'stuPickupArriveTime' => NULL,
	  'stuLeaveTime' => NULL
	  ), "coCode=%s", DB::$coCode);
	exit;
}

function updateOn($stuCode) {
    DB::update('tbstustatus', array(
	  'stuStatus' => 'on',
	  'stuArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateDone($stuCode) {
    DB::update('tbstustatus', array(
	  'stuStatus' => 'done',
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateLeave($stuCode) {
    DB::update('tbstustatus', array(
	  'stuStatus' => 'leave',
	  'stuLeaveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateImmed($stuCode) {
    DB::update('tbstustatus', array(
	  'stuPickupStatus' => 'immediate',
	  'stuPickupArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function updateWait($stuCode) {
    DB::update('tbstustatus', array(
	  'stuPickupStatus' => 'wait',
	  'stuPickupArriveTime' => date("Y-m-d H:i:s")
	  ), "stuCode=%s and coCode=%s", $stuCode, DB::$coCode);
    exit;
}

function checkCard($cardId) {
	$results = DB::query('SELECT * 
	FROM tbcard INNER JOIN tbstudent ON tbcard.StuCode=tbstudent.StuCode INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
	WHERE tbstudent.CoCode=%s and tbcard.CardId=%s', DB::$coCode, $cardId);
	
	print json_encode($results); ;
}
?>