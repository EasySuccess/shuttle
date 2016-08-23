<?php	

	require_once('meekrodb.2.3.class.php'); 
	require_once('config.php'); 

	DB::$error_handler = false;	
	
	echo "Running script to generate demo data";
	
	//Company
	DB::insert("tbCo", array(
		'CoCode' => 'c001',
		'CoFullName' => 'company1',
		'CoName' => 'company1',
	));
	
	//Student
	DB::insert("tbStudent", array(
		'StuCode' => 's001',
		'CoCode' => 'c001',
		'StuName' => 'student1',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's002',
		'CoCode' => 'c001',
		'StuName' => 'student2',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's003',
		'CoCode' => 'c001',
		'StuName' => 'student3',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's004',
		'CoCode' => 'c001',
		'StuName' => 'student4',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's005',
		'CoCode' => 'c001',
		'StuName' => 'student5',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's006',
		'CoCode' => 'c001',
		'StuName' => 'student6',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's007',
		'CoCode' => 'c001',
		'StuName' => 'student7',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's008',
		'CoCode' => 'c001',
		'StuName' => 'student8',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's009',
		'CoCode' => 'c001',
		'StuName' => 'student9',
	));
	DB::insert("tbStudent", array(
		'StuCode' => 's010',
		'CoCode' => 'c001',
		'StuName' => 'student10',
	));
	
	//Student Status
	DB::insert("tbStuStatus", array(
		'StuCode' => 's001',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's002',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's003',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's004',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's005',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's006',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's007',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's008',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's009',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's010',
		'CoCode' => 'c001',
		'StuStatus' => '4',
		'StuPickupStatus' => '99',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	
	//Card
	DB::insert("tbCard", array(
		'StuCode' => 's001',
		'CoCode' => 'c001',
		'CardId' => '1',
	));
		DB::insert("tbCard", array(
		'StuCode' => 's002',
		'CoCode' => 'c002',
		'CardId' => '2',
	));
		DB::insert("tbCard", array(
		'StuCode' => 's003',
		'CoCode' => 'c003',
		'CardId' => '3',
	));	
	DB::insert("tbCard", array(
		'StuCode' => 's004',
		'CoCode' => 'c004',
		'CardId' => '4',
	));	
	DB::insert("tbCard", array(
		'StuCode' => 's005',
		'CoCode' => 'c005',
		'CardId' => '5',
	));
		DB::insert("tbCard", array(
		'StuCode' => 's006',
		'CoCode' => 'c006',
		'CardId' => '6',
	));
		DB::insert("tbCard", array(
		'StuCode' => 's007',
		'CoCode' => 'c007',
		'CardId' => '7',
	));
		DB::insert("tbCard", array(
		'StuCode' => 's008',
		'CoCode' => 'c008',
		'CardId' => '8',
	));
		DB::insert("tbCard", array(
		'StuCode' => 's009',
		'CoCode' => 'c009',
		'CardId' => '9',
	));	
	DB::insert("tbCard", array(
		'StuCode' => 's010',
		'CoCode' => 'c010',
		'CardId' => '10',
	));
	
?>