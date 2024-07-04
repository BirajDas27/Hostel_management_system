<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Fetch all users for the dropdown
$user_query = "SELECT id, firstName FROM registration";
$user_result = $mysqli->query($user_query);

$user_id = '';
$fees_result = null;
$order_by = 'b.paid_date DESC'; // Default sorting order

// Handle sorting and user search
if (isset($_POST['search_student']) || isset($_POST['sort_option'])) {
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

    if (isset($_POST['sort_option'])) {
        $sort_option = $_POST['sort_option'];
        if ($sort_option == 'recent') {
            $order_by = 'b.paid_date DESC';
        } elseif ($sort_option == 'old') {
            $order_by = 'b.paid_date ASC';
        } elseif ($sort_option == 'amount_asc') {
            $order_by = 'b.amount ASC';
        } elseif ($sort_option == 'amount_desc') {
            $order_by = 'b.amount DESC';
        }
    }

    // Validate user_id
    if (!empty($user_id)) {
        $user_check_query = "SELECT id FROM registration WHERE id = ?";
        $user_check_stmt = $mysqli->prepare($user_check_query);
        $user_check_stmt->bind_param('i', $user_id);
        $user_check_stmt->execute();
        $user_check_result = $user_check_stmt->get_result();

        if ($user_check_result->num_rows > 0) {
            $query = "SELECT b.id, b.amount, b.status, b.paid_date, b.transaction_id, r.firstName 
                      FROM bills b 
                      JOIN registration r ON b.user_id = r.id 
                      WHERE b.user_id = ? 
                      ORDER BY $order_by";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $fees_result = $stmt->get_result();
        } else {
            echo "<script>alert('Invalid user ID!');</script>";
        }
    }
}

// Process marking a fee as paid
if (isset($_POST['mark_paid'])) {
    $bill_id = $_POST['bill_id'];

    // Update fee status to 'paid'
    $update = "UPDATE bills SET status = 'paid', paid_date = NOW() WHERE id = ?";
    $stmt = $mysqli->prepare($update);
    $stmt->bind_param('i', $bill_id);
    $stmt->execute();

    echo "<script>alert('Fee marked as paid successfully!');</script>";
    header('Location: billing_management.php'); // Redirect to refresh the page after marking fee as paid
    exit;
}

// Generate empty payment columns for all users
if (isset($_POST['generate_payments'])) {
    $users_query = "SELECT id FROM registration";
    $users_result = $mysqli->query($users_query);

    while ($user_row = $users_result->fetch_assoc()) {
        $user_id = $user_row['id'];
        $insert = "INSERT INTO bills (user_id, amount, status, transaction_id) VALUES (?, '', 'unpaid', '')";
        $stmt = $mysqli->prepare($insert);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
    }

    echo "<script>alert('Empty payment columns generated for all users!');</script>";
    header('Location: billing_management.php');
    exit;
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
    <title>Admin Fee Management</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bill.css">
</head>

<body>
    <?php include("includes/header.php"); ?>

    <div class="ts-main-content">
        <?php include("includes/sidebar.php"); ?>
        <div class="content-wrapper">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title">Fee Management</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color:#325D88;color: white">payment related</div>
                            <div class="panel-body">

                                <div class="flex-row">
                                    <!-- Generate Payments Button -->
                                    <form method="post" class="mb-4" style="display: flex;align-items: center;justify-content: center">
                                        <button type="submit" name="generate_payments" class="btn btn-warning">Generate Empty Payments for All Users</button>
                                    </form>

                                    <!-- Search Student Form -->
                                    <div class="flex-col">
                                        <h3 class="mb-3">Search Student</h3>
                                        <form method="post" class="mb-4">
                                            <div class="form-group">
                                                <label for="user_id">Student ID:</label>
                                                <select name="user_id" class="form-control" required>
                                                    <option value="">Select User</option>
                                                    <?php while ($user_row = $user_result->fetch_assoc()) { ?>
                                                        <option value="<?php echo $user_row['id']; ?>" <?php echo $user_id == $user_row['id'] ? 'selected' : ''; ?>><?php echo $user_row['firstName']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <button type="submit" name="search_student" class="btn btn-success">Search</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Sorting Dropdown -->
                                <div class="sort">
                                    <form method="post" class="mb-4">
                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                                        <div class="form-group">
                                            <label for="sort_option">Sort By:</label>
                                            <select name="sort_option" class="form-control" onchange="this.form.submit()">
                                                <option value="recent" <?php echo (isset($sort_option) && $sort_option == 'recent') ? 'selected' : ''; ?>>Recent Payments</option>
                                                <option value="old" <?php echo (isset($sort_option) && $sort_option == 'old') ? 'selected' : ''; ?>>Old Payments</option>
                                                <option value="amount_asc" <?php echo (isset($sort_option) && $sort_option == 'amount_asc') ? 'selected' : ''; ?>>Amount (Low to High)</option>
                                                <option value="amount_desc" <?php echo (isset($sort_option) && $sort_option == 'amount_desc') ? 'selected' : ''; ?>>Amount (High to Low)</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>

                                <!-- Display Fees for Selected User -->
                                <h3 class="mb-3">Fees for Selected User</h3>
                                <div class="overflow-auto">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Bill ID</th>
                                                <th>User Name</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Paid Date</th>
                                                <th>Transaction ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($fees_result) {
                                                while ($row = $fees_result->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['firstName']; ?></td>
                                                        <td><?php echo $row['amount']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <td><?php echo $row['paid_date'] ? $row['paid_date'] : 'N/A'; ?></td>
                                                        <td><?php echo $row['transaction_id'] ? $row['transaction_id'] : 'N/A'; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] != 'paid') { ?>
                                                                <form method="post">
                                                                    <input type="hidden" name="bill_id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="mark_paid" class="btn btn-success">Mark as Paid</button>
                                                                </form>
                                                            <?php } else { ?>
                                                                <span class="text-success">Paid</span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No records found</td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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