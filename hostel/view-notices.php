<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notice Board</title>
    <link rel="stylesheet" href="path_to_your_stylesheet.css">
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
        }
        .notice {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .notice-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        .notice-content {
            margin-top: 10px;
        }
        .back-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Notice Board</h2>
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
                echo "<div class='notice-header'><span>" . $row['title'] . "</span><span>" . $row['created_at'] . "</span></div>";
                echo "<div class='notice-content'>" . $row['content'] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No notices found</p>";
        }

        $mysqli->close();
        ?>
        <a href="dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
</body>
</html>
