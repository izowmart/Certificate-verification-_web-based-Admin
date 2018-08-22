<?php 
	include ("db.php");

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.html');
	}
 ?>