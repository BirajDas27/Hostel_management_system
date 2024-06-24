<?php
include('includes/config.php');

// Handle salary addition form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $employee_id = $_POST['employee_id'];
    $bonus_salary = $_POST['bonus_salary'];

    $sql = "INSERT INTO salaries (employee_id, bonus_salary) VALUES ('$employee_id', '$bonus_salary')";

    if ($mysqli->query($sql) === TRUE) {
        echo "Salary added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

// Handle search form submission
$employee_details = null;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
    $search_criteria = $_POST['search_criteria'];

    $sql = "SELECT * FROM employees WHERE $search_criteria LIKE '%$search_term%'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $employee_details = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "No employees found matching '$search_term'";
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

    <title>Add Salary</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }
        .employee-details {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .employee-details img {
            margin-right: 10px;
            max-width: 100px;
            max-height: 100px;
        }
    </style>
    <script>
        function confirmSalaryAddition() {
            return confirm("Are you sure you want to add this bonus?");
        }
    </script>
</head>
<body>
    <?php include ("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include ("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:4%">Search employee</h2>
                        <form action="add-bonus.php" method="post">
                            <div class="form-group">
                                <label for="search_criteria">Search Criteria:</label>
                                <select id="search_criteria" name="search_criteria">
                                    <option value="id">ID</option>
                                    <option value="name">Name</option>
                                    <option value="designation">Designation</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="search_term">Search Term:</label>
                                <input type="text" id="search_term" name="search_term" required>
                            </div>
                            <button type="submit" name="search">Search</button>
                        </form>

                        <?php if ($employee_details): ?>
                            <h2>Employee Details</h2>
                            <?php foreach ($employee_details as $employee): ?>
                                <div class="employee-details">
                                    <img src="<?php echo $employee['photo_path']; ?>" alt="Employee Photo">
                                    <div>
                                        <p><strong>ID:</strong> <?php echo $employee['id']; ?></p>
                                        <p><strong>Name:</strong> <?php echo $employee['name']; ?></p>
                                        <p><strong>Salary:</strong> <?php echo $employee['salary']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <h2 class="page-title" style="margin-top:4%">Add bonus</h2>

                        <form action="add-bonus.php" method="post" onsubmit="return confirmSalaryAddition();">
                            <div class="form-group">
                                <label for="employee_id">Employee ID:</label>
                                <input type="text" id="employee_id" name="employee_id" required value="<?php echo isset($employee['id']) ? $employee['id'] : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="bonus_salary">Bonus Salary:</label>
                                <input type="text" id="bonus_salary" name="bonus_salary" required>
                            </div>
                            <button type="submit" name="submit">Add bonus</button>
                        </form>

                        
                        

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
