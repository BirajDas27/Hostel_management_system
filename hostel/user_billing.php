<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$user_id = $_SESSION['id'];
$order_by = 'paid_date DESC'; // Default sorting order

// Handle sorting
if (isset($_POST['sort_option'])) {
    $sort_option = $_POST['sort_option'];
    if ($sort_option == 'recent') {
        $order_by = 'paid_date DESC';
    } elseif ($sort_option == 'old') {
        $order_by = 'paid_date ASC';
    } elseif ($sort_option == 'amount_asc') {
        $order_by = 'amount ASC';
    } elseif ($sort_option == 'amount_desc') {
        $order_by = 'amount DESC';
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
    <title>User Fees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .qr-code {
            width: 150px;
            height: 150px;
        }
        .additional-img {
            width: 100px;  /* Small width */
            height: auto;  /* Maintain aspect ratio */
            display: block;
            margin: 10px auto;  /* Center the image */
        }
        .dropdown {
            float: left;
            margin-right: 10px;
        }
        /* Remove the top-right close button from the modal */
        .modal-header .close {
            display: none;
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <div class="container mt-5">
        <h2 class="mb-4">My Fees</h2>

        <!-- Sorting Dropdown -->
        <form method="post" class="mb-4">
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

        <h3 class="mb-3">All Fees</h3>
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
                <?php while ($row = $result->fetch_assoc()) { ?>
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
                                <span class="badge badge-success">Paid</span>
                            <?php } ?>
                        </td>
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
                    <h5 class="modal-title" id="qrModalLabel">Scan to Pay</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="img/QR.png" class="qr-code" alt="QR Code">
                    <img src="img/telegram_UPI.png" class="additional-img" alt="Additional Image">
                    <p>Bill ID: <span id="billId"></span></p>
                    <p>Please scan the QR code to complete the payment.</p>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setQRData(billId) {
            document.getElementById('billId').textContent = billId;
            document.getElementById('modalBillId').value = billId;
        }
    </script>
</body>
</html>
