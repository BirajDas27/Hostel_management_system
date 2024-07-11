<?php
session_start();
include('includes/config.php');
if (isset($_POST['submit'])) {
	$fname = $_POST['fname'];
	$mname = $_POST['mname'];
	$lname = $_POST['lname'];
	$gender = $_POST['gender'];
	$contactno = $_POST['contact'];
	$emailid = $_POST['email'];
	$password = $_POST['password'];
	$course = $_POST['course'];
	$query = "insert into  userRegistration(firstName,middleName,lastName,gender,contactNo,email,password,course) values(?,?,?,?,?,?,?,?)";
	$stmt = $mysqli->prepare($query);
	$rc = $stmt->bind_param('ssssisss', $fname, $mname, $lname, $gender, $contactno, $emailid, $password, $course);
	$stmt->execute();
	echo "<script>alert('Student Succssfully register');</script>";
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	<title>User Registration</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/registration.css">
	<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
	<script type="text/javascript" src="js/validation.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript">
		function valid() {
			if (document.registration.password.value != document.registration.cpassword.value) {
				alert("Password and Re-Type Password Field do not match  !!");
				document.registration.cpassword.focus();
				return false;
			}
			return true;
		}
	</script>
</head>

<body>
	<div class="container-fluid">

		<div class="row">
			<div class="col-md-12">

				<h2 class="page-title">User Registration </h2>

				<div class="row">
					<div class="col-md-12">
						<div class="content">
							<div class="panel panel-primary">
								<div class="panel-heading">Fill all Information</div>
								<div class="panel-body">
									<form method="post" action="" name="registration" class="form-horizontal" onSubmit="return valid();">


										<div class="ref">
											<a href="./index.php">Login?</a>
										</div>



										<div class="form-group">
											<label class="col-sm-3 control-label">First Name:</label>
											<div class="col-sm-8">
												<input type="text" name="fname" id="fname" class="form-control" required="required">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Middle Name:</label>
											<div class="col-sm-8">
												<input type="text" name="mname" id="mname" class="form-control">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Last Name:</label>
											<div class="col-sm-8">
												<input type="text" name="lname" id="lname" class="form-control" required="required">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Gender:</label>
											<div class="col-sm-8">
												<select name="gender" class="form-control" required="required">
													<option value="">Select Gender</option>
													<option value="male">Male</option>
													<option value="female">Female</option>
													<option value="others">Others</option>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Contact No:</label>
											<div class="col-sm-8">
												<input type="text" name="contact" id="contact" class="form-control" required="required">
											</div>
										</div>


										<div class="form-group">
											<label class="col-sm-3 control-label">Email id:</label>
											<div class="col-sm-8">
												<input type="email" name="email" id="email" class="form-control" onBlur="checkAvailability()" required="required">
												<span id="user-availability-status" style="font-size:12px;"></span>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Password:</label>
											<div class="col-sm-8">
												<input type="password" name="password" id="password" class="form-control" required="required">
											</div>
										</div>


										<div class="form-group">
											<label class="col-sm-3 control-label">Confirm Password:</label>
											<div class="col-sm-8">
												<input type="password" name="cpassword" id="cpassword" class="form-control" required="required">
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label">Course:</label>
											<div class="col-sm-8">
												<select name="course" id="course" class="form-control" required>
													<option value="">Select course</option>
													<?php $query = "SELECT * FROM courses";
													$stmt2 = $mysqli->prepare($query);
													$stmt2->execute();
													$res = $stmt2->get_result();
													while ($row = $res->fetch_object()) {
													?>
														<option value="<?php echo $row->course_fn; ?>"><?php echo $row->course_fn; ?>&nbsp;&nbsp;(<?php echo $row->course_sn; ?>)</option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-3 control-label"></label>
											<div class="col-sm-8">
												<button type="submit" name="submit" class="btn btn-primary" style="background-color:#0010ce;color: white;font-size: 16px;font-weight: bold;">Register</button>
											</div>
										</div>


										<div class="col-sm-8">


										</div>

									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
<script>
	function checkAvailability() {

		$("#loaderIcon").show();
		jQuery.ajax({
			url: "check_availability.php",
			data: 'emailid=' + $("#email").val(),
			type: "POST",
			success: function(data) {
				$("#user-availability-status").html(data);
				$("#loaderIcon").hide();
			},
			error: function() {
				event.preventDefault();
				alert('error');
			}
		});
	}
</script>

</html>