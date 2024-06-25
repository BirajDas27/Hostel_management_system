<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['id'];
    $date = date('Y-m-d');
    $status = $_POST['status'];

    // Check if attendance already exists for the user on the current date
    $query_check = "SELECT id FROM attendance WHERE user_id = ? AND date = ?";
    $stmt_check = $mysqli->prepare($query_check);
    $stmt_check->bind_param('is', $user_id, $date);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<script>alert('Attendance for today has already been marked');</script>";
    } else {
        // Insert attendance record
        $query_insert = "INSERT INTO attendance (user_id, date, status) VALUES (?, ?, ?)";
        $stmt_insert = $mysqli->prepare($query_insert);
        $stmt_insert->bind_param('iss', $user_id, $date, $status);
        $stmt_insert->execute();
        $stmt_insert->close();

        echo "<script>alert('Attendance marked successfully');</script>";
    }

    $stmt_check->close();
}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/update-profile.css">
    <link rel="stylesheet" href="css/attendance.css">
</head>

<body>
<?php include("includes/header.php");?>

    <div class="ts-main-content">
        <?php include("includes/sidebar.php");?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:4%">Mark Attendance</h2>
                        
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color:#325d88;color:white">Attendance Form</div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>
                                        <div class="col-sm-8">
                                            <select name="status" class="form-control">
                                                <option value="Present">Present</option>
                                                <option value="Absent" selected>Absent</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-8 col-sm-offset-9">
                                        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
                                    </div>
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
