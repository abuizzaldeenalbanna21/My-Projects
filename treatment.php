<?php
session_start();
require_once 'config.php';
require_once 'database.php';

$db = new Database($conn);

// Fetch all treatments
$treatments = $db->select('treatments');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Treatments Management</title>
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
                        <h1 class="h3 text-gray-800">Treatments Management</h1>
                        <a href="treatment-add.php" class="btn btn-success btn-sm">
                            <i class="fas fa-plus"></i> Add Treatment
                        </a>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Price (JD)</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($treatments as $treatment): ?>
                                            <tr>
                                                <td><?= $treatment['id'] ?></td>
                                                <td><?= htmlspecialchars($treatment['name']) ?></td>
                                                <td><?= htmlspecialchars($treatment['description']) ?></td>
                                                <td><?= number_format($treatment['price'], 2) ?></td>
                                                <td>
                                                    <a href="treatment-delete.php?id=<?= $treatment['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this treatment?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($treatments)): ?>
                                            <tr><td colspan="5">No treatments found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <footer class="sticky-footer bg-white">
                            <div class="container my-auto">
                                <div class="text-center my-auto">
                                    <span>Copyright &copy; Developed by Ali Albanna 2025</span>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
