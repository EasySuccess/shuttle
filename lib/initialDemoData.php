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
		'StuStatus' => 'on',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's002',
		'CoCode' => 'c001',
		'StuStatus' => 'on',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's003',
		'CoCode' => 'c001',
		'StuStatus' => 'pending',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's004',
		'CoCode' => 'c001',
		'StuStatus' => 'pending',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's005',
		'CoCode' => 'c001',
		'StuStatus' => 'off',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's006',
		'CoCode' => 'c001',
		'StuStatus' => 'off',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's007',
		'CoCode' => 'c001',
		'StuStatus' => 'off',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's008',
		'CoCode' => 'c001',
		'StuStatus' => 'off',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's009',
		'CoCode' => 'c001',
		'StuStatus' => 'off',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	DB::insert("tbStuStatus", array(
		'StuCode' => 's010',
		'CoCode' => 'c001',
		'StuStatus' => 'off',
		'stuarrivetime' => date("Y-m-d H:i:s"),
	));
	
?>