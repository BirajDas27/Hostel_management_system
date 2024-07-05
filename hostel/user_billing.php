<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$user_id = $_SESSION['id'];
$order_by = 'CASE WHEN status = "unpaid" THEN 1 ELSE 2 END, paid_date DESC'; // Default sorting order

// Handle sorting
if (isset($_POST['sort_option'])) {
    $sort_option = $_POST['sort_option'];
    if ($sort_option == 'recent') {
        $order_by = 'CASE WHEN status = "unpaid" THEN 1 ELSE 2 END, paid_date DESC';
    } elseif ($sort_option == 'old') {
        $order_by = 'CASE WHEN status = "unpaid" THEN 1 ELSE 2 END, paid_date ASC';
    } elseif ($sort_option == 'amount_asc') {
        $order_by = 'CASE WHEN status = "unpaid" THEN 1 ELSE 2 END, amount ASC';
    } elseif ($sort_option == 'amount_desc') {
        $order_by = 'CASE WHEN status = "unpaid" THEN 1 ELSE 2 END, amount DESC';
    }
}

// Fetch fees for the logged-in user
$query = "SELECT * FROM bills WHERE user_id = ? ORDER BY $order_by";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Process payment
if (isset($_POST['pay_fee'])) {
    $bill_id = $_POST['bill_id'];
    $amount = $_POST['amount'];
    $transaction_id = $_POST['transaction_id'];

    // Update fee status to 'pending' with transaction ID and selected amount
    $update = "UPDATE bills SET status = 'pending', paid_date = NOW(), transaction_id = ?, amount = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update);
    $stmt->bind_param('sii', $transaction_id, $amount, $bill_id);
    $stmt->execute();

    echo "<script>
        alert('The payment is pending. Inform Admin for confirmation!');
        window.location.href = 'user_billing.php';
    </script>";
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
    <title>User Fees</title>
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
                        <h2 class="page-title">Payments</h2>
                        <div class="panel panel-default">
                            <div class="panel-heading" style="background-color:#325D88;color: white">payment related</div>
                            <div class="panel-body">

                                <!-- Sorting Dropdown -->
                                <form method="post" class="mb-4">
                                    <div class="other">
                                        <div class="form-group">
                                            <label for="sort_option">Sort By:</label>
                                            <select name="sort_option" class="form-control" onchange="this.form.submit()">
                                                <option value="recent" <?php echo (isset($sort_option) && $sort_option == 'recent') ? 'selected' : ''; ?>>Recent Payments</option>
                                                <option value="old" <?php echo (isset($sort_option) && $sort_option == 'old') ? 'selected' : ''; ?>>Old Payments</option>
                                                <option value="amount_asc" <?php echo (isset($sort_option) && $sort_option == 'amount_asc') ? 'selected' : ''; ?>>Amount (Low to High)</option>
                                                <option value="amount_desc" <?php echo (isset($sort_option) && $sort_option == 'amount_desc') ? 'selected' : ''; ?>>Amount (High to Low)</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                                <h3 class="mb-3">All Payments</h3>
                                <div class="overflow-auto">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>Bill ID</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Paid Date</th>
                                                <th>Transaction ID</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($result) {
                                                while ($row = $result->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['amount']; ?></td>
                                                        <td><?php echo $row['status']; ?></td>
                                                        <td><?php echo $row['paid_date'] ? $row['paid_date'] : 'N/A'; ?></td>
                                                        <td><?php echo $row['transaction_id'] ? $row['transaction_id'] : 'N/A'; ?></td>
                                                        <td>
                                                            <?php if ($row['status'] == 'unpaid') { ?>
                                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#qrModal" onclick="setQRData(<?php echo $row['id']; ?>)">Pay Now</button>
                                                            <?php } elseif ($row['status'] == 'pending') { ?>
                                                                <span class="badge badge-warning">Pending</span>
                                                            <?php } else { ?>
                                                                <span class="badge badge-success" style="font-size: 16px;border-radius: 3px;font-weight: bold">Paid</span>
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

                                <!-- Modal for QR Code -->
                                <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="qrModalLabel">Scan to Pay</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <p>Please scan the QR code to complete the payment.</p>
                                                <img src="img/QR.png" class="qr-code" alt="QR Code" width="250px" height="250px"><br>
                                                <img src="img/upi-logo.png" class="type" alt="upi logo" style="border: 0px;padding: 5px 10px" width="250px" height="50px">
                                                <p style="font-weight: bold">Bill ID: <span id="billId"></span></p>

                                                <form method="post">
                                                    <input type="hidden" name="bill_id" id="modalBillId">
                                                    <div class="form-group">
                                                        <label for="duration">Select Duration:</label>
                                                        <select name="amount" id="duration" class="form-control" required>
                                                            <option value="8000">1 Month / Rs.8000</option>
                                                            <option value="24000">3 Months / Rs.24000</option>
                                                            <option value="48000">6 Months / Rs.48000</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="transaction_id">Transaction ID:</label>
                                                        <input type="text" class="form-control" name="transaction_id" id="transaction_id" required>
                                                    </div>
                                                    <button type="submit" name="pay_fee" class="btn btn-success">Submit</button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
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
    <script>
        function setQRData(billId) {
            document.getElementById('billId').textContent = billId;
            document.getElementById('modalBillId').value = billId;
        }
    </script>

</body>

</html>
