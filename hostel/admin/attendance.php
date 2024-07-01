<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Default date selection (or use current date as default)
$selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : date('Y-m-d');

// Handle date change and mark absent for missing attendance
if (isset($_POST['selected_date'])) {
    $prev_date = date('Y-m-d', strtotime('-1 day', strtotime($_POST['selected_date'])));
    
    // Fetch all students from registration table
    $registrationQuery = "SELECT id FROM registration";
    $registrationResult = mysqli_query($mysqli, $registrationQuery);

    if ($registrationResult) {
        while ($row = mysqli_fetch_assoc($registrationResult)) {
            $user_id = $row['id'];

            // Check if attendance already exists for the selected date
            $checkQuery = "SELECT id FROM attendance WHERE user_id = $user_id AND date = '$selected_date'";
            $checkResult = mysqli_query($mysqli, $checkQuery);

            if (mysqli_num_rows($checkResult) == 0) {
                // If no attendance record exists, insert as absent
                $insertQuery = "INSERT INTO attendance (user_id, date, status) VALUES ($user_id, '$selected_date', 'Absent')";
                mysqli_query($mysqli, $insertQuery);
            }
        }
    }
}

// Fetch attendance and registration data for the selected date
$current_date = date('Y-m-d');

if ($selected_date > $current_date) {
    $result = false; // No records for future dates
} else {
    $fetchQuery = "SELECT a.id as attendance_id, r.roomno, r.course, u.firstName, u.middleName, u.lastName, u.regNo, a.date, COALESCE(a.status, 'Absent') as status 
                  FROM registration r
                  LEFT JOIN userregistration u ON r.regno = u.regno
                  LEFT JOIN attendance a ON u.id = a.user_id AND a.date = '$selected_date'
                  ORDER BY r.id ASC";

    $result = mysqli_query($mysqli, $fetchQuery);

    if (!$result) {
        die('Invalid query: ' . mysqli_error($mysqli));
    }
}
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

    <title>Attendance Management</title>
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
    <?php include("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Attendance Management</h2>

                        <!-- Date Selection -->
                        <form method="post" class="form-inline custom-inline-form" style="margin-bottom: 15px">
                            <div class="form-group">
                                <label for="selected_date">Select Date:</label>
                                <input type="date" class="form-control" id="selected_date" name="selected_date" value="<?php echo $selected_date; ?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Go</button>
                        </form>

                        <!-- Attendance Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: #325d88;color:white">Attendance Details</div>
                            <div class="panel-body">
                                <?php if ($selected_date > $current_date): ?>
                                    <p>No attendance records available for future dates.</p>
                                <?php else: ?>
                                    <table id="attendanceTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Registration Number</th>
                                                <th>Room Number</th>
                                                <th>Course</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['regNo']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['roomno']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='5'>No attendance records found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
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


    <script>
        $(document).ready(function () {
            $('#attendanceTable').DataTable({
                "order": [[4, "asc"]],
                "paging": true,
                "lengthMenu": [10, 25, 50, 75, 100],
                "searching": false,
                "info": true
            });
        });
    </script>

</body>

</html>

<?php
mysqli_close($mysqli);
?>
