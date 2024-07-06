<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Handle editing form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_employee'])) {
        $employee_id = $_POST['employee_id'];
        $name = $_POST['name'];
        $gender = $_POST['gender'];
        $employee_type = $_POST['employee_type'];
        $designation = $_POST['designation'];
        $join_date = $_POST['join_date'];
        $salary = $_POST['salary'];
        $block_number = $_POST['block_number'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone_no = $_POST['phone_no'];
        $pin = $_POST['pin'];

        $sql = "UPDATE employees SET 
                name = '$name',
                gender = '$gender',
                employee_type = '$employee_type',
                designation = '$designation',
                join_date = '$join_date',
                salary = '$salary',
                block_number = '$block_number',
                address = '$address',
                email = '$email',
                phone_no = '$phone_no',
                pin = '$pin'
                WHERE id = $employee_id";

        if ($mysqli->query($sql) === TRUE) {
            echo "Employee details updated successfully";
        } else {
            echo "Error updating employee details: " . $mysqli->error;
        }
    }

    // Handle delete form submission
    if (isset($_POST['delete_employee'])) {
        $employee_id = $_POST['employee_id'];

        // Delete related salary records first
        $sql_delete_salaries = "DELETE FROM salaries WHERE employee_id = $employee_id";

        if ($mysqli->query($sql_delete_salaries) === TRUE) {
            // Delete the employee record
            $sql_delete_employee = "DELETE FROM employees WHERE id = $employee_id";
            
            if ($mysqli->query($sql_delete_employee) === TRUE) {
                echo "Employee deleted successfully";
            } else {
                echo "Error deleting employee: " . $mysqli->error;
            }
        } else {
            echo "Error deleting related salaries: " . $mysqli->error;
        }
    }
}

// Fetch employees from database
$sql = "SELECT * FROM employees";
$result = $mysqli->query($sql);
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
    <title>List Employees</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/list-emp.css">
    <style>
        .edit-form {
            display: none;
        }
        .show-form {
            display: block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            cursor: pointer;
        }
        th.sort-asc::after {
            content: " ▲";
        }
        th.sort-desc::after {
            content: " ▼";
        }
    </style>
</head>
<body>
    <?php include ("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include ("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top:4%">View Employees</h2>
                        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names.." style="margin-bottom:20px">

                        <?php
                        // Display edit form if edit button is clicked
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit'])) {
                            $employee_id = $_POST['employee_id'];
                            $sql_edit = "SELECT * FROM employees WHERE id = $employee_id";
                            $result_edit = $mysqli->query($sql_edit);
                        
                            if ($result_edit->num_rows == 1) {
                                $row_edit = $result_edit->fetch_assoc();
                        ?>
                        <div class="edit-form show-form">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">Update employee information</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" action="list-employees.php" method="post" onsubmit="return confirm('Do you want to update the employee details? (Y/N)');">
                                        <input type="hidden" name="employee_id" value="<?php echo $row_edit['id']; ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Name:</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="name" name="name" value="<?php echo $row_edit['name']; ?>" class="form-control" style="width: 100%" required></div>
                                            </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Gender:</label>
                                            <div class="col-sm-8">
                                                <select id="gender" name="gender" class="form-control" style="width: 100%" required>
                                                    <option value="Male" <?php if ($row_edit['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                                    <option value="Female" <?php if ($row_edit['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                                    <option value="Other" <?php if ($row_edit['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                                                </select></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Employee Type:</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="employee_type" name="employee_type" value="<?php echo $row_edit['employee_type']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Designation:</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="designation" name="designation" value="<?php echo $row_edit['designation']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Join Date:</label>
                                            <div class="col-sm-8">
                                            <input type="date" id="join_date" name="join_date" value="<?php echo $row_edit['join_date']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Salary:</label>
                                            <div class="col-sm-8">
                                            <input type="text" id="salary" name="salary" value="<?php echo $row_edit['salary']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">   
                                            <label class="col-sm-2 control-label">Block Number:</label>
                                            <div class="col-sm-8">
                                            <input type="text" id="block_number" name="block_number" value="<?php echo $row_edit['block_number']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Address:</label>
                                            <div class="col-sm-8">
                                            <textarea id="address" name="address" rows="4" required class="form-control" style="width: 100%"><?php echo $row_edit['address']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Email:</label>
                                            <div class="col-sm-8">
                                            <input type="email" id="email" name="email" value="<?php echo $row_edit['email']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">   
                                            <label class="col-sm-2 control-label">Phone Number:</label>
                                            <div class="col-sm-8">
                                            <input type="text" id="phone_no" name="phone_no" value="<?php echo $row_edit['phone_no']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <label class="col-sm-2 control-label">PIN:</label>
                                            <div class="col-sm-8">
                                            <input type="text" id="pin" name="pin" value="<?php echo $row_edit['pin']; ?>" class="form-control" style="width: 100%" required>
                                            </div>
                                        </div>
                                        <div class="btns">
                                            <button type="button" onclick="goBack()">Back</button>
                                            <button type="submit" name="edit_employee">Update</button>
                            </div>
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>
                            function goBack() {
                                if (confirm('Do you want to go back without saving changes? (Y/N)')) {
                                    window.location.href = 'list-employees.php';
                                }
                            }
                        </script>
                        <?php
                            }
                        } else {
                        ?>
                        <div class="employee-list show-form">
                            <table id="employeeTable">
                                <thead style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">
                                    <tr>
                                        <th onclick="sortTable(0)">ID</th>
                                        <th>Photo</th>
                                        <th onclick="sortTable(1)">Name</th>
                                        <th onclick="sortTable(2)">Gender</th>
                                        <th onclick="sortTable(3)">Employee Type</th>
                                        <th onclick="sortTable(4)">Designation</th>
                                        <th onclick="sortTable(5)">Join Date</th>
                                        <th onclick="sortTable(6)">Salary</th>
                                        <th onclick="sortTable(7)">Block Number</th>
                                        <th onclick="sortTable(8)">Address</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th onclick="sortTable(11)">PIN</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $row["id"] . "</td>";
                                            echo "<td><img src='" . $row["photo_path"] . "' height='50' width='55'></td>";
                                            echo "<td>" . $row["name"] . "</td>";
                                            echo "<td>" . $row["gender"] . "</td>";
                                            echo "<td>" . $row["employee_type"] . "</td>";
                                            echo "<td>" . $row["designation"] . "</td>";
                                            echo "<td>" . $row["join_date"] . "</td>";
                                            echo "<td>" . $row["salary"] . "</td>";
                                            echo "<td>" . $row["block_number"] . "</td>";
                                            echo "<td>" . $row["address"] . "</td>";
                                            echo "<td>" . $row["email"] . "</td>";
                                            echo "<td>" . $row["phone_no"] . "</td>";
                                            echo "<td>" . $row["pin"] . "</td>";
                                            echo "<td style='display: flex'>
                                                <form action='list-employees.php' method='post' style=\"margin-left:0px;padding:0px\">
                                                    <input type='hidden' name='employee_id' value='" . $row["id"] . "'>
                                                    <div class='edit-button'>
                                                        <button class='action-button' type='submit' name='edit' style='margin: 5px 0px;border-bottom-right-radius:0px;border-top-right-radius: 0px'>Edit</button>
                                                    </div>
                                                </form>
                                                <form action='list-employees.php' method='post' onsubmit='return confirm(\"Are you sure you want to delete this employee?\");' style=\"margin-left:0px;padding:0px\">
                                                    <input type='hidden' name='employee_id' value='" . $row["id"] . "'>
                                                    <div class='delete-button'>
                                                        <button class='action-button' type='submit' name='delete_employee' style='margin: 5px 0px;border-bottom-left-radius:0px;border-top-left-radius: 0px'>Del</button>
                                                    </div>
                                                </form>
                                              </td>";
                                        echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='13'>No employees found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
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
    <script>
        function sortTable(n) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementById("employeeTable");
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }

        function searchTable() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toLowerCase();
            table = document.getElementById("employeeTable");
            tr = table.getElementsByTagName("tr");
            for (i = 1; i < tr.length; i++) {
                tr[i].style.display = "none";
                td = tr[i].getElementsByTagName("td");
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                            break;
                        }
                    }
                }
            }
        }
    </script>

</body>
</html>

