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
    <title>Admin Fee Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .back-button {
            margin-bottom: 10px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .dropdown {
            float: left;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include('../includes/header.php'); ?>
    <div class="container mt-5">
        <h2 class="mb-4">Fee Management</h2>

        <button class="btn btn-primary back-button" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>

        <!-- Generate Payments Button -->
        <form method="post" class="mb-4">
            <button type="submit" name="generate_payments" class="btn btn-warning">Generate Empty Payments for All Users</button>
        </form>

        <!-- Search Student Form -->
        <h3 class="mb-3">Search Student</h3>
        <form method="post" class="mb-4">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Select User</option>
                    <?php while ($user_row = $user_result->fetch_assoc()) { ?>
                        <option value="<?php echo $user_row['id']; ?>" <?php echo $user_id == $user_row['id'] ? 'selected' : ''; ?>><?php echo $user_row['firstName']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" name="search_student" class="btn btn-success">Search</button>
        </form>

        <!-- Sorting Dropdown -->
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

        <!-- Display Fees for Selected User -->
        <h3 class="mb-3">Fees for Selected User</h3>
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
                <?php } } else { ?>
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
