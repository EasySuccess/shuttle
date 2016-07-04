<?php	

	require_once('meekrodb.2.3.class.php'); 
	require_once('config.php'); 
	
	echo "Running script to create tables";
	
	DB::$error_handler = false;
				
	$tbCo = "CREATE TABLE tbCo (
				CoCode VARCHAR(10) NOT NULL UNIQUE PRIMARY KEY,
				CoFullName VARCHAR(50),
				CoName VARCHAR(50),
				CoAddress VARCHAR(50),
				CoTel VARCHAR(30),
				CoContact VARCHAR(30),
				CoEmail VARCHAR(30),
				CoFax VARCHAR(30),
				CoStatus VARCHAR(10)
			)";
			
	$tbStudent = "CREATE TABLE tbStudent (
				StuCode VARCHAR(10) NOT NULL UNIQUE PRIMARY KEY,
				CoCode VARCHAR(10),
				StuName VARCHAR(10),
				StuSex VARCHAR(6),
				StuBirth DATE,
				StuAddress VARCHAR(100),
				StuFather VARCHAR(30),
				StuFatherTel VARCHAR(30),
				StuMum VARCHAR(30),
				StuMumTel VARCHAR(30),
				StuContact VARCHAR(30),
				StuContactTel VARCHAR(30),
				StuRemark VARCHAR(300),
				StuGrad VARCHAR(10),
				FOREIGN KEY (CoCode)
					REFERENCES tbCo(CoCode)
			)";
	
	$tbCard = "CREATE TABLE tbCard (
				CardId VARCHAR(10) NOT NULL PRIMARY KEY,
				CoCode VARCHAR(10),
				StuCode VARCHAR(10),
				FOREIGN KEY (CoCode)
					REFERENCES tbCo(CoCode),
				FOREIGN KEY (StuCode)
					REFERENCES tbStudent(StuCode)
			)";
	
	$tbAttend = "CREATE TABLE tbAttend (
				AttId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				AttDate DATETIME,
				CardId VARCHAR(10),
				StuCode VARCHAR(10), 
				CoCode VARCHAR(10),
				FOREIGN KEY (CardId)
					REFERENCES tbCard(CardId),
				FOREIGN KEY (CoCode)
					REFERENCES tbCo(CoCode),
				FOREIGN KEY (StuCode)
					REFERENCES tbStudent(StuCode)
			)";
			
	$tbStuStatus = "CREATE TABLE tbStuStatus (
				StuCode	VARCHAR(10), 
				CoCode VARCHAR(10), 
				StuStatus VARCHAR(10), 
				StuShuttle VARCHAR(10), 
				StuArriveTime DATETIME,
				StuDefaultTime DATETIME,
				FOREIGN KEY (CoCode)
					REFERENCES tbCo(CoCode),
				FOREIGN KEY (StuCode)
					REFERENCES tbStudent(StuCode)
			)";
	
	$tbAudit = "CREATE TABLE tbAudit (
				AuditId INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				StuCode	VARCHAR(10), 
				CoCode VARCHAR(10), 
				AuditDate DATETIME,
				AuditRec VARCHAR(50),
				FOREIGN KEY (CoCode)
					REFERENCES tbCo(CoCode),
				FOREIGN KEY (StuCode)
					REFERENCES tbStudent(StuCode)
			)";
	
	if (DB::query($tbCo) === TRUE) {
		echo "Table tbCo created successfully";
	} else {
		echo "Table tbCo already exists" . "<br>";
	}
	if (DB::query($tbStudent) === TRUE) {
		echo "Table tbStudent created successfully";
	} else {
		echo "Table tbStudent already exists" . "<br>";
	}
	if (DB::query($tbCard) === TRUE) {
		echo "Table tbCard created successfully";
	} else {
		echo "Table tbCard already exists" . "<br>";
	}
	if (DB::query($tbAttend) === TRUE) {
		echo "Table tbAttend created successfully";
	} else {
		echo "Table tbAttend already exists" . "<br>";
	}
	if (DB::query($tbStuStatus) === TRUE) {
		echo "Table tbStuStatus created successfully";
	} else {
		echo "Table tbStuStatus already exists" . "<br>";
	}
	if (DB::query($tbAudit) === TRUE) {
		echo "Table tbAudit created successfully";
	} else {
		echo "Table tbAudit already exists" . "<br>";
	}
	
?>