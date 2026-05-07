<?php 
// نحصل على اسم الملف الحالي
$currentPage = basename($_SERVER['PHP_SELF']);
?>
   <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index_admin.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Dental Clinic</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= $currentPage == 'index_admin.php' ? 'active' : '' ?>">
                <a class="nav-link" href="index_admin.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <?php if ($_SESSION['user_type'] == 'doctor') { ?>
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- if user type -->
            <li class="nav-item <?= $currentPage == 'users.php' || $currentPage == 'adduser.php' ? 'active' : '' ?>">
                <a class="nav-link" href="users.php" >
                    <i class="fas fa-fw fa-user"></i>
                    <span>Doctors</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <li class="nav-item <?= $currentPage == 'user.php' || $currentPage == 'info.php' ? 'active' : '' ?>">
                <a class="nav-link" href="user.php" >
                    <i class="fas fa-fw fa-users"></i>
                    <span>Patients</span>
                </a>
            </li>
            <?php } ?>


            <!-- Divider -->
             <hr class="sidebar-divider">
              <li class="nav-item <?= $currentPage == 'treatment.php' || $currentPage == 'treatment-add.php'? 'active' : '' ?>">
                <a class="nav-link" href="treatment.php" >
                    <i class="fas fa-fw fa-notes-medical"></i>
                    <span> Treatment</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <?php if ($_SESSION['user_type'] == 'doctor') { ?>
           
            

            <li class="nav-item <?= $currentPage == 'patient_treatments.php' ? 'active' : '' ?>">
                <a class="nav-link" href="patient_treatments.php" >
                    <i class="fas fa-fw fa-notes-medical"></i>
                    <span>Patient Treatment</span>
                </a>
            </li>
            <hr class="sidebar-divider">
            <?php }?>
            

            <li class="nav-item <?= $currentPage == 'appointment.php' || $currentPage == 'appointment-edit.php' || $currentPage == 'addAppointment.php' ? 'active' : '' ?>">
                <a class="nav-link" href="appointment.php" >
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">


            <li class="nav-item <?= $currentPage == 'invoice_items.php' || $currentPage == 'reports.php' ? 'active' : '' ?>">
                <a class="nav-link" href="invoice_items.php" >
                    <i class="fas fa-file-invoice"></i>
                    <span>Medical History</span>
                </a>
            </li>
            <hr class="sidebar-divider">

            <li class="nav-item <?= $currentPage == 'payment.php' ? 'active' : '' ?>">
                <a class="nav-link" href="payment.php">
                    <i class="fas fa-credit-card"></i>
                    <span>Payment</span>
                </a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            

        </ul>

