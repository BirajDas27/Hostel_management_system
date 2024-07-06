<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$message = ''; // Initialize message variable

if (isset($_POST['present'])) {
    $user_id = $_SESSION['id'];
    $date = date('Y-m-d');
    $status = 'Present'; // Fixed to 'Present' status

    // Check if attendance already exists for the user on the current date
    $query_check = "SELECT id FROM attendance WHERE user_id = ? AND date = ?";
    $stmt_check = $mysqli->prepare($query_check);
    $stmt_check->bind_param('is', $user_id, $date);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $message = "Attendance for today has already been marked";
    } else {
        // Insert attendance record
        $query_insert = "INSERT INTO attendance (user_id, date, status) VALUES (?, ?, ?)";
        $stmt_insert = $mysqli->prepare($query_insert);
        $stmt_insert->bind_param('iss', $user_id, $date, $status);
        $stmt_insert->execute();
        $stmt_insert->close();

        $message = "Attendance marked successfully";
    }

    $stmt_check->close();
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
    <title>Mark Attendance</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
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
                        <h2 class="page-title">Mark Attendance</h2>

                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">Attendance Form</div>
                            <div class="panel-body">
                                <form method="post" class="form-horizontal">
                                    <div class="form-group">
                                        <label>Date:</label>
                                        
                                        <input type="text" id="currentDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" disabled>
                                        
                                    </div>

                                    
                                    <button class="align-right" type="submit" name="present">Present</button>
                                    

                                    <?php if (!empty($message)) : ?>
                                        
                                            <div class="alert alert-info"><?php echo $message; ?></div>
                                        
                                    <?php endif; ?>
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

    <script>
        // Function to update the date dynamically
        function updateDate() {
            var currentDateInput = document.getElementById('currentDate');
            var currentDate = new Date().toISOString().slice(0, 10); // Get current date in YYYY-MM-DD format
            currentDateInput.value = currentDate;
        }

        // Update the date initially and every minute (for example)
        updateDate();
        setInterval(updateDate, 60000); // Update every minute (60000 milliseconds)
    </script>

</body>

</html>
