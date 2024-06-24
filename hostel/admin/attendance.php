<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Function to update attendance status
if (isset($_POST['update_status'])) {
    $attendance_id = $_POST['attendance_id'];
    $status = $_POST['status'];

    $updateQuery = "UPDATE attendance SET status = '$status' WHERE id = $attendance_id";
    $updateResult = mysqli_query($mysqli, $updateQuery);

    if (!$updateResult) {
        die('Update query failed: ' . mysqli_error($mysqli));
    }
    // Redirect to self to avoid resubmission on refresh
    header("Location: attendance.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .update-form {
            display: none;
        }
    </style>
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

                        <!-- Attendance Table -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Attendance Details</div>
                            <div class="panel-body">
                                <table id="attendanceTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Registration Number</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $searchQuery = "SELECT a.id as attendance_id, u.firstName, u.middleName, u.lastName, u.regNo, a.date, a.status 
                                                        FROM attendance a 
                                                        JOIN userregistration u ON a.user_id = u.id";

                                        if (isset($_POST['search'])) {
                                            $keyword = $_POST['keyword'];
                                            $searchQuery .= " WHERE 
                                                u.firstName LIKE '%$keyword%' OR 
                                                u.middleName LIKE '%$keyword%' OR 
                                                u.lastName LIKE '%$keyword%' OR 
                                                u.regNo LIKE '%$keyword%' OR 
                                                a.date LIKE '%$keyword%' OR 
                                                a.status LIKE '%$keyword%'";
                                        }

                                        $searchQuery .= " ORDER BY a.date DESC";
                                        $result = mysqli_query($mysqli, $searchQuery);

                                        if (!$result) {
                                            die('Invalid query: ' . mysqli_error($mysqli));
                                        }

                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<tr>";
                                                echo "<td>" . htmlspecialchars($row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['regNo']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                                echo '<td>';
                                                echo '<button class="btn btn-primary btn-sm toggle-update">Edit</button>';
                                                echo '<form class="update-form mt-1" style="display: none;" method="post" action="">';
                                                echo '<input type="hidden" name="attendance_id" value="' . $row['attendance_id'] . '">';
                                                echo '<select name="status" class="form-control">';
                                                echo '<option value="Present" ' . (($row['status'] == 'Present') ? 'selected' : '') . '>Present</option>';
                                                echo '<option value="Absent" ' . (($row['status'] == 'Absent') ? 'selected' : '') . '>Absent</option>';
                                                echo '</select>';
                                                echo '<button type="submit" name="update_status" class="btn btn-primary btn-sm mt-1">Update</button>';
                                                echo '</form>';
                                                echo '</td>';
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5'>No attendance records found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
                "order": [[2, "desc"]], // Order by date column descending initially
                "paging": true, // Enable paging
                "lengthMenu": [10, 25, 50, 75, 100], // Page length options
                "searching": true, // Enable searching
                "info": true // Enable table information display
            });

            // Toggle visibility of update form on edit button click
            $('.toggle-update').click(function () {
                $(this).closest('tr').find('.update-form').toggle();
            });
        });
    </script>

</body>

</html>

<?php
mysqli_close($mysqli);
?>
