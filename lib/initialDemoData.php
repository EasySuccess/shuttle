<?php	

	require_once('meekrodb.2.3.class.php'); 
	require_once('config.php'); 

	DB::$error_handler = false;	
	
	echo "Running script to generate demo data";
	
	//Company
	DB::insert("tbCo", array(
		'CoCode' => 1,
		'CoFullName' => 'company1',
		'CoName' => 'company1',
		'Created' => NULL,
	));
	
	//Student
	DB::insert("tbStudent", array(
		'StuCode' => 1,
		'CoCode' => 1,
		'StuName' => 'student1',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 2,
		'CoCode' => 1,
		'StuName' => 'student2',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 3,
		'CoCode' => 1,
		'StuName' => 'student3',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 4,
		'CoCode' => 1,
		'StuName' => 'student4',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 5,
		'CoCode' => 1,
		'StuName' => 'student5',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 6,
		'CoCode' => 1,
		'StuName' => 'student6',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 7,
		'CoCode' => 1,
		'StuName' => 'student7',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 8,
		'CoCode' => 1,
		'StuName' => 'student8',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 9,
		'CoCode' => 1,
		'StuName' => 'student9',
		'Created' => NULL,
	));
	DB::insert("tbStudent", array(
		'StuCode' => 10,
		'CoCode' => 1,
		'StuName' => 'student10',
		'Created' => NULL,
	));
	
	//Student Status
	DB::insert("tbStuStatus", array(
		'StuCode' => 1,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 2,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 3,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 4,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 5,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 6,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 7,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 8,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 9,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 10,
		'CoCode' => 1,
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
		'Created' => NULL,
	));
	
	//Card
	DB::insert("tbCard", array(
		'StuCode' => 1,
		'CoCode' => 1,
		'CardId' => '1',
		'Created' => NULL,
	));
		DB::insert("tbCard", array(
		'StuCode' => 2,
		'CoCode' => 1,
		'CardId' => '2',
		'Created' => NULL,
	));
		DB::insert("tbCard", array(
		'StuCode' => 3,
		'CoCode' => 1,
		'CardId' => '3',
		'Created' => NULL,
	));	
	DB::insert("tbCard", array(
		'StuCode' => 4,
		'CoCode' => 1,
		'CardId' => '4',
		'Created' => NULL,
	));	
	DB::insert("tbCard", array(
		'StuCode' => 5,
		'CoCode' => 1,
		'CardId' => '5',
		'Created' => NULL,
	));
		DB::insert("tbCard", array(
		'StuCode' => 6,
		'CoCode' => 1,
		'CardId' => '6',
		'Created' => NULL,
	));
		DB::insert("tbCard", array(
		'StuCode' => 7,
		'CoCode' => 1,
		'CardId' => '7',
		'Created' => NULL,
	));
		DB::insert("tbCard", array(
		'StuCode' => 8,
		'CoCode' => 1,
		'CardId' => '8',
		'Created' => NULL,
	));
		DB::insert("tbCard", array(
		'StuCode' => 9,
		'CoCode' => 1,
		'CardId' => '9',
		'Created' => NULL,
	));	
	DB::insert("tbCard", array(
		'StuCode' => 10,
		'CoCode' => 1,
		'CardId' => '10',
		'Created' => NULL,
	));
	
?>