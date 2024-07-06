<?php
session_start();
include ('includes/config.php');
include ('includes/checklogin.php');
check_login();
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
    <title>edit notice</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit-notice.css">
</head>
<body>
    <?php include ("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include ("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:4%">Edit Notices</h2>
                        <?php
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
                    
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                        
                            $sql = "SELECT * FROM notices WHERE id=$id";
                            $result = $mysqli->query($sql);
                        
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">Update notice</div>
                                    <div class="panel-body">
                                        <form action="edit-notice.php" method="post">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <div class="form-group">
                                                <label for="title">Title:</label>
                                                <input type="text" id="title" name="title" value="<?php echo $row['title']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="content">Content:</label>
                                                <textarea id="content" name="content" required style="text-align: center"><?php echo $row['content']; ?></textarea>
                                            </div>
                                            <button type="submit" name="submit" class="align-right">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            } else {
                                echo "No notice found";
                            }
                        }
                    
                        if (isset($_POST['submit'])) {
                            $id = $_POST['id'];
                            $title = $_POST['title'];
                            $content = $_POST['content'];
                        
                            $sql = "UPDATE notices SET title='$title', content='$content' WHERE id=$id";
                        
                            if ($mysqli->query($sql) === TRUE) {
                                echo "Notice updated successfully";
                            } else {
                                echo "Error: " . $sql . "<br>" . $mysqli->error;
                            }
                        }
                    
                        $mysqli->close();
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
