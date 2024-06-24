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

    $sql = "DELETE FROM notices WHERE id=$id";

    if ($mysqli->query($sql) === TRUE) {
        echo "Notice deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

$mysqli->close();
header("Location: manage-notices.php");
exit();
?>
