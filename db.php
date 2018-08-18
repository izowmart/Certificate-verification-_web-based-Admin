<?php 
	session_start();
	$edit_state = false;
	$name = "";
	$institution = "";
	$reg_number = "";
	$grade = "";
	$date = "";
	$id = 0;
	$update = false;
	try {
		$pdo = new PDO('mysql:host=localhost;dbname=certificate_verification','izowmart','mightmight');
		$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		
	} catch (Exception $e) {
		echo "Connection Failed! ".$e->getMessage();
	}

