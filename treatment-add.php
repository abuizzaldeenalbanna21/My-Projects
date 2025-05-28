<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

// عند إرسال النموذج
$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_treatment'])) {
    $name = trim($_POST['treatment_name']);
    $description = trim($_POST['treatment_description']);
    $price = floatval($_POST['treatment_price']);

    // تحقق من أن الحقول ليست فارغة
    if (!empty($name) && !empty($description) && $price >= 0) {
        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ];
        $db->insert('treatments', $data);
        $successMessage = 'Treatment added successfully!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Treatment - Dental Clinic</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include 'navbar.php'; ?>

                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-gray-800">Add Treatment</h1>
                        <a href="treatment.php" class="btn btn-secondary btn-circle">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    </div>

                    <?php if (!empty($successMessage)): ?>
                        <div class="alert alert-success text-center"><?= $successMessage ?></div>
                    <?php endif; ?>

                    <div class="card shadow">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="treatmentName">Treatment Name</label>
                                    <input type="text" name="treatment_name" id="treatmentName" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="treatmentDescription">Treatment Description</label>
                                    <textarea name="treatment_description" id="treatmentDescription" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="treatmentPrice">Treatment Price</label>
                                    <input type="number" name="treatment_price" id="treatmentPrice" step="0.01" min="0" class="form-control" required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="save_treatment" class="btn btn-primary">Save Treatment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto text-center">
                        <span>Copyright &copy; Developer By Ali Albanna 2025</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
