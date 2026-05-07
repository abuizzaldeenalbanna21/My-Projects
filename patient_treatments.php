
<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

$id = $_SESSION['id'] ?? '';
$userType = $_SESSION['user_type'] ?? '';
$name = $_SESSION['name'] ?? '';
// عند الضغط على زر الدفع
if (isset($_GET['pay']) && is_numeric($_GET['pay'])) {
    $appointment_id = $_GET['pay'];
    $db->insert('invoice_items', [
        'appointment_id' => $appointment_id,
        'invoice_id' => 1 // عيّن ID فاتورة مناسبة هنا حسب النظام لديك
    ]);
    header('Location: patient_treatments.php');
    exit;
}
$sq = "";
if(isset($id) and $userType != "doctor"){
    $sq = " and p.id=$id ";
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
WHERE ii.id IS NULL $sq 
ORDER BY pt.treatment_date DESC
";
$treatmentsList = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Patients Treatments</title>
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
                        <h1 class="mb-4">Patients Treatment</h1>
                    </div>

                    <?php if (!empty($_SESSION['message'])): ?>
                        <div class="alert alert-info"><?= htmlspecialchars($_SESSION['message']); ?></div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Patient Name</th>
                                            <th>Treatment Name</th>
                                            <th>Doctor Name</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $loo = 1; foreach ($treatmentsList as $pt): ?>
                                            <tr>
                                                <td><?= $loo; ?></td>
                                                <td><?= htmlspecialchars($pt['first_name']) . " " . htmlspecialchars($pt['last_name']); ?></td>
                                                <td><?= $pt['treatment_name'] ?></td>
                                                <td><?= $pt['doctor_name'] ?></td>
                                                <td><?= $pt['treatment_date'] ?></td>
                                            </tr>
                                        <?php $loo++;endforeach; ?>
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