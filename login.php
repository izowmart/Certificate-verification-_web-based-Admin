<?php 
include ("db.php");
	
	if (isset($_POST['login'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		// ensure that form fields are filled properly

		if (empty($username)) {
			echo "Username is required";
		}
		if (empty($password)) {
			echo "Password is required";
		}
		
		$sql = "SELECT * FROM users WHERE username=? AND password=?";
			$stmt =$pdo->prepare($sql);
			$stmt->execute([$username,$password]);
			if ($stmt->rowCount()==1) {
				// log user in
				$_SESSION['username'] = $username;
				header('location:home.php');
			}else{
				echo "wrong username and password combination";
								
			}
	}

	

 ?>
 