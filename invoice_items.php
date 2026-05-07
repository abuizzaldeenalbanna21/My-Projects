<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_payment'])) {
    $patient_treatment_id = $_POST['patient_treatment_id'];
    $notes = $_POST['notes'] ?? null;

    // أولًا، جلب appointment_id من patient_treatments
    $stmt = $conn->prepare("SELECT appointment_id FROM patient_treatments WHERE id = ?");
    $stmt->execute([$patient_treatment_id]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($appointment) {
        $appointment_id = $appointment['appointment_id'];

        // إدخال دفعة في invoice_items
        $stmtInsert = $conn->prepare("INSERT INTO invoice_items (appointment_id, invoice_id) VALUES (?, ?)");
        $invoice_id = 1; // عدّل حسب نظامك
        $stmtInsert->execute([$appointment_id, $invoice_id]);

        // تحديث notes في patient_treatments
        $stmtUpdate = $conn->prepare("UPDATE patient_treatments SET notes = ? WHERE id = ?");
        $stmtUpdate->execute([$notes, $patient_treatment_id]);

        $_SESSION['message'] = "Added successfully";
    } else {
        $_SESSION['message'] = "Patient treatment record is not available.";
    }

    header('Location: invoice_items.php');
    exit;
}
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
$treatmentsListNotFoundInInvoiceItem = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$id = $_SESSION['id'] ?? '';
if (isset($id) && $userType != "doctor") {
    $sq = "AND p.id = " . intval($id); // تحقق من المريض فقط إذا لم يكن المستخدم طبيباً
} else {
    $sq = "";
}

$sql = "
    SELECT pt.id, pt.treatment_date, 
           p.first_name AS patient_first_name, p.last_name AS patient_last_name,
           t.name AS treatment_name,
           d.full_name AS doctor_name,
           t.price AS cost,
           a.date AS appointment_date, a.time AS appointment_time,
           pt.appointment_id, pt.notes
    FROM patient_treatments pt
    JOIN patients p ON pt.patient_id = p.id
    JOIN treatments t ON pt.treatment_id = t.id
    JOIN doctors d ON pt.doctor_id = d.id
    JOIN appointments a ON pt.appointment_id = a.id
    WHERE EXISTS (
        SELECT 1 FROM invoice_items ii WHERE ii.appointment_id = pt.appointment_id
    )
    $sq
    ORDER BY pt.treatment_date DESC
";

$treatmentsList = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patient Treatments</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
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
                        <h1 class="mb-4">Medical History</h1>
                    </div>


                    <?php if ($userType === 'doctor') { ?>
                    <form method="post">
                        <input type="hidden" name="add_payment" value="1">
                        <select name="patient_treatment_id" class="form-control mb-2" required>
                            <option value="" disabled selected>Choose the patient's treatment</option>
                            <?php foreach ($treatmentsListNotFoundInInvoiceItem as $pt): ?>
                                <option value="<?= $pt['id'] ?>">
                                    <?= htmlspecialchars($pt['first_name'] . ' ' . $pt['last_name']) ?>
                                    - <?= htmlspecialchars($pt['treatment_name']) ?>
                                    (<?= htmlspecialchars(date('Y-m-d', strtotime($pt['treatment_date']))) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <textarea type="text" name="notes" class="form-control mb-1" placeholder="Notes (optional)" ></textarea>
                        <br>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-sm btn-success">+ Addition</button>
                        </div>
                    </form>
                    <hr>
<?php } ?>
                    <?php if (!empty($_SESSION['message'])): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($_SESSION['message']); ?></div>
                        <?php unset($_SESSION['message']); ?>
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
            <table class="table table-bordered" id="dataTable">
                <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient Name</th>
                                            <th>Treatment Name</th>
                                            <th>Doctor Name</th>
                                            <th>Date</th>
                                            <th>Cost</th>
                                            <th>Notes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $loo = 1; foreach ($treatmentsList as $pt):  ?>
                                            <tr>
                                                <td><?= $loo; ?></td>
                                                <td><?= htmlspecialchars($pt['patient_first_name']) . " " . htmlspecialchars($pt['patient_last_name']); ?></td>
                                                <td><?= $pt['treatment_name'] ?></td>
                                                <td><?= $pt['doctor_name'] ?></td>
                                                <td><?= $pt['treatment_date'] ?></td>
                                                <td><?= $pt['cost']?></td>
                                                <td><?= $pt['notes'] ?></td>
                                                <td>
                                                    <a href="reports.php?appointment_id=<?= $pt['appointment_id'] ?>" class="btn btn-info btn-sm" ><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        <?php  $loo++;endforeach; ?>
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
</body>

</html>