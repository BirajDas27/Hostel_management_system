<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_POST['update'])){
    $id = intval($_GET['id']);
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $contactno = $_POST['contactno'];
    $roomno = $_POST['roomno'];
    $seater = $_POST['seater'];
    $stayfrom = $_POST['stayfrom'];

    $query = "UPDATE registration SET firstName=?, middleName=?, lastName=?, contactno=?, roomno=?, seater=?, stayfrom=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssssi', $firstName, $middleName, $lastName, $contactno, $roomno, $seater, $stayfrom, $id);
    $stmt->execute();
    echo "<script>alert('Student details updated successfully');</script>";
}

$id = intval($_GET['id']);
$query = "SELECT * FROM registration WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
    <title>Edit Student Profile</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit-student.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php include('includes/sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Edit Student Profile</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #325d88;color: white">Student Details</div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="firstName">First Name:</label>
                                        
                                        <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($row->firstName); ?>" required>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="middleName">Middle Name:</label>
                                        
                                        <input type="text" class="form-control" name="middleName" value="<?php echo htmlspecialchars($row->middleName); ?>">
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName">Last Name:</label>
                                        
                                        <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($row->lastName); ?>" required>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="contactno">Contact Number:</label>
                                        
                                        <input type="text" class="form-control" name="contactno" value="<?php echo htmlspecialchars($row->contactno); ?>" required>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="roomno">Room Number:</label>
                                        
                                        <input type="text" class="form-control" name="roomno" value="<?php echo htmlspecialchars($row->roomno); ?>" required>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="seater">Seater:</label>
                                        
                                        <input type="text" class="form-control" name="seater" value="<?php echo htmlspecialchars($row->seater); ?>" required>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="stayfrom">Staying From:</label>
                                        
                                        <input type="date" class="form-control" name="stayfrom" value="<?php echo htmlspecialchars($row->stayfrom); ?>" required style="width: 94%">
                                        
                                    </div>
                                    
                                    <button type="submit" name="update" class="align-right">Update</button>
                                    
                                </form>
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
</html>
