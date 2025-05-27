
    <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dental Clinic</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index_admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php #if ($_SESSION['user_type'] == 'doctor') { ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- if user type -->
            <li class="nav-item ">
                <a class="nav-link" href="users.php" >
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span>
                </a>
            </li>
            <?php #} ?>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="treatment.php" >
                    <i class="fas fa-fw fa-notes-medical"></i>
                    <span>Treatment</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="appointment.php" >
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="medical_history.php" >
                    <i class="fas fa-fw fa-notes-medical"></i>
                    <span>Medical History</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
    
