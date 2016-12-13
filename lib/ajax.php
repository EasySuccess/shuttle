<?php
require_once("meekrodb.2.3.class.php");
require_once("config.php");

if (isset($_POST['action'])) {
	
	$action = $_POST['action'];
	$coCode = $_POST['cocode'];
	$param = $_POST['param'];
	
	switch ($action) {
		case "reset":
			resetStuStatus($coCode, $param);
			break;
		case "1":
			updateParentStatus($action, $param, $coCode);
			break;
		case "99":
			updateParentStatus($action, $param, $coCode);
			break;
		case "4":
			updateStuStatus($action, $param, $coCode);
			break;
		case "1":
			updateStuStatus($action, $param, $coCode);
			break;
		case "done":
			updateStuStatus($action, $param, $coCode);
			break;
		case "2":
			updateStuStatus($action, $param, $coCode);
			break;
		case "0":
			updateStuStatus($action, $param, $coCode);
			break;
		case "checkCardId":
			checkCard($param, $coCode);
			break;
	}
}

function resetStuStatus($coCode, $status)
{
	DB::update("tbstustatus", array(
		"StuStatus" => $status,
		"StuPickupStatus" => NULL,
	), "CoCode=%s", $coCode);
	
	exit;
}

function updateStuStatus($action, $stuCode, $coCode){
	DB::update("tbstustatus", array(
		"StuStatus" => $action,
	), "StuCode=%s and CoCode=%s", $stuCode, $coCode);
	
	DB::insert("tblog", array(
		"StuStatus" => $action,
		"StuCode" => $stuCode,
		"CoCode" => $coCode,
		"Created" => NULL,
	));
}

function updateParentStatus($action, $stuCode, $coCode)
{
	DB::update("tbstustatus", array(
		"StuPickupStatus" => $action,
	), "StuCode=%s and CoCode=%s", $stuCode, $coCode);
	
	DB::insert("tblog", array(
		"StuStatus" => $action,
		"StuCode" => $stuCode,
		"CoCode" => $coCode,
		"Created" => NULL,
	));
}


function checkCard($cardId, $coCode)
{
	// $results = DB::queryFirstRow("SELECT tbstudent.StuName, tbstudent.StuCode, tbstustatus.StuStatus, tbstustatus.StuPickupStatus, tblog.Created 
	// FROM tbcard INNER JOIN tbstudent ON tbcard.StuCode=tbstudent.StuCode 
	// INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
	// INNER JOIN tblog ON tblog.StuCode=tbcard.StuCode AND tblog.CoCode=tbstudent.CoCode AND tblog.StuStatus=tbstustatus.StuStatus
	// WHERE tbstudent.CoCode=%s and tbcard.CardId=%s
	// ORDER BY tblog.LogId DESC", $coCode, $cardId);
	
	$results = DB::queryFirstRow("SELECT tbstudent.StuName, tbstudent.StuCode, tbstustatus.StuStatus, tbstustatus.StuPickupStatus
	FROM tbcard INNER JOIN tbstudent ON tbcard.StuCode=tbstudent.StuCode 
	INNER JOIN tbstustatus ON tbstudent.StuCode=tbstustatus.StuCode 
	WHERE tbstudent.CoCode=%s and tbcard.CardId=%s", $coCode, $cardId);
	
	print json_encode($results);

}
?>