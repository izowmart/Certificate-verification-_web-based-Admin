<?php 
include ("db.php");

	if (isset($_POST['save'])) {

		$name = $_POST["name"];
		$institution = $_POST["institution"];
		$reg_number = $_POST["reg_number"];
		$grade = $_POST["grade"];
	   $date = $_POST["date"];
		
		$sql = "INSERT INTO certificates(name,institution,reg_number,grade,tdate) VALUES(?,?,?,?,?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$name,$institution,$reg_number,$grade,$date]);

		header('location: home.php');
	}
// retrieve records
	$stmt =$pdo->prepare("SELECT * FROM certificates");
	$stmt->execute([]);

	// update record
	if (isset($_POST['update'])) {

		$name = $_POST["name"];
		$institution = $_POST["institution"];
		$reg_number = $_POST["reg_number"];
		$grade = $_POST["grade"];
	   $date = $_POST["date"];
	   $id = $_POST["id"];

	   $sql = "UPDATE certificates SET name= '$name',institution= '$institution',reg_number= '$reg_number',grade= '$grade', tdate= '$date' WHERE id= $id";
		$stmt =$pdo->prepare($sql);
		$stmt->execute();
		header('location: home.php');
	}
	// sending feedback to users

	if (isset($_POST['feedback_submit'])) {
		$msg = 'Hello: '. $_POST['name'].'\n'
				.'Feedback: '. $_POST['feedback'];
		mail($_POST['email'], "Feedback report from certificate verification centre by admin", $msg,"izowmart7@gmail.com");	
		header('location: home.php');	
	}
 ?>

 