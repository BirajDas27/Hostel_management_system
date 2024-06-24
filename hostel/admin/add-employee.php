<?php
include('includes/config.php');

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

    <title>Dashboard</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
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
                        <form action="add-employee.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select id="gender" name="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="employee_type">Employee Type:</label>
                                <input type="text" id="employee_type" name="employee_type" required>
                            </div>
                            <div class="form-group">
                                <label for="designation">Designation:</label>
                                <input type="text" id="designation" name="designation" required>
                            </div>
                            <div class="form-group">
                                <label for="join_date">Join Date:</label>
                                <input type="date" id="join_date" name="join_date" required>
                            </div>
                            <div class="form-group">
                                <label for="salary">Salary:</label>
                                <input type="text" id="salary" name="salary" required>
                            </div>
                            <div class="form-group">
                                <label for="block_number">Block Number:</label>
                                <input type="text" id="block_number" name="block_number" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address:</label>
                                <textarea id="address" name="address" rows="4" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="phone_no">Phone Number:</label>
                                <input type="tel" id="phone_no" name="phone_no" required>
                            </div>
                            <div class="form-group">
                                <label for="pin">PIN:</label>
                                <input type="text" id="pin" name="pin" required>
                            </div>
                            <div class="form-group">
                                <label for="photo">Photo:</label>
                                <input type="file" id="photo" name="photo">
                            </div>
                            <button type="submit" name="submit">Add Employee</button>
                        </form>

                        
                        

                        

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
