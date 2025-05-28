<?php
session_start();
require_once 'database.php'; // Your Database class file
require_once 'config.php';   // Your PDO connection setup

$db = new Database($conn);  // $conn is PDO connection from config.php

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];
    if ($db->delete('appointments', ['id' => $deleteId])) {
        $_SESSION['message'] = "Appointment deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete appointment.";
    }
    header("Location: appointment.php");
    exit;
}

// Fetch appointments with JOINs to get related names
$sql = "SELECT a.id, p.first_name AS patient_name, a.day, a.date, a.time, d.full_name AS doctor_name, t.name AS treatment_name
        FROM appointments a
        JOIN patients p ON a.patient_id = p.id
        JOIN doctors d ON a.doctor_id = d.id
        JOIN treatments t ON a.treatment_id = t.id
        ORDER BY a.date DESC";

$appointments = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Dental Clinic - Appointments</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'navbar.php'; ?>
                <div class="container-fluid">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Appointments</h1>
                        <a href="addAppointment.php" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>

                    <?php if (!empty($_SESSION['message'])): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($_SESSION['message']); ?></div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient Name</th>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Doctor</th>
                                            <th>Treatment</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($appointments as $app): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($app['id']); ?></td>
                                                <td><?= htmlspecialchars($app['patient_name']); ?></td>
                                                <td><?= htmlspecialchars($app['day']); ?></td>
                                                <td><?= htmlspecialchars($app['date']); ?></td>
                                                <td><?= htmlspecialchars($app['time']); ?></td>
                                                <td><?= htmlspecialchars($app['doctor_name']); ?></td>
                                                <td><?= htmlspecialchars($app['treatment_name']); ?></td>
                                                <td>
                                                    <form method="post" onsubmit="return confirm('Delete this appointment?');" style="display:inline;">
                                                        <input type="hidden" name="delete_id" value="<?= $app['id']; ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <!-- You can add an edit button here if you want -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination and other controls could go here -->
                        </div>
                    </div>

                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; Developer By . Ali Albanna . 2025</span>
                            </div>
                        </div>
                    </footer>

                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>
