<?php
session_start();
require_once 'database.php'; // Your Database class file
require_once 'config.php';   // Your PDO connection setup

$db = new Database($conn);  // $conn is PDO connection from config.php

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';

// Insert appointment into patient_treatments
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_treatment'])) {
    $appointmentId = (int) $_POST['add_to_treatment'];

    // Fetch appointment details
    $stmt = $conn->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->execute([$appointmentId]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment) {
        $insert = $db->insert('patient_treatments', [
            'patient_id' => $appointment['patient_id'],
            'treatment_id' => $appointment['treatment_id'],
            'doctor_id' => $appointment['doctor_id'],
            'appointment_id' => $appointment['id'],
            'treatment_date' => date('Y-m-d H:i:s'),
            'notes' => ''
        ]);

        $_SESSION['message'] = $insert ? "Started patient processing." : "Failed to add.";
        $_SESSION['show_processing_alert'] = $insert ? true : false;
    } else {
        $_SESSION['message'] = "Appointment not found.";
    }

    header("Location: appointment.php");
    exit;
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int) $_POST['delete_id'];
    if ($db->delete('appointments', ['id' => $deleteId])) {
        $_SESSION['message'] = "Appointment deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete appointment.";
    }
    header("Location: appointment.php");
    exit;
}

// Fetch appointments with JOINs to get related names
$sql = "SELECT a.id, p.first_name AS patient_first_name, p.last_name AS patient_last_name, a.day, a.date, a.time,
       d.full_name AS doctor_name, t.name AS treatment_name
FROM appointments a
JOIN patients p ON a.patient_id = p.id
JOIN doctors d ON a.doctor_id = d.id
JOIN treatments t ON a.treatment_id = t.id
LEFT JOIN patient_treatments pt ON a.id = pt.appointment_id
WHERE pt.id IS NULL
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
    <div class="alert alert-info" id="processingAlert"><?= htmlspecialchars($_SESSION['message']); ?></div>
    <?php unset($_SESSION['message']); unset($_SESSION['show_processing_alert']); ?>
<?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                            <!-- Search & Show Entries Controls -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <label for="entriesSelect">Show
                                            <select id="entriesSelect"
                                                class="custom-select custom-select-sm form-control form-control-sm"
                                                style="width: auto;">
                                                <option value="2">2</option>
                                                <option value="5">5</option>
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select> entries
                                        </label>
                                    </div>
                                    <div>
                                        <label for="searchBox">Search:
                                            <input id="searchBox" type="text" class="form-control form-control-sm"
                                                style="width: auto; display: inline-block;">
                                        </label>
                                    </div>
                                </div>
                                <!-- End Controls -->
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <?php if ($userType === 'doctor') { ?>
                                                <th>Patient Name</th>
                                            <?php } ?>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Doctor</th>
                                            <th>Treatment</th>
                                            <?php if ($userType === 'doctor') { ?>
                                            <th>Actions</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $loo = 1; foreach ($appointments as $app): ?>
                                            <tr>
                                                <td><?= $loo; ?></td>
                                                <?php if ($userType === 'doctor') { ?>
                                                    <td><?= htmlspecialchars($app['patient_first_name']) . " " . htmlspecialchars($app['patient_last_name']); ?>
                                                    </td>
                                                <?php } ?>
                                                <td><?= htmlspecialchars($app['day']); ?></td>
                                                <td><?= htmlspecialchars($app['date']); ?></td>
                                                <td><?= htmlspecialchars($app['time']); ?></td>
                                                <td><?= htmlspecialchars($app['doctor_name']); ?></td>
                                                <td><?= htmlspecialchars($app['treatment_name']); ?></td>
                                                <?php if ($userType === 'doctor') { ?>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-between align-items-center" style="gap: 5px;">
                                                        <!-- حذف (يمين) -->
                                                        <form method="post" onsubmit="return confirm('Delete this appointment?');" style="display:inline;">
                                                            <input type="hidden" name="delete_id" value="<?= $app['id']; ?>">
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        <!-- تعديل (وسط) -->
                                                        <form action="appointment-edit.php" method="get" style="display:inline; margin: 0 auto;">
                                                            <input type="hidden" name="id" value="<?= $app['id']; ?>">
                                                            <button type="submit" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </form>
                                                        <!-- إضافة (يسار) -->
                                                        <form method="post" style="display:inline;">
                                                            <input type="hidden" name="add_to_treatment" value="<?= $app['id']; ?>">
                                                            <button type="submit" class="btn btn-primary btn-sm" title="Add to Treatment">
                                                                <i class="fas fa-plus-circle"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                        <?php $loo++;endforeach; ?>
                                    </tbody>
                                </table>
                                <!-- Pagination Controls -->
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button id="prevPage" class="btn btn-primary btn-sm">Previous</button>
                                    <span id="currentPage" class="mx-2">1</span>
                                    <button id="nextPage" class="btn btn-primary btn-sm">Next</button>
                                </div>
                            </div>
                            <!-- Pagination and other controls could go here -->
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
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script>
        // Search and Pagination logic
        const rows = Array.from(document.querySelectorAll('#dataTable tbody tr'));
        const entriesSelect = document.getElementById('entriesSelect');
        const prevPageButton = document.getElementById('prevPage');
        const nextPageButton = document.getElementById('nextPage');
        const currentPageDisplay = document.getElementById('currentPage');
        const searchBox = document.getElementById('searchBox');
        let currentPage = 1;
        let rowsPerPage = parseInt(entriesSelect.value);

        function getVisibleRows() {
            return rows.filter(row => row.style.display !== 'none' && row.style.display !== 'hidden');
        }

        function updateTable() {
            // Filtered rows after search
            const visibleRows = rows.filter(row => !row.hasAttribute('data-hidden'));
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            // Hide all rows first
            rows.forEach(row => row.style.display = 'none');
            // Show only the visible rows for the current page
            visibleRows.forEach((row, index) => {
                if (index >= (currentPage - 1) * rowsPerPage && index < currentPage * rowsPerPage) {
                    row.style.display = '';
                }
            });
            currentPageDisplay.textContent = totalPages === 0 ? 0 : currentPage;
            prevPageButton.disabled = (currentPage <= 1);
            nextPageButton.disabled = (currentPage >= totalPages);
        }

        searchBox.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        match = true;
                    }
                });
                if (match) {
                    row.removeAttribute('data-hidden');
                } else {
                    row.setAttribute('data-hidden', 'true');
                }
            });
            currentPage = 1;
            updateTable();
        });

        entriesSelect.addEventListener('change', function () {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            updateTable();
        });

        prevPageButton.addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        nextPageButton.addEventListener('click', function () {
            const visibleRows = rows.filter(row => !row.hasAttribute('data-hidden'));
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            updateTable();
            var alertBox = document.getElementById('processingAlert');
            if (alertBox) {
                setTimeout(function () {
                    alertBox.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>