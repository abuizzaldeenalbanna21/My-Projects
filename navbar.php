<?php 
// error_reporting(0);

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

<!-- Sidebar Toggle (Topbar) -->
<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
<i class="fa fa-bars"></i>
</button>

<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

<!-- Nav Item - User Information -->
<li class="nav-item dropdown no-arrow">

    <a class="nav-link dropdown-toggle" href="profile.html" id="userDropdown" role="button"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $name ?? "" ?></span>
        <img class="img-profile rounded-circle"
            src=<?= !empty($_SESSION['profile_image']) ? 'uploads/' . htmlspecialchars($_SESSION['profile_image']) : 'img/undraw_profile.svg' ?>>
    </a>
    <!-- Dropdown - User Information -->
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
        aria-labelledby="userDropdown">
        <?php if($userType == "doctor"){?>

        <a class="dropdown-item" href="profile-doctor.php">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
        <?php }?>

        <?php if($userType != "doctor"){?>

        <a class="dropdown-item" href="profile.php">
            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
            Profile
        </a>
        <?php }?>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="logout.php">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
    </div>
</li>

</ul>

</nav>
<!-- End of Topbar -->