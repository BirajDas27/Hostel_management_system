<head>
    <style>
        @media only screen and (min-width: 250px) and (max-width: 426px){
            body{
                z-index: 4;
            }
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
            <li><a href="registration.php"><i class="fa fa-user-plus"></i> Student Registration</a></li>
            <li class="menu-item-has-children">
                <a href="#"><i class="fa fa-users"></i> Manage Students</a>
                <ul class="sub-menu">
                    <li><a href="manage-students.php">Students</a></li>
                    <li><a href="attendance.php">Attendance</a></li>
                    <li><a href="billing_management.php">Bills</a></li>
                </ul>
            </li>
            <li><a href="access-log.php"><i class="fa fa-history"></i> User Access logs</a></li>
            <li><a href="#"><i class="fa fa-briefcase"></i> Employee Management</a>
                <ul>
                    <li><a href="add-employee.php">Add New</a></li>
                    <li><a href="list-employees.php">View List</a></li>
                    <li><a href="add-bonus.php">Add Bonus</a></li>
                    <li><a href="view-salaries.php">View Salary</a></li>
                </ul>
            </li>
            <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>

        </ul>
    </nav>
</body>