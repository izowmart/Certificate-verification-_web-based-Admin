 <?php 
 include ("home_backend.php"); 
 
	 // if user is not logged in, they cannot access this page
 	if (empty($_SESSION['username'])) {
 		header('location:login.html');
 		}

 	if (isset($_GET['edit'])) {
 			$id = $_GET['edit'];
 			$edit_state = true;
 			$update = true;
	 		$sql = "SELECT * FROM certificates WHERE id = ?";
			$stmt =$pdo->prepare($sql);
			$stmt->execute([$id]);
	 		$record = $stmt->fetch(PDO::FETCH_ASSOC);
	 		$name = $record['name'];
	 		$institution = $record['institution'];
	 		$reg_number = $record['reg_number'];
	 		$grade = $record['grade'];
	 		$date = $record['date'];
	 		$id = $record['id'];
 		}
 ?> 

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Main Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="style.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
 function generate_qrcode(sample){
 $.ajax({
 		type: 'post',
 		url: 'qr_generation.php',
 		data : {sample:sample},
 		success: function(code){
 			$('#result').html(code);
 		}
 	});
 }
</script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="#" class="navbar-brand">Certificate Verification</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-collase">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#reports">Reports</a></li>
					<li><a href="#feedback">Feedback</a></li>
					<li><a href="logout.php?logout='1'">Sign out <span class="glyphicon glyphicon-log-out"></span></a></li>
				</ul>
			</div>			
		</div>
	</nav>
	<!-- jumbotron -->
	<div class="jumbotron">
		<div class="container text-center">
			<h2>Admin. welcome <small> <?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];} ?></small></h2>	
			<p>Make a selection to perform an operation using the buttons below</p>
			<div class="btn-group">
				<a href="#certs" class="btn btn-lg btn-success">Certificates</a>
				<a href="#reports" class="btn btn-lg btn-default">Reports</a>
				<a href="#new_certs" class="btn btn-lg btn-success">New certificate</a>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="page-header" id="new_certs">
					<h2>New Certificates <small>You can also edit certificates</small></h2>			
				</div>
				<div class="panel panel-success">
					<div class="panel-heading">Enter Certificate Details</div>
					<div class="panel-body">
						<form action="home_backend.php" method="POST" class="form-group">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<table class="table table-hover">
								<tr>
									<td>Name</td>
									<td><input type="text" class="form-control" value="<?php echo $name; ?>" name="name" placeholder="Enter student name"></td>
								</tr>
								<tr>
									<td>Institution</td>
									<td><input type="text" class="form-control" value="<?php echo $institution; ?>" name="institution" placeholder="Enter student Institution"></td>
								</tr>
								<tr>
									<td>Reg_number</td>
									<td><input type="text" class="form-control" value="<?php echo $reg_number; ?>" name="reg_number" placeholder="Enter student Reg_number"></td>
								</tr>
								<tr>
									<td>Grade</td>
									<td><input type="text" class="form-control" value="<?php echo $grade; ?>" name="grade" placeholder="Enter student Grade"></td>
								</tr>
								<tr>
									<td>Date</td>
									<td><input type="text" class="form-control" name="date" placeholder="Enter issueing Date" value="<?php echo $date; ?>"></td>
								</tr>
								<tr>
									<td>
										<?php if ($edit_state == true): ?>
											<button type="submit" class="btn btn-success btn-block" name="update">Update</button>
											
										<?php else: ?>
											<button type="submit" class="btn btn-success btn-block" name="save">Store</button>
										<?php endif ?>	
									</td>
									
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="page-header" id="qrcode">
					<h2>QRcode Generation <small>Generate certificates qrcode</small></h2>			
				</div>
				<form class="form-inline" method="POST" action="home.php">
					<div class="form-group">
						<label for "id">Enter a genuine id</label>
						<input type="number" onkeyup="generate_qrcode(this.value)"class="form-control">
					</div>
				</form>
					
				<div id="result"></div>
			</div>
		</div>
	</div>
	<div class="container" id="accordion">
		<div class="container">
			<div class="page-header" id="certs">
				<h2><a href="#collapse_1" data-toggle="collapse" data-parent="#arcodion">Certificates <small>Students certificates generated from the database</small></a></h2>	

			</div>
			<div class="row" id="collapse_1">			
					<table class="table table-bordered">
						<tr>
							<th>Id</th>
							<th>Name</th>
							<th>Institution</th>
							<th>Reg-number</th>
							<th>Grade</th>
							<th>Date</th>
							<th>&nbsp;</th>
						</tr>
						
						<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
								
							<tr>		
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['institution']; ?></td>
								<td><?php echo $row['reg_number']; ?></td>
								<td><?php echo $row['grade']; ?></td>
								<td><?php echo $row['tdate']; ?></td>
								<td><a href="home.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a></td>
							</tr>
						<?php } ?>	
						
					</table>
			</div>
		</div>
		<?php include ("report.php");  ?>
		<div class="container" >
			<div class="page-header" id="reports">
				<h2><a href="#collapse-2" data-toggle="collapse" data-parent="#arcodion">Reports <small>Sent reports generated from the database</small></a></h2>
							
			</div>
			<div class="row" id="collapse_2">			
					<table class="table table-bordered">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Description</th>
							<th>Premises</th>
							<th>Radiogroup</th>
							<th>Image url</th>
						</tr>
						
						<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
								
							<tr>		
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['name']; ?></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['descr']; ?></td>
								<td><?php echo $row['place']; ?></td>
								<td><?php echo $row['radiogroup']; ?></td>
								<td><?php echo $row['image']; ?></td>
							</tr>
						<?php } ?>		
					</table>
			</div>
		</div>
	</div>

	<footer>
		<div class="container text-center">
			<div class="page-header" id="feedback">
				<h2>Feedbacks <small>Send feedback to users regarding the updates</small></h2>			
			</div>
			<form action="home_backend.php" method="POST" class="form-horizontal">
				<div class="form-group">
					<label for="name" class="col-lg-2 control-label">Name</label>
					<div class="col-lg-8">
						<input type="text" name="name" class="form-control" placeholder="Enter client's Name">
					</div>
				</div>
				<div class="form-group">
					<label for="email" class="col-lg-2 control-label">Email</label>
					<div class="col-lg-8">
						<input type="email" name="email" class="form-control" placeholder="Enter client's Email">
					</div>
				</div>
				<div class="form-group">
					<label for="Message" class="col-lg-2 control-label">Feedback</label>
					<div class="col-lg-8">
						<textarea name="feedback" class="form-control" cols="20" rows="4" placeholder=
						"Enter your message"></textarea>	
					</div>
				</div>
				<div class="form-group">
						<div class="col-lg-5">
							<button type="submit" name="feedback_submit" class="btn btn-primary">Submit</button>
						</div>
					</div>
			</form>
		</div>	
	</footer>
</body>

</html>

