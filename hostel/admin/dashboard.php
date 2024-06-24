<?php
session_start();
include ('includes/config.php');
include ('includes/checklogin.php');
check_login();
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
                        <h2 class="page-title" style="margin-top:4%">Dashboard</h2>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-primary text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Query to get total students
                                            $result = $mysqli->query("SELECT count(*) FROM registration");
                                            $count = $result->fetch_row()[0];
                                            ?>
                                            <div class="stat-panel-number h1 "><?php echo $count; ?></div>
                                            <div class="stat-panel-title text-uppercase">Students</div>
                                        </div>
                                    </div>
                                    <a href="manage-students.php" class="block-anchor panel-footer text-center">Full Detail
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-success text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Query to get total rooms
                                            $result = $mysqli->query("SELECT count(*) FROM rooms");
                                            $count = $result->fetch_row()[0];
                                            ?>
                                            <div class="stat-panel-number h1 "><?php echo $count; ?></div>
                                            <div class="stat-panel-title text-uppercase">Total Rooms</div>
                                        </div>
                                    </div>
                                    <a href="manage-rooms.php" class="block-anchor panel-footer text-center">See All &nbsp;
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-info text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Query to get total courses
                                            $result = $mysqli->query("SELECT count(*) FROM courses");
                                            $count = $result->fetch_row()[0];
                                            ?>
                                            <div class="stat-panel-number h1 "><?php echo $count; ?></div>
                                            <div class="stat-panel-title text-uppercase">Total Courses</div>
                                        </div>
                                    </div>
                                    <a href="manage-courses.php" class="block-anchor panel-footer text-center">See All &nbsp;
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-default">
                                    <div class="panel-body bk-warning text-light">
                                        <div class="stat-panel text-center">
                                            <?php
                                            // Query to get total attendance records
                                            $result = $mysqli->query("SELECT count(*) FROM attendance");
                                            $count = $result->fetch_row()[0];
                                            ?>
                                            <div class="stat-panel-number h1 "><?php echo $count; ?></div>
                                            <div class="stat-panel-title text-uppercase">Total Attendance Records</div>
                                        </div>
                                    </div>
                                    <a href="attendance.php" class="block-anchor panel-footer text-center">Manage Attendance &nbsp;
                                        <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Latest Notices Panel -->
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Latest Notices</div>
                                    <div class="panel-body-notice">
                                        <ul class="list-group">
                                            <?php
                                            $noticeQuery = "SELECT title, content, created_at FROM notices ORDER BY created_at DESC LIMIT 5";
                                            $noticeResult = $mysqli->query($noticeQuery);

                                            if ($noticeResult->num_rows > 0) {
                                                while ($notice = $noticeResult->fetch_assoc()) {
                                                    echo '<li class="list-group-item">';
                                                    echo '<h5 class="list-group-item-heading">' . htmlspecialchars($notice['title']) . ' <small>' . htmlspecialchars($notice['created_at']) . '</small></h5>';
                                                    echo '<p class="list-group-item-text">' . htmlspecialchars($notice['content']) . '</p>';
                                                    echo '</li>';
                                                }
                                            } else {
                                                echo '<li class="list-group-item">No notices found.</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <a href="manage-notices.php" class="block-anchor panel-footer">View All Notices <i class="fa fa-arrow-right"></i></a>
                                </div>
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

<?php
mysqli_close($mysqli);
?>
