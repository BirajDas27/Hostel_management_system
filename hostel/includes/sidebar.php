<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body,
        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
        }

        .ts-sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            position: fixed;
            height: 100%;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .ts-sidebar-menu {
            padding: 0;
        }

        .ts-sidebar-menu li {
            width: 100%;
        }

        .ts-sidebar-menu li a {
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: background 0.3s, padding-left 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .ts-sidebar-menu li a .fa {
            margin-right: 10px;
        }

        .ts-sidebar-menu li a:hover {
            background-color:rgb(87, 0, 87);
            padding-left: 30px;
        }

        .ts-sidebar-menu .ts-label {
            color: #ecf0f1;
            padding: 15px 20px;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-family: 'Poppins', sans-serif;
        }


        .ts-sidebar::-webkit-scrollbar {
            width: 8px;
        }

        .ts-sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .ts-sidebar::-webkit-scrollbar-thumb {
            background-color: #764ba2;
            border-radius: 10px;
        }
    </style>
</head>
<nav class="ts-sidebar">
    <ul class="ts-sidebar-menu">
        <li class="ts-label">Main</li>
        <?php if (isset($_SESSION['id'])) { ?>
            <li><a href="dashboard.php"><i class="fa fa-tachometer"></i>Dashboard</a></li>
            <li><a href="my-profile.php"><i class="fa fa-user"></i> My Profile</a></li>
            <li><a href="change-password.php"><i class="fa fa-key"></i>Change Password</a></li>
            <li><a href="room-details.php"><i class="fa fa-info-circle"></i>Room Details</a></li>
            <li><a href="view-notices.php"><i class="fa fa-bullhorn"></i>Notice Board</a></li>
            <li><a href="check-attendance.php"><i class="fa fa-check-square"></i>Check Attendance</a></li>
            <li><a href="user_billing.php"><i class="fa fa-credit-card"></i>Payment</a></li>
            <li><a href="staff.php"><i class="fa fa-users"></i>Staff</a></li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a></li>

        <?php } else { ?>
            <li><a href="registration.php"><i class="fa fa-files-o"></i> User Registration</a></li>
            <li><a href="index.php"><i class="fa fa-users"></i> User Login</a></li>
            <li><a href="admin"><i class="fa fa-user"></i> Admin Login</a></li>
        <?php } ?>
    </ul>
</nav>