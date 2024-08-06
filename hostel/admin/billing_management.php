<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Process marking a fee as paid
if (isset($_POST['mark_paid'])) {
    $bill_id = $_POST['bill_id'];

    // Update fee status to 'paid'
    $update = "UPDATE bills SET status = 'Paid', paid_date = NOW() WHERE id = ?";
    $stmt = $mysqli->prepare($update);
    $stmt->bind_param('i', $bill_id);
    $stmt->execute();

    echo "<script>alert('Fee marked as paid successfully!');</script>";
    header('Location: billing_management.php'); // Redirect to refresh the page after marking fee as paid
    exit;
}

// Generate empty payment columns for all users
if (isset($_POST['generate_payments'])) {
    $users_query = "SELECT regno FROM registration";
    $users_result = $mysqli->query($users_query);

    while ($user_row = $users_result->fetch_assoc()) {
        $regno = $user_row['regno'];
        $insert = "INSERT INTO bills (regno, amount, status, transaction_id) VALUES (?, '', 'Unpaid', '')";
        $stmt = $mysqli->prepare($insert);
        $stmt->bind_param('i', $regno);
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
                            <div class="panel-heading" style="background-color: rgb(87, 0, 87);border-color: rgb(87, 0, 87);color: white">Payment related</div>
                            <div class="panel-body">

                                <!-- Generate Payments Button -->
                                <form method="post" class="mb-4" style="display: flex; align-items: center; justify-content: center">
                                    <button type="submit" name="generate_payments" class="btn btn-warning">Generate Empty Payments for All Users</button>
                                </form>

                                <!-- Display All Fees -->
                                <h3 class="mb-3">All Fees</h3>
                                <!-- <div class="overflow-auto"> -->
                                    <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Bill id</th>
                                                <th>Reg No</th>
                                                <th>User Name</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Paid Date</th>
                                                <th>Transaction ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT b.id, b.regno, b.amount, b.status, b.paid_date, b.transaction_id, r.firstName 
                                                      FROM bills b 
                                                      JOIN registration r ON b.regno = r.regno 
                                                      ORDER BY b.paid_date DESC"; // Default order
                                            $fees_result = $mysqli->query($query);

                                            if ($fees_result && $fees_result->num_rows > 0) {
                                                while ($row = $fees_result->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td><?php echo $row['id'];?></td>
                                                        <td><?php echo $row['regno']; ?></td>
                                                        <td><?php echo $row['firstName']; ?></td>
                                                        <td><?php echo $row['amount']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <td><?php echo $row['paid_date'] ? $row['paid_date'] : 'N/A'; ?></td>
                                                        <td><?php echo $row['transaction_id'] ? $row['transaction_id'] : 'N/A'; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] != 'paid') { ?>
                                                                <form method="post" class="custom">
                                                                    <input type="hidden" name="bill_id" value="<?php echo $row['id']; ?>">
                                                                    <button type="submit" name="mark_paid" class="btn btn-success">Mark as Paid</button>
                                                                </form>
                                                            <?php } else { ?>
                                                                <span class="text-success" style="color: white">Paid</span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                            ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">No records found</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <!-- </div> -->

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
