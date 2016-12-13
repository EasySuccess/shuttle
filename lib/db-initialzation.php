<?php	

	require_once('meekrodb.2.3.class.php'); 
	require_once('config.php'); 

	DB::$error_handler = false;	
	
	echo "Initializing Database <br>";
	
	
	echo "Creating admin account <br>";
	DB::insert("tbuser", array(
		'UserName' => 'admin',
		'UserPw' => '$2a$08$1R7M9z1DHakaBZFKroCdk.6Tikq/WBU.rsdIv9Nc1vfvaP9A.5p2W',
		'UserRole' => 'admin',
		'Created' => NULL,
	));
	
	echo "Creating default group <br>";
	DB::insert("tbgroup", array(
		'GroupId' => 1,
		'GroupName' => 'N/A',
		'Created' => NULL,
	));
	
	// //Student
	// DB::insert("tbstudent", array(
		// 'StuCode' => 1,
		// 'CoCode' => 1,
		// 'StuName' => 'student1',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 2,
		// 'CoCode' => 1,
		// 'StuName' => 'student2',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 3,
		// 'CoCode' => 1,
		// 'StuName' => 'student3',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 4,
		// 'CoCode' => 1,
		// 'StuName' => 'student4',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 5,
		// 'CoCode' => 1,
		// 'StuName' => 'student5',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 6,
		// 'CoCode' => 1,
		// 'StuName' => 'student6',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 7,
		// 'CoCode' => 1,
		// 'StuName' => 'student7',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 8,
		// 'CoCode' => 1,
		// 'StuName' => 'student8',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 9,
		// 'CoCode' => 1,
		// 'StuName' => 'student9',
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstudent", array(
		// 'StuCode' => 10,
		// 'CoCode' => 1,
		// 'StuName' => 'student10',
		// 'Created' => NULL,
	// ));
	
	// //Student Status
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 1,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 2,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 3,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 4,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 5,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 6,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 7,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 8,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 9,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	// DB::insert("tbstustatus", array(
		// 'StuCode' => 10,
		// 'CoCode' => 1,
		// 'StuStatus' => '4',
		// 'StuPickupStatus' => '99',
		// 'StuArriveTime' => date("Y-m-d H:i:s"),
		// 'Created' => NULL,
	// ));
	
	// //Card
	// DB::insert("tbcard", array(
		// 'StuCode' => 1,
		// 'CoCode' => 1,
		// 'CardId' => '1',
		// 'Created' => NULL,
	// ));
		// DB::insert("tbcard", array(
		// 'StuCode' => 2,
		// 'CoCode' => 1,
		// 'CardId' => '2',
		// 'Created' => NULL,
	// ));
		// DB::insert("tbcard", array(
		// 'StuCode' => 3,
		// 'CoCode' => 1,
		// 'CardId' => '3',
		// 'Created' => NULL,
	// ));	
	// DB::insert("tbcard", array(
		// 'StuCode' => 4,
		// 'CoCode' => 1,
		// 'CardId' => '4',
		// 'Created' => NULL,
	// ));	
	// DB::insert("tbcard", array(
		// 'StuCode' => 5,
		// 'CoCode' => 1,
		// 'CardId' => '5',
		// 'Created' => NULL,
	// ));
		// DB::insert("tbcard", array(
		// 'StuCode' => 6,
		// 'CoCode' => 1,
		// 'CardId' => '6',
		// 'Created' => NULL,
	// ));
		// DB::insert("tbcard", array(
		// 'StuCode' => 7,
		// 'CoCode' => 1,
		// 'CardId' => '7',
		// 'Created' => NULL,
	// ));
		// DB::insert("tbcard", array(
		// 'StuCode' => 8,
		// 'CoCode' => 1,
		// 'CardId' => '8',
		// 'Created' => NULL,
	// ));
		// DB::insert("tbcard", array(
		// 'StuCode' => 9,
		// 'CoCode' => 1,
		// 'CardId' => '9',
		// 'Created' => NULL,
	// ));	
	// DB::insert("tbcard", array(
		// 'StuCode' => 10,
		// 'CoCode' => 1,
		// 'CardId' => '10',
		// 'Created' => NULL,
	// ));
	
?>