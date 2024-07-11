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
<body>
    <nav class="ts-sidebar">
        <ul class="ts-sidebar-menu">
            <li class="ts-label">Main</li>
            <li><a href="dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
            <li><a href="admin-profile.php"><i class="fa fa-user"></i> Admin Account</a></li>
            <li><a href="#"><i class="fa fa-book"></i> Courses</a>
                <ul>
                    <li><a href="add-courses.php">Add Courses</a></li>
                    <li><a href="manage-courses.php">Manage Courses</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-building"></i> Rooms</a>
                <ul>
                    <li><a href="create-room.php">Add a Room</a></li>
                    <li><a href="manage-rooms.php">Manage Rooms</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-bullhorn"></i> Notice Board</a>
                <ul>
                    <li><a href="add-notice.php">Add Notice</a></li>
                    <li><a href="manage-notices.php">Manage Notices</a></li>
                </ul>
            </li>
            <li><a href="new-registration.php"><i class="fa fa-user-plus"></i> Student Registration</a></li>
            <li class="menu-item-has-children">
                <a href="#"><i class="fa fa-users"></i> Manage Students</a>
                <ul class="sub-menu">
                    <li><a href="manage-students.php">Students</a></li>
                    <li><a href="student-roomdetail.php">Room Allotment</a></li>
                    <li><a href="attendance.php">Attendance</a></li>
                    <li><a href="billing_management.php">Bills</a></li>
                </ul>
            </li>
            <li><a href="access-log.php"><i class="fa fa-history"></i> User Access logs</a></li>
            <li><a href="#"><i class="fa fa-briefcase"></i> Employee</a>
                <ul>
                    <li><a href="add-employee.php">Add Employee</a></li>
                    <li><a href="list-employees.php">View Employees</a></li>
                    <li><a href="add-bonus.php">Add Bonus</a></li>
                    <li><a href="view-salaries.php">View Salary</a></li>
                </ul>
            </li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>

        </ul>
    </nav>
</body>