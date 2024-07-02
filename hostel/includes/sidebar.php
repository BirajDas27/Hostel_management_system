<nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">
        <li class="ts-label">Main</li>
        <?php if (isset($_SESSION['id'])) { ?>
            <li><a href="dashboard.php"><i class="fa fa-tachometer"></i>Dashboard</a></li>
            <li><a href="my-profile.php"><i class="fa fa-user"></i> My Profile</a></li>
            <li><a href="change-password.php"><i class="fa fa-key"></i>Change Password</a></li>
            <li><a href="book-hostel.php"><i class="fa fa-bed"></i>Book Hostel</a></li>
            <li><a href="room-details.php"><i class="fa fa-info-circle"></i>Room Details</a></li>
            <li><a href="access-log.php"><i class="fa fa-history"></i>Access Log</a></li>
            <li><a href="view-notices.php"><i class="fa fa-bullhorn"></i>Notice Board</a></li>
            <li><a href="check-attendance.php"><i class="fa fa-check-square"></i>Check Attendance</a></li>
            <li><a href="user_billing.php"><i class="fa fa-credit-card"></i>Payment</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>

        <?php } else { ?>
            <li><a href="registration.php"><i class="fa fa-files-o"></i> User Registration</a></li>
            <li><a href="index.php"><i class="fa fa-users"></i> User Login</a></li>
            <li><a href="admin"><i class="fa fa-user"></i> Admin Login</a></li>
        <?php } ?>
    </ul>
</nav>
