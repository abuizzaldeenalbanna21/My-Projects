<?php
session_start();

// For demo: you might want to get the current date formatted like this
$date = date('l, j F Y'); // e.g., Saturday, 9 May 2020

// الحصول على تاريخ اليوم بصيغة متوافقة مع قاعدة البيانات
$today = date('Y-m-d');

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
$id = $_SESSION['id'] ?? '';

require_once "database.php";
$db = new Database($conn);
$patients = $db->select('patients');
$doctors = $db->select('doctors');



$sql = "
SELECT pt.id, pt.treatment_date, 
       p.first_name AS first_name, p.last_name AS last_name,
       t.name AS treatment_name,
       d.full_name AS doctor_name,
       a.date AS appointment_date, a.time AS appointment_time,
       pt.appointment_id, pt.notes
FROM patient_treatments pt
JOIN patients p ON pt.patient_id = p.id
JOIN treatments t ON pt.treatment_id = t.id
JOIN doctors d ON pt.doctor_id = d.id
JOIN appointments a ON pt.appointment_id = a.id
LEFT JOIN invoice_items ii ON pt.appointment_id = ii.appointment_id
WHERE ii.id IS NULL
ORDER BY pt.treatment_date DESC
";
$treatmentsList = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Placeholder for patient count today — you will replace this with a real query
$today = date('Y-m-d');
$sqlpatientCount = "SELECT COUNT(*) FROM appointments WHERE doctor_id = :doctor_id AND date = :today";

$stmtpatientCount = $conn->prepare($sqlpatientCount);
$stmtpatientCount->execute([
    'doctor_id' => $id,
    'today' => $today
]);
$patientCount = $stmtpatientCount->fetchColumn();



// Fetch appointments with JOINs to get related names
$sql = "SELECT a.id, p.first_name AS patient_first_name, p.last_name AS patient_last_name, a.day, a.date, a.time,
       d.full_name AS doctor_name, t.name AS treatment_name
FROM appointments a
JOIN patients p ON a.patient_id = p.id
JOIN doctors d ON a.doctor_id = d.id
JOIN treatments t ON a.treatment_id = t.id
LEFT JOIN patient_treatments pt ON a.id = pt.appointment_id
WHERE pt.id IS NULL
and a.date = :today
ORDER BY a.date DESC";

$stmt = $conn->prepare($sql);
$stmt->execute(['today' => $today]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

/////////////////////////////////
$sqlCount = "SELECT COUNT(*) FROM appointments a
JOIN patients p ON a.patient_id = p.id
JOIN doctors d ON a.doctor_id = d.id
JOIN treatments t ON a.treatment_id = t.id
LEFT JOIN patient_treatments pt ON a.id = pt.appointment_id
WHERE pt.id IS NULL AND a.date = :today";

$stmtCount = $conn->prepare($sqlCount);
$stmtCount->execute(['today' => $today]);
$appointmentCount = $stmtCount->fetchColumn();
////////////////////////////////////////////

/////////////////////////////////
$sqlCountTotal = "SELECT COUNT(*) FROM appointments";

$stmtCountTotal = $conn->prepare($sqlCountTotal);
$stmtCountTotal->execute();
$appointmentCountTotal = $stmtCountTotal->fetchColumn();
////////////////////////////////////////

$month = 6;
$year = 2025;

// تحديد أول وآخر يوم في الشهر
$start_date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-01";
$end_date = "$year-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . cal_days_in_month(CAL_GREGORIAN, $month, $year);

// استعلام يعتمد فقط على حقل `date`
$sql = "SELECT DAY(date) AS day, COUNT(*) AS count 
        FROM appointments 
        WHERE date BETWEEN :start_date AND :end_date
        GROUP BY DAY(date)
        ORDER BY DAY(date)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':end_date', $end_date);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// تحضير مصفوفة الأيام مع قيمة افتراضية 0
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$daysOfMonth = [];
for ($i = 1; $i <= $daysInMonth; $i++) {
    $daysOfMonth[$i] = 0;
}

// تعبئة الأيام التي تحتوي على مواعيد فقط
foreach ($results as $row) {
    $day = (int)$row['day'];
    $daysOfMonth[$day] = (int)$row['count'];
}

// تحويل البيانات إلى صيغ جاهزة لـ Chart.js
$labels = array_map(fn($d) => str_pad($d, 2, '0', STR_PAD_LEFT), array_keys($daysOfMonth));
$counts = array_values($daysOfMonth);



?>

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dental Clinic - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">


    <style>
        /* Ensure the sidebar is fixed and content scrolls underneath */
        #accordionSidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            overflow-y: auto;
            z-index: 1030;
        }

        #content-wrapper {
            margin-left: 250px;
            /* Adjust based on sidebar width */
        }

        @media (max-width: 768px) {
            #accordionSidebar {
                position: relative;
                height: auto;
            }

            #content-wrapper {
                margin-left: 0;
            }
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include 'navbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Good Morning Section -->
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="card shadow"
                                style="background-color: #4285f4; color: white; border-radius: 5px;">
                                <div class="card-body">
                                   <?php
                                    date_default_timezone_set('Asia/Riyadh'); // تأكد من ضبط المنطقة الزمنية حسب موقعك

                                    $hour = date('H'); // جلب الساعة بصيغة 24
                                    $greeting = ($hour < 12) ? 'Good Morning' : 'Good Afternoon';

                                    if ($userType === 'doctor') {
                                        echo "<h5>$date</h5>";
                                        echo "<h2>$greeting, Dr. $name</h2>";
                                        echo "<p>You Have <strong>$patientCount Patients</strong> Today</p>";
                                    } elseif ($userType === 'patient') {
                                        echo "<h5>$date</h5>";
                                        echo "<h2>$greeting, $name</h2>";
                                        echo "<p>Welcome to your patient dashboard.</p>";
                                    } else {
                                        echo "<h5>$date</h5>";
                                        echo "<h2>Welcome!</h2>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($userType === 'doctor') { ?>
                    <!-- Dental Clinic Statistics -->
                    <div class="row">
                        <!-- Number of Patients Registered -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Patients Registered</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($patients) ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Number of Employees -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Today's appointments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $appointmentCount; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patients Under Treatment -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Patients Under Treatment</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($treatmentsList) ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-procedures fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total appointments -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total appointments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $appointmentCountTotal; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <canvas id="dailyTreatmentsChart" height="60"></canvas>
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        const labels = <?= json_encode($labels) ?>;
                        const counts = <?= json_encode($counts) ?>;

                        const ctx = document.getElementById('dailyTreatmentsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Number of daily treatments',
                                    data: counts,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Number of cases'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'day of the month'
                                        }
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: context => `${context.parsed.y} Cases`
                                        }
                                    }
                                }
                            }
                        });
                    </script>

                    <?php }  ?>

                </div>
                <!-- /.container-fluid -->
                
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800 text-center">Appointments of Today</h1>
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
                    </tr>
                </thead>
                <tbody>
                    <?php $loo=1; foreach ($appointments as $app): ?>
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
                        </tr>
                    <?php $loo++; endforeach; ?>
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
</div>
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Developer By . Ali .Albanna 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
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
            return rows.filter(row => !row.hasAttribute('data-hidden'));
        }

        function updateTable() {
            const visibleRows = getVisibleRows();
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            rows.forEach(row => row.style.display = 'none');
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
            const visibleRows = getVisibleRows();
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage) || 1;
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            updateTable();
        });
    </script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>
    <script src="js/demo/chart-line-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Add Chart.js for Patients and Visits Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Patients Chart
        const patientsCtx = document.getElementById('patientsChart').getContext('2d');
        new Chart(patientsCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [
                    { label: 'New', data: [30, 35, 40, 45, 50], backgroundColor: '#4e73df' },
                    { label: 'Old', data: [20, 25, 30, 35, 40], backgroundColor: '#1cc88a' }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Visits Chart
        const visitsCtx = document.getElementById('visitsChart').getContext('2d');
        new Chart(visitsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [
                    { label: 'Appointment', data: [10, 15, 20, 25, 30], borderColor: '#4e73df', fill: false },
                    { label: 'Cancelled', data: [5, 10, 15, 20, 25], borderColor: '#e74a3b', fill: false }
                ]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    </script>

</body>

</html>