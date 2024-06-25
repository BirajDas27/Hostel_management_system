<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
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
    <title>Notice Board</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/view-notice.css">
    
</head>
<body>
<?php include("includes/header.php");?>

    <div class="ts-main-content">
        <?php include("includes/sidebar.php");?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row" >
                    <div class="col-md-12">

                        <h2 class="page-title" style="margin-top:4%">Notice Board</h2>
                        <div class="notice-container">
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
                        
                            // Fetch notices in descending order by created_at
                            $sql = "SELECT title, content, created_at FROM notices ORDER BY created_at DESC";
                            $result = $mysqli->query($sql);
                        
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<div class='notice'>";
                                    echo "<div class='notice-header'><div class='title'><span>" . $row['title'] . "</span></div><div class='time'><span>" . $row['created_at'] . "</span></div></div>";
                                    echo "<div class='notice-content'>" . $row['content'] . "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>No notices found</p>";
                            }
                        
                            $mysqli->close();
                            ?>
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
        
    window.onload = function(){
    
        // Line chart from swirlData for dashReport
        var ctx = document.getElementById("dashReport").getContext("2d");
        window.myLine = new Chart(ctx).Line(swirlData, {
            responsive: true,
            scaleShowVerticalLines: false,
            scaleBeginAtZero : true,
            multiTooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
        }); 
        
        // Pie Chart from doughutData
        var doctx = document.getElementById("chart-area3").getContext("2d");
        window.myDoughnut = new Chart(doctx).Pie(doughnutData, {responsive : true});

        // Dougnut Chart from doughnutData
        var doctx = document.getElementById("chart-area4").getContext("2d");
        window.myDoughnut = new Chart(doctx).Doughnut(doughnutData, {responsive : true});

    }
    </script>

</body>

</html>
