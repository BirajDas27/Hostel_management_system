<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $employee_type = $_POST['employee_type'];
    $designation = $_POST['designation'];
    $join_date = $_POST['join_date'];
    $salary = $_POST['salary'];
    $block_number = $_POST['block_number'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $pin = $_POST['pin'];

    // File upload handling
    $photo_path = 'default.jpg'; // Default photo path
    if ($_FILES['photo']['error'] === 0) {
        $photo_name = $_FILES['photo']['name'];
        $photo_tmp = $_FILES['photo']['tmp_name'];
        $photo_path = 'uploads/' . $photo_name;

        if (move_uploaded_file($photo_tmp, $photo_path)) {
            echo "File uploaded successfully";
        } else {
            echo "Error moving file";
            error_log("Error moving uploaded file: " . $photo_name, 0);
        }
    } else {
        echo "File upload error: " . $_FILES['photo']['error'];
        error_log("File upload error: " . $_FILES['photo']['error'], 0);
    }

    // Insert into database
    $sql = "INSERT INTO employees (name, gender, employee_type, designation, join_date, salary, block_number, address, email, phone_no, pin, photo_path) 
            VALUES ('$name', '$gender', '$employee_type', '$designation', '$join_date', '$salary', '$block_number', '$address', '$email', '$phone_no', '$pin', '$photo_path')";

    if ($mysqli->query($sql) === TRUE) {
        echo "New employee added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
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

    <title>add-employee</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/add-emp.css">
</head>
<body>
    <?php include ("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include ("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:4%">Add Employee</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">fill all information</div>
                            <div class="panel-body">
                                <form action="add-employee.php" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name:</label>
                                        <div class="col-sm-8">    
                                            <input type="text" id="name" name="name" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Gender:</label>
                                        <div class="col-sm-8">
                                            <select id="gender" name="gender" class="form-control" required>
                                                <option value="">Select Gender</option>
			                                    <option value="male">Male</option>
			                                    <option value="female">Female</option>
			                                    <option value="others">Others</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Employee Type:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="employee_type" name="employee_type" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Designation:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="designation" name="designation" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Join Date:</label>
                                        <div class="col-sm-8">
                                            <input type="date" id="join_date" name="join_date" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Salary:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="salary" name="salary" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Block Number:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="block_number" name="block_number" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Address:</label>
                                        <div class="col-sm-8">
                                            <textarea id="address" name="address" rows="4" class="form-control" style="width: 100%" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email:</label>
                                        <div class="col-sm-8">
                                            <input type="email" id="email" name="email" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Phone Number:</label>
                                        <div class="col-sm-8">
                                            <input type="tel" id="phone_no" name="phone_no" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">PIN:</label>
                                        <div class="col-sm-8">
                                            <input type="text" id="pin" name="pin" class="form-control" style="width: 100%" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Photo:</label>
                                        
                                        <input type="file" id="photo" name="photo" required>
                                        
                                    </div>
                                    <button class="align-right" type="submit" name="submit">Add Employee</button>
                                </form>
                            </div>
                        </div>

                        
                        

                        

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
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
