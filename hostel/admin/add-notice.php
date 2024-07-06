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

    <title>add notice</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/add-notice.css">
</head>

<body>
    <?php include ("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include ("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:4%">Add Notice</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">create notice</div>
                            <div class="panel-body">
                                <form action="add-notice.php" method="post">
                                    <div class="form-group">
                                        <label for="title">Title:</label>
                                        <input type="text" id="title" class="form-control" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content:</label>
                                        <textarea id="content" name="content" required></textarea>
                                    </div>
                                    <button class="align-right" type="submit" name="submit">Add Notice</button>
                                </form>
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['submit'])) {
                            $title = $_POST['title'];
                            $content = $_POST['content'];
                        
                            // Database connection
                            $dbuser = "root";
                            $dbpass = "";
                            $host = "localhost";
                            $db = "hostel";
                            $mysqli = new mysqli($host, $dbuser, $dbpass, $db);
                        
                            // Check connection
                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error);
                            }
                        
                            $sql = "INSERT INTO notices (title, content) VALUES ('$title', '$content')";
                        
                            if ($mysqli->query($sql) === TRUE) {
                                echo "<div style=\"text-align:center\">New notice added successfully</div>";
                            } else {
                                echo "Error: " . $sql . "<br>" . $mysqli->error;
                            }
                        
                            $mysqli->close();
                        }
                        ?>

                        
                        

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
